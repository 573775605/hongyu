<?php

namespace App\Repositories\Rbac;

use App\Repositories\Base;
use App\Models\Permission as PermissionModel;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/13
 * Time: 17:56
 * Author: wenlongh <wenlongh@qq.com>
 */
class Permission extends Base
{
    public static $modelName = PermissionModel::class;

    public function isHaveChild()
    {
        $child = PermissionModel::where('parent_id', $this->data->id)->count();

        return boolval($child);
    }
}