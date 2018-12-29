<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\tag\BaseTag */

$this->title = '创建分词';
$this->params['breadcrumbs'][] = ['label' => '分词', 'url' => ['participle-list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-tag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_participle_form', [
        'model' => $model,
    ]) ?>

</div>
