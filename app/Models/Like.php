<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* Adam Endvy */
class Like extends Model
{
    protected $table = "likes";

    public function user()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id');
    }
}