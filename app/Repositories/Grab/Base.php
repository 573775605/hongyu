<?php

namespace App\Repositories\Grab;

use App\Repositories\Upload\File;
use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/12
 * Time: 11:26
 * Author: wenlongh <wenlongh@qq.com>
 */
class Base
{
    public $url;

    public $content;

    public $result;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function getContent()
    {
        if (!$this->content) {
            $client = new Client();
            $result = $client->request(
                'get',
                $this->url
            );
            $content = $result->getBody()->getContents();
            $this->content = $content;
        }

        return $this->content;
    }

    public function uploadImg($server = 'default')
    {
        if (!isset($this->result['img'])) {
            return false;
        }
        $img = [];
        foreach ($this->result['img'] as $v) {
            $file = $this->download($v['url']);
            if ($file) {
                $path = env('UPLOAD_SAVE_ROOT');
                if (!file_exists($path)) {
                    mkdir($path);
                }
                $fileDir = date('Y-m-d') . '/';
                $path .= $fileDir;
                if (!file_exists($path)) {
                    mkdir($path);
                }
                $fileName = uniqid() . '.png';
                $resource = fopen($path . $fileName, 'a');
                fwrite($resource, $file);
                fclose($resource);

                $fileLogic = File::create();
                $fileLogic->data->server = $server;
                $fileLogic->data->md5 = md5_file($path . $fileName);
                $fileLogic->data->path = $fileDir . $fileName;
                $fileLogic->data->file_size = filesize($path . $fileName);
                $fileLogic->data->url = env('UPLOAD_SERVER_ROOT') . $fileDir . $fileName;
                $fileLogic->save();
                $img[] = [
                    'id'  => $fileLogic->data->id,
                    'url' => $fileLogic->data->url,
                ];
            }
        }
        $this->result['img'] = $img;

        return true;
    }

    public function download($imgUrl)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $imgUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $file = curl_exec($ch);
        curl_close($ch);

        //        $filename = pathinfo($imgUrl, PATHINFO_BASENAME);
        return $file;
    }
}