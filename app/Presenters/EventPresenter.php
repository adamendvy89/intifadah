<?php

namespace App\Presenters;
use Laracasts\Presenter\Presenter;

/**
*
*@author: Adam Endvy
*@website : www.intifadah.com
*/
class EventPresenter extends Presenter
{
    public function url($segment = null)
    {
        $segment = (empty($segment)) ? '' : '/'.$segment;
        return \URL::route('event', ['slug' => $this->entity->slug]).$segment;
    }

    public function readDesign()
    {
        return $this->entity->user->present()->readDesign('event-'.$this->entity->id);
    }

    public function getAvatar($size = 100)
    {
        if (empty($this->entity->logo)) return \Theme::asset()->img('theme/images/event/logo.jpg');

        return \Image::url($this->entity->logo, $size);
    }

    public function joinedOn()
    {
        return str_replace(' ', 'T', $this->entity->created_at).'Z';
    }

    public function isAdmin($ignoreGlobalAdmin = false)
    {
        if (!\Auth::check()) return false;

        if (!$ignoreGlobalAdmin and  \Auth::user()->isAdmin()) return true;
        if ($this->entity->isOwner()) return true;

        $userid = \Auth::user()->id;
        $adminRepository = app('App\Repositories\EventAdminRepository');
        if ($adminRepository->isAdmin($this->entity->id, $userid)) return true;
        return false;
    }

    public function isModerator()
    {
        if (!\Auth::check()) return false;

        $userid = \Auth::user()->id;
        $adminRepository = app('App\Repositories\EventAdminRepository');
        if ($adminRepository->isModerator($this->entity->id, $userid)) return true;
        return false;
    }

    public function isEditor()
    {
        if (!\Auth::check()) return false;

        $userid = \Auth::user()->id;
        $adminRepository = app('App\Repositories\EventAdminRepository');
        if ($adminRepository->isEditor($this->entity->id, $userid)) return true;
        return false;
    }

    public function coverImage()
    {
        if (!empty($this->entity->cover)) {
            return \Image::url($this->entity->cover);
        }
    }

    public function field($id = null)
    {
        $details = (!empty($this->entity->info)) ? perfectUnserialize($this->entity->info) : [];

        if (empty($id)) return $details;

        if (isset($details[$id])) return $details[$id];

        return 'Nill';
    }

    public function fields()
    {
        return app('App\\Repositories\\CustomFieldRepository')->listAll('event');
    }

    public function likeStatus($userid)
    {
        $liked = app('App\\Repositories\\LikeRepository')->hasLiked('event', $this->entity->id, $userid);

        if ($liked) return 'liked';

        $invited = app('App\\Repositories\\InvitedMemberRepository')->isInvited('event', $this->entity->id, $userid);
        if ($invited) return 'invited';

        return false;
    }
}
 