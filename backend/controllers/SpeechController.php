<?php

namespace backend\controllers;

use Yii;
use common\models\speech\SpeechArc;
use yii\data\ActiveDataProvider;
use common\core\backend\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use common\helpers\UtilHelper;
use common\components\SpeechInfo;

/**
 * SpeechController implements the CRUD actions for SpeechArc model.
 */
class SpeechController extends Controller
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
     * Lists all SpeechArc models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionList(){
        $sEcho= empty($_GET['sEcho']) ? 0:intval($_GET['sEcho']);
        $colums=array("id",'',"content","split_word",'exact_word','status','type');
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
        $iData=SpeechArc::search($arr);
        $totalNum=empty($iData['totalNum']) ?0:$iData['totalNum'];
        $output['iTotalRecords']=$totalNum;
        $output['iTotalDisplayRecords']=$totalNum;
        if($totalNum){
            $arcType=Yii::$app->params['speech_conf']['arc_type'];
            $iList=empty($iData['list']) ?[]:$iData['list'];
            foreach($iList as $k=>$i){
                $id=$i['id'];
                $action='
                <a  href="/speech/view?id='.$id.'"><i class="glyphicon glyphicon-eye-open"></i></a>&nbsp;&nbsp;
                <a href="/speech/delete?id='.$id.'" title="删除" aria-label="删除" data-pjax="0" data-confirm="您确定要删除此项吗？" data-method="post">
                <i class="glyphicon glyphicon-trash"></i></a>';
                $audio='<video style="height:50px;width:200px;" src="'.$i['dst_url'].'" controls="controls"  name="media"></video>';
                $statusStr='<i class="icon-remove"></i>';
                if($i['status']=='1'){
                    $statusStr='<i class="icon-ok"></i>';
                }
                $aaData=array($id,
                    $audio,
                    Html::encode($i['content']),
                    Html::encode($i['split_word']),
                    Html::encode($i['exact_word']),
                    $statusStr,
                    empty($arcType[$i['type']]) ? '':$arcType[$i['type']],
                    $action);
                $output['aaData'][]=$aaData;
            }
        }
        echo json_encode($output);
        exit;
    }

    /**
     * Displays a single SpeechArc model.
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
     * Creates a new SpeechArc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SpeechArc();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SpeechArc model.
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
     * Deletes an existing SpeechArc model.
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
     * Finds the SpeechArc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SpeechArc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SpeechArc::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionSplitWord($id)
    {
        SpeechInfo::splitWord($id);
        
        return $this->redirect(['view', 'id' =>$id]);
    }
}
