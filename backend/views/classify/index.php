<?php

use yii\helpers\Html;
use fedemotta\datatables\DataTables;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Brand', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= DataTables::widget([
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
            ],  */
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
    ]); ?>
</div>
