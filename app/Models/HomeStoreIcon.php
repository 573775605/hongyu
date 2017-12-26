<?php

namespace App\Models;

class HomeStoreIcon extends Base
{
    protected $table = 'home_store_icon';

    protected $guarded = ['id'];

    public $timestamps = false;

    public function defaultValue()
    {
        return [
            'create_time' => date('Y-m-d h:i:s'),
            'status'      => 1,
        ];
    }

    public function img()
    {
        return $this->belongsTo(File::class, 'img_id', 'id');
    }
}
