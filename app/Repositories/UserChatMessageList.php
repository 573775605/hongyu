<?php

namespace App\Repositories;

use App\Models\UserChatMessage as UserChatMessageModel;

class UserChatMessageList extends BaseList
{
    public static $model = UserChatMessageModel::class;

    public function customerCondition()
    {
        return [
            'keyword' => function ($q, $param) {
                $q->where('content', 'like', "%{$param}%");
                $q->orWhereHas(
                    'sendUser',
                    function ($q) use ($param) {
                        $q->where('nickname', 'like', "%{$param}%");
                    }
                );
            },
        ];
    }

    public function update($userId)
    {
        return $this->getBuilder()->where('accept_user_id', $userId)->update(['status' => 2]);
    }

}