<?php

namespace App\Console\Commands;

use App\Repositories\Config;
use App\Repositories\GoodsSourceList;
use Illuminate\Console\Command;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/19
 * Time: 13:42
 * Author: wenlongh <wenlongh@qq.com>
 */
class CountSource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count:source';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '统计货源订单';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $source = GoodsSourceList::getAll(['level' => 2]);
        $source->countDemand();
        $source->countTotalSpare();
        Config::countSalesUser();
    }
}