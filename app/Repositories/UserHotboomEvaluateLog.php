<?php

namespace App\Repositories;

use App\Models\UserHotboomEvaluateLog as UserHotboomEvaluateLogModel;

class UserHotboomEvaluateLog extends Base
{
    public static $modelName = UserHotboomEvaluateLogModel::class;

    public function syncUserTotalGrade()
    {
        $user = User::initByModel($this->data->user);
        $user->hotboomEvaluate($this->data->grade);
        $user->save();

        return $this;
    }

}
