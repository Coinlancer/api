<?php

namespace App\Models;

class Freelancers extends ModelBase
{
    public static function createFreelancer($account_id)
    {
        $freelancer = new self();

        $freelancer->acc_id = $account_id;

        return $freelancer->save();
    }
}