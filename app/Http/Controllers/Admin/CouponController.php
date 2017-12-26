<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Coupon;
use App\Repositories\CouponList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/7/20
 * Time: 16:53
 * Author: wenlongh <wenlongh@qq.com>
 */
class CouponController extends Controller
{

    public function index()
    {
        $rows = CouponList::getList();
        $type = Coupon::$type;

        return view('admin.coupon.index', compact('rows', 'type'));
    }

    public function add()
    {
        if ($this->_request->isMethod('post')) {
            $data = $this->check();
            if (Coupon::create($data)->save()) {
                return redirect(url('admin/coupon/index'));
            }
        }
        $data = [
            'type'     => Coupon::$type,
            'useScope' => Coupon::$useScope,
        ];

        return view('admin.coupon.add', $data);
    }

    public function edit($id)
    {
        $logic = Coupon::initById($id);
        if ($this->_request->isMethod('post')) {
            if ($logic->save($this->check())) {
                return redirect(url('admin/coupon/index'));
            }
        }

        $data = [
            'row'      => $logic,
            'type'     => Coupon::$type,
            'useScope' => Coupon::$useScope,
        ];

        return view('admin.coupon.add', $data);
    }

    public function remove($id)
    {
        if (Coupon::initById($id)->delete()) {
            return $this->returnJson(true);
        }

        return $this->returnJson(false, '删除失败');
    }

    public function check()
    {
        $rule = [
            'name'       => 'required',
            'price'      => 'required|numeric',
            'valid_time' => 'required|numeric',
        ];
        $message = [
            'name.*'       => '请输入优惠券名称',
            'price.*'      => '请输入正确优惠金额',
            'valid_time.*' => '请输入有效过期时间',
        ];
        $this->validate($this->_request, $rule, $message);

        return [
            'name'           => $this->_request->input('name'),
            'type'           => $this->_request->input('type'),
            'start_time'     => $this->_request->input('start_time'),
            'end_time'       => $this->_request->input('end_time'),
            'use_scope'      => $this->_request->input('use_scope'),
            'price'          => $this->_request->input('price'),
            'full_price_use' => $this->_request->input('full_price_use') ? : 0,
            'valid_time'     => $this->_request->input('valid_time') * 60 * 60 * 24,
            'sort'           => $this->_request->input('sort'),
            'description'    => $this->_request->input('description'),
            'manager_id'     => $this->_request->user()->id,
        ];
    }
}