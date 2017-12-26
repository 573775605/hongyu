<?php

namespace App\Repositories\Rbac;

use App\Repositories\BaseList;
use App\Models\Role as RoleModel;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/13
 * Time: 23:15
 * Author: wenlongh <wenlongh@qq.com>
 */
class RoleList extends BaseList
{
    public static $model = RoleModel::class;
}