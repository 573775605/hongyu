<?php

namespace App\Http\Controllers\Wechat;

use App\Repositories\PaymentOrder;
use EasyWeChat;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/13
 * Time: 15:36
 * Author: wenlongh <wenlongh@qq.com>
 */
class PayController extends Controller
{
    public function pay($id)
    {
        $payOrder = PaymentOrder::initById($id);
        $payConfig = $payOrder->createWechatJsConfig($this->getUser()->data->openid);

        $js = EasyWeChat::js();

        return view('wechat.pay', ['js' => $js, 'config' => $payConfig]);
    }

    public function callback()
    {
        $payment = EasyWeChat::payment();
        $response = $payment->handleNotify(
            function ($notify, $successful) {
                $order = PaymentOrder::getByNumber($notify->out_trade_no);
                //找到订单
                if (!$order) {
                    return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
                }
                // 设置成已支付
                if ($successful) {
                    $order->data->wechat_order_number = $notify->transaction_id;
                    $order->pay();
                }

                return true; // 返回处理完成
            }
        );

        return $response;
    }
}