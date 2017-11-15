<?php

namespace App\Controllers;

use App\Lib\Response;
use App\Models\Projects;

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
            ])
            ->join('clients', 'clients.acc_id', '=', 'accounts.acc_id')
            ->where('clients.cln_id', $id)
            ->get();

        $client = reset($client);

        if (!$client || !$client->acc_id) {
            return $this->response->error(Response::ERR_NOT_FOUND, 'Client');
        }

        $client = (array)$client;

        $client['projects_counters'] = [
            'active_projects' => 0,
            'completed_projects' => 0,
        ];

        $active_projects = $this->querybuilder
            ->table('projects')
            ->select([
                $this->querybuilder->raw('count(projects.prj_id) as count')
            ])
            ->where('projects.cln_id', $id)
            ->where('projects.prj_status', Projects::STATUS_ACTIVE)
            ->get();

        $active_projects = reset($active_projects);

        if ($active_projects && $active_projects->count) {
            $client['projects_counters']['active_projects'] = $active_projects->count;
        }

        $completed_projects = $this->querybuilder
            ->table('projects')
            ->select([
                $this->querybuilder->raw('count(projects.prj_id) as count')
            ])
            ->where('projects.cln_id', $id)
            ->where('projects.prj_status', Projects::STATUS_COMPLETED)
            ->get();

        $completed_projects = reset($completed_projects);

        if ($completed_projects && $completed_projects->count) {
            $client['projects_counters']['completed_projects'] = $completed_projects->count;
        }

        return $this->response->json($client);
    }
}
