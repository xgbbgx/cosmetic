<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\tag\BaseTag */

$this->title = 'Create Base Tag';
$this->params['breadcrumbs'][] = ['label' => 'Base Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-tag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
