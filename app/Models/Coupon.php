<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Base
{
    use SoftDeletes;

    public $timestamps = true;
    /**
     * 定义数据库表名
     *
     * @var string
     */
    protected $table = 'coupon';

    protected $guarded = ['id'];

    public function manager()
    {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

}
