<?php
namespace frontend\controllers;

use Yii;
use common\core\frontend\Controller;
use common\services\SpeechService;
use common\components\spider\SpiderInfo;
use common\services\aliyun\AliSpeechInfo;
use common\models\category\CategoryLevel;
use common\helpers\Pinyin;
use common\models\category\Brand;
use common\models\category\Category;
use common\components\SpeechInfo;
use common\models\speech\SpeechFlow;
use app\models\EsStore;
use common\services\SpliteService;
use common\models\elastic\Product;
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
        //$fileDir=Yii::getAlias('@data-file/uploads/speech') ;
        
    }
    public function actionUpload(){
        $speech=[];
        $rtn=SpeechInfo::rtnSpeechTag();
        if(isset($rtn['code']) && $rtn['code']=='10001'){
            $content='';
            if(isset($rtn['data']['exact_word'])){
                $content=$rtn['data']['exact_word'];
            }else if(isset($rtn['data']['split_word'])){
                $content=$rtn['data']['split_word'];
            }else if(isset($rtn['data']['conent'])){
                $content=$rtn['data']['conent'];
            }
            $content=str_replace(',', ' ', $content);
            $query = [
                'multi_match' => ['query'=>$content,
                    "fields"=>['product_name',"feature",'buzzword']
                ]
            ];
            
            $highlight = [
                'pre_tags' => '<em>',
                'post_tags' => '</em>',
                'fields' => ['keyword'=>new \stdClass()]
            ];
            $customer = Product::find()->query($query)
            ->highlight($highlight)->asArray()->all();
            $speech['score']=json_encode($customer);
        }
        echo json_encode($speech);
        exit;
        exit;
        if ($_FILES["file"]["error"] > 0){
            echo json_encode(['code' => -1, 'data' => '', 'msg' => $_FILES["file"]["error"]]);
            exit;
        }
        print_r($_FILES);
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
       
        /**$conn=Yii::$app->db;
        $sql='select id,product_name,product_cover,product_feature,buzzword from t_mac_product';
        $product=$conn->createCommand($sql)->queryAll();
        if($product){
            foreach ($product as $p){
                $pa = new Product();
                $pa->primaryKey=$p['id'];
                $pa->setAttributes([
                    'id'=>$p['id'],
                    'product_name' => $p['product_name'],
                    'cover'=>$p['product_cover'],
                    'feature'=>$p['product_feature'],
                    'buzzword'=>$p['buzzword']
                ], false);
                $pa->save(false);
            }
        }
       exit;
        
        echo '<pre>';
        $query = [
            'multi_match' => ['query'=>'男女老幼',"fields"=>['product_name',"feature",'buzzword']]
        ];
        
        $highlight = [
            'pre_tags' => '<em>',
            'post_tags' => '</em>',
            'fields' => ['keyword'=>new \stdClass()]
        ];
        $customer = Product::find()->query($query)->highlight($highlight)->asArray()->all();
        print_r($customer);
        exit;*/
        /**
         *$tree=Category::loadCategoryTree();
       print_r($tree);
       exit;
        
       
        $file=Yii::getAlias('@data-file/uploads/speech').'/445.wav';
        //AliSpeechInfo::Synthesis('我喜欢你阿红',$file);

        $res=AliSpeechInfo::speechArc($file);
        print_r($res);
        exit;
       
        $speechInfo=SpeechInfo::arc(1,1);
        print_r($speechInfo);
        exit;*/
        return $this->render('index');
    }
    public function actionA(){
        
        $query = [
            'multi_match' => ['query'=>'1994',
                "fields"=>['product_name',"feature",'buzzword']
            ]
        ];
        
        $highlight = [
            'pre_tags' => '<em>',
            'post_tags' => '</em>',
            'fields' => ['keyword'=>new \stdClass()]
        ];
        $customer = Product::find()->query($query)
        ->highlight($highlight)->asArray()->all();
        print_r($customer);
        exit;
        $file=Yii::getAlias('@data-file/uploads/speech') .'/123.wav';
        $content='小优您好我要找粉红色的外套和黑色的长裤子';
        $res=SpeechService::baiduSynthesis(['0'=>$content], $file,['tex'=>$content,'spd'=>'3']);
        //$res=SpliteService::vicword($content);
        print_r($res);
        exit;
        $file=dirname(__FILE__).'/../web/wav/1522138979-208034-271191.wav';
        $data=SpeechService::baiduAsr($file);
        $res=SpliteService::getPhpanalysisKeywords($data['result'][0]);
        print_r($data);
    }
}