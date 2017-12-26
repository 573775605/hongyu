<?php

namespace App\Repositories\Upload;

use App\Exceptions\ExceptionRepository;

use App\Models\File as FileModel;
use App\Repositories\Base;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Upload
 *
 * @package Service\Repositories
 */
class File extends Base
{

    /**
     * @var FileModel
     */
    public $data;

    public static $modelName = FileModel::class;

    public static function initByMd5($md5)
    {
        $check = static::getByMd5($md5);
        if (!$check) {
            throw new ExceptionRepository('文件不存在', -2);
        }

        return $check;
    }

    public static function upload($file, $server = 'default')
    {
        if (!$file->isValid()) {
            throw new ExceptionRepository('文件上传出错', -3);
        }

        //检查数据库是否存在
        $md5 = md5_file($file->getRealPath());
        if ($check = static::getByMd5($md5)) {
            return $check;
        }

        $obj = static::create();
        $obj->data->server = $server;
        $obj->data->file_size = $file->getSize();
        $obj->data->md5 = $md5;
        //获取文件后缀
        $extension = $file->getClientOriginalExtension();
        //执行上传文件
        $newFileName = $md5 . ($extension ? '.' . $extension : '');
        $re = FileUploader::uploadFile($file, $newFileName);
        //保存数据库
        list($width, $height) = getimagesize($re->filePath());
        $obj->data->width = $width;
        $obj->data->height = $height;
        $obj->data->path = $re->path();
        $obj->data->url = $re->url();

        $obj->save();

        return $obj;
    }

    public static function getByMd5($md5)
    {
        $data = FileModel::where('md5', $md5)->first();
        if (!$data) {
            return null;
        }

        return static::initByModel($data);
    }

    public function url()
    {
        return $this->data->url;
    }

    public function updateServer($server, $url)
    {
        $this->data->server = $server;
        $this->data->url = $url . $this->data->path;

        return $this;
    }
}
