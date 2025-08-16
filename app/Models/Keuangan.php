<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    use HasFactory;

    protected $table = 'keuangans';
    protected $fillable = [
        'kode_transaksi',
        'tipe',
        'kategori',
        'jumlah',
        'keterangan',
        'referensi',
        'tanggal',
        'user_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pemesanan()
    {
        return $this->belongsTo(PemesananBarang::class, 'referensi', 'nomor_surat_jalan');
    }

    public static function generateKodeTransaksi($tipe)
    {
        $prefix = match($tipe) {
            'pemasukan' => 'TRX-IN-',
            'pengeluaran' => 'TRX-OUT-',
            'pembayaran' => 'PAY-',
            default => 'TRX-'
        };

        $lastNumber = self::where('kode_transaksi', 'like', $prefix.'%')
            ->orderBy('kode_transaksi', 'desc')
            ->value('kode_transaksi');

        $nextNumber = $lastNumber ? (int)str_replace($prefix, '', $lastNumber) + 1 : 1;
        return $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}


