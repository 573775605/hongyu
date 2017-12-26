<?php

namespace App\Repositories;

use App\Models\DemandGoods as DemandGoodsModel;

class DemandGoods extends Base
{
    public static $modelName = DemandGoodsModel::class;

    public static $type = [
        'link'   => '链接地址',
        'upload' => '本地上传',
    ];

    public function updateCache($data = [])
    {
        foreach ($data as $k => $v) {
            if ($k != 'imgs') {
                if ($this->data->$k !== null) {
                    $this->data->$k = $v;
                }
            }
        }

        return $this;
    }

    public function countPrice()
    {
        $price = $this->data->known_unit_price * $this->data->count;
        $this->data->price = $price;

        return $this;
    }

    public function updateDemand()
    {
        $deamnd = Demand::initByModel($this->data->demand);
        $deamnd->countGoodsPrice();

        return $deamnd->save();
    }

    public function syncImgs($data = [])
    {
        return $this->data->imgs()->sync($data);
    }

}
