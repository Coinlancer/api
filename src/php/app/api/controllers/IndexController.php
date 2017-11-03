<?php
namespace App\Controllers;

use App\Lib\Response;
use App\Models\Categories;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        return $this->response->setJsonContent(['API']);
    }

    public function notFoundAction()
    {
        return $this->response->error(Response::ERR_NOT_FOUND, 'route');
    }

    public function getCategoriesWithProjectsCountAction()
    {
        $categories = Categories::getCategoriesWithProjectsCount();

        return $this->response->setJsonContent(['categories' => $categories]);
    }
}
