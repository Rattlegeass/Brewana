<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use Uuid;

    protected $table = 'pengirimans';
    protected $fillable = ['order_id', 'ongkir', 'status'];
    public $with = ['pembayarans'];

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
