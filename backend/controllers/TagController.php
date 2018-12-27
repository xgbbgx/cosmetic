<?php

namespace backend\controllers;

use Yii;
use common\models\tag\BaseTag;
use yii\data\ActiveDataProvider;
use common\core\backend\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\UtilHelper;
use yii\helpers\Html;
use common\services\SpliteService;

/**
 * TagController implements the CRUD actions for BaseTag model.
 */
class TagController extends Controller
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
     * Lists all BaseTag models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionList(){
        $sEcho= empty($_GET['sEcho']) ? 0:intval($_GET['sEcho']);
        $colums=array("id","name","weight",'noun');
        $arr=UtilHelper::getDataTablesParams($_GET,$colums);
        $output = array(
            "sEcho" => $sEcho,
            "iTotalRecords" => 1,
            "iTotalDisplayRecords" => 1,
            "aaData" => array()
        );
        $request=Yii::$app->request;
        $type=intval($request->get('type'));
        if($type){
            if(empty($arr['sWhere'])){
                $arr['sWhere'] ='where type='.$type;
            }else{
                $arr['sWhere'] .=' and type='.$type;
            }
        }
        $iData=BaseTag::search($arr);
        $totalNum=empty($iData['totalNum']) ?0:$iData['totalNum'];
        $output['iTotalRecords']=$totalNum;
        $output['iTotalDisplayRecords']=$totalNum;
        if($totalNum){
            $tagType=Yii::$app->params['tag_conf']['base_tag_type'];
            $iList=empty($iData['list']) ?[]:$iData['list'];
            foreach($iList as $k=>$i){
                $id=$i['id'];
                $action='
                <a  href="/tag/view?id='.$id.'"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;&nbsp;
                <a  href="/tag/update?id='.$id.'"><i class="glyphicon glyphicon-pencil"></i></a>&nbsp;&nbsp;
                <a href="/tag/delete?id='.$id.'" title="删除" aria-label="删除" data-pjax="0" data-confirm="您确定要删除此项吗？" data-method="post">
                <i class="glyphicon glyphicon-trash"></i></a>';
                $aaData=array($id,
                    Html::encode($i['name']),
                    Html::encode($i['weight']),
                    Html::encode($i['noun']),
                    empty($tagType[$i['type']]) ? '':$tagType[$i['type']],
                    $action);
                $output['aaData'][]=$aaData;
            }
        }
        echo json_encode($output);
        exit;
    }
    
    /**
     * Displays a single BaseTag model.
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
     * Creates a new BaseTag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BaseTag();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BaseTag model.
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
     * Deletes an existing BaseTag model.
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
     * Finds the BaseTag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BaseTag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BaseTag::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionExportDic(){
        $fileTxt=dirname(__FILE__).'/../../common/services/phpanalysis/dict/not-build/base_dic_new.txt';
        $myfile = fopen($fileTxt, "w");
        if($myfile){
            $baseTag=BaseTag::getAll('name,weight,noun', ['datafix'=>BaseTag::DATAFIX]);
            if($baseTag){
                foreach ($baseTag as $tag){
                    $txt=$tag['name'].','.$tag['weight'].','.$tag['noun']."\n";
                    fwrite($myfile, $txt);
                }
                SpliteService::makePhpanalysis();
            }
            return UtilHelper::rtnError('00001');
        }else{
            return UtilHelper::rtnError('20201');
        }
    }
}