<?php

use yii\helpers\Html;
use yii\grid\GridView;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Brand', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<a href="/test/delete?id=20" title="删除" aria-label="删除" data-pjax="0" data-confirm="您确定要删除此项吗？" 
data-method="post">
<span class="glyphicon glyphicon-trash"></span></a>
    <?= 
    /** DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'clientOptions'=>[
            "oLanguage"=> [
                "sUrl"=> "/js/jquery/cn.txt"
            ]
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            /**[
             // 看这里
             'attribute' => 'logo',
             'format' => 'html',
             'value' =>  function ($model, $key, $index, $column){
             return '<img style="width:80px;" src='. $model->logo .' />';
             }
             ],  
            'name',
            'name_en',
            'name_py',
            //'type',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            //'datafix',
            
            ['class' => 'backend\components\grid\BackendActionColumn',
                
            ],
        ],
        ]); */
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'name_en',
            'name_py',
            'logo',
            //'type',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            //'datafix',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
