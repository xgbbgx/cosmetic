<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\speech\SpeechArc */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Speech Arcs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speech-arc-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('重新分词', ['split-word', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'speech_flow_id',
            'dst_url',
            'type',
            'content',
            'split_word',
            'exact_word',
            [
                'attribute'=>'created_at',
                'label'=>'创建时间',
                'value'=>date('Y-m-d H:i:s',$model->created_at),
            ],
            'created_by',
            [
                'attribute'=>'created_at',
                'label'=>'创建时间',
                'value'=>date('Y-m-d H:i:s',$model->updated_at),
            ],
            'updated_by',
            'status',
            'datafix',
        ],
    ]) ?>

</div>
