<?php

namespace App\Repositories\Grab;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/12
 * Time: 16:46
 * Author: wenlongh <wenlongh@qq.com>
 */
class Jd extends Base
{
    public function filterName()
    {
        $regex = '/<span\s*class="title-text"\s*>.*<\/span>/';
        preg_match($regex, $this->getContent(), $result);
        if (!empty($result[0])) {
            $this->result['name'] = strip_tags($result[0]);
        }

        return $this;
    }

    public function filterPrice()
    {
        $regex = '/<span\s*class="yang-pic-price"\s*id="jdPrice-copy">(\n*)(.*)/';
        preg_match($regex, $this->getContent(), $result);
        if (!empty($result[2])) {
            $this->result['price'] = floatval(strip_tags($result[2]));
        }

        return $this;
    }

    public function filterImg()
    {
        $regex = '/\<img  src\=\"(.+?)\"  class\=\"J_ping\"  report\-eventid\=\"MProductdetail_Photo\"/';
        preg_match($regex, $this->getContent(), $result);
        if (!empty($result[1])) {
            $img = [
                [
                    'url' => $result[1],
                ],
            ];
            $this->result['img'] = $img;
            $this->uploadImg();
        }

        return $this;
    }

    public function filter()
    {
        $this->filterName();
        $this->filterPrice();
        $this->filterImg();

        return $this->result;
    }
}