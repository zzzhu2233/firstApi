<?php


namespace app\user\model;


use base\model\baseMod;

class user extends baseMod
{
    public function getOneInfo($id){
        $userInfo = Db::table('user')->where('id',$id)->find();
        return $userInfo;
    }

}