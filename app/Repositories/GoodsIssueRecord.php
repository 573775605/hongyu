<?php

namespace App\Repositories;

use App\Models\GoodsIssueRecord as GoodsIssueRecordModel;

class GoodsIssueRecord extends Base
{
    public static $modelName = GoodsIssueRecordModel::class;

    /**
     * 清空当前用户商品记录
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $userId
     * @return mixed
     */
    public static function clearRecord($userId)
    {
        return GoodsIssueRecordModel::where('user_id', $userId)->delete();
    }

}
