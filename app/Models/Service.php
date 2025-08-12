<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DetailService;
use App\Models\ServiceJobDetail;

class Service extends Model
{
    protected $fillable = [
        'tanggal',
        'nama_pelanggan',
        'plat_nomor',
        'keterangan',
        'nomor_invoice',
        'total'
    ];

    // Barang yang dipakai
    public function detailBarang()
    {
        return $this->hasMany(DetailService::class, 'service_id');
    }

    // Jasa yang dikerjakan
    public function detailJasa()
    {
        return $this->hasMany(ServiceJobDetail::class, 'service_id');
    }
}
