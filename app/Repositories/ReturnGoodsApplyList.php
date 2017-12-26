<?php

namespace App\Repositories;

use App\Models\ReturnGoodsApply as ReturnGoodsApplyModel;

class ReturnGoodsApplyList extends BaseList
{
    public static $model = ReturnGoodsApplyModel::class;

    public function customerCondition()
    {
        return [
            'keyword' => function ($q, $param) {
                $q->whereHas(
                    'demand',
                    function ($q) use ($param) {
                        $q->where('order_number', $param);
                    }
                );
                $q->orWhereHas(
                    'user',
                    function ($q) use ($param) {
                        $q->where('nickname', 'like', "%$param%");
                    }
                );
            },
        ];
    }
}
