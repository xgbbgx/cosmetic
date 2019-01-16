<?php
namespace common\core\api;
use Yii;
use common\core\base\BaseController;

/**
 * frontend 前端 Controller
 * @author Alex
 *
 */
class Controller extends BaseController
{
    public $accessToken;
    public $uid;//用户uid
    public function beforeAction($action){
        parent::beforeAction($action);
        $controllerId=Yii::$app->controller->id;
        $actionId=Yii::$app->controller->action->id;
        if($controllerId=='site' && $actionId=='error'){
            
        }else{
           
        }
        return true;
    }
    protected function renderJSON($data=[], $code = 0, $msg ="") {
        header('Content-type: application/json');
        if($code){
            $msg=Yii::t('error', $code);
        }
        $jsonResult = json_encode([
            "code" => $code,
            "msg" => $msg,
            "data" => $data,
            "time" => time()
        ],JSON_UNESCAPED_UNICODE);
        return $jsonResult;
    }
}