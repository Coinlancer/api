<?php

namespace App\Models;

use Phalcon\Mvc\Model;

class Skills extends Model
{
    public $skl_id;

    public function initialize()
    {
        $this->hasManyToMany(
            "skl_id",
            "SkillsProjects",
            "skl_id", "prj_id",
            "Projects",
            "prj_id"
        );
    }
}