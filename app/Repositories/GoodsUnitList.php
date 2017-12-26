<?php

namespace App\Repositories;

use App\Models\GoodsUnit as GoodsUnitModel;

class GoodsUnitList extends BaseList
{
    public static $model = GoodsUnitModel::class;

    public function defaultOrderBy()
    {
        return $this->getBuilder()->orderBy('sort', 'asc');
    }
}
