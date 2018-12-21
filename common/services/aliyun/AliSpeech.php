<?php
namespace common\services\aliyun;

use Yii;
// 修改成自己的SDK路径
require_once '/path/to/aliyun-openapi-php-sdk/aliyun-php-sdk-core/Config.php';
require_once '/path/to/aliyun-openapi-php-sdk/aliyun-php-sdk-nls-filetrans/nls_filetrans/Request/V20180817/SubmitTaskRequest.php';
require_once '/path/to/aliyun-openapi-php-sdk/aliyun-php-sdk-nls-filetrans/nls_filetrans/Request/V20180817/GetTaskResultRequest.php';
use nls_filetrans\Request\V20180817\SubmitTaskRequest;
use nls_filetrans\Request\V20180817\GetTaskResultRequest;
/**
 * 地域ID
 * 常量内容，请勿改变
 */
define("REGION_ID",     "cn-shanghai");
define("ENDPOINT_NAME", "cn-shanghai");
define("PRODUCT",       "nls-filetrans");
define("DOMAIN",        "filetrans.cn-shanghai.aliyuncs.com");
define("API_VERSION",         "2018-08-17");
define("POST_REQUEST_ACTION", "SubmitTask");
define("GET_REQUEST_ACTION",  "GetTaskResult");
/**
 * 参数设置Key
 * 常量内容，请勿改变
 */
define("KEY_APP_KEY",     "app_key");
define("KEY_FILE_LINK",   "file_link");
define("KEY_TASK",        "Task");
define("KEY_TASK_ID",     "TaskId");
define("KEY_STATUS_TEXT", "StatusText");
class AliSpeech{
   public static function fileTrans($fileLink){
       $speechConf=Yii::$app->params['speech_conf']['aliyun'];
       
       return self::_fileTrans($speechConf['access_key_id'], $speechConf['access_key_secret'], 
           $speechConf['app_key'], $fileLink);
   }
   /**
    * $accessKeyId = "您的AccessKey Id";
    $accessKeySecret = "您的AccessKey Secret";
    $appKey = "您的app_key";
    $fileLink = "https://aliyun-nls.oss-cn-hangzhou.aliyuncs.com/asr/fileASR/examples/nls-sample-16k.wav";
    fileTrans($accessKeyId, $accessKeySecret, $appKey, $fileLink);
    * @param unknown $accessKeyId
    * @param unknown $accessKeySecret
    * @param unknown $appKey
    * @param unknown $fileLink
    */
   public static function _fileTrans($accessKeyId, $accessKeySecret, $appKey, $fileLink) {
        // 设置endpoint
        \DefaultProfile::addEndpoint(
            ENDPOINT_NAME,
            REGION_ID,
            PRODUCT,
            DOMAIN);
        /**
         * 创建阿里云鉴权client
         */
        $clientProfile = \DefaultProfile::getProfile(
            REGION_ID,
            $accessKeyId,
            $accessKeySecret);
        $client = new \DefaultAcsClient($clientProfile);
        /**
         * 创建提交录音文件识别请求，设置请求参数
         */
        $submitTaskRequest = new SubmitTaskRequest();
        // 获取task json字符串，包含app_key和file_link参数
        $taskArr = array(KEY_APP_KEY => $appKey, KEY_FILE_LINK => $fileLink);
        $task = json_encode($taskArr);
        print $task . "\n";
        // 设置task
        $submitTaskRequest->setTask($task);
        try {
            /**
             * 提交录音文件识别请求，处理服务端返回的响应
             */
            $submitTaskResponse = $client->getAcsResponse($submitTaskRequest);
            print_r($submitTaskResponse);
            // 获取录音文件识别请求任务的ID，以供识别结果查询使用
            $taskId = "";
            $statusText = ((array)$submitTaskResponse)[KEY_STATUS_TEXT];
            if (strcmp("SUCCESS", $statusText) == 0) {
                $taskId = ((array)$submitTaskResponse)[KEY_TASK_ID];
                print "录音文件识别请求成功!\n";
            }
            else {
                print "录音文件识别请求失败!\n";
                return;
            }
            /**
             * 创建录音文件识别结果查询请求
             * 以轮询的方式进行识别结果的查询，直到服务端返回的状态描述为"SUCCESS"、"SUCCESS_WITH_NO_VALID_FRAGMENT"，
             * 或者为错误描述，则结束轮询。
             */
            $getTaskResultRequest = new GetTaskResultRequest();
            $getTaskResultRequest->setTaskId($taskId);
            /**
             * 提交查询识别结果请求
             * 以轮询的方式进行识别结果的查询，直到服务端返回的状态描述符为"SUCCESS"、"SUCCESS_WITH_NO_VALID_FRAGMENT",
             * 或者为错误描述，则结束轮询。
             */
            $statusText = "";
            while (TRUE) {
                $getTaskResultResponse = $client->getAcsResponse($getTaskResultRequest);
                print_r($getTaskResultResponse);
                $statusText = ((array)$getTaskResultResponse)[KEY_STATUS_TEXT];
                if (strcmp("RUNNING", $statusText) == 0 || strcmp("QUEUEING", $statusText) == 0) {
                    // 继续轮询
                    sleep(3);
                }
                else {
                    // 退出轮询
                    break;
                }
            }
        } catch (ServerException $e) {
            print "ServerException: " . $e->getErrorCode() . " Message: " . $e->getMessage() . "\n";
        } catch (ClientException $e) {
            print "ClientException: " . $e->getErrorCode() . " Message: " . $e->getMessage() . "\n";
        }
        if (strcmp("SUCCESS", $statusText) == 0 || strcmp("SUCCESS_WITH_NO_VALID_FRAGMENT", $statusText) == 0) {
            print "录音文件识别成功!\n";
        }
        else {
            print "录音文件识别失败!\n";
        }
    }
}

?>