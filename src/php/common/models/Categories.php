<?php

namespace App\Models;

use Phalcon\Mvc\Model;

class Categories extends Model
{
    public static function getCategoriesWithProjectsCount()
    {
        $sql = "SELECT categories.*, count(category_project.cat_id) as prjs_count FROM categories 
                  LEFT JOIN category_project ON categories.cat_id = category_project.cat_id 
                    GROUP BY categories.cat_id;";

        $category = new self;

        return $category->getDi()->getShared('db')->query($sql)->fetchAll();
    }
}