<?php

namespace backend\controllers;

use Yii;
use common\models\category\Brand;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\core\backend\Controller;
use backend\models\BrandSearch;
use yii\grid\GridView;
use common\helpers\UtilHelper;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use common\models\category\CategoryLevel;
use common\models\category\Category;

/**
 * ClassifyController implements the CRUD actions for Brand model.
 */
class ClassifyController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * Lists all Brand models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionList(){
        $sEcho= empty($_GET['sEcho']) ? 0:intval($_GET['sEcho']);
        $colums=array("id","","name","name_en",'name_py');
        $arr=UtilHelper::getDataTablesParams($_GET,$colums);
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 1,
            "iTotalDisplayRecords" => 1,
            "aaData" => array()
        );
        $iData=Brand::search($arr);
        $totalNum=empty($iData['totalNum']) ?0:$iData['totalNum'];
        $output['iTotalRecords']=$totalNum;
        $output['iTotalDisplayRecords']=$totalNum;
        if($totalNum){
            $brandType=Yii::$app->params['classify_conf']['brand_type'];
            $iList=empty($iData['list']) ?[]:$iData['list'];
            foreach($iList as $k=>$i){
                $id=$i['id'];
                $img='<img style="width:80px;" src="'.$i['logo'].'">';
                $action='
                <a  href="/classify/view?id='.$id.'"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;&nbsp;
                <a  href="/classify/update?id='.$id.'"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;&nbsp;
                <a href="/classify/delete?id='.$id.'" title="删除" aria-label="删除" data-pjax="0" 
                data-confirm="您确定要删除此项吗？" data-method="post">
                <i class="glyphicon glyphicon-trash"></i></a>';
                $aaData=array($id,
                    $img,
                    Html::encode($i['name']),
                    Html::encode($i['name_en']),
                    Html::encode($i['name_py']),
                    empty($brandType[$i['type']]) ? '':$brandType[$i['type']],
                    $action);
                $output['aaData'][]=$aaData;
            }
        }
        echo json_encode($output);
        exit;
    }
    
    /**
     * Displays a single Brand model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brand();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Brand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Brand model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $model->datafix=$model::DATAFIX_DELETE;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Brand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    
    public function actionCategoryList(){
        $tree=Category::loadCategoryTree();
        $data['tree']=$tree;
        return $this->render('category_list',$data);
    }
    public function actionGetCategoryList(){
        $sEcho= empty($_GET['sEcho']) ? 0:intval($_GET['sEcho']);
        $colums=array("","t3.name1","t3.name2",'t4.name');
        $arr=UtilHelper::getDataTablesParams($_GET,$colums);
        
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 1,
            "iTotalDisplayRecords" => 1,
            "aaData" => array()
        );
        
        $totalNum=Category::loadCategoryNumByArr($arr);
        $output['iTotalRecords']=$totalNum;
        $output['iTotalDisplayRecords']=$totalNum;
        if($totalNum){
            $iList=Category::loadCategoryByArr($arr);
            $a=1;
            foreach($iList as $k=>$i){
                $province='<a href="/classify/category?id='.$i['cid1'].'">'.$i['name1'].'</a>';
                $city='<a href="/classify/category?id='.$i['cid2'].'">'.$i['name2'].'</a>';
                $district='<a href="/classify/category?id='.$i['cid3'].'">'.$i['name3'].'</a>';
                $actions='';
                $aaData=array($a,$province,$city,$district,$actions);
                $output['aaData'][]=$aaData;
                $a++;
            }
        }
        echo json_encode($output);
        exit;
    }
    public function actionCategory(){
        $id=Yii::$app->request->get('id');
        if($id){
            $model = Category::findOne($id);
        }
        if(empty($model)){
            $model=new Category();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/classify/category', 'id' => $model->id]);
        }
        
        return $this->render('category', [
            'model' => $model,
        ]);
    }
    public function actionCategoryView(){
        $id=Yii::$app->request->get('id');
        $model = Category::findOne($id);
        return $this->render('category_view', [
            'model' => $model,
        ]);
    }
    public function actionCategoryDel($id)
    {
        $id=Yii::$app->request->get('id');
        $model = Category::findOne($id);
        $model->datafix=$model::DATAFIX_DELETE;
        $model->save();
        return $this->redirect(['/classify/category-list']);
    }
    /**
     * Function output the site that you selected.
     * @param int $pid
     * @param int $typeid
     */
    public function actionSite($pid, $id = 0)
    {
        $model = new Category();
        $model = $model->getCategoryList($pid);
        
        $aa="--请选择分类--";
        
        echo Html::tag('option',$aa, ['value'=>'empty']) ;
        
        foreach($model as $value=>$name)
        {
            if($id==$value){}else
            echo Html::tag('option',Html::encode($name),array('value'=>$value));
        }
    }
}
