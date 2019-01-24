<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\product\Productskin */

$this->title = '创建产品适用肤质';
$this->params['breadcrumbs'][] = ['label' => '产品适用肤质', 'url' => ['skin-index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-skin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_skin_form', [
        'model' => $model,
    ]) ?>

</div>
