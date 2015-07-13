<?php

namespace App\Controllers\Base;

/**
*
*@author: Adam Endvy
*@website : www.intifadah.com
*/
class EventBaseController extends \BaseController
{
    public $event;

    public function __construct()
    {
        parent::__construct();
        $this->eventRepository = app('App\\Repositories\\EventRepository');
        $slug = \Request::segment(2);

        $this->event = $this->eventRepository->get($slug);

        $this->theme->share('event', $this->event);
    }

    public function exists()
    {
        return ($this->event);
    }

    public function render($path, $param = [], $setting = [])
    {
        $predefinedSettings = [
            'title' => $this->setTitle()
        ];

        if ($this->exists()) {

            $predefinedSettings = array_merge($predefinedSettings, ['design' => $this->event->present()->readDesign()]);
        }

        $settings = array_merge($predefinedSettings, $setting);

        if (\Config::get('event-design') and isset($settings['design'])) {
            extract($settings['design']);

            $bgImage = (!empty($bg_image)) ? 'background-image:url('.\Image::url($bg_image).');' : null;
            $this->theme->asset()->afterStyleContent("
                body{
                    ".$bgImage."
                    background-position: ".$bg_position.";
                    background-color: ".$bg_color.";
                    background-repeat: ".$bg_repeat.";
                    background-attachment : ".$bg_attachment.";
                }

                a {
                    color : ".$link_color.";
                }

                .page-content{
                    background-color: ".$content_bg_color.";
                }
            ");
        }

        return parent::render('event.profile.layout', ['content' => $this->theme->section($path, $param)], $settings);

    }

    public function notFound()
    {
        //if ($this->page and !$this->community->present()->canView()) return \Redirect::route('communities');
        return $this->theme->section('error-page');
    }

    public function setTitle($title = null)
    {
        if (!$this->exists()) return parent::setTitle($title);
        $title = $this->event->title.((!empty($title)) ? ' - '.$title : null);
        return parent::setTitle($title);
    }

}