<?php

namespace App\Models;

class Config extends Base
{
    protected $table = 'config';

    protected $guarded = ['id'];

    public $timestamps = true;

    public function defaultValue()
    {
        return [];
    }
}
