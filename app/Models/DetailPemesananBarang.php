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
        'subtotal',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(PemesananBarang::class, 'pemesanan_barang_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }

    // Auto calculate subtotal
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->subtotal = $model->quantity * $model->harga_beli;
        });

        static::updating(function ($model) {
            $model->subtotal = $model->quantity * $model->harga_beli;
        });
    }
}
