<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\DemandList;
use DB;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/10/9
 * Time: 10:22
 * Author: wenlongh <wenlongh@qq.com>
 */
class CountController extends Controller
{
    public function demand()
    {
        $demand = DemandList::getList($this->getWhere());
        $data = [
            'rows'        => $demand,
            'dealPrice'   => $demand->getBuilder()->sum('price'),
            'dealCount'   => $demand->getBuilder()->count(),
            'couponPrice' => $demand->getBuilder()->sum('coupon_price'),
        ];

        return view('admin.count.demand', $data);
    }

    public function provinceDemand()
    {
        $startTime = $this->_request->query('start_time');
        $endTime = $this->_request->query('end_time');

        $build = DB::table('demand')->selectRaw('issue_province areaName,count(id) dealCount,sum(price) couponPrice,count(distinct user_id) userCount')->where(
            'is_pay',
            1
        );
        if ($startTime) {
            $build->where('create_time', '>=', $startTime);
        }
        if ($endTime) {
            $build->where('create_time', '<=', $endTime);
        }
        $build->where('status', '<>', -2);
        $data = [
            'rows' => $build->groupBy('issue_province')->get(),
        ];

        return view('admin.count.area_demand', $data);
    }

    public function cityDemand()
    {
        $province = $this->_request->query('province');
        $startTime = $this->_request->query('start_time');
        $endTime = $this->_request->query('end_time');

        $build = DB::table('demand')->selectRaw('issue_city areaName,count(id) dealCount,sum(price) couponPrice,count(distinct user_id) userCount')
            ->where('is_pay', 1)->where('issue_province', $province);
        if ($startTime) {
            $build->where('create_time', '>=', $startTime);
        }
        if ($endTime) {
            $build->where('create_time', '<=', $endTime);
        }
        $build->where('status', '<>', -2);
        $data = [
            'rows' => $build->groupBy('issue_city')->get(),
        ];

        return view('admin.count.area_demand', $data);
    }

    public function getWhere()
    {
        $startTime = $this->_request->query('start_time');
        $endTime = $this->_request->query('end_time');
        $cond = [
            'is_pay' => 1,
            ['status', '<>', -2],
        ];
        if ($startTime) {
            $cond[] = [
                'create_time',
                '>=',
                $startTime,
            ];
        }
        if ($endTime) {
            $cond[] = [
                'create_time',
                '<=',
                $endTime,
            ];
        }

        return $cond;
    }
}