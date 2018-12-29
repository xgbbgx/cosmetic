<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\tag\BaseTag */

$this->title = '更新分词: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '分词', 'url' => ['participle-list']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['participle-view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="base-tag-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_participle_form', [
        'model' => $model,
    ]) ?>

</div>
