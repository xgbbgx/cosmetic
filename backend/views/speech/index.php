<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Speech Arcs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speech-arc-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Speech Arc', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'speech_flow_id',
            [
                // 看这里
                'attribute' => 'dst_url',
                'format' => 'html',
                'value' =>  function ($model, $key, $index, $column){
                    //return Html::video( , ['width' => '60px']);
                    return '<a target="_blank" href="'.$model->dst_url.'"  >音频</a>' ;
                }
            ],
            'type',
            'content',
            'split_word',
            'exact_word',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            'status',
            //'datafix',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
