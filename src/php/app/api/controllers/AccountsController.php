<?php

namespace App\Controllers;

use App\Models\Accounts;
use App\Lib\Response;

class AccountsController extends ControllerBase
{
    public function showAction($id = null)
    {
        $id ?: $id = $this->account_id;

        $account = Accounts::findFirst($id);

        if (!$account) {
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        $account = Accounts::makePublic($account);

        return $this->response->json($account);
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

        if (!$freelancer->save()) {
            return $this->response->error(Response::ERR_SERVICE);
        }

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

        if (!$client->save()) {
            return $this->response->error(Response::ERR_SERVICE);
        }

        return true;
    }

    public function updateAction()
    {
        $required_parameters = ['name', 'surname', 'description', 'phone', 'skype'];

        $post = $this->getPost($required_parameters);

        $account = Accounts::findFirst($this->account_id);

        if (!$account) {
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        $account->acc_name = $post['name'];
        $account->acc_surname = $post['surname'];
        $account->acc_description = $post['description'];
        $account->acc_phone = $post['phone'];
        $account->acc_skype = $post['skype'];

        if (!$account->save()) {
            $this->logger->error('Can not update account with id - ' . $this->account_id);

            return $this->response->error(Response::ERR_SERVICE);
        }

        return $this->response->json();
    }

    public function updatePasswordAction()
    {
        $required_parameters = ['password', 'new_password', 'crypt_pair'];

        $post = $this->getPost($required_parameters);

        $account = Accounts::findFirst($this->account_id);

        if (!$account) {
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        if (!$this->security->checkHash($post['password'], $account->acc_password)) {
            $this->logger->error('Can not change password. account_id = ' . $this->account_id . '. Incorrect old password');

            return $this->response->error(Response::ERR_BAD_PARAM, 'Incorrect old password');
        }

        $account->acc_password = $this->security->hash($post['new_password']);
        $account->acc_crypt_pair = $post['crypt_pair'];

        if (!$account->save()) {
            $this->logger->error('Can not update password for account_id - ' . $this->account_id);

            return $this->response->error(Response::ERR_SERVICE);
        }

        return $this->response->json();
    }
}
