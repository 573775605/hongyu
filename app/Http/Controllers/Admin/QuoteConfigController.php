<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\QuoteAdvantageConfig;
use App\Repositories\QuoteAdvantageConfigList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/15
 * Time: 15:55
 * Author: wenlongh <wenlongh@qq.com>
 */
class QuoteConfigController extends Controller
{
    public function index()
    {
        $rows = QuoteAdvantageConfigList::getList();

        return view('admin.quote-config.index', compact('rows'));
    }

    public function add()
    {
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if (QuoteAdvantageConfig::create($data)->save()) {
                return redirect('admin/quote-config/index');
            }
        }

        return view('admin.quote-config.add');
    }

    public function edit($id)
    {
        $logic = QuoteAdvantageConfig::initById($id);
        $logic->data->label = \GuzzleHttp\json_decode($logic->data->label, true);
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if ($logic->save($data)) {
                return redirect('admin/quote-config/index');
            }
        }
        $data = [
            'row' => $logic,
        ];

        return view('admin.quote-config.add', $data);
    }

    public function remove($id)
    {
        if (QuoteAdvantageConfig::initById($id)->delete()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
    }

    public function checkData()
    {
        $rule = [
            'name'  => 'required',
            'label' => 'sometimes|required',
        ];
        $message = [
            'name.*'  => '请输入优势名称',
            'label.*' => '标签名称不能为空',
        ];
        $this->validate($this->_request, $rule, $message);

        return [
            'name'        => $this->_request->input('name'),
            'label'       => \GuzzleHttp\json_encode($this->_request->input('label', [])),
            'description' => $this->_request->input('description'),
            'sort'        => $this->_request->input('sort'),
            'status'      => $this->_request->input('status'),
        ];
    }
}