<?php

namespace App\Repositories;

use App\Models\UserMessage as UserMessageModel;

class UserMessageList extends BaseList
{
    public static $model = UserMessageModel::class;

    public function setAlreadyRead()
    {
        return $this->getBuilder()->where('status', 1)->update(['status' => 2]);
    }
}
