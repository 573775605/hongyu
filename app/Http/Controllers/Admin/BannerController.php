<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Banner;
use App\Repositories\BannerList;

class BannerController extends Controller
{
    public function index()
    {
        $rows = BannerList::getList();

        return view('admin.banner.index', compact('rows'));
    }

    public function add()
    {
        $status = $row = '';
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if ($this->_request->input('id')) {
                $logic = Banner::initById($this->_request->input('id'));
            } else {
                $logic = Banner::create();
            }
            if ($logic->save($data)) {
                return redirect('admin/banner/index');
            }
            $status['status'] = false;
            $row = $logic;
        }
        $data = [
            'row'    => $row,
            'status' => $status,
            'space'  => Banner::$space,
        ];

        return view('admin.banner.add', $data);
    }

    public function edit($id)
    {
        $status = '';
        $row = $logic = Banner::initById($id);
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if ($logic->save($data)) {
                return redirect('admin/banner/index');
            }
            $status['status'] = false;
        }
        $data = [
            'row'    => $row,
            'status' => $status,
            'space'  => Banner::$space,
        ];

        return view('admin.banner.add', $data);
    }

    public function remove($id)
    {
        $logic = Banner::initById($id);
        if ($logic->delete()) {
            return $this->returnJson(true);
        }

        return $this->returnJson(false);
    }

    public function checkData()
    {
        $rule = [
            'title'  => 'required',
            'img_id' => 'required',
        ];
        $message = [
            'title.required'  => '请输入广告标题',
            'img_id.required' => '请上传广告图片',
        ];
        $this->validate($this->_request, $rule, $message);

        return [
            'title'  => $this->_request->input('title'),
            'space'  => $this->_request->input('space'),
            'url'    => $this->_request->input('url'),
            'img_id' => $this->_request->input('img_id'),
            'sort'   => $this->_request->input('sort'),
            'status' => $this->_request->input('status'),
        ];
    }
}