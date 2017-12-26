<?php

namespace App\Repositories;

use App\Exceptions\ExceptionRepository;

abstract class BaseList
{
    protected $items;

    /**
     * @var \Illuminate\Database\Query\Builder
     */
    protected $builder;

    protected $customerCondition;


    public static $model;


    public function customerCondition()
    {
        return [];
    }


    /**
     * @param $items
     * @return static
     */
    public static function initByItems($items)
    {
        $obj = new static();
        $obj->items = $items;

        return $obj;
    }

    public static function initByBuilder($builder)
    {
        $obj = new static();
        $obj->builder = $builder;

        return $obj;
    }

    /**
     * @param bool $new
     * @return \Illuminate\Database\Query\Builder
     */
    public function getBuilder($new = false)
    {
        if ($new || $this->builder == null) {
            $model = static::$model;
            $this->builder = $model::query();
        }

        return $this->builder;
    }

    protected function defaultOrderBy()
    {
        return $this->getBuilder()->orderBy('id', 'desc');
    }


    public function where($where = [])
    {
        $builder = $this->getBuilder();
        if ($where instanceof \Closure) {
            $builder->where($where);
        } elseif (is_array($where)) {
            $customerCondition = $this->customerCondition();
            foreach ($where as $k => $v) {
                if (!is_null($v) && isset($customerCondition[$k])) {
                    $customerCondition[$k]($builder, $v);
                } else {
                    static::buildWhere($builder, $k, $v);
                }
            }
        } else {
            throw new ExceptionRepository('错误的参数类型', -2);
        }

        return $this;
    }

    /**
     * @author xiaoze <zeasly@live.com>
     * @param \Illuminate\Database\Query\Builder $builder
     * @param $column
     * @param $value
     * @return mixed
     */
    public static function buildWhere($builder, $column, $value)
    {
        if ($value instanceof \Closure) {
            $builder->where($value);
        } elseif (is_array($value)) {
            if (count($value) === 3) {
                list($column, $operator, $search) = $value;
                $builder->where($column, $operator, $search);
            } elseif (count($value) === 2) {
                list($column, $search) = $value;
                $builder->where($column, '=', $search);
            }
        } else {
            $builder->where($column, '=', $value);
        }

        return $builder;
    }

    /**
     * @param array $where
     * @param int $pagesize
     * @param string $pageName
     * @param null $page
     * @return static
     */
    public static function getList($where = [], $pagesize = 15, $pageName = null, $page = null)
    {
        $obj = new static();
        $obj->where($where);

        if (is_null($pageName)) {
            $pageName = 'page';
        }
        $obj->paginate($pagesize, $pageName, $page);

        return $obj;
    }


    public static function getAll($where = [], $builder = null)
    {
        $obj = new static();
        $obj->where($where);

        if ($builder instanceof \Closure) {
            $builder($obj->getBuilder());
        }

        $obj->all();

        return $obj;
    }

    public function paginate($pagesize = 15, $pageName = 'page', $page = null)
    {
        $this->defaultOrderBy();
        $this->items = $this->getBuilder()->paginate($pagesize, ['*'], $pageName, $page);

        return $this;
    }

    public function all()
    {
        $this->defaultOrderBy();
        $this->items = $this->getBuilder()->get();

        return $this;
    }


    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    public function __call($method, $parameters)
    {
        call_user_func_array([$this->getBuilder(), $method], $parameters);

        return $this;
    }

}
