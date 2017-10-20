<?php

namespace App\Controllers;

use App\Models\Skills;
use App\Models\Categories;
use App\Models\Subcategories;

class CommonController extends ControllerBase
{
    public function getSkillsAction()
    {
        $skills = Skills::find();

        return $this->response->json(['skills' => $skills]);
    }

    public function getCategoriesAction()
    {
        $categories = Categories::find();

        return $this->response->json(['categories' => $categories]);
    }

    public function getChildCategoriesAction()
    {
        $subcategories = Subcategories::find();

        return $this->response->json(['subcategories' => $subcategories]);
    }
}
