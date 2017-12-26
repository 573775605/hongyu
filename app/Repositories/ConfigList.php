<?php

namespace App\Repositories;

use App\Models\Config as ConfigModel;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/20
 * Time: 13:35
 * Author: wenlongh <wenlongh@qq.com>
 */
class ConfigList extends BaseList
{
    public static $model = ConfigModel::class;
}