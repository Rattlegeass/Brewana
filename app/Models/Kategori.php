<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use Uuid;

    protected $fillable = ['nama'];
}
