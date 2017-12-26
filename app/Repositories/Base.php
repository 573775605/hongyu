<?php

namespace App\Repositories;

use App\Exceptions\ExceptionRepository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Base
 *
 * @package App\Repositories
 */
abstract class Base
{

    /**
     * 基本数据模型
     *
     * @var Model
     */
    public $data = null;

    /**
     * 基本模型名称
     *
     * @var string
     */
    public static $modelName;

    /**
     * 初始化对象
     *
     * @param $param
     * @return Base
     * @throws ExceptionRepository
     */
    public static function init($param)
    {
        if (is_numeric($param)) {
            return static::initById($param);
        } elseif ($param instanceof static::$modelName) {
            return static::initByModel($param);
        } else {
            throw new ExceptionRepository('初始化失败,错误的参数类型.', -1);
        }
    }

    /**
     * 根据id初始化
     *
     * @param $id
     * @return static
     * @throws ExceptionRepository
     */
    public static function initById($id)
    {
        $obj = static::getByid($id);
        if (!$obj) {
            throw new ExceptionRepository('初始化失败,找不到数据.', -1);
        }

        return $obj;
    }

    /**
     * 根据模型对象初始化
     *
     * @param $model
     * @return static
     */
    public static function initByModel($model)
    {
        $obj = new static();
        $obj->data = $model;

        return $obj;
    }

    /**
     * 根据id获取对象
     *
     * @param $id
     * @return null|static
     */
    public static function getByid($id)
    {
        $model = static::$modelName;
        $data = $model::find($id);
        if (!$data) {
            return null;
        }

        $obj = new static();
        $obj->data = $data;

        return $obj;
    }

    /**
     * 新建对象
     *
     * @param array $data
     * @return static
     */
    public static function create($data = [])
    {
        $model = new static::$modelName();
        $model->fill($data);

        return static::initByModel($model);
    }

    /**
     * 保存数据
     *
     * @param array $data
     * @return bool
     */
    public function save($data = [])
    {
        return $this->data->fill($data)->save();
    }

    /**
     * 获取基本模型
     */
    public function getData()
    {
        return $this->data;
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->data, $method], $parameters);
    }

    public function delete()
    {
        return $this->data->delete();
    }

    public function logAdd($remark = '')
    {
    }

    public function logUpdate($remark = '')
    {
    }

    public function logDelete($remark = '')
    {
    }

}
