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
            'limit' => (int) $this->request->getQuery('limit'),
            'offset' => (int) $this->request->getQuery('offset'),
            'min_budget' => (int) $this->request->getQuery('min_budget'),
            'max_budget' => (int) $this->request->getQuery('max_budget'),
            'skills' => $this->getQuerySkills($this->request->getQuery('skills')),
            'subcategory_id' => (int) $this->request->getQuery('subcategory_id'),
            'content' => $this->request->getQuery('content'),
            'status' => Projects::STATUS_CREATED
        ];

        $filters['limit'] ?: $filters['limit'] = $this->config->filters->limit;
        $filters['offset'] ?: $filters['offset'] = $this->config->filters->offset;

        $projects = Projects::getExtended($filters);

        $min_budget = Projects::getMinBudget();
        $max_budget = Projects::getMaxBudget();

        return $this->response->json(['projects' => $projects, 'min_budget' => $min_budget, 'max_budget' => $max_budget]);
    }

    // TODO: maybe refactor and move to each own routes instead
    public function showAction($id)
    {
        $project = $this->querybuilder
            ->table('projects')
            ->select([
                'clients.cln_id',
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
                'accounts.acc_skype',
                'accounts.acc_phone',
                'accounts.acc_email',
                'accounts.acc_avatar',
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

        $hired_suggestion = $this->getProjectHiredSuggestion($project->prj_id);

        return $this->response->json([
            'project'     => $project,
            'steps'       => $steps->toArray(),
            'attachments' => $attachments->toArray(),
            'category'    => $category,
            'subcategory' => $subcategory,
            'skills'      => $skills,
            'hired_suggestion'  => !empty($hired_suggestion) ? $hired_suggestion : null
        ]);
    }

    protected function getAccountSuggestion($account_id, $project_id)
    {
        $suggestion = $this->querybuilder
            ->table('accounts')
            ->select([
                'accounts.acc_id',
                'projects_freelancers.prf_is_hired',
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

    protected function getProjectHiredSuggestion($project_id)
    {
        $suggestion = $this->querybuilder
            ->table('projects_freelancers')
            ->select([
                'projects_freelancers.*',
                'freelancers.*',
            ])
            ->join('freelancers', 'freelancers.frl_id', '=', 'projects_freelancers.frl_id')
            ->where('projects_freelancers.prj_id', $project_id)
            ->where('projects_freelancers.prf_is_hired', 1)
            ->limit(1)
            ->get();

        return reset($suggestion);
    }

    public function getByAccountAction($id)
    {
        $id = intval($id);

        if (empty($id)) {
            return $this->response->error(Response::ERR_EMPTY_PARAM, 'account_id');
        }

        $filters = [
            'limit' => (int) $this->request->getQuery('limit'),
            'offset' => (int) $this->request->getQuery('offset'),
            'acc_id' => $id
        ];

        $filters['limit'] ?: $filters['limit'] = $this->config->filters->limit;
        $filters['offset'] ?: $filters['offset'] = $this->config->filters->offset;

        $projects = Projects::getExtended($filters);

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

        return $this->response->json();
    }

    public function addSkillAction($project_id)
    {
        $required_parameters = ['skill_id'];

        $post = $this->getPost($required_parameters);

        $this->checkProjectOwner($project_id);

        try {
            $this->querybuilder
                ->table('projects_skills')
                ->insert([
                    'prj_id' => $project_id,
                    'skl_id' => $post['skill_id']
                ]);
        } catch (\Exception $e) {
            return $this->response->error(Response::ERR_DUPLICATE, $e->getMessage());
        }

        return $this->response->json();
    }

    public function deleteSkillAction($project_id)
    {
        $required_parameters = ['skill_id'];

        $post = $this->getPost($required_parameters);

        $this->checkProjectOwner($project_id);

        try {
            $this->querybuilder
                ->table('projects_skills')
                ->where('prj_id', $project_id)
                ->where('skl_id', $post['skill_id'])
                ->delete();
        } catch (\Exception $e) {
            return $this->response->error(Response::ERR_SERVICE, $e->getMessage());
        }

        return $this->response->json();
    }

    public function testAction()
    {
        var_dump($_FILES);
        die;
    }
}
