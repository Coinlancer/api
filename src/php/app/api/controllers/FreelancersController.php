<?php

namespace App\Controllers;

use App\Lib\Response;
use App\Models\Projects;

class FreelancersController extends ControllerBase
{
    public function suggestionsAction()
    {
        $freelancer = $this->getFreelancer();

        $filters = [
            'limit' => (int) $this->request->getQuery('limit'),
            'offset' => (int) $this->request->getQuery('offset')
        ];

        $filters['limit'] ?: $filters['limit'] = $this->config->filters->limit;
        $filters['offset'] ?: $filters['offset'] = $this->config->filters->offset;

        $suggestions = $this->querybuilder
            ->table('projects_freelancers')
            ->select('*')
            ->join('projects', 'projects.prj_id', '=', 'projects_freelancers.prj_id')
            ->where('frl_id', '=', $freelancer->frl_id)
            ->orderBy('projects_freelancers.prf_created_at', 'DESC')
            ->limit($filters['limit'])
            ->offset($filters['offset'])
            ->get();

        return $this->response->json($suggestions);
    }

    public function projectSuggestionAction($project_id)
    {
        $freelancer = $this->getFreelancer();

        $suggestion = $this->querybuilder
            ->table('projects_freelancers')
            ->select('*')
            ->where('frl_id', '=', $freelancer->frl_id)
            ->where('prj_id', '=', $project_id)
            ->get();

        return $this->response->json(reset($suggestion));
    }

    public function worksAction()
    {
        $freelancer = $this->getFreelancer();

        $filters = [
            'limit' => (int) $this->request->getQuery('limit'),
            'offset' => (int) $this->request->getQuery('offset')
        ];

        $filters['limit'] ?: $filters['limit'] = $this->config->filters->limit;
        $filters['offset'] ?: $filters['offset'] = $this->config->filters->offset;

        $works = \App\Models\ProjectsFreelancers::find(
            [
                'conditions' => 'frl_id = '.$freelancer->frl_id.' and prf_is_hired = 1',
                'limit' => $filters['limit'],
                'offset' => $filters['offset'],
                'order' => 'prf_created_at DESC',
            ]
        );

        $ids = [];

        foreach ($works as $work) {
            $ids[] = $work->prj_id;
        }

        $works = [];

        if ($ids) {
            $works = Projects::getExtended(['ids' => $ids]);
        }

        return $this->response->json($works);
    }

    public function showAction($id)
    {
        $freelancer = $this->querybuilder
            ->table('accounts')
            ->select([
                'freelancers.frl_id',
                'accounts.acc_id',
                'accounts.acc_description',
                'accounts.acc_name',
                'accounts.acc_surname',
                'accounts.acc_login',
                'accounts.acc_email',
                'accounts.acc_skype',
                'accounts.acc_phone',
                'accounts.acc_avatar',
                $this->querybuilder->raw('count(projects_freelancers.frl_id) as active_projects_count')
            ])
            ->join('freelancers', 'freelancers.acc_id', '=', 'accounts.acc_id')
            ->join('projects_freelancers', 'projects_freelancers.frl_id', '=', 'freelancers.frl_id')
            ->where('freelancers.frl_id', $id)
            ->where('projects_freelancers.prf_is_hired', '1')
            ->get();

        $freelancer = reset($freelancer);

        if (!$freelancer || !$freelancer->acc_id) {
            return $this->response->error(Response::ERR_NOT_FOUND, 'freelancer');
        }

        $freelancer = (array)$freelancer;

        $skills = $this->querybuilder
            ->table('skills')
            ->select(['skills.*'])
            ->join('skills_freelancers', 'skills.skl_id', '=', 'skills_freelancers.skl_id')
            ->join('freelancers', 'freelancers.frl_id', '=', 'skills_freelancers.frl_id')
            ->where('freelancers.frl_id', $freelancer['frl_id'])
            ->get();

        $freelancer['skills'] = $skills;

        return $this->response->json($freelancer);
    }

    public function addSkillAction($skill_id)
    {
        //temporary hardcode years
//        $required_parameters = ['years'];
//        $post = $this->getPost($required_parameters);

        $freelancer = $this->getFreelancer();

        $skill_freelancer = new \App\Models\SkillsFreelancers;
        $skill_freelancer->skl_id = $skill_id;
        $skill_freelancer->frl_id = $freelancer->frl_id;
//        $skill_freelancer->skl_frl_years = $post['years'];
        $skill_freelancer->skl_frl_years = 1;

        $skill_freelancer->save();

        return $this->response->json();
    }

    public function deleteSkillAction($skill_id)
    {
        $freelancer = $this->getFreelancer();

        $skill_freelancer = \App\Models\SkillsFreelancers::findFirst([
            'conditions' => 'skl_id = ?1 and frl_id = ?2',
            'bind' => [
                1 => $skill_id,
                2 => $freelancer->frl_id
            ]
        ]);

        if (!$skill_freelancer) {
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        $skill_freelancer->delete();

        return $this->response->json();
    }

    protected function getFreelancer()
    {
        $freelancer = \App\Models\Freelancers::findFirstByAccId($this->account_id);

        if (!$freelancer) {
            $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        return $freelancer;
    }
}
