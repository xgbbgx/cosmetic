<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\tag\BaseTag */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="base-tag-form">

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
        ]);?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'noun')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList(Yii::$app->params['tag_conf']['base_tag_type'],
	['prompt'=>'请选择'])?>

    <div class="form-actions">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
