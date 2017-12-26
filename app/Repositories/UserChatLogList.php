<?php

namespace App\Repositories;

use App\Models\UserChatLog as UserChatLogModel;
use App\Models\UserChatMessage as UserChatMessageModel;

class UserChatLogList extends BaseList
{
    public static $model = UserChatLogModel::class;

    public function countUnreadMessage()
    {
        foreach ($this->getItems() as $v) {
            $v->unread_count = UserChatMessageModel::where(
                function ($q) use ($v) {
                    $q->where(
                        function ($q) use ($v) {
                            $q->where('send_user_id', $v->send_user_id)->where('accept_user_id', $v->accept_user_id);
                        }
                    );
                    $q->orWhere(
                        function ($q) use ($v) {
                            $q->where('send_user_id', $v->accept_user_id)->where('accept_user_id', $v->send_user_id);
                        }
                    );
                }
            )
                ->where('accept_user_id', $v->send_user_id)->where('status', 1)->count() ? : '';
        }

        return $this;
    }

    public function loadFirstMessage()
    {
        foreach ($this->getItems() as $v) {
            $message = UserChatMessageModel::where(
                function ($q) use ($v) {
                    $q->where(
                        function ($q) use ($v) {
                            $q->where('send_user_id', $v->send_user_id)->where('accept_user_id', $v->accept_user_id);
                        }
                    );
                    $q->orWhere(
                        function ($q) use ($v) {
                            $q->where('send_user_id', $v->accept_user_id)->where('accept_user_id', $v->send_user_id);
                        }
                    );
                }
            )
                ->orderBy('id', 'desc')->first();
            $v->first_message = $message ? $message->content : '';
        }
    }

    public function countUnread($userId)
    {
        foreach ($this->getItems() as $v) {
            $v->unread = $v->userChatMessage()->where('accept_user_id', $userId)->where('status', 1)->count();
        }

        return $this;
    }

}