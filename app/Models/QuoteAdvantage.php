<?php

namespace App\Models;

class QuoteAdvantage extends Base
{
    protected $table = 'quote_advantage';

    protected $guarded = ['id'];

    public $timestamps = true;

    public function defaultValue()
    {
        return [];
    }

    public function userTender()
    {
        return $this->belongsTo(UserTender::class, 'user_tender_id');
    }
}
