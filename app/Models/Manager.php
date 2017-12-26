<?php

namespace App\Models;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/8
 * Time: 10:52
 * Author: wenlongh <wenlongh@qq.com>
 */
use Zizaco\Entrust\Traits\EntrustUserTrait;

class Manager extends Auth
{
    use EntrustUserTrait;

    protected $table = 'manager';

    protected $guarded = ['id', 'password'];

    public $timestamps = true;
}