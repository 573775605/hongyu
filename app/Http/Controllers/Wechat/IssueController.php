<?php

namespace App\Http\Controllers\Wechat;

use App\Exceptions\ExceptionRepository;
use App\Jobs\DisposeFailureDemand;
use App\Repositories\Demand;
use App\Repositories\GoodsCategoryList;
use App\Repositories\GoodsIssueRecord;
use App\Repositories\GoodsIssueRecordList;
use App\Repositories\GoodsSourceList;
use App\Repositories\GoodsUnitList;
use App\Repositories\UserAddress;
use Jenssegers\Agent\Agent;
use DB;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/21
 * Time: 13:47
 * Author: wenlongh <wenlongh@qq.com>
 */
class IssueController extends Controller
{
    public function browse()
    {
        return view('wechat.Issue.browse');
    }

    public function checkBrowse()
    {
        $agent = new Agent();
        $url = $this->request->get('url');
        if (!$agent->isGenericBrowser()) {
            return redirect($url);
        }

        return view('wechat.Issue.check_browse');
    }

    public function index()
    {
        $action = $this->request->query('action');
        if ($this->request->query('address_id')) {
            $this->getAddressId();
            GoodsIssueRecord::clearRecord($this->getUserId());
            $this->clearGoodsInfo();
        }
        $this->putGoodsInfo();
        if ($action == 'type') {
            $type = $this->request->query('type');
            if ($type == 'upload') {
                return $this->fillForm();
            } elseif ($type == 'link') {
                return $this->formLink();
            }

            return $this->selectType();
        } elseif ($action == 'source') {
            return $this->selectSource();
        } elseif ($action == 'category') {
            return $this->selectCategory();
        } elseif ($action == 'location') {
            return $this->selectSite();
        } elseif ($action == 'add') {
            return $this->createGoods();
        } elseif ($action == 'save') {
            return $this->submit($this->request->query('is_issue'));
        } else {
            return $this->fillForm();
        }
    }

    public function fillForm()
    {
        $record = GoodsIssueRecordList::getAll(['user_id' => $this->getUserId()]);
        $record->loadFirstImg();
        //商品单位
        $unit = GoodsUnitList::getAll(['status' => 1]);
        $data = [
            'row'  => $this->getGoodsInfo(),
            'rows' => $record->getItems(),
            'unit' => $unit->getItems(),
        ];

        return view('wechat.Issue.fill_form', $data);
    }

    public function selectType()
    {
        return view('wechat.Issue.select_type');
    }

    public function formLink()
    {
        return view('wechat.Issue.form_link');
    }

    public function selectSource()
    {
        $logic = GoodsSourceList::getAll(['status' => 1]);
        $data = [
            'rows' => $logic->getItems(),
        ];

        return view('wechat.Issue.select_source', $data);
    }

    public function selectCategory()
    {
        $logic = GoodsCategoryList::getAll(['status' => 1]);
        $data = [
            'rows' => $logic->getItems(),
        ];

        return view('wechat.Issue.select_category', $data);
    }

    public function selectSite()
    {
        $data = [
            'user' => $this->getUser(),
        ];

        return view('wechat.Issue.select_site', $data);
    }

    public function submit($isIssue)
    {
        $user = $this->getUser();
        $record = GoodsIssueRecordList::getAll(['user_id' => $this->getUserId()]);
        $goods = $record->getItems()->toArray();
        $goods [] = $this->getParam();
        $param = [
            'user_id'     => $this->getUserId(),
            'category_id' => reset($goods)['category_id'],
            'source_id'   => reset($goods)['source_id'],
            'issue_lng'   => $user->data->lng,
            'issue_lat'   => $user->data->lat,
        ];
        $demand = Demand::createDemand(UserAddress::initById($this->getAddressId())->getData(), $param);
        DB::beginTransaction();
        try {
            if ($isIssue) {
                $demand->issue($this->getEndtime());
            }
            //创建商品
            foreach ($goods as $v) {
                $demand->pushGoods($v);
            }
            //地址解析
            $demand->coordAnalysis();
            //计算商品价格
            $demand->countGoodsPrice();
            $demand->save();
            $demand->saveGoods();

            DB::commit();
            //清除商品记录
            GoodsIssueRecord::clearRecord($this->getUserId());
            $this->clearGoodsInfo();
            if ($isIssue) {
                //添加队列
                $job = new DisposeFailureDemand($demand->getData());
                $job = $job->delay($demand->data->end_time - time() + 10);
                $this->dispatch($job);

                return redirect('wechat/issue/success');
            }

            return redirect('wechat/demand/index');
        } catch (ExceptionRepository $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function createGoods()
    {
        if ($this->request->isMethod('post')) {
            $data = $this->getParam();
            if (GoodsIssueRecord::create($data)->save()) {
                $this->clearGoodsInfo();
                $param = [
                    'action'    => 'type',
                    'type'      => $data['type'],
                    'source'    => $data['source'],
                    'source_id' => $data['source_id'],
                ];

                return redirect('wechat/issue/index?' . http_build_query($param));
            }
        }

        return $this->fillForm();
    }

    public function getParam()
    {
        $input = $this->request->input();
        $user = $this->getUser();
        $data = [
            'user_id'     => $this->getUserId(),
            'category_id' => $input['category_id'],
            'imgs'        => \GuzzleHttp\json_encode($input['imgs']),
            'type'        => $input['type'],
            'link'        => $input['link'],
            'domain'      => $input['domain'],
            'goods_name'  => $input['goods_name'],
            'sku_name'    => isset($input['sku_name']) ? $input['sku_name'] : '',
            'goods_unit'  => $this->request->input('goods_unit', '件'),
            'source_id'   => $input['source_id'],
            'source'      => $input['source'],
            'price'       => $input['price'],
            'count'       => $input['count'],
            'remark'      => $input['remark'],
            'store_name'  => $input['store_name'],
            'store_lng'   => $input['store_lng'],
            'store_lat'   => $input['store_lat'],
        ];

        return $data;
    }

    public function getRecordId()
    {
        $id = $this->request->query('goods_issue_record_id');
        if ($id) {
            session(['goods_issue_record_id' => $id]);
            session()->save();
        }

        return session('goods_issue_record_id');
    }

    public function getAddressId()
    {
        $id = $this->request->query('address_id');
        if ($id) {
            session(['address_id' => $id]);
            session()->save();
        }

        return session('address_id');
    }
}