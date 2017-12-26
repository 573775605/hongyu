<?php

namespace App\Repositories;

use App\Exceptions\ExceptionRepository;
use App\Models\Demand as DemandModel;
use App\Models\DemandGoods as DemandGoodsModel;
use App\Models\UserAddress as UserAddressModel;
use App\Models\UserTender as UserTenderModel;
use App\Models\UserMessage as UserMessageModel;
use App\Models\User as UserModel;
use App\Models\UserCoupon as UserCouponModel;
use EasyWeChat\Core\Exceptions\HttpException;
use GuzzleHttp\Client;

class Demand extends Base
{
    public static $modelName = DemandModel::class;

    public static $status = [
        -3 => '支付失效',
        -2 => '申请售后',
        -1 => '未发布',
        1  => '寻找红利中',
        2  => '待支付',
        3  => '待发货',
        4  => '待收货',
        5  => '待评价',
        6  => '已完成',
    ];

    public static $type = [
        'link'   => '链接地址',
        'upload' => '本地上传',
    ];

    public static $express = [
        'AJ'       => '安捷快递',
        'ANE'      => '安能物流',
        'AXD'      => '安信达快递',
        'BQXHM'    => '北青小红帽',
        'BFDF'     => '百福东方',
        'BTWL'     => '百世快运',
        'CCES'     => 'CCES快递',
        'CITY100'  => '城市100',
        'COE'      => 'COE东方快递',
        'CSCY'     => '长沙创一',
        'CDSTKY'   => '成都善途速运',
        'DBL'      => '德邦',
        'DSWL'     => 'D速物流',
        'DTWL'     => '大田物流',
        'EMS'      => 'EMS',
        'FAST'     => '快捷速递',
        'FEDEX'    => 'FEDEX联邦(国内件',
        'FEDEX_GJ' => 'FEDEX联邦(国际件)',
        'FKD'      => '飞康达',
        'GDEMS'    => '广东邮政',
        'GSD'      => '共速达',
        'GTO'      => '国通快递',
        'GTSD'     => '高铁速递',
        'HFWL'     => '汇丰物流',
        'HHTT'     => '天天快递',
        'HLWL'     => '恒路物流',
        'HOAU'     => '天地华宇',
        'hq568'    => '华强物流',
        'HTKY'     => '百世快递',
        'HXLWL'    => '华夏龙物流',
        'HYLSD'    => '好来运快递',
        'JGSD'     => '京广速递',
        'JIUYE'    => '九曳供应链',
        'JJKY'     => '佳吉快运',
        'JLDT'     => '嘉里物流',
        'JTKD'     => '捷特快递',
        'JXD'      => '急先达',
        'JYKD'     => '晋越快递',
        'JYM'      => '加运美',
        'JYWL'     => '佳怡物流',
        'KYWL'     => '跨越物流',
        'LB'       => '龙邦快递',
        'LHT'      => '联昊通速递',
        'MHKD'     => '民航快递',
        'MLWL'     => '明亮物流',
        'NEDA'     => '能达速递',
        'SF'       => '平安达腾飞快递',
        'QCKD'     => '全晨快递',
        'QFKD'     => '全峰快递',
        'QRT'      => '全日通快递',
        'RFD'      => '如风达',
        'SAD'      => '赛澳递',
        'SAWL'     => '圣安物流',
        'SBWL'     => '盛邦物流',
        'SDWL'     => '上大物流',
        'SF'       => '顺丰快递',
        'SFWL'     => '盛丰物流',
        'SHWL'     => '盛辉物流',
        'ST'       => '速通物流',
        'STO'      => '申通快递',
        'STWL'     => '速腾快递',
        'SURE'     => '速尔快递',
        'TSSTO'    => '唐山申通',
        'UAPEX'    => '全一快递',
        'UC'       => '优速快递',
        'WJWL'     => '万家物流',
        'WXWL'     => '万象物流',
        'XBWL'     => '新邦物流',
        'XFEX'     => '信丰快递',
        'XYT'      => '希优特',
        'XJ'       => '新杰物流',
        'YADEX'    => '源安达快递',
        'YCWL'     => '远成物流',
        'YD'       => '韵达快递',
        'YDH'      => '义达国际物流',
        'YFEX'     => '越丰物流',
        'YFHEX'    => '原飞航物流',
        'YFSD'     => '亚风快递',
        'YTKD'     => '运通快递',
        'YTO'      => '圆通速递',
        'YXKD'     => '亿翔快递',
        'YZPY'     => '邮政平邮/小包',
        'ZENY'     => '增益快递',
        'ZHQKD'    => '汇强快递',
        'ZJS'      => '宅急送',
        'ZTE'      => '众通快递',
        'ZTKY'     => '中铁快运',
        'ZTO'      => '中通速递',
        'ZTWL'     => '中铁物流',
        'ZYWL'     => '中邮物流',
        'AMAZON'   => '亚马逊物流',
        'SUBIDA'   => '速必达物流',
        'RFEX'     => '瑞丰速递',
        'QUICK'    => '快客快递',
        'CJKD'     => '城际快递',
        'CNPEX'    => 'CNPEX中邮快递',
        'HOTSCM'   => '鸿桥供应链',
        'HPTEX'    => '海派通物流公司',
        'AYCA'     => '澳邮专线',
        'PANEX'    => '泛捷快递',
        'PCA'      => 'PCA Express',
        'UEQ'      => 'UEQ Express',
    ];

    public static function createDemand(UserAddressModel $address, $data = [])
    {
        $obj = parent::create($data);
        $obj->data->order_number = static::generateNumber(10);
        $obj->data->consignee = $address->name;
        $obj->data->phone = $address->phone;
        $obj->data->address = $address->province . $address->city . $address->area . ' ' . $address->address;

        return $obj;
    }

    /**
     * 计算时间间隔
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $datetime
     * @return string
     */
    public static function countTimeInterval($datetime)
    {
        $intervalTime = '';
        $timeLag = time() - strtotime($datetime);
        if ($timeLag > 0) {
            if ($timeLag < 60) {
                $intervalTime = $timeLag . '秒前';
            } elseif ($timeLag < 3600) {
                $intervalTime = floor($timeLag / 60) . '分钟前';
            } elseif ($timeLag < 86400) {
                $intervalTime = floor($timeLag / 3600) . '小时前';
            } elseif ($timeLag < 604800) {
                $intervalTime = floor($timeLag / 86400) . '天前';
            } elseif ($timeLag < 86400 * 30) {
                $intervalTime = floor($timeLag / 604800) . '周前';
            } elseif ($timeLag < 86400 * 30 * 12) {
                $intervalTime = floor($timeLag / (86400 * 30)) . '月前';
            }
        }

        return $intervalTime;
    }

    /**
     * 计算两点距离(单位：米)
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $lng1
     * @param $lat1
     * @param $lng2
     * @param $lat2
     * @return int
     */
    public static function getdistance($lng1, $lat1, $lng2, $lat2)
    {
        // 将角度转为狐度
        $radLat1 = deg2rad($lat1); //deg2rad()函数将角度转换为弧度
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;

        return $s;
    }

    /**
     * 生成订单号
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return string
     */
    public static function generateNumber($length = null)
    {
        $year = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        $orderSn = $year[date('Y') % 10]
            . strtoupper(dechex(date('m')))
            . date('d')
            . substr(time(), -5)
            . substr(microtime(), 2, 5)
            . rand(10, 99);
        if (!$length) {
            return $orderSn;
        }

        return substr($orderSn, 0, $length);
    }

    public static function coordToSite($lng, $lat)
    {
        $url = 'http://apis.map.qq.com/ws/geocoder/v1/';
        $param = [
            'location' => $lat . ',' . $lng,
            'key'      => env('TENCENT_MAP_KEY'),
        ];
        $client = new Client();
        $result = $client->request('get', $url, ['query' => $param]);
        $result = \GuzzleHttp\json_decode($result->getBody()->getContents(), true);
        if ($result['status'] == 0) {
            return $result;
        }

        return null;
    }

    /**
     * 创建支付订单
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return static
     */
    public function createPayOrder()
    {
        $param = [
            'demand_id' => $this->data->id,
            'type'      => 'demand',
            'price'     => $this->data->price,
            'title'     => '订单支付',
            'details'   => '微信支付',
        ];
        $payOrder = PaymentOrder::create($param);
        $payOrder->save();

        return $payOrder;
    }

    /**
     * 撤回
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function recall()
    {
        $this->data->status = -1;
        $this->data->is_issue = 0;

        return $this;
    }

    /**
     * 查看用户角色
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $userId
     * @return string
     */
    public function getDemandRole($userId)
    {
        if ($this->data->user_id == $userId) {
            return 'issue';
        }

        return 'hotboom';
    }

    public function setStatus($status)
    {
        $this->data->status = $status;

        return $this;
    }

    /**
     * 确认收货
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function confirmSignfor()
    {
        $this->data->status = 5;
        $this->data->over_time = date('Y-m-d H:i:s');

        $user = User::initByModel($this->data->user);
        $user->data->issue_over_demand += 1;
        //统计累计节省金额
        $price = $this->data->known_price - $this->data->price;
        if ($price > 0) {
            $param = [
                'demand_id' => $this->data->id,
                'title'     => '订单完成',
                'content'   => '红利需求订单完成。订单编号：' . $this->data->order_number,
            ];
            $user->updateSpare($price, $param);
        }
        $user->save();
        //修改代购完成单数
        $hotboomUser = User::initByModel($this->data->selectUser);
        $hotboomUser->data->daigou_over_demand += 1;
        //解除用户冻结保证金
        if (!$this->data->is_copy) {
            $pledge = $this->data->selectUserTender->frost_pledge;
            if ($pledge > 0) {
                $hotboomUser->frostPledge(-$pledge);
            }
        }
        //修改用户代购余额
        $hotboomUser->updateHotboomBalance($this->data->getHotboomPrice(), '代购订单支付', ['demand_id' => $this->data->id]);
        $hotboomUser->save();

        return $this;
    }

    public function payFailure()
    {
        //添加发布者提醒消息
        $param = [
            'title'   => '支付失效提醒',
            'content' => '订单超过两小时未支付失效，订单编号：' . $this->data->order_number,
        ];
        $this->createMessage($param);
        //添加代购提醒消息
        $this->createMessage($param, $this->data->select_user_id);
        if ($this->data->is_copy) {
            $this->data->status = -3;

            return $this;
        }
        $hotboomUser = User::initByModel($this->data->selectUser);
        //解除用户冻结保证金
        $tender = UserTender::initByModel($this->data->selectUserTender);
        if ($tender->data->frost_pledge > 0) {
            $hotboomUser->frostPledge(-$tender->data->frost_pledge);
            $hotboomUser->save();
        }
        //修改报价状态
        $tender->setStatus(2)->save();
        //修改订单状态
        $this->data->status = -1;
        $this->data->is_issue = 0;
        $this->data->is_select = 0;
        $this->data->select_user_id = 0;
        $this->data->user_tender_id = 0;

        return $this;
    }

    public function pay()
    {
        $this->data->is_pay = 1;
        $this->data->pay_time = date('Y-m-d H:i:s');
        $this->data->status = 3;
        //扣除报价库存
        $tender = UserTender::initByModel($this->data->selectUserTender);
        $tender->reduceRepertory($this->data->count)->save();
        $param = [
            'title'   => '支付成功',
            'content' => '订单支付成功!等待发货。订单编号：' . $this->data->order_number,
        ];
        $this->createMessage($param);
        //提醒代购者
        $param = [
            'title'   => '支付成功',
            'content' => '代购订单支付成功!请尽快发货。订单编号：' . $this->data->order_number,
        ];
        $this->createMessage($param, $this->data->select_user_id);
        //发送微信模板消息
        $this->paySuccessNotice();

        return $this;
    }

    /**
     * 订单发货
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $expressCompany 物流公司编号(快递鸟)
     * @param $expressNumber 物流编号
     * @param array $imgs 购买小票
     * @return $this
     */
    public function delivery($expressCompany, $expressNumber, $imgs = [])
    {
        $this->data->status = 4;
        $this->data->delivery_time = date('Y-m-d H:i:s');
        $this->data->express_company_number = $expressCompany;
        $this->data->express_number = $expressNumber;
        $this->data->shopInvoiceImg()->sync($imgs);

        return $this;
    }

    /**
     * 发布需求评价
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function issueEvaluate()
    {
        $this->data->issue_evaluate = 1;
        if ($this->data->daigou_evaluate) {
            $this->data->status = 6;
        }

        return $this;
    }

    /**
     * 是否失效
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return bool
     */
    public function isPastdue()
    {
        return time() > $this->data->end_time;
    }

    /**
     * 代购评价
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function hotboomEvaluate()
    {
        $this->data->daigou_evaluate = 1;
        if ($this->data->issue_evaluate) {
            $this->data->status = 6;
        }

        return $this;
    }

    /**
     * 查看是否超过最大报价人数
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return bool
     */
    public function isExceedMaxTender()
    {
        $maxTender = Config::get('demand_tender_max_count', 5);
        $tenderCount = $this->data->userTender()->where('status', 1)->count();

        return $tenderCount >= $maxTender;
    }

    /**
     * 查看用户是否已投标
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $userId
     * @return bool
     */
    public function checkUserTender($userId)
    {
        $result = $this->data->userTender()->where('user_id', $userId)->where('status', 1)->count();

        return boolval($result);
    }

    public function setCoupon($userCouponId)
    {
        $coupon = UserCoupon::getUsableByUser($userCouponId, $this->data->user_id);
        if (!$coupon) {
            return true;
        }
        if ($this->data->getHotboomPrice() < $coupon->data->full_price_use) {
            return true;
        }
        $this->data->user_coupon_id = $coupon->data->id;
        $this->data->coupon_price = $coupon->data->price;
        $this->countPrice();
        //修改优惠券状态
        $coupon->employ($this->data->id)->save();

        return $this->save();
    }

    /**
     * 选择报价用户
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param UserTenderModel $tender
     * @return $this
     */
    public function selectTender(UserTenderModel $tender)
    {
        $this->data->status = 2;
        $this->data->select_user_id = $tender->user_id;
        $this->data->user_tender_id = $tender->id;
        $this->data->tender_price = $tender->quote;
        $this->data->express_price = $tender->express_price;
        $this->data->is_select = 1;
        $this->data->pay_end_time = time() + (3600 * 2);
        $this->countPrice();
        //解除未选其他用户冻结押金
        $this->updateFrostPledge();

        return $this;
    }

    /**
     * 解除报价用户冻结押金
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param string $content
     * @return $this
     */
    public function updateFrostPledge($content = '您的报价没被选中，请继续努力。')
    {
        $this->data->load(
            [
                'userTender' => function ($q) {
                    $q->where('user_id', '<>', $this->data->select_user_id)->where('status', 1);
                },
            ]
        );
        foreach ($this->data->userTender as $v) {
            if ($v->frost_pledge > 0) {
                $user = User::initByModel($v->user);
                $user->frostPledge(-$v->frost_pledge);
                $user->save();
            }
            $tender = UserTender::initByModel($v);
            $tender->setStatus(4)->save();
            $param = [
                'title'   => '报价结果',
                'content' => $content . '订单编号：' . $this->data->order_number,
            ];
            $tender->createMessage($param);
        }

        return $this;
    }

    /**
     * 获取订单实时物流信息
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return mixed
     */
    public function getLogisticsInfo()
    {
        $url = 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx';
        $requestData = [
            'OrderCode'    => '',
            'ShipperCode'  => $this->data->express_company_number,
            'LogisticCode' => $this->data->express_number,
        ];
        $data = [
            'RequestData' => urlencode(\GuzzleHttp\json_encode($requestData)),
            'EBusinessID' => env('EXPRESS_API_ID'),
            'DataSign'    => urlencode(base64_encode(md5(\GuzzleHttp\json_encode($requestData) . env('EXPRESS_API_KEY')))),
            'RequestType' => 1002,
            'DataType'    => 2,
        ];
        $client = new Client();
        $result = $client->request('post', $url, ['form_params' => $data]);

        return \GuzzleHttp\json_decode($result->getBody()->getContents(), true);
    }

    /**
     * 经纬度解析地址
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function coordAnalysis()
    {
        if ($this->data->issue_lng && $this->data->issue_lat) {
            $result = static::coordToSite($this->data->issue_lng, $this->data->issue_lat);
            if ($result) {
                $this->data->issue_province = $result['result']['address_component']['province'];
                $this->data->issue_city = $result['result']['address_component']['city'];
                $this->data->issue_area = $result['result']['address_component']['district'];
                $this->data->issue_address = $result['result']['address_component']['street'];
            }
        }

        return $this;
    }

    /**
     * 获取节省金额
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return int|mixed
     */
    public function getSaveprice()
    {
        $price = $this->data->known_price - $this->data->tender_price;

        return $price > 0 ? $price : 0;
    }

    /**
     * 创建订单商品
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $data
     * @return $this
     */
    public function pushGoods($data)
    {
        $imgs = \GuzzleHttp\json_decode($data['imgs'], true);
        $imgsId = [];
        foreach ($imgs as $v) {
            $imgsId[] = $v['id'];
        }
        $goods = new DemandGoodsModel();
        $goods->goodsImg = $imgsId;
        $goods->category_id = $data['category_id'];
        $goods->img_id = reset($imgs)['id'];
        $goods->type = $data['type'];
        $goods->link = $data['link'];
        $goods->domain = $data['domain'];
        $goods->source_id = $data['source_id'];
        $goods->source = $data['source'];
        $goods->name = $data['goods_name'];
        $goods->sku_name = $data['sku_name'];
        $goods->unit = $data['goods_unit'];
        $goods->known_unit_price = $data['price'];
        $goods->count = $data['count'];
        $goods->price = $goods->count * $goods->known_unit_price;
        $goods->remark = $data['remark'];
        $goods->store_name = $data['store_name'];
        $goods->store_lng = $data['store_lng'];
        $goods->store_lat = $data['store_lat'];
        //经纬度解析地址
        if ($goods->store_lng && $goods->store_lat) {
            $result = static::coordToSite($goods->store_lng, $goods->store_lat);
            if ($result) {
                $goods->province = $result['result']['address_component']['province'];
                $goods->city = $result['result']['address_component']['city'];
                $goods->area = $result['result']['address_component']['district'];
                $goods->address = $result['result']['address_component']['street'];
            }
        }

        $this->data->demandGoods->push($goods);

        return $this;
    }

    /**
     * 发布需求
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $endTime
     * @return $this
     */
    public function issue($endTime)
    {
        $this->data->status = 1;
        $this->data->is_issue = 1;
        $this->data->issue_time = date('Y-m-d H;i:s');
        $this->data->end_time = $endTime;
        $param = [
            'title'   => '发布成功',
            'content' => '需求发布成功，等待报价。订单编号：' . $this->data->order_number,
        ];
        $this->createMessage($param);

        return $this;
    }

    /**
     * 计算商品价格
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function countGoodsPrice()
    {
        $price = $this->data->demandGoods->sum('price');
        $this->data->known_price = $price;

        return $this;
    }

    /**
     * 计算订单支付金额
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function countPrice()
    {
        $price = $this->data->tender_price + $this->data->express_price - $this->data->coupon_price;
        $this->data->price = $price;

        return $this;
    }

    /**
     * 保存商品
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     * @throws ExceptionRepository
     */
    public function saveGoods()
    {
        if (!$this->data->id) {
            throw new ExceptionRepository('订单基本没保存', -1);
        }
        //保存商品
        $this->data->demandGoods()->saveMany($this->data->demandGoods);
        //保存商品图片
        foreach ($this->data->demandGoods as $v) {
            $v->imgs()->sync($v->goodsImg);
        }

        return $this;
    }

    /**
     * 处理失效订单
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return bool
     */
    public function clearFailure()
    {
        if ($this->data->end_time < time() && $this->data->status == 1) {
            $this->data->status = -1;
            $this->data->is_issue = 0;
            //修改报价人状态
            $this->updateFrostPledge('订单失效，报价未被选中');
            $this->data->userTender()->where('status', 1)->update(['status' => 2]);
            $param = [
                'title'   => '订单提醒',
                'content' => '订单到期，未选报价（或无报价），订单失效。订单编号：' . $this->data->order_number,
            ];
            $this->createMessage($param);

            return $this->save();
        }

        return true;
    }

    public function createMessage($data = [], $userId = null)
    {
        $message = new UserMessageModel();
        $message->fill($data);
        $message->user_id = $userId ? : $this->data->user_id;
        $message->demand_id = $this->data->demand_id;
        $message->type = 'demand';

        return $message->save();
    }

    public function hideAddress()
    {
        preg_match_all('/\d/', $this->data->address, $result);
        $result = $result[0];
        $replace = [];
        for ($i = 0; $i < count($result); $i++) {
            $replace[] = '*';
        }

        return str_replace($result, $replace, $this->data->address);
    }

    public function copyDemand(UserModel $user, $count = 1)
    {
        $demand = Demand::create();
        $demand->data->source_id = $this->data->source_id;
        $demand->data->category_id = $this->data->category_id;
        $demand->data->user_id = $user->id;
        $demand->data->select_user_id = $this->data->select_user_id;
        $demand->data->user_tender_id = $this->data->user_tender_id;
        $demand->data->copy_demand_id = $this->data->id;
        $demand->data->is_select = 1;
        $demand->data->is_copy = 1;
        $demand->data->count = $count;
        $demand->data->pay_end_time = time() + (3600 * 2);
        $demand->data->order_number = static::generateNumber(10);
        $demand->data->type = $this->data->type;
        $demand->data->express_price = $this->data->express_price;
        $demand->data->tender_price = $this->data->tender_price * $count;
        $demand->data->issue_lng = $user->lng;
        $demand->data->issue_lat = $user->lat;
        $demand->data->is_issue = 1;
        $demand->data->status = 2;
        //地址解析
        $demand->coordAnalysis();
        //预加载商品和商品图片
        $this->data->load('demandGoods', 'demandGoods.imgs');
        //添加订单商品
        foreach ($this->data->demandGoods as $v) {
            $goods = new DemandGoodsModel();
            $goods->source_id = $v->source_id;
            $goods->category_id = $v->category_id;
            $goods->img_id = $v->img_id;
            $goods->goodsImg = $v->imgs->pluck('id')->toArray();
            $goods->type = $v->type;
            $goods->link = $v->link;
            $goods->domain = $v->domain;
            $goods->source = $v->source;
            $goods->sku_name = $v->sku_name;
            $goods->unit = $v->unit;
            $goods->name = $v->name;
            $goods->count = $v->count * $count;
            $goods->known_unit_price = $v->known_unit_price;
            $goods->price = $goods->known_unit_price * $goods->count;
            $goods->store_name = $v->store_name;
            $goods->store_lng = $v->store_lng;
            $goods->store_lat = $v->store_lat;
            $goods->province = $v->province;
            $goods->city = $v->city;
            $goods->area = $v->area;
            $goods->address = $v->address;
            $demand->data->demandGoods->push($goods);
        }

        return $demand;
    }

    public function checkCopy($count)
    {
        $res = [
            'status' => true,
        ];
        $repertory = $this->getHotboomRepertory();
        if ($repertory < $count) {
            $res['status'] = false;
            $res['message'] = '代购库存不足';
        }
        if ($this->data->selectUserTender->hotboom_end_time < time()) {
            $res['status'] = false;
            $res['message'] = '代购时间已过期';
        }

        return $res;
    }

    public function getHotboomRepertory()
    {
        $repertory = $this->data->selectUserTender->getRepertory();
        $count = $this->data->is_pay ? $repertory : $repertory - 1;

        return $count ? : 0;
    }

    public function isCirculation()
    {
        if (!$this->data->is_select) {
            return false;
        }
        if (!$this->data->is_pay) {
            return false;
        }
        if ($this->getHotboomRepertory() < 1) {
            return false;
        }

        if ($this->data->selectUserTender->hotboom_end_time < time()) {
            return false;
        }

        return true;
    }

    public function getCirculationCount()
    {
        return DemandModel::where('copy_demand_id', $this->data->id)->count() ? : 0;
    }

    public function deliveryNotice()
    {
        $templateId = '6oowEdBdZtGhIxJ_LXkulbhhOzxhf8ufaHlxznIOlCk';
        $notice = app('wechat')->notice;
        $goods = $this->data->demandGoods()->first();
        try {
            $notice->send(
                [
                    'touser'      => $this->data->user->openid,
                    'template_id' => $templateId,
                    'url'         => url('wechat/demand/details/' . $this->data->id),
                    'data'        => [
                        'first'    => '订单发货通知！',
                        'keyword1' => '红利需求订单',
                        'keyword2' => $goods ? $goods->name : '',
                        'keyword3' => '【' . $this->data->selectUser->nickname . '】' . $this->data->selectUser->mobile,
                        'keyword4' => '订单金额：￥' . $this->data->known_price,
                        'keyword5' => date('Y年m月d日H时i分s秒'),
                        'remark'   => '点击查看详情！',
                    ],
                ]
            );
        } catch (HttpException $e) {

        }
    }

    public function paySuccessNotice()
    {
        $templateId = 'GLo9ko1obB6dfsBLT4CTjA7jd7pJZ_X1mybBhkwLC5U';
        $notice = app('wechat')->notice;
        try {
            $notice->send(
                [
                    'touser'      => $this->data->selectUser->openid,
                    'template_id' => $templateId,
                    'url'         => url('wechat/hotboom-demand/details/' . $this->data->id),
                    'data'        => [
                        'first'    => '您的红利分享订单已支付成功',
                        'keyword1' => $this->data->order_number,
                        'keyword2' => $this->data->tender_price,
                        'keyword3' => date('Y年m月d日H时i分s秒'),
                        'remark'   => '点击查看详情！',
                    ],
                ]
            );
        } catch (HttpException $e) {

        }
    }

}
