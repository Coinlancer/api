<?php

namespace App\Controllers;

use App\Lib\Response;
use App\Models\Accounts;

class AuthController extends ControllerBase
{
    public function registerAction()
    {
        $required_parameters = ['name', 'surname', 'login', 'email', 'crypt_address', 'crypt_pair', 'password', 'type'];

        $post = $this->getPost($required_parameters);

        $is_unique_login = Accounts::checkUniqueBy('login', $post['login']);

        if (!$is_unique_login) {
            return $this->response->error(Response::ERR_ALREADY_EXISTS, 'login');
        }

        $is_unique_email = Accounts::checkUniqueBy('email', $post['email']);

        if (!$is_unique_email) {
            return $this->response->error(Response::ERR_ALREADY_EXISTS, 'email');
        }

        try {
            $account = Accounts::createAccount($post);
        } catch (\Exception $e) {
            $this->logger->critical('Can not register account with email ' . $post['email'] . ' .' . $e->getMessage());

            return $this->response->error(Response::ERR_SERVICE);
        }

        try {
            $this->sendVerificationKey($account);
            $account->acc_is_email_sent = 1;
            $account->save();
        } catch (\Exception $e) {
            $this->logger->critical('Can not send email to ' . $account->acc_email . ' while registering user. ' . $e->getMessage());
        }

        $token = $this->createJwt($account->acc_id);

        $account = Accounts::makePublic($account);

        return $this->response->json(['account' => $account, 'token' => $token]);
    }

    public function verifyAction()
    {
        $required_parameters = ['verification_key'];

        $post = $this->getPost($required_parameters);

        $account = Accounts::findFirst($this->account_id);

        if (!$account) {
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        if ($account->acc_verification_key !== $post['verification_key']) {
            $this->logger->critical('Cannot verify account with id - ' . $this->account_id . ' Incorrect verification key');

            return $this->response->error(Response::ERR_SERVICE, 'Cannot verify. Incorrect verification key');
        }

        $account->acc_is_verified = 1;

        if (!$account->save()) {
            $this->logger->critical('Can not save is_verified into DB for account with id - ' . $this->account_id);

            return $this->response->error(Response::ERR_SERVICE);
        }

        return $this->response->json();
    }

    public function loginAction()
    {
        $required_parameters = ['identificator', 'password'];

        $post = $this->getPost($required_parameters);

        $account = Accounts::findFirst([
            "conditions" => "acc_email = ?1 or acc_login = ?2",
            "bind" => [
                1 => $post['identificator'],
                2 => $post['identificator']
            ]
        ]);

        if (!$account) {
            return $this->response->error(Response::ERR_NOT_FOUND, 'account');
        }

        if (!$this->security->checkHash($post['password'], $account->acc_password)) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'password');
        }

        $token = $this->createJwt($account->acc_id);

        $account = Accounts::makePublic($account);

        return $this->response->json(['account' => $account, 'token' => $token]);
    }

    protected function sendVerificationKey($account)
    {
        $this->mailer->send($account->acc_email, 'Coinlancer',
            [
                'verification_code',
                [
                    'code'   => $account->acc_verification_key,
                ]
            ]);

        return true;
    }

    protected function createJwt($account_id)
    {
        $tokenId    = base64_encode(openssl_random_pseudo_bytes(32));
        $issuedAt   = $notBefore = time();
        $expire     = $notBefore + $this->config->jwt->ttl;
        $serverName = 'test';

        $data = [
            'iat'  => $issuedAt,         // Issued at: time when the token was generated
            'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
            'iss'  => $serverName,       // Issuer
            'nbf'  => $notBefore,        // Not before
            'exp'  => $expire,           // Expire
            'data' => [                  // Data related to the signer user
                'userId'   => $account_id // $account_id from accounts table
            ]
        ];

        $secretKey = $this->config->jwt->secret;
        $algo = $this->config->jwt->algo;

        /*
         * Encode the array to a JWT string.
         * Second parameter is the key to encode the token.
         *
         * The output string can be validated at http://jwt.io/
         */
        $jwt = \Firebase\JWT\JWT::encode(
            $data,      //Data to be encoded in the JWT
            $secretKey, // The signing key
            $algo     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        );

        return $jwt;
    }
}
