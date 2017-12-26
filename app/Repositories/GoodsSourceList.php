<?php

namespace App\Repositories;

use App\Models\GoodsSource as GoodsSourceModel;

class GoodsSourceList extends BaseList
{

    public static $model = GoodsSourceModel::class;

    protected function defaultOrderBy()
    {
        return $this->getBuilder()->orderBy('sort', 'asc');
    }

    public function loadParent()
    {
        foreach ($this->getItems() as $v) {
            $parent = GoodsSource::getByid($v->parent_id);
            $v->parent = $parent ? $parent->getData() : null;
        }

        return $this;
    }

    public function countDemand()
    {
        foreach ($this->getItems() as $v) {
            $source = GoodsSource::initByModel($v);
            $source->countTotalDemand();
            $source->countIssueDemand();
            $source->countOverDemand();
            $source->countSparePrice();
            $source->save();
        }

        return $this;
    }

    public function countTotalSpare()
    {
        $price = $this->getItems()->sum('total_spare_price');
        $config = Config::getByKey('total_spare_price');
        $config->data->value = $price;

        return $config->save();
    }

}
