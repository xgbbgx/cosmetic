<?php
namespace common\helpers;

class SignHelper{
 
     /**
     *生成支付链接需要的md5数据
     */
    public static function getSignMsg($pay_params=array(),$md5_key)
    {
        $params_str = "";
        $signMsg = "";
        ksort($pay_params);
        foreach($pay_params as $key=>$val){
            if($key!="signMsg" && isset($val) && @$val!="")
            {
                $params_str .= $key."=".$val."&";
            }
        }
        $params_str .= "key=" . $md5_key;
        $signMsg = strtolower(md5($params_str));
        return $signMsg;
    }
    /**
    *校验异步返回数据中的md5数据
    */
    public static function checkSignMsg($pay_params=array(),$md5_key)
    {
        ksort($pay_params);
        $params_str = "";
        $signMsg = "";
        foreach($pay_params as $key=>$val){
            if($key!="signMsg" && !is_null($val) && @$val!="")
            {
                $params_str .= $key."=".$val."&";
            }
        }
        $params_str .= "key=" . $md5_key;
        $signMsg = strtolower(md5($params_str));
        $return=false;
        if($signMsg && isset($pay_params['signMsg']) && $pay_params['signMsg']){
            if($signMsg==$pay_params['signMsg']){
                $return=true;
            }
        }
        return $return;
    }
}