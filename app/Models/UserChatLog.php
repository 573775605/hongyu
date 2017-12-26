<?php

namespace App\Models;

class UserChatLog extends Base
{
    protected $table = 'user_chat_log';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function defaultValue()
    {
        return [
            'create_time' => date('Y-m-d H:i:s'),
        ];
    }

    public function userChatMessage()
    {
        return $this->hasMany(UserChatMessage::class, 'user_chat_log_id');
    }

    public function sendUser()
    {
        return $this->belongsTo(User::class, 'send_user_id');
    }

    public function acceptUser()
    {
        return $this->belongsTo(User::class, 'accept_user_id');
    }
}
