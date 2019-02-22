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
								<label class="control-label">分类</label>
								<div class="controls">
									<input value='<?php echo $category['name'];?>' class='span6 m-wrap' readonly disabled/>
									<input value='<?php echo $category['id'];?>' id="category_id" type="hidden"/>
								</div>
							</div>
							
							<div class="control-group">
								<label class="control-label">品牌</label>
								<div class="controls">
									<input value='<?php echo $brand['name'];?>' class='span6 m-wrap' readonly disabled/>
									<input value='<?php echo $brand['id'];?>' id="brand_id" type="hidden"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">产品名称</label>
								<div class="controls">
									<input value='' class='span6 m-wrap'/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">产品名称（英文）</label>
								<div class="controls">
									<input value='' class='span6 m-wrap'/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">产品名称（拼音）</label>
								<div class="controls">
									<input value='' class='span6 m-wrap'/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">图片</label>
								<div class="controls">
									<input value='' class='span6 m-wrap'/>
								</div>
							</div>
							<div class="form-actions">
								<button type="button" class="btn blue" onclick='blurbSubmit(this)'>保存</button>
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
