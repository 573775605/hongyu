<?php

namespace App\Http\Controllers\Wechat;

use App\Models\UserChatMessage;
use App\Models\UserMessage;
use App\Repositories\UserMessageList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/21
 * Time: 13:48
 * Author: wenlongh <wenlongh@qq.com>
 */
class MessageController extends Controller
{
    public function index()
    {
        $data = [
            'chatMessageCount'   => UserChatMessage::where('accept_user_id', $this->getUserId())->where('status', 1)->count(),
            'tenderMessageCount' => UserMessage::where('user_id', $this->getUserId())->where('type', 'tender')->where('status', 1)->count(),
            'demandMessageCount' => UserMessage::where('user_id', $this->getUserId())->where('type', 'demand')->where('status', 1)->count(),
            'systemMessageCount' => UserMessage::where('user_id', $this->getUserId())->where('type', 'system')->where('status', 1)->count(),
            'otherMessageCount'  => UserMessage::where('user_id', $this->getUserId())->where('type', 'system')->where('status', 1)->count(),
        ];

        return view('wechat.message.index', $data);
    }

    public function content($type)
    {
        $cond = [
            'user_id' => $this->getUserId(),
            'type'    => $type,
        ];
        $message = UserMessageList::getList($cond);
        $message->setAlreadyRead();
        $data = [
            'message' => $message->getItems(),
            'title'   => UserMessage::$type[$type],
        ];
        if ($this->request->ajax()) {
            $data = [
                'rows' => view('wechat.message.paging', $data)->render(),
            ];

            return $this->returnJson(1, 'ok', $data);
        }

        return view('wechat.message.content', $data);
    }

    public function remove($id)
    {
        $message = UserMessage::where('id', $id)->where('user_id', $this->getUserId())->first();
        if ($message->delete()) {
            return $this->returnJson(1);
        }

        return $this->returnJson(-1);
    }
}