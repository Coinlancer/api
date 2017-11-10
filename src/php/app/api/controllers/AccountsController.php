<?php

namespace App\Controllers;

use App\Models\Accounts;
use App\Lib\Response;

class AccountsController extends ControllerBase
{
    public function showAction($id = null)
    {
        $id ?: $id = $this->account_id;

        $account = Accounts::findFirst($id);

        if (!$account) {
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        $account = Accounts::makePublic($account);

        return $this->response->json($account);
    }

    public function activateRoleAction()
    {
        $role = $this->request->getPost('role');

        $status = null;

        if ($role == 'client') {
            $status = $this->activateClientRole();
        }
        if ($role == 'freelancer') {
            $status = $this->activateFreelancerRole();
        }

        if (!$status) {
            return $this->response->error(Response::ERR_BAD_PARAM);
        }

        return $this->response->json();
    }

    protected function activateFreelancerRole()
    {
        $freelancer = \App\Models\Freelancers::findFirstByAccId($this->account_id);

        if ($freelancer) {
            $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $freelancer = new \App\Models\Freelancers;

        $freelancer->acc_id = $this->account_id;

        if (!$freelancer->save()) {
            return $this->response->error(Response::ERR_SERVICE);
        }

        return true;
    }

    protected function activateClientRole()
    {
        $client = \App\Models\Clients::findFirstByAccId($this->account_id);

        if ($client) {
            $this->response->error(Response::ERR_NOT_ALLOWED);
        }

        $client = new \App\Models\Clients;

        $client->acc_id = $this->account_id;

        if (!$client->save()) {
            return $this->response->error(Response::ERR_SERVICE);
        }

        return true;
    }

    public function updateAction()
    {
        $required_parameters = ['name', 'surname', 'description', 'phone', 'skype'];

        $post = $this->getPost($required_parameters);

        $account = Accounts::findFirst($this->account_id);

        if (!$account) {
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        $account->acc_name = $post['name'];
        $account->acc_surname = $post['surname'];
        $account->acc_description = $post['description'];
        $account->acc_phone = $post['phone'];
        $account->acc_skype = $post['skype'];

        if (!$account->save()) {
            $this->logger->error('Can not update account with id - ' . $this->account_id);

            return $this->response->error(Response::ERR_SERVICE);
        }

        return $this->response->json();
    }

    public function updatePasswordAction()
    {
        $required_parameters = ['password', 'new_password', 'crypt_pair'];

        $post = $this->getPost($required_parameters);

        $account = Accounts::findFirst($this->account_id);

        if (!$account) {
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        if (!$this->security->checkHash($post['password'], $account->acc_password)) {
            $this->logger->error('Can not change password. account_id = ' . $this->account_id . '. Incorrect old password');

            return $this->response->error(Response::ERR_BAD_PARAM, 'Incorrect old password');
        }

        $account->acc_password = $this->security->hash($post['new_password']);
        $account->acc_crypt_pair = $post['crypt_pair'];

        if (!$account->save()) {
            $this->logger->error('Can not update password for account_id - ' . $this->account_id);

            return $this->response->error(Response::ERR_SERVICE);
        }

        return $this->response->json();
    }

    public function saveAvatarAction()
    {
        if (!$this->request->hasFiles()) {
            return $this->response->error(Response::ERR_EMPTY_PARAM, 'no files were sent');
        }

        if (count($this->request->getUploadedFiles()) > 1) {
            return $this->response->error(Response::ERR_NOT_ALLOWED, 'not allowed to send more than 1 file');
        }

        $file = $this->request->getUploadedFiles()[0];

        if ($file->getSize() > $this->config->files['max_file_size']) {
            return $this->response->error(Response::ERR_FILESIZE);
        }

        if (!in_array($file->getExtension(), ['jpg', 'jpeg', 'png'])) {
            return $this->response->error(Response::ERR_BAD_PARAM, 'not allowed file extension.');
        }

        $filename = md5(time()) . '_' . $file->getName();
        $path = $this->config->files['root_dir'] . '/accounts/avatars/';
        $width = $this->config->pictures['avatars']['width'];
        $height = $this->config->pictures['avatars']['height'];

        $image = $this->resizeImage($file->getTempName(), $width, $height);

        $image->save($path . $filename);

        $account = Accounts::findFirst($this->account_id);

        if ($account->acc_avatar) {
            unlink($path . $account->acc_avatar);
        }

        $account->acc_avatar = $filename;

        try {
            $account->save();
        } catch (\Exception $e) {
            $this->logger->error('can not save avatar filename ' . $file->getName() . ' in a DB');
            return $this->response->error(Response::ERR_SERVICE);
        }

        return $this->response->json();
    }

    protected function resizeImage($image, $new_width, $new_height)
    {
//        $image = new \Phalcon\Image\Adapter\Gd($file->getTempName());
//        $image->resize(512, 512, \Phalcon\Image::TENSILE);

        $image = new \Phalcon\Image\Adapter\GD($image);
        $source_height = $image->getHeight();
        $source_width = $image->getWidth();
        $source_aspect_ratio = $source_width / $source_height;
        $desired_aspect_ratio = $new_width / $new_height;
        if ($source_aspect_ratio > $desired_aspect_ratio) {
            $temp_height = $new_height;
            $temp_width = ( int ) ($new_height * $source_aspect_ratio);
        } else {
            $temp_width = $new_width;
            $temp_height = ( int ) ($new_width / $source_aspect_ratio);
        }
        $x0 = ($temp_width - $new_width) / 2;
        $y0 = ($temp_height - $new_height) / 2;
        $image->resize($temp_width, $temp_height)->crop($new_width, $new_height, $x0, $y0);

        return $image;
    }

    public function deleteAvatarAction()
    {
        $account = Accounts::findFirst($this->account_id);

        if (!$account->acc_avatar) {
            return $this->response->error(Response::ERR_NOT_FOUND, 'Account does not have avatar');
        }

        $path = $this->config->files['root_dir'] . '/accounts/avatars/';
        unlink($path . $account->acc_avatar);

        $account->acc_avatar = null;
        $account->save();

        return $this->response->json();
    }
}
