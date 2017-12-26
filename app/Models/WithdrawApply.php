<?php

namespace App\Models;

class WithdrawApply extends Base
{
    protected $table = 'withdraw_apply';

    protected $guarded = ['id'];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
