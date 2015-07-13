<?php

namespace App\Controllers;

use App\Controllers\Base\ProfileBaseController;
use App\Interfaces\PhotoRepositoryInterface;
use App\Repositories\BlockedUserRepository;
use App\Repositories\PhotoRepository;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;

/* Adam Endvy */
class ProfileController extends ProfileBaseController
{
    public function __construct(
        PostRepository $postRepository,
        BlockedUserRepository $blockedUserRepository,
        PhotoRepositoryInterface $photoRepositoryInterface,
        UserRepository $userRepository
    )
    {
        parent::__construct();
        $this->postRepository = $postRepository;
        $this->blockUserRepository = $blockedUserRepository;
        $this->photo = $photoRepositoryInterface;
        $this->userRepository = $userRepository;

        //set neccessary meta data

        if ($this->profileUser) {
            $this->theme->share('site_description', ($this->profileUser and $this->profileUser->bio) ? $this->profileUser->bio : \Config::get('site_description'));
            $this->theme->share('ogSiteName', $this->profileUser->present()->fullName());
            $this->theme->share('ogUrl', $this->profileUser->present()->url());
            $this->theme->share('ogTitle', $this->profileUser->present()->fullName());
            $this->theme->share('ogImage', $this->profileUser->present()->getAvatar(150));
        }
    }
    public function index()
    {
        if (!$this->exists()) {
            return $this->profileNotFound();
        }

        if (\Auth::check() and $this->blockUserRepository->hasBlock(\Auth::user()->id, $this->profileUser->id)) {
            return \Redirect::route('user-home');
        }


        echo $this->render('profile.index', [],
            [
                'title' => $this->setTitle()
            ]
        );
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

        $path = $file->getRealPath();

        list($width, $height) = getimagesize($path);

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
        } else {
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

        $image = $this->photo->cropImage(base_path('').$file, 'cover/', $left, $top, $cWidth, $cHeight, false);
        $image = str_replace('%d', 'original', $image->result());

        /**make sure to delete the original image***/
        $this->photo->delete($file);

        if (!empty($image)) {
            /**
             * Update user profile cover
             */
            $this->userRepository->updateCover($image);
            return json_encode([
                'status' => 'success',
                'url' => \Image::url($image),
            ]);
        } else {
            return json_encode([
                'status' => 'error',
                'message' => 'Error things',
            ]);
        }


    }
}
