<?php

namespace App\Controllers;

use App\Lib\Response;
use App\Models\Attachments;
use App\Models\Clients;
use App\Models\Projects;
use App\Models\Steps;

class ProjectsController extends ControllerBase
{
    public function indexAction()
    {
        $projects = Projects::getExtended();

        return $this->response->json($projects);
    }

    // TODO: maybe refactor and move to each own routes instead
    public function showAction($id)
    {
        $project = $this->querybuilder
            ->table('projects')
            ->select([
                'projects.prj_title',
                'projects.prj_description',
                'projects.prj_budget',
                'projects.prj_deadline',
                'projects.prj_created_at',
                'accounts.acc_name',
                'accounts.acc_id',
                'accounts.acc_surname',
            ])
            ->join('clients', 'clients.cln_id', '=', 'projects.cln_id')
            ->join('accounts', 'clients.acc_id', '=', 'accounts.acc_id')
            ->where('projects.prj_id', $id)
            ->first();

        if (empty($project)) {
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        $steps = \App\Models\Steps::find([
            'prj_id = :prj_id:',
            'bind' => ['prj_id' => $id]
        ]);

        $attachments = \App\Models\Attachments::find([
            'prj_id = :prj_id:',
            'bind' => ['prj_id' => $id]
        ]);

        $skills = $this->querybuilder
            ->table('skills')
            ->select(['skills.*'])
            ->join('projects_skills', 'skills.skl_id', '=', 'projects_skills.skl_id')
            ->join('projects', 'projects.prj_id', '=', 'projects_skills.prj_id')
            ->where('projects.prj_id', $id)
            ->get();

        $freelancers = $this->querybuilder
            ->table('accounts')
            ->select([
                'accounts.acc_id',
                'accounts.acc_name',
                'accounts.acc_surname',
                'accounts.acc_login',
                'accounts.acc_email'
            ])
            ->join('freelancers', 'freelancers.acc_id', '=', 'accounts.acc_id')
            ->join('projects_freelancers', 'projects_freelancers.frl_id', '=', 'freelancers.frl_id')
            ->where('projects_freelancers.prj_id', $id)
            ->get();

        return $this->response->json([
            'project'     => $project,
            'steps'       => $steps->toArray(),
            'attachments' => $attachments->toArray(),
            'skills'      => $skills,
            'freelancers' => $freelancers,
        ]);
    }

    public function getByAccountAction($id)
    {
        if (empty($id)) {
            return $this->response->error(Response::ERR_EMPTY_PARAM, 'Empty account id');
        }

        $projects = Projects::getExtended(['acc_id' => $id]);

        return $this->response->json($projects);
    }

    public function createAction()
    {
        $raw_project = $this->request->getPost();

        $client = Clients::findFirst([
            "conditions" => "acc_id = ?1",
            "bind"       => [1 => $this->account_id]
        ]);

        if (!$client) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $project = new Projects();
        $project->cln_id = $client->cln_id;
        $project->prj_title = $raw_project['title'];
        $project->prj_description = $raw_project['description'];
        $project->prj_budget = $raw_project['budget'];
        $project->prj_deadline = $raw_project['deadline'];
        $project->save();

        $steps = $this->saveSteps($raw_project['steps'], $project->prj_id);
        $attachments = $this->saveAttachments($project->prj_id);

        return $this->response->json(['project' => $project, 'steps' => $steps, 'attachments' => $attachments]);
//        return $this->response->json(['project' => $project]);

//        $client = Accounts::query()
//            ->columns('[App\Models\Accounts].acc_id as account_id, [App\Models\Clients].cln_id')
//            ->where('account_id = 17')
//            ->join('App\Models\Clients', 'App\Models\Accounts.acc_id = App\Models\Clients.acc_id')
//            ->execute();
//        $client = Clients::getClientWithAccount($this->account_id);

    }

    protected function saveSteps($steps, $project_id)
    {
        $steps_array = json_decode($steps, true);

        $steps = [];

        foreach ($steps_array as $one_step) {
            $step = new Steps;

            $step->prj_id = $project_id;
            $step->stp_title = $one_step['title'];
            $step->stp_description = $one_step['description'];
            $step->stp_budget = $one_step['budget'];
            $step->save();

            $steps[] = ['id' => $step->stp_id];
        }

        return $steps;
    }

    protected function saveAttachments($project_id)
    {
        $random = new \Phalcon\Security\Random;

        $attachments = [];

        if ($this->request->hasFiles()) {
            foreach ($this->request->getUploadedFiles() as $file) {
                $path = $this->config->path_to_files . '/project_attachments/' . $random->base64(12) . '_' . $file->getName();
                $file->moveTo($path);

                $attachment = new Attachments;
                $attachment->tch_title = $file->getName();
                $attachment->tch_path = $path;
                $attachment->prj_id = $project_id;
                $attachment->save();

                $attachments[] = [
                    'title' => $file->getName(),
                    'path'  => $path
                ];
            }
        }

        return $attachments;
    }

    public function testAction()
    {
        var_dump($_FILES);
        die;
    }
}
