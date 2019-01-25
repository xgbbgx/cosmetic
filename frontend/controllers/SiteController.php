<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\elastic\Product;
use common\services\SphinxClient;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex()
    {
        $data=[];
        $product=[];
       /** $query = [
            'match_phrase' => [
                'product_name' =>[
                    'query'=>'兰蔻',
                ]
            ]
        ];
        $highlight = [
            'pre_tags' => '<em>',
            'post_tags' => '</em>',
            'fields' => ['keyword'=>new \stdClass()]
        ];
        $customer = Product::find()->query($query)
        ->highlight($highlight)->asArray()->all();
        if($customer){
            foreach ($customer as $c){
                if(isset($c['_source']) && $c['_source']){
                    if(isset($c['_source']['cover']) && $c['_source']['cover']){
                        $product[]=$c['_source'];
                    }
                }
            }
        }*/
        $data['product']=$product;
        return $this->render('index',$data);
    }
}
