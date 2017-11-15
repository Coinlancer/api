<?php

namespace App\Controllers;

use App\Models\Skills;
use App\Models\Categories;
use App\Models\Subcategories;

class CommonController extends ControllerBase
{
    public function getSkillsAction()
    {
        $skills = Skills::find();

        return $this->response->json(['skills' => $skills]);
    }

    public function getCategoriesAction()
    {
        $categories = $this->querybuilder->table('categories')->select('*')->get();

        $subcategories = $this->querybuilder
            ->table('subcategories')
            ->select(['subcategories.*', $this->querybuilder->raw('count(projects.prj_id) as projects_count')])
            ->leftJoin('projects', 'subcategories.sct_id', '=', 'projects.sct_id')
            ->groupBy('subcategories.sct_id')
            ->get();

        return $this->response->json(['categories' => $categories, 'subcategories' => $subcategories]);
    }

    public function getSubCategoriesAction()
    {
        $subcategories = $this->querybuilder
            ->table('subcategories')
            ->select(['subcategories.*', $this->querybuilder->raw('count(projects.prj_id) as projects_count')])
            ->leftJoin('projects', 'subcategories.sct_id', '=', 'projects.sct_id')
            ->groupBy('subcategories.sct_id')
            ->get();

        return $this->response->json($subcategories);
    }

    public function getFreelancersAction()
    {
        $filters = [
            'limit' => (int) $this->request->getQuery('limit'),
            'offset' => (int) $this->request->getQuery('offset'),
            'skills' => $this->getQuerySkills($this->request->getQuery('skills'))
        ];

        $filters['limit'] ?: $filters['limit'] = $this->config->filters->limit;
        $filters['offset'] ?: $filters['offset'] = $this->config->filters->offset;

        $db = $this->querybuilder;
        $query = $db
            ->table('freelancers')
            ->select([
                'freelancers.*',
                'accounts.*',
                $db->raw('GROUP_CONCAT(skills_freelancers.skl_id) as skills'),
                $db->raw('GROUP_CONCAT(\'|\', skills_freelancers.skl_id , \'|\') as skill_ids')
            ])
            ->join('accounts', 'accounts.acc_id', '=', 'freelancers.acc_id')
            ->leftJoin('skills_freelancers', 'freelancers.frl_id', '=', 'skills_freelancers.frl_id')
            ->groupBy('freelancers.frl_id');

        if (!empty($filters['skills'])) {
            $skills = "%";

            foreach ($filters['skills'] as $skill) {
                $skills .= '|' . $skill . '|' . '%';
            }

            $query->having('skill_ids', 'like', $skills);
        }

        $query
            ->limit($filters['limit'])
            ->offset($filters['offset']);

        $freelancers = $query->get();

        foreach ($freelancers as $key => $freelancer) {
            unset($freelancer->acc_password);
            unset($freelancer->acc_verification_key);

            $freelancers[$key] = $freelancer;
        }

        return $this->response->json($freelancers);
    }
}
