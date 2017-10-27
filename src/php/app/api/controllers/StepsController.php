<?php

namespace App\Controllers;

use App\Models\Steps;

class StepsController extends ControllerBase
{
    public function indexAction($project_id)
    {
        $steps = Steps::find([
            "conditions" => "prj_id = ?1",
            "bind"       => [1 => $project_id]
        ]);

        return $this->response->json($steps);
    }

    public function createAction($project_id)
    {
        $step = new Steps;
        $step->prj_id = $project_id;

        $step = $this->saveStep($step);

        return $this->response->json($step);
    }

    public function updateAction($id)
    {
        $step = Steps::findFirst([
            "conditions" => "stp_id = ?1",
            "bind"       => [1 => $id]
        ]);

        $step = $this->saveStep($step);

        return $this->response->json($step);
    }

    protected function saveStep($step)
    {
        $step->stp_title = $this->request->getPost('title');
        $step->stp_description = $this->request->getPost('description');
        $step->stp_budget = $this->request->getPost('budget');
        $step->save();

        return $step;
    }

    public function deleteAction($id)
    {
        $step = Steps::findFirst([
            "conditions" => "stp_id = ?1",
            "bind"       => [1 => $id]
        ]);

        $project = \App\Models\Projects::findFirst([
            "conditions" => "prj_id = ?1",
            "bind"       => [1 => $step->prj_id]
        ]);

        $project_owner = \App\Models\Clients::findFirst([
            "conditions" => "cln_id = ?1",
            "bind"       => [1 => $project->cln_id]
        ]);

        if ($project_owner->acc_id !== $this->account_id) {
            return $this->response->error(\App\Lib\Response::ERR_BAD_PARAM);
        }

        $step->delete();

        return $this->response->json();
    }
}
