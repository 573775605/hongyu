<?php

namespace App\Models;

class DemandGoods extends Base
{
    protected $table = 'demand_goods';

    protected $guarded = ['id'];

    public $timestamps = true;

    public $goodsImg;

    public function demand()
    {
        return $this->belongsTo(Demand::class, 'demand_id');
    }

    public function goodsCategory()
    {
        return $this->belongsTo(GoodsCategory::class, 'category_id');
    }

    public function img()
    {
        return $this->belongsTo(File::class, 'img_id');
    }

    public function imgs()
    {
        return $this->belongsToMany(File::class, 'goods_img', 'demand_goods_id', 'img_id');
    }

    public function getSite()
    {
        return $this->province . $this->city . $this->area . $this->address;
    }
}
