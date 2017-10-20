<?php

namespace App\Models;

use Phalcon\Mvc\Model;
use App\Models\Clients;
use App\Models\Freelancers;
use Phalcon\Exception;

class Accounts extends Model
{
    public $acc_id;
    public $acc_name;
    public $acc_surname;
    public $acc_login;
    public $acc_email;
    public $acc_password;
    public $acc_verification_key;
    public $acc_is_verified;
    public $acc_created_at;
    public $acc_crypt_pair;

    public static function createAccount($account_data)
    {
        $account = new self();

        $account->acc_name = $account_data['name'];
        $account->acc_surname = $account_data['surname'];
        $account->acc_login = $account_data['login'];
        $account->acc_email = $account_data['email'];
        $account->acc_crypt_pair = $account_data['cryptopair'];
        $account->acc_verification_key = self::makeVerificationKey($account);

        $raw_password = $account_data['password'];

        $account->acc_password = $account->getDi()->getShared('security')->hash($raw_password);

        $account->save();

        if ($account_data['type'] == 'client') {
            Clients::createClient($account->acc_id);
        } elseif ($account_data['type'] == 'freelancer') {
            Freelancers::createFreelancer($account->acc_id);
        }

        return $account;
    }

    protected static function makeVerificationKey($account)
    {
        $key = rand(10000000, 99999999);
        $mailer = $account->getDi()->getShared('mailer');
        $subject = 'Coinlancer verification key';
        $body = 'Verification key is - ' . $key;

//        $mailer->send($account->acc_email, $subject, $body);

        return $key;
    }

    public static function verify($account_id, $verification_key)
    {
        $account = self::findFirst($account_id);

        if ($account->acc_verification_key == $verification_key) {
            $account->acc_is_verified = +true;
            $account->save();

            return $account;
        }

        return false;
    }

    //    public static function getAccount($account_id)
//    {
//        return self::findFirst($account_id);
//    }
//
//    public static function getAccountByNumberAndCurrency($account_number, $currency)
//    {
//        return self::findFirst([
//            "conditions" => "account_number = ?1 AND currency = ?2",
//            "bind"       => [
//                1 => $account_number,
//                2 => $currency
//            ]
//        ]);
//    }
//
//    public static function getCustomerAccounts($customer_id, $currency = null)
//    {
//        if (!empty($currency)) {
//            $condition = [
//                "conditions" => "customer_id = ?1 AND currency = ?2",
//                "bind"       => [
//                    1 => $customer_id,
//                    2 => $currency
//                ]
//            ];
//        } else {
//            $condition = [
//                "conditions" => "customer_id = ?1",
//                "bind"       => [
//                    1 => $customer_id
//                ]
//            ];
//        }
//
//        return self::find($condition);
//    }

}