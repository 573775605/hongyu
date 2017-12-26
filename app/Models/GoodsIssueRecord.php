<?php

namespace App\Models;

class GoodsIssueRecord extends Base
{
    protected $table = 'goods_issue_record';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function goodsCategory()
    {
        return $this->belongsTo(GoodsCategory::class, 'category_id');
    }
}
