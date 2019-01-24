<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\product\Productskin */

$this->title = '更新适用肤质: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '产品适用肤质', 'url' => ['skin-index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-skin-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_skin_form', [
        'model' => $model,
    ]) ?>

</div>
