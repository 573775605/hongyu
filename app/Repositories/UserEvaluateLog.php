<?php

namespace App\Repositories;

use App\Models\UserEvaluateLog as UserEvaluateLogModel;

class UserEvaluateLog extends Base
{
    public static $modelName = UserEvaluateLogModel::class;

    /**
     * 计算评价得分
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function countGrade()
    {
        $totalGrade = $this->data->goods_grade;
        $totalGrade += $this->data->service_grade;
        $totalGrade += $this->data->delivery_grade;
        $totalGrade += $this->data->logistics_grade;
        $this->data->avg_grade = intval($totalGrade / 4);
        //修改用户总评分
        $user = User::initByModel($this->data->user);
        $user->issueEvaluate($this->data->avg_grade)->save();

        return $this;
    }

}
