<?php

namespace App\Repositories\Upload;

/**
 * class FileUploader
 *
 * @package Service\Repositories
 */
class FileUploader implements Uploader
{
    public $file;

    public $path;

    public $filePath;

    public static function uploadFile($file, $name, $dir = '')
    {
        $obj = new static();
        $obj->file = $file;
        $obj->upload($name, $dir);

        return $obj;
    }

    public static function saveRoot()
    {
        return env('UPLOAD_SAVE_ROOT');
    }

    public static function savePath()
    {
        return env('UPLOAD_SAVE_PATH') . date('Ymd') . '/';
    }

    public static function serverRoot()
    {
        return env('UPLOAD_SERVER_ROOT');
    }

    public function url()
    {
        return static::serverRoot() . $this->path();
    }

    public function path()
    {
        return $this->path;
    }

    public function filePath()
    {
        return $this->filePath;
    }

    public function upload($name, $dir = '')
    {
        $this->path = static::savePath() . $dir . $name;
        $this->filePath = static::saveRoot() . $this->path;

        return $this->file->move(static::saveRoot() . static::savePath() . $dir, $name);
    }

}
