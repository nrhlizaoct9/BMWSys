<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    use HasFactory;

    protected $table = 'jenis_barangs';

    protected $fillable = [
        'nama_jenis'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'jenis_barang_id');
    }
}
