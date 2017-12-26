<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Article;
use App\Repositories\ArticleCategoryList;
use App\Repositories\ArticleList;
use App\Repositories\Demand;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/6/23
 * Time: 11:43
 * Author: wenlongh <wenlongh@qq.com>
 */
class ArticleController extends Controller
{

    public function index()
    {
        $rows = ArticleList::getList();

        return view('admin.article.index', compact('rows'));
    }

    public function add()
    {
        $status = '';
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if (Article::create($data)->save()) {
                return redirect(url('admin/article/index'));
            }
            $status['status'] = false;
        }
        $data = [
            'status'   => $status,
            'category' => ArticleCategoryList::getAll()->getItems(),
        ];

        return view('admin.article.add', $data);
    }

    public function edit($id)
    {
        $status = '';
        $logic = Article::initById($id);
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if ($logic->save($data)) {
                return redirect(url('admin/article/index'));
            }
            $status['status'] = false;
        }
        $data = [
            'category' => ArticleCategoryList::getAll()->getItems(),
            'status'   => $status,
            'row'      => $logic,
        ];

        return view('admin.article.add', $data);
    }

    public function remove($id)
    {
        $logic = Article::initById($id);
        if ($logic->delete()) {
            return $this->returnJson(true);
        }

        return $this->returnJson(false, '操作失败，请重试');
    }

    public function checkData()
    {
        $rule = [
            'title'       => 'required',
            'category_id' => 'required',
            //            'img_id'      => 'required',
        ];
        $message = [
            'title.required'       => '请输入文章标题',
            'category_id.required' => '请选择文章分类',
            'img_id.required'      => '请上传文章图片',
        ];
        $this->validate($this->_request, $rule, $message);

        return [
            'title'       => $this->_request->input('title'),
            'category_id' => $this->_request->input('category_id'),
            'img_id'      => $this->_request->input('img_id'),
            'description' => $this->_request->input('description'),
            'content'     => $this->_request->input('content'),
            'sort'        => $this->_request->input('sort'),
            'status'      => $this->_request->input('status'),
        ];
    }
}