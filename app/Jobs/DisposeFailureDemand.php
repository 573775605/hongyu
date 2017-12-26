<?php

namespace App\Jobs;

use App\Exceptions\ExceptionRepository;
use App\Jobs\Job;
use App\Repositories\Demand;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class DisposeFailureDemand extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $demand;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Demand $demand)
    {
        $this->demand = $demand;
    }

    /**
     * @author wenlongh <wenlongh@qq.com>
     */
    public function handle()
    {
        $demand = Demand::initByModel($this->demand);
        DB::beginTransaction();
        try {
            $demand->clearFailure();

            DB::commit();
        } catch (ExceptionRepository $e) {
            DB::rollBack();
        }

    }
}
