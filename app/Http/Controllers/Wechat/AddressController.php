<?php

namespace App\Http\Controllers\Wechat;

use App\Repositories\UserAddress;
use App\Repositories\UserAddressList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/22
 * Time: 11:27
 * Author: wenlongh <wenlongh@qq.com>
 */
class AddressController extends Controller
{
    public function index()
    {
        $user = $this->getUser();
        $logic = UserAddressList::getAll(['user_id' => $user->data->id]);
        $data = [
            'rows' => $logic->getItems(),
        ];

        return view('wechat.address.index', $data);
    }

    public function add()
    {
        if ($this->request->isMethod('post')) {
            $type = $this->request->query('type');
            $logic = UserAddress::create($this->checkData());
            $logic->checkDefault();
            if ($logic->save()) {
                if ($type == 'issue-demand') {
                    return redirect('wechat/issue/index?action=type&address_id=' . $logic->data->id);
                } elseif ($type == 'copy-demand') {
                    return redirect('wechat/demand/copy-demand?address_id=' . $logic->data->id);
                } else {
                    return redirect('wechat/address');
                }
            }
        }

        return view('wechat.address.add');
    }

    public function edit($id)
    {
        $logic = UserAddress::initById($id);
        if ($this->request->isMethod('post')) {
            $data = $this->checkData();
            //            $logic->data->is_default = $data['is_default'];
            //            $logic->checkDefault();
            if ($logic->save($data)) {
                return redirect('wechat/address');
            }
        }
        $logic->data->location = $logic->data->province . ' ' . $logic->data->city . ' ' . $logic->data->area;
        $data = [
            'row' => $logic->getData(),
        ];

        return view('wechat.address.add', $data);
    }

    public function remove($id)
    {
        $logic = UserAddress::initById($id);
        if ($logic->remove()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
    }

    public function setDefault($id)
    {
        $logic = UserAddress::initById($id);
        if ($logic->setDefault()->save()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '设置失败');
    }

    public function checkData()
    {
        $rule = [
            'name'     => 'required',
            'phone'    => 'required',
            'location' => 'required',
            'address'  => 'required',
        ];
        $message = [
            'name.*'     => '请填写收货人',
            'phone.*'    => '输入手机号有误',
            'location.*' => '请选择收货地区',
            'address.*'  => '请填写详细地址',
        ];
        $this->validate($this->request, $rule, $message);
        $param = $this->request->input();
        list($province, $city, $area) = explode(' ', $param['location']);

        return [
            'user_id'  => $this->getUserId(),
            'name'     => $param['name'],
            'phone'    => $param['phone'],
            //            'postcode' => $param['postcode'],
            'province' => $province,
            'city'     => $city,
            'area'     => $area,
            'address'  => $param['address'],
            //            'is_default' => $param['is_default'],
        ];
    }
}