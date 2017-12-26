<?php

namespace App\Repositories;

use App\Models\UserFundAccount as UserFundAccountModel;

class UserFundAccount extends Base
{
    public static $modelName = UserFundAccountModel::class;

    public static $type = [
        'alipay' => '支付宝账号',
        'bank'   => '银行卡号',
    ];

    public static function getAlipayAccount($userId)
    {
        $data = UserFundAccountModel::where('user_id', $userId)->where('type', 'alipay')->first();
        if (!$data) {
            return null;
        }

        return static::initByModel($data);
    }

}
