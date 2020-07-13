<?php


namespace app\user\controller;





use baseAll\controller\BaseAll;

class User extends BaseAll
{
    /**
    @desc 验证登录返回token
     * update zrr
     * date 2020/7/9
     */
    public function login(){
        $model = new \app\user\model\User();
        
        $testTok = 'mytest';
        $testTok2 = ['my'=>123,'psd'=>1234];
        $mdAfter = $this->encrypt($testTok,'E');
        dump($mdAfter);
        $mdDecode = $this->encrypt($mdAfter,'D');
        dump($mdDecode);
    }

    public function test2(){
        $model = new \app\user\model\User();
        $find1 = $model->getOneInfo(1);
        dump($find1);
    }
}