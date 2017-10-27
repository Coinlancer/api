<?php

namespace App\Controllers;

use App\Lib\Response;
use App\Models\Clients;
use App\Models\Projects;

class ProjectsController extends ControllerBase
{
    public function indexAction()
    {
        $filters = [
            'limit' => +$this->request->getQuery('limit'),
            'offset' => +$this->request->getQuery('offset')
        ];

        $projects = Projects::getExtended($filters);

        return $this->response->json($projects);
    }

    // TODO: maybe refactor and move to each own routes instead
    public function showAction($id)
    {
        $project = $this->querybuilder
            ->table('projects')
            ->select([
                'projects.prj_id',
                'projects.prj_title',
                'projects.prj_description',
                'projects.prj_budget',
                'projects.prj_deadline',
                'projects.prj_created_at',
                'projects.sct_id',
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

        $subcategory = $category = null;

        if ($project->sct_id) {
            $subcategory = \App\Models\Subcategories::findFirstBySctId($project->sct_id);
            $category = \App\Models\Categories::findFirstByCatId($subcategory->cat_id);
        }

        $freelancers = $this->querybuilder
            ->table('accounts')
            ->select([
                'accounts.acc_id',
                'accounts.acc_name',
                'accounts.acc_surname',
                'accounts.acc_login',
                'accounts.acc_email',
                'projects_freelancers.prf_is_hired',
                'projects_freelancers.prf_price',
                'projects_freelancers.prf_message',
                'projects_freelancers.prf_hours',
                'projects_freelancers.prf_created_at',
                'projects_freelancers.prf_updated_at'
            ])
            ->join('freelancers', 'freelancers.acc_id', '=', 'accounts.acc_id')
            ->join('projects_freelancers', 'projects_freelancers.frl_id', '=', 'freelancers.frl_id')
            ->where('projects_freelancers.prj_id', $id)
            ->get();

        $suggestion = $this->getAccountSuggestion($this->account_id, $project->prj_id);

        return $this->response->json([
            'project'     => $project,
            'steps'       => $steps->toArray(),
            'attachments' => $attachments->toArray(),
            'category'    => $category,
            'subcategory' => $subcategory,
            'category'    => $category,
            'skills'      => $skills,
            'freelancers' => $freelancers,
            'suggestion'  => $suggestion
        ]);
    }

    protected function getAccountSuggestion($account_id, $project_id)
    {
        $suggestion = $this->querybuilder
            ->table('accounts')
            ->select([
                'accounts.acc_id',
                'projects_freelancers.prf_is_hired',
                'projects_freelancers.prf_price',
                'projects_freelancers.prf_message',
                'projects_freelancers.prf_hours',
                'projects_freelancers.prf_created_at',
                'projects_freelancers.prf_updated_at'
            ])
            ->join('freelancers', 'freelancers.acc_id', '=', 'accounts.acc_id')
            ->join('projects_freelancers', 'projects_freelancers.frl_id', '=', 'freelancers.frl_id')
            ->where('accounts.acc_id', $account_id)
            ->where('projects_freelancers.prj_id', $project_id)
            ->get();

        if (!$suggestion) {
            return null;
        }

        return $suggestion;
    }

    public function getByAccountAction($id)
    {
        if (empty($id)) {
            return $this->response->error(Response::ERR_EMPTY_PARAM, 'account_id');
        }

        $projects = Projects::getExtended(['acc_id' => $id]);

        return $this->response->json($projects);
    }

    public function createAction()
    {
         $client = Clients::findFirst([
            "conditions" => "acc_id = ?1",
            "bind"       => [1 => $this->account_id]
        ]);

        if (!$client) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $project = new Projects();
        $project->cln_id = $client->cln_id;
        $project->save();

        return $this->response->json($project);
    }

    public function updateAction($id)
    {
        $raw_project = $this->request->getPost();

        $project = Projects::findFirst([
            "conditions" => "prj_id = ?1",
            "bind"       => [1 => $id]
        ]);

        $project->prj_title = $raw_project['title'];
        $project->prj_description = $raw_project['description'];
        $project->prj_budget = $raw_project['budget'];
        $project->prj_deadline = $raw_project['deadline'];
        $project->sct_id = $raw_project['subcategory_id'];
        $project->save();

//        $this->saveProjectSkills($raw_project['skills'], $project->prj_id);
//        $this->saveProjectSubcategories($raw_project['subcategories'], $project->prj_id);

        return $this->response->json();
    }

//    protected function saveProjectSkills($skills, $project_id)
//    {
//        if (!$skills) {
//            return false;
//        }
//
//        $data = [];
//
//        foreach ($skills as $skill_id) {
//            $data[] = [
//                'skl_id' => $skill_id,
//                'prj_id' => $project_id
//            ];
//        }
//
//        $this->querybuilder
//            ->table('projects_skills')
//            ->insert($data);
//
//        return true;
//    }

//    protected function saveProjectSubcategories($subcategories, $project_id)
//    {
//        if (!$subcategories) {
//            return false;
//        }
//
//        $data = [];
//
//        foreach ($subcategories as $subcategory_id) {
//            $data[] = [
//                'sct_id' => $subcategory_id,
//                'prj_id' => $project_id
//            ];
//        }
//
//        $this->querybuilder
//            ->table('projects_subcategories')
//            ->insert($data);
//
//        return true;
//    }

    public function addSkillAction($project_id)
    {
        $skill_id = $this->request->getPost('skill_id');

        $this->querybuilder
            ->table('projects_skills')
            ->insert([
                'prj_id' => $project_id,
                'skl_id' => $skill_id
            ]);

        return $this->response->json();
    }

    public function deleteSkillAction($project_id)
    {
        $skill_id = $this->request->getPost('skill_id');

        $this->querybuilder
            ->table('projects_skills')
            ->where('prj_id', $project_id)
            ->where('skl_id', $skill_id)
            ->delete();

        return $this->response->json();
    }

    //    protected function saveSteps($steps, $project_id)
//    {
//        $steps_array = json_decode($steps, true);
//
//        $steps = [];
//
//        foreach ($steps_array as $one_step) {
//            $step = new Steps;
//
//            $step->prj_id = $project_id;
//            $step->stp_title = $one_step['title'];
//            $step->stp_description = $one_step['description'];
//            $step->stp_budget = $one_step['budget'];
//            $step->save();
//
//            $steps[] = ['id' => $step->stp_id];
//        }
//
//        return $steps;
//    }
//
//    protected function saveAttachments($project_id)
//    {
//        $random = new \Phalcon\Security\Random;
//
//        $attachments = [];
//
//        if ($this->request->hasFiles()) {
//            foreach ($this->request->getUploadedFiles() as $file) {
//                $path = $this->config->path_to_files . '/project_attachments/' . $random->base64(12) . '_' . $file->getName();
//                $file->moveTo($path);
//
//                $attachment = new Attachments;
//                $attachment->tch_title = $file->getName();
//                $attachment->tch_path = $path;
//                $attachment->prj_id = $project_id;
//                $attachment->save();
//
//                $attachments[] = [
//                    'title' => $file->getName(),
//                    'path'  => $path
//                ];
//            }
//        }
//
//        return $attachments;
//    }

    public function testAction()
    {
        var_dump($_FILES);
        die;
    }
}
