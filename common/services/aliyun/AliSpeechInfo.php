<?php
namespace common\services\aliyun;

use Yii;
require_once 'aliyun-openapi-php-sdk/aliyun-php-sdk-core/Config.php';
require_once 'aliyun-openapi-php-sdk/aliyun-php-sdk-nls-cloud-meta/nls_cloud_meta/Request/V20180518/CreateTokenRequest.php';
use nls_cloud_meta\Request\V20180518\CreateTokenRequest;

class AliSpeechInfo{
   
    public static function getAccessToken($accessKeyId,$accessKeySecret){
       
        \DefaultProfile::addEndpoint(
            "cn-shanghai",
            "cn-shanghai",
            "nls-cloud-meta",
            "nls-meta.cn-shanghai.aliyuncs.com");
        # 创建DefaultAcsClient实例并初始化
        $clientProfile = \DefaultProfile::getProfile(
            "cn-shanghai",                   # Region ID
            $accessKeyId,               # 您的 AccessKey ID
            $accessKeySecret            # 您的 AccessKey Secret
            );
        $client = new \DefaultAcsClient($clientProfile);
        # 创建API请求并设置参数
        $request = new CreateTokenRequest();
        # 发起请求并处理返回
        try {
            $response = $client->getAcsResponse($request);
            //print_r($response->Token);
            return $response;
        } catch(\ServerException $e) {
            print "Error: " . $e->getErrorCode() . " Message: " . $e->getMessage() . "\n";
        } catch(\ClientException $e) {
            print "Error: " . $e->getErrorCode() . " Message: " . $e->getMessage() . "\n";
        }
    }
    public  static function speechArc($file){
        $speechConf=Yii::$app->params['speech_conf']['aliyun'];
        //$token=self::getAccessToken($speechConf['access_key_id'], $speechConf['access_key_secret']);
       // print_r($token);
       // $token=$token->Token->Id;
       $token='122b3e13440944f4bd642de5aa92b631';
       return  self::Post($file,$token,$speechConf['app_key']);
    }
    public static function Post($file,$token,$appKey){
        $url='http://nls-gateway.cn-shanghai.aliyuncs.com/stream/v1/asr';
        $params=[
            'appkey'=>$appKey,
            'format'=>'pcm',
            'sample_rate'=>'16000',
            'enable_punctuation_prediction'=>'false',
            'enable_inverse_text_normalization'=>'false',
            'enable_voice_detection'=>'false'
        ];
        $url=$url.'?'.http_build_query($params);
        $bodyData=file_get_contents($file);
        $headers =[
            'X-NLS-Token:'.$token,
            'Content-type:application/octet-stream',
            'Content-Length:'.strlen($bodyData),
            'Host:nls-gateway.cn-shanghai.aliyuncs.com'
        ];
        $postData =[
            'audio'=>$bodyData,
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        curl_setopt($ch, CURLOPT_POST, true);
        //curl_setopt($ch,CURLOPT_BINARYTRANSFER,true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 5000);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 5000);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 3);
        $result = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);
        if ($curl_errno != 0) {
            return false;
        }
        return $result;
    }
    
    public static  function Synthesis($text,$file){
        $token='122b3e13440944f4bd642de5aa92b631';
        $speechConf=Yii::$app->params['speech_conf']['aliyun'];
        
        $textUrlEncode = urlencode($text);
        $textUrlEncode = preg_replace('/\+/', '%20', $textUrlEncode);
        $textUrlEncode = preg_replace('/\*/', '%2A', $textUrlEncode);
        $textUrlEncode = preg_replace('/%7E/', '~', $textUrlEncode);
        $format='wav';
        $sampleRate='16000';
        return self::processGETRequest($speechConf['app_key'], $token,$textUrlEncode,$file, $format, $sampleRate);
    }
    public static function processGETRequest($appkey, $token, $text, $audioSaveFile, $format, $sampleRate) {
        $url = "https://nls-gateway.cn-shanghai.aliyuncs.com/stream/v1/tts";
        $url = $url . "?appkey=" . $appkey;
        $url = $url . "&token=" . $token;
        $url = $url . "&text=" . $text;
        $url = $url . "&format=" . $format;
        $url = $url . "&sample_rate=" . strval($sampleRate);
        // voice 发音人，可选，默认是xiaoyun
        // $url = $url . "&voice=" . "xiaoyun";
        // volume 音量，范围是0~100，可选，默认50
        // $url = $url . "&volume=" . strval(50);
        // speech_rate 语速，范围是-500~500，可选，默认是0
        // $url = $url . "&speech_rate=" . strval(0);
        // pitch_rate 语调，范围是-500~500，可选，默认是0
        // $url = $url . "&pitch_rate=" . strval(0);
        print $url . "\n";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        /**
         * 设置HTTPS GET URL
         */
        curl_setopt($curl, CURLOPT_URL, $url);
        /**
         * 设置返回的响应包含HTTPS头部信息
         */
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        /**
         * 发送HTTPS GET请求
         */
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        $response = curl_exec($curl);
        if ($response == FALSE) {
            print "curl_exec failed!\n";
            curl_close($curl);
            return ;
        }
        /**
         * 处理服务端返回的响应
         */
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $headerSize);
        $bodyContent = substr($response, $headerSize);
        curl_close($curl);
        if (stripos($headers, "Content-Type: audio/mpeg") != FALSE || stripos($headers, "Content-Type:audio/mpeg") != FALSE) {
            file_put_contents($audioSaveFile, $bodyContent);
            print "The GET request succeed!\n";
        }
        else {
            print "The GET request failed: " . $bodyContent . "\n";
        }
    }
    public static  function processPOSTRequest($appkey, $token, $text, $audioSaveFile, $format, $sampleRate) {
        $url = "https://nls-gateway.cn-shanghai.aliyuncs.com/stream/v1/tts";
        /**
         * 请求参数，以JSON格式字符串填入HTTPS POST请求的Body中
         */
        $taskArr = array(
            "appkey" => $appkey,
            "token" => $token,
            "text" => $text,
            "format" => $format,
            "sample_rate" => $sampleRate
            // voice 发音人，可选，默认是xiaoyun
            // "voice" => "xiaoyun",
            // volume 音量，范围是0~100，可选，默认50
            // "volume" => 50,
            // speech_rate 语速，范围是-500~500，可选，默认是0
            // "speech_rate" => 0,
            // pitch_rate 语调，范围是-500~500，可选，默认是0
            // "pitch_rate" => 0
        );
        $body = json_encode($taskArr);
        print "The POST request body content: " . $body . "\n";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        /**
         * 设置HTTPS POST URL
         */
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        /**
         * 设置HTTPS POST请求头部
         * */
        $httpHeaders = array(
            "Content-Type: application/json"
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeaders);
        /**
         * 设置HTTPS POST请求体
         */
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        /**
         * 设置返回的响应包含HTTPS头部信息
         */
        curl_setopt($curl, CURLOPT_HEADER, TRUE);
        /**
         * 发送HTTPS POST请求
         */
        $response = curl_exec($curl);
        if ($response == FALSE) {
            print "curl_exec failed!\n";
            curl_close($curl);
            return ;
        }
        /**
         * 处理服务端返回的响应
         */
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headers = substr($response, 0, $headerSize);
        $bodyContent = substr($response, $headerSize);
        curl_close($curl);
        if (stripos($headers, "Content-Type: audio/mpeg") != FALSE || stripos($headers, "Content-Type:audio/mpeg") != FALSE) {
            file_put_contents($audioSaveFile, $bodyContent);
            print "The POST request succeed!\n";
        }
        else {
            print "The POST request failed: " . $bodyContent . "\n";
        }
    }
    /**$appkey = "您的appkey";
    $token = "您的token";
    $text = "1949年10月，中华人民共和国成立。";
    $textUrlEncode = urlencode($text);
    $textUrlEncode = preg_replace('/\+/', '%20', $textUrlEncode);
    $textUrlEncode = preg_replace('/\*\/', '%2A', $textUrlEncode);
    $textUrlEncode = preg_replace('/%7E/', '~', $textUrlEncode);
    $audioSaveFile = "syAudio.wav";
    $format = "wav";
    $sampleRate = 16000;
    processGETRequest($appkey, $token, $textUrlEncode, $audioSaveFile, $format, $sampleRate);
    // processPOSTRequest($appkey, $token, $text, $audioSaveFile, $format, $sampleRate);
    */
}