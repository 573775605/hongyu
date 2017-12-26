<?php

namespace App\Http\Controllers\Wechat;

use App\Repositories\Cart;
use App\Repositories\CartList;
use App\Repositories\Demand;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/5
 * Time: 14:21
 * Author: wenlongh <wenlongh@qq.com>
 */
class HotboomCartController extends Controller
{
    public function index()
    {
        $cond = [
            'user_id' => $this->getUserId(),
        ];
        $cart = CartList::getList($cond);
        $data = [
            'rows'   => $cart->getItems(),
            'status' => Demand::$status,
        ];
        if ($this->request->ajax()) {
            $data = [
                'rows' => view('wechat.center.hotboom_cart_paging', $data)->render(),
            ];

            return $this->returnJson(1, 'ok', $data);
        }

        return view('wechat.center.hotboom_cart', $data);
    }

    public function add($demandId)
    {
        if (Cart::getByUser($this->getUserId(), $demandId)) {
            return $this->returnJson();
        }
        $data = [
            'user_id'   => $this->getUserId(),
            'demand_id' => $demandId,
        ];
        if (Cart::create($data)->save()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '添加失败');
    }
}