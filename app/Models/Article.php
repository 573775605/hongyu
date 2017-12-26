<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Base
{
    use SoftDeletes;

    /**
     * 定义数据库表名
     *
     * @var string
     */
    protected $table = 'article';

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }

    public function img()
    {
        return $this->belongsTo(File::class, 'img_id');
    }
}
