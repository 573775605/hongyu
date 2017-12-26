<?php

namespace App\Repositories;

use App\Models\User as UserModel;

class UserList extends BaseList
{
    public static $model = UserModel::class;

    public function customerCondition()
    {
        return [
            'keyword' => function ($q, $param) {
                $q->where('nickname', 'like', '%' . $param . '%');
            },
        ];
    }
}
