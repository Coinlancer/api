<?php

namespace App\Controllers;

use App\Lib\Response;

class ClientsController extends ControllerBase
{

    public function showAction($id)
    {
        $client = $this->querybuilder
            ->table('accounts')
            ->select([
                'clients.cln_id',
                'accounts.acc_id',
                'accounts.acc_description',
                'accounts.acc_name',
                'accounts.acc_surname',
                'accounts.acc_login',
                'accounts.acc_email',
                'accounts.acc_skype',
                'accounts.acc_phone',
                'accounts.acc_avatar',
                $this->querybuilder->raw('count(projects.cln_id) as active_projects_count')
            ])
            ->join('clients', 'clients.acc_id', '=', 'accounts.acc_id')
            ->join('projects', 'projects.cln_id', '=', 'clients.cln_id')
            ->where('clients.cln_id', $id)
            ->get();

        $client = reset($client);

        if (!$client || !$client->acc_id) {
            return $this->response->error(Response::ERR_NOT_FOUND, 'Client');
        }

        return $this->response->json($client);
    }
}
