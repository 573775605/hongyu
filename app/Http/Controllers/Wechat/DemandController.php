<?php

namespace App\Http\Controllers\Wechat;

use App\Jobs\DisposeFailureDemand;
use App\Jobs\FailurePayDemand;
use App\Repositories\Demand;
use App\Repositories\DemandGoods;
use App\Repositories\DemandGoodsList;
use App\Repositories\DemandList;
use App\Repositories\GoodsUnitList;
use App\Repositories\ReturnGoodsApply;
use App\Repositories\UserAddress;
use App\Repositories\UserCouponList;
use App\Repositories\UserEvaluateLog;
use App\Repositories\UserTender;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/17
 * Time: 15:22
 * Author: wenlongh <wenlongh@qq.com>
 */
class DemandController extends Controller
{
    public function index()
    {
        return view('wechat.demand.index');
    }

    public function edit($goodsId)
    {
        $this->putGoodsInfo();
        $cache = $this->getGoodsInfo();
        $goods = DemandGoods::initById($goodsId);
        $goods->updateCache($cache);

        if ($this->request->isMethod('post')) {
            $submitType = $this->request->input('submit_type');
            switch ($submitType) {
                case 'select-source':
                    return redirect('wechat/issue/select-source?goods_id=' . $goodsId);
                    break;
                case 'select-category':
                    return redirect('wechat/issue/select-category?goods_id=' . $goodsId);
                    break;
                case 'select-site':
                    return redirect('wechat/issue/select-site?goods_id=' . $goodsId.'&select_type=issue_store');
                    break;

                default:
                    $goods->countPrice();
                    $goods->save();
                    $goods->syncImgs(array_column($cache['imgs'], 'id'));
                    $goods->updateDemand();

                    return redirect('wechat/demand/details/' . $goods->data->demand_id);
                    break;
            }
        }
        $goodsList = DemandGoodsList::getAll(['demand_id' => $goods->data->demand_id]);
        if (isset($cache['id']) && $cache['id'] != $goods->id) {
            $this->clearGoodsInfo();
        }
        //商品单位
        $unit = GoodsUnitList::getAll(['status' => 1]);
        $data = [
            'goodsList' => $goodsList->getItems(),
            'goods'     => $goods->getData(),
            'imgs'      => empty($cache['imgs']) ? $goods->getData()->imgs->toArray() : $cache['imgs'],
            'unit'      => $unit->getItems(),
        ];

        return view('wechat.demand.edit', $data);
    }

    public function recall($id)
    {
        $demand = Demand::initById($id);
        if ($demand->data->user_id != $this->getUserId()) {
            return $this->returnJson(-1, '您不能操作该需求');
        }
        if ($demand->recall()->save()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '撤回失败');
    }

    public function remove($id)
    {
        $demand = Demand::initById($id);
        if ($demand->data->user_id != $this->getUserId()) {
            return $this->returnJson(-1, '您不能删除该需求');
        }
        if ($demand->delete()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
    }

    public function pay($id, $userCouponId = null)
    {
        $demand = Demand::initById($id);
        if ($userCouponId) {
            $demand->setCoupon($userCouponId);
        }
        $payment = $demand->createPayOrder();

        return redirect('wechat/pay/' . $payment->data->id);
    }

    public function paging()
    {
        $input = $this->request->input();
        $status = $input['status'];
        $keyword = $input['keyword'];
        $cond = [
            'user_id' => $this->getUserId(),
        ];
        if ($status) {
            $cond['status'] = $status;
            if ($status == 5) {
                $cond[] = ['issue_evaluate', '<>', 1];
            }
        }
        if ($keyword) {
            $cond['keyword'] = $keyword;
        }
        $logic = DemandList::getList($cond);
        $param = [
            'rows'         => $logic->getItems(),
            'status'       => Demand::$status,
            'returnStatus' => ReturnGoodsApply::$status,
        ];
        $data = [
            'rows'      => view('wechat.demand.paging', $param)->render(),
            'pageTotal' => $logic->getItems()->lastPage(),
        ];

        return $this->returnJson(1, 'ok', $data);
    }

    public function details($id)
    {
        $demandLogic = Demand::initById($id);
        $demand = $demandLogic->getData();
        if ($demand->user_id != $this->getUserId()) {
            return redirect('wechat/tender/demand-details/' . $id);
        }
        $demand->load(
            [
                'demandGoods' => function ($q) {
                    $q->orderBy('id', 'desc');
                },
                'userTender'  => function ($q) {
                    $q->where('status', 1)->orderBy('id', 'asc');
                },
            ]
        );
        $sparePrice = $demand->known_price - $demand->getTenderPrice();
        //获取可用优惠券
        $cond = [
            'user_id' => $this->getUserId(),
            'status'  => 1,
            ['full_price_use', '<=', $demand->getHotboomPrice()],
            ['valid_time', '>', date('Y-m-d H:i:s')],
        ];
        $coupon = UserCouponList::getAll($cond);
        $data = [
            'demand'       => $demand,
            'goods'        => $demand->demandGoods->first(),
            'coupon'       => $coupon->getItems(),
            'status'       => Demand::$status,
            'express'      => Demand::$express,
            'returnStatus' => ReturnGoodsApply::$status,
            'sparePrice'   => $sparePrice < 0 ? 0 : $sparePrice,
            'js'           => app('wechat')->js,
            'savePrice'    => $demandLogic->getSaveprice(),
        ];

        return view('wechat.demand.details', $data);
    }

    public function hotboomStoreSite()
    {
        return view('wechat.tender.store_site');
    }

    public function viewLogistics($id)
    {
        $demand = Demand::initById($id);
        $result = $demand->getLogisticsInfo();
        $rows = [];
        if ($result['Success']) {
            $rows = $result['Traces'];
            if ($rows) {
                $rows = collect($rows)->sortByDesc('AcceptTime');
            }
        }
        $data = [
            'rows' => $rows,
        ];

        return view('wechat.demand.view_logistics', $data);
    }

    public function issue($id)
    {
        $demand = Demand::initById($id);
        if ($demand->issue($this->getEndtime())->save()) {
            //添加队列
            $job = new DisposeFailureDemand($demand->getData());
            $job = $job->delay($demand->data->end_time - time() + 10);
            $this->dispatch($job);

            return $this->returnJson();
        }

        return $this->returnJson(-1, '发布失败');
    }

    public function returnGoods($id)
    {
        $demand = Demand::initById($id);
        if ($this->request->isMethod('post')) {
            $data = [
                'user_id' => $this->getUserId(),
                'type'    => $this->request->input('type'),
                'remark'  => $this->request->input('remark'),
            ];
            $apply = ReturnGoodsApply::getByDemand($id);
            if ($apply->save($data) && $demand->setStatus(-2)->save()) {
                return redirect('wechat/demand/index');
            }
        }
        $data = [
            'demand' => $demand->getData(),
        ];

        return view('wechat.demand.return_goods', $data);
    }

    public function confirmSignfor($id)
    {
        $demand = Demand::initById($id);
        if ($demand->confirmSignfor()->save()) {
            $param = [
                'title'   => '订单通知',
                'content' => '您代购订单已经确认收货。订单编号：' . $demand->data->order_number,
            ];
            $demand->createMessage($param, $demand->data->select_user_id);

            return $this->returnJson();
        }

        return $this->returnJson(-1, '操作失败');
    }

    public function evaluate($id)
    {
        if ($this->request->isMethod('post')) {
            $demand = Demand::initById($id);
            $data = [
                'user_id'          => $demand->data->select_user_id,
                'demand_id'        => $demand->data->id,
                'evaluate_user_id' => $this->getUserId(),
                'goods_grade'      => $this->request->input('goods_grade'),
                'service_grade'    => $this->request->input('service_grade'),
                'deliver_grade'    => $this->request->input('deliver_grade'),
                'logistics_grade'  => $this->request->input('logistics_grade'),
                'content'          => $this->request->input('content'),
            ];
            $evaluate = UserEvaluateLog::create($data);
            $evaluate->countGrade();
            //修改订单状态
            $demand->issueEvaluate()->save();
            if ($evaluate->save()) {
                return redirect('wechat/demand/index');
            }
        }

        return view('wechat.demand.evaluate');
    }

    public function copyDemand($id = null)
    {
        if ($id) {
            session(['copy-demand-id' => $id]);
            session()->save();
        }
        $demand = Demand::initById(session('copy-demand-id'));
        $addressId = $this->request->get('address_id');
        if ($addressId) {
            $address = UserAddress::initById($addressId);
        } else {
            $address = UserAddress::getDefault($this->getUserId());
        }
        if (!$address) {
            return redirect('wechat/address?type=copy-demand');
        }
        if ($this->request->isMethod('post')) {
            $user = $this->getUser();
            $count = $this->request->input('count');
            $check = $demand->checkCopy($count);
            if (!$check['status']) {
                if ($this->request->ajax()) {
                    return $this->returnJson(-1, $check['message']);
                }

                return redirect('wechat');
            }
            $copyDemand = $demand->copyDemand($user->getData(), $count);
            //计算订单商品价
            $copyDemand->countGoodsPrice();
            //计算订单价格
            $copyDemand->countPrice();
            $data = [
                'consignee' => $address->data->name,
                'phone'     => $address->data->phone,
                'address'   => $address->getDetailsSite(),
                'remark'    => $this->request->input('remark'),
            ];
            if ($copyDemand->save($data)) {
                $copyDemand->saveGoods();
                //冻结报价库存
                $tender = UserTender::initById($copyDemand->data->user_tender_id);
                $tender->frostRepertory($count)->save();
                //添加队列
                $job = new FailurePayDemand($copyDemand->getData());
                $job = $job->delay(3600 * 2);
                $this->dispatch($job);

                return redirect('wechat/demand/details/' . $copyDemand->data->id);
            }
        }
        $data = [
            'demand'    => $demand->getData(),
            'address'   => $address->getData(),
            'repertory' => $demand->getHotboomRepertory(),
        ];

        return view('wechat.demand.copy_demand', $data);
    }
}