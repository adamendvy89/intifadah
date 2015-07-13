<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

/**
*
*@author: Adam Endvy
*@website : www.intifadah.com
*/
class Event extends  Model
{
    use PresentableTrait;

    protected $table = "events";

    protected $presenter = "App\\Presenters\\EventPresenter";

    public function user()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id');
    }

    public function isOwner()
    {
        if (!\Auth::check()) return false;
        return (\Auth::user()->id == $this->user_id);
    }

    public function likes()
    {
        return $this->hasMany('App\\Models\\Like', 'type_id')->where('type', '=', 'event');
    }

    public function countLikes()
    {
        return count($this->likes);
        //return app('App\\Repositories\\LikeRepository')->count('event', $this->id);
    }

    public function friendsLiked()
    {
        return app('App\\Repositories\\LikeRepository')->friendsLike('event', $this->id, 12);
    }

    public function hasLiked()
    {
        if (!\Auth::check()) return false;

        return app('App\\Repositories\\LikeRepository')->hasLiked('event', $this->id, \Auth::user()->id);
    }

    public function category()
    {
        return $this->belongsTo('App\\Models\\PageCategory', 'category_id');
    }
}