<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use Uuid;

    protected $fillable = [
        'nama',
        'deskripsi',
        'stok',
        'harga',
        'kategori_id',
        'promo_id',
    ];
    public $with = ['kategori', 'barang_images', 'promo'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function barang_images()
    {
        return $this->hasMany(BarangImage::class);
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }
}
