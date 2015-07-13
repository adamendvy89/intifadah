<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* Adam Endvy */
class BlockedUser extends Model
{
    protected $table = "blocked_users";

    public function user()
    {
        return $this->belongsTo('App\\Models\\User', 'block_id');
    }
}