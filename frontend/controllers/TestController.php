<?php
namespace frontend\controllers;

use Yii;
use common\core\frontend\Controller;
use common\services\SpeechService;

/**
 * Site controller
 */
class TestController extends Controller
{
    public $fileDir;
    public function init(){
        $this->enableCsrfValidation = false;
    }
    public function TestController(){
        $fileDir=Yii::getAlias('@data-file/uploads/speech') ;
    }
    public function actionUpload(){
        if ($_FILES["file"]["error"] > 0){
            echo json_encode(['code' => -1, 'data' => '', 'msg' => $_FILES["file"]["error"]]);
            exit;
        }
        
        $name = (string)$_POST['name'];
        $word=(string)$_POST['word'];
        $file= Yii::getAlias('@data-file/uploads/speech') .'/'. $name;
        if(!move_uploaded_file($_FILES["file"]["tmp_name"],$file)){
            echo json_encode(['code' => -2, 'data' => '', 'msg' => '保存失败']);
            exit;
        }
        $speech['score']='11111';
        echo json_encode($speech);
        exit;
    }
    public function actionIndex(){
        return $this->render('index');
    }
    public function actionA(){
        $file=dirname(__FILE__).'/../web/wav/1522138979-208034-271191.wav';
        $data=SpeechService::baiduAsr($file);
        //$res=SpliteService::getPhpanalysisKeywords($data['result'][0]);
        print_r($data);
    }
}