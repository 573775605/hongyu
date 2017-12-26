<?php

namespace App\Models;

class UserMessage extends Base
{
    protected $table = 'user_message';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function defaultValue()
    {
        return [
            'create_time' => date('Y-m-d H:i:s'),
            'status'      => 1,
        ];
    }

    public static $type = [
        'tender' => '报价消息',
        'demand' => '订单消息',
        'system' => '系统消息',
        'other'  => '其他消息',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function demand()
    {
        return $this->belongsTo(Demand::class, 'demand_id');
    }
}
