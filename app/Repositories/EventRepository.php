<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Events\Dispatcher;

/**
*
*@author: Adam Endvy
*@website : www.intifadah.com
*/
class EventRepository
{
    public function __construct(Event $eventM,
                                PhotoRepository $photoRepository,
                                LikeRepository $likeRepository,
                                MustAvoidUserRepository $mustAvoidUserRepository,
                                Dispatcher $event
    )
    {
        $this->model = $eventM;
        $this->photoRepository = $photoRepository;
        $this->likeRepository = $likeRepository;
        $this->mustAvoidUserRepository = $mustAvoidUserRepository;
        $this->event = $event;
    }

    /**
     * Create event
     *
     * @param array $val
     * @return \App\Models\Event
     */
    public function create($val)
    {
        $expected = [
            'title',
            'description',
            'website',
            'url' => '',
            'category'
        ];

        /**
         * @var $title
         * @var $description
         * @var $website
         * @var $category
         * @var $url
         */
        extract(array_merge($expected, $val));


        if (!empty($title) and !empty($category)) {
            $event = $this->model->newInstance();
            $event->title = sanitizeText($title, 130);
            $event->slug = sanitizeText($url);
            $event->user_id = \Auth::user()->id;
            $event->description = \Hook::fire('filter-text', sanitizeText($description));
            $event->category_id = sanitizeText($category);
            $event->website = sanitizeText($website);
            $event->save();

            $event->save();

            $this->event->fire('event.add', [$event]);
            return $event;
        }

        return false;
    }

    /**
     * @param $val
     * @param $event
     * @return bool
     */
    public function save($val, $event)
    {
        $expected = [
            'title',
            'description',
            'website',
            'category',
            'url' => '',
            'title' => '',
            'info' => []
        ];

        /**
         * @var $title
         * @var $description
         * @var $website
         * @var $category
         * @var $info
         * @var $url
         */
        extract(array_merge($expected, $val));

        $event->description = sanitizeText($description);
        $event->website = sanitizeText($website);
        $event->title = sanitizeText($title, 130);
        $event->category_id = sanitizeText($category);
        $event->info = serialize($info);
        $event->save();

        return true;
    }

    public function adminEdit($val, $event)
    {
        $expected = [
            'description' => '',
            'verified' => 0
        ];

        /**
         * @var $description
         * @var $verified
         */
        extract(array_merge($expected, $val));

        $event->description = $description;
        $event->verified = $verified;
        $event->save();

        return true;
    }

    public function exists($title)
    {
        return $this->model->where('title', '=', $title)->first();
    }

    public function get($id)
    {
        return $this->model->with('likes')
            ->where('title', '=', $id)
            ->whereNotIn('user_id', $this->mustAvoidUserRepository->get())
            ->orWhere('slug', '=', $id)->orWhere('id', '=', $id)->first();
    }

    public function changePhoto($image, $event)
    {
        $user = (empty($user)) ? \Auth::user() : $user;
        $image = $this->photoRepository->upload($image, [
            'path' => 'users/'.$user->id,
            'slug' => 'page-'.$event->id,
            'userid' => $user->id
        ]);

        /**
         * Now save user avatar
         */
        $event->logo = $image;
        $event->save();

        return $image;
    }

    public function updateCover($id, $image)
    {
        return $this->model->where('id', '=', $id)->update(['cover' => sanitizeText($image)]);
    }

    public function search($term, $limit = 10)
    {
        return $this->model->with('likes')
            ->where('title', 'LIKE', '%'.$term.'%')
            ->whereNotIn('user_id', $this->mustAvoidUserRepository->get())
            ->orWhere('description', 'LIKE', '%'.$term.'%')->paginate($limit);
    }

    public function suggest($limit = 3)
    {
        $userid = \Auth::user()->id;
        $likes = $this->likeRepository->getLikesId('event', $userid);
        /**$connectionRepository = app('App\Repositories\\ConnectionRepository');
        $friendsId = $connectionRepository->getAllFriendConnectionIds($userid);

        $friendsLiked = ['00'];

        foreach($friendsId as $uid) {
            $fLikes = $this->likeRepository->getLikesId('page', $uid);

            if (is_array($fLikes)) $friendsLiked = array_merge($friendsLiked, $fLikes);
        }
        ->where(function($query) use($friendsLiked) {
        $query->whereIn('id', $friendsLiked)
        ->orWhere('id', '!=', '');
        })
         **/

        $query = $this->model->with('likes')
            ->whereNotIn('user_id', $this->mustAvoidUserRepository->get())

            ->whereNotIn('id', $likes)
            ->where('user_id', '!=', \Auth::user()->id)
            ->orderBy(\DB::raw('rand()'));

        if (\Config::get('enable-query-cache')) {
            return $query = $query->remember(\Config::get('query-cache-time-out', 5), 'event-suggestions-'.\Auth::user()->id)->take($limit)->get();
        } else {
            return $query = $query->paginate($limit);
        }

    }

    public function suggestAdmin($term, $event)
    {
        $userRepository = app('App\Repositories\UserRepository');

        $userIds = ['none'];
        //people who like this event
        $likesId = $this->likeRepository->getIds('event', $event->id);
        $userIds = array_merge($userIds, $likesId);

        //also friends only
        $friendsId = app('App\Repositories\ConnectionRepository')->getFriendsId();
        $userIds = array_merge($userIds, $friendsId);

        return $userRepository->searchByIds($term, $userIds);
    }

    public function friendsToLike($eventId, $limit = 5, $offset = 0, $term = '')
    {

        $userRepository = app('App\Repositories\UserRepository');
        $userIds = ['none'];
        //people who like this event
        $likesId = $this->likeRepository->getIds('event', $eventId);
        $userIds = array_merge($userIds, $likesId);

        //also friends only
        $friendsId = app('App\Repositories\ConnectionRepository')->getFriendsId();
        $friendsId[] = 0;

        return $userRepository->listByIds($friendsId, [0], $limit, $offset, $term);
    }

    public function lists($category = null, $limit = 10, $term = null)
    {
        $query =  $this->model->orderBy('id', 'desc')
            ->whereNotIn('user_id', $this->mustAvoidUserRepository->get());

        if(!empty($category)) {
            $query = $query->where('category_id', '=', $category);
        }

        if ($term) {
            $query = $query->where('title', 'LIKE', '%'.$term.'%');
        }

        return $query = $query->paginate($limit);
    }

    public function myLists($limit = 10)
    {
        return $this->model->with('likes')->where('user_id', '=', \Auth::user()->id)->orderBy('id', 'desc')->paginate($limit);
    }

    public function myListsId()
    {
        return $this->model->with('likes')->where('user_id', '=', \Auth::user()->id)->lists('id');
    }

    public function delete($id)
    {
        $event = $this->get($id);


        if ($event) {

            if ($event->user_id != \Auth::user()->id) {
                if (!\Auth::user()->isAdmin()) return false;
            }

            $event->delete();

            foreach([
                        'App\\Repositories\\PostRepository',
                        'App\\Repositories\\LikeRepository',
                        'App\\Repositories\\PhotoRepository',
                    ] as $object) {
                app($object)->deleteAllByEvent($id);
            }
        }

    }

    public function deleteAllByUser($userid)
    {
        return $this->model->where('user_id', '=', $userid)->delete();
    }

    public function total()
    {
        return $this->model->count();
    }

}