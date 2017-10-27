<?php

namespace App\Controllers;

use App\Lib\Response;

class SuggestionsController extends ControllerBase
{
    public function index($id)
    {
        $suggestions = \App\Models\ProjectsFreelancers::find([
            "conditions" => "prj_id = ?1",
            "bind" => [1 => $id]
        ]);

        return $this->response->json($suggestions);
    }

    public function createAction($id)
    {
        $freelancer = \App\Models\Freelancers::findFirst([
            "conditions" => "acc_id = ?1",
            "bind" => [1 => $this->account_id]
        ]);

        if (!$freelancer) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $data = [
            'prj_id' => $id,
            'frl_id' => $freelancer->frl_id,
            'prf_price' => $this->request->getPost('price'),
            'prf_hours' => $this->request->getPost('hours'),
            'prf_message' => $this->request->getPost('message')
        ];

        $suggestion = $this->querybuilder
            ->table('projects_freelancers')
            ->insert($data);

        return $this->response->json($suggestion);
    }

    public function deleteAction($id)
    {
        $projects_freelancers = \App\Models\ProjectsFreelancers::findFirst([
            "conditions" => "acc_id = ?1",
            "bind" => [1 => $id]
        ]);

        $freelancer = \App\Models\Freelancers::findFirst([
            "conditions" => "acc_id = ?1",
            "bind" => [1 => $this->account_id]
        ]);

        if ($projects_freelancers->frl_id !== $freelancer->frl_id) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $projects_freelancers->delete();

        return $this->response->json();
    }

    public function confirmAction($id)
    {
        $projects_freelancers = \App\Models\ProjectsFreelancers::findFirst([
            "conditions" => "acc_id = ?1",
            "bind" => [1 => $id]
        ]);

        $project = \App\Models\Projects::findFirst([
            "conditions" => "prj_id = ?1",
            "bind" => [1 => $projects_freelancers->prj_id]
        ]);

        $project_owner = \App\Models\Clients::findFirst([
            "conditions" => "cln_id = ?1",
            "bind" => [1 => $project->cln_id]
        ]);

        if ($project_owner->acc_id !== $this->account_id) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $projects_freelancers->prf_is_hired = true;
        $projects_freelancers->save();

        return $this->response->json();
    }
}
