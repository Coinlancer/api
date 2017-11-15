<?php

namespace App\Lib;

use Exception;

class SmartContract
{
    protected $base_url;

    public function __construct()
    {
        $this->base_url = getenv('SCBOT_HOST');
    }

    public function depositStep($step_id, $client_address, $freelancer_address, $step_budget)
    {
        $parameters = [
            'step'   => $step_id,
            'from'   => $client_address,
            'to'     => $freelancer_address,
            'amount' => bcmul($step_budget, bcpow(10, 18))
        ];

        error_log(print_r($parameters, 1));

        $response = $this->makeRequest('/deposit', $parameters);

        if (empty($response) || empty($response['tx_hash'])) {
            throw new Exception('Deposit method does not return tx_hash in response');
        }

        return $response['tx_hash'];
    }

    public function getConfirmationsByTxHash($tx_hash)
    {
        $parameters['tx'] = $tx_hash;

        $response = $this->makeRequest('/confirmations', $parameters);

        if (empty($response) || !isset($response['confirmations'])) {
            throw new Exception('getConfirmationsByTxHash does not return confirmations in response');
        }

        return $response['confirmations'];
    }

    public function payStep($step_id)
    {
        $parameters = ['step' => $step_id];

        $response = $this->makeRequest('/pay', $parameters); // must be some array result

        if (empty($response) || !isset($response['tx_hash'])) {
            throw new Exception('Pay method does not return tx_hash in response');
        }

        return $response['tx_hash'];
    }

    public function refundStep($step_id)
    {
        $parameters = ['step' => $step_id];

        $response = $this->makeRequest('/refund', $parameters); // must be some array result

        if (empty($response) || !isset($response['tx_hash'])) {
            throw new Exception('Refund method does not return tx_hash in response');
        }

        return $response['tx_hash'];
    }

    protected function makeRequest($url, $parameters)
    {
        $url = $this->base_url . '/' . ltrim($url, '/');
        $username = getenv('SCBOT_USERNAME');
        $password = getenv('SCBOT_PASSWORD');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . base64_encode($username . ':' . $password),
            'Content-type: application/x-www-form-urlencoded'
        ]);

        $resp = curl_exec($ch);
        $err = curl_error($ch);

        curl_close($ch);

        if ($resp === false || !empty($err)) {
            error_log($resp);
            error_log($err);
            throw new Exception('cURL error: ' . $err);
        }

        $resp = json_decode($resp, true);

        if (empty($resp)) {
            throw new Exception('Unable to parse response result (' . json_last_error() . ')');
        }

        return $resp;
    }

}