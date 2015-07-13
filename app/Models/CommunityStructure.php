<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* Adam Endvy */
class CommunityStructure extends Model
{
    protected $table = "community_structure";

    public function community()
    {
        return $this->belongsTo('App\\Models\\Community', 'community_id');
    }
}
 