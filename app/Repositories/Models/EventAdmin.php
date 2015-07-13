<?php

namespace App\Repositories\Models;
use Illuminate\Database\Eloquent\Model;

/**
*
*@author: Adam Endvy
*@website : www.intifadah.com
*/
class EventAdmin extends Model
{
    protected $table = "event_admins";

    public function user()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id');
    }

    public function event()
    {
        return $this->belongsTo('App\\Models\\Event', 'event_id');
    }
}
 