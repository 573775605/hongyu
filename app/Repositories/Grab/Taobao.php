<?php

namespace App\Repositories\Grab;

use GuzzleHttp\Client;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/12
 * Time: 13:49
 * Author: wenlongh <wenlongh@qq.com>
 */
class Taobao extends Base
{

    public static function commandAnalysis($command)
    {
        $res = [
            'status' => true,
        ];
        $url = 'http://www.taokouling.com/index.php?m=api&a=taokoulingjm';
        $param = [
            'username' => urlencode(env('TAOKOULING_USERNAME')),
            'password' => env('TAOKOULING_PASSWORD'),
            'text'     => $command,
        ];
        $client = new Client();
        $result = $client->request('post', $url, ['form_params' => $param]);
        $content = $result->getBody()->getContents();
        $content = \GuzzleHttp\json_decode($content, true);
        if (!isset($content['url'])) {
            $res['status'] = false;
            $res['message'] = '淘口令解析失败';
        } else {
            $res['url'] = $content['url'];
        }

        return $res;
    }

    public function filter()
    {
        $data = $this->getContent();
        $data = \GuzzleHttp\json_decode($data, true);
        if (!empty($data['data']['itemInfoModel'])) {
            $this->result['name'] = $data['data']['itemInfoModel']['title'];
            $this->result['price'] = floatval(
                reset(\GuzzleHttp\json_decode(reset($data['data']['apiStack'])['value'], true)['data']['itemInfoModel']['priceUnits'])['price']
            );
            $img = [];
            foreach ($data['data']['itemInfoModel']['picsPath'] as $v) {
                $img[] = [
                    'url' => $v,
                ];
            }
            $this->result['img'] = $img;
            $this->uploadImg();
        }

        return $this->result;
    }
}