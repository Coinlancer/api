<?php

namespace App\Models;

use Phalcon\Mvc\Model;
use Phalcon\Exception;

class Freelancers extends Model
{
    public $frl_id;
    public $acc_id;
    public $frl_description;

    public static function createFreelancer($account_id)
    {
        $freelancer = new self();

        $freelancer->acc_id = $account_id;

        return $freelancer->save();
    }
}