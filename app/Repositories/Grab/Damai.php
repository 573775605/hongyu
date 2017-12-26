<?php

namespace App\Repositories\Grab;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/12
 * Time: 18:05
 * Author: wenlongh <wenlongh@qq.com>
 */
class Damai extends Base
{
    public function filterName()
    {
        preg_match('/<h2 class\=\"tt\">(.+?)<\/h2>/', $this->getContent(), $dd);

        if (!empty($dd[1])) {
            $this->result['name'] = $dd[1];
        }

        return $this;
    }

    public function filterPrice()
    {
        $regex = '/<div class\=\"price\">([\d\.]+?)[^\d\.]/';
        preg_match($regex, $this->getContent(), $result);
        if (!empty($result[1])) {
            $this->result['price'] = floatval($result[1]);
        }

        return $this;
    }

    public function filterImg()
    {
        $regex = "/<div class\=\"thumb\" style\=\"background\-image\: url\(\\'(.+?)\\'\)\"><\/div>/";
        preg_match($regex, $this->getContent(), $result);
        if (!empty($result[1])) {
            $img[] = [
                'url' => $result[1],
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