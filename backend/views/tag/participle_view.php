<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\tag\BaseTag */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '基础分词', 'url' => ['participle-list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-tag-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['participle-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['participle-delete', 'id' => $model->id], [
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
            'name',
            'weight',
            'noun',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'datafix',
            'type',
        ],
    ]) ?>

</div>
