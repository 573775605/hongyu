<?php

namespace App\Repositories;

use App\Models\QuoteAdvantage as QuoteAdvantageModel;

class QuoteAdvantageList extends BaseList
{
    public static $model = QuoteAdvantageModel::class;

    public function getFlatten()
    {
        $res = [];
        foreach ($this->getItems() as $v) {
            $res[] = \GuzzleHttp\json_decode($v->label, true);
        }

        return collect($res)->flatten()->toArray();
    }
}
