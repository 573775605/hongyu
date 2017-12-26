<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Demand;
use App\Repositories\DemandGoods;
use App\Repositories\DemandList;
use Excel;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/14
 * Time: 17:12
 * Author: wenlongh <wenlongh@qq.com>
 */
class DemandController extends Controller
{
    public function issue()
    {
        $rows = DemandList::getList($this->getWhere());
        $rows->getItems()->appends(['status' => $this->_request->query('status')]);
        $rows->getItems()->load('user', 'selectUser', 'paymentOrder');
        $data = [
            'rows' => $rows,
        ];

        return view('admin.demand.issue', $data);
    }

    public function recall()
    {
        $id = $this->_request->input('id');
        $remark = $this->_request->input('remark');
        $demand = Demand::initById($id);
        if ($demand->data->status != 1) {
            return $this->returnJson(-1, '该订单不能被撤回' . $demand->data->status);
        }
        if ($demand->recall()->save()) {
            //退回报价用户保证金
            $demand->updateFrostPledge('该订单已被管理员撤回，撤回原因：' . $remark);
            //通知需求用户
            $param = [
                'title'   => '撤回通知',
                'content' => '您的订单已被系统管理员撤回，撤回原因：' . $remark . '。订单编号：' . $demand->data->order_number,
            ];
            $demand->createMessage($param);

            return $this->returnJson();
        }

        return $this->returnJson(-1, '操作失败');
    }

    public function details($id)
    {
        $demand = Demand::initById($id);
        $demand->getData()->load('demandGoods');
        $data = [
            'demand'  => $demand->getData(),
            'status'  => Demand::$status,
            'express' => Demand::$express,
        ];

        return view('admin.demand.details', $data);
    }

    public function goodsDetails($id)
    {
        $goods = DemandGoods::initById($id);
        $goods->getData()->load('imgs');
        $data = [
            'goods' => $goods->getData(),
        ];

        return view('admin.demand.goods_details', $data);
    }

    public function notIssue()
    {
        $cond = $this->getWhere();
        $cond['is_issue'] = 0;
        $rows = DemandList::getList($cond);
        $rows->getItems()->load('user');
        $data = [
            'rows' => $rows,
        ];

        return view('admin.demand.not_issue', $data);
    }

    public function getWhere()
    {
        $keyword = $this->_request->query('keyword');
        $status = $this->_request->query('status');
        $startTime = $this->_request->query('start_time');
        $endTime = $this->_request->query('end_time');
        $cond = [
            'is_issue' => 1,
        ];
        if ($status) {
            $cond['status'] = $status;
        }
        if ($keyword) {
            $cond['keyword'] = $keyword;
        }
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

    public function export()
    {
        $demand = DemandList::getAll($this->getWhere());
        $demand->getItems()->load('user', 'paymentOrder', 'selectUser');
        $data[] = [
            '订单编号',
            '微信单号',
            '发布用户',
            '代购用户',
            '发布金额',
            '报价金额',
            '创建时间',
            '收货人',
        ];
        foreach ($demand->getItems() as $v) {
            $data[] = [
                $v->order_number,
                isset($v->paymentOrder->wechat_order_number) ? $v->paymentOrder->wechat_order_number : '',
                isset($v->user->nickname) ? $v->user->nickname : '',
                isset($v->selectUser->nickname) ? $v->selectUser->nickname : '',
                $v->known_price,
                $v->tender_price,
                $v->create_time,
                $v->consignee . ':' . $v->address,
            ];
        }
        Excel::create(
            date('Y-m-d') . '订单导出',
            function ($excel) use ($data) {
                $excel->sheet(
                    'score',
                    function ($sheet) use ($data) {
                        $sheet->rows($data);
                    }
                );
            }
        )->export('xls');
    }
}