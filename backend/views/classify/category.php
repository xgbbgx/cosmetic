<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\category\Category */

if($model->name){
	$this->title = '分类: ' . $model->name;
	$this->params['breadcrumbs'][] = ['label' => '分类', 'url' => ['/classify/category-list']];
	$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['/classify/category-view', 'id' => $model->id]];
	$this->params['breadcrumbs'][] = 'Update';
}else{
	$this->title = '分类';
	$this->params['breadcrumbs'][] = ['label' => '分类', 'url' => ['/classify/category-list']];
	$this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption"><i class="icon-reorder"></i><?= Html::encode($this->title) ?></div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="#portlet-config" data-toggle="modal" class="config"></a>
			<a href="javascript:;" class="reload"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<h3 class="block"><?= Html::encode($this->title) ?></h3>
        <?= $this->render('_category_form', [
            'model' => $model,
        ]) ?>
	</div>
</div>