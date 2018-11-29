<?php
namespace common\services;
use  Yii;
use common\services\baidu\AipSpeech;
class SpeechService{
    
   /**
    * 
    * @param string $file
    * @param array $option  cuid	String	用户唯一标识，用来区分用户，填写机器 MAC 地址或 IMEI 码，长度为60以内	
                            dev_pid	语言	模型	是否有标点	备注
                            1536	普通话(支持简单的英文识别)	搜索模型	无标点	支持自定义词库
                            1537	普通话(纯中文识别)	输入法模型	有标点	不支持自定义词库
                            1737	英语		有标点	不支持自定义词库
                            1637	粤语		有标点	不支持自定义词库
                            1837	四川话		有标点	不支持自定义词库
                            1936	普通话远场	远场模型	有标点	不支持

    * @param string $format wav,pcm,amr
    */
    public static function baiduAsr($file,$option=[],$format='pcm'){
        $data=[];
        if($file && file_exists($file)){            
        }else{
            return $data;
        }
        $client=self::baiduClient();
        return $client->asr(file_get_contents($file), $format, 16000,$option);
    }
    /**
     * 百度翻译接口，将文字翻译成语音
     * 
     * @param unknown $content 翻译内容
     * @param unknown $file 文件存放路径
     * @param array $option tex	String	合成的文本，使用UTF-8编码，请注意文本长度必须小于1024字节	是
                            cuid	String	用户唯一标识，用来区分用户， 填写机器 MAC 地址或 IMEI 码，长度为60以内	否
                            spd	String	语速，取值0-9，默认为5中语速	否
                            pit	String	音调，取值0-9，默认为5中语调	否
                            vol	String	音量，取值0-15，默认为5中音量	否
                            per	String	发音人选择, 0为女声，1为男声，
                            3为情感合成-度逍遥，4为情感合成-度丫丫，默认为普通女
     */
    public static function baiduSynthesis($content,$file,$option=[]){
       $client=self::baiduClient();
       $result = $client->synthesis($content, 'zh', 1,$content);
       
       // 识别正确返回语音二进制 错误则返回json 参照下面错误码
       if(!is_array($result)){
           file_put_contents($file, $result);
           return true;
       }
       return $result;
    }
    private static function baiduClient(){
        $baiduConf=Yii::$app->params['speech_conf']['baidu'];
        return new AipSpeech($baiduConf['app_id'], $baiduConf['app_key'], $baiduConf['app_secret']);
    }
}