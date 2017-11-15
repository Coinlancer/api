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

        $filters['limit'] ?: $filters['limit'] = $config->filters->limit;
        $filters['offset'] ?: $filters['offset'] = $config->filters->offset;

        $db = Di::getDefault()->getQuerybuilder();

        $budget_sums = $db
            ->table('steps')
            ->select([
                'prj_id',
                $db->raw('SUM(steps.stp_budget) as prj_budget')
            ])
            ->groupBy('steps.prj_id');

        $query = $db
            ->table('projects')
            ->select([
                'projects.*',
                'accounts.acc_id',
                'accounts.acc_name',
                'accounts.acc_surname',
                'budgets.prj_budget',
                $db->raw('GROUP_CONCAT(DISTINCT skills.skl_id, ":", skills.skl_title) as skills'),
                $db->raw('GROUP_CONCAT(\'|\', projects_skills.skl_id , \'|\') as skill_ids')
            ])
            ->join('clients', 'clients.cln_id', '=', 'projects.cln_id')
            ->join('accounts', 'clients.acc_id', '=', 'accounts.acc_id')
            ->leftJoin('projects_skills', 'projects_skills.prj_id', '=', 'projects.prj_id')
            ->leftJoin('skills', 'projects_skills.skl_id', '=', 'skills.skl_id')
            ->leftJoin($db->subQuery($budget_sums, 'budgets'), 'projects.prj_id', '=', 'budgets.prj_id')
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

        if (!empty($filters['subcategory_id'])) {
            $query->where('projects.sct_id', '=', $filters['subcategory_id']);
        }

        if (!empty($filters['content'])) {
            $query
                ->where('prj_title', 'like', '%' . $filters['content'] . '%')
                ->orWhere('prj_description', 'like', '%' . $filters['content'] . '%');
        }

        if (!empty($filters['deadline_from']) && intval($filters['deadline_from'])) {
            $query
                ->where('projects.prj_deadline', '>', date('Y-m-d H:i:s', strtotime('+ ' . intval($filters['deadline_from']) . ' days')));
        }

        if (!empty($filters['deadline_to']) && intval($filters['deadline_to'])) {
            $query
                ->where('projects.prj_deadline', '<', date('Y-m-d H:i:s', strtotime('+ ' . intval($filters['deadline_to']) . ' days')));
        }

        if (!empty($filters['skills'])) {
            $skills = "%";

            foreach ($filters['skills'] as $skill) {
                $skills .= '|' . $skill . '|' . '%';
            }

            $query->having('skill_ids', 'like', $skills);
        }

        if (!empty($filters['min_budget'])) {
            $query->having('budgets.prj_budget', '>=', $filters['min_budget']);
        }

        if (!empty($filters['max_budget'])) {
            $query->having('budgets.prj_budget', '<=', $filters['max_budget']);
        }

        $projects = $query->get();

        $projects = static::parseSkills($projects);

        return $projects;
    }

    protected static function getDeadline($days)
    {
        $deadline = new \DateTime();
        $deadline->add(new \DateInterval('P' . $days . 'D'));

        return $deadline->format('Y-m-d H:i:s');
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
}