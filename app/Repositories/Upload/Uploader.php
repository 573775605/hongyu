<?php

namespace App\Repositories\Upload;

/**
 * Interface Uploader
 *
 * @package App\Repositories
 */
interface Uploader
{
    /**
     * 保存文件的根目录
     *
     * @return string
     */
    public static function saveRoot();

    /**
     * 保存文件的相对目录
     *
     * @return string
     */
    public static function savePath();

    /**
     * 访问文件的根域名
     *
     * @return string
     */
    public static function serverRoot();

    /**
     * 上传文件
     *
     * @param $file
     * @param $name
     * @param string $dir
     * @return mixed
     */
    public static function uploadFile($file, $name, $dir = '');

    /**
     * 上传
     *
     * @param $name
     * @param $dir
     * @return mixed
     */
    public function upload($name, $dir);

    /**
     * 获取访问url
     *
     * @return mixed
     */
    public function url();

    /**
     * 获取文件相对路径
     *
     * @return mixed
     */
    public function path();

    /**
     * 获取文件保存路径
     *
     * @return mixed
     */
    public function filePath();
}
