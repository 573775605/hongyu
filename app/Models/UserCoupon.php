<?php

namespace App\Models;

class UserCoupon extends Base
{
    public $timestamps = true;

    /**
     * 定义数据库表名
     *
     * @var string
     */
    protected $table = 'user_coupon';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
