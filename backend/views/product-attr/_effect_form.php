<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\product\Producteffect */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-effect-form">

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
        ]); ?>
	<?= $form->field($model, 'type')->dropDownList(Yii::$app->params['product_conf']['effect_type'],
	['prompt'=>'请选择'])?>
	
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_py')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'info')->textarea(['maxlength' => true,'rows'=>5]) ?>
	
	<?= $form->field($model, 'info_en')->textarea(['maxlength' => true,'rows'=>5]) ?>
	
    <div class="form-actions">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
