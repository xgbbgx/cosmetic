<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\product\Productskin */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '产品适用肤质', 'url' => ['skin-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-skin-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['skin-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['skin-delete', 'id' => $model->id], [
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
            'name_en',
            'name_py',
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
