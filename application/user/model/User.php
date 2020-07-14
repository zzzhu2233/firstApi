<?php


namespace app\user\model;


use baseAll\model\BaseMod;
use baseAll\model\MyRedis;
use think\Db;

class User extends BaseMod
{
    public function getOneInfo($id){
        $userInfo = Db::table('user')->where('id',$id)->find();
        return $userInfo;
    }

    public function getOneInfoWhere($where){
        $userInfo = Db::table('user')->where($where)->find();
        return $userInfo;
    }

    /**
     * @desc 获取redis中key
     * @update zrr
     * @time 2020/7/14
     * @param $key string 需要获取的key名称
    */
    public function getToken($key){
        $myRedis = new MyRedis();
        $keyValue = $myRedis->get('test1');
        dump($keyValue);
    }

    /**
     * @desc 设置redis中key
     * @update zrr
     * @time 2020/7/14
     * @param $key string 需要设置的key名称
     * @param $value string 需要设置的key值
     * @param $activeTime integer 单位秒，key的有效时间
     */
    public function setToken($key,$value,$activeTime){
        $myRedis = new MyRedis();
        $keyValue = $myRedis->set('test1','简体中文是否可以','7200');
        dump($keyValue);
    }

}