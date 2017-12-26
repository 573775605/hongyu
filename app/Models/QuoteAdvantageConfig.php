<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/6/12
 * Time: 17:01
 * Author: wenlongh <wenlongh@qq.com>
 */
class QuoteAdvantageConfig extends Base
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $table = 'quote_advantage_config';

}