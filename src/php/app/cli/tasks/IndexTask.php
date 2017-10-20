<?php


use App\Models\Accounts;
use App\Models\PhysResidentForms;
use App\Models\Customers;
use App\Models\Transactions;
use Phalcon\CLI\Task;
use Phalcon\DI;

class IndexTask extends Task
{
    public function transactionsHandlerAction()
    {
        $txs = Transactions::getUnhandledTxs();
        foreach ($txs as $tx) {
            Transactions::handleTx($tx->id);
        }
    }

    public function acceptPhysResidentFormsAction()
    {
        $forms = PhysResidentForms::getUnhandledForms();

        foreach ($forms as $form) {
            if (PhysResidentForms::acceptForm($form->id)) {
                $customer = Customers::getCustomerByPublicKey($form->public_key);
                Accounts::createAccount($customer->id, 'UAH');
                Accounts::createAccount($customer->id, 'UAH');
                Accounts::createAccount($customer->id, 'UAH');
            }
        }
    }
}
