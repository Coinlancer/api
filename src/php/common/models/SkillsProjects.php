<?php

namespace App\Models;

use Phalcon\Mvc\Model;

class SkillsProjects extends Model
{
    public $skl_id;

    public $prj_id;

    public function initialize()
    {
        $this->belongsTo(
            "skl_id",
            "App\\Models\\Skills",
            "skl_id"
        );

        $this->belongsTo(
            "prj_id",
            "App\\Models\\Projects",
            "prj_id"
        );
    }
}