<?php


namespace app\user\model;


use baseAll\model\BaseMod;
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

}