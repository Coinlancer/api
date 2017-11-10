<?php

namespace App\Models;

use Phalcon\Di;

class Projects extends ModelBase
{
    const STATUS_CREATED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_COMPLETED = 2;
    const STATUS_CANCELED = 3;

    public static function getExtended(array $filters = [])
    {
        $config = Di::getDefault()->getConfig();

        $filters['limit'] = $filters['limit'] ? $filters['limit'] : $config->filters->limit;
        $filters['offset'] = $filters['offset'] ? $filters['offset'] : $config->filters->offset;

        $qb = Di::getDefault()->getQuerybuilder();
        $query = $qb
            ->table('projects')
            ->select([
                'projects.*',
                'accounts.acc_id',
                'accounts.acc_name',
                'accounts.acc_surname',
                $qb->raw('GROUP_CONCAT(DISTINCT concat(skills.skl_id, ":", skills.skl_title) SEPARATOR ",") as skills'),
                $qb->raw('GROUP_CONCAT(`projects_skills`.skl_id) as skill_ids')
            ])
            ->join('clients', 'clients.cln_id', '=', 'projects.cln_id')
            ->join('accounts', 'clients.acc_id', '=', 'accounts.acc_id')
            ->leftJoin('projects_skills', 'projects_skills.prj_id', '=', 'projects.prj_id')
            ->leftJoin('skills', 'projects_skills.skl_id', '=', 'skills.skl_id')
            ->orderBy('projects.prj_created_at', 'DESC')
            ->groupBy('projects.prj_id')
            ->limit($filters['limit'])
            ->offset($filters['offset']);

        if (!empty($filters['acc_id'])) {
            $query->where('accounts.acc_id', $filters['acc_id']);
        }

        if (isset($filters['status'])) {
            $query->where('projects.prj_status', $filters['status']);
        }

        if (!empty($filters['ids'])) {
            $query->whereIn('projects.prj_id', $filters['ids']);
        }

        if (!empty($filters['min_budget'])) {
            $query->where('projects.prj_budget', '>=', $filters['min_budget']);
        }

        if (!empty($filters['max_budget'])) {
            $query->where('projects.prj_budget', '<=', $filters['max_budget']);
        }

        if (!empty($filters['subcategory_id'])) {
            $query->where('projects.sct_id', '=', $filters['subcategory_id']);
        }

        if (!empty($filters['content'])) {
            $query
                ->where('prj_title', 'like', '%' . $filters['content'] . '%')
                ->orWhere('prj_description', 'like', '%' . $filters['content'] . '%');
        }

        if (!empty($filters['skills'])) {
            $query->having('skill_ids', 'like', '%' . $filters['skills'] . '%');
        }

        $projects = $query->get();

        $projects = static::parseSkills($projects);

        return $projects;
    }

    protected static function parseSkills($projects)
    {
        if (!empty($projects)) {
            foreach ($projects as &$project) {
                if (empty($project->skills)) {
                    continue;
                }

                $parsed_skills = [];
                $skills = explode(',', $project->skills);
                foreach ($skills as $skl) {
                    $skl = explode(':', $skl);
                    $parsed_skills[] = [
                        'skl_id'    => $skl[0],
                        'skl_title' => $skl[1],
                    ];
                }

                $project->skills = $parsed_skills;
            }
        }

        return $projects;
    }

    public static function getMinBudget()
    {
        $qb = Di::getDefault()->getQuerybuilder();

        $min_budget = $qb->table('projects')
            ->select([$qb->raw('min(projects.prj_budget) as prj_budget')])
            ->get();

        $min_budget = (int) $min_budget[0]->prj_budget;

        return $min_budget;
    }

    public static function getMaxBudget()
    {
        $qb = Di::getDefault()->getQuerybuilder();

        $max_budget = $qb->table('projects')
            ->select([$qb->raw('max(projects.prj_budget) as prj_budget')])
            ->get();

        $max_budget = (int) $max_budget[0]->prj_budget;

        return $max_budget;
    }
}