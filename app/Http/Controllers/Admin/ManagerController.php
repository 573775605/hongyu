<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Manager;
use App\Repositories\ManagerList;
use App\Repositories\Rbac\RoleList;
use Auth;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/8
 * Time: 10:28
 * Author: wenlongh <wenlongh@qq.com>
 */
class ManagerController extends Controller
{
    public function index()
    {
        $rows = ManagerList::getList();

        return view('admin.manager.index', compact('rows'));
    }

    public function add()
    {
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            $logic = Manager::create($data);
            $logic->setPassword($this->_request->input('password'));
            if ($logic->save()) {
                $logic->data->roles()->sync($this->_request->input('role', []));

                return redirect('admin/manager/index');
            }
        }
        $data = [
            'role' => RoleList::getAll()->getItems(),
        ];

        return view('admin.manager.add', $data);
    }

    public function edit($id)
    {
        $logic = Manager::initById($id);
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData($id);
            if ($logic->save($data)) {
                $logic->data->roles()->sync($this->_request->input('role', []));

                return redirect('admin/manager/index');
            }
        }
        $data = [
            'row'  => $logic,
            'role' => RoleList::getAll()->getItems(),
        ];

        return view('admin.manager.add', $data);
    }

    public function remove($id)
    {
        $manager = Manager::initById($id);
        if ($manager->delete()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
    }

    public function changePassword()
    {
        if ($this->_request->isMethod('post')) {
            $rule = [
                'old_password'          => 'required',
                'password'              => 'required|confirmed',
                'password_confirmation' => 'required',
            ];
            $message = [
                'old_password.*'                 => '请输入当前密码',
                'password.required'              => '请输入登陆密码',
                'password.confirmed'             => '两次密码不一致',
                'password_confirmation.required' => '请输入确认密码',
            ];
            $this->validate($this->_request, $rule, $message);
            $logic = Manager::initByModel($this->_request->user('manager'));
            if (!$logic->checkPassword($this->_request->input('old_password'))) {
                return redirect()->back()->withErrors(['old_password' => '当前登陆密码错误']);
            }
            if ($logic->setPassword($this->_request->input('password'))->save()) {
                return $this->logout();
            }
        }

        return view('admin.manager.change_password');
    }

    public function logout()
    {
        Auth::guard('manager')->logout();

        return redirect('auth/manager');
    }

    public function checkData($id = 0)
    {
        $rule = [
            'username'              => 'required|unique:manager,username,' . $id,
            'password'              => 'sometimes|required|confirmed',
            'password_confirmation' => 'sometimes|required',
        ];
        $message = [
            'username.required'              => '请输入登陆账号',
            'password.required'              => '请输入登陆密码',
            'password.confirmed'             => '两次密码不一致',
            'password_confirmation.required' => '请输入确认密码',
        ];
        $this->validate($this->_request, $rule, $message);

        return [
            'username' => $this->_request->input('username'),
            'name'     => $this->_request->input('name'),
            'mobile'   => $this->_request->input('mobile'),
            'email'    => $this->_request->input('email'),
        ];
    }

}