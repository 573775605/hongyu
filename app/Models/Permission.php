<?php

namespace App\Models;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/12
 * Time: 20:23
 * Author: wenlongh <wenlongh@qq.com>
 */
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $guarded = ['id'];
}