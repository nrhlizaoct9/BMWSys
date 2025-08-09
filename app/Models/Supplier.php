<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\PemesananBarang;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';

    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
    ];

    public function pemesananBarangs(): HasMany
    {
        return $this->hasMany(PemesananBarang::class);
    }
}
