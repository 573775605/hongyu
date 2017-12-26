<?php

namespace App\Repositories\Upload;

use App\Repositories\BaseList;
use App\Models\GoodsIssueRecord as GoodsIssueRecordModel;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/23
 * Time: 15:52
 * Author: wenlongh <wenlongh@qq.com>
 */
class FileList extends BaseList
{
    public static $model = GoodsIssueRecordModel::class;
}