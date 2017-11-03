<?php

namespace App\Controllers;

use App\Lib\Response;

class SuggestionsController extends ControllerBase
{
    public function indexAction($id)
    {
        $suggestions = \App\Models\ProjectsFreelancers::find([
            "conditions" => "prj_id = ?1",
            "bind" => [1 => $id]
        ]);

        return $this->response->json($suggestions);
    }

    public function createAction($project_id)
    {
        $required_parameters = ['price', 'hours', 'message'];

        $post = $this->getPost($required_parameters);

        $freelancer = \App\Models\Freelancers::findFirst([
            "conditions" => "acc_id = ?1",
            "bind" => [1 => $this->account_id]
        ]);

        if (!$freelancer) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $this->checkOwnProject($project_id);

        $data = [
            'prj_id' => $project_id,
            'frl_id' => $freelancer->frl_id,
            'prf_price' => $post['price'],
            'prf_hours' => $post['hours'],
            'prf_message' => $post['message']
        ];

        try {
            $this->querybuilder
                ->table('projects_freelancers')
                ->insert($data);
        } catch (\Exception $e) {
            $message = 'Cannot create suggestion from account_id - ' . $this->account_id . ' . project_id - ' . $project_id
                . ' , message - ' . $e->getMessage();
            $this->logger->error($message);
            return $this->response->error(Response::ERR_BAD_PARAM);
        }

        return $this->response->json();
    }

    public function deleteAction($project_id)
    {
        $freelancer = \App\Models\Freelancers::findFirst([
            "conditions" => "acc_id = ?1",
            "bind" => [1 => $this->account_id]
        ]);

        if (!$freelancer) {
            $this->logger->error('Can not delete suggestion. Not a freelancer');
            return $this->response->error(Response::ERR_NOT_ALLOWED, 'Not a freelancer');
        }

        $suggestion = \App\Models\ProjectsFreelancers::findFirst([
            "conditions" => "prj_id = ?1 and frl_id = ?2 and prf_is_hired = 0",
            "bind" => [1 => $project_id, 2 => $freelancer->frl_id]
        ]);

        if (!$suggestion) {
            $this->logger->error('Can not delete suggestion. Current account (freelancer) doesnot have suggestion');
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        $suggestion->delete();

        return $this->response->json();
    }

    public function confirmAction()
    {
        $project_id = intval($this->request->getPost('project_id'));
        $freelancer_id = intval($this->request->getPost('freelancer_id'));

        if (empty($project_id)) {
            return $this->response->error(Response::ERR_EMPTY_PARAM, 'project_id');
        }

        if (empty($freelancer_id)) {
            return $this->response->error(Response::ERR_EMPTY_PARAM, 'freelancer_id');
        }

        $project = \App\Models\Projects::findFirst([
            "conditions" => "prj_id = ?1",
            "bind"       => [1 => $project_id]
        ]);

        if (empty($project)) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'project_id');
        }

        $project_owner = \App\Models\Clients::findFirst([
            "conditions" => "cln_id = ?1",
            "bind"       => [1 => $project->cln_id]
        ]);

        if (empty($project_owner)) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        if ($project_owner->acc_id !== $this->account_id) {
            return $this->response->error(\App\Lib\Response::ERR_NOT_ALLOWED);
        }

        $suggestion = \App\Models\ProjectsFreelancers::findFirst([
            "conditions" => "prj_id = ?1 and frl_id = ?2 and prf_is_hired = 0",
            "bind" => [1 => $project_id, 2 => $freelancer_id]
        ]);

        if (empty($suggestion)) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'freelancer_id');
        }

        $suggestion->prf_is_hired = 1;
        $suggestion->prf_updated_at = date("Y-m-d H:i:s");

        if (!$suggestion->save()) {
            $this->logger->error('Can not update suggestion.', $suggestion->getMessages());

            return $this->response->error(Response::ERR_SERVICE);
        }

        return $this->response->json($suggestion);
    }

    protected function checkOwnProject($project_id)
    {
        $account = $this->querybuilder
            ->table('projects')
            ->select('*')
            ->join('clients', 'clients.cln_id', '=', 'projects.cln_id')
            ->join('accounts', 'accounts.acc_id', '=', 'clients.acc_id')
            ->where('projects.prj_id', $project_id)
            ->get();

        if (!empty($account[0]) &&  $account[0]->acc_id == $this->account_id) {
            return $this->response->error(Response::ERR_NOT_ALLOWED, 'Try to suggest to own project');
        }
    }
}
