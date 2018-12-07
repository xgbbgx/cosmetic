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
                <a href="javascript:void(0);" onclick="delBlog(\''.$id.'\',\''.Html::encode($i['name']).'\',this)">
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
}
