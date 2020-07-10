<?php


namespace baseAll\controller;


use think\Controller;

class BaseAll extends Controller
{
    protected $userInfo = [];

    function check_token($token) {
        /**** api传来的token ****/
        if(!isset($token) || empty($token)) {
            $msg['code']='400';
            $msg['msg']='非法请求';
            return json_encode($msg,JSON_UNESCAPED_UNICODE);
        }
        //对比token
        $explode = explode('.',$token);
        //以.分割token为数组
        if(!empty($explode[0]) && !empty($explode[1]) && !empty($explode[2]) && !empty($explode[3]) ) {
            $info = $explode[0].'.'.$explode[1].'.'.$explode[2];
            //信息部分
            $true_signature = hash_hmac('md5',$info,'siasqr');
            //正确的签名
            if(time() > $explode[2]) {
                $msg['code']='401';
                $msg['msg']='Token已过期,请重新登录';
                return json_encode($msg,JSON_UNESCAPED_UNICODE);
            }
            if ($true_signature == $explode[3]) {
                $msg['code']='200';
                $msg['msg']='Token合法';
                return json_encode($msg,JSON_UNESCAPED_UNICODE);
            } else {
                $msg['code']='400';
                $msg['msg']='Token不合法';
                return json_encode($msg,JSON_UNESCAPED_UNICODE);
            }
        } else {
            $msg['code']='400';
            $msg['msg']='Token不合法';
            return json_encode($msg,JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * @param $string    要加密/解密的字符串
     * @param $operation    类型，E 加密；D 解密
     * @param string $key   密钥
     * @return mixed|string
     */
    function encryptString($string, $operation, $key = 'encrypt')
    {
        $key = md5($key);
        $key_length = strlen($key);
        $string = $operation == 'D' ? base64_decode($string) : substr(md5($string . $key), 0, 8) . $string;
        $string_length = strlen($string);
        $rndkey = $box = array();
        $result = '';
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($key[$i % $key_length]);
            $box[$i] = $i;
        }
        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if ($operation == 'D') {
            if (substr($result, 0, 8) == substr(md5(substr($result, 8) . $key), 0, 8)) {
                return substr($result, 8);
            } else {
                return '';
            }
        } else {
            return str_replace('=', '', base64_encode($result));
        }
    }


}