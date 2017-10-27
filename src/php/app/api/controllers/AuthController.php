<?php

namespace App\Controllers;

use App\Lib\Response;
use Phalcon\DI;
use App\Models\Accounts;


class AuthController extends ControllerBase
{
    public function registerAction()
    {
        $account_data = $this->request->getPost();
        $account = Accounts::createAccount($account_data);
        $account = Accounts::findFirst(intval($account->acc_id));

        $sent = $this->mailer->send($account->acc_email, 'Coinlancer',
            [
                'verification_code',
                [
                    'code'   => $account->acc_verification_key,
                ]
            ]);

        if (!$sent) {
            $this->logger->critical('Cannot send email to (' . $account->acc_email . ')');
        }

        $token = $this->createToken($account->acc_id);

        $account = Accounts::getPublicAccount($account->acc_id);

        return $this->response->json(['account' => $account, 'token' => $token]);
    }

    public function verifyAction()
    {
        $verification_key = $this->request->getPost('verification_key');

        $is_verified = Accounts::verify($this->account_id, $verification_key);

        if (!$is_verified) {
            //todo logger
            return $this->response->error(Response::ERR_SERVICE);
        }

        return $this->response->json(['status' => 'verified']);
    }

    public function loginAction()
    {
        $email = $this->request->getPost('email');
        $raw_password = $this->request->getPost('password');

        $account = Accounts::findFirst([
            "conditions" => "acc_email = ?1",
            "bind" => [1 => $email]
        ]);

        if (!$account) {
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        if (!$this->security->checkHash($raw_password, $account->acc_password)) {
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        $token = $this->createToken($account->acc_id);

        $account = Accounts::getPublicAccount($account->acc_id);

        return $this->response->json(['account' => $account, 'token' => $token]);
    }
}
