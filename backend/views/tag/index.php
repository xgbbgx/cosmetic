<?php

use yii\helpers\Html;

$this->title = '词典';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">
    <div class="row-fluid">
    	<div class="span2">
    		 <?= Html::a('创建词典', ['create'], ['class' => 'btn btn-success']) ?>
    	</div>
    	<div class="span2">
    		 <a href="javascript:void(0);" class='btn green' id="export-dic">导入新标签</a>
    	</div>
        <div class="span4">
    		<div class="pull-right">
    			<select style="width:160px;"
    			class="chosen  m-wrap" tabindex="-1" id="type">
    				<option value="" style="display: none;">分类</option>
    				<option value="0">All</option>
    				<?php 
    				    $tagType=Yii::$app->params['tag_conf']['base_tag_type'];
    				    if(is_array($tagType)){
    				        foreach ($tagType as $k=>$v){
    				            echo '<option value="'.$k.'" '.($k=='101'?'selected':'').'>'.$v.'</option>';
    				        }
    				    }
    				?>
    			</select>		
    		</div>
    	</div>
    	<div class="span2">
    		<a id="search" href="javascript:void(0);" class="btn pull-right green"><i class="icon-search"></i> search</a>
    	</div>
    	<div class="span2">
    	</div>
	</div>
	<hr class="clearfix" />
   <table class="table table-striped table-bordered" id="jq_datatable_list">
       <thead>
        <tr>
        	<th>ID</th>
        	<th>词语</th>
        	<th>权重</th>
        	<th>词性</th>
        	<th>类型</th>
        	<th class="action-column">&nbsp;</th>
        </thead>
        <tbody>
        	<?php
				for($i=0;$i<10;$i++){
					echo '<tr><td>&nbsp;</td><td>&nbsp;</td>
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
	"aaSorting": [[ 1, "asc" ]],
	"sAjaxSource": "/tag/list",
	"oLanguage": {
		"sUrl": "/js/jquery/cn.txt"
	},
	"fnInfoCallback":function(nRow,aData,iDataIndex){
		$('.popovers').popover({"trigger":"hover","placement":"bottom"});
	},"aoColumns": [
		{ "sName": "id" },
		{ "sName": "name",},
		{ "sName": "name_cn"},
		{ "sName": "info" ,"bSortable": false},
		{ "sName": "book_num" ,"bSearchable": false},
        { "sName": "actions","bSearchable": false, "bSortable": false}
    ],//$_GET['sColumns']将接收到aoColumns传递数据 
    "fnServerParams": function ( aoData ) {//向服务器传额外的参数
		aoData.push( 
			{ "name": "_csrf-backend", "value": $('meta[name="csrf-token"]').attr('content') },
			{ "name": "type", "value": $('#type').val() }
		);
	}
});
$('#search').click(function(){
	$('#jq_datatable_list').dataTable().fnPageChange( 'previous', true );
});
$("#export-dic").click(function(){
	if(confirm('确定生成吗')){
		var that=this;
		$(that).html('正在导入...');
    	$.get('/tag/export-dic',function(data){
    		$(that).html('导入新标签');
    		data=eval('('+data+')');
    		if(data.code=='00001'){
    			wdialog.msgBox({msgType: 'success', html:data.msg,dialogWidth:'350px'}); 
    			return;   
    		}else{
    			wdialog.msgBox({msgType: 'error', html:data.msg,dialogWidth:'350px'}); 
    			return;   
    		}
    	});
	}
});
</script>
