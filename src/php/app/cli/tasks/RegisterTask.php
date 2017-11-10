<?php

use Phalcon\CLI\Task;
use Phalcon\DI;
use App\Models\Accounts;

class RegisterTask extends Task
{
    public function sendMailAction()
    {
//        $accounts = Accounts::find("acc_is_email_sent = 0");
//
//        $mailer = DI::getDefault()->getMailer();
//        $logger = DI::getDefault()->getLogger();
//
//        $count = count($accounts);
//
//        $emails = "";
//        $success = 0;
//
//        foreach ($accounts as $account) {
//            try {
//                $body = [
//                    'verification_code', ['code'   => $account->acc_verification_key]
//                ];
//
//                if (!$mailer->send($account->acc_email, 'Coinlancer', $body)) {
//                    $logger->error("Try to send verification key for " . $count . " accounts. Successfully sent to - " . $success . " emails. Can not send to " . ($count - $success) . " emails: " . $emails);
//                }
//
//                $account->acc_is_email_sent = 1;
//                $account->save();
//
//                $success++;
//            } catch (\Exception $e) {
//                $emails .= $account->acc_email . " (" . $e->getMessage() . ") -----------   ";
//            }
//        }
//
//        if ($emails) {
//            $logger->error("Try to send verification key for " . $count . " accounts. Successfully sent to - " . $success . " emails. Can not send to " . ($count - $success) . " emails: " . $emails);
//        }
    }
}
