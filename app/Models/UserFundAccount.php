<?php

namespace App\Models;

class UserFundAccount extends Base
{
    protected $table = 'user_fund_account';

    protected $guarded = ['id'];

    public $timestamps = true;

    public function defaultValue()
    {
        return [];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
