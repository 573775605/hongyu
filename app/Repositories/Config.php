<?php

namespace App\Repositories;

use App\Models\Config as ConfigModel;
use App\Models\User as UserModel;

class Config extends Base
{
    public static $modelName = ConfigModel::class;

    public static function getByKey($key)
    {
        $data = ConfigModel::where('key', $key)->first();

        return $data ? static::initByModel($data) : null;
    }

    public static function get($key, $default = null)
    {
        $config = static::getByKey($key);
        if ($config) {
            return $config->data->value;
        } elseif ($default !== null) {
            return $default;
        } else {
            throw new ExceptionRepository('找不到配置', -2);
        }
    }

    public static function getOrCreate($key)
    {
        $logic = static::getByKey($key);

        return $logic ? : static::create(['key' => $key]);
    }

    public static function countSalesUser()
    {
        $count = UserModel::where('issue_over_demand', '>', 0)->count();
        $config = static::getByKey('use_user_count');
        $config->data->value = $count;

        return $config->save();
    }

}
