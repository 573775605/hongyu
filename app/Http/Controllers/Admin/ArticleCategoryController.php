<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ArticleCategory;
use App\Repositories\ArticleCategoryList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/6/21
 * Time: 14:24
 * Author: wenlongh <wenlongh@qq.com>
 */
class ArticleCategoryController extends Controller
{
    public function index()
    {
        $rows = ArticleCategoryList::getList();
        $type = ArticleCategory::$type;

        return view('admin.article.category_index', compact('rows', 'type'));
    }

    public function add()
    {
        $status = '';
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            $logic = ArticleCategory::create();
            if ($logic->save($data)) {
                return redirect(url('admin/article/category/index'));
            }
        }
        $data = [
            'status' => $status,
            'type'   => ArticleCategory::$type,
        ];

        return view('admin.article.category_add', $data);
    }

    public function edit($id)
    {
        $status = '';
        $logic = ArticleCategory::initById($id);
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if ($logic->save($data)) {
                return redirect(url('admin/article/category/index'));
            }
        }
        $data = [
            'row'    => $logic,
            'status' => $status,
            'type'   => ArticleCategory::$type,
        ];

        return view('admin.article.category_add', $data);
    }

    public function remove($id)
    {
        $logic = ArticleCategory::initById($id);
        if ($logic->data->article->count() > 0) {
            return $this->returnJson(false, '删除失败，请重试');
        }
        $logic->delete();

        return $this->returnJson();
    }

    public function checkData()
    {
        $rule = [
            'name' => 'required',
        ];
        $message = [
            'name.required' => '请输入分类名称',
        ];
        $this->validate($this->_request, $rule, $message);

        return [
            'name'        => $this->_request->input('name'),
            'description' => $this->_request->input('description'),
            'sort'        => $this->_request->input('sort'),
            'status'      => $this->_request->input('status'),
            'type'        => $this->_request->input('type'),
        ];
    }
}