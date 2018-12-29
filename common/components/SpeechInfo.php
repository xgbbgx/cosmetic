<?php
namespace common\components;
use Yii;
use common\helpers\UtilHelper;
use common\models\speech\SpeechFlow;
use common\services\SpeechService;
use common\services\aliyun\AliSpeechInfo;
use common\models\SourceToken;
use common\models\speech\SpeechArc;
use common\services\SpliteService;
use common\models\speech\StopWord;
class SpeechInfo{
    /**
     * 
     * @param string $fName
     * @param string $dir
     * @return string[]|string[]|unknown[]
     */
    public static function upload($fName='file',$dir=''){
        $baseDir=Yii::getAlias('@data-file');
        if ($_FILES[$fName]["error"] > 0){
            return UtilHelper::rtnCommonCode('10101',Yii::t('error', '10101').':'.$_FILES[$fName]["error"]);
        }
        $code=UtilHelper::rtnUqMd5Code();
        $nodeDir= '/uploads/speech';
        if(empty($dir)){
            $dir='/'.date('Y').'/'.date('m').'/'.date('d').'/';
        }
        $urlDir=$nodeDir.$dir;
        $fileDir=$baseDir.$nodeDir.$dir;
        if(!is_dir($fileDir)){
            if(mkdir($fileDir,0777,true)){
            }else{
                return UtilHelper::rtnCommonCode('10102');
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
            return UtilHelper::rtnCommonCode('10103');
        }
        $fileName=$code.'.'.$ext;
        $file=$fileDir.$fileName;
        if(!move_uploaded_file($_FILES[$fName]["tmp_name"],$file)){
            return UtilHelper::rtnCommonCode('10104');
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
    public static function uploadSpeech($fName='file',$dir=''){
        $files=self::upload($fName,$dir);
        if(isset($files['dst_code']) && $files['dst_code']){
            $speechFlow=new SpeechFlow();
            $speechFlow->code=$files['dst_code'];
            $speechFlow->dst_name=$files['dst_name'];
            $speechFlow->dst_url=$files['dst_url'];
            $speechFlow->size=intval($files['dst_size']);
            if($speechFlow->save()){
                $data=[
                    'code'=>'10001',
                    'msg'=>Yii::$app->params['error_conf']['10001'],
                    'data'=>$speechFlow
                ];
                return $data;
            }else{
                return UtilHelper::rtnCommonCode('10002');
            }
        }else{
            return $files;
        }
    }
    /**
     * 
     * @param unknown $id 上传speech_flow的流水id
     * @param number $type
     * @return string[]|mixed[]|string[]|mixed[]|NULL[]
     */
    public static function arc($id,$type=1){
        $result='';
        $speech=SpeechFlow::getOne('dst_url,size',['id'=>$id]);
        if(empty($speech['dst_url'])){
            return  UtilHelper::rtnCommonCode('10202');
        }
        //判断文件大小
        if($speech['size']<1024){
            return  UtilHelper::rtnCommonCode('10203');
        }
        $dstUrl=$speech['dst_url'];
        $absFile=Yii::getAlias('@data-file').$dstUrl;
        if($type==1){//baidu
            $rtnAsr=SpeechService::baiduAsr($absFile);
            if(isset($rtnAsr['result'])){
                $result=@$rtnAsr['result'][0];
            }
        }else if($type==2){//aliyun
           $token=self::rtnAliToken();
           if(empty($token)){
               return UtilHelper::rtnCommonCode('10003');
           }
            $rtnAsr=AliSpeechInfo::speechArc($token,$absFile);
            if(isset($rtnAsr['result'])){
                $result=$rtnAsr['result'];
            }
        }
        $speechArc='';
        if($result){//翻译内容入库
            $speechArc=new SpeechArc();
            $speechArc->speech_flow_id=$id;
            $speechArc->dst_url=$dstUrl;
            $speechArc->content=$result;
            $speechArc->type=$type;
            $speechArc->save();
            SpeechFlow::updateStatusById($id);
        }
        return empty($result) ? UtilHelper::rtnCommonCode('10201'):[
            'code'=>'10001',
            'msg'=>Yii::$app->params['error_conf']['10001'],
            'data'=>$speechArc
        ];
    }

    public static function rtnAliToken(){
        $token='';
        $sourceId=Yii::$app->params['base_conf']['source_token']['0']['key'];
        $sourceToken=SourceToken::loadExpiredTokenBySourceId($sourceId);
        if(!$sourceToken){
            $speechConf=Yii::$app->params['speech_conf']['aliyun'];
            $tokenObj=AliSpeechInfo::getAccessToken($speechConf['access_key_id'], $speechConf['access_key_secret']);
            if(isset($tokenObj->Token->Id) && $tokenObj->Token->Id){
                $token=$tokenObj->Token->Id;
                $sourceToken=new SourceToken();
                $sourceToken->token=$token;
                $sourceToken->expire_time=intval($tokenObj->Token->ExpireTime);
                $sourceToken->source_id=$sourceId;
                $sourceToken->save();
            }
        }else{
            $token=$sourceToken['token'];
        }
        return $token;
    }
    
    public static function splitWord($speechArcId){
        $data=[];
        $speechArc=SpeechArc::findOne(['id'=>$speechArcId]);
        if(isset($speechArc['content']) && $speechArc['content']){
            $data['content']=$speechArc['content'];
            $split=SpliteService::getPhpanalysisKeywords($speechArc['content']);
            if($split){
                $exacWord=$split;
                $stopWord=StopWord::loadStopWordByNames($split);
                if($stopWord){
                    $exacWord=array_diff($split,$stopWord) ;
                }
                $speechArc->split_word=empty($split)?'':implode(",", $split);
                $speechArc->exact_word=empty($exacWord)?'':implode(",", $exacWord);
                $speechArc->save();
                
                $data['split_word']=$speechArc->split_word;
                $data['exact_word']=$speechArc->exact_word;
            }
        }
        return $data;
    }
    /**
     * 
     * @param string $fName
     * @param string $dir
     * @return string[]|mixed[]
     */
    public static function rtnSpeechTag($fName='file',$dir=''){
        $upload=self::uploadSpeech($fName,$dir);
        if(isset($upload['code']) && $upload['code']){
            if($upload['code']=='10001' && !empty($upload['data']->id)){
                $speechArc=SpeechInfo::arc($upload['data']->id,1);
                if(isset($speechArc['code']) && $speechArc['code']){
                    if($speechArc['code']=='10001' && !empty($speechArc['data']->id)){
                        $splitWord=self::splitWord($speechArc['data']->id);
                        return [
                            'code'=>'10001',
                            'msg'=>Yii::$app->params['error_conf']['10001'],
                            'data'=>$splitWord
                        ];
                    }else{
                        return UtilHelper::rtnCommonCode($speechArc['code'],$speechArc['msg']);
                    }
                }
            }else{
                return UtilHelper::rtnCommonCode($upload['code'],$upload['msg']);
            }
        }
        return UtilHelper::rtnCommonCode('10002');
    }
}