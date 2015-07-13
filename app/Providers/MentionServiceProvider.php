<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/* Adam Endvy */
class MentionServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app['events']->listen('post.add', function($post, $val) {
            App('App\\Repositories\\MentionRepository')->process($post->text, $post->id);
        });


        /***
         * transform @mention in text to there valid links
         */
        $this->app['hook']->listen('post-text', function($text) {
           return App('App\\Repositories\\MentionRepository')->transform($text);
        });
    }
}