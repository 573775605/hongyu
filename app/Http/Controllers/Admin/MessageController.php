<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\UserChatMessage;
use App\Repositories\UserChatMessageList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/28
 * Time: 13:45
 * Author: wenlongh <wenlongh@qq.com>
 */
class MessageController extends Controller
{
    public function chat()
    {
//        $keyword = $this->_request->query('keyword');
//        $cond = [];
//        if ($keyword) {
//            $cond['keyword'] = $keyword;
//        }
        $message = UserChatMessageList::getList($this->getWhere());
        $message->getItems()->load('sendUser', 'acceptUser');
        $data = [
            'rows' => $message,
        ];

        return view('admin.message.chat', $data);
    }

    public function removeChat($id)
    {
        $message = UserChatMessage::initById($id);
        if ($message->delete()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
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
}