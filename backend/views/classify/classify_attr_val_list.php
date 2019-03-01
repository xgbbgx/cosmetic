<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分类属性值';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-currency-index">
    <p>
        <?= Html::a('分类属性值', ['classify-attr-val-view'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'name_en',
            'name_py',
            'classify_attr_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'template' => '{classify-attr-val-view}  {classify-attr-val-delete}',
                'buttons' => [
                    // 下面代码来自于 yii\grid\ActionColumn 简单修改了下
                    'classify-attr-val-view' => function ($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                    },
                    'classify-attr-val-delete' => function ($url, $model, $key) {
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