<?php

namespace App\Http\Controllers\Admin\Rbac;

use App\Http\Controllers\Admin\Controller;
use App\Repositories\Rbac\PermissionList;
use App\Repositories\Rbac\Role;
use App\Repositories\Rbac\RoleList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/13
 * Time: 22:42
 * Author: wenlongh <wenlongh@qq.com>
 */
class RoleController extends Controller
{
    public function index()
    {
        $rows = RoleList::getList();

        return view('admin.rbac.role.index', compact('rows'));
    }

    public function add()
    {
        if ($this->_request->isMethod('post')) {
            $data = $this->_request->except(['_token', 'permission']);
            $logic = Role::create($data);
            if ($logic->save()) {
                $logic->data->perms()->sync($this->_request->input('permission') ? : []);

                return redirect('admin/rbac/role');
            }
        }
        $data = [
            'rows' => PermissionList::getAll()->getItems(),
        ];

        return view('admin.rbac.role.add', $data);
    }

    public function edit($id)
    {
        $logic = Role::initById($id);
        if ($this->_request->isMethod('post')) {
            $data = $this->_request->except(['_token', 'permission']);
            if ($logic->save($data)) {
                $logic->data->perms()->sync($this->_request->input('permission') ? : []);

                return redirect('admin/rbac/role');
            }
        }
        $data = [
            'rows' => $logic->loadPermisssion(),
            'row'  => $logic,
        ];

        return view('admin.rbac.role.add', $data);
    }

    public function remove($id)
    {
        if (Role::initById($id)->delete()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
    }

}