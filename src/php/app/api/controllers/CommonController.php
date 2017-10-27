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
            'limit' => +$this->request->getQuery('limit'),
            'offset' => +$this->request->getQuery('offset')
        ];

        $filters['limit'] ?: $filters['limit'] = $this->config->filters->limit;
        $filters['offset'] ?: $filters['offset'] = $this->config->filters->offset;

        $freelancers = $this->querybuilder
            ->table('freelancers')
            ->select('*')
            ->join('accounts', 'accounts.acc_id', '=', 'freelancers.acc_id')
            ->limit($filters['limit'])
            ->offset($filters['offset'])
            ->get();

        foreach ($freelancers as $key => $freelancer) {
            $freelancers[$key] = \App\Models\Accounts::sanitise($freelancer);
        }

        return $this->response->json($freelancers);
    }
}
