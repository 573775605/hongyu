<?php

namespace App\Repositories;

use App\Exceptions\ExceptionRepository;
use App\Models\UserTender as UserTenderModel;
use App\Models\QuoteAdvantage as QuoteAdvantageModel;
use App\Models\UserMessage as UserMessageModel;

class UserTender extends Base
{
    public static $modelName = UserTenderModel::class;

    public static $status = [
        -1 => '已取消',
        1  => '待筛选',
        2  => '已失效',
        3  => '已选中',
        4  => '未选中',
    ];

    public static $type = [
        'raw-hotboom'   => '原路代购',
        'other-hotboom' => '其他商家',
    ];

    public static $hotboomType = [
        'once'        => '单次代购',
        'circulation' => '循环代购',
    ];

    public function setStatus($status)
    {
        $this->data->status = $status;

        return $this;
    }

    /**
     * 取消报价用户
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function cancelTender()
    {
        $this->data->status = -1;
        $this->data->cancel_time = date('Y-m-d H:i:s');
        //修改用户冻结保证金
        $user = User::initByModel($this->data->user);
        $user->frostPledge(-$this->data->known_price);
        $user->save();

        return $this;
    }

    /**
     * 经纬度解析地址
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return $this
     */
    public function coordAnalysis()
    {
        $result = Demand::coordToSite($this->data->lng, $this->data->lat);
        if ($result) {
            $this->data->province = $result['result']['address_component']['province'];
            $this->data->city = $result['result']['address_component']['city'];
            $this->data->area = $result['result']['address_component']['district'];
            $this->data->address = $result['result']['address_component']['street'];
        }

        return $this;
    }

    public function clearAdvantage()
    {
        return $this->data->quoteAdvantage()->delete();
    }

    /**
     * 创建报价优势
     *
     * @author wenlongh <wenlongh@qq.com>
     * @param array $data
     * @return $this
     */
    public function pushAdvantage($data = [])
    {
        foreach ($data as $k => &$v) {
            $select = isset($v['select']) ? $v['select'] : [];
            $advantage = new QuoteAdvantageModel();
            $advantage->name = $k;
            $advantage->label = \GuzzleHttp\json_encode($select);
            $advantage->other = $v['other'];

            $this->data->quoteAdvantage->push($advantage);
        }

        return $this;
    }

    /**
     * 保存报价优势
     *
     * @author wenlongh <wenlongh@qq.com>
     * @return mixed
     * @throws ExceptionRepository
     */
    public function saveAdvantage()
    {
        if (!$this->data->id) {
            throw new ExceptionRepository('报价信息未保存', -1);
        }

        return $this->data->quoteAdvantage()->saveMany($this->data->quoteAdvantage);
    }

    public function createMessage($data = [])
    {
        $message = new UserMessageModel();
        $message->fill($data);
        $message->user_id = $this->data->user_id;
        $message->demand_id = $this->data->demand_id;
        $message->type = 'tender';

        return $message->save();
    }

    public function frostRepertory($count)
    {
        $this->data->frost_repertory += $count;

        return $this;
    }

    public function reduceFrostRepertory($count)
    {
        $this->data->frost_repertory -= $count;

        return $this;
    }

    public function reduceRepertory($count)
    {
        $this->data->repertory -= $count;
        $this->data->frost_repertory -= $count;

        return $this;
    }

}
