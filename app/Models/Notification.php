<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

/* Adam Endvy */
class Notification extends Model
{
    use PresentableTrait;

    protected $table = 'notifications';

    protected $presenter = "App\\Presenters\\NotificationPresenter";

    public function user()
    {
        return $this->belongsTo('App\\Models\\User', 'user_id');
    }

    public function markSeen()
    {
        $this->seen = 1;
        $this->save();
    }
}
 