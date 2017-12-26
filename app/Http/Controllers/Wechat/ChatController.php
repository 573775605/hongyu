<?php

namespace App\Http\Controllers\Wechat;

use App\Repositories\UserChatLog;
use App\Repositories\UserChatLogList;
use App\Repositories\UserChatMessage;
use App\Repositories\UserChatMessageList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/15
 * Time: 16:59
 * Author: wenlongh <wenlongh@qq.com>
 */
class ChatController extends Controller
{

    public function index()
    {
        $cond = [
            'send_user_id' => $this->getUserId(),
        ];
        $log = UserChatLogList::getAll($cond);
        $log->loadFirstMessage();
        $log->countUnreadMessage();
        $data = [
            'log'  => $log->getItems(),
            'user' => $this->getUser()->getData(),
        ];

        return view('wechat.chat.index', $data);
    }

    public function message($acceptUserId)
    {
        $cond = function ($q) use ($acceptUserId) {
            $q->where(
                function ($q) use ($acceptUserId) {
                    $q->where('send_user_id', $this->getUserId())->where('accept_user_id', $acceptUserId);
                }
            );
            $q->orWhere(
                function ($q) use ($acceptUserId) {
                    $q->where('send_user_id', $acceptUserId)->where('accept_user_id', $this->getUserId());
                }
            );
        };
        $message = UserChatMessageList::getList($cond);
        $message->update($this->getUserId());
        $data = [
            'message'      => $message->getItems(),
            'user'         => $this->getUser()->getData(),
            'acceptUserId' => $acceptUserId,
        ];

        return view('wechat.chat.message', $data);
    }

    public function send()
    {
        $data = [
            'send_user_id'   => $this->getUserId(),
            'accept_user_id' => $this->request->input('accept_user_id'),
            'img_id'         => $this->request->input('img_id'),
            'content'        => $this->request->input('content'),
        ];
        $message = UserChatMessage::create($data);
        $message->createLog();
        $message->sendMessageNotice();
        if ($message->save()) {
            $param = [
                'content' => $message->getData(),
                'user'    => $this->getUser()->getData(),
            ];
            $data = [
                'html'   => view('wechat.chat.content', $param)->render(),
                'result' => $message->getData()->toArray(),
            ];

            return $this->returnJson(1, 'ok', $data);
        }

        return $this->returnJson(-1);
    }

    public function pull()
    {
        $maxId = $this->request->input('max_id');
        $acceptUserId = $this->request->input('accept_user_id');
        $cond = [
            function ($q) use ($acceptUserId, $maxId) {
                $q->where(
                    function ($q) use ($acceptUserId) {
                        $q->where('send_user_id', $this->getUserId())->where('accept_user_id', $acceptUserId);
                    }
                );
                $q->orWhere(
                    function ($q) use ($acceptUserId) {
                        $q->where('send_user_id', $acceptUserId)->where('accept_user_id', $this->getUserId());
                    }
                );
            },
            ['id', '>', $maxId],
        ];
        $message = UserChatMessageList::getAll($cond);
        $message->update($this->getUserId());
        $param = [
            'user'    => $this->getUser()->getData(),
            'message' => $message->getItems()->sortBy('id'),
        ];
        $data = [
            'message' => view('wechat.chat.paging', $param)->render(),
            'maxId'   => $message->getItems()->count() ? $message->getItems()->first()->id : $maxId,
        ];

        return $this->returnJson(1, 'ok', $data);
    }

    public function paging()
    {
        $maxId = $this->request->input('max_id');
        $acceptUserId = $this->request->input('accept_user_id');
        $cond = [
            function ($q) use ($acceptUserId, $maxId) {
                $q->where(
                    function ($q) use ($acceptUserId) {
                        $q->where('send_user_id', $this->getUserId())->where('accept_user_id', $acceptUserId);
                    }
                );
                $q->orWhere(
                    function ($q) use ($acceptUserId) {
                        $q->where('send_user_id', $acceptUserId)->where('accept_user_id', $this->getUserId());
                    }
                );
            },
            ['id', '<', $maxId],
        ];
        $message = UserChatMessageList::getList($cond);
        $param = [
            'user'    => $this->getUser()->getData(),
            'message' => $message->getItems()->sortBy('id'),
        ];
        $data = [
            'message' => view('wechat.chat.paging', $param)->render(),
        ];

        return $this->returnJson(1, 'ok', $data);
    }

    public function delete($id)
    {
        $log = UserChatLog::initById($id);
        if ($log->delete()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
    }
}