<?php

namespace App\Repositories;

use App\Models\Banner as BannerModel;

class Banner extends Base
{

    public static $modelName = BannerModel::class;

    public static $space = [
        'home-top'    => '首页顶部',
        'home-center' => '首页中间',
    ];

    /**
     * 置顶
     *
     * @author xiaoze <zeasly@live.com>
     * @return $this
     */
    public function setTop()
    {
        $check = BannerModel::max('sort');
        $this->data->sort = ++$check;

        return $this;
    }

    public static function getHomeCenter()
    {
        $data = BannerModel::where('status', 1)->where('space', 'home-center')->first();
        if (!$data) {
            return null;
        }

        return static::initByModel($data);
    }

}
