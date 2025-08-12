<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceJob extends Model
{
    protected $fillable = [
        'nama_pekerjaan',
        'estimasi_waktu',
        'tipe_harga',
        'harga_jual',
        'hpp_jasa',
        'deskripsi'
    ];

    public function detailJasa()
    {
        return $this->hasMany(ServiceJobDetail::class, 'service_job_id');
    }
}
