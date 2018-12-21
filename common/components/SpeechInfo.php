<?php
namespace common\components;
use Yii;
use common\helpers\UtilHelper;
use common\models\speech\SpeechFlow;
use common\services\SpeechService;
use common\services\aliyun\AliSpeechInfo;
class SpeechInfo{
    public static $baseDir=Yii::getAlias('@data-file');
    /**
     * 
     * @param string $fName
     * @param string $dir
     * @return string[]|string[]|unknown[]
     */
    public static function upload($fName='file',$dir=''){
        if ($_FILES[$fName]["error"] > 0){
            return UtilHelper::rtnCode('10101',Yii::t('error', '10101').':'.$_FILES[$fName]["error"]);
        }
        $code=UtilHelper::rtnUqMd5Code();
        $nodeDir= '/uploads/speech';
        if(empty($dir)){
            $dir='/'.date('Y').'/'.date('m').'/'.date('d').'/';
        }
        $urlDir=$nodeDir.$dir;
        $fileDir=self::$baseDir.$nodeDir.$dir;
        if(!is_dir($fileDir)){
            if(mkdir($fileDir,0777,true)){
            }else{
                return UtilHelper::rtnCode('10102');
            }
        }
        $ext='';
        $type  = $_FILES[$fName]['type'];
        switch ($type){
            case 'audio/wav':
                $ext='wav';
                break;
            default:
                $ext='';
        }
        if(empty($ext)){
            return UtilHelper::rtnCode('10103');
        }
        $fileName=$code.'.'.$ext;
        $file=$fileDir.$fileName;
        if(!move_uploaded_file($_FILES[$fName]["tmp_name"],$file)){
           return UtilHelper::rtnCode('10104');
        }
        return [
            'dst_code'=>$code,
            'dst_name'=>$fileName,
            'dst_url'=>$urlDir.$fileName,
            'dst_size'=>$_FILES[$fName]["size"]
        ];
    }
    /**
     * 
     * @return string[]|\common\components\string[]|\common\components\unknown[]
     */
    public static function uploadSpeech(){
        $files=self::upload();
        if(isset($files['dst_code']) && $files['dst_code']){
            $speechFlow=new SpeechFlow();
            $speechFlow->code=$files['dst_code'];
            $speechFlow->dst_name=$files['dst_name'];
            $speechFlow->dst_url=$files['dst_url'];
            $speechFlow->size=intval($files['dst_size']);
            if($speechFlow->save()){
                $data=[
                    'code'=>'10001',
                    'msg'=>Yii::t('error', '10001'),
                    'data'=>$speechFlow
                ];
                return $data;
            }else{
                return UtilHelper::rtnCode('10002');
            }
        }else{
            return $files;
        }
    }
    
    public static function arc($dstUrl,$type=1){
        $absFile=self::$baseDir.$dstUrl;
        if($type==1){//baidu
            $rtnAsr=SpeechService::baiduAsr($absFile);
        }else if($type==2){//aliyun
            $rtnAsr=AliSpeechInfo::speechArc($absFile);
        }
        
    }
}