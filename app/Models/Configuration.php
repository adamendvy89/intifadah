<?php

namespace App\Models;

use Illuminate\Database\Eloquent;

/* Adam Endvy */
class Configuration extends Eloquent\Model
{
    protected $table = "configurations";

    public function findBySlug($slug)
    {
        return $this->where('slug', '=', $slug)->first();
    }
}