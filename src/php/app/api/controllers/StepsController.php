<?php

namespace App\Controllers;

use App\Models\Steps;
use App\Lib\Response;

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
        $required_parameters = ['title', 'description', 'budget'];

        $post = $this->getPost($required_parameters);

        $this->checkProjectOwner($project_id);

        $step = new Steps;
        $step->prj_id = $project_id;

        $step = $this->saveStep($step, $post);

        return $this->response->json($step);
    }

    public function updateAction($project_id, $id)
    {
        $required_parameters = ['title', 'description', 'budget'];

        $post = $this->getPost($required_parameters);

        $this->checkProjectOwner($project_id);

        $step = Steps::findFirst([
            "conditions" => "stp_id = ?1 and prj_id = ?2",
            "bind"       => [
                1 => $id,
                2 => $project_id
            ]
        ]);

        if (!$step) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'step_id & project_id');
        }

        $step = $this->saveStep($step, $post);

        return $this->response->json($step);
    }

    protected function saveStep($step, $post)
    {
        $step->stp_title = $post['title'];
        $step->stp_description = $post['description'];
        $step->stp_budget = $post['budget'];
        $step->save();

        return $step;
    }

    public function deleteAction($project_id, $id)
    {
        $this->checkProjectOwner($project_id);

        $step = Steps::findFirst([
            "conditions" => "stp_id = ?1 and prj_id = ?2",
            "bind"       => [
                1 => $id,
                2 => $project_id
            ]
        ]);

        if (!$step) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'step_id & project_id');
        }

        $step->delete();

        return $this->response->json();
    }
}
