<?php

namespace App\Controllers;
use App\Controllers\Base\EventBaseController;
use App\Repositories\CustomFieldRepository;
use App\Repositories\EventAdminRepository;
use App\Repositories\EventCategoryRepository;
use App\Repositories\PhotoRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;

/**
*
*@author: Adam Endvy
*@website : www.intifadah.com
*/
class EventProfileController extends EventBaseController
{
    public function __construct(
        CustomFieldRepository $customFieldRepository,
        EventCategoryRepository $categoryRepository,
        PostRepository $postRepository,
        UserRepository $userRepository,
        EventAdminRepository $adminRepository,
        PhotoRepository $photoRepository,
        PostRepository $postRepository
    )
    {
        parent::__construct();
        $this->customFiedRepository = $customFieldRepository;
        $this->categoryRepository = $categoryRepository;
        $this->postRepository = $postRepository;
        $this->userRepository = $userRepository;
        $this->adminRepository = $adminRepository;
        $this->photoRepository = $photoRepository;
        $this->postRepository = $postRepository;

        if ($this->event) {
            $this->theme->share('site_description', $this->event->description);
            $this->theme->share('ogSiteName', $this->event->title);
            $this->theme->share('ogUrl', $this->event->present()->url());
            $this->theme->share('ogTitle', $this->event->title);
            $this->theme->share('ogImage', $this->event->present()->getAvatar(150));
        }
    }

    public function index()
    {
        if(!$this->exists()) {
            return $this->notFound();
        }

        return $this->render('event.profile.index', []);
    }

    public function photos()
    {
        if(!$this->exists()) {
            return $this->notFound();
        }

        $current = \Input::get('type', 'posts');

        $this->theme->share('singleColumn', 'true');

        return $this->render('event.profile.photos', [
            'current' => $current,
            'photos' => $this->photoRepository->listPages($this->event->id, $current)]);
    }

    public function addPhotos()
    {

        if (\Input::hasFile('image')) {

            $images = \Input::file('image');

            if (!$this->photoRepository->imagesMetSizes($images)) return 0; //confirm if one of the size is more than admin set value

            $event = $this->eventRepository->get(\Input::get('val.id'));

            $param = [
                'path' => 'events/'.$event->id.'/posts',
                'slug' => 'photos',
                'userid' => $event->user->id,
                'event_id' => $event->id,
                'privacy' => 5
            ];

            $photos = [];
            $paths = [];
            foreach($images as $im) {
                $i = $this->photoRepository->upload($im, $param);
                $paths[] = $i;
                $photos[] = $this->photoRepository->getByLink($i);
            }

            //help this event to post to its timeline
            $this->postRepository->add([
                'type' => 'event',
                'content_type' => 'image',
                'type_content' => $paths,
                'event_id' => $event->id,
                'privacy' => 1,
            ]);


            $content = "";
            foreach($photos as $photo) {
                if ($photo) {
                    $content .= (String) $this->theme->section('photo.display-photo', ['photo' => $photo]);
                }
            }

            return $content;
        }

        return '0';
    }

    public function edit()
    {
        if(!$this->exists()) {
            return $this->notFound();
        }

        if (!$this->event->present()->isAdmin() and !$this->event->present()->isEditor()) return \Redirect::to($this->event->present()->url());

        $message = null;

        if ($val = \Input::get('val')) {

            $validator = \Validator::make($val, [
                'title' => 'required',
            ]);

            if (!$validator->fails()) {
                $save = $this->eventRepository->save($val, $this->event);
                if($save) {
                    $message = trans('event.success');
                } else {
                    $message = trans('event.save-error');
                }
            } else {
                $message = $validator->messages()->first();
            }
        }

        return $this->render('event.profile.edit', [
            'message' => $message,
            'fields' => $this->customFiedRepository->listAll('event'),
            'categories' => $this->categoryRepository->listAll()
        ]);
    }

    public function manageAdmins()
    {
        if(!$this->exists()) {
            return $this->notFound();
        }

        if (!$this->event->present()->isAdmin()) return \Redirect::to($this->event->present()->url());

        return $this->render('event.profile.admins', [
            'admins' => $this->adminRepository->getList($this->event->id)
        ]);
    }

    public function design()
    {
        if(!$this->exists() or !\Config::get('event-design')) {
            return $this->notFound();
        }

        if (!$this->event->present()->isAdmin() and !$this->event->present()->isEditor()) return \Redirect::to($this->event->present()->url());

        $message = null;
        if ($val = \Input::get('val')) {
            $this->userRepository->saveDesign($val);
            $message = 'Design saved';
        }

        return $this->render('event.profile.design', [
            'message' => $message,

        ]);
    }
}