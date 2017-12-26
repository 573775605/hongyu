<?php

namespace App\Repositories;

use App\Models\ReturnGoodsApply as ReturnGoodsApplyModel;
use EasyWeChat;

class ReturnGoodsApply extends Base
{
    public static $modelName = ReturnGoodsApplyModel::class;

    public static $status = [
        -1 => '未通过',
        1  => '申请中',
        2  => '已打款',
    ];

    public static $type = [
        'return-money' => '退款',
        'return-goods' => '退货',
    ];

    public static function getByDemand($demandId)
    {
        $data = ReturnGoodsApplyModel::where('demand_id', $demandId)->first();
        if ($data) {
            return static::initByModel($data);
        }

        return static::create(['demand_id' => $demandId]);
    }

    /**
     * @author wenlongh <wenlongh@qq.com>
     * @param $status
     * @param string $remark
     * @return $this
     */
    public function check($status, $remark = '')
    {
        if ($this->data->is_check) {
            return $this;
        }
        $this->data->status = $status;
        $this->data->check_remark = $remark;
        $this->data->check_time = date('Y-m-d H:i:s');
        $demand = Demand::initByModel($this->data->demand);
        if ($status == 2) {
            $this->data->is_check = 1;
            //查看订单是否支付
            if ($demand->data->is_pay) {
                //                $user = User::initByModel($this->data->user);
                //                $user->updateBalance($demand->data->price, '订单' . static::$type[$this->data->type] . '成功', ['demand_id' => $demand->data->id]);
                //                $user->save();
                $paymentOrder = $demand->data->paymentOrder;
                $payment = EasyWeChat::payment();
                $payment->refund($paymentOrder->order_number, Demand::generateNumber(), intval($paymentOrder->price * 100));
            }
            $param = [
                'title'   => static::$type[$this->data->type] . '通知',
                'content' => '订单' . static::$type[$this->data->type] . '申请已处理，处理结果：' . static::$status[$this->data->status] . '。' . '订单编号：' . $demand->data->order_number,
            ];
            $demand->createMessage($param);
        } else {
            $this->data->status = 1;
            if ($this->data->type == 'return-money') {
                $demand->setStatus(3)->save();
            } else {
                $demand->setStatus(4)->save();
            }
        }

        return $this;
    }

}
