<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/8
 * Time: 10:24
 * Author: wenlongh <wenlongh@qq.com>
 */
class Controller extends \App\Http\Controllers\Controller
{
    public $_request;

    public function __construct(Request $request)
    {
        $this->_request = $request;
    }
}