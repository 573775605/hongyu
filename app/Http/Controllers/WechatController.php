<?php

namespace App\Http\Controllers;

use App\Repositories\Config;
use App\Repositories\Coupon;
use App\Repositories\User;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/1
 * Time: 23:32
 * Author: wenlongh <wenlongh@qq.com>
 */
class WechatController extends Controller
{
    public function index()
    {
        $server = app('wechat')->server;
        $server->setMessageHandler(
            function ($message) {
                // 注意，这里的 $message 不仅仅是用户发来的消息，也可能是事件
                // 当 $message->MsgType 为 event 时为事件
                if ($message->MsgType == 'event') {
                    switch ($message->Event) {
                        case 'subscribe':
                            //                            $this->subscribe($message);

                            return Config::get('subscribe_notice', '你好，欢迎关注！');
                            break;
                        case 'CLICK':

                            break;
                        case 'LOCATION':

                            return $this->saveLocation($message);
                            break;
                        default:

                            break;
                    }
                }
            }
        );
        $response = $server->serve();

        $response->send();
    }

    public function subscribe($message)
    {
        $user = User::getByOpenid($message->FromUserName);
        if (!$user) {
            return null;
        }
        if ($user->data->is_subscribe) {
            return true;
        }
        $user->subscribe();
        $coupon = Coupon::getFirst();
        if ($coupon) {
            $user->createCoupon($coupon->getData());
        }

        return $user->save();
    }

    /**
     * 保存用户经纬度
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $message
     * @return bool
     */
    public function saveLocation($message)
    {
        $user = User::getByOpenid($message->FromUserName);
        if (!$user) {
            return true;
        }
        $data = [
            'lng' => $message->Longitude,
            'lat' => $message->Latitude,
        ];

        return $user->save($data);
    }

    public function setMenu()
    {
        $menu = app('wechat')->menu;
        $buuton = [
            [
                "type" => "view",
                "name" => "首页",
                "url"  => url('wechat'),
            ],
            [
                "name"       => "红市",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "寻找红利-可报价",
                        "url"  => "http://www.meikai.site/wechat/demand/filter?filter-active=filter&filter_type=not_select",
                    ],
                    [
                        "type" => "view",
                        "name" => "循环红利-可跟单",
                        "url"  => "http://www.meikai.site/wechat/demand/filter?filter-active=filter&filter_type=select",
                    ],
                ],
            ],
            [
                "name"       => "我的",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "消息",
                        "url"  => "http://www.meikai.site/wechat/message/index",
                    ],
                    [
                        "type" => "view",
                        "name" => "红利需求订单",
                        "url"  => "http://www.meikai.site/wechat/demand/index",
                    ],
                    [
                        "type" => "view",
                        "name" => "红利分享订单",
                        "url"  => "http://www.meikai.site/wechat/hotboom-demand/index",
                    ],
                    [
                        "type" => "view",
                        "name" => "我的钱包",
                        "url"  => "http://www.meikai.site/wechat/user/wallet",
                    ],
                ],
            ],
        ];
        dd($menu->add($buuton));
    }
}