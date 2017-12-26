<?php

namespace App\Repositories;

use App\Models\GoodsSource as GoodsSourceModel;
use App\Models\Demand as DemandModel;

class GoodsSource extends Base
{
    public static $modelName = GoodsSourceModel::class;

    public function countTotalDemand()
    {
        $count = DemandModel::where('source_id', $this->data->id)->count();
        $this->data->demand_count = $count;

        return $this;
    }

    public function countIssueDemand()
    {
        $count = DemandModel::where('source_id', $this->data->id)->where('is_issue', 1)->count();
        $this->data->issue_demand_count = $count;

        return $this;
    }

    public function countOverDemand()
    {
        $count = DemandModel::where('source_id', $this->data->id)->where('status', '>', 4)->count();
        $this->data->over_demand_count = $count;

        return $this;
    }

    public function countSparePrice()
    {
        $knownPrice = DemandModel::where('source_id', $this->data->id)->where('is_pay', 1)->sum('known_price');
        $tenderPrice = DemandModel::where('source_id', $this->data->id)->where('is_pay', 1)->sum('tender_price');
        $price = $knownPrice - $tenderPrice;
        $this->data->total_spare_price = $price < 0 ? 0 : $price;

        return $this;
    }

}
