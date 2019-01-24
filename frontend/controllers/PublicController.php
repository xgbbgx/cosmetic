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
    public function actionStorybook(){
        $data=[];
        $blurbArr=Blurb::loadBlurbByDomainAndPage(1,3);
        if($blurbArr){
            $blurb=[];
            foreach ($blurbArr as $b){
                $blurb[$b['id']]=$b['name'];
            }
            $data['blurb']=$blurb;
        }
        if(Yii::$app->request->get('blurb')=='true'){
            $data['isBlurb']=true;
        }
        return $this->render('storybook',$data);
    }
    
    public function actionQrcode(){
        
    }
}
