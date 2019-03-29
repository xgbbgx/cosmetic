<?php 
    use backend\assets\UniformAsset;

    UniformAsset::register($this);

?>
<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid">
	<div class="span12">
	<?php
            use yii\widgets\Breadcrumbs;
            echo Breadcrumbs::widget([
                'homeLink' => ['label' => '    首页', 'url' => ['/product/index']],
                'itemTemplate' => "<li>{link}  <i class='icon-angle-right'></i></li>", //全局模板  运用到每个link
                'links' => [
                    [
                        'label' => '列表',
                        'url' => ['/product/product-list'],//如果需要传参这种格式
                    ],
                    '测试'
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
								<label class="control-label">测试</label>
								<div class="controls">
									<textarea class='span6 m-wrap' name='content'></textarea>
								</div>
							</div>
							<div class="control-group" style="margin-bottom:80px;">
								<label class="control-label"></label>
								<div class="controls">
									<?php 
									   if(isset($content) && $content){
									      echo '原句：'.$content.'<br>';
									      echo '分词：'.(empty($splitWord) ?'':implode(' | ', $splitWord)).'<br>';
									      echo '去燥：'.(empty($exactWord) ?'':implode(' | ', $exactWord)).'<br>';
									   }
									?>
								</div>
							</div>
							<div class="form-actions">
								<button type="submit" class="btn blue">保存</button>
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
