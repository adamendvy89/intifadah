<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* Adam Endvy */
class Report extends Model
{
    protected $table = "reports";

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}