<?php

namespace App\Lib;

class Response extends \Phalcon\Http\Response
{
    const ERR_SERVICE = 'ERR_SERVICE';
    const ERR_NOT_FOUND = 'ERR_NOT_FOUND';
    const ERR_ALREADY_EXISTS = 'ERR_ALREADY_EXISTS';
    const ERR_BAD_PARAM = 'ERR_BAD_PARAM';
    const ERR_EMPTY_PARAM = 'ERR_EMPTY_PARAM';
    const ERR_NOT_ACTIVATED = 'ERR_NOT_ACTIVATED';
    const ERR_BAD_SIGN = 'ERR_BAD_SIGN';
    const ERR_NOT_ALLOWED = 'ERR_NOT_ALLOWED';

    public function error($err_code, $http_code = 400, $msg = '')
    {
        if (!defined('self::' . $err_code)) {
            throw new \Exception($err_code . ' - Unknown error code');
        }

        $this->setStatusCode($http_code);

        $this->setJsonContent([
            'error'   => $err_code,
            'message' => $msg
        ])->send();

        exit;
    }

    public function json($data = null)
    {
        $resp = [];
        $resp['data'] = $data;

        $resp['status'] = 'success';

        $this->setJsonContent($resp)->send();
        exit;
    }

}