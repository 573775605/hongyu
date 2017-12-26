<?php

namespace App\Models;

class UserFeedback extends Base
{
    protected $table = 'user_feedback';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function defaultValue()
    {
        return [
            'status'      => 1,
            'create_time' => date('Y-m-d H:i:s'),
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
