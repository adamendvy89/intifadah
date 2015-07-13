<?php

namespace App\Controllers;

use App\Controllers\Base\UserBaseController;
use App\Repositories\LikeRepository;

/* Adam Endvy */
class LikeController extends UserBaseController
{
    public function __construct(LikeRepository $likeRepository)
    {
        $this->likeRepository = $likeRepository;
        parent::__construct();
    }

    public function like($type, $id)
    {
        return $this->likeRepository->add($type, $id);
    }

    public function unlike($type, $id)
    {
        return $this->likeRepository->remove($type, $id);
    }

    public function showLikes($type, $id)
    {
        if (\Request::ajax()) {
            return $this->theme->section('likes.inline', ['likes' => $this->likeRepository->getLikes($type, $id)]);
        }
    }
}