<?php

namespace App\Repositories\Grab;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/12
 * Time: 18:05
 * Author: wenlongh <wenlongh@qq.com>
 */
class Ctrip extends Base
{
    public function filterName()
    {
        preg_match('/<h1 class\=\"cm\-page\-title js\_title\"\>\<span class\=\"align\"\>(.+?)\<\/span>/', $this->getContent(), $dd);
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
        $regex = '/<div class\=\"t\-i js\_head\_slider\" data\-ubt\-key\=\"c_hotel_inland_detaila_picture\"\>[\s\S]+?<img src=\"([^\<]+?)\"[\s\S]+?style\=\"height\:100%;width\:100%\" is\=\"c\-img\" pageCode\=\"H5HotelDetail\"\/>/';
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
//        $this->filterPrice();
        $this->filterImg();

        return $this->result;
    }
}