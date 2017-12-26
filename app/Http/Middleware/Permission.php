<?php

namespace App\Http\Middleware;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/15
 * Time: 17:52
 * Author: wenlongh <wenlongh@qq.com>
 */
use Zizaco\Entrust\Middleware\EntrustPermission;
use Closure;

class Permission extends EntrustPermission
{
    public function handle($request, Closure $next, $permissions = '')
    {
        $permissions = $permissions ? : ltrim($request->route()->getCompiled()->getStaticPrefix(), '/');

        if (!$request->user()->can(explode('|', $permissions))) {
            if ($request->ajax()) {
                $data = [
                    'status'  => -1,
                    'message' => '没有操作权限',
                ];

                return response()->json($data);
            }

            return response()->view('admin.403');
        }

        return $next($request);
    }
}