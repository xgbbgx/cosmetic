<?php 
    use backend\assets\UniformAsset;

    UniformAsset::register($this);
?>
<div class="row-fluid sortable">		
	<div class="box span12">
		<?php
            use yii\widgets\Breadcrumbs;
            echo Breadcrumbs::widget([
                'homeLink' => ['label' => '     '.Yii::t('common', 'book_index'), 'url' => ['book/index']],
                'itemTemplate' => "<li>{link}  <i class='icon-angle-right'></i></li>", //全局模板  运用到每个link
                'links' => [
                    Yii::t('common', 'book_list'),
                    //'编辑',//没有链接的
                    [
                        'label' => '添加产品',
                        'url' => ['/product/select'],//如果需要传参这种格式
                        'template' => "<li style='margin-left:100px;' class='btn btn-success'><i class='icon-plus'></i>{link}</li>" //只会引用到该类模板
                    ],
                ]
            ]);
    ?>
		<div class="box-content">
			<!-- BEGIN GALLERY MANAGER PANEL-->
			<div class="row-fluid">
				<div class="span10">
					<div class="pull-left">
						<input id="product_brand" value='' style='width:250px' class="m-wrap select2_category" data-placeholder="品牌" tabindex="1">
						
						<input id="product_category" value='' style='width:250px' class="m-wrap select2_category" data-placeholder="分类" tabindex="1">		
					</div>
				</div>
				<div class="span2">
					<a id="book_search" href="javascript:void(0);" class="btn pull-right green"><i class="icon-search"></i> search</a>
				</div>
			</div>
			<!-- END GALLERY MANAGER PANEL-->
			<hr class="clearfix" />
			<table class="table table-striped table-bordered bootstrap-datatable datatable" id="i_article_table">
			  <thead>
				  <tr>
					  <th>#</th>
					  <th>产品图片</th>
					  <th>产品名称</th>
					  <th>产品属性</th>
					  <th width="150px"><?= Yii::t('common','option'); ?></th>
					  <th width="120px">Actions</th>
				  </tr>
			  </thead>   
			  <tbody>
				<?php
					for($i=0;$i<10;$i++){
						echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td></td><td></td><td></td><td></td></tr>';
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
		"aaSorting": [[ 0, "desc" ]],
		"sAjaxSource": "/product/get-product-list",
		"oLanguage": {
			"sUrl": "/js/jquery/cn.txt"
		},
		"fnInfoCallback":function(nRow,aData,iDataIndex){
			$('.popovers').popover({"trigger":"hover","placement":"bottom"});
		},"aoColumns": [
			{ "sName": "id" },
			{ "sName": "name"},
			{ "sName": "name_cn"},
            { "sName": "name_tw"},
			{ "sName": "option" ,"bSearchable": false, "bSortable": false},
            { "sName": "actions","bSearchable": false, "bSortable": false}
        ],//$_GET['sColumns']将接收到aoColumns传递数据 
        "fnServerParams": function ( aoData ) {//向服务器传额外的参数
            var brand_id=$('#product_brand').val(),
                category_id=$('#product_category').val();
				aoData.push( { "name": "_csrf-backend", "value": $('meta[name="csrf-token"]').attr('content') },
					     { "name": "brand_id", "value": brand_id },
					     { "name": "category_id", "value": category_id }
				);
		}
	});
	$('#book_search').click(function(){
		$('#i_article_table').dataTable().fnPageChange( 'previous', true );
	});

jQuery(document).ready(function() {
   load_select2($("#product_brand"),'/classify/brand-search-name','/classify/brand-search-id');
   load_select2($("#product_category"),'/classify/category-search-name','/classify/category-search-id');
})
</script>
