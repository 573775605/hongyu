<?php

namespace App\Http\Controllers\Wechat;

use App\Repositories\Demand;
use App\Repositories\DemandList;
use App\Repositories\GoodsCategoryList;
use App\Repositories\GoodsSourceList;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/21
 * Time: 13:56
 * Author: wenlongh <wenlongh@qq.com>
 */
class DemandFilterController extends Controller
{
    public function index()
    {
        $active = $this->request->get('filter-active');
        $sourceId = $this->request->get('source_id');
        $cond = [
            'is_issue' => 1,
            'is_copy'  => 0,
            function ($q) {
                $q->whereIn('status', [1, 3, 5, 6]);
            },
        ];
        if ($sourceId) {
            $cond['source_id'] = $sourceId;
        }
        switch ($active) {
            case 'area':
                //                $cond['issue_province'] = $this->request->query('province');
                $city = $this->request->get('city');
                if (in_array($city, ['北京', '上海', '天津', '重庆'])) {
                    $cond['issue_city'] = $city . '市';
                    $cond['issue_area'] = $this->request->get('area');
                } else {
                    $cond['issue_province'] = $city . '省';
                    $cond['issue_city'] = $this->request->get('area');
                }
                if ($this->request->get('area') == '线上') {
                    unset($cond['issue_province']);
                    unset($cond['issue_city']);
                }
                return $this->result($cond);
                break;
            case 'category':
                $cond ['category_id'] = $this->request->get('category_id');

                return $this->result($cond);
                break;
            case 'filter':
                $minPrice = $this->request->get('min_price');
                $maxPrice = $this->request->get('max_price');
                $filterType = $this->request->get('filter_type');
                $cond = [
                    'is_issue' => 1,
                    'is_copy'  => 0,
                ];
                if ($sourceId) {
                    $cond['source_id'] = $sourceId;
                }
                if ($minPrice) {
                    $cond [] = ['known_price', '>=', $minPrice];
                }
                if ($maxPrice) {
                    $cond [] = ['known_price', '<=', $maxPrice];
                }
                if ($filterType) {
                    if ($filterType == 'not_select') {
                        $cond['status'] = 1;
                    } elseif ($filterType == 'select') {
                        $cond[] = function ($q) {
                            $q->whereIn('status', [3, 5, 6]);
                            $q->whereHas(
                                'selectUserTender',
                                function ($q) {
                                    $q->where('hotboom_type', 'once')->orWhere('repertory', '<', 1);
                                }
                            );
                        };
                    } elseif ($filterType == 'circulation') {
                        $cond[] = function ($q) {
                            $q->whereIn('status', [3, 5, 6]);
                            $q->whereHas(
                                'selectUserTender',
                                function ($q) {
                                    $q->where('hotboom_type', 'circulation')->where('repertory', '>', 0)->where('hotboom_end_time', '>', time());
                                }
                            );
                        };
                    }
                }

                return $this->result($cond);
                break;

            default:
                return $this->result($cond);
                break;
        }
    }

    public function result($cond = [], $demand = null)
    {
        $user = $this->getUser();
        switch ($this->request->get('sort')) {
            case 'price':
                $demand = new DemandList();
                $demand->getBuilder()->orderBy('known_price', $this->request->get('orderby'));
                $demand->where($cond);
                $demand->paginate();
                break;
            case 'distance':
                $demand = DemandList::getNearbyList($user->data->lng, $user->data->lat, $cond);
                break;

            default:
                # code...
                break;
        }
        if (!$demand) {
            $demand = DemandList::getList($cond);
        }
        //计算发布时间
        $demand->countIssueTime();
        //计算距离
        $demand->countDistance($user->data);
        //检测是否循环订单
        $demand->countCirculation();

        $data = [
            'demand' => $demand->getItems(),
            'status' => Demand::$status,
        ];
        if ($this->request->ajax()) {
            $data = [
                'rows' => view('wechat.filter.paging', $data)->render(),
            ];

            return $this->returnJson(1, 'ok', $data);
        }
        //获取商品分类
        $category = GoodsCategoryList::getAll(['status' => 1]);
        $data['category'] = $category->getItems();
        //获取货源信息
        $address = $this->request->get('city');
        if($address) {
            $address_id = GoodsSourceList::getList(['name' => $address])->getItems()->items()[0]['attributes']['id'];
            $cond = [
                'status' => 1,
                'level'  => 2,
                'parent_id' => $address_id
            ];
        } else {
            $cond = [
                'status' => 1,
                'level'  => 2
            ];
        }
        $source = GoodsSourceList::getAll($cond);
        $data['source'] = $source->getItems();
        
        return view('wechat.filter.index', $data);
    }
}