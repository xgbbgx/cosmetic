<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\ProductCurrency */

$this->title = '创建产品币种';
$this->params['breadcrumbs'][] = ['label' => '产品币种', 'url' => ['currency-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-currency-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_currency_form', [
        'model' => $model,
    ]) ?>

</div>
