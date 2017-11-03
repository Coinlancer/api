<?php

namespace App\Models;

use Phalcon\DI;
class Accounts extends ModelBase
{
    public static function createAccount($post)
    {
        $account = new self();

        $account->acc_name = $post['name'];
        $account->acc_surname = $post['surname'];
        $account->acc_login = $post['login'];
        $account->acc_email = $post['email'];
        $account->acc_crypt_address = $post['crypt_address'];
        $account->acc_crypt_pair = $post['crypt_pair'];
        $account->acc_verification_key = rand(10000000, 99999999);

        $raw_password = $post['password'];

        $account->acc_password = $account->getDi()->getShared('security')->hash($raw_password);

        $account->save();

        if ($post['type'] == 'client') {
            Clients::createClient($account->acc_id);
        } else {
            Freelancers::createFreelancer($account->acc_id);
        }

        return $account;
    }

    public static function verify($account_id, $verification_key)
    {
        $account = self::findFirst($account_id);

        if ($account->acc_verification_key == $verification_key) {
            $account->acc_is_verified = 1;
            $account->save();

            return true;
        }

        throw new \Exception('Verification account error');
    }

    public static function makePublic($account)
    {
        $account = $account->toArray();

        unset($account['acc_password']);
        unset($account['acc_verification_key']);

        $account['cln_id'] = null;
        $account['frl_id'] = null;

        $client = Clients::findFirstByAccId($account['acc_id']);

        if ($client) {
            $account['cln_id'] = $client->cln_id;
        }

        $freelancer = Freelancers::findFirstByAccId($account['acc_id']);

        if ($freelancer) {
            $account['frl_id'] = $freelancer->frl_id;

            $querybuilder = DI::getDefault()->getQuerybuilder();

            $skills = $querybuilder
                ->table('skills')
                ->select(['skills.*'])
                ->join('skills_freelancers', 'skills.skl_id', '=', 'skills_freelancers.skl_id')
                ->join('freelancers', 'freelancers.frl_id', '=', 'skills_freelancers.frl_id')
                ->where('freelancers.frl_id', $freelancer->frl_id)
                ->get();

            $account['skills'] = $skills;
        }



        return $account;
    }

    public static function checkUniqueBy($parameter, $value)
    {
        $account_exists = self::findFirst([
            'conditions' => 'acc_' . $parameter . ' = ?1',
            'bind' => [
                1 => $value
            ]
        ]);

        if ($account_exists) {
            return false;
        }

        return true;
    }

//    public static function getPublicAccount($account_id)
//    {
//        $account = self::findFirst($account_id);
//
//        if (!$account) {
//            return false;
//        }
//
//        $account = self::sanitise($account);
//
//        $account = $account->toArray();
//
//        $account['cln_id'] = null;
//        $account['frl_id'] = null;
//
//        $client = Clients::findFirstByAccId($account['acc_id']);
//
//        if ($client) {
//            $account['cln_id'] = $client->cln_id;
//        }
//
//        $freelancer = Freelancers::findFirstByAccId($account['acc_id']);
//
//        if ($freelancer) {
//            $account['frl_id'] = $freelancer->frl_id;
//        }
//
//        return $account;
//    }


//    public static function sanitise($account)
//    {
//        unset($account->acc_password);
//        unset($account->acc_verification_key);
//
//        return $account;
//    }

}