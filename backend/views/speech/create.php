<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\speech\SpeechArc */

$this->title = 'Create Speech Arc';
$this->params['breadcrumbs'][] = ['label' => 'Speech Arcs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="speech-arc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
