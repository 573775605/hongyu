<?php

namespace App\Http\Controllers\Wechat;

use App\Repositories\DemandList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/21
 * Time: 14:02
 * Author: wenlongh <wenlongh@qq.com>
 */
class SearchController extends Controller
{
    public function index()
    {
        return view('wechat.search.index');
    }

    public function result()
    {
        $keyword = $this->request->query('keyword');
        $historySearch = $this->request->cookie('history_search', []);
        if (!in_array($keyword, $historySearch)) {
            $historySearch[] = $keyword;
        }
        $cond = [
            'is_issue' => 1,
            'is_copy'  => 0,
            'keyword'  => $keyword,
            //            function ($q) {
            //                $q->where(
            //                    function ($q) {
            //                        $q->where('end_time', '>=', time())->orWhere('is_select', 1);
            //                    }
            //                );
            //            },
        ];
        $demand = DemandList::getAll($cond);
        $data = [
            'demand' => $demand->getItems(),
        ];

        return response(view('wechat.search.result', $data))->header('Content-Type', 'text/html')
            ->cookie('history_search', $historySearch);

    }

    public function clearSearch()
    {
        \Cookie::queue(\Cookie::forget('history_search'));

        return $this->returnJson();
    }
}