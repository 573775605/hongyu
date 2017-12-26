<?php

namespace App\Repositories;

use App\Models\UserMessage;
use App\Models\WithdrawApply as WithdrawApplyModel;
use App\Models\UserFundAccount as UserFundAccountModel;

class WithdrawApply extends Base
{
    public static $modelName = WithdrawApplyModel::class;

    public static $type = [
        'hotboom' => '代购余额',
        'other'   => '其他余额',
        'pledge'  => '保证金',
    ];

    public static $status = [
        1  => '待审核',
        2  => '已打款',
        -1 => '不通过',
    ];

    public static $accountType = [
        'alipay' => '支付宝',
        'bank'   => '银行卡',
    ];

    public static function createApply(UserFundAccountModel $fund, $data = [])
    {
        $obj = static::create($data);
        $obj->data->account_type = $fund->type;
        $obj->data->name = $fund->name;
        $obj->data->bank_name = $fund->bank_name;
        $obj->data->account = $fund->account;

        return $obj;
    }

    public function check($status, $remark = '')
    {
        $this->data->is_check = 1;
        $this->data->check_time = date('Y-m-d H:i:s');
        $this->data->check_remark = $remark;
        $this->data->status = $status;
        //更新用户账户信息
        $user = User::initByModel($this->data->user);
        $type = '';
        switch ($this->data->type) {
            case 'hotboom':
                $type = '代购余额';
                $user->frostHotboomBalance(-$this->data->price);
                if ($status == 2) {
                    $user->updateHotboomBalance(-$this->data->price, '提现成功');
                }
                break;
            case 'other':
                $type = '余额';
                $user->frostBalance(-$this->data->price);
                if ($status == 2) {
                    $user->updateBalance(-$this->data->price, '提现成功');
                }
                break;
            case 'pledge':
                $type = '保证金';
                $user->frostPledge(-$this->data->price);
                if ($status == 2) {
                    $user->updatePledge(-$this->data->price, '提现成功');
                }
                break;

            default:
                # code...
                break;
        }
        $user->save();
        $message = new UserMessage();
        $status = $status == 2 ? '通过' : '不通过。审核原因：' . $remark;
        $data = [
            'user_id' => $this->data->user_id,
            'type'    => 'system',
            'title'   => '提现通知',
            'content' => '账户' . $type . '提现审核' . $status,
        ];
        $message->fill($data)->save();

        return $this;
    }

    /**
     * 计算平台抽成比例
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function countServicePrice()
    {
        $scale = Config::get('daigou_balance_withdraw_scale');
        $price = round($this->data->actual_price * $scale, 2);
        $this->data->actual_price = $this->data->price - $price;

        return $this;
    }
}
