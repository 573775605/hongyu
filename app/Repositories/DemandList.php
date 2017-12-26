<?php

namespace App\Repositories;

use App\Models\Demand as DemandModel;
use App\Models\User as UserModel;
use DB;

class DemandList extends BaseList
{
    public static $model = DemandModel::class;

    public function __construct()
    {
        $this->getBuilder()->whereHas(
            'user',
            function ($q) {
                $q->select('id')->where('status', 1);
            }
        );
    }

    public function customerCondition()
    {
        return [
            'keyword' => function ($q, $param) {
                $q->where(
                    function ($q) use ($param) {
                        $q->where('order_number', $param)->orWhereHas(
                            'demandGoods',
                            function ($q) use ($param) {
                                $q->where('name', 'like', "%{$param}%");
                            }
                        );
                        $q->orWhereHas(
                            'user',
                            function ($q) use ($param) {
                                $q->where('nickname', 'like', "%$param%");
                            }
                        );
                    }
                );
            },
        ];
    }

    /**
     * @author wenlongh <wenlongh@qq.com>
     * @param $lng
     * @param $lat
     * @param $where
     * @param int $pageSize
     * @return $this
     * 获取附近需求
     */
    public static function getNearbyList($lng, $lat, $where = [], $pageSize = 15)
    {
        if (!$lng || !$lat) {
            return static::getList($where, $pageSize);
        }
        $str = <<<EQ
        ROUND(6378.138*2*ASIN(SQRT(POW(SIN(({$lat}*PI()/180-issue_lat*PI()/180)/2),2)
        +COS({$lat}*PI()/180)*COS(issue_lat*PI()/180)*POW(SIN(({$lng}*PI()/180-issue_lng*PI()/180)/2),2)))*1000) AS juli
EQ;

        $bulider = DemandModel::select(DB::raw('*,' . $str))->orderBy('juli', 'asc');
        $logic = static::initByBuilder($bulider);
        $logic->where($where);

        return $logic->paginate($pageSize);
    }

    /**
     * 计算发布距离
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param UserModel $user
     * @return $this
     */
    public function countDistance(UserModel $user)
    {
        foreach ($this->getItems() as $v) {
            if ($user->lng && $user->lat) {
                $distance = Demand::getdistance($user->lng, $user->lat, $v->issue_lng, $v->issue_lat);
                $v->distance = round($distance / 1000, 1);
            } else {
                $v->distance = 0;
            }
        }

        return $this;
    }

    /**
     * 计算发布时间
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function countIssueTime()
    {
        foreach ($this->getItems() as $v) {
            $v->issue_time = Demand::countTimeInterval($v->issue_time);
        }

        return $this;
    }

    public function countCirculation()
    {
        foreach ($this->getItems() as $v) {
            $demand = Demand::initByModel($v);
            $v->circulation = $demand->isCirculation();
            if ($v->circulation) {
                $v->circulation_count = $demand->getCirculationCount();
            }
        }

        return $this;
    }
}
