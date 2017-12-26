<?php

namespace App\Http\Controllers\Wechat;

use App\Repositories\Banner;
use App\Repositories\BannerList;
use App\Repositories\Config;
use App\Repositories\Demand;
use App\Repositories\DemandList;
use App\Repositories\HomeStoreIconList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/16
 * Time: 17:00
 * Author: wenlongh <wenlongh@qq.com>
 */
class IndexController extends Controller
{
    public function index()
    {
        $user = $this->getUser();
        $cond = [
            'is_issue' => 1,
            'status'   => 1,
            'is_copy'  => 0,
        ];
        //获取需求列表
        $demand = DemandList::getList($cond);
        //计算发布时间
        $demand->countIssueTime();
        //计算距离
        $demand->countDistance($user->data);
        if ($this->request->isMethod('post')) {
            $viewData = [
                'demand' => $demand->getItems(),
                'status' => Demand::$status,
            ];
            $data = [
                'rows' => view('wechat.demand.home_paging', $viewData)->render(),
            ];

            return $this->returnJson(1, 'ok', $data);
        }
        //获取广告列表
        $banner = BannerList::getAll(['status' => 1, 'space' => 'home-top']);
        //获取附近需求
        $nearbyDemand = DemandList::getNearbyList($user->data->lng, $user->data->lat, $cond);
        $nearbyDemand->countDistance($user->getData());
        //获取首页推荐商城
        $store = HomeStoreIconList::getAll(['status' => 1]);
        $data = [
            'demand'          => $demand->getItems(),
            'nearbyDemand'    => $nearbyDemand->getItems(),
            'store'           => $store->getItems(),
            'banner'          => $banner->getItems(),
            'centerBanner'    => Banner::getHomeCenter(),
            'useUserCount'    => Config::get('use_user_count', 0),
            'totalSparePrice' => number_format(Config::get('total_spare_price', 0), 2),
        ];

        return view('wechat.index', $data);
    }

    public function distanceSort()
    {
        $user = $this->getUser();
        $cond = [
            'is_issue' => 1,
            'status'   => 1,
            'is_copy'  => 0,
        ];
        $nearbyDemand = DemandList::getNearbyList($user->data->lng, $user->data->lat, $cond);
        $nearbyDemand->countDistance($user->getData());
        $viewData = [
            'demand' => $nearbyDemand->getItems(),
            'status' => Demand::$status,
        ];
        $data = [
            'rows' => view('wechat.demand.home_paging', $viewData)->render(),
        ];

        return $this->returnJson(1, 'ok', $data);
    }
}