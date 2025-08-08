<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'nama_barang',
        'jenis_barang_id',
        'stok',
        'satuan',
        'harga'
    ];

    /**
     * Kolom yang harus disembunyikan dari array/JSON
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function getHargaFormattedAttribute()
    {
        if (is_null($this->harga)) {
            return '-';
        }
        return 'Rp ' . number_format($this->harga, 2, ',', '.');
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
