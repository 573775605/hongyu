<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Config;
use App\Repositories\WithdrawApply;
use App\Repositories\WithdrawApplyList;
use App\Models\WithdrawApply as WithdrawApplyModel;
/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/15
 * Time: 14:28
 * Author: wenlongh <wenlongh@qq.com>
 */
class WithdrawController extends Controller
{
    public function index()
    {
        $rows = WithdrawApplyList::getList($this->getWhere());
        $rows->getItems()->load('user');
        $accountType = WithdrawApply::$accountType;
        $status = WithdrawApply::$status;
        $type = WithdrawApply::$type;
        $data = [
            'rows'         => $rows,
            'accountType'  => $accountType,
            'status'       => $status,
            'type'         => $type,
            'scale'        => Config::get('daigou_balance_withdraw_scale') * 100,
            'price'        => WithdrawApplyModel::sum('actual_price'),
            'stayPrice'    => WithdrawApplyModel::where('status', 1)->sum('actual_price'),
            'thenPrice'    => WithdrawApplyModel::where('status', 2)->sum('actual_price'),
            'notpassPrice' => WithdrawApplyModel::where('status', -1)->sum('actual_price'),
        ];

        return view('admin.user.withdraw', $data);
    }

    public function check()
    {
        $id = $this->_request->input('id');
        $status = $this->_request->input('status');
        $remark = $this->_request->input('remark');
        if (WithdrawApply::initById($id)->check($status, $remark)->save()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '数据保存失败');
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
}