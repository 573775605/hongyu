<?php

namespace App\Repositories;

use App\Models\Coupon as CouponModel;

/**
 * Class Goods
 *
 * @package App\Repositories
 */
class Coupon extends Base
{
    public static $modelName = CouponModel::class;
    //优惠券类型
    public static $type = [
        'voucher' => '代金券',
    ];
    //使用范围
    public static $useScope = [
        'all' => '不限制',
    ];

    public static $status = [
        1 => '未使用',
        1 => '已使用',
    ];

    public static function getFirst()
    {
        $data = CouponModel::where('status', 1)->orderBy('sort', 'asc')->first();
        if (!$data) {
            return null;
        }

        return static::initByModel($data);
    }

}
