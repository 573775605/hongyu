<?php

namespace App\Repositories;

use App\Models\GoodsCategory as GoodsCategoryModel;

class GoodsCategoryList extends BaseList
{

    public static $model = GoodsCategoryModel::class;

    protected function defaultOrderBy()
    {
        return $this->getBuilder()->orderBy('sort', 'asc');
    }

    public function loadParent()
    {
        foreach ($this->getItems() as $v) {
            $parent = GoodsCategory::getByid($v->parent_id);
            $v->parent = $parent ? $parent->getData() : null;
        }

        return $this;
    }

}
