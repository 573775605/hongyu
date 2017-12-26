<?php

namespace App\Repositories;

use App\Models\QuoteAdvantageConfig as QuoteAdvantageConfigModel;

class QuoteAdvantageConfigList extends BaseList
{
    public static $model = QuoteAdvantageConfigModel::class;

    protected function defaultOrderBy()
    {
        return $this->getBuilder()->orderBy('sort', 'asc');
    }
}
