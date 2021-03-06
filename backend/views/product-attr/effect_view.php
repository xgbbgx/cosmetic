<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\product\Producteffect */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '产品功效', 'url' => ['effect-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-effect-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['effect-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['effect-delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('创建产品功效', ['effect-create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'name_en',
            'name_py',
            'type',
            'info',
            'info_en',
            'created_by',
            [
                'attribute' => 'created_at',
                'value' =>  date('Y-m-d H:i:s',$model->created_at)
            ],
            'updated_by',
            [
                'attribute' => 'updated_at',
                'value' =>  date('Y-m-d H:i:s',$model->updated_at)
            ],
            [
                'attribute' => 'datafix',
                'value' => $model->datafix==0 ?'正常':'删除'
            ],
        ],
    ]) ?>

</div>
