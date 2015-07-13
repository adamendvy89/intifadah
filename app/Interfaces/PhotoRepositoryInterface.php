<?php

namespace App\Interfaces;

/* Adam Endvy */
interface PhotoRepositoryInterface
{
    public function upload($file, $settings = []);

    public function add($image, $userid, $slug);

    public function delete($path);
}