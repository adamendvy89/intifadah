<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/* Adam Endvy */
class AdmincpServiceProvider extends ServiceProvider
{
    public function register(){

    }


    public function  boot()
    {

        \Hook::listen('filter-text', function($text) {
            $badwords = \Config::get('user-badwords');
            $replace = \Config::get('user-badwords-replace');

            $badwords = (empty($badwords)) ? [] : explode(',', $badwords);
            $words = join("|", array_filter(array_map('preg_quote',array_map('trim', $badwords))));

            foreach($badwords as $badword) {
                $text = @preg_replace("/\b($words)\b/uie", '"".str_repeat("$replace",strlen("$1")).""', $text);
            }

            return $text;
        });

        include(app_path().'/routes/admincp.php');

        if (true ) {

            \App::setLocale(\Session::get('current-language', \Cache::get('active-language', 'en')));

            if (\Auth::check()) {
              //set user preferred language
                $lang = \Auth::user()->present()->privacy('lang', \Cache::get('active-language', 'en'));
                \App::setLocale($lang);
            }

            $configurationRepository = $this->app->make('App\\Repositories\ConfigurationRepository');
            $configurations = $configurationRepository->getNameLists();



            foreach($configurations as $configuration) {
                if ($configuration != 'general') {
                    \Menu::add('admincp-configuration', $configuration, [
                        'link' => \URL::to('admincp/configurations/'.$configuration),
                        'name' => ucwords($configuration).'',
                    ]);
                }
            }

        }

        \Menu::add('admincp-configuration', 'general', [
            'link' => \URL::to('admincp/configurations/general'),
            'name' => 'General',
        ]);

        /**User menus***/
        \Menu::add('admincp-users', 'list', [
            'link' => \URL::route('admincp-user-list'),
            'name' => 'Lists',
        ]);

        /**\Menu::add('admincp-users', 'add-user', [
            'link' => \URL::route('admincp-user-list'),
            'name' => 'Add user',
        ]);**/

        \Menu::add('admincp-users', 'unvalidated-list', [
            'link' => \URL::route('admincp-user-unvalidated-list'),
            'name' => 'Unvalidated Members',
        ]);
        \Menu::add('admincp-users', 'custom-field', [
            'link' => \URL::route('admincp-user-custom-field'),
            'name' => 'Custom Fields',
        ]);

        \Menu::add('admincp-users', 'ban-users', [
            'link' => \URL::route('admincp-ban-users'),
            'name' => 'Banned Users',
        ]);



        \Menu::add('admincp-menu', 'language', [
            'link' => '',
            'name' => 'Manage Translation',
        ]);

        \Menu::add('sub-menu-language', 'list', [
            'link' => \URL::to('admincp/languages'),
            'name' => 'Languages',
        ]);

        \Menu::add('sub-menu-language', 'add-language', [
            'link' => \URL::to('admincp/languages/add'),
            'name' => 'Add Languages',
        ]);

        //communities menu
        \Menu::add('admincp-menu', 'communities', [
            'link' => \URL::to('admincp/communities'),
            'name' => 'Manage Communities',
        ]);


        //events menu
        \Menu::add('admincp-menu', 'event', [
            'link' => '',
            'name' => 'Manage Events',
        ]);

        \Menu::add('sub-menu-event', 'events', [
            'link' => \URL::to('admincp/events'),
            'name' => 'Events',
        ]);


        \Menu::add('sub-menu-event', 'event-category', [
            'link' => \URL::to('admincp/events/categories'),
            'name' => 'Categories',
        ]);

        \Menu::add('sub-menu-event', 'event-create-category', [
            'link' => \URL::to('admincp/events/create/category'),
            'name' => 'Add Categories',
        ]);

        //Report menu
        \Menu::add('admincp-menu', 'report', [
            'link' => '',
            'name' => 'Reports',
        ]);

        \Menu::add('sub-menu-report', 'report-post', [
            'link' => \URL::to('admincp/reports'),
            'name' => 'Posts',
        ]);

        \Menu::add('sub-menu-report', 'report-profile', [
            'link' => \URL::to('admincp/reports?type=profile'),
            'name' => 'Profile',
        ]);

        \Menu::add('sub-menu-report', 'report-community', [
            'link' => \URL::to('admincp/reports?type=community'),
            'name' => 'Communities',
        ]);

        \Menu::add('sub-menu-report', 'report-page', [
            'link' => \URL::to('admincp/reports?type=page'),
            'name' => 'Pages',
        ]);

        //Additional pages
        \Menu::add('admincp-menu', 'additional-page', [
            'link' => '',
            'name' => 'Manage Additional Pages',
        ]);

        \Menu::add('sub-menu-additional-page', 'about-us', [
            'link' => \URL::to('admincp/additional-page?slug=about-us'),
            'name' => 'About US',
        ]);

        \Menu::add('sub-menu-additional-page', 'terms-and-condition', [
            'link' => \URL::to('admincp/additional-page?slug=terms-and-condition'),
            'name' => 'Terms and Condition',
        ]);

        \Menu::add('sub-menu-additional-page', 'disclaimer', [
            'link' => \URL::to('admincp/additional-page?slug=disclaimer'),
            'name' => 'Disclaimer',
        ]);

        \Menu::add('sub-menu-additional-page', 'privacy-policy', [
            'link' => \URL::to('admincp/additional-page?slug=privacy-policy'),
            'name' => 'Privacy Policy',
        ]);

        //Help system
        \Menu::add('admincp-menu', 'help', [
            'link' => '',
            'name' => 'Manage Helps',
        ]);

        \Menu::add('sub-menu-help', 'lists', [
            'link' => \URL::to('admincp/helps/list'),
            'name' => 'Lists',
        ]);

        \Menu::add('sub-menu-help', 'add', [
            'link' => \URL::to('admincp/helps/add'),
            'name' => 'Add Help',
        ]);

        
        
        \Menu::add('admincp-menu', 'ads', [
            'link' => \URL::to('admincp/ads'),
            'name' => 'Manage Ads',
        ]);

        //newsletter admincpc management
        \Menu::add('admincp-menu', 'newsletter', [
            'link' => '',
            'name' => 'NewsLetter',
        ]);

        \Menu::add('sub-menu-newsletter', 'list', [
            'link' => \URL::to('admincp/newsletter'),
            'name' => 'Lists',
        ]);

        \Menu::add('sub-menu-newsletter', 'add', [
            'link' => \URL::to('admincp/newsletter/add'),
            'name' => 'Add New',
        ]);

        //listing to new users
        $this->app['events']->listen('user.register', function($user) {
            $users = \Config::get('users-autofollow');

            if (!empty($users)) {
                $users = explode(',', $users);
                foreach($users as $thisUser) {
                    $thisUser = app('App\\Repositories\\UserRepository')->findByUsername($thisUser);
                    if ($thisUser) {
                        $connection = app('App\\Repositories\\ConnectionRepository');
                        $connection->add($user->id, $thisUser->id, 1);
                    }
                }
            }

            //communities
            $communities = \Config::get('community-autojoin');
            if (!empty($communities)) {
                $communities = explode(',', $communities);
                foreach($communities as $slug) {
                    $communityRepo = app('App\\Repositories\\CommunityRepository');
                    $community = $communityRepo->get($slug);
                    if($community) {
                        $communityRepo->join($community->id, $user->id);
                    }
                }
            }

            //for pages comming later
            $pages = \Config::get('pages-autolike');
            if(!empty($pages)) {
                $pages = explode(',', $pages);
                foreach($pages as $slug) {
                    $eventRepository = app('App\\Repositories\\EventRepository');
                    $page = $eventRepository->get($slug);
                    if ($page) {
                        app('App\\Repositories\\LikeRepository')->add('page', $page->id, $user->id);
                    }
                }
            }
        });
    }
}