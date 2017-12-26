<?php

namespace App\Models;

class PaymentOrder extends Base
{
    protected $table = 'payment_order';

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
}
