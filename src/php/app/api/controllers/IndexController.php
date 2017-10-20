<?php
namespace App\Controllers;

use App\Lib\Response;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        return $this->response->setJsonContent(['API']);
    }

    public function notFoundAction()
    {
        return $this->response->error(Response::ERR_NOT_FOUND);
    }
}
