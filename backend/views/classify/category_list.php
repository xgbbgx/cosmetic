<?php

use yii\helpers\Html;
use fedemotta\datatables\DataTables;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brands';
$this->params['breadcrumbs'][] = $this->title;
function procHtml($tree){
	$html = '';
	foreach($tree as $t)
	{
	  if($t['parent_id'] == ''){
	   $html .= "<li>{$t['name']}</li>";
	  }else{
	   $html .= "<li>".$t['name'];
	   $html .= procHtml($t['parent_id']);
	   $html = $html."</li>";
	  }
	}
	return $html ? '<ul class="test_ul">'.$html.'</ul>' : $html ;
}
?>
<style>
ul{
	list-style:none;
}
.test_ul li{
	float:left;
} 
</style>
<div class="brand-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Brand', ['category'], ['class' => 'btn btn-success']) ?>
    </p>
	<p>
	<?php echo procHtml($tree); ?>
	</p>
</div>