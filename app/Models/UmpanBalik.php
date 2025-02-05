<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class UmpanBalik extends Model
{
    use Uuid;

    protected $fillable = ['user_id', 'pesan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
