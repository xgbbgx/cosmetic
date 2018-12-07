<?php

use yii\helpers\Html;
use fedemotta\datatables\DataTables;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Brand', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
   <table class="table table-striped table-bordered" id="jq_datatable_list">
       <thead>
        <tr>
        	<th>#</th>
        	<th>Logo</th>
        	<th>Name</th>
        	<th>Name En</th>
        	<th>Name Py</th>
        	<th>Type</th>
        	<th class="action-column">&nbsp;</th>
        </thead>
        <tbody>
        	<?php
				for($i=0;$i<10;$i++){
					echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td></td>
                <td></td><td></td><td></td><td></td></tr>';
				}
			?>
        </tbody>
   </table>
</div>
<script type="text/javascript">
$('#jq_datatable_list').dataTable( {
	"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
	"sPaginationType": "bootstrap",
	"bStateSave": false, 
	"bAutoWidth":false,
	"bProcessing": true,
	"bServerSide": true,
	"aaSorting": [[ 2, "asc" ]],
	"sAjaxSource": "/classify/list",
	"oLanguage": {
		"sUrl": "/js/jquery/cn.txt"
	},
	"fnInfoCallback":function(nRow,aData,iDataIndex){
		$('.popovers').popover({"trigger":"hover","placement":"bottom"});
	},"aoColumns": [
		{ "sName": "id" },
        { "sName": "img","bSearchable": false, "bSortable": false},
		{ "sName": "name",},
		{ "sName": "name_cn"},
		{ "sName": "info" ,"bSortable": false},
		{ "sName": "book_num" ,"bSearchable": false},
        { "sName": "actions","bSearchable": false, "bSortable": false}
    ],//$_GET['sColumns']将接收到aoColumns传递数据 
    "fnServerParams": function ( aoData ) {//向服务器传额外的参数
		aoData.push( { "name": "_csrf-backend", "value": $('meta[name="csrf-token"]').attr('content') });
	}
});
</script>
