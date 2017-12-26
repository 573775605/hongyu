<?php

namespace App\Models;

class UserChatMessage extends Base
{
    public $timestamps = false;

    protected $table = 'user_chat_message';

    protected $guarded = ['id'];

    public function defaultValue()
    {
        return [
            'status'      => 1,
            'create_time' => date('Y-m-d H:i:s'),
        ];
    }

    public function img()
    {
        return $this->belongsTo(File::class, 'img_id');
    }

    public function userChatLog()
    {
        return $this->belongsTo(UserChatLog::class, 'user_chat_user_id');
    }

    /**
     * 发送用户
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sendUser()
    {
        return $this->belongsTo(User::class, 'send_user_id');
    }

    /**
     * 接受用户
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function acceptUser()
    {
        return $this->belongsTo(User::class, 'accept_user_id');
    }

}
