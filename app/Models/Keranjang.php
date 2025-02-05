<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use Uuid;

    protected $fillable = ['barang_id', 'user_id', 'kuantitas', 'total_harga'];
    public $with = ['barang.barang_images', 'barang.kategori', 'user'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
