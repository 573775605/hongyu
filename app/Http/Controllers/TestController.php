<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\Input;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/13
 * Time: 13:31
 * Author: wenlongh <wenlongh@qq.com>
 */
class TestController extends Controller
{
    public function index()
    {

       return view('admin.403');
    }
}