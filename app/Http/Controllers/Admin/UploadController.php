<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Img;
use App\Repositories\Upload\File;

class UploadController extends Controller
{
    public function editorUploadImg()
    {
        $fileList = $this->_request->allFiles();
        if (!$fileList) {
            return response('');
        }
        $file = reset($fileList);
        $file = Img::create($file)->upload($file);

        return response(url('upload') . $file->getFilePath());
    }

    public function uploadImg()
    {
        $file = $this->_request->file('file');
        if (!$file) {
            return $this->returnJson(-1, '没有文件上传');
        }
        $files = File::upload($file);

        return $this->returnJson(1, 'success', ['id' => $files->data->id, 'url' => $files->url()]);
    }


    public function uploadImgs()
    {
        $fileList = $this->_request->allFiles();
        if (!$fileList) {
            return $this->json(-1, '没有文件上传');
        }

        $result = [];
        foreach ($fileList as $k => $file) {
            $file = File::upload($file);
            $result[$k]['id'] = $file->data->id;
            $result[$k]['url'] = $file->url();
        }

        return $this->returnJson(1, 'success', $result);
    }
}
