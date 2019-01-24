<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\product\ProductCurrency */

$this->title = '更新币种: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '产品币种', 'url' => ['skin-index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-currency-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_currency_form', [
        'model' => $model,
    ]) ?>

</div>
