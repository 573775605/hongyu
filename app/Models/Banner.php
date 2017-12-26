<?php

namespace App\Models;

class Banner extends Base
{
    protected $table = 'banner';

    protected $guarded = ['id'];

    public $timestamps = true;

    public function img()
    {
        return $this->belongsTo(File::class, 'img_id', 'id');
    }
}
