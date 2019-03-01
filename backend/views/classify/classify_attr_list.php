<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分类属性';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-currency-index">
    <p>
        <?= Html::a('分类属性', ['classify-attr-view'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'name_en',
            'name_py',
            'classify_id',
            ['attribute' => 'is_sale', 
                'value' => function($model) {
                    return $model->is_sale == 1 ? "是" : "否";
                }
            ],
            ['attribute' => 'edit_type',
              'format' => 'html',
              'value' =>  function ($model, $key, $index, $column){
                    $editConf=Yii::$app->params['classify_conf']['edit_type'];
                return  empty($editConf[$model->edit_type]) ?'':$editConf[$model->edit_type];
             }],  
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{classify-attr-view}{classify-attr-delete}',
                'buttons' => [
                    // 下面代码来自于 yii\grid\ActionColumn 简单修改了下
                    'classify-attr-view' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'classify-attr-delete' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'Delete'),
                            'aria-label' => Yii::t('yii', 'Delete'),
                            'data-confirm' => Yii::t('yii', '确定删除吗?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                            'style'=>"margin-left:20px;"
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                ]
            ],
        ],
    ]); ?>
</div>