<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\product\Producteffect */

$this->title = '更新功效: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '产品功效', 'url' => ['skin-index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-effect-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_effect_form', [
        'model' => $model,
    ]) ?>

</div>
