<?php

namespace App\Repositories\Rbac;

use App\Repositories\Base;
use App\Models\Role as RoleModel;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/13
 * Time: 23:13
 * Author: wenlongh <wenlongh@qq.com>
 */
class Role extends Base
{
    public static $modelName = RoleModel::class;

    public function loadPermisssion()
    {
        $permission = PermissionList::getAll()->getItems();
        $this->data->load('perms');

        foreach ($permission as $v) {
            if ($this->data->perms->search(
                    function ($item) use ($v) {
                        return $item->name == $v->name;
                    }
                ) !== false
            ) {
                $v->checked = true;
            }
        }

        return $permission;
    }
}