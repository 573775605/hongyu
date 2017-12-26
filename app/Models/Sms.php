<?php

namespace App\Models;

class Sms extends Base
{
    protected $table = 'sms';

    protected $guarded = ['id'];

    public $timestamps = true;
}
