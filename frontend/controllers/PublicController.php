<?php
namespace frontend\controllers;

use Yii;
use common\helpers\FileHelper;
use common\services\WxsdkService;
use common\models\Blurb;

class PublicController extends \common\core\frontend\Controller
{
    public function actionUploads(){
        $fileName=Yii::$app->request->get('p');
        echo  FileHelper::getInstance()->file('/'.$fileName); 
    }
    
    public function actionWxShare(){
        $data=[];
        $appid = 'wx3758307a3506f598';
        $appsecret = 'a27be2211104de3ca2d64a82036ee461';
        $jssdk = new WxsdkService($appid,$appsecret);
        $signPackage = $jssdk->GetSignPackage();
        $data['signPackage']=$signPackage;
        return $this->renderAjax('wx_share',$data);
    }
}
