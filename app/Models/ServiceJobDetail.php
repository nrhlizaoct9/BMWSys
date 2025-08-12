<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceJobDetail extends Model
{
    protected $fillable = [
        'service_id',
        'service_job_id',
        'jumlah_jam',
        'harga_satuan',
        'subtotal'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function serviceJob()
    {
        return $this->belongsTo(ServiceJob::class);
    }
}
