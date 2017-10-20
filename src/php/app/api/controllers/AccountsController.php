<?php

namespace App\Controllers;

use App\Models\Clients;
use App\Models\Projects;

class AccountsController extends ControllerBase
{
    public function getProjectsAction()
    {
        // todo: remove in production
        $this->account_id = 17;

        $client = Clients::findFirst([
            'conditions' => 'acc_id = ?1',
            'bind' => ['1' => $this->account_id]
        ]);

        $projects = Projects::find([
            'conditions' => 'cln_id = ?1',
            'bind' => ['1' => $client->cln_id]
        ]);

        return $this->response->json(['projects' => $projects]);
    }
}
