<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

/**
*
*@author: Adam Endvy
*@website : www.intifadah.com
*/
class Message extends Model
{
    use PresentableTrait;

    protected $table = "messages";

    protected $presenter = "App\\Presenters\\MessagePresenter";

    public function senderUser()
    {
        return $this->belongsTo('App\\Models\\User', 'sender');
    }

    public function receiverUser()
    {
        return $this->belongsTo('App\\Models\\User', 'receiver');
    }
}