<?php

namespace App\Controllers;

use App\Models\Accounts;
use App\Lib\Response;

class AccountsController extends ControllerBase
{
    public function showAction($id = null)
    {
        $id ?: $id = $this->account_id;

        $public_account = Accounts::getPublicAccount($id);

        if (!$public_account) {
            return $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        return $this->response->json($public_account);
    }

    public function activateRoleAction()
    {
        $role = $this->request->getPost('role');

        $status = null;

        if ($role == 'client') {
            $status = $this->activateClientRole();
        }
        if ($role == 'freelancer') {
            $status = $this->activateFreelancerRole();
        }

        if (!$status) {
            return $this->response->error(Response::ERR_BAD_PARAM);
        }

        return $this->response->json();
    }

    protected function activateFreelancerRole()
    {
        $freelancer = \App\Models\Freelancers::findFirstByAccId($this->account_id);

        if ($freelancer) {
            $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $freelancer = new \App\Models\Freelancers;

        $freelancer->acc_id = $this->account_id;
        $freelancer->save();

        return true;
    }

    protected function activateClientRole()
    {
        $client = \App\Models\Clients::findFirstByAccId($this->account_id);

        if ($client) {
            $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $client = new \App\Models\Clients;

        $client->acc_id = $this->account_id;
        $client->save();

        return true;
    }
}
