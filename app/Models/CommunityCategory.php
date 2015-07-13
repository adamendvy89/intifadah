<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* Adam Endvy */
class CommunityCategory extends Model
{
    protected $table = "community_categories";

    public function community()
    {
        return $this->belongsTo('App\\Models\\Community', 'community_id');
    }
}
 