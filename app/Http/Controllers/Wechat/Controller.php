<?php

namespace App\Http\Controllers\Wechat;

use App\Repositories\CouponList;
use App\Repositories\User;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/16
 * Time: 16:54
 * Author: wenlongh <wenlongh@qq.com>
 */
class Controller extends \App\Http\Controllers\Controller
{
    public $request;

    public $user;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * 获取授权用户
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return null|static
     */
    public function getUser()
    {
        if (!$this->user) {
            $user = session('wechat.oauth_user');
            $data = [
                'openid'   => $user->getId(),
                'nickname' => $user->getNickname(),
                'img_url'  => $user->getAvatar(),
                'sex'      => $user->getOriginal()['sex'],
                'province' => $user->getOriginal()['province'],
                'city'     => $user->getOriginal()['city'],
                'country'  => $user->getOriginal()['country'],
            ];
            $logic = User::getByOpenid($user->getId());
            if (!$logic) {
                $logic = User::create($data);
                $logic->save();
                $logic->grantCoupon();
            } else {
                $logic->save($data);
            }
            $this->user = $logic;
        }

        return $this->user;
    }

    /**
     * 获取授权用户id
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return int
     */
    public function getUserId()
    {
        $user = $this->getUser();

        return $user ? $user->data->id : 0;
    }

    /**
     * 计算两点经纬度距离(单位：米)
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $lng1
     * @param $lat1
     * @param $lng2
     * @param $lat2
     * @return int
     */
    public function getdistance($lng1, $lat1, $lng2, $lat2)
    {
        // 将角度转为狐度
        $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;

        return $s;
    }

    /**
     * 获取需求结束时间
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return array|string
     */
    public function getEndtime()
    {
        $day = $this->request->input('day');
        $hour = $this->request->input('hour');

        return ($day * 24 * 60 * 60) + ($hour * 60 * 60) + time();
    }

    /**
     * 保存单个商品信息
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return mixed
     */
    public function putGoodsInfo()
    {
        $param = $this->request->except('_token');
        $param = array_filter($param);
        $oldParam = $this->getGoodsInfo();
        foreach ($param as $k => $v) {
            $oldParam[$k] = $v;
        }
        session(['goods_info' => $oldParam]);

        return session()->save();
    }

    /**
     * 获取商品信息
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return array
     */
    public function getGoodsInfo()
    {
        return session('goods_info') ? : [];
    }

    /**
     * 清除商品信息
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return mixed
     */
    public function clearGoodsInfo()
    {
        return session()->forget('goods_info');
    }
}