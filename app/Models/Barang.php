<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'jenis_barang_id',
        'stok',
        'stok_min',
        'satuan',
        'harga_beli',
        'harga_jual'
    ];

    /**
     * Kolom yang harus disembunyikan dari array/JSON
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public static function generateKodeBarang($jenisBarangId)
    {
        $jenisBarang = JenisBarang::findOrFail($jenisBarangId);
        $prefix = strtoupper(substr($jenisBarang->nama_jenis, 0, 3)); // 3 huruf depan

        $lastBarang = self::where('kode_barang', 'like', $prefix.'-%')
            ->orderBy('kode_barang', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastBarang) {
            $lastNumber = (int) substr($lastBarang->kode_barang, -3);
            $nextNumber = $lastNumber + 1;
        }

        return $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function getHargaBeliFormattedAttribute()
    {
        if (is_null($this->harga_beli)) {
            return '-';
        }
        return 'Rp ' . number_format($this->harga_beli, 2, ',', '.');
    }

    public function getHargaJualFormattedAttribute()
    {
        if (is_null($this->harga_jual)) {
            return '-';
        }
        return 'Rp ' . number_format($this->harga_jual, 2, ',', '.');
    }

    public function isStokRendah()
    {
        return $this->stok <= $this->stok_min;
    }


    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class);
    }
}
