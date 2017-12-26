<?php

namespace App\Console\Commands;

use App\Models\Demand as DemandModel;
use App\Repositories\Demand;
use Illuminate\Console\Command;

class AutoConfirmSignfor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demand:auto-confirm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '自动确认7天后未签收订单';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DemandModel::where('is_pay', 1)->where('status', 4)
            ->whereRaw('NOW()>FROM_UNIXTIME(UNIX_TIMESTAMP(delivery_time)+(60*60*24*7))')
            ->chunk(
                100,
                function ($item) {
                    foreach ($item as $v) {
                        $demand = Demand::initByModel($v);
                        $demand->confirmSignfor()->save();
                    }
                }
            );
    }
}
