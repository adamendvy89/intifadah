<?php

namespace App\Controllers;
use App\Controllers\Base\UserBaseController;
use App\Interfaces\PhotoRepositoryInterface;
use App\Repositories\EventAdminRepository;
use App\Repositories\EventCategoryRepository;
use App\Repositories\EventRepository;
use App\Repositories\PostRepository;

/**
*
*@author: Adam Endvy
*@website : www.intifadah.com
*/
class EventController extends UserBaseController
{
    public function __construct(
        EventRepository $eventRepository,
        EventCategoryRepository $categoryRepository,
        PhotoRepositoryInterface $photoRepositoryInterface,
        PostRepository $postRepository,
        EventAdminRepository $adminRepository
    )
    {
        parent::__construct();
        $this->eventRepository = $eventRepository;
        $this->categoryRepository = $categoryRepository;
        $this->photo = $photoRepositoryInterface;
        $this->postRepository = $postRepository;
        $this->adminRepository = $adminRepository;
    }

    public function index()
    {
        return $this->preRender($this->theme->section('event.index', ['events' => $this->eventRepository->lists(\Input::get('category'))]), $this->setTitle(trans('event.events')));
    }

    public function mine()
    {
        return $this->preRender($this->theme->section('event.index', ['events' => $this->eventRepository->myLists()]), $this->setTitle(trans('event.my-events')));
    }

    public function create()
    {
        $message = null;
        if ($val = \Input::get('val')) {

            $validator = \Validator::make($val, [
                'title' => 'required|predefined|validalpha|min:3',
                'website' => 'url',
                'url' => 'required|predefined|validalpha|min:3|alpha_dash|slug|unique:events,slug'
            ]);

            if (!$validator->fails()) {
                $event = $this->eventRepository->create($val);

                if ($event) {
                    //redirect to community page
                    return \Redirect::to($event->present()->url());
                } else {
                    $message = trans('event.event-add-error');
                }
            } else {
                $message = $validator->messages()->first();
            }

        }

        return $this->preRender($this->theme->section('event.create', [
            'message' => $message,
            'categories' => $this->categoryRepository->listAll()
        ]), $this->setTitle(trans('evet.create-event')));
    }

    public function delete($id)
    {
        $this->eventRepository->delete($id);

        return \Redirect::route('events');
    }

    public function suggestAdmin()
    {
        $eventId = \Input::get('eventid');
        $term = \Input::get('term');

        $event = $this->eventRepository->get($eventId);

        $result = [
            'code' => 0,
            'message' => '<span style="margin: 10px">No results found</span>'
        ];

        if ($event) {
            $users = $this->eventRepository->suggestAdmin($term, $event);

            if (!empty($users)) {
                $result['code'] = 1;
                $result['content'] = (string) $this->theme->section('event.profile.suggest-admin', ['users' => $users]);
            }
        }

        echo json_encode($result);
    }

    public function addAdmin()
    {
        $eventId = \Input::get('val.eventid');
        $userId = \Input::get('val.userid');
        $type = \Input::get('val.type');
        $event = $this->eventRepository->get($eventId);

        $result = [
            'code' => 0,
            'message' => 'This user is already an admin'
        ];

        if ($event) {

            $admin = $this->adminRepository->add($eventId, $userId, $type);

            if ($admin) {
                $result['code'] = 1;
                $result['message'] = (String) $this->theme->section('event.profile.format-admin', ['admin' => $admin]);
            }
        }

        return json_encode($result);
    }

    public function updateAdmin()
    {
        $adminId = \Input::get('adminId');
        $type = \Input::get('type');

        $this->adminRepository->updateAdmin($adminId, $type);
    }

    public function removeAdmin()
    {
        $adminId = \Input::get('id');
        $this->adminRepository->removeAdmin($adminId);
    }

    public function changePhoto()
    {
        $id = \Input::get('id');
        $event = $this->eventRepository->get($id);

        $response = [
            'code' => 0,
            'message' => trans('event.change-photo-fail'),
            'url' => ''
        ];

        if (\Request::hasFile('image')) {

            if (!$this->photo->imagesMetSizes(\Input::file('image'))) return json_encode($response);

            $image = $this->eventRepository->changePhoto(\Input::file('image'), $event);
            if ($image) {
                $response['code'] = 1;
                $response['url'] = \Image::url($image, 100);
            }
        }

        return json_encode($response);
    }


    public function preRender($content, $title)
    {
        return $this->render('event.layout', ['content' => $content], ['title' => $title]);
    }

    public function uploadCover()
    {
        $failed = json_encode([
            'status' => 'error',
            'message' => trans('photo.error', ['size' => formatBytes()])
        ]);
        if (!\Input::hasFile('img')) return $failed;

        $file = \Input::file('img');

        if (!$this->photo->imagesMetSizes($file)) return $failed;

        list($width, $height) = getimagesize($file->getRealPath());

        $result = json_encode([
            'status' => 'error',
            'message' => 'Insufficient image width/Height, MinWidth : 200px and MinHeight :  100px'
        ]);
        if ($width < 200 or $height < 100) {
            return $result;
        }
        if ($width < 1000) {
            //let use direct upload like that
            $imageRepo = $this->photo->image;
            $image = $imageRepo->load($file)->setPath('temp/')->offCdn();
            $image = $image->resize(1000, 500, 'fill', 'up');;

            //if ($image->hasError()) return $result;

            $image = $image->result();
            $image = str_replace('%d', '1000', $image);
        }  else {
            $image = $this->photo->upload($file, [
                'path' => 'temp/',
                'width' => 1000,
                'fit' => 'inside',
                'scale' => 'down',
                'cdn' => false
            ]);

            if (!$image) return $result;
            $image = str_replace('_%d_', '_1000_', $image);
        }




        if ($image) {

            list($width, $height) = getimagesize(base_path().'/'.$image);
            return json_encode([
                'status' => 'success',
                'url' => \URL::to($image),

            ]);
        }

        return $result;


    }

    public function cropCover()
    {
        $top = \Input::get('imgY1');
        $left = \Input::get('imgX1');
        $cWidth = \Input::get('cropW');
        $cHeight = \Input::get('cropH');
        $file = \Input::get('imgUrl');
        $file = str_replace( [\URL::to(''), '//'],[ '', '/'], $file);
        $id = \Input::get('id');

        $image = $this->photo->cropImage(base_path('').$file, 'cover/', $left, $top, $cWidth, $cHeight, false);
        $image = str_replace('%d', 'original', $image->result());

        /**make sure to delete the original image***/
        $this->photo->delete($file);

        if (!empty($image)) {
            /**
             * Update user profile cover
             */
            $this->eventRepository->updateCover($id, $image);
            return json_encode([
                'status' => 'success',
                'url' => \Image::url($image),
            ]);
        } else {
            return json_encode([
                'status' => 'error',
                'message' => 'Error ',
            ]);
        }


    }

    public function loadMoreInvitee()
    {
        $offset = \Input::get('offset');
        $eventId = \Input::get('eventid');
        $event = $this->eventRepository->get($eventId);
        $limit = 5;
        $newOffset =(int) $offset  + (int) $limit;
        $result = [
            'offset' => $newOffset,
            'content' => ''
        ];

        if ($event) {
            $users = $this->eventRepository->friendsToLike($eventId, $limit, $newOffset);

            $content = '';
            foreach($users as $user) {
                $content .= $this->theme->section('event.profile.display-invite-user', ['user' => $user, 'event' => $event]);
            }
            $result['content'] = $content;
        }

        return json_encode($result);
    }

    public function searchInvitee()
    {
        $text = \Input::get('text');
        $eventId = \Input::get('eventid');
        $event = $this->eventRepository->get($eventId);

        if ($event) {
            $users = $this->eventRepository->friendsToLike($eventId, 10, 0, $text);

            $content = '';
            foreach($users as $user) {
                $content .= $this->theme->section('event.profile.display-invite-user', ['user' => $user, 'event' => $event]);
            }
            return $content;
        }

        return '';
    }
}