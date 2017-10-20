<?php

namespace App\Models;

use Phalcon\Mvc\Model;
use Phalcon\Exception;
use Phalcon\Mvc\Model\Query\Builder;

class Clients extends Model
{
    public $cln_id;
    public $acc_id;
    public $cln_description;

    public static function createClient($account_id)
    {
        $client = new self();

        $client->acc_id = $account_id;

        return $client->save();
    }

    public static function getClientWithAccount($account_id)
    {
        $queryBuilder = new Builder([
            "models" => ["Accounts"]
        ]);

        return $queryBuilder->join("Clients")->getPhql();
    }
}