<?php 
namespace backend\controllers\classify;

use Yii;
use common\core\backend\Action;
use common\models\classify\Classify;
use yii\data\ActiveDataProvider;

class ClassifyAction extends Action{
    public function actionClassifyView(){
        $request=Yii::$app->request;
        $id=$request->get('id');
        if($id){
            $model=Classify::findOne($id);
        }
        if(empty($model)){
            $model = new Classify();
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['classify-view', 'id' => $model->id]);
        }
        return $this->render('classify', [
            'model' => $model,
        ]);
    }
    public function actionClassifyList()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Classify::find()->where(['datafix'=>Classify::DATAFIX]),
        ]);
        return $this->render('classify_list', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionClassifyDelete($id)
    {
        $model=Classify::findOne($id);
        $model->datafix=$model::DATAFIX_DELETE;
        $model->save();
        return $this->redirect(['classify-list']);
    }
}