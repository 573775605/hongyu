<?php

namespace App\Repositories;

use App\Models\ArticleCategory as ArticleCategoryModel;

/**
 * Class Goods
 *
 * @package App\Repositories
 */
class ArticleCategory extends Base
{
    public static $modelName = ArticleCategoryModel::class;

    public static $type = [
        'about_we' => '关于我们',
    ];

}
