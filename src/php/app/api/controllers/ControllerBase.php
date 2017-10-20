<?php

namespace App\Controllers;

use App\Lib\User;
use App\Lib\Response;
use \Firebase\JWT\JWT;

class ControllerBase extends \Phalcon\Mvc\Controller
{
    protected $account_id;
    protected $token_expired_at;

    public function beforeExecuteRoute($dispatcher)
    {
        if (!empty($_SERVER['HTTP_ORIGIN'])) {
            $this->response->setHeader('Access-Control-Allow-Origin', $_SERVER['HTTP_ORIGIN']);
            $this->response->setHeader('Access-Control-Allow-Credentials', 'true');

            if ($this->request->isOptions()) {
                $this->response->setHeader('Access-Control-Allow-Headers',
                    'Origin, X-Requested-With, X-HTTP-Method-Override, Content-Range, Content-Disposition, Content-Type, Authorization, Geolocation');
                $this->response->setHeader('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, DELETE');
                $this->response->sendHeaders();
                exit;
            }
        }

        //Controllers that do not need a signature
        $free_controllers = ['index', 'nonce'];

        if (!in_array($dispatcher->getControllerName(), $free_controllers)) {

            $allow_routes = [
                'auth/login',
                'auth/register'
            ];

            $current_action = mb_strtolower($dispatcher->getControllerName() . '/' . $dispatcher->getActionName());

            if (!in_array($current_action, $allow_routes)) {
                $jwt = $this->request->getDataFromJWT();

                $userId = $jwt->data->userId ?? null;

                if (!$userId) {
                    return $this->response->error(Response::ERR_BAD_SIGN);
                }

                $this->account_id = $userId;
                $this->token_expired_at =  $jwt->exp ?? null;
            }
        }

        return true;
    }

    public function createToken($userId)
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
                'userId'   => $userId // userid from the users table
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
        $jwt = JWT::encode(
            $data,      //Data to be encoded in the JWT
            $secretKey, // The signing key
            $algo     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
        );

        return $jwt;
    }

    public function buildUrl($path = null)
    {
        if (!empty($path)) {
            $path = '/' . trim($path, '/');
        }

        return (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $path;
    }
}