<?php

namespace App\Repositories;

use App\Exceptions\ExceptionRepository;
use App\Models\PaymentOrder as PaymentOrderModel;
use EasyWeChat\Payment\Order as WechatOrder;
use EasyWeChat;

class PaymentOrder extends Base
{
    public static $modelName = PaymentOrderModel::class;

    public static $type = [
        'demand' => '需求订单',
        'pledge' => '保证金充值',
    ];

    public static function create($data = [])
    {
        $order = parent::create($data);
        $order->data->order_number = Demand::generateNumber();

        return $order;
    }

    public static function getByNumber($orderNumber)
    {
        $data = PaymentOrderModel::where('order_number', $orderNumber)->first();
        if (!$data) {
            return null;
        }

        return static::initByModel($data);
    }

    public function createWechatJsConfig($openid)
    {
        $param = [
            'openid'       => $openid,
            'trade_type'   => 'JSAPI',
            'notify_url'   => url('wechat/pay/callback'),//支付回调
            'out_trade_no' => $this->data->order_number,
            'total_fee'    => intval($this->data->price * 100),
            'body'         => $this->data->title,
            'detail'       => $this->data->details,
        ];
        //测试支付
//        $param['total_fee'] = 1;
        $wechatOrder = new WechatOrder($param);
        $payment = EasyWeChat::payment();
        $result = $payment->prepare($wechatOrder);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
            //微信订单生成以后就保存订单信息
            $this->data->prepay_id = $result->prepay_id;
            $this->save();

            return $payment->configForJSSDKPayment($result->prepay_id);
        } else {
            throw new ExceptionRepository('创建微信订单失败:' . $result->return_msg . '-' . $result->result_code, -2);
        }
    }

    public function pay()
    {
        if ($this->data->is_pay) {
            return true;
        }
        $this->updateRelevanceInfo();

        $this->data->is_pay = 1;
        $this->data->pay_time = date('Y-m-d H:i:s');

        return $this->save();
    }

    /**
     * 更新支付关联信息
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return bool
     */
    public function updateRelevanceInfo()
    {
        switch ($this->data->type) {
            case 'demand':
                $demand = Demand::initByModel($this->data->demand);
                $demand->pay();

                return $demand->save();
                break;
            case 'pledge':
                $user = User::initByModel($this->data->user);
                $user->updatePledge($this->data->price, '保证金充值成功');

                return $user->save();
                break;

            default:
                # code...
                break;
        }
    }

}
