<?php

namespace App\Repositories;

use App\Models\Banner as BannerModel;

class BannerList extends BaseList
{

    public static $model = BannerModel::class;

    protected function defaultOrderBy()
    {
        return $this->getBuilder()->orderBy('sort', 'asc');
    }

}
