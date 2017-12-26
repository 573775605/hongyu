<?php

namespace App\Repositories;

use App\Models\User as UserModel;
use App\Models\UserInfo as UserInfoModel;
use App\Models\UserInfoAuth as UserInfoAuthModel;
use App\Models\UserPledgeLog as UserPledgeLogModel;
use App\Models\UserSpareLog as UserSpareLogModel;
use App\Models\Coupon as CouponModel;
use App\Models\UserCoupon as UserCouponModel;
use App\Models\UserFeedback as UserFeedbackModel;
use App\Models\UserMessage as UserMessageModel;

class User extends Base
{
    public static $modelName = UserModel::class;

    public static $status = [
        0 => '冻结',
        1 => '正常',
    ];

    public static function getByOpenid($openid)
    {
        $data = UserModel::where('openid', $openid)->first();
        if (!$data) {
            return null;
        }

        return static::initByModel($data);
    }

    public function hideMobile()
    {
        $this->data->hide_mobile = 1 - $this->data->hide_mobile;

        return $this;
    }

    public function frost()
    {
        $this->data->status = 1 - $this->data->status;

        return $this;
    }

    /**
     * 关注公众号
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function subscribe()
    {
        $this->data->is_subscribe = 1;
        $this->data->subscribe_time = date('Y-m-d H:i:s');

        return $this;
    }

    public function grantCoupon()
    {
        $cond = [
            'status' => 1,
            ['start_time', '<=', date('Y-m-d H:i:s')],
            ['end_time', '>=', date('Y-m-d H:i:s')],
        ];
        $coupon = CouponList::getAll($cond);
        foreach ($coupon->getItems() as $v) {
            $this->createCoupon($v);
        }

        return $this;
    }

    /**
     * 获取用户详情
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return UserInfoModel|mixed
     */
    public function getUserInfo()
    {
        $userInfo = $this->data->userInfo;
        if (!$userInfo) {
            $userInfo = new UserInfoModel();
            $userInfo->user_id = $this->data->id;
        }

        return $userInfo;
    }

    /**
     * 创建支付订单
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return static
     */
    public function createPayOrder($price)
    {
        $param = [
            'user_id' => $this->data->id,
            'type'    => 'pledge',
            'price'   => $price,
            'title'   => '保证充值',
            'details' => '微信支付充值',
        ];
        $payOrder = PaymentOrder::create($param);
        $payOrder->save();

        return $payOrder;
    }

    /**
     * 保存审核通过资料
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param UserInfoAuthModel $auth
     * @return $this
     */
    public function authPass(UserInfoAuthModel $auth)
    {
        $this->data->is_auth = 1;
        //保存详细信息
        $info = $this->getUserInfo();
        $info->name = $auth->name;
        $info->idcard = $auth->idcard;
        $info->idcard_front_img = $auth->idcard_front_img;
        $info->idcard_reverse_img = $auth->idcard_reverse_img;
        $info->save();

        return $this;
    }

    /**
     * 发布需求总评价
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $grade
     * @return $this
     */
    public function issueEvaluate($grade)
    {
        $this->data->total_evaluate_count += 1;
        $this->data->total_evaluate_grade += $grade;
        $this->data->evaluate_avg_grade = intval($this->data->total_evaluate_grade / $this->data->total_evaluate_count);

        return $this;
    }

    /**
     * 代购总评价
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $grade
     * @return $this
     */
    public function hotboomEvaluate($grade)
    {
        $this->data->daigou_total_evaluate_count += 1;
        $this->data->daigou_total_evaluate_grade += $grade;
        $this->data->daigou_evaluate_avg_grade = intval($this->data->daigou_total_evaluate_grade / $this->data->daigou_total_evaluate_count);

        return $this;
    }

    /**
     * 冻结押金
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $price
     * @return $this
     */
    public function frostPledge($price)
    {
        $this->data->frost_pledge += $price;

        return $this;
    }

    public function frostBalance($price)
    {
        $this->data->frost_balance += $price;

        return $this;
    }

    public function frostHotboomBalance($price)
    {
        $this->data->frost_daigou_balance += $price;

        return $this;
    }

    /**
     * 用户是否认证
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return bool
     */
    public function isAuth()
    {
        return boolval($this->data->is_auth);
    }

    /**
     * 查看用户是否有没有审核申请
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return bool
     */
    public function hasNotCheckApply()
    {
        $result = $this->data->userInfoAuth->search(
            function ($item) {
                return $item->status == 1;
            }
        );

        return $result !== false;
    }

    /**
     * 更新余额
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $price
     * @param string $remark
     * @param array $data
     * @return $this
     */
    public function updateBalance($price, $remark = '', $data = [])
    {
        $this->data->balance += $price;

        $balanceLog = UserBalanceLog::create($data);
        $balanceLog->data->user_id = $this->data->id;
        $balanceLog->data->type = 'other';
        $balanceLog->data->change_balance = $price;
        $balanceLog->data->balance = $this->data->balance;
        $balanceLog->data->remark = $remark;
        $balanceLog->save();

        return $this;
    }

    /**
     * 更新代购余额
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $price
     * @param string $remark
     * @param array $data
     * @return $this
     */
    public function updateHotboomBalance($price, $remark = '', $data = [])
    {
        $this->data->daigou_balance += $price;

        $balanceLog = UserBalanceLog::create($data);
        $balanceLog->data->user_id = $this->data->id;
        $balanceLog->data->type = 'hotboom';
        $balanceLog->data->change_balance = $price;
        $balanceLog->data->balance = $this->data->balance;
        $balanceLog->data->remark = $remark;
        $balanceLog->save();

        return $this;
    }

    /**
     * 更新保证金
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $price
     * @param string $remark
     * @param array $data
     * @return $this
     */
    public function updatePledge($price, $remark = '', $data = [])
    {
        $this->data->pledge += $price;

        $pledge = new UserPledgeLogModel();
        $pledge->fill($data);
        $pledge->user_id = $this->data->id;
        $pledge->change_pledge = $price;
        $pledge->pledge = $this->data->pledge;
        $pledge->remark = $remark;
        $pledge->save();

        return $this;
    }

    public function updateSpare($price, $data = [])
    {
        $this->data->total_spare_price += $price;

        $log = new UserSpareLogModel();
        $log->fill($data);
        $log->user_id = $this->data->id;
        $log->change_price = $price;
        $log->save();

        return $this;
    }

    public function createCoupon(CouponModel $coupon)
    {
        $userCoupon = new UserCouponModel();
        $userCoupon->user_id = $this->data->id;
        $userCoupon->name = $coupon->name;
        $userCoupon->description = $coupon->description;
        $userCoupon->type = $coupon->type;
        $userCoupon->price = $coupon->price;
        $userCoupon->full_price_use = $coupon->full_price_use;
        $userCoupon->valid_time = date('Y-m-d H:i:s', time() + $coupon->valid_time);
        $userCoupon->save();

        return $this;
    }

    /**
     * 保存用户反馈信息
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param array $data
     * @return bool
     */
    public function saveFeedback($data = [])
    {
        $feedback = new UserFeedbackModel();
        $feedback->fill($data);
        $feedback->user_id = $this->data->id;

        return $feedback->save();
    }

    public function createSystemMessage($data = [])
    {
        $message = new UserMessageModel();
        $message->fill($data);
        $message->user_id = $this->data->id;
        $message->type = 'system';

        return $message->save();
    }

}
