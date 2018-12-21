<?php

use yii\helpers\Html;
use fedemotta\datatables\DataTables;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品分类';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row-fluid sortable">		
	<div class="box span12">
		<p>
        <?= Html::a('创建商品分类', ['category'], ['class' => 'btn btn-success']) ?>
    </p>
		<div class="box-content">
			<table class="table table-striped table-bordered bootstrap-datatable datatable" id="i_article_table">
			  <thead>
				  <tr>
					  <th>#</th>
					  <th>大分类</th>
					  <th>第二分类</th>
					  <th>第三分类</th>
				  </tr>
			  </thead>   
			  <tbody>
				<?php
					for($i=0;$i<10;$i++){
						echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td></tr>';
					}
				?>
			  </tbody>
			 </table>
			 <div class="sabrosus" id="i_a_page">
			 </div>
		</div>
	</div>
</div>
<script>
	$('#i_article_table').dataTable( {
		"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
		"sPaginationType": "bootstrap",
		"bStateSave": false, 
		"bAutoWidth":false,
		"bProcessing": true,
		"bServerSide": true,
		"aaSorting": [[ 1, "asc" ]],
		"sAjaxSource": "/classify/get-category-list",
		"oLanguage": {
			"sUrl": "/js/jquery/cn.txt"
		},
		"fnInfoCallback":function(nRow,aData,iDataIndex){
			$('.popovers').popover({"trigger":"hover","placement":"bottom"});
		},"aoColumns": [
			{ "sName": "id" ,"bSearchable": false, "bSortable": false},
			{ "sName": "name"},
			{ "sName": "name_cn"},
            { "sName": "name_tw"}
        ],//$_GET['sColumns']将接收到aoColumns传递数据 
        "fnServerParams": function ( aoData ) {//向服务器传额外的参数
			aoData.push( { "name": "_csrf-backend", "value": $('meta[name="csrf-token"]').attr('content') });
		}
	});
	function delCity(id,name,e){
			$(e).removeAttr('onclick');
			if(id){
				wdialog.confirmBox({html:"确定删除<span style='color:red'>“"+name+"”</span>吗？",autoHide:null,dialogWidth:'338px',callBack:function(){
					$.ajax({
						"type":"POST",
						"url":"/store/city-del",
						"data":{
							'id':id,
							'_csrf-backend':$('meta[name="csrf-token"]').attr('content'),
						},
						"success":function(data){
							$(e).attr("onclick",'delcity('+id+','+name+',this)');
							if(!data){
								wdialog.msgBox({msgType: 'warning', html:'<?php echo Yii::t('error', 'data_exception');?>',dialogWidth:'350px'});    
								 return;
							}
							data =eval("("+data+")");
							if(data.code=='00001'){
								wdialog.msgBox({msgType: 'success', html:data.msg,dialogWidth:'350px'});  
								$('#i_article_table').dataTable().fnPageChange( 'previous', true );
							}else{
								wdialog.msgBox({msgType: 'error', html:data.msg,dialogWidth:'350px'}); 
								return;   
							}
						}
					});
				}});
			}else{
				wdialog.msgBox({msgType: 'warning', html:'<?php echo Yii::t('error', '20204');?>',dialogWidth:'350px'});    
			}
			$(e).attr("onclick",'delcity('+id+',"'+name+'",this)');
		}

</script>
