<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\UserInfoAuth;
use App\Repositories\UserInfoAuthList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/8
 * Time: 14:01
 * Author: wenlongh <wenlongh@qq.com>
 */
class UserAuthController extends Controller
{
    public function index()
    {
        $cond = [];
        if ($this->_request->has('is_check')) {
            $cond['is_check'] = $this->_request->query('is_check');
        }
        $rows = UserInfoAuthList::getList($cond);
        $status = UserInfoAuth::$status;

        return view('admin.user-auth.index', compact('rows', 'status'));
    }

    public function check()
    {
        $id = $this->_request->input('id');
        $status = $this->_request->input('status');
        $checkRemark = $this->_request->input('check_remark');

        $info = UserInfoAuth::initById($id);
        if ($info->check($status, $checkRemark)->save()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '资料保存失败');
    }

    public function view($id)
    {
        $auth = UserInfoAuth::initById($id);
        $data = [
            'row'    => $auth->getData(),
            'status' => UserInfoAuth::$status,
        ];

        return view('admin.user-auth.view', $data);
    }
}