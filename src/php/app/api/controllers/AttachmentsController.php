<?php

namespace App\Controllers;

use App\Models\Attachments;

class AttachmentsController extends ControllerBase
{
    public function saveAction($id)
    {
        $random = new \Phalcon\Security\Random;

        $attachments = [];

        if ($this->request->hasFiles()) {
            foreach ($this->request->getUploadedFiles() as $file) {
                $path = $this->config->path_to_files . '/project_attachments/' . $random->base64(12) . '_' . $file->getName();
                $file->moveTo($path);

                $attachment = new Attachments;
                $attachment->tch_title = $file->getName();
                $attachment->tch_path = $path;
                $attachment->prj_id = $id;
                $attachment->save();

                $attachments[] = [
                    'id'    => $attachment->tch_id,
                    'title' => $file->getName(),
                    'path'  => $path
                ];
            }
        }

        return $this->response->json($attachments);
    }

    public function deleteAction($id)
    {
        $attachment = Attachments::findFirst([
            'condition' => 'tch_id = ?1',
            'bind' => [1 => $id]
        ]);

        $this->storage->delete($attachment->tch_path);

        $attachment->delete();

        return $this->response->json();
    }
}
