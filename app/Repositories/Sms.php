<?php

namespace App\Repositories;

use App\Models\Sms as SmsModel;
use Overtrue\EasySms\EasySms;

class Sms extends Base
{
    public static $modelName = SmsModel::class;

    public $result;

    public static function send($mobile)
    {
        $content = '验证码${code}，您正在进行身份验证，打死不要告诉别人哦！';
        $code = static::generateCode();

        $sms = new EasySms(static::getConfig());
        $param = [
            'content'  => $content,
            'template' => 'SMS_89855393',
            'data'     => [
                'code' => $code,
            ],
        ];
        $result = $sms->send($mobile, $param);
        $data = [
            'mobile'  => $mobile,
            'content' => $content,
            'code'    => $code,
            'result'  => \GuzzleHttp\json_encode($result['aliyun']['result']),
        ];

        $obj = static::create($data);
        $obj->result = $result;

        $obj->save();

        return $obj;
    }

    public static function generateCode($size = 6)
    {
        $arr = [];
        while (count($arr) < $size) {
            $arr[] = rand(1, 9);
            $arr = array_unique($arr);
        }

        return implode("", $arr);
    }

    public function verify($code)
    {
        if ($this->data->code != $code) {
            return false;
        }
        $this->data->status = 2;
        $this->save();

        return true;
    }

    public static function getConfig()
    {
        return [
            // HTTP 请求的超时时间（秒）
            'timeout'  => 5.0,
            // 默认发送配置
            'default'  => [
                // 网关调用策略，默认：顺序调用
                'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

                // 默认可用的发送网关
                'gateways' => [
                    'aliyun',
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'errorlog' => [
                    'file' => storage_path() . '/logs/easy-sms.log',
                ],
                'aliyun'   => [
                    'access_key_id'     => 'LTAIR63gd1subYXx',
                    'access_key_secret' => '60NkjBiYfI9PD8oXbNONOSBPAgUCcJ',
                    'sign_name'         => '红鱼网',
                ],
            ],
        ];
    }

}
