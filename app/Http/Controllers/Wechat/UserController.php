<?php

namespace App\Http\Controllers\Wechat;

use App\Repositories\Demand;
use App\Repositories\DemandList;
use App\Repositories\Sms;
use App\Repositories\User;
use App\Repositories\UserCouponList;
use App\Repositories\UserEvaluateLogList;
use App\Repositories\UserHotboomEvaluateLogList;
use App\Repositories\UserInfoAuth;
use App\Repositories\UserTender;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/8/29
 * Time: 16:58
 * Author: wenlongh <wenlongh@qq.com>
 */
class UserController extends Controller
{

    public function bindMobile()
    {
        if ($this->request->ajax()) {
            $verifyId = $this->request->input('verify_id');
            $verifCode = $this->request->input('verify_code');
            $sms = Sms::getByid($verifyId);
            if (!$sms) {
                return $this->returnJson(-1, '验证码错误');
            }
            if (!$sms->verify($verifCode)) {
                return $this->returnJson(-1, '验证码错误');
            }
            $user = $this->getUser();
            $data = [
                'mobile' => $sms->data->mobile,
            ];
            if ($user->save($data)) {
                return $this->returnJson();
            }

            return $this->returnJson(-1, '绑定失败,请重试');
        }

        return view('wechat.user.bind_mobile');
    }

    public function feedback()
    {
        if ($this->request->isMethod('post')) {
            $user = $this->getUser();
            $content = $this->request->input('content');
            if ($user->saveFeedback(['content' => $content])) {
                if ($this->request->ajax()) {
                    return $this->returnJson();
                }

                return redirect('wechat/center');
            }
        }

        return view('wechat.user.feedback');
    }

    public function hideMobile()
    {
        $user = $this->getUser();
        if ($user->hideMobile()->save()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1);
    }

    public function userInfo()
    {
        $user = $this->getUser();
        if ($this->request->isMethod('post')) {
            $info = $user->getUserInfo();
            $info->description = $this->request->input('description');
            if ($info->save()) {
                return redirect('wechat/center');
            }
        }
        $data = [
            'user' => $user->getData(),
        ];

        return view('wechat.user.user_info', $data);
    }

    public function wallet()
    {
        $user = $this->getUser();
        $demand = $user->data->hotboomDemand()->selectRaw('sum(tender_price+express_price) as price')
            ->where('is_pay', 1)->where('status', '<', 5)->where('status', '<>', -2)->first();
        $data = [
            'user'           => $user->getData(),
            'payDemandPrice' => $demand->price,
        ];

        return view('wechat.user.wallet', $data);
    }

    public function pledgeRecharge()
    {
        $user = User::initById($this->getUserId());
        if ($this->request->isMethod('post')) {
            $this->validate($this->request, ['price' => 'numeric|min:1'], ['price.*' => '请输入有效充值金额']);
            $price = $this->request->input('price');
            $payment = $user->createPayOrder($price);

            return redirect('wechat/pay/' . $payment->data->id);
        }

        return view('wechat.user.pledge_recharge');
    }

    public function coupon()
    {
        $cond = [
            'user_id' => $this->getUserId(),
        ];
        $coupon = UserCouponList::getAll($cond);
        $data = [
            'rows' => $coupon->getItems(),
        ];

        return view('wechat.user.coupon', $data);
    }

    public function perfectInfo()
    {
        $user = $this->getUser();
        if ($user->hasNotCheckApply()) {
            if ($this->request->ajax()) {
                return $this->returnJson(-1, '资料已提交请等待审核');
            }

            return redirect('wechat/center');
        } else {
            if ($this->request->ajax()) {
                return $this->returnJson(1, 'ok');
            }
        }

        if ($this->request->isMethod('post')) {
            $data = $this->checkInfo();
            if (UserInfoAuth::create($data)->save()) {
                return redirect('wechat/center');
            }
        }

        return view('wechat.user.perfect_info');
    }

    public function sendVerifycode()
    {
        $mobile = $this->request->input('mobile');
        try {
            $sms = Sms::send($mobile);
            $data = [
                'id'     => $sms->data->id,
                'result' => $sms->result,
            ];
        } catch (NotAcceptableHttpException $e) {
            return $this->returnJson(-1, 'ok', '发送失败：' . $e->getMessage());
        }

        return $this->returnJson(1, 'ok', $data);
    }

    public function issueDemand($id, $demandId)
    {
        $user = User::initById($id);
        $evaluate = UserHotboomEvaluateLogList::getList(['user_id' => $id]);

        $demand = Demand::initById($demandId);
        $cond = [
            'user_id'  => $id,
            'is_issue' => 1,
            'status'   => 1,
        ];
        $demandList = DemandList::getAll($cond);
        $demandList->countIssueTime();

        $data = [
            'user'       => $user->getData(),
            'evaluate'   => $evaluate->getItems(),
            'demand'     => $demand,
            'demandList' => $demandList->getItems(),
        ];

        return view('wechat.user.issue_demand', $data);
    }

    public function hotboomInfo($userTenderId)
    {
        $tender = UserTender::initById($userTenderId);
        $cond = [
            'user_id' => $tender->data->user_id,
        ];
        $demand = DemandList::getList(['select_user_id' => $tender->data->user_id], 10);
        $demand->countIssueTime();
        if ($this->request->ajax()) {
            $data = [
                'rows' => view('wechat.user.hotboom_info_paging', ['rows' => $demand->getItems()])->render(),
            ];

            return $this->returnJson(1, 'ok', $data);
        }
        $evaluate = UserEvaluateLogList::getList($cond, 3);
        $data = [
            'tender'   => $tender->getData(),
            'evaluate' => $evaluate->getItems(),
            'demand'   => $demand->getItems(),
        ];

        return view('wechat.user.hotboom_info', $data);
    }

    public function checkInfo()
    {
        $rule = [
            'name'               => 'required',
            'idcard'             => 'required',
            'idcard_front_img'   => 'required',
            'idcard_reverse_img' => 'required',
        ];
        $message = [
            'name.required'               => '请输入姓名',
            'idcard.required'             => '请填写身份证号',
            'idcard_front_img.required'   => '请上传身份证正面图',
            'idcard_reverse_img.required' => '请上传身份证反面图',
        ];
        $this->validate($this->request, $rule, $message);
        $input = $this->request->input();

        return [
            'user_id'            => $this->getUserId(),
            'name'               => $input['name'],
            'idcard'             => $input['idcard'],
            'idcard_front_img'   => $input['idcard_front_img'],
            'idcard_reverse_img' => $input['idcard_reverse_img'],
        ];
    }

    public function allEvaluate($type, $userId)
    {
        if ($type == 'issue') {
            $evaluate = UserHotboomEvaluateLogList::getList(['user_id' => $userId]);
        } else {
            $evaluate = UserEvaluateLogList::getList(['user_id' => $userId]);
        }
        $data = [
            'rows' => $evaluate->getItems(),
            'user' => User::initById($userId),
        ];
        if ($this->request->ajax()) {
            $data = [
                'rows' => view('wechat.user.all_evaluate_paging', $data)->render(),
            ];

            return $this->returnJson(1, 'ok', $data);
        }

        return view('wechat.user.all_evaluate', $data);
    }
}