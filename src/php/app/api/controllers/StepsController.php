<?php

namespace App\Controllers;

use App\Models\Projects;
use App\Models\Steps;
use App\Lib\Response;
use App\Lib\SmartContract;
use Phalcon\Exception;

class StepsController extends ControllerBase
{
    public function indexAction($project_id)
    {
        $steps = Steps::find([
            "conditions" => "prj_id = ?1",
            "bind"       => [1 => $project_id]
        ]);

        return $this->response->json($steps);
    }

    public function createAction($project_id)
    {
        $required_parameters = ['title', 'description', 'budget'];

        $post = $this->getPost($required_parameters);

        $this->checkProjectOwner($project_id);
        $this->checkProjectSuggestion($project_id);

        $step = new Steps;
        $step->prj_id = $project_id;

        $step = $this->saveStep($step, $post);

        return $this->response->json($step);
    }

    public function updateAction($project_id, $id)
    {
        $required_parameters = ['title', 'description', 'budget'];

        $post = $this->getPost($required_parameters);

        $this->checkProjectOwner($project_id);
        $this->checkProjectSuggestion($project_id);

        $step = Steps::findFirst([
            "conditions" => "stp_id = ?1 and prj_id = ?2",
            "bind"       => [
                1 => $id,
                2 => $project_id
            ]
        ]);

        if (!$step) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'step_id & project_id');
        }

        $step = $this->saveStep($step, $post);

        return $this->response->json($step);
    }

    protected function saveStep($step, $post)
    {
        $step->stp_title = $post['title'];
        $step->stp_description = $post['description'];
        $step->stp_budget = $post['budget'];
        $step->save();

        return $step;
    }

    public function deleteAction($project_id, $id)
    {
        $this->checkProjectOwner($project_id);
        $this->checkProjectSuggestion($project_id);

        $step = Steps::findFirst([
            "conditions" => "stp_id = ?1 and prj_id = ?2",
            "bind"       => [
                1 => $id,
                2 => $project_id
            ]
        ]);

        if (!$step) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'step_id & project_id');
        }

        $step->delete();

        return $this->response->json();
    }

    public function depositAction($step_id)
    {
        $step_id = intval($step_id);

        if (empty($step_id)) {
            return $this->response->error(Response::ERR_EMPTY_PARAM, 'step_id');
        }

        $step = Steps::findFirst($step_id);

        if (empty($step)) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'step_id');
        }

        if (!$step->stp_budget) {
            $this->logger->error('Can not deposit step with id - ' . $step_id . ' . Step does not have budget');
            return $this->response->error(Response::ERR_BAD_PARAM, 'step_id');
        }

        $this->checkProjectOwner($step->prj_id);

        if ($step->stp_status != Steps::STATUS_CREATED) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'step');
        }

        if (!$step->stp_budget) {
            $this->logger->error('Can not deposit step with id - ' . $step_id . ' . Step does not have budget');
            return $this->response->error(Response::ERR_BAD_PARAM, 'step_id');
        }

        $client_account = \App\Models\Accounts::findClientByProjectId($step->prj_id);

        if (!$client_account && !$client_account->acc_crypt_address) {
            $this->logger->error('Can not deposit step with id - ' . $step_id . ' . Can not find crypt_address of project owner in DB');
            return $this->response->error(Response::ERR_BAD_PARAM, 'step_id');
        }

        $client_address = $client_account->acc_crypt_address;

        $freelancer_account = \App\Models\Accounts::findFreelancerByProjectId($step->prj_id); // ??

        if (!$freelancer_account && !$freelancer_account->acc_crypt_address) {
            $this->logger->error('Can not deposit step with id - ' . $step_id . ' . Can not find crypt_address of freelancer in DB');
            return $this->response->error(Response::ERR_BAD_PARAM, 'step_id');
        }

        $freelancer_address = $freelancer_account->acc_crypt_address;

        try {
            $smart_contract = new SmartContract();
            $tx_hash = $smart_contract->depositStep($step_id, $client_address, $freelancer_address, $step->stp_budget);
        } catch (\Exception $e) {
            return $this->response->error(Response::ERR_SERVICE, $e->getMessage());
        }

        if ($tx_hash) {
            $step->stp_tx_hash = $tx_hash;
            $step->stp_status = Steps::STATUS_WAIT_DEPOSIT_CONFIRMATION;
        }

        if (!$step->save()) {
            $this->logger->error('Can not save step after deposit [step_id ' . $step_id . ']', $step->getMessages());
            return $this->response->error(Response::ERR_SERVICE);
        }

        return $this->response->json();
    }

    public function markAsDoneAction($step_id)
    {
        $freelancer = \App\Models\Freelancers::findFirstByAccId($this->account_id);

        if (empty($freelancer)) {
            $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $step_id = intval($step_id);

        if (empty($step_id)) {
            return $this->response->error(Response::ERR_EMPTY_PARAM, 'step_id');
        }

        $step = Steps::findFirst($step_id);

        if (empty($step)) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'step_id');
        }

        if ($step->stp_status != Steps::STATUS_DEPOSITED) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'step');
        }

        $suggestion = \App\Models\ProjectsFreelancers::findFirst([
            "conditions" => "prj_id = ?1 and frl_id = ?2 and prf_is_hired = 1",
            "bind" => [1 => $step->prj_id, 2 => $freelancer->frl_id]
        ]);

        if (empty($suggestion)) {
            $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $step->stp_status = Steps::STATUS_MARK_AS_DONE;

        if (!$step->save()) {
            $this->logger->error('Can not save step after deposit [step_id ' . $step_id . ']', $step->getMessages());

            return $this->response->error(Response::ERR_SERVICE);
        }

        return $this->response->json();
    }

    public function markAsCompletedAction($step_id)
    {
        $step_id = intval($step_id);

        if (empty($step_id)) {
            return $this->response->error(Response::ERR_EMPTY_PARAM, 'step_id');
        }

        $step = Steps::findFirst($step_id);

        if (empty($step)) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'step_id');
        }

        $project = $this->getProjectIfOwner($step->prj_id);

        if (empty($project)) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        if ($step->stp_status != Steps::STATUS_MARK_AS_DONE) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'step');
        }

        try {
            $smart_contract = new SmartContract();
            $result = $smart_contract->payStep($step_id);
        } catch (Exception $e) {
            $this->logger->error('Can not pay step after deposit [step_id ' . $step_id . ']', $step->getMessages());

            return $this->response->error(Response::ERR_SERVICE);
        }

        if ($result) {
            $step->stp_status = Steps::STATUS_COMPLETED;
        }

        if (!$step->save()) {
            $this->logger->error('Can not save step after deposit [step_id ' . $step_id . ']', $step->getMessages());

            return $this->response->error(Response::ERR_SERVICE);
        }

        if (self::isAllStepsFinished($step->prj_id)) {
            $project = \App\Models\Projects::findFirst($step->prj_id);
            $project->prj_status = Projects::STATUS_COMPLETED;

            if (!$project->save()) {
                $this->logger->error('Can not save project complete status after deposit [step_id ' . $step_id . ']', $project->getMessages());
            }
        }

        return $this->response->json();
    }

    public function refundAction($step_id)
    {
        $step_id = intval($step_id);

        if (empty($step_id)) {
            return $this->response->error(Response::ERR_EMPTY_PARAM, 'step_id');
        }

        $step = Steps::findFirst($step_id);

        if (empty($step)) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'step_id');
        }

        $project = $this->getProjectIfOwner($step->prj_id);

        if (empty($project)) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        if ($step->stp_status != Steps::STATUS_DEPOSITED) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'step');
        }

        if (time() < strtotime($project->prj_deadline)) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        try {
            $smart_contract = new SmartContract();
            $result = $smart_contract->refundStep($step_id);
        } catch (Exception $e) {
            $this->logger->error('Can not pay step after deposit [step_id ' . $step_id . ']', $step->getMessages());

            return $this->response->error(Response::ERR_SERVICE);
        }

        if ($result) {
            $step->stp_status = Steps::STATUS_REFUNDED;
        }

        if (!$step->save()) {
            $this->logger->error('Can not save step after deposit [step_id ' . $step_id . ']', $step->getMessages());

            return $this->response->error(Response::ERR_SERVICE);
        }

//        if (self::isAllStepsFinished($step->prj_id)) {
            $project = \App\Models\Projects::findFirst($step->prj_id);
            $project->prj_status = Projects::STATUS_CANCELED;

            if (!$project->save()) {
                $this->logger->error('Can not save project canceled status after deposit [step_id ' . $step_id . ']', $project->getMessages());
            }
//        }

        return $this->response->json();
    }

    protected function checkProjectSuggestion($project_id)
    {
        $suggestion = \App\Models\ProjectsFreelancers::find(['conditions' => "prj_id = '" . $project_id . "'"])->toArray();

        if (!empty($suggestion)) {
            $this->logger->error('Can not add or edit or delete step. Project ' . $project_id . ' has already suggestion');

            return $this->response->error(Response::ERR_NOT_ALLOWED, 'Current project has already suggestion');
        }
    }

    protected function isAllStepsFinished($project_id) {
        $project_id = intval($project_id);
        $steps = Steps::find(
            [
                'conditions' => "prj_id = ?1 AND stp_status NOT IN (?2, ?3)",
                'bind' => [
                    1 => $project_id,
                    2 => Steps::STATUS_COMPLETED,
                    3 => Steps::STATUS_REFUNDED
                ]
            ]
        );

        return !count($steps);
    }
}
