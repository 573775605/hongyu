<?php

namespace App\Repositories;

use App\Models\GoodsIssueRecord as GoodsIssueRecordModel;
use App\Repositories\Upload\File;

class GoodsIssueRecordList extends BaseList
{
    public static $model = GoodsIssueRecordModel::class;

    public function loadFirstImg()
    {
        foreach ($this->getItems() as $v) {
            if ($v->imgs) {
                $imgs = \GuzzleHttp\json_decode($v->imgs, true);
                $file = File::initById(reset($imgs)['id']);
                $v->firstImg = $file ? $file->data->url : '';
            }
        }
    }
}
