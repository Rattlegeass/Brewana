<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class BarangImage extends Model
{
    use Uuid;

    protected $fillable = ['image', 'barang_id'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
