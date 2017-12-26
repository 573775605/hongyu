<?php

namespace App\Http\Controllers\Wechat;

use App\Exceptions\ExceptionRepository;
use App\Jobs\FailurePayDemand;
use App\Repositories\Config;
use App\Repositories\Demand;
use App\Repositories\DemandGoods;
use App\Repositories\QuoteAdvantageConfigList;
use App\Repositories\QuoteAdvantageList;
use App\Repositories\User;
use App\Repositories\UserEvaluateLogList;
use App\Repositories\UserTender;
use DB;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/29
 * Time: 10:34
 * Author: wenlongh <wenlongh@qq.com>
 */
class UserTenderController extends Controller
{
    public function demandDetails($demandId)
    {
        $hotboomUserId = '';
        $goodsId = $this->request->query('goods_id');
        $tenderId = $this->request->query('tender_id');
        $user = $this->getUser();

        $demand = Demand::initById($demandId);
        $demand->getData()->load(
            [
                'userTender' => function ($q) {
                    $q->where('status', 1);
                },
                'demandGoods',
            ]
        );

        $goods = $demand->getData()->demandGoods->first();
        if ($goodsId) {
            $goods = $demand->getData()->demandGoods->first(
                function ($k, $v) use ($goodsId) {
                    return $v->id == $goodsId;
                }
            );
        }
        $data = [
            'demand'         => $demand,
            'status'         => Demand::$status,
            'goods'          => $goods,
            'tenderMaxCount' => Config::get('demand_tender_max_count', 5),
            'js'             => app('wechat')->js,
            'user'           => $this->getUser(),
        ];
        if ($goods->store_lng && $goods->store_lat) {
            $distance = $this->getdistance($user->data->lng, $user->data->lat, $goods->store_lng, $goods->store_lat);
            $data['distance'] = round($distance / 1000, 1);
        }
        if ($tenderId) {
            $tender = UserTender::getByid($tenderId);
            $data['tender'] = $tender->getData();
            $hotboomUserId = $tender->data->user_id;
        }
        if ($demand->data->is_select) {
            $data['tender'] = $demand->data->selectUserTender;
            $hotboomUserId = $demand->data->select_user_id;
        }
        if ($hotboomUserId) {
            $evauate = UserEvaluateLogList::getList(['user_id' => $hotboomUserId], 3);
            $data['evaluate'] = $evauate->getItems();
            $data['evaluateCount'] = $evauate->getBuilder()->count() ? : 0;
        }

        return view('wechat.tender.demand_details', $data);
    }

    public function edit($id)
    {
        $tender = UserTender::initById($id);
        $data = [
            'tender' => $tender->getData(),
        ];

        return view('wechat.tender.edit', $data);
    }

    public function editSub($id)
    {
        $tender = UserTender::initById($id);
        $data = [
            'hotboom_store_name' => $this->request->input('hotboom_store_name'),
            'hotboom_lng'        => $this->request->input('hotboom_lng'),
            'hotboom_lat'        => $this->request->input('hotboom_lat'),
            'quote'              => $this->request->input('quote'),
            'express_price'      => $this->request->input('express_price'),
            'type'               => $this->request->input('type'),
            'repertory'          => $this->request->input('repertory'),
            'hotboom_type'       => $this->request->input('repertory') > 1 ? 'circulation' : 'once',
            'hotboom_end_time'   => $this->getEndtime(),
        ];
        $tender->save($data);
        $tender->clearAdvantage();
        $tender->pushAdvantage($this->request->input('advantage', []));
        $tender->saveAdvantage();

        return redirect('wechat/tender/demand-details/' . $tender->data->demand_id . '?tender_id=' . $tender->data->id);
    }

    public function storeSite($goodsId)
    {
        $goods = DemandGoods::initById($goodsId);
        $data = [
            'goods' => $goods->getData(),
        ];

        return view('wechat.tender.store_site', $data);
    }

    public function tenderCheck($demandId)
    {
        $user = $this->getUser();
        $demand = Demand::initById($demandId);
        if (!$user->data->mobile) {
            if (!$this->request->ajax()) {
                return false;
            }

            return $this->returnJson(-1, '请完善个人信息');
        }
        if ($demand->data->user_id == $this->getUserId()) {
            if (!$this->request->ajax()) {
                return false;
            }

            return $this->returnJson(-2, '不能对自己需求报价');
        }
        //        if ($demand->data->known_price > $user->data->getPledge()) {
        //            if (!$this->request->ajax()) {
        //                return false;
        //            }
        //
        //            return $this->returnJson(-2, '账户保证金不足');
        //        }
        if ($demand->checkUserTender($user->data->id)) {
            if (!$this->request->ajax()) {
                return false;
            }

            return $this->returnJson(-3, '报价成功，等待筛选(请勿重复报价)');
        }
        if ($demand->isExceedMaxTender()) {
            if (!$this->request->ajax()) {
                return false;
            }

            return $this->returnJson(-4, '该需求已经超过最大报价数');
        }
        if ($demand->isPastdue()) {
            if (!$this->request->ajax()) {
                return false;
            }

            return $this->returnJson(-5, '该需求已失效');
        }
        if (!$this->request->ajax()) {
            return true;
        }

        return $this->returnJson(1, 'ok');
    }

    public function index()
    {
        $demandId = $this->request->get('demand_id');
        if (!$demandId) {
            return redirect('wechat');
        }
        if (!$this->tenderCheck($demandId)) {
            return redirect('wechat/tender/demand-details/' . $demandId);
        }
        $demand = Demand::initById($demandId);
        $data = [
            'demand'      => $demand->getData(),
            'address'     => $demand->hideAddress(),
            'hotboomType' => UserTender::$hotboomType,
        ];

        return view('wechat.tender.index', $data);
    }

    /**
     * 选择报价优势
     *
     * @author wenlongh <wenlongh@qq.com>
     */
    public function selectAdvantage()
    {
        $tenderId = $this->request->query('tender_id');
        $quoteConfig = QuoteAdvantageConfigList::getAll(['status' => 1]);
        $data = [
            'rows' => $quoteConfig->getItems(),
        ];
        if ($tenderId) {
            $quote = QuoteAdvantageList::getAll(['user_tender_id' => $tenderId]);
            $data['label'] = $quote->getFlatten();
            $tender = UserTender::initById($tenderId);
            $data['tender'] = $tender->getData();
        }

        return view('wechat.tender.select_advantage', $data);
    }

    public function selectStoreSite()
    {
        return view('wechat.tender.select_store_site');
    }

    public function submit()
    {
        $demandId = $this->request->input('demand_id');
        if (!$this->tenderCheck($demandId)) {
            return redirect('wechat');
        }
        $user = $this->getUser();
        $demand = Demand::initById($demandId);
        $pledge = $user->getData()->getPledge();
        if ($pledge > $demand->data->known_price) {
            $frostPledge = $demand->data->known_price;
        } else {
            $frostPledge = $pledge;
        }
        $data = [
            'frost_pledge'       => $frostPledge,
            'user_id'            => $this->getUserId(),
            'type'               => $this->request->input('type'),
            'demand_id'          => $this->request->input('demand_id'),
            'quote'              => $this->request->input('quote'),
            'express_price'      => $this->request->input('express_price'),
            'hotboom_store_name' => $this->request->input('hotboom_store_name'),
            'hotboom_lng'        => $this->request->input('hotboom_lng'),
            'hotboom_lat'        => $this->request->input('hotboom_lat'),
            'lng'                => $user->data->lng,
            'lat'                => $user->data->lat,
            'repertory'          => $this->request->input('repertory'),
            'hotboom_type'       => $this->request->input('repertory') > 1 ? 'circulation' : 'once',
            'hotboom_end_time'   => $this->getEndtime(),
        ];

        DB::beginTransaction();
        try {
            $tender = UserTender::create($data);
            $tender->coordAnalysis();
            //创建报价优势
            $tender->pushAdvantage($this->request->input('advantage', []));
            $tender->save();
            $tender->saveAdvantage();
            //冻结用户保证金
            $user->frostPledge($frostPledge)->save();
            $param = [
                'title'   => '报价成功',
                'content' => '等待发布者筛选，订单编号：' . $tender->data->demand->order_number,
            ];
            $tender->createMessage($param);
            //通知发布者
            $param = [
                'title'   => '报价通知',
                'content' => '需求订单有新的报价，订单编号：' . $tender->data->demand->order_number,
            ];
            $demand->createMessage($param);
            Db::commit();

            return redirect('wechat/center/tender-list');
        } catch (ExceptionRepository $e) {
            DB::rollback();

            return view('wechat.tender.index', ['demand' => $demand->getData()]);
        }
    }

    public function select($id)
    {
        DB::beginTransaction();
        try {
            $tender = UserTender::initById($id);
            $demand = Demand::initByModel($tender->getData()->demand);
            $demand->selectTender($tender->getData());
            $demand->save();
            //修改报价状态
            $tender->setStatus(3)->save();
            $param = [
                'title'   => '选中报价',
                'content' => '您的报价已被发布者选择，订单编号：' . $demand->data->order_number,
            ];
            $tender->createMessage($param);
            $param = [
                'title'   => '支付提醒',
                'content' => '你的订单已选中报价，请尽快支付。订单编号：' . $demand->data->order_number,
            ];
            $demand->createMessage($param);
            DB::commit();
            //添加支付失效队列
            $job = new FailurePayDemand($demand->getData());
            $job = $job->delay(3600 * 2);
            $this->dispatch($job);

            return $this->returnJson();
        } catch (ExceptionRepository $e) {
            DB::rollback();

            return $this->returnJson(-1, $e->getMessage());
        }
    }

    public function cancel($id)
    {
        DB::beginTransaction();
        try {
            $tender = UserTender::initById($id);
            $tender->cancelTender()->save();
            $param = [
                'title'   => '取消报价',
                'content' => '你的报价已被订单需求者取消，请继续努力。订单编号：' . $tender->data->demand->order_number,
            ];
            $tender->createMessage($param);
            DB::commit();

            return $this->returnJson();
        } catch (ExceptionRepository $e) {
            DB::rollback();

            return $this->returnJson(-1, $e->getMessage());
        }

    }

    public function editRepertory($id)
    {
        $tender = UserTender::initById($id);
        if ($this->request->isMethod('post')) {
            $data = [
                'repertory'        => $this->request->input('repertory'),
                'hotboom_end_time' => $this->getEndtime(),
            ];
            if ($tender->save($data)) {
                return redirect('wechat/tender/demand-details/' . $tender->data->demand_id . '?tender_id=' . $id);
            }
        }
        $data = [
            'tender' => $tender->getData(),
        ];

        return view('wechat.tender.edit_repertory', $data);
    }

    public function delete($id)
    {
        $tender = UserTender::initById($id);
        if ($tender->delete()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
    }
}