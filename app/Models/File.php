<?php

namespace App\Models;

class File extends Base
{
    /**
     * 定义数据库表名
     *
     * @var string
     */
    protected $table = 'upload_file';

    protected $guarded = ['id'];


    public function defaultValue()
    {
        return [

        ];
    }

}
