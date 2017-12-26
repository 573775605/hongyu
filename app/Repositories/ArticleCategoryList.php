<?php

namespace App\Repositories;

use App\Models\ArticleCategory as ArticleCategoryModel;

class ArticleCategoryList extends BaseList
{
    public static $model = ArticleCategoryModel::class;

    protected function defaultOrderBy()
    {
        return $this->getBuilder()->orderBy('id', 'desc');
    }

}
