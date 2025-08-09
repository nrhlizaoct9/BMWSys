<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PemesananBarang extends Model
{
    use HasFactory;

    protected $table = 'pemesanan_barangs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'supplier_id',
        'tanggal_datang',
        'nomor_surat_jalan',
        'status' => 'arrived',
    ];

    protected $dates = ['tanggal_datang'];

    protected $casts = [
        'tanggal_datang' => 'datetime:Y-m-d',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details()
    {
        return $this->hasMany(DetailPemesananBarang::class);
    }

    // Generate nomor invoice otomatis
    public static function generateInvoiceNumber(): string
    {
        $prefix = 'PO-' . date('Ymd') . '-';
        $lastOrder = self::where('nomor_invoice', 'like', $prefix . '%')
            ->orderBy('nomor_invoice', 'desc')
            ->first();

        $lastNumber = $lastOrder ? (int) str_replace($prefix, '', $lastOrder->nomor_invoice) : 0;
        return $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }

    // Hitung total quantity
    public function getTotalQuantityAttribute(): int
    {
        return $this->details->sum('quantity');
    }

    // Hitung total amount
    public function getTotalAmountAttribute(): float
    {
        return $this->details->sum('subtotal');
    }
}
