<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\GoodsSource;
use App\Repositories\GoodsSourceList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/22
 * Time: 10:20
 * Author: wenlongh <wenlongh@qq.com>
 */
class GoodsSourceController extends Controller
{
    public function index()
    {
        $rows = GoodsSourceList::getList(['level' => 2]);
        $rows->loadParent();

        return view('admin.goods-source.index', compact('rows'));
    }

    public function add()
    {
        $parent = GoodsSourceList::getList(['level' => 1],40)->getItems();
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if (GoodsSource::create($data)->save()) {
                return redirect('admin/goods-source/index');
            }
        }

        return view('admin.goods-source.add', compact('parent'));
    }

    public function edit($id)
    {
        $logic = GoodsSource::initById($id);
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if ($logic->save($data)) {
                return redirect('admin/goods-source/index');
            }
        }
        $data = [
            'row'    => $logic,
            'parent' => $parent = GoodsSourceList::getList(['level' => 1],40)->getItems(),
        ];

        return view('admin.goods-source.add', $data);
    }

    public function remove($id)
    {
        $logic = GoodsSource::initById($id);
        if ($logic->delete()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
    }

    public function checkData()
    {
        $rule = [
            'name'   => 'required',
            'img_id' => 'required',
        ];
        $message = [
            'name.required'   => '请填写货源名称',
            'img_id.required' => '请上传货源图片',
        ];
        $this->validate($this->_request, $rule, $message);

        return [
            'parent_id'   => $this->_request->input('parent_id'),
            'level'       => $this->_request->input('parent_id') ? 2 : 1,
            'name'        => $this->_request->input('name'),
            'img_id'      => $this->_request->input('img_id'),
            'description' => $this->_request->input('description'),
            'sort'        => $this->_request->input('sort'),
            'total_grade'        => $this->_request->input('total_grade'),
            'status'      => $this->_request->input('status'),
        ];
    }
}