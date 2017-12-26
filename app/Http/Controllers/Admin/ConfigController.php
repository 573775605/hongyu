<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Config;
use App\Repositories\ConfigList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/20
 * Time: 13:33
 * Author: wenlongh <wenlongh@qq.com>
 */
class ConfigController extends Controller
{
    public function explain()
    {
        $cond = [
            'group' => 'explain',
        ];
        $status = [];
        $config = ConfigList::getAll($cond);
        if ($this->_request->isMethod('post')) {
            foreach ($config->getItems() as $v) {
                $v->value = $this->_request->input($v->key);
                $v->save();
            }
            $status['status'] = true;
        }
        $data = [
            'explain' => $config->getItems(),
            'status'  => $status,
        ];

        return view('admin.config.explain', $data);
    }

    public function saveScale()
    {
        $scale = $this->_request->input('scale');
        if (!$scale) {
            return $this->returnJson(-1, '没有保存内容');
        }
        $scale = $scale / 100;
        $config = Config::getByKey('daigou_balance_withdraw_scale');
        if ($config->save(['value' => $scale])) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '保存失败');
    }

    public function wechatSet()
    {
        $status = [];
        if ($this->_request->isMethod('post')) {
            $param = $this->_request->input('param');
            foreach ($param as $k => $v) {
                $logic = Config::getOrCreate($k);
                $logic->save(['value' => $v]);
            }
            $status['status'] = true;
        }
        $rows = ConfigList::getAll(['group'=>'wechat']);

        return view('admin.config.wechat', compact('status', 'rows'));
    }
}