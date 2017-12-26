<?php

namespace App\Models;

class UserTender extends Base
{
    protected $table = 'user_tender';

    protected $guarded = ['id'];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function demand()
    {
        return $this->belongsTo(Demand::class, 'demand_id');
    }

    public function quoteAdvantage()
    {
        return $this->hasMany(QuoteAdvantage::class, 'user_tender_id');
    }

    public function getPrice()
    {
        return $this->quote;
    }

    public function countSparePrice()
    {
        $price = $this->demand->known_price - $this->quote;

        return $price < 0 ? 0 : $price;
    }

    public function getSite()
    {
        return $this->province . $this->city . $this->area . $this->address;
    }

    public function getDay()
    {
        $time = $this->getTime();
        if ($time <= 0) {
            return 0;
        }

        return intval($time / (3600 * 24));
    }

    public function getHour()
    {
        $time = $this->getTime();
        $time = $time - ($this->getDay() * 86400);
        if ($time <= 0) {
            return 0;
        }

        return intval($time / (3600));
    }

    public function getTime()
    {
        return $this->hotboom_end_time - time();
    }

    public function getRepertory()
    {
        return $this->repertory - $this->frost_repertory;
    }

    public function isDelete()
    {
        if (in_array($this->status, [-1, 2, 4])) {
            return true;
        }

        return false;
    }
}
