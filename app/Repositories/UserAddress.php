<?php

namespace App\Repositories;

use App\Models\UserAddress as UserAddressModel;

class UserAddress extends Base
{
    public static $modelName = UserAddressModel::class;

    /**
     * 获取默认
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param $userId
     * @return null|static
     */
    public static function getDefault($userId)
    {
        $data = UserAddressModel::where('user_id', $userId)->where('is_default', 1)->first();
        if (!$data) {
            return null;
        }

        return static::initByModel($data);
    }

    /**
     * 查看是否有默认
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function checkDefault()
    {
        if (!static::getDefault($this->data->user_id)) {
            $this->data->is_default = 1;
        } else {
            if ($this->data->is_default) {
                $this->clearDefault($this->data->user_id);
            }
        }

        return $this;
    }

    /**
     * 设置默认
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function setDefault()
    {
        $this->clearDefault();
        $this->data->is_default = 1;

        return $this;
    }

    /**
     * 清空默认
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return mixed
     */
    public function clearDefault()
    {
        return UserAddressModel::where('user_id', $this->data->user_id)->update(['is_default' => 0]);
    }

    public function remove()
    {
        if ($this->data->is_default) {
            $data = UserAddressModel::where('user_id', $this->data->user_id)->where('id', '<>', $this->data->id)->first();
            if ($data) {
                $data->update(['is_default' => 1]);
            }
        }

        return $this->data->delete();
    }

    public function getDetailsSite()
    {
        return $this->data->province . $this->data->city . $this->data->area . $this->data->address;
    }

}
