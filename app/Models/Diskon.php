<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use Uuid;

    protected $fillable = [
        'promo_id',
        'barang_id',
        'potongan_harga',
    ];

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
