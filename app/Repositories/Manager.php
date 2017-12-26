<?php

namespace App\Repositories;

use Hash;
use App\Models\Manager as ManagerModel;

class Manager extends Base
{
    public static $modelName = ManagerModel::class;

    public function setPassword($password)
    {
        $this->data->password = Hash::make($password);

        return $this;
    }

    public function checkPassword($password)
    {
        return Hash::check($password, $this->data->password);
    }
}
