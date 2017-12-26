<?php

namespace App\Http\Controllers\Wechat;

use App\Repositories\Demand;
use App\Repositories\DemandList;
use App\Repositories\UserHotboomEvaluateLog;
use App\Repositories\ReturnGoodsApply;
use App\Repositories\UserTender;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/28
 * Time: 10:06
 * Author: wenlongh <wenlongh@qq.com>
 */
class HotboomDemandController extends Controller
{
    public function index()
    {
        return view('wechat.daigou-demand.index');
    }

    public function paging()
    {
        $input = $this->request->input();
        $status = $input['status'];
        $keyword = $input['keyword'];
        $cond = [
            'select_user_id' => $this->getUserId(),
        ];
        if ($status) {
            $cond['status'] = $status;
            if ($status == 5) {
                $cond[] = ['daigou_evaluate', '<>', 1];
            }
        }
        if ($keyword) {
            $cond['keyword'] = $keyword;
        }
        $logic = DemandList::getList($cond);
        $data = [
            'rows'         => $logic->getItems(),
            'status'       => Demand::$status,
            'returnStatus' => ReturnGoodsApply::$status,
        ];
        $data = [
            'rows'      => view('wechat.daigou-demand.paging', $data)->render(),
            'pageTotal' => $logic->getItems()->lastPage(),
        ];

        return $this->returnJson(1, 'ok', $data);
    }

    public function details($id)
    {
        $goodsId = $this->request->query('goods_id');
        $user = $this->getUser();
        $demand = Demand::initById($id);
        if ($demand->data->select_user_id != $this->getUserId()) {
            return redirect('wechat/tender/demand-details/' . $id);
        }

        $goods = $demand->getData()->demandGoods->first();
        if ($goodsId) {
            $goods = $demand->getData()->demandGoods->first(
                function ($k, $v) use ($goodsId) {
                    return $v->id == $goodsId;
                }
            );
        }
        $data = [
            'demand'       => $demand,
            'goods'        => $goods,
            'status'       => Demand::$status,
            'express'      => Demand::$express,
            'returnStatus' => ReturnGoodsApply::$status,
            'js'           => app('wechat')->js,
        ];
        if ($goods->store_lng && $goods->store_lat) {
            $distance = $this->getdistance($user->data->lng, $user->data->lat, $goods->store_lng, $goods->store_lat);
            $data['distance'] = round($distance / 1000, 1);
        }

        return view('wechat.daigou-demand.details', $data);
    }

    public function returnCheck($id)
    {
        $status = $this->request->input('status');
        $demand = Demand::initById($id);
        $apply = ReturnGoodsApply::initByModel($demand->data->returnGoodsApply);
        if ($apply->check($status)->save()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '操作失败');
    }

    public function delivery($id)
    {
        $demand = Demand::initById($id);
        if ($this->request->isMethod('post')) {
            $expressCompany = $this->request->input('express_company_number');
            $expressNumber = $this->request->input('express_number');
            $imgs = $this->request->input('imgs', []);
            if ($demand->delivery($expressCompany, $expressNumber, $imgs)->save()) {
                $param = [
                    'title'   => '发货通知',
                    'content' => '你的宝贝已经发货了。订单编号：' . $demand->data->order_number,
                ];
                $demand->createMessage($param);
                //发送微信模板消息
                $demand->deliveryNotice();

                return redirect('wechat/hotboom-demand/index');
            }
        }
        $data = [
            'demand'  => $demand->getData(),
            'express' => Demand::$express,
        ];

        return view('wechat.daigou-demand.delivery', $data);
    }

    public function evaluate($id)
    {
        if ($this->request->isMethod('post')) {
            $demand = Demand::initById($id);
            $data = [
                'user_id'          => $demand->data->user_id,
                'demand_id'        => $demand->data->id,
                'evaluate_user_id' => $this->getUserId(),
                'grade'            => $this->request->input('grade'),
                'content'          => $this->request->input('content'),
            ];
            $evaluate = UserHotboomEvaluateLog::create($data);
            $evaluate->syncUserTotalGrade();
            //修改订单状态
            $demand->hotboomEvaluate()->save();
            if ($evaluate->save()) {
                return redirect('wechat/hotboom-demand/index');
            }
        }

        return view('wechat.daigou-demand.evaluate');
    }
}