<?php

namespace App\Repositories;
use App\Repositories\Models\EventAdmin;
use Illuminate\Cache\Repository;

/**
*
*@author: Adam Endvy
*@website : www.intifadah.com
*/
class EventAdminRepository
{
    public function __construct(EventAdmin $eventAdmin, Repository $cache, NotificationRepository $notificationRepository)
    {
        $this->model = $eventAdmin;
        $this->cache = $cache;
        $this->notification = $notificationRepository;
    }

    public function add($eventId, $userId, $type)
    {
        //if (!is_numeric($eventId) or !is_numeric($userId)) return false;

        if (!$this->exists($eventId, $userId)) {
            $admin = $this->model->newInstance();
            $admin->event_id = $eventId;
            $admin->user_id = $userId;
            $admin->type = $type;

            $admin->save();

            //lets send notification to this user about this great news
            $this->notification->send($userId, [
                'path' => 'notification.events.make-admin',
                'admin' => $admin,
            ]);

            //lets clear the cache base on the page admin role type
            if ($type == 1) {
                $this->cache->forget('event-admins-'.$eventId);
            } elseif ($type == 2) {
                $this->cache->forget('event-editors-'.$eventId);
            } else {
                $this->cache->forget('event-moderators-'.$eventId);
            }
            return $admin;
        }

        return false;
    }

    public function exists($eventId, $userId)
    {
        return $this->model->where('event_id', '=', $eventId)->where('user_id', '=', $userId)->first();
    }

    public function getList($eventId)
    {
        return $this->model->where('event_id', '=', $eventId)->get();
    }

    public function getUserListId($eventId)
    {
        return $this->model->where('event_id', '=', $eventId)->lists('event_id');
    }

    public function findById($id)
    {
        return $this->model->where('id', '=', $id)->first();
    }

    public function removeAdmin($adminId)
    {
        $admin = $this->findById($adminId);
        if ($admin) {
            $type = $admin->type;

            if ($type == 1) {
                $this->cache->forget('event-admins-'.$admin->event_id);
            } elseif ($type == 2) {
                $this->cache->forget('event-editors-'.$admin->event_id);
            } else {
                $this->cache->forget('event-moderators-'.$admin->event_id);
            }

            return $this->model->where('id', '=', $adminId)->delete();
        }

        return false;
    }
    public function updateAdmin($adminId, $type)
    {
        //lets clear the cache base on the page admin role type
        $admin = $this->findById($adminId);
        if ($type == 1) {
            $this->cache->forget('event-admins-'.$admin->event_id);
        } elseif ($type == 2) {
            $this->cache->forget('event-editors-'.$admin->event_id);
        } else {
            $this->cache->forget('event-moderators-'.$admin->event_id);
        }
        return $this->model->where('id', '=', $adminId)->update(['type' => $type]);
    }

    public function listAdmins($eventId)
    {
        $cacheName = 'event-admins-'.$eventId;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        } else {
            $get = $this->model->where('event_id', '=', $eventId)->where('type', '=', 1)->lists('user_id');

            if (empty($get)) return [];
            $this->cache->forever($cacheName, $get);
            return $get;
        }
    }

    public function listEditors($eventId)
    {
        $cacheName = 'event-editors-'.$eventId;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        } else {
            $get = $this->model->where('event_id', '=', $eventId)->where('type', '=', 2)->lists('user_id');

            if (empty($get)) return [];
            $this->cache->forever($cacheName, $get);
            return $get;
        }
    }

    public function listModerators($eventId)
    {
        $cacheName = 'event-moderators-'.$eventId;
        if ($this->cache->has($cacheName)) {
            return $this->cache->get($cacheName);
        } else {
            $get = $this->model->where('event_id', '=', $eventId)->where('type', '=', 3)->lists('user_id');

            if (empty($get)) return [];
            $this->cache->forever($cacheName, $get);
            return $get;
        }
    }

    public function isAdmin($eventId, $userid)
    {
        return (in_array($userid, $this->listAdmins($eventId)));
    }

    public function isModerator($eventId, $userid)
    {
        return (in_array($userid, $this->listModerators($eventId)));
    }

    public function isEditor($eventId, $userid)
    {
        return (in_array($userid, $this->listEditors($eventId)));
    }
}