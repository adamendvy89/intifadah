<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', ['uses' => 'App\Controllers\HomeController@index']);

Route::get('/xcrud_ajax', ['uses' => 'App\Controllers\XcrudAjax@index']);

Route::post('/xcrud_ajax', ['uses' => 'App\Controllers\XcrudAjax@index']);


Route::any('mobile_chat', [
    'as' => 'mobile.chat',
    'uses' => 'App\\Controllers\\MobileChatController@index'
]);

Route::any('mobile_video_call', [
    'as' => 'mobile.video.call',
    'uses' => 'App\\Controllers\\MobileVideoCallController@index'
]);

Route::any('mobile_online_meeting', [
    'as' => 'mobile.online.meeting',
    'uses' => 'App\\Controllers\\MobileOnlineMeetingController@index'
]);

Route::any('mobile_online_meeting/{slug}', [
    'uses' => 'App\\Controllers\\MobileOnlineMeetingController@show',
    'as' => 'mobile.online.meeting.show',
])->where('slug', '[a-zA-Z0-9\-\_]+');




Route::get('logout', ['as' => 'user-logout', 'uses' => function() {
        if (\Auth::check()) {
            $user = \Auth::user();
            $user->last_active_time = time() - 3600;
            $repository = app('App\\Repositories\\UserRepository');
            $repository->savePrivacy(['self-online' =>  0]);
            //$user->updateStatus(0);
            $user->save();
        }
        \Auth::logout();
        \Session::flush();

        sleep(1);


        \Auth::logout();
        \Session::flush();
        return \Redirect::to('/');
    }]);


require 'routes/user.php';
require 'routes/post.php';
require 'routes/event.php';

Route::any('load/pagelets', ['uses' => function() {
        $pagelets = perfectUnserialize(\Input::get('pagelets'));
        $content = "";
        foreach($pagelets as $pagelet) {
            $content .=\Theme::section($pagelet['view'], $pagelet['data']);
        }

        echo $content;
    }]);


require 'routes/message.php';
require 'routes/connection.php';
require 'routes/search.php';
require 'routes/discover.php';
require 'routes/help.php';
require 'routes/report.php';
require 'routes/additional-page.php';
require 'routes/notification.php';
require 'routes/photo.php';
require 'routes/comment.php';
require 'routes/likes.php';
require 'routes/admincp.php';
require 'routes/community.php';
require 'routes/invite.php';
require 'routes/api.php';
require 'routes/socialauth.php';

/***user profile***/
require 'routes/profile.php';



