<?php

namespace App\Models;

class ReturnGoodsApply extends Base
{
    protected $table = 'return_goods_apply';

    protected $guarded = ['id'];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function demand()
    {
        return $this->belongsTo(Demand::class, 'demand_id');
    }
}
