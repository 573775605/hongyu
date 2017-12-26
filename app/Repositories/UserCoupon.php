<?php

namespace App\Repositories;

use App\Models\UserCoupon as UserCouponModel;

/**
 * Class Goods
 *
 * @package App\Repositories
 */
class UserCoupon extends Base
{
    public static $modelName = UserCouponModel::class;

    /**
     * @author wenlongh <wenlongh@qq.com>
     * @param $id
     * @param $userId
     * @return null|static
     * 获取用户可用优惠券
     */
    public static function getUsableByUser($id, $userId)
    {
        $data = UserCouponModel::where('status', 1)->where('user_id', $userId)->where('valid_time', '>', date('Y-m-d H:i:s'))->find($id);
        if (!$data) {
            return null;
        }

        return static::initByModel($data);
    }

    /**
     * @author wenlongh <wenlongh@qq.com>
     * @param $orderId
     * @return $this
     * 优惠券使用
     */
    public function employ($orderId)
    {
        $this->data->status = 2;
        $this->data->employ_time = date('Y-m-d H:i:s');
        $this->data->demand_id = $orderId;

        return $this;
    }

}
