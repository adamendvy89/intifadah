<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* Adam Endvy */
class CommunityMember extends Model
{
    protected $table = "community_members";

    public function user()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id');
    }

    public function community()
    {
        return $this->belongsTo('App\\Models\\Community', 'community_id');
    }
}