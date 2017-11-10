<?php

use Phalcon\CLI\Task;
use Phalcon\DI;
use App\Models\Steps;
use App\Lib\SmartContract;

class TransactionTask extends Task
{
    public function checkConfirmationsAction()
    {
        $steps = Steps::find('stp_status = ' . Steps::STATUS_WAIT_DEPOSIT_CONFIRMATION);

        $smart_contract = new SmartContract();
        $logger = DI::getDefault()->getLogger();
        $config = DI::getDefault()->getConfig();

        foreach ($steps as $step) {
            try {
                $confirmations_number = $smart_contract->getConfirmationsByTxHash($step->stp_tx_hash);

                if ($confirmations_number >= $config->min_confirmations) {
                    $step->stp_status = Steps::STATUS_DEPOSITED;

                    if (!$step->save()) {
                        $logger->error('Bot returned successful TransactionConfirmations for step - ' . $step->stp_id . ' , but can not save result in DB.');
                    }
                }

            } catch (\Exception $e) {
                $logger->error('Error while bot checked for TransactionConfirmations for step - ' . $step->stp_id . $e->getMessage());
            }
        }
    }
}
