<?php

namespace App\Controllers;

use App\Controllers\Base\CommunityPageBaseController;
use App\Controllers\Xcrud;

/* Adam Endvy */

class XcrudAjax extends CommunityPageBaseController{

	public function index(){
		//dd($_POST);
		echo Xcrud::get_requested_instance();
		//echo "hello";
	}
}

