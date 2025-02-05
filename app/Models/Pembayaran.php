<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use Uuid;

    protected $fillable = ['order_id', 'barang_id', 'user_id', 'kuantitas', 'total_harga', 'status', 'pengiriman_id'];
    public $with = ['barang', 'user'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class);
    }
}
