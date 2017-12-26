<?php

namespace App\Repositories;

use App\Models\UserChatLog as UserChatLogModel;
use EasyWeChat\Core\Exceptions\HttpException;

class UserChatLog extends Base
{
    public static $modelName = UserChatLogModel::class;

    public static function getOrCreate($sendUserId, $acceptUserId)
    {
        $data = UserChatLogModel::where('send_user_id', $sendUserId)->where('accept_user_id', $acceptUserId)->first();
        if (!$data) {
            $param = [
                'send_user_id'   => $sendUserId,
                'accept_user_id' => $acceptUserId,
            ];
            $log = static::create($param);
            $log->save();
            //创建接受消息记录
            $log->createAcceptLog();

            return $log;
        }

        return static::initByModel($data);
    }

    public function createAcceptLog()
    {
        $data = [
            'send_user_id'   => $this->data->accept_user_id,
            'accept_user_id' => $this->data->send_user_id,
        ];
        $log = static::create($data);

        return $log->save();
    }

}
