<?php

namespace App\Controllers\Base;

/* Adam Endvy */
class DiscoverBaseController extends UserBaseController
{
    public function render($path, $param = [], $setting = [])
    {
        return parent::render('discover.layout', [
            'content' => $this->theme->section($path, $param)
        ], $setting);
    }
}