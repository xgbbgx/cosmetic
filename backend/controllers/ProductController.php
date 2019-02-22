<?php

namespace backend\controllers;

use Yii;
use common\core\backend\Controller;
use yii\filters\VerbFilter;
use common\helpers\UtilHelper;
use common\models\category\Category;
use common\models\category\Brand;
use yii\web\NotFoundHttpException;

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
        $colums=array("id");
        $arr=UtilHelper::getDataTablesParams($_GET,$colums);
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 1,
            "iTotalDisplayRecords" => 1,
            "aaData" => array()
        );
        
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
       $id=$request->get('id');
       //
       
       
       return $this->render('product_view',$data);
    }
}
