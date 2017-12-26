<?php

namespace App\Models;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/12
 * Time: 20:26
 * Author: wenlongh <wenlongh@qq.com>
 */
use Zizaco\Entrust\EntrustRole;
use Config;

class Role extends EntrustRole
{
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(
            Manager::class,
            Config::get('entrust.role_user_table'),
            Config::get('entrust.role_foreign_key'),
            Config::get('entrust.user_foreign_key')
        );
    }
}