<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\GoodsUnit;
use App\Repositories\GoodsUnitList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/8
 * Time: 13:46
 * Author: wenlongh <wenlongh@qq.com>
 */
class GoodsUnitController extends Controller
{
    public function index()
    {
        $rows = GoodsUnitList::getList();

        return view('admin.goods-unit.index', compact('rows'));
    }

    public function add()
    {
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if (GoodsUnit::create($data)->save()) {
                return redirect('admin/goods-unit/index');
            }
        }

        return view('admin.goods-unit.add');
    }

    public function edit($id)
    {
        $logic = GoodsUnit::initById($id);
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if ($logic->save($data)) {
                return redirect('admin/goods-unit/index');
            }
        }
        $data = [
            'row' => $logic,
        ];

        return view('admin.goods-unit.add', $data);
    }

    public function remove($id)
    {
        $logic = GoodsUnit::initById($id);
        if ($logic->delete()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
    }

    public function checkData()
    {
        $rule = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => '请输入单位名称',
        ];
        $this->validate($this->_request, $rule, $message);

        return [
            'name'   => $this->_request->input('name'),
            'sort'   => $this->_request->input('sort'),
            'status' => $this->_request->input('status'),
        ];
    }
}