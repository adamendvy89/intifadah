<?php

namespace App\Controllers;

use App\Controllers\Base\UserBaseController;
use App\Controllers\Xcrud;

/* Adam Endvy */
class MobileOnlineMeetingController extends UserBaseController
{

    public function index()
    {

        $data = Xcrud::get_instance()->table('inti_online_meeting_rooms')
        ->columns('room_name,description,created_at')
        ->fields('room_name,description')
        ->label('room_name', 'Judul Rapat')
        ->label('description', 'Deskripsi')
        ->label('created_at', 'Tanggal Dibuat')
        ->column_pattern('room_name', '<a href="https://rtc.intifadah.net/{slug}" class="xcrud-action" ><b color="red">{room_name}</a></b>')
        ->pass_var('creator', \Auth::user()->id )
        ->pass_var('created_at',date('Y-m-d H:i:s'))
        ->before_insert('save_online_meeting', app_path().'/config/function.php')
        ->where("creator = '".\Auth::user()->id."'")
        ->unset_title()
        ->unset_limitlist()
        ->unset_view()
        ->unset_csv()
        ->limit(10);


        return $this->render('webrtc.meeting.manage', ['data' => $data], ['title' => $this->setTitle(trans('global.about'))]);
    }

    public function show()
    {
        
    }
}