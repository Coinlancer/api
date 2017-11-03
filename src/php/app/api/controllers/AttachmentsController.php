<?php

namespace App\Controllers;

use App\Lib\Response;
use App\Models\Attachments;

class AttachmentsController extends ControllerBase
{
    public function saveAction($project_id)
    {
        $this->checkProjectOwner($project_id);

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

        //TODO: remove microtime, use early created link if already exists
        //TODO: bot that will be delete files when all link are deleted
//        $md5_hash = md5(file_get_contents($file->getTempName()) );
        $md5_hash = md5(file_get_contents($file->getTempName()) . microtime());

        $attachment = Attachments::findFirst([
            "conditions" => "tch_hash = ?1",
            "bind" => [1 => $md5_hash]
        ]);

        if ($attachment) {
            $this->logger->error('can not save file ' . $file->getName() . ' on server . File was downloaded earlier');
            return $this->response->error(Response::ERR_BAD_PARAM);
        }

        $path = $this->config->files['root_dir'] . '/project_attachments/';

        try {
            $path = $this->filePath($md5_hash, $path);
        } catch (\Exception $e) {
            $this->logger->error('can not create folders for file ' . $file->getName());
            return $this->response->error(Response::ERR_SERVICE);
        }

        $filename = md5(time()) . '_' . $file->getName();

        if (!$file->moveTo($path . $filename)) {
            $this->logger->error('can not save file ' . $file->getName() . ' on disk');
            return $this->response->error(Response::ERR_SERVICE);
        }

        $attachment = new Attachments;
        $attachment->prj_id = $project_id;
        $attachment->tch_title = $file->getName();
        $attachment->tch_full_title = $filename;
        $attachment->tch_path = $path;
        $attachment->tch_hash = $md5_hash;

        if (!$attachment->save()) {
            $this->logger->error('can not save file ' . $file->getName() . ' in DB');
            return $this->response->error(Response::ERR_SERVICE);
        }

        return $this->response->json($attachment);
    }

    protected function filePath($str, $rootPath = null, $depth = 2)
    {
        if (!empty($rootPath)) {
            $rootPath = rtrim($rootPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }

        $pattern = '/[^a-z0-9]/';

        $s = preg_replace($pattern, '', strtolower($str));
        $path = '';

        if (strlen($s) >= $depth) {
            for ($i = 1; $i <= $depth; $i++) {
                $path .= substr($s, 0, $i) . '/';
            }
        }

        if (!empty($rootPath) && !is_dir($rootPath . $path)) {
            mkdir($rootPath . $path, 0775, true);
        }

        return $rootPath . $path;
    }

    public function getAction($project_id, $id)
    {
        $attachment = Attachments::findFirst([
            'conditions' => 'tch_id = ?1 and prj_id = ?2',
            'bind' => [
                1 => $id,
                2 => $project_id
            ]
        ]);

        if (!$attachment) {
            $this->logger->error('can not access file with  id=' . $id. ' and project_id=' . $project_id . ' . There is no data in DB');
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        $file = $attachment->tch_path . $attachment->tch_full_title;

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'. $attachment->tch_title .'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        } else {
            $this->logger->error('can not access file with  id=' . $id. ' and project_id=' . $project_id . ' . There is no file in filesystem');
            return $this->response->error(Response::ERR_NOT_FOUND);
        }
    }

    public function deleteAction($project_id, $id)
    {
        $attachment = Attachments::findFirst([
            'conditions' => 'tch_id = ?1 and prj_id = ?2',
            'bind' => [
                1 => $id,
                2 => $project_id
            ]
        ]);

        if (!$attachment) {
            $this->logger->error('can not delete file with  id=' . $id. ' and project_id=' . $project_id . ' . There is no data in DB');
            return $this->response->error(Response::ERR_NOT_FOUND);
        }

        if (!unlink($attachment->tch_path . $attachment->tch_full_title)) {
            $this->logger->error('can not delete file with  id=' . $id. ' and project_id=' . $project_id . ' from filesystem');
            return $this->response->error(Response::ERR_SERVICE);
        }

        if (!$attachment->delete()) {
            $this->logger->error('can not delete file with  id=' . $id. ' and project_id=' . $project_id . ' from DB');
            return $this->response->error(Response::ERR_SERVICE);
        }

        return $this->response->json();
    }
}
