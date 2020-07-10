<?php


namespace app\user\model;


use base\model\baseMod;
use think\Db;

class User extends baseMod
{
    public function getOneInfo($id){
        $userInfo = Db::table('user')->where('id',$id)->find();
        return $userInfo;
    }

    public function getOneInfoWhere($where){
        $userInfo = Db::table('user')->where($where)->find();
        return $userInfo;
    }

}