<?php

use Phalcon\CLI\Task;
use Phalcon\DI;
use App\Models\Projects;

class ProjectsTask extends Task
{
    public function getMinMaxBudgetAction()
    {
        $db = Di::getDefault()->getQuerybuilder();
        $memcached = Di::getDefault()->getMemcached();

        $budgets = $db
            ->table('steps')
            ->select($db->raw('SUM(stp_budget) as budget'))
            ->join('projects', 'projects.prj_id', '=', 'steps.prj_id')
            ->where('projects.prj_status', Projects::STATUS_CREATED)
            ->groupBy('steps.prj_id');

        $min = $db
            ->table($db->subQuery($budgets, 'budgets'))
            ->select($db->raw('MIN(budgets.budget) as budget'))
            ->get();

        $max = $db
            ->table($db->subQuery($budgets, 'budgets'))
            ->select($db->raw('MAX(budgets.budget) as budget'))
            ->get();

        $min = (int) $min[0]->budget;
        $max = (int) $max[0]->budget;

        $memcached->set('minProjectsBudget', $min);
        $memcached->set('maxProjectsBudget', $max);
    }

    public function markExpiredProjectsAction()
    {
        $logger = Di::getDefault()->getLogger();
        $logger->debug('Start markExpiredProjects cli action');
        $expired_projects = Projects::find(
            [
                "conditions" => "prj_status = ?1 AND prj_deadline < ?2",
                "bind"       => [
                    1 => Projects::STATUS_CREATED,
                    2 => date('Y-m-d H:i:s'),
                ]
            ]
        );

        foreach ($expired_projects as $expired_project) {
            $expired_project->prj_status = Projects::STATUS_CANCELED;
            if (!$expired_project->save()) {
                $logger->error('Can not mark as expired project with id ' . $expired_project->prj_id);
                continue;
            }

            $logger->debug('Project with id ' . $expired_project->prj_id  . ' marked as expired');
        }
    }
}
