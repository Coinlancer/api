<?php

namespace App\Controllers;

use App\Lib\Response;
use App\Lib\SmartContract;
use App\Models\Clients;
use App\Models\Projects;
use App\Models\Steps;

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
            'deadline_from' => (int) $this->request->getQuery('deadline_from'),
            'deadline_to' => (int) $this->request->getQuery('deadline_to'),
            'status' => Projects::STATUS_CREATED
        ];

        $projects = Projects::getExtended($filters);

        $min_budget = $this->memcached->get('minProjectsBudget');
        $max_budget = $this->memcached->get('maxProjectsBudget');

        return $this->response->json(['projects' => $projects, 'min_budget' => $min_budget, 'max_budget' => $max_budget]);
    }

    // TODO: maybe refactor and move to each own routes instead
    public function showAction($id)
    {
        $db = $this->querybuilder;

        $project = $db
            ->table('projects')
            ->select([
                'clients.cln_id',
                'projects.prj_id',
                'projects.prj_title',
                'projects.prj_description',
//                'projects.prj_budget',
                'projects.prj_deadline',
                'projects.prj_created_at',
                'projects.prj_status',
                'projects.sct_id',
                'accounts.acc_name',
                'accounts.acc_id',
                'accounts.acc_surname',
                'accounts.acc_skype',
                'accounts.acc_phone',
                'accounts.acc_email',
                'accounts.acc_avatar',
                $db->raw('SUM(steps.stp_budget) as prj_budget')
            ])
            ->join('clients', 'clients.cln_id', '=', 'projects.cln_id')
            ->join('accounts', 'clients.acc_id', '=', 'accounts.acc_id')
            ->leftJoin('steps', 'projects.prj_id', '=', 'steps.prj_id')
            ->where('projects.prj_id', $id)
            ->groupBy('projects.prj_id')
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
        $id = intval($id);

        if (empty($id)) {
            return $this->response->error(Response::ERR_EMPTY_PARAM, 'project_id');
        }

//        $required_parameters = ['title', 'description', 'budget', 'deadline', 'subcategory_id'];
        $required_parameters = ['title', 'description', 'deadline', 'subcategory_id'];

        $raw_project = $this->getPost($required_parameters);

        $client = Clients::findFirstByAccId($this->account_id);

        if (!$client) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $project = Projects::findFirst($id);

        if (empty($project)) {
            return $this->response->error(Response::ERR_NOT_FOUND, 'project');
        }

        if (!in_array($project->prj_status, [Projects::STATUS_CREATED, Projects::STATUS_ACTIVE])) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        if ($project->cln_id != $client->cln_id) {
            $this->logger->error('User with account_id ' . $this->account_id . ' tried to update another\'s project');

            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        if (strtotime($raw_project['deadline']) < time()) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'deadline');
        }

        $project->prj_title = $raw_project['title'];
        $project->prj_description = $raw_project['description'];
//        $project->prj_budget = $raw_project['budget'];
        $project->prj_deadline = $raw_project['deadline'];
        $project->sct_id = $raw_project['subcategory_id'];
        $project->save();

        return $this->response->json();
    }

    /**
     * refund all deposited and not completed steps
     * set canceled project status
     * @param $id - project_id
     * @return mixed
     */
    public function cancelAction($id)
    {
        $id = intval($id);

        if (empty($id)) {
            return $this->response->error(Response::ERR_EMPTY_PARAM, 'project_id');
        }

        $client = Clients::findFirstByAccId($this->account_id);

        if (empty($client)) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $project = Projects::findFirst($id);

        if (empty($project)) {
            $this->response->error(Response::ERR_NOT_FOUND, 'project');
        }

        if ($project->cln_id != $client->cln_id) {
            $this->logger->error('User with account_id ' . $this->account_id . ' tried to cancel another\'s project');

            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        if (!in_array($project->prj_status, [Projects::STATUS_CREATED, Projects::STATUS_ACTIVE])) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $project_steps = Steps::findByPrjId($id);

        foreach ($project_steps as $project_step) {
            if (in_array($project_step->stp_status, [Steps::STATUS_DEPOSITED, Steps::STATUS_MARK_AS_DONE])) {
                $smartcontract = new SmartContract();

                try {
                    $result = $smartcontract->refundStep($project_step->stp_id);

                    $step = Steps::findFirst($project_step->stp_id);

                    if ($result) {
                        $step->stp_status = Steps::STATUS_REFUNDED;

                        if (!$step->save()) {
                            $this->logger->error('Can not save step after refund [step_id ' . $project_step->stp_id . ']', $step->getMessages());

                            return $this->response->error(Response::ERR_SERVICE);
                        }
                    }

                } catch (\Exception $e) {
                    $this->logger->emergency('Can not refund step with id ' . $project_step->stp_id, [$e->getMessage()]);

                    return $this->response->error(Response::ERR_SERVICE);
                }
            }
        }

        $project->prj_status = Projects::STATUS_CANCELED;

        if (!$project->save()) {
            $this->logger->emergency('Can not save canceled status of project with id ' . $project->prj_id);

            return $this->response->error(Response::ERR_SERVICE);
        }

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
}
