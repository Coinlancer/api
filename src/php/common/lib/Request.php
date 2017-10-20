<?php

namespace App\lib;
use Phalcon\DI;
use \Firebase\JWT\JWT;

class Request extends \Phalcon\Http\Request
{
    const TOKEN = 'Authorization';

    /**
     * @var Account Id of request initiator
     */
    protected $accountId;

//    //TEMPORARY TEST HACK!!!!!!!!
//    public function __construct()
//    {
//        //parent::__construct();
//        $this->accountId = 'GAWIB7ETYGSWULO4VB7D6S42YLPGIC7TY7Y2SSJKVOTMQXV5TILYWBUA';
//    }

    /**
     * return data from auth token
     * @return array|bool
     */
    public function getDataFromJWT()
    {
        $token = $this->getHeader(self::TOKEN);

        if (empty($token)) {
            return false;
        }

        try {
            $config = DI::getDefault()->getConfig();

            /*
             * decode the jwt using the key from config
             */

            list($jwt) = sscanf($token, 'Bearer %s');
//            var_dump($jwt); die;
            $payload = JWT::decode($jwt, $config->jwt->secret, array($config->jwt->algo));

            return $payload;
        } catch (\Exception $e) {
            //todo use logger service

            return false;
        }
    }
}