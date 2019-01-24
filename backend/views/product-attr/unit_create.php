<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\Productunit */

$this->title = '创建产品单位';
$this->params['breadcrumbs'][] = ['label' => '产品单位', 'url' => ['unit-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_unit_form', [
        'model' => $model,
    ]) ?>

</div>
