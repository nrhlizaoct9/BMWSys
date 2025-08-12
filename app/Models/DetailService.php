<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailService extends Model
{
    protected $fillable = [
        'service_id',
        'barang_id',
        'jumlah',
        'harga_satuan',
        'subtotal'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
