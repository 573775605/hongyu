<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Repositories\Demand;
use App\Repositories\UserTender;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Demand as DemandModel;

class FailurePayDemand extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $demand;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DemandModel $demand)
    {
        $this->demand = $demand;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $demand = Demand::initByModel($this->demand);
        if ($demand->data->is_select && !$demand->data->is_pay) {
            //减少报价冻结库存
            $tender = UserTender::initByModel($demand->data->selectUserTender);
            $tender->reduceFrostRepertory($demand->data->count)->save();
            //修改订单状态
            $demand->payFailure()->save();
        }
    }
}
