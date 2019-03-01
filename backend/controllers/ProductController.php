<?php

namespace backend\controllers;

use Yii;
use common\core\backend\Controller;
use yii\filters\VerbFilter;
use common\helpers\UtilHelper;
use common\models\category\Category;
use common\models\category\Brand;
use yii\web\NotFoundHttpException;
use common\models\product\ProductEffect;
use common\models\product\ProductSkin;
use common\models\product\Product;
use yii\helpers\Html;

class ProductController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionProductList(){
        return $this->render('product_list');
    }
    public function actionGetProductList(){
        $sEcho= empty($_GET['sEcho']) ? 0:intval($_GET['sEcho']);
        $colums=array("id","name");
        $arr=UtilHelper::getDataTablesParams($_GET,$colums);
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 1,
            "iTotalDisplayRecords" => 1,
            "aaData" => array()
        );
        $totalNum=Product::loadProductNumByArr($arr);
        $output['iTotalRecords']=$totalNum;
        $output['iTotalDisplayRecords']=$totalNum;
        if($totalNum){
            $iList=Product::loadloadProductByArr($arr);
            foreach($iList as $k=>$i){
                $id=$i['id'];
                $option='';
                $actions='
				<a  class="edit btn blue icn-only" href="/product/view?cid='.$i['category_id'].'&bid='.$i['brand_id'].'&id='.$id.'"><i class="icon-edit icon-white"></i></a>&nbsp;
				&nbsp;&nbsp;&nbsp;<a  class="btn red icn-only" href="javascript:void(0);"
                onclick="delFormat(\''.$id.'\',\''.Html::encode($i['name']).'\',this)"><i class="icon-trash icon-white"></i></a>'; 
                $aaData=array($id,$i['name'],$i['name_en'],$i['name_py'],$option,$actions);
                $output['aaData'][]=$aaData;
            }
        }
        echo json_encode($output);
        exit;
    }
    public function actionSelect(){
        $data=[];
        $category0=Category::loadCategoryListByParentId(0);
        $data['category0']=$category0;
        return $this->render('product_select',$data);
    }
    public function actionGetSelect($pid,$d){
        $data=[];
        $category=Category::loadCategoryListByParentId($pid);
        $data['pid']=$pid;
        $data['d']=$d;
        $data['category']=$category;
        return $this->renderAjax('p_select',$data);
    }
    public function actionView(){
       $data=[];
       $request=Yii::$app->request;
       $bid=$request->get('bid');
       if($bid){
           $brand=Brand::loadBrandById($bid);
           $data['brand']=$brand;
       }
       if(empty($brand)){
           throw new NotFoundHttpException(Yii::t('error','20301'));
       }
       $cid=$request->get('cid');
       if($cid){
           $category=Category::loadCategoryById($bid);
           $data['category']=$category;
       }
       if(empty($category)){
           throw new NotFoundHttpException(Yii::t('error','20302'));
       }
       $data['cid']=$cid;
       $data['bid']=$bid;
       $id=$request->get('id');
       //
       $product=Product::getOne('*',['id'=>$id]);
       $data['product']=$product;
       $data['productEffect']=ProductEffect::loadAllProductEffect();
       $data['productSkin']=ProductSkin::loadAllProductSkin();
       return $this->render('product_view',$data);
    }
    public function actionEdit(){
        $request=Yii::$app->request;
        $brandId=intval($request->post('brand_id'));
        $categoryId=intval($request->post('category_id'));
        $name=$request->post('name');
        $nameEn=$request->post('name_en');
        $namePy=$request->post('name_py');
        $image=$request->post('image');
        $effectIds=$request->post('effect_ids');
        $skinIds=$request->post('skin_ids');
        if($brandId && $categoryId){
        }else{
            return UtilHelper::rtnError('20401');
        }
        $id=$request->post('id');
        if($id){
            $product=Product::findOne(['id'=>$id]);
        }else{
            $product=new Product();
        }
        $product->name=$name;
        $product->name_en=empty($nameEn) ?'':$nameEn;
        $product->name_py=empty($namePy) ?'':$namePy;
        $product->image=empty($image) ?'':$image;
        $product->brand_id=$brandId;
        $product->category_id=$categoryId;
        $product->effect_ids=empty($effectIds) ?'':implode(',', $effectIds);
        $product->skin_ids=empty($skinIds) ?'':implode(',', $skinIds);
        $option=$product->save();
        if($option){
            echo json_encode([
                'code'=>'00001',
                'msg'=>Yii::t('error','00001'),
                'id'=>$product->id]
            );
            return ;
        }else{
            return UtilHelper::rtnError('00002',UtilHelper::getModelError($product));
        }
    }
}
