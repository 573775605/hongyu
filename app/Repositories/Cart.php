<?php

namespace App\Repositories;

use App\Models\Cart as CartModel;

class Cart extends Base
{
    public static $modelName = CartModel::class;

    public static function getByUser($userId, $demandId)
    {
        $data = CartModel::where('user_id', $userId)->where('demand_id', $demandId)->first();
        if (!$data) {
            return null;
        }

        return static::initByModel($data);
    }

}
