<?php
namespace backend\components\grid;

use yii\grid\ActionColumn;

class BackendActionColumn extends ActionColumn{
    public $template='{view}&nbsp;&nbsp;&nbsp;&nbsp;{update}&nbsp;&nbsp;&nbsp;&nbsp;{delete}';
}