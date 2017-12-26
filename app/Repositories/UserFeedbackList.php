<?php

namespace App\Repositories;

use App\Models\UserFeedback as UserFeedbackModel;

class UserFeedbackList extends BaseList
{
    public static $model = UserFeedbackModel::class;
}
