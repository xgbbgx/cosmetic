<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\UniformAsset;
UniformAsset::register($this);

if($model->name){
	$this->title = '分类属性值: ' . $model->name;
	$this->params['breadcrumbs'][] = ['label' => '分类属性值', 'url' => ['/classify/classify-attr-val-list']];
	$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['/classify/classify-attr-val-view', 'id' => $model->id]];
	$this->params['breadcrumbs'][] = 'Update';
}else{
	$this->title = '分类属性';
	$this->params['breadcrumbs'][] = ['label' => '分类属性值', 'url' => ['/classify/classify-attr-val-list']];
	$this->params['breadcrumbs'][] = $this->title;
}
?>
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption"><i class="icon-reorder"></i><?= Html::encode($this->title) ?></div>
	</div>
	<div class="portlet-body form">
		<h3 class="block"><?= Html::encode($this->title) ?></h3>
        <div class="brand-form">
            <?php $form = ActiveForm::begin([
                 'fieldConfig' => [
                    'template' => '<div class="control-group">
                					   {label}
                					   <div class="controls">
                					       {input}
                                            <span class="help-inline">{error}</span>
                                        </div>
                					</div>',
                    'inputOptions' => ['class' => 'm-wrap medium'],
                ],
                'options' => ['class' => 'form-horizontal','id'=>'form1','enctype'=>"multipart/form-data"],
                ]);
            ?>
        	<?= $form->field($model, 'classify_attr_id')->textInput(['maxlength' => true,'class'=>'select2_category','style'=>'width:230px;']) ?>
        	
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
        
            <?= $form->field($model, 'name_py')->textInput(['maxlength' => true]) ?>
        	
            <div class="form-actions">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        
            <?php ActiveForm::end(); ?>
        
        </div>
	</div>
</div>
<script>
	jQuery(document).ready(function() {
	   load_select2($("#classifyattrval-classify_attr_id"),'/classify/classify-attr-search-name','/classify/classify-attr-search-id');
	})
</script>