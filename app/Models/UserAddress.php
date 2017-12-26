<?php

namespace App\Models;

class UserAddress extends Base
{
    protected $table = 'user_address';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function defaultValue()
    {
        return [

        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
