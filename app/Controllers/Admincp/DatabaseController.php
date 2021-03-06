<?php

namespace App\Controllers\Admincp;

use App\Repositories\DatabaseRepository;

/* Adam Endvy */
class DatabaseController extends AdmincpController
{
    public function __construct(DatabaseRepository $databaseRepository)
    {
        parent::__construct();
        $this->databaseRepository = $databaseRepository;
    }

    public function update()
    {
        $this->databaseRepository->update();
        return \Redirect::to(\URl::previous())->with('message', trans('admincp.success-saved'));
    }
}