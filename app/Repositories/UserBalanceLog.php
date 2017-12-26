<?php

namespace App\Repositories;

use App\Models\UserBalanceLog as UserBalanceLogModel;

class UserBalanceLog extends Base
{
    public static $modelName = UserBalanceLogModel::class;

    public static $type = [
        'hotboom' => '代购余额',
        'other'   => '其他余额',
    ];

}
