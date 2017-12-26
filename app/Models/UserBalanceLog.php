<?php

namespace App\Models;

class UserBalanceLog extends Base
{
    protected $table = 'user_balance_log';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function defaultValue()
    {
        return [
            'create_time' => date('Y-m-d H:i:s'),
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function demand()
    {
        return $this->belongsTo(Demand::class, 'demand_id');
    }
}
