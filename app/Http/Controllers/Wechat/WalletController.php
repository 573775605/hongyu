<?php

namespace App\Http\Controllers\Wechat;

use App\Exceptions\ExceptionRepository;
use App\Repositories\Config;
use App\Repositories\UserBalancelogList;
use App\Repositories\UserFundAccount;
use App\Repositories\UserFundAccountList;
use App\Repositories\UserPledgeList;
use App\Repositories\UserSpareLogList;
use App\Repositories\WithdrawApply;
use DB;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/6
 * Time: 13:59
 * Author: wenlongh <wenlongh@qq.com>
 */
class WalletController extends Controller
{
    public function balanceLog()
    {
        $cond = [
            'user_id' => $this->getUserId(),
            'type'    => 'other',
        ];
        $balance = UserBalancelogList::getList($cond);
        $data = [
            'rows' => $balance->getItems(),
            'type' => 'balance',
        ];
        if ($this->request->ajax()) {
            $data = [
                'rows' => view('wechat.wallet.paging', $data)->render(),
            ];

            return $this->returnJson(1, 'ok', $data);
        }

        return view('wechat.wallet.balance_log', $data);
    }

    public function pledgeLog()
    {
        $cond = [
            'user_id' => $this->getUserId(),
        ];
        $pledge = UserPledgeList::getList($cond);
        $data = [
            'rows' => $pledge->getItems(),
            'type' => 'pledge',
        ];
        if ($this->request->ajax()) {
            $data = [
                'rows' => view('wechat.wallet.paging', $data)->render(),
            ];

            return $this->returnJson(1, 'ok', $data);
        }

        return view('wechat.wallet.pladge_log', $data);
    }

    public function hotboomBalanceLog()
    {
        $cond = [
            'user_id' => $this->getUserId(),
            'type'    => 'hotboom',
        ];
        $balance = UserBalancelogList::getList($cond);
        $data = [
            'rows' => $balance->getItems(),
            'type' => 'hotboom-balance',
        ];
        if ($this->request->ajax()) {
            $data = [
                'rows' => view('wechat.wallet.paging', $data)->render(),
            ];

            return $this->returnJson(1, 'ok', $data);
        }

        return view('wechat.wallet.hotboom_balance_log', $data);
    }

    public function spareLog()
    {
        $cond = [
            'user_id' => $this->getUserId(),
        ];
        $spare = UserSpareLogList::getList($cond);
        $data = [
            'rows' => $spare->getItems(),
            'type' => 'spare',
        ];
        if ($this->request->ajax()) {
            $data = [
                'rows' => view('wechat.wallet.paging', $data)->render(),
            ];

            return $this->returnJson(1, 'ok', $data);
        }

        return view('wechat.wallet.spare_log', $data);
    }

    public function withdraw()
    {
        $user = $this->getUser();
        if ($this->request->isMethod('post')) {
            $type = $this->request->input('type');
            $price = $this->request->input('price');
            if ($price < 10) {
                return $this->returnJson(-1, '提现金额最少为10元');
            }
            $fundid = $this->request->input('fund_id');
            if ($type == 'hotboom') {
                $price = $price > $user->data->getdaigoubalance() ? $user->data->getdaigoubalance() : $price;
                $user->frostHotboomBalance($price);
            } elseif ($type == 'other') {
                $price = $price > $user->data->getbalance() ? $user->data->getbalance() : $price;
                $user->frostBalance($price);
            } elseif ($type == 'pledge') {
                $price = $price > $user->data->getPledge() ? $user->data->getPledge() : $price;
                $user->frostPledge($price);
            }
            $data = [
                'user_id'      => $this->getuserid(),
                'type'         => $type,
                'price'        => $price,
                'actual_price' => $price,
            ];
            DB::beginTransaction();
            try {
                $withdraw = WithdrawApply::createApply(UserFundAccount::initbyid($fundid)->getdata(), $data);
                if ($type == 'hotboom') {
                    $withdraw->countServicePrice();
                }
                $withdraw->save();
                $user->save();

                DB::commit();
                if ($this->request->ajax()) {
                    return $this->returnJson();
                }

                return redirect('wechat/user/wallet');
            } catch (ExceptionRepository $e) {
                DB::rollback();
                if ($this->request->ajax()) {
                    return $this->returnJson(-1, '提交失败，请重试');
                }
            }

        }
        $cond = [
            'user_id' => $this->getUserId(),
            'type'    => 'bank',
        ];
        $bank = UserFundAccountList::getAll($cond);
        $alipay = UserFundAccount::getAlipayAccount($this->getUserId());
        $data = [
            'user'   => $user->getData(),
            'bank'   => $bank->getItems(),
            'alipay' => $alipay ? $alipay->getData() : null,
        ];
        if (request('type') == 'hotboom') {
            $data['scale'] = Config::get('daigou_balance_withdraw_scale') * 100;
        }

        return view('wechat.wallet.withdraw', $data);
    }

    public function alipayAccount()
    {
        $fund = UserFundAccount::getAlipayAccount($this->getUserId());
        if ($this->request->isMethod('post')) {
            if (!$fund) {
                $fund = UserFundAccount::create();
            }
            $data = [
                'user_id' => $this->getUserId(),
                'type'    => 'alipay',
                'name'    => $this->request->input('name'),
                'account' => $this->request->input('account'),
            ];
            if ($fund->save($data)) {
                $type = $this->request->query('type');
                if ($type) {
                    return redirect('wechat/wallet/withdraw?type=' . $type);
                }

                return redirect('wechat/user/wallet');
            }
        }
        $data = [
            'row' => $fund ? $fund->getData() : null,
        ];

        return view('wechat.wallet.alipay_account', $data);
    }

    public function bankList()
    {
        $cond = [
            'user_id' => $this->getUserId(),
            'type'    => 'bank',
        ];
        $fund = UserFundAccountList::getAll($cond);
        $data = [
            'rows' => $fund->getItems(),
        ];

        return view('wechat.wallet.bank_list', $data);
    }

    public function addBank()
    {
        if ($this->request->isMethod('post')) {
            $data = [
                'user_id'   => $this->getUserId(),
                'type'      => 'bank',
                'name'      => $this->request->input('name'),
                'bank_name' => $this->request->input('bank_name'),
                'account'   => $this->request->input('account'),
            ];
            if (UserFundAccount::create($data)->save()) {
                return redirect('wechat/wallet/bank-list');
            }
        }

        return view('wechat.wallet.add_bank');
    }

    public function removeBank($id)
    {
        $fund = UserFundAccount::initById($id);
        if ($fund->data->user_id != $this->getUserId()) {
            return $this->returnJson();
        }
        if ($fund->delete()) {
            return $this->returnJson();
        }

        return $this->returnJson(-1, '删除失败');
    }
}