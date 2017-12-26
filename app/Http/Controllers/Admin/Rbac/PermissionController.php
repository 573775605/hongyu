<?php

namespace App\Http\Controllers\Admin\Rbac;

use App\Http\Controllers\Admin\Controller;
use App\Repositories\Rbac\Permission;
use App\Repositories\Rbac\PermissionList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/13
 * Time: 17:54
 * Author: wenlongh <wenlongh@qq.com>
 */
class PermissionController extends Controller
{
    public function index()
    {
        $rows = PermissionList::getAll();

        return view('admin.rbac.permission.index', compact('rows'));
    }

    public function add()
    {
        if ($this->_request->isMethod('post')) {
            $input = $this->_request->except('_token');
            if (Permission::create($input)->save()) {
                return redirect('admin/rbac/permission');
            }
        }
        $data = [
            'rows' => PermissionList::getAll()->getItems(),
        ];

        return view('admin.rbac.permission.add', $data);
    }

    public function edit($id)
    {
        $logic = Permission::initById($id);
        if ($this->_request->isMethod('post')) {
            $input = $this->_request->except('_token');
            if ($logic->save($input)) {
                return redirect('admin/rbac/permission');
            }
        }
        $data = [
            'rows' => PermissionList::getAll()->getItems(),
            'row'  => $logic,
        ];

        return view('admin.rbac.permission.add', $data);
    }

    public function remove($id)
    {
        $logic = Permission::initById($id);
        if ($logic->isHaveChild()) {
            return $this->returnJson(-1, '有子节点不能删除，请删除子节点');
        }
        if ($logic->delete()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
    }
}