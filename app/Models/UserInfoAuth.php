<?php

namespace App\Models;

class UserInfoAuth extends Base
{
    protected $table = 'user_info_auth';

    protected $guarded = ['id'];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function frontImg()
    {
        return $this->belongsTo(File::class, 'idcard_front_img');
    }

    public function reverseImg()
    {
        return $this->belongsTo(File::class, 'idcard_reverse_img');
    }
}
