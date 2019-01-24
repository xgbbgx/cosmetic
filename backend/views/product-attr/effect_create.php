<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\Producteffect */

$this->title = '创建产品功效';
$this->params['breadcrumbs'][] = ['label' => '产品功效', 'url' => ['effect-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-effect-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_effect_form', [
        'model' => $model,
    ]) ?>

</div>
