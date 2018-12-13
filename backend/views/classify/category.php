<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\category\Category */

if($model->name){
	$this->title = 'Update Category: ' . $model->name;
	$this->params['breadcrumbs'][] = ['label' => 'Categorys', 'url' => ['index']];
	$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
	$this->params['breadcrumbs'][] = 'Update';
}else{
	$this->title = 'Create Category';
	$this->params['breadcrumbs'][] = ['label' => 'Categorys', 'url' => ['index']];
	$this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="Category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_category_form', [
        'model' => $model,
    ]) ?>

</div>