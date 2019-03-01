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
                'homeLink' => ['label' => '    首页', 'url' => ['/product/index']],
                'itemTemplate' => "<li>{link}  <i class='icon-angle-right'></i></li>", //全局模板  运用到每个link
                'links' => [
                    [
                        'label' => '产品列表',
                        'url' => ['/product/product-list'],//如果需要传参这种格式
                    ],
                    '产品',
                    [
                        'label' => '添加产品',
                        'url' => ['/product/view'],//如果需要传参这种格式
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
									<input value='<?php echo empty($product['name'])?'':$product['name'];?>' class='span6 m-wrap' id='name'/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">产品名称（英文）</label>
								<div class="controls">
									<input value='<?php echo empty($product['name_en'])?'':$product['name_en'];?>' class='span6 m-wrap' id='name_en'/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">产品名称（拼音）</label>
								<div class="controls">
									<input value='<?php echo empty($product['name_py'])?'':$product['name_py'];?>' class='span6 m-wrap' id="name_py"/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">图片</label>
								<div class="controls">
									<input value='<?php echo empty($product['image'])?'':$product['image'];?>' class='span6 m-wrap' id='image'/>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">功效</label>
								<div class="controls">
									<select data-placeholder="功效" class="chosen span6" multiple="multiple" tabindex="6" id='effect_ids'>
										<optgroup label="功效">
										<?php 
										if(isset($productEffect) && $productEffect){
											$effectIds=[];
											if(isset($product['effect_ids']) && $product['effect_ids']){
											    $effectIds=explode(',',$product['effect_ids']);
											}
											foreach ($productEffect as $effect){
										?>
											<option value='<?php echo $effect['id']; ?>' <?php if($effectIds && in_array($effect['id'],$effectIds)) echo 'selected';?>><?php echo $effect['name']; ?></option>
										<?php } } ?>
										</optgroup>
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">皮肤</label>
								<div class="controls">
									<select data-placeholder="皮肤" class="chosen span6" multiple="multiple" tabindex="2" id='skin_ids'>
										<optgroup label="皮肤">
										<?php 
										if(isset($productSkin) && $productSkin){
										    $skinIds=[];
										    if(isset($product['skin_ids']) && $product['skin_ids']){
										        $skinIds=explode(',',$product['skin_ids']);
										    }
											foreach ($productSkin as $skin){
										?>
											<option value='<?php echo $skin['id']; ?>' <?php if($skinIds && in_array($skin['id'],$skinIds)) echo 'selected';?>><?php echo $skin['name']; ?></option>
										<?php } } ?>
										</optgroup>
									</select>
								</div>
							</div>
							<div class="control-group" style="margin-bottom:80px;">
								<label class="control-label"></label>
								<div class="controls">
								</div>
							</div>
							<div class="form-actions">
								<button type="button" class="btn blue" onclick='productSubmit(this)'>保存</button>
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
<script type="text/javascript">
	function productSubmit(e){
		var brand_id=$("#brand_id").val(),
			category_id=$("#category_id").val(),
			name=$("#name").val(),
			name_en=$('#name_en').val(),
			name_py=$('#name_py').val(),
			image=$('#image').val(),
			effect_ids=$('#effect_ids').val(),
			skin_ids=$('#skin_ids').val();
			var id='<?php echo empty($product['id'])?'':$product['id'];?>';
			$.ajax({
				'type':'POST',
				'url':'/product/edit',
				'data':{
					'brand_id':brand_id,
					'category_id':category_id,
					'name':name,
					'name_en':name_en,
					'name_py':name_py,
					'iamge':image,
					'effect_ids':effect_ids,
					'skin_ids':skin_ids,
					'id':id
				},
				'success':function(data){
					$(e).attr("onclick",'productSubmit(this)');
					if(!data){
						wdialog.msgBox({msgType: 'warning', html:'<?php echo Yii::t('error', 'data_exception');?>',dialogWidth:'350px'});    
						 return;
					}
					data =eval("("+data+")");
					if(data.code=='00001'){
						wdialog.msgBox({msgType: 'success', html:data.msg,dialogWidth:'350px'});    
						if(id){
						}else{
							location.href='/product/view?cid=<?php echo $cid;?>&bid=<?php echo $bid;?>&id='+data.id;
						}
					}else{
						if(data.pos){
							form_msg("#"+data.pos,data.msg,'error');
				    		return false;
						}else{
							wdialog.msgBox({msgType: 'error', html:data.msg,dialogWidth:'350px'}); 
						}   
						return;
					}
				}
			});
	}
</script>
