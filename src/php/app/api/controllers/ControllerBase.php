<?php

namespace App\Controllers;

use \Phalcon\Mvc\Controller;
use App\Lib\Response;

class ControllerBase extends Controller
{
    protected $account_id;
    protected $token_expired_at;

    public function beforeExecuteRoute($dispatcher)
    {
        if (!empty($_SERVER['HTTP_ORIGIN'])) {
            $this->response->setHeader('Access-Control-Allow-Origin', '*');
            $this->response->setHeader('Access-Control-Allow-Credentials', 'true');

            if ($this->request->isOptions()) {
                $this->response->setHeader('Access-Control-Allow-Headers',
                    'Origin, X-Requested-With, X-HTTP-Method-Override, Content-Range, Content-Disposition, Content-Type, Authorization, Geolocation');
                $this->response->setHeader('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, DELETE');
                $this->response->sendHeaders();
                exit;
            }
        }

        //Controllers that do not need a signature (jwt token)
        $free_controllers = ['index', 'nonce'];

        if (!in_array($dispatcher->getControllerName(), $free_controllers)) {

            $allow_routes = [
                'auth/login',
                'auth/register',
                'common/getcategories',
                'projects/index',
                'projects/show',
                'common/getfreelancers',
                'common/getskills',
                'freelancers/show',
                'attachments/get',
            ];

            $current_action = mb_strtolower($dispatcher->getControllerName() . '/' . $dispatcher->getActionName());

            if (!in_array($current_action, $allow_routes)) {
                $jwt = $this->request->getDataFromJWT();

                $userId = $jwt->data->userId ?? null;

                if (!$userId) {
                    return $this->response->error(Response::ERR_BAD_SIGN);
                }

                $this->account_id = intval($userId);
                $this->token_expired_at =  $jwt->exp ?? null;
            }
        }

        return true;
    }

    public function buildUrl($path = null)
    {
        if (!empty($path)) {
            $path = '/' . trim($path, '/');
        }

        return (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $path;
    }

    protected function getPost($required_parameters)
    {
        $request_data = $this->request->getPost();

        foreach ($required_parameters as $parameter) {
            if (!array_key_exists($parameter, $request_data)) {
                return $this->response->error(Response::ERR_EMPTY_PARAM, $parameter);
            }
        }

        return $request_data;
    }

    protected function checkProjectOwner($project_id)
    {
        $project = $this->querybuilder
            ->table('accounts')
            ->select('*')
            ->join('clients', 'clients.acc_id', '=', 'accounts.acc_id')
            ->join('projects', 'projects.cln_id', '=', 'clients.cln_id')
            ->where('accounts.acc_id', $this->account_id)
            ->where('projects.prj_id', $project_id)
            ->get();

        if (!$project) {
            return $this->response->error(Response::ERR_NOT_ALLOWED, 'Not a project owner');
        }

        return true;
    }

    protected function getQuerySkills($skills_string)
    {
        $skills = explode(',', $skills_string);

        foreach ($skills as $key => $skill) {
            $skills[$key] = (int) $skill;
            if ($skills[$key] == 0) {
                unset($skills[$key]);
            }
        }

        sort($skills);

        return implode(",", $skills);
    }

    protected function getProjectIfOwner($project_id)
    {
        $project = $this->querybuilder
            ->table('accounts')
            ->select('*')
            ->join('clients', 'clients.acc_id', '=', 'accounts.acc_id')
            ->join('projects', 'projects.cln_id', '=', 'clients.cln_id')
            ->where('accounts.acc_id', $this->account_id)
            ->where('projects.prj_id', $project_id)
            ->get();

        return reset($project);
    }
}