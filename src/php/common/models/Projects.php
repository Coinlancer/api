<?php

namespace App\Models;

use Phalcon\Di;

class Projects extends ModelBase
{
    public static function getExtended(array $filters = [])
    {
        $config = Di::getDefault()->getConfig();

        $filters['limit'] ?: $filters['limit'] = $config->filters->limit;
        $filters['offset'] ?: $filters['offset'] = $config->filters->offset;

        $qb = Di::getDefault()->getQuerybuilder();
        $query = $qb
            ->table('projects')
            ->select([
                'projects.prj_id',
                'projects.prj_title',
                'projects.prj_description',
                'projects.prj_budget',
                'projects.prj_deadline',
                'projects.prj_created_at',
                'accounts.acc_id',
                'accounts.acc_name',
                'accounts.acc_surname',
                $qb->raw('GROUP_CONCAT(DISTINCT concat(skills.skl_id, ":", skills.skl_title) SEPARATOR ",") as skills'),
            ])
            ->join('clients', 'clients.cln_id', '=', 'projects.cln_id')
            ->join('accounts', 'clients.acc_id', '=', 'accounts.acc_id')
            ->leftJoin('projects_skills', 'projects_skills.prj_id', '=', 'projects.prj_id')
            ->leftJoin('skills', 'projects_skills.skl_id', '=', 'skills.skl_id')
            ->groupBy('projects.prj_id')
            ->limit($filters['limit'])
            ->offset($filters['offset']);
        ;

        if (!empty($filters['acc_id'])) {
            $query->where('accounts.acc_id', $filters['acc_id']);
        }

        $projects = $query->get();

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