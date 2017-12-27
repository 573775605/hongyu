<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('test', 'TestController@index');
//用户认证
Route::group(
    [
        'namespace' => 'Auth',
        'prefix'    => 'auth',
    ],
    function () {
        //管理员认证
        Route::any(
            'manager',
            [
                'middleware' => 'guest:manager',
                'uses'       => 'AuthController@manager',
            ]
        )->name('managerAuth');
    }
);
//管理平台
Route::group(
    [
        'namespace'  => 'Admin',
        'prefix'     => 'admin',
        'middleware' => ['auth:manager'],
    ],
    function () {
        Route::get('/', 'IndexController@index');
        Route::group(
            ['prefix' => 'index'],
            function () {
                Route::get('home', 'IndexController@home');
            }
        );
        //上传图片
        Route::any('upload', 'UploadController@uploadImg');
        Route::get('manager/logout', 'ManagerController@logout');
        Route::any('manager/change-password', 'ManagerController@changePassword');

        Route::group(
            ['middleware' => 'permission'],
            function () {
                Route::group(
                    ['prefix' => 'demand'],
                    function () {
                        Route::get('issue', 'DemandController@issue');
                        Route::get('export', 'DemandController@export');
                        Route::post('recall', 'DemandController@recall');
                        Route::get('details/{id}', 'DemandController@details');
                        Route::get('goods-details/{id}', 'DemandController@goodsDetails');
                        Route::get('not-issue', 'DemandController@notIssue');

                        Route::get('return-apply', 'ReturnApplyController@index');
                        Route::post('return-apply/check', 'ReturnApplyController@check');
                        Route::get('return-apply/export', 'ReturnApplyController@export');
                    }
                );

                Route::group(
                    ['prefix' => 'rbac'],
                    function () {
                        Route::get('permission', 'Rbac\PermissionController@index');
                        Route::any('permission/add', 'Rbac\PermissionController@add');
                        Route::any('permission/edit/{id}', 'Rbac\PermissionController@edit');
                        Route::any('permission/remove/{id}', 'Rbac\PermissionController@remove');

                        Route::get('role', 'Rbac\RoleController@index');
                        Route::any('role/add', 'Rbac\RoleController@add');
                        Route::any('role/edit/{id}', 'Rbac\RoleController@edit');
                        Route::any('role/remove/{id}', 'Rbac\RoleController@remove');
                    }
                );

                Route::group(
                    ['prefix' => 'user'],
                    function () {
                        Route::get('index', 'UserController@index');
                        Route::get('export', 'UserController@export');
                        Route::get('feedback', 'UserController@feedback');
                        Route::post('feedback-reply', 'UserController@feedbackReply');
                        Route::post('frost/{id}', 'UserController@frost');

                        Route::get('auth', 'UserAuthController@index');
                        Route::post('auth/check', 'UserAuthController@check');
                        Route::get('auth/view/{id}', 'UserAuthController@view');

                        Route::get('withdraw', 'WithdrawController@index');
                        Route::post('withdraw/check', 'WithdrawController@check');
                    }
                );

                Route::group(
                    ['prefix' => 'message'],
                    function () {
                        Route::get('chat', 'MessageController@chat');
                        Route::post('remove-chat/{id}', 'MessageController@removeChat');
                    }
                );

                Route::group(
                    ['prefix' => 'manager'],
                    function () {
                        Route::get('index', 'ManagerController@index');
                        Route::any('add', 'ManagerController@add');
                        Route::any('edit/{id}', 'ManagerController@edit');
                        Route::any('remove/{id}', 'ManagerController@remove');
                    }
                );

                Route::group(
                    ['prefix' => 'banner'],
                    function () {
                        Route::get('index', 'BannerController@index');
                        Route::any('add', 'BannerController@add');
                        Route::any('edit/{id}', 'BannerController@edit');
                        Route::post('remove/{id}', 'BannerController@remove');
                    }
                );

                Route::group(
                    ['prefix' => 'home-store'],
                    function () {
                        Route::get('index', 'HomeStoreController@index');
                        Route::any('add', 'HomeStoreController@add');
                        Route::any('edit/{id}', 'HomeStoreController@edit');
                        Route::post('remove/{id}', 'HomeStoreController@remove');
                    }
                );

                Route::group(
                    ['prefix' => 'coupon'],
                    function () {
                        Route::get('index', 'CouponController@index');
                        Route::any('add', 'CouponController@add');
                        Route::any('edit/{id}', 'CouponController@edit');
                        Route::post('remove/{id}', 'CouponController@remove');
                    }
                );

                Route::group(
                    ['prefix' => 'quote-config'],
                    function () {
                        Route::get('index', 'QuoteConfigController@index');
                        Route::any('add', 'QuoteConfigController@add');
                        Route::any('edit/{id}', 'QuoteConfigController@edit');
                        Route::post('remove/{id}', 'QuoteConfigController@remove');
                    }
                );

                Route::group(
                    ['prefix' => 'article'],
                    function () {
                        Route::get('category/index', 'ArticleCategoryController@index');
                        Route::any('category/add', 'ArticleCategoryController@add');
                        Route::any('category/edit/{id}', 'ArticleCategoryController@edit');
                        Route::post('category/remove/{id}', 'ArticleCategoryController@remove');

                        Route::get('index', 'ArticleController@index');
                        Route::any('add', 'ArticleController@add');
                        Route::any('edit/{id}', 'ArticleController@edit');
                        Route::post('remove/{id}', 'ArticleController@remove');
                    }
                );

                Route::group(
                    ['prefix' => 'goods-category'],
                    function () {
                        Route::get('index', 'GoodsCategoryController@index');
                        Route::any('add', 'GoodsCategoryController@add');
                        Route::any('edit/{id}', 'GoodsCategoryController@edit');
                        Route::post('remove/{id}', 'GoodsCategoryController@remove');
                    }
                );

                Route::group(
                    ['prefix' => 'goods-unit'],
                    function () {
                        Route::get('index', 'GoodsUnitController@index');
                        Route::any('add', 'GoodsUnitController@add');
                        Route::any('edit/{id}', 'GoodsUnitController@edit');
                        Route::post('remove/{id}', 'GoodsUnitController@remove');
                    }
                );

                Route::group(
                    ['prefix' => 'goods-source'],
                    function () {
                        Route::get('index', 'GoodsSourceController@index');
                        Route::get('citydata', 'GoodsSourceController@citydata');
                        Route::any('add', 'GoodsSourceController@add');
                        Route::any('edit/{id}', 'GoodsSourceController@edit');
                        Route::post('remove/{id}', 'GoodsSourceController@remove');
                    }
                );

                Route::group(
                    ['prefix' => 'config'],
                    function () {
                        Route::any('explain', 'ConfigController@explain');
                        Route::any('wechat-set', 'ConfigController@wechatSet')->name('wechatSet');
                        Route::post('save-scale', 'ConfigController@saveScale');
                    }
                );

                Route::group(
                    ['prefix' => 'count'],
                    function () {
                        Route::get('demand', 'CountController@demand');
                        Route::get('province-demand', 'CountController@provinceDemand');
                        Route::get('city-demand', 'CountController@cityDemand');
                    }
                );
            }
        );

    }
);
//官网
Route::get(
    '/',
    function () {
        return view('web.index');
    }
);
//微信端
Route::any('wechat/message', 'WechatController@index');
Route::any('wechat/check-browse', 'Wechat\IssueController@checkBrowse');
//支付回调
Route::any('wechat/pay/callback', 'Wechat\PayController@callback');
Route::get('wechat/set-menu', 'WechatController@setMenu');
Route::group(
    [
        'namespace'  => 'Wechat',
        'prefix'     => 'wechat',
        'middleware' => ['wechat.oauth'],
    ],
    function () {
        //上传图片
        Route::any('upload', 'UploadController@uploadImg');
        Route::any('uploads', 'UploadController@uploadImgs');
        Route::any('/', 'IndexController@index');
        Route::group(
            ['prefix' => 'index'],
            function () {
                Route::get(
                    'iframe',
                    function () {
                        return view('wechat.iframe');
                    }
                );
                Route::post('distance-sort', 'IndexController@distanceSort');
            }
        );
        //发布需求
        Route::group(
            ['prefix' => 'issue'],
            function () {
                Route::get('browse', 'IssueController@browse');
                Route::any('index', 'IssueController@index');
                Route::any('grab', 'GrabController@index');
                Route::get('select-source', 'IssueController@selectSource');
                Route::get('select-category', 'IssueController@selectCategory');
                Route::any('select-site', 'IssueController@selectSite');
                Route::get(
                    'success',
                    function () {
                        return view('wechat.Issue.issue_success');
                    }
                );
            }
        );
        //发布需求订单
        Route::group(
            ['prefix' => 'demand'],
            function () {
                Route::get('index', 'DemandController@index');
                Route::any('edit/{goodsId}', 'DemandController@edit');
                Route::post('paging', 'DemandController@paging');
                Route::post('issue/{id}', 'DemandController@issue');
                Route::any('copy-demand/{id?}', 'DemandController@copyDemand');
                Route::post('recall/{id}', 'DemandController@recall');
                Route::post('remove/{id}', 'DemandController@remove');
                Route::any('return-goods/{id}', 'DemandController@returnGoods');
                Route::any('evaluate/{id}', 'DemandController@evaluate');
                Route::post('confirm-signfor/{id}', 'DemandController@confirmSignfor');
                Route::get('details/{id}', 'DemandController@details');
                Route::get('hotboom-store-site', 'DemandController@hotboomStoreSite');
                Route::get('view-logistics/{id}', 'DemandController@viewLogistics');
                Route::get('pay/{id}/{userCouponId?}', 'DemandController@pay');

                Route::any('filter', 'DemandFilterController@index');
            }
        );
        //投标报价
        Route::group(
            ['prefix' => 'tender'],
            function () {
                Route::get('demand-details/{demandId}', 'UserTenderController@demandDetails');
                Route::get('store-site/{goodsId}', 'UserTenderController@storeSite');
                Route::post('tender-check/{demandId}', 'UserTenderController@tenderCheck');
                Route::any('index', 'UserTenderController@index');
                Route::any('edit/{id}', 'UserTenderController@edit');
                Route::any('edit-repertory/{id}', 'UserTenderController@editRepertory');
                Route::post('edit-sub/{id}', 'UserTenderController@editSub');
                Route::post('select-advantage', 'UserTenderController@selectAdvantage');
                Route::post('select-store-site', 'UserTenderController@selectStoreSite');
                Route::post('submit', 'UserTenderController@submit');
                Route::post('select/{id}', 'UserTenderController@select');
                Route::post('cancel/{id}', 'UserTenderController@cancel');
                Route::delete('{id}', 'UserTenderController@delete')->name('tenderDelete');
            }
        );
        //代购需求订单
        Route::group(
            ['prefix' => 'hotboom-demand'],
            function () {
                Route::get('index', 'HotboomDemandController@index');
                Route::post('paging', 'HotboomDemandController@paging');
                Route::post('return-check/{id}', 'HotboomDemandController@returnCheck');
                Route::get('details/{id}', 'HotboomDemandController@details');
                Route::get('tender-details/{id}', 'HotboomDemandController@tenderDetails');
                Route::any('delivery/{id}', 'HotboomDemandController@delivery');
                Route::any('evaluate/{id}', 'HotboomDemandController@evaluate');
            }
        );
        //代购车
        Route::group(
            ['prefix' => 'hotboom-cart'],
            function () {
                Route::any('index', 'HotboomCartController@index');
                Route::post('add/{demandId}', 'HotboomCartController@add');
            }
        );

        Route::group(
            ['prefix' => 'user'],
            function () {
                Route::any('feedback', 'UserController@feedback');
                Route::any('user-info', 'UserController@userInfo');
                Route::post('hide-mobile', 'UserController@hideMobile');
                Route::any('pledge-recharge', 'UserController@pledgeRecharge');
                Route::any('bind-mobile', 'UserController@bindMobile');
                Route::get('wallet', 'UserController@wallet');
                Route::get('coupon', 'UserController@coupon');
                Route::get('issue-demand/{id}/{demandId}', 'UserController@issueDemand');
                Route::any('hotboom-info/{userTenderId}', 'UserController@hotboomInfo');
                Route::any('perfect-info', 'UserController@perfectInfo');
                Route::post('send-verifycode', 'UserController@sendVerifycode');
                Route::any('all-evaluate/{type}/{userId}', 'UserController@allEvaluate');
            }
        );
        //我的钱包
        Route::group(
            ['prefix' => 'wallet'],
            function () {
                Route::any('spare-log', 'WalletController@spareLog');
                Route::any('balance-log', 'WalletController@balanceLog');
                Route::any('pledge-log', 'WalletController@pledgeLog');
                Route::any('hotboom-balance-log', 'WalletController@hotboomBalanceLog');
                Route::any('alipay-account', 'WalletController@alipayAccount');
                Route::get('bank-list', 'WalletController@bankList');
                Route::any('add-bank', 'WalletController@addBank');
                Route::post('remove-bank/{id}', 'WalletController@removeBank');
                Route::any('withdraw', 'WalletController@withdraw');
            }
        );
        //收货地址
        Route::group(
            ['prefix' => 'address'],
            function () {
                Route::get('/', 'AddressController@index');
                Route::any('add', 'AddressController@add');
                Route::any('edit/{id}', 'AddressController@edit');
                Route::post('remove/{id}', 'AddressController@remove');
                Route::post('set-default/{id}', 'AddressController@setDefault');
            }
        );

        Route::group(
            ['prefix' => 'message'],
            function () {
                Route::get('index', 'MessageController@index');
                Route::any('content/{type}', 'MessageController@content');
                Route::post('remove/{id}', 'MessageController@remove');
            }
        );

        Route::group(
            ['prefix' => 'search'],
            function () {
                Route::get('index', 'SearchController@index');
                Route::get('result', 'SearchController@result');
                Route::post('clear-search', 'SearchController@clearSearch');
            }
        );

        Route::group(
            ['prefix' => 'center'],
            function () {
                Route::get('/', 'CenterController@index');
                Route::any('tender-list', 'CenterController@tenderList');
                Route::post('cart-remove/{id}', 'CenterController@cartRemove');
                Route::get('evaluate-grade', 'CenterController@evaluateGrade');
                Route::any('evaluate-grade-log', 'CenterController@evaluateGradeLog');
            }
        );

        Route::group(
            ['prefix' => 'about'],
            function () {
                Route::get('index', 'AboutController@index');
                Route::get('explain-article/{key}', 'AboutController@explainArticle');
                Route::get('article-details/{id}', 'AboutController@articleDetails');
            }
        );

        Route::group(
            ['prefix' => 'chat'],
            function () {
                Route::get('index', 'ChatController@index');
                Route::get('message/{acceptUserId}', 'ChatController@message');
                Route::post('send', 'ChatController@send');
                Route::post('pull', 'ChatController@pull');
                Route::post('paging', 'ChatController@paging');
                Route::delete('{id}', 'ChatController@delete')->name('chatDelete');
            }
        );

        Route::group(
            ['prefix' => 'pay'],
            function () {
                Route::get('/{id}', 'PayController@pay');
            }
        );
    }
);
