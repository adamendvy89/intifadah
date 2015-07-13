<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/* Adam Endvy */
class MenuServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        $this->app['menu']->add('site-menu', 'mobile_chat', [
            'name' => 'Telp Messenger',
            'link' => 'http://chat.intifadah.net',
            'ajaxify' => true,
            'icon' => '<i class="icon ion-android-chat"></i>'
        ]);

        /*$this->app['menu']->add('site-menu', 'mobile_video_call', [
            'name' => 'Panggilan Video',
            'link' => \URL::to('mobile_video_chat'),
            'ajaxify' => true,
            'icon' => '<i class="icon ion-headphone"></i>'
        ]);*/

        $this->app['menu']->add('site-menu', 'mobile_online_meeting', [
            'name' => 'Rapat Online',
            'link' => \URL::to('mobile_online_meeting'),
            'ajaxify' => true,
            'icon' => '<i class="icon ion-android-forums"></i>'
        ]);

        if (true  and \Auth::check()) {
            $this->app['menu']->add('site-menu', 'pages', [
                'name' => trans('photo.photos'),
                'link' => \URL::to(\Auth::user()->username.'/photos'),
                'ajaxify' => true,
                'icon' => '<i class="icon ion-ios7-photos-outline"></i>'
            ]);
        }

        $this->app['menu']->add('site-menu', '#discover', [
            'name' => trans('discover.discover'),
            'link' => \URL::to('discover/post'),
            'ajaxify' => true,
            'icon' => '<i class="icon ion-ios7-lightbulb-outline"></i>'
        ]);

        $this->app['menu']->add('site-menu', '@mention', [
            'name' => trans('discover.@mention'),
            'link' => \URL::to('discover/mention'),
            'ajaxify' => true,
            'icon' => '<i class="icon ion-ios7-at-outline"></i>'
        ]);

        $this->app['menu']->add('site-menu', 'communities', [
            'name' => trans('community.communities'),
            'link' => \URL::to('communities'),
            'ajaxify' => true,
            'icon' => '<i class="icon ion-ios7-people-outline"></i>'
        ]);


        $this->app['menu']->add('site-menu', 'event', [
            'name' => trans('event.events'),
            'link' => \URL::to('events'),
            'ajaxify' => true,
            'icon' => '<i class="icon ion-document-text"></i>'
        ]);

        $this->app['menu']->add('site-menu', 'invite', [
            'name' => trans('user.invite'),
            'link' => \URL::to('invite'),
            'ajaxify' => true,
            'icon' => '<i class="icon ion-android-contacts"></i>'
        ]);

    }

}