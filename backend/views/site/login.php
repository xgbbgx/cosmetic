<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
	<?php $form = ActiveForm::begin(['id' => 'login-form','options'=>['class'=>'form-vertical login-form']]); ?>
		<div class="control-group">
		<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
		</div>
		<div class="control-group">
		<?= $form->field($model, 'password')->passwordInput() ?>
		</div>
		<div class="form-actions">
			<?= $form->field($model, 'rememberMe')->checkbox(['style'=>'margin-left:0px;']) ?>
			<?= Html::submitButton('登陆', ['class' => 'btn green pull-right', 'name' => 'login-button']) ?>
		</div>

	<?php ActiveForm::end(); ?>

</div>
