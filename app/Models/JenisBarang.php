<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'jenis_barangs';

    /**
     * Kolom yang dapat diisi massal (mass assignable).
     *
     * @var array
     */
    protected $fillable = [
        'nama_jenis'
    ];

    /**
     * Kolom yang harus disembunyikan dari array dan JSON.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Relasi ke model Barang (jika diperlukan)
     */
    // public function barangs()
    // {
    //     return $this->hasMany(Barang::class, 'jenis_barang_id');
    // }
}
