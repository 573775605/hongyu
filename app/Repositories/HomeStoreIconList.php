<?php

namespace App\Repositories;

use App\Models\HomeStoreIcon as HomeStoreIconModel;

class HomeStoreIconList extends BaseList
{
    public static $model = HomeStoreIconModel::class;

    protected function defaultOrderBy()
    {
        return $this->getBuilder()->orderBy('sort', 'asc');
    }
}
