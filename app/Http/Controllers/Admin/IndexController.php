<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Node\Menu;
use DB;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/8
 * Time: 16:15
 * Author: wenlongh <wenlongh@qq.com>
 */
class IndexController extends Controller
{

    public function index()
    {
        $menu = new Menu();
        $data = [
            'menuHtml' => $menu->getPermisionMenu(),
        ];

        return view('admin.index', $data);
    }

    public function home()
    {
        $monday = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), date("d") - date("w") + 1, date("Y")));
        $mondayTime = strtotime($monday);
        $weekCond = [
            [
                'start_time' => $monday,
                'end_time'   => date('Y-m-d 23:59:59', strtotime($monday)),
            ],
        ];
        for ($i = 1; $i < 7; $i++) {
            $time = strtotime("+$i day", $mondayTime);
            $weekCond[] = [
                'start_time' => date('Y-m-d H:i:s', $time),
                'end_time'   => date('Y-m-d 23:59:59', $time),
            ];
        }
        $demandSql = 'select ';
        foreach ($weekCond as $k => $v) {
            $demandSql .= 'COUNT(IF(`create_time`>=\'' . $v['start_time'] . '\' AND `create_time`<=\'' . $v['end_time'] . '\' AND `is_pay`=1,id,NULL)) as count' . $k . ',';
            $demandSql .= 'SUM(IF(`create_time`>=\'' . $v['start_time'] . '\' AND `create_time`<=\'' . $v['end_time'] . '\' AND `is_pay`=1,price,0)) as sum' . $k . ',';
        }
        $demandSql = rtrim($demandSql, ',');
        $demandSql .= ' from demand where create_time>=\'' . $monday . '\' AND create_time<=\'' . end($weekCond)['end_time'] . '\'';
        $demand = DB::select($demandSql);
        $demand = (array)reset($demand);

        $userSql = 'select ';
        foreach ($weekCond as $k => $v) {
            $userSql .= 'COUNT(IF(`create_time`>=\'' . $v['start_time'] . '\' AND `create_time`<=\'' . $v['end_time'] . '\',id,NULL)) as count' . $k . ',';
        }
        $userSql = rtrim($userSql, ',');
        $userSql .= ' from user where create_time>=\'' . $monday . '\' AND create_time<=\'' . end($weekCond)['end_time'] . '\'';
        $user = DB::select($userSql);
        $user = (array)reset($user);

        $demandCount = $demandSum = $userCount = [];
        for ($i = 0; $i < 7; $i++) {
            $demandCount[] = $demand['count' . $i];
            $userCount[] = $user['count' . $i];
            $demandSum[] = $demand['sum' . $i];
        }
        $data = [
            'demandSum'        => $demandSum,
            'demandCount'      => $demandCount,
            'userCount'        => $userCount,
            'demandTotalPrice' => DB::table('demand')->where('is_pay', 1)->sum('price'),
            'demandTotalCount' => DB::table('demand')->where('is_pay', 1)->count(),
            'userTotalCount'   => DB::table('user')->count(),
            'pledgeTotalPrice' => DB::table('user')->sum('pledge'),
        ];

        return view('admin.index.home', $data);
    }
}