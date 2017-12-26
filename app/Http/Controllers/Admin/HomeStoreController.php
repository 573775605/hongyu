<?php

namespace App\Http\Controllers\Admin;


use App\Repositories\HomeStoreIcon;
use App\Repositories\HomeStoreIconList;

class HomeStoreController extends Controller
{
    public function index()
    {
        $rows = HomeStoreIconList::getList();

        return view('admin.home-store.index', compact('rows'));
    }

    public function add()
    {
        $status = $row = '';
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if ($this->_request->input('id')) {
                $logic = HomeStoreIcon::initById($this->_request->input('id'));
            } else {
                $logic = HomeStoreIcon::create();
            }
            if ($logic->save($data)) {
                return redirect('admin/home-store/index');
            }
            $status['status'] = false;
            $row = $logic;
        }

        return view('admin.home-store.add', compact('row', 'status'));
    }

    public function edit($id)
    {
        $status = '';
        $row = $logic = HomeStoreIcon::initById($id);
        if ($this->_request->isMethod('post')) {
            $data = $this->checkData();
            if ($logic->save($data)) {
                return redirect('admin/home-store/index');
            }
            $status['status'] = false;
        }

        return view('admin.home-store.add', compact('row', 'status'));
    }

    public function remove($id)
    {
        $logic = HomeStoreIcon::initById($id);
        if ($logic->delete()) {
            return $this->returnJson(true);
        }

        return $this->returnJson(false);
    }

    public function checkData()
    {
        $rule = [
            'name'  => 'required',
            'img_id' => 'required',
            'link'   => 'required|url',
        ];
        $message = [
            'name.required'    => '请输入商城名称',
            'img_id.required'   => '请上传商城LOGO',
            'link.*' => '请输入有效url地址',
        ];
        $this->validate($this->_request, $rule, $message);

        return [
            'name'      => $this->_request->input('name'),
            'is_shield' => $this->_request->input('is_shield'),
            'link'      => $this->_request->input('link'),
            'img_id'    => $this->_request->input('img_id'),
            'sort'      => $this->_request->input('sort'),
            'status'    => $this->_request->input('status'),
        ];
    }
}