<?php

namespace App\Models;

class Demand extends Base
{
    protected $table = 'demand';

    protected $guarded = ['id'];

    public $timestamps = true;

    public function defaultValue()
    {
        return [
            'is_select' => 0,
            'status'    => -1,
            'count'     => 1,
        ];
    }

    public function issueEvaluate()
    {
        return $this->hasOne(UserEvaluateLog::class, 'demand_id');
    }

    public function hotboomEvaluate()
    {
        return $this->hasOne(UserHotboomEvaluateLog::class, 'demand_id');
    }

    public function paymentOrder()
    {
        return $this->hasOne(PaymentOrder::class, 'demand_id');
    }

    public function demandGoods()
    {
        return $this->hasMany(DemandGoods::class, 'demand_id');
    }

    public function userTender()
    {
        return $this->hasMany(UserTender::class, 'demand_id');
    }

    public function shopInvoiceImg()
    {
        return $this->belongsToMany(File::class, 'shop_invoice_img', 'img_id', 'demand_id');
    }

    /**
     * 发布需求用户
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userCoupon()
    {
        return $this->belongsTo(UserCoupon::class, 'user_coupon_id');
    }

    /**
     * 中镖用户
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function selectUser()
    {
        return $this->belongsTo(User::class, 'select_user_id');
    }

    public function selectUserTender()
    {
        return $this->belongsTo(UserTender::class, 'user_tender_id');
    }

    public function quoteAdvantage()
    {
        return $this->hasMany(QuoteAdvantage::class, 'user_tender_id', 'user_tender_id');
    }

    public function returnGoodsApply()
    {
        return $this->hasOne(ReturnGoodsApply::class, 'demand_id');
    }

    public function getIssueSite()
    {
        return $this->issue_province . $this->issue_city . $this->issue_area . $this->issue_address;
    }

    public function getPrice()
    {
        return $this->price ? : $this->known_price;
    }

    public function getTenderprice()
    {
        return $this->tender_price;
    }

    public function getHotboomPrice()
    {
        return $this->tender_price + $this->express_price;
    }
}
