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
        'kategori_id',
        'harga',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function barang_images()
    {
        return $this->hasMany(BarangImage::class);
    }

    public function diskons()
    {
        return $this->hasMany(Diskon::class);
    }
}
