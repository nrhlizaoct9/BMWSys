<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PemesananBarang extends Model
{
    use HasFactory;

    protected $table = 'pemesanan_barangs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'supplier_id',
        'tanggal_datang',
        'nomor_surat_jalan',
        'status',
        'diskon_global_nilai',
        'diskon_global_tipe',
        'ppn_global_nilai',
        'ppn_global_tipe',
        'subtotal',
        'total_diskon',
        'total_ppn',
        'total_akhir'
    ];

    protected $attributes = [
        'status' => 'arrived',
        'diskon_global_nilai' => 0,
        'ppn_global_nilai' => 0,
        'subtotal' => 0,
        'total_diskon' => 0,
        'total_ppn' => 0,
        'total_akhir' => 0
    ];

    protected $dates = ['tanggal_datang'];

    protected $casts = [
        'tanggal_datang' => 'datetime:Y-m-d',
        'diskon_global_nilai' => 'decimal:2',
        'ppn_global_nilai' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total_diskon' => 'decimal:2',
        'total_ppn' => 'decimal:2',
        'total_akhir' => 'decimal:2'
    ];

    protected $appends = [
        'total_items',
        'formatted_total_akhir'
    ];

    /* RELASI */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details()
    {
    return $this->hasMany(DetailPemesananBarang::class, 'pemesanan_barang_id');
    }

    /* ACCESSORS */
    public function getTotalItemsAttribute(): int
    {
        return $this->details->sum('quantity');
    }

    public function getTotalAkhirAttribute(): float
    {
        return ($this->subtotal - $this->total_diskon) + $this->total_ppn;
    }

    protected function formattedTotalAkhir(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->total_akhir ?? 0, 0, ',', '.')
        );
    }

    public function getFormattedTanggalDatangAttribute(): string
    {
        return $this->tanggal_datang?->format('d/m/Y');
    }

    /* METHOD BISNIS */
    public static function generateNomorSuratJalan(): string
    {
        $prefix = 'SJ-' . date('Ymd') . '-';
        $lastNumber = self::where('nomor_surat_jalan', 'like', $prefix . '%')
            ->orderBy('nomor_surat_jalan', 'desc')
            ->value(DB::raw("SUBSTRING(nomor_surat_jalan, LENGTH('$prefix') + 1)"));

        $nextNumber = (int)$lastNumber + 1;
        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function hitungUlangTotal(): void
    {
        $this->load('details');

        // Hitung ulang subtotal dari detail
        $this->subtotal = $this->details->sum(function($detail) {
            return ($detail->quantity * $detail->harga_beli);
        });

        // Hitung ulang diskon global
        $this->total_diskon = ($this->diskon_global_tipe === 'persen')
            ? $this->subtotal * ($this->diskon_global_nilai / 100)
            : $this->diskon_global_nilai;

        // Hitung ulang ppn global
        $subtotalSetelahDiskon = $this->subtotal - $this->total_diskon;
        $this->total_ppn = ($this->ppn_global_tipe === 'persen')
            ? $subtotalSetelahDiskon * ($this->ppn_global_nilai / 100)
            : $this->ppn_global_nilai;

        // Hitung total akhir
        $this->total_akhir = $subtotalSetelahDiskon + $this->total_ppn;

        $this->save();
    }

    /* SCOPES */
    public function scopeFilterByTanggal($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_datang', [$startDate, $endDate]);
    }

    public function scopeWithTotalLebihBesarDari($query, $minimalTotal)
    {
        return $query->where('total_akhir', '>', $minimalTotal);
    }
}
