<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ExceptionRepository;
use App\Repositories\ReturnGoodsApply;
use App\Repositories\ReturnGoodsApplyList;
use DB;
use Excel;
/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/15
 * Time: 09:51
 * Author: wenlongh <wenlongh@qq.com>
 */
class ReturnApplyController extends Controller
{
    public function index()
    {
        $rows = ReturnGoodsApplyList::getList($this->getWhere());
        $rows->getItems()->load('demand.paymentOrder', 'user');
        $status = ReturnGoodsApply::$status;

        return view('admin.demand.return_apply', compact('rows', 'status'));
    }

    public function check()
    {
        $id = $this->_request->input('id');
        $status = $this->_request->input('status');
        $remark = $this->_request->input('remark');
        try {
            DB::beginTransaction();

            $logic = ReturnGoodsApply::initById($id);
            $logic->check($status, $remark)->save();

            DB::commit();

            return $this->returnJson();
        } catch (ExceptionRepository $e) {
            DB::rollBack();

            return $this->returnJson(-1, $e->getMessage());
        }

    }

    public function getWhere()
    {
        $isCheck = $this->_request->query('is_check');
        $keyword = $this->_request->query('keyword');
        $startTime = $this->_request->query('start_time');
        $endTime = $this->_request->query('end_time');
        $cond = [];
        if ($this->_request->has('is_check')) {
            $cond['is_check'] = $isCheck;
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
        $apply = ReturnGoodsApplyList::getAll($this->getWhere());
        $status = ReturnGoodsApply::$status;
        $apply->getItems()->load('demand.paymentOrder', 'user');
        $data[] = [
            '订单编号',
            '微信单号',
            '支付金额',
            '申请用户',
            '退货说明',
            '申请时间',
            '处理时间',
            '状态',
        ];
        foreach ($apply->getItems() as $v) {
            $data[] = [
                isset($v->demand->order_number) ? $v->demand->order_number : '',
                isset($v->demand->paymentOrder->wechat_order_number) ? $v->demand->paymentOrder->wechat_order_number : '',
                isset($v->demand->price) ? $v->demand->price : '',
                isset($v->user->nickname) ? $v->user->nickname : '',
                $v->remark,
                $v->create_time,
                $v->check_time,
                isset($status[$v->status]) ? $status[$v->status] : '',
            ];
        }
        Excel::create(
            date('Y-m-d') . '退货导出',
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