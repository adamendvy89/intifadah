<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* Adam Endvy */
class Hashtag extends Model
{
    protected $table = "hashtags";

    public function url()
    {
         return \URL::to('search/hashtag?term='.ltrim(str_replace('#', '', $this->hash)));
    }
}