<?php

namespace App\Http\Controllers\Admin;

use App\Models\UserFeedback;
use App\Repositories\User;
use App\Repositories\UserFeedbackList;
use App\Repositories\UserList;
use Excel;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/10
 * Time: 15:03
 * Author: wenlongh <wenlongh@qq.com>
 */
class UserController extends Controller
{

    public function index()
    {
        $rows = UserList::getList($this->getWhere());

        return view('admin.user.index', compact('rows'));
    }

    public function frost($id)
    {
        $user = User::initById($id);
        if ($user->frost()->save()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '操作失败');
    }

    public function feedback()
    {
        $feedback = UserFeedbackList::getList();
        $data = [
            'rows' => $feedback,
        ];

        return view('admin.user.feedback', $data);
    }

    public function feedbackReply()
    {
        $id = $this->_request->input('id');
        $reply = $this->_request->input('reply');
        $data = [
            'manager_id' => $this->_request->user()->id,
            'reply'      => $reply,
            'status'     => 2,
        ];
        $feedback = UserFeedback::find($id);
        if ($feedback->fill($data)->save()) {
            $param = [
                'title'   => '反馈通知',
                'content' => '您的意见或反馈平台已处理,处理结果：' . $reply,
            ];
            $user = User::initByModel($feedback->user);
            $user->createSystemMessage($param);

            return $this->returnJson();
        }

        return $this->returnJson(-1, '操作失败，请重试');
    }

    public function getWhere()
    {
        $keyword = $this->_request->query('keyword');
        $startTime = $this->_request->query('start_time');
        $endTime = $this->_request->query('end_time');
        $cond = [];
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
        $user = UserList::getAll($this->getWhere());
        $data[] = [
            '用户昵称',
            '用户性别',
            '代购余额',
            '账户余额',
            '账户押金',
            '所在地区',
            '加入时间',
        ];
        foreach ($user->getItems() as $v) {
            $data[] = [
                $v->nickname,
                $v->sex == 1 ? '男' : '女',
                $v->getDaigouBalance(),
                $v->getBalance(),
                $v->pledge,
                $v->country . '-' . $v->province . '-' . $v->city,
                $v->create_time,
            ];
        }
        Excel::create(
            date('Y-m-d') . '用户导出',
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