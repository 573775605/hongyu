<?php

namespace App\Models;

class UserInfo extends Base
{
    protected $table = 'user_info';

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
