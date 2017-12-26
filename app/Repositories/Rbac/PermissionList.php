<?php

namespace App\Repositories\Rbac;

use App\Repositories\BaseList;
use App\Models\Permission as PermissionModel;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/13
 * Time: 17:58
 * Author: wenlongh <wenlongh@qq.com>
 */
class PermissionList extends BaseList
{
    public static $model = PermissionModel::class;

    protected $treeItems = [];

    public function loadTree($items = [], $pid = 0)
    {
        $items = $items ? : $this->getItems();
        foreach ($items as $v) {
            if ($v->parent_id == $pid) {
                $this->treeItems[] = $v;
                $this->loadTree($items, $v->id);
            }
        }

        return $this->treeItems;
    }
}