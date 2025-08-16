<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CicilanPembayaran extends Model
{
    use HasFactory;

    protected $table = 'cicilan_pembayarans';
    protected $fillable = [
        'pemesanan_id',
        'jumlah',
        'tanggal_bayar',
        'metode_bayar',
        'catatan',
        'user_id'
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'jumlah' => 'decimal:2'
    ];

    public function pemesanan()
    {
        return $this->belongsTo(PemesananBarang::class, 'pemesanan_barang_id'); // Sesuaikan dengan nama kolom
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
