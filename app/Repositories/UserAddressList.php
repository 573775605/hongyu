<?php

namespace App\Repositories;

use App\Models\UserAddress as UserAddressModel;

class UserAddressList extends BaseList
{
    public static $model = UserAddressModel::class;
}
