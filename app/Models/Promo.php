<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use Uuid;

    protected $fillable = [
        'nama',
        'deskripsi',
        'image',
        'periode_awal',
        'periode_akhir',
    ];

    public function diskons()
    {
        return $this->hasMany(Diskon::class);
    }
}
