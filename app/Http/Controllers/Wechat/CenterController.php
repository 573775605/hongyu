<?php

namespace App\Http\Controllers\Wechat;

use App\Repositories\Cart;
use App\Repositories\Demand;
use App\Repositories\UserEvaluateLogList;
use App\Repositories\UserHotboomEvaluateLogList;
use App\Repositories\UserTender;
use App\Repositories\UserTenderList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/21
 * Time: 11:11
 * Author: wenlongh <wenlongh@qq.com>
 */
class CenterController extends Controller
{
    public function index()
    {
        $user = $this->getUser();
        $data = [
            'user' => $user->getData(),
        ];

        return view('wechat.center.index', $data);
    }

    public function tenderList()
    {
        $cond = [
            'user_id' => $this->getUserId(),
        ];
        $tender = UserTenderList::getList($cond);
        $data = [
            'rows'         => $tender->getItems(),
            'status'       => UserTender::$status,
            'demandStatus' => Demand::$status,
        ];
        if ($this->request->ajax()) {
            $data = [
                'rows' => view('wechat.center.tender_list_paging', $data)->render(),
            ];

            return $this->returnJson(1, 'ok', $data);
        }

        return view('wechat.center.tender_list', $data);
    }

    public function cartRemove($id)
    {
        $cart = Cart::initById($id);
        if ($cart->delete()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
    }

    public function evaluateGrade()
    {
        $user = $this->getUser();
        $data = [
            'user' => $user->getData(),
        ];

        return view('wechat.center.evaluate_grade', $data);
    }

    public function evaluateGradeLog()
    {
        $type = $this->request->get('type');
        $cond = [
            'user_id' => $this->getUserId(),
        ];
        if ($type == 'issue') {
            $log = UserHotboomEvaluateLogList::getList($cond);
        } else {
            $log = UserEvaluateLogList::getList($cond);
        }
        $data = [
            'evaluate' => $log->getItems(),
        ];
        if ($this->request->ajax()) {
            $data = [
                'rows' => view('wechat.center.evaluate_grade_log_paging', $data)->render(),
            ];

            return $this->returnJson(1, 'ok', $data);
        }

        return view('wechat.center.evaluate_grade_log', $data);
    }
}