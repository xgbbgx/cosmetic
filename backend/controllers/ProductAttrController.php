<?php

namespace backend\controllers;

use Yii;
use common\models\product\ProductCurrency;
use yii\data\ActiveDataProvider;
use common\core\backend\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\product\ProductUnit;
use common\models\product\ProductEffect;
use common\models\product\ProductSkin;

class ProductAttrController extends Controller
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
    public function actionCurrencyIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductCurrency::find()->andWhere(['datafix'=>ProductCurrency::DATAFIX]),
        ]);
        return $this->render('currency_index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCurrencyView($id)
    {
        return $this->render('currency_view', [
            'model' => $this->findCurrencyModel($id),
        ]);
    }

    public function actionCurrencyCreate()
    {
        $model = new ProductCurrency();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['currency-view', 'id' => $model->id]);
        }

        return $this->render('currency_create', [
            'model' => $model,
        ]);
    }
    public function actionCurrencyUpdate($id)
    {
        $model = $this->findCurrencyModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['currency-view', 'id' => $model->id]);
        }

        return $this->render('currency_update', [
            'model' => $model,
        ]);
    }
    public function actionCurrencyDelete($id)
    {
        $model=$this->findCurrencyModel($id);
        $model->datafix=$model::DATAFIX_DELETE;
        $model->save();
        return $this->redirect(['currency-index']);
    }
    protected function findCurrencyModel($id)
    {
        if (($model = ProductCurrency::findOne(['datafix'=>ProductCurrency::DATAFIX,'id'=>$id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionUnitIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductUnit::find()->andWhere(['datafix'=>ProductUnit::DATAFIX]),
        ]);
        return $this->render('unit_index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionUnitView($id)
    {
        return $this->render('unit_view', [
            'model' => $this->findUnitModel($id),
        ]);
    }
    
    public function actionUnitCreate()
    {
        $model = new ProductUnit();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['unit-view', 'id' => $model->id]);
        }
        
        return $this->render('unit_create', [
            'model' => $model,
        ]);
    }
    public function actionUnitUpdate($id)
    {
        $model = $this->findUnitModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['unit-view', 'id' => $model->id]);
        }
        
        return $this->render('unit_update', [
            'model' => $model,
        ]);
    }
    public function actionUnitDelete($id)
    {
        $model=$this->findUnitModel($id);
        $model->datafix=$model::DATAFIX_DELETE;
        $model->save();
        return $this->redirect(['unit-index']);
    }
    protected function findUnitModel($id)
    {
        if (($model = ProductUnit::findOne(['datafix'=>ProductUnit::DATAFIX,'id'=>$id])) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionEffectIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductEffect::find()->andWhere(['datafix'=>ProductEffect::DATAFIX]),
        ]);
        return $this->render('effect_index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionEffectView($id)
    {
        return $this->render('effect_view', [
            'model' => $this->findEffectModel($id),
        ]);
    }
    
    public function actionEffectCreate()
    {
        $model = new ProductEffect();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['effect-view', 'id' => $model->id]);
        }
        
        return $this->render('effect_create', [
            'model' => $model,
        ]);
    }
    public function actionEffectUpdate($id)
    {
        $model = $this->findEffectModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['effect-view', 'id' => $model->id]);
        }
        
        return $this->render('effect_update', [
            'model' => $model,
        ]);
    }
    public function actionEffectDelete($id)
    {
        $model=$this->findEffectModel($id);
        $model->datafix=$model::DATAFIX_DELETE;
        $model->save();
        return $this->redirect(['effect-index']);
    }
    protected function findEffectModel($id)
    {
        if (($model = ProductEffect::findOne(['datafix'=>ProductEffect::DATAFIX,'id'=>$id])) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionSkinIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductSkin::find()->andWhere(['datafix'=>ProductSkin::DATAFIX]),
        ]);
        return $this->render('skin_index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionSkinView($id)
    {
        return $this->render('skin_view', [
            'model' => $this->findSkinModel($id),
        ]);
    }
    
    public function actionSkinCreate()
    {
        $model = new ProductSkin();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skin-view', 'id' => $model->id]);
        }
        
        return $this->render('skin_create', [
            'model' => $model,
        ]);
    }
    public function actionSkinUpdate($id)
    {
        $model = $this->findSkinModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['skin-view', 'id' => $model->id]);
        }
        
        return $this->render('skin_update', [
            'model' => $model,
        ]);
    }
    public function actionSkinDelete($id)
    {
        $model=$this->findSkinModel($id);
        $model->datafix=$model::DATAFIX_DELETE;
        $model->save();
        return $this->redirect(['skin-index']);
    }
    protected function findSkinModel($id)
    {
        if (($model = ProductSkin::findOne(['datafix'=>ProductSkin::DATAFIX,'id'=>$id])) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
