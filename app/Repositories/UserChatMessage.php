<?php

namespace App\Repositories;

use App\Models\UserChatMessage as UserChatMessageModel;

class UserChatMessage extends Base
{
    public static $modelName = UserChatMessageModel::class;

    public function createLog()
    {
        $log = UserChatLog::getOrCreate($this->data->send_user_id, $this->data->accept_user_id);
        $this->data->user_chat_log_id = $log->data->id;

        return $this;
    }

    public function sendMessageNotice()
    {
        if (UserChatMessageModel::where('send_user_id', $this->data->send_user_id)->where('accept_user_id', $this->data->accept_user_id)->where(
            'create_time',
            '>=',
            date(
                'Y-m-d 00:00:00'
            )
        )->where('create_time', '<=', date('Y-m-d 23:59:59'))->count()
        ) {
            return false;
        }
        $templateId = 'wDa-Hd9jDIa_GUWexWljLVSABLitimhsiqvpqVir-60';
        $notice = app('wechat')->notice;
        try {
            $notice->send(
                [
                    'touser'      => $this->data->acceptUser->openid,
                    'template_id' => $templateId,
                    'url'         => url('wechat/chat/message/' . $this->data->send_user_id),
                    'data'        => [
                        'first'    => '您好！您收到一条咨询信息。',
                        'keyword1' => date('Y年m月d日H时i分s秒'),
                        'keyword2' => $this->data->sendUser->nickname,
                        'keyword3' => '聊天咨询',
                        'keyword4' => '红利订单咨询',
                        'remark'   => '点击查看详情！',
                    ],
                ]
            );
        } catch (HttpException $e) {

        }
    }

}
