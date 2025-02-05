<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use Uuid;

    protected $fillable = ['user_id', 'barang_id', 'komentar'];
    public $with = ['barang', 'user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
