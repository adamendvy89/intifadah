<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

/* Adam Endvy */
class ConnectionPresenter extends Presenter
{
    public function getFriend($userid)
    {
        if ($this->entity->user_id == $userid) {
            return $this->entity->toUser;
        } else {
            return $this->entity->fromUser;
        }
    }
}