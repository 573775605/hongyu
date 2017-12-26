<?php

namespace App\Models;

class User extends Base
{
    protected $table = 'user';

    protected $guarded = ['id'];

    public $timestamps = true;

    public function img()
    {
        return $this->belongsTo(File::class, 'img_id', 'id');
    }

    public function userInfo()
    {
        return $this->hasOne(UserInfo::class, 'user_id');
    }

    public function userInfoAuth()
    {
        return $this->hasMany(UserInfoAuth::class, 'user_id');
    }

    public function hotboomDemand()
    {
        return $this->hasMany(Demand::class, 'select_user_id');
    }

    public function getDaigouBalance()
    {
        return $this->daigou_balance - $this->frost_daigou_balance;
    }

    public function getBalance()
    {
        return $this->balance - $this->frost_balance;
    }

    public function getPledge()
    {
        return $this->pledge - $this->frost_pledge;
    }
}
