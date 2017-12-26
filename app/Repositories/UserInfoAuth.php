<?php

namespace App\Repositories;

use App\Models\UserInfoAuth as UserInfoAuthModel;

class UserInfoAuth extends Base
{
    public static $modelName = UserInfoAuthModel::class;

    public static $status = [
        -1 => '不通过',
        1  => '待审核',
        2  => '已通过',
    ];

    public function check($status, $remark = '')
    {
        $this->data->is_check = 1;
        $this->data->check_time = date('Y-m-d H:i:s');
        $this->data->check_remark = $remark;
        $this->data->status = $status;
        if ($status == 2) {
            $user = User::initByModel($this->data->user);
            $user->authPass($this->getData())->save();
            $content = '认证资料审核已通过';
        } else {
            $content = '认证资料审核未通过。处理结果：' . $remark;
        }
        $param = [
            'title'   => '认证通知',
            'content' => $content,
        ];
        $user = User::initByModel($this->data->user);
        $user->createSystemMessage($param);

        return $this;
    }

}
