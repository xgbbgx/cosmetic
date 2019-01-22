<?php
namespace api\controllers;

use Yii;
use common\core\api\Controller;
use common\models\elastic\Product;
use common\helpers\UtilHelper;

class GoodsController extends Controller
{
    public function actionGetList()
    { 
        $data=[];
        $request=Yii::$app->request;
        $search=$request->get('search');
        if(!$search){
            return UtilHelper::rtnError('20101');
        }
        $search=str_replace(',', ' ', $search);
        /**$query = [
            'multi_match' => [
                'query'=>$search,
                "fields"=>['product_name']
            ]
        ];*/
        $query = [
            'match_phrase' => [
                'product_name' =>[
                    'query'=>$search,
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
                    $data[]=$c['_source'];
                }
            }
        }
        return $this->renderJSON($data);
    }
}
