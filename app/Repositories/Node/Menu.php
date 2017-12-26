<?php

namespace App\Repositories\Node;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/9
 * Time: 09:52
 * Author: wenlongh <wenlongh@qq.com>
 */
use Auth;

class Menu
{
    public $user;

    public function __construct($guard = 'manager')
    {
        $this->user = Auth::user($guard);
    }

    public static function getMenu()
    {
        return [
            [
                'title' => '需求管理',
                'child' => [
                    [
                        'title' => '已发布需求',
                        'url'   => 'admin/demand/issue',
                    ],
                    [
                        'title' => '未发布需求',
                        'url'   => 'admin/demand/not-issue',
                    ],
                    [
                        'title' => '申请退货',
                        'url'   => 'admin/demand/return-apply',
                    ],
                ],
            ],
            [
                'title' => '财务管理',
                'child' => [
                    [
                        'title' => '提现申请',
                        'url'   => 'admin/user/withdraw',
                    ],
                    [
                        'title' => '交易统计',
                        'url'   => 'admin/count/demand',
                    ],
                    [
                        'title' => '区域统计',
                        'url'   => 'admin/count/province-demand',
                    ],
                ],
            ],
            [
                'title' => '用户管理',
                'child' => [
                    [
                        'title' => '用户列表',
                        'url'   => 'admin/user/index',
                    ],
                    [
                        'title' => '资料审核',
                        'url'   => 'admin/user/auth',
                    ],
                    [
                        'title' => '聊天记录',
                        'url'   => 'admin/message/chat',
                    ],
                    [
                        'title' => '意见反馈',
                        'url'   => 'admin/user/feedback',
                    ],
                ],
            ],
            [
                'title' => '活动管理',
                'child' => [
                    [
                        'title' => '优惠券管理',
                        'url'   => 'admin/coupon/index',
                    ],
                ],
            ],
            [
                'title' => '运营管理',
                'child' => [
                    [
                        'title' => '广告管理',
                        'url'   => 'admin/banner/index',
                    ],
                    [
                        'title' => '推荐商城',
                        'url'   => 'admin/home-store/index',
                    ],
                    [
                        'title' => '文章分类',
                        'url'   => 'admin/article/category/index',
                    ],
                    [
                        'title' => '文章列表',
                        'url'   => 'admin/article/index',
                    ],
                    [
                        'title' => '商品分类',
                        'url'   => 'admin/goods-category/index',
                    ],
                    //                    [
                    //                        'title' => '商品单位',
                    //                        'url'   => 'admin/goods-unit/index',
                    //                    ],
                    [
                        'title' => '货源配置',
                        'url'   => 'admin/goods-source/index',
                    ],
                    [
                        'title' => '报价优势',
                        'url'   => 'admin/quote-config/index',
                    ],
                    [
                        'title' => '介绍说明',
                        'url'   => 'admin/config/explain',
                    ],
                    [
                        'title' => '公众号设置',
                        'url'   => 'admin/config/wechat-set',
                    ],
                ],
            ],
            [
                'title' => '系统管理',
                'child' => [
                    [
                        'title' => '管理用户',
                        'url'   => 'admin/manager/index',
                    ],
                    [
                        'title' => '角色列表',
                        'url'   => 'admin/rbac/role',
                    ],
                    [
                        'title' => '权限列表',
                        'url'   => 'admin/rbac/permission',
                    ],
                ],
            ],
        ];
    }

    public static function getHtml(array $menu = [])
    {
        $html = $child = '';
        $menu = $menu ? : static::getMenu();
        foreach ($menu as $v) {
            if (isset($v['child'])) {
                $child = static::getChild($v['child']);
            }
            $html .= view('admin.menu', ['menu' => $v, 'child' => $child])->render();
        }

        return $html;
    }

    private static function getChild($child)
    {
        $html = $childHtml = '';
        foreach ($child as $v) {
            if (isset($v['child'])) {
                $childHtml = static::getHtml($v['child']);
            }
            $html .= view('admin.menu', ['menu' => $v, 'child' => $childHtml])->render();
        }

        return $html;
    }

    public function getPermisionMenu()
    {
        $menu = static::getMenu();
        $actionMenu = [];
        foreach ($menu as $v) {
            if (isset($v['child'])) {
                $child = $this->getChildMenu($v['child']);
                if ($child) {
                    $row = $v;
                    $row['child'] = $child;
                    $actionMenu[] = $row;
                }
            } else {
                if ($this->user->can($v['url'])) {
                    $actionMenu = $v;
                }
            }
        }

        return static::getHtml($actionMenu);
    }

    public function getChildMenu($child)
    {
        $result = [];
        foreach ($child as $v) {
            if (isset($v['child'])) {
                $row = $v;
                $row['child'] = $this->getChildMenu($v['child']);
                $result[] = $row;
            } else {
                if ($this->user->can($v['url'])) {
                    $result[] = $v;
                }
            }
        }

        return $result;
    }
}