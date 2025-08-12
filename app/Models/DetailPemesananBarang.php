<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPemesananBarang extends Model
{
    use HasFactory;

    protected $table = 'detail_pemesanan_barangs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'pemesanan_barang_id',
        'barang_id',
        'quantity',
        'harga_beli',
        'diskon_nilai',
        'diskon_tipe',
        'ppn_nilai',
        'ppn_tipe',
        'subtotal',
    ];

    protected $casts = [
        'harga_beli' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'diskon_nilai' => 'decimal:2',
        'ppn_nilai' => 'decimal:2'
    ];

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(PemesananBarang::class, 'pemesanan_barang_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->hitungSubtotal();
        });

        static::updating(function ($model) {
            $model->hitungSubtotal();
        });
    }

    public function hitungSubtotal()
    {
        $subtotalAwal = $this->quantity * $this->harga_beli;

        $diskon = ($this->diskon_tipe == 'persen')
            ? $subtotalAwal * ($this->diskon_nilai / 100)
            : $this->diskon_nilai;

        $subtotalSetelahDiskon = $subtotalAwal - $diskon;

        $ppn = ($this->ppn_tipe == 'persen')
            ? $subtotalSetelahDiskon * ($this->ppn_nilai / 100)
            : $this->ppn_nilai;

        $this->subtotal = $subtotalSetelahDiskon + $ppn;
    }

    public function hitungDiskon(): float
    {
        if ($this->diskon_tipe == 'persen') {
            return ($this->quantity * $this->harga_beli) * ($this->diskon_nilai / 100);
        }
        return $this->diskon_nilai;
    }

    public function hitungPpn(): float
    {
        $subtotalSetelahDiskon = ($this->quantity * $this->harga_beli) - $this->hitungDiskon();

        if ($this->ppn_tipe == 'persen') {
            return $subtotalSetelahDiskon * ($this->ppn_nilai / 100);
        }
        return $this->ppn_nilai;
    }

    public function punyaDiskon(): bool
    {
        return $this->diskon_nilai > 0;
    }

    public function punyaPpn(): bool
    {
        return $this->ppn_nilai > 0;
    }
}
