<?php 
    use backend\assets\UniformAsset;
    use backend\assets\UeditorAsset;

    UniformAsset::register($this);

?>
<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
	<div class="span12">
	<?php
		use yii\widgets\Breadcrumbs;
		echo Breadcrumbs::widget([
			'homeLink' => ['label' => '     '.Yii::t('common', 'blurb_index'), 'url' => ['blurb/index']],
			'itemTemplate' => "<li>{link}  <i class='icon-angle-right'></i></li>", //全局模板  运用到每个link
			'links' => [
				[
					'label' => Yii::t('common', 'blurb_list'),
					'url' => ['blurb/list'],//如果需要传参这种格式
				],
				Yii::t('common', 'blurb_view'),
				[
					'label' => Yii::t('common', 'blurb_view_add'),
					'url' => ['blurb/view'],//如果需要传参这种格式
					'template' => "<li style='margin-left:100px;' class='btn btn-success'><i class='icon-plus'></i>{link}</li>" //只会引用到该类模板
				],
			]
		]);
    ?>
		<!-- BEGIN SAMPLE FORM PORTLET-->   
		<div class="portlet box blue tabbable">
			<div class="portlet-body form">
				<div class="tabbable">
					<div class="tab-content">
						<!-- BEGIN FORM-->
						<form action="" class="form-horizontal"  method='POST' id='blurb_submit'>
							<div class="control-group">
								<label class="control-label">品牌</label>
								<div class="controls">
    								<div class="span3">
        								<select  data-placeholder="一级分类" class="span12 m-wrap" multiple="multiple" tabindex="-1" id="category0" size=10>
        									<?php 
        									  foreach ($category0 as $c){
        									      echo '<option value="'.$c['id'].'">'.$c['name'].'</option>';
        									 }
        									?>
        								</select>
    								</div>
    								<div class="span3" id="category1">
    								</div>
    								<div class="span3" id="category2">
    								</div>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">品牌</label>
								<div class="controls">
									<input id="product_brand" value='' style='width:250px' class="m-wrap select2_category" data-placeholder="品牌" tabindex="1">
								</div>
							</div>
							<input type="hidden" id='category_sel_id'>
							<div class="form-actions">
								<button type="button" class="btn blue" onclick='select_product()'>发布产品</button>
								<button type="button" class="btn">取消</button>
							</div>
						</form>
					<!-- END FORM-->  
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$("#category0").change(function(){
		category($(this).val(),1);
		$('#category_sel_id').val($(this).val());
	});
	function category(pid,d){
		$.get('/product/get-select','pid='+pid+'&d='+d,function(data){
			$("#category"+d).html(data);
		});
	}
	jQuery(document).ready(function() {
		   load_select2($("#product_brand"),'/classify/brand-search-name','/classify/brand-search-id');
	})
	function select_product(){
		location.href='/product/view?cid='+$('#category_sel_id').val()+'&bid='+$("#product_brand").val();
	}
</script>