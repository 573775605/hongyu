<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\GoodsCategory;
use App\Repositories\GoodsCategoryList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/10
 * Time: 12:01
 * Author: wenlongh <wenlongh@qq.com>
 */
class GoodsCategoryController extends Controller
{

    public function index()
    {
        $rows = GoodsCategoryList::getList();
        $rows->loadParent();

        return view('admin.goods-category.index', compact('rows'));
    }

    public function add()
    {
        $parent = GoodsCategoryList::getList(['level' => 1])->getItems();
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if (GoodsCategory::create($data)->save()) {
                return redirect('admin/goods-category/index');
            }
        }

        return view('admin.goods-category.add', compact('parent'));
    }

    public function edit($id)
    {
        $logic = GoodsCategory::initById($id);
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if ($logic->save($data)) {
                return redirect('admin/goods-category/index');
            }
        }
        $data = [
            'row'    => $logic,
            'parent' => $parent = GoodsCategoryList::getList(['level' => 1])->getItems(),
        ];

        return view('admin.goods-category.add', $data);
    }

    public function remove($id)
    {
        $logic = GoodsCategory::initById($id);
        if ($logic->delete()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
    }

    public function checkData()
    {
        $rule = [
            'name'   => 'required',
//            'img_id' => 'required',
        ];
        $message = [
            'name.required'   => '请填写分类名称',
            'img_id.required' => '请上传分类图片',
        ];
        $this->validate($this->_request, $rule, $message);

        return [
            'parent_id'   => $this->_request->input('parent_id'),
            'level'       => $this->_request->input('parent_id') ? 2 : 1,
            'name'        => $this->_request->input('name'),
            'img_id'      => $this->_request->input('img_id'),
            'description' => $this->_request->input('description'),
            'sort'        => $this->_request->input('sort'),
            'status'      => $this->_request->input('status'),
        ];
    }
}