<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\category\Brand */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
 'fieldConfig' => [
    'template' => '<div class="control-group">
					   {label}
					   <div class="controls">
					       {input}
                            <span class="help-inline">{error}</span>
                        </div>
					</div>',
    'inputOptions' => ['class' => 'm-wrap medium'],
],
'options' => ['class' => 'form-horizontal','id'=>'form1','enctype'=>"multipart/form-data"],
]); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'name_py')->textInput(['maxlength' => true]) ?>

<div class="control-group">
   <label class="control-label" for="category-name_en">大分类</label>
   <div class="controls">
       <select id="category-c1" class="m-wrap medium" onchange="">
            <option value="">--请选择大分类--</option>
            <?php 
                $id=$model->id;
                $parentId=$model->parent_id;
                $isSelected=false;
                $c1=$model->getCategoryList(0);
               foreach($c1 as $k1=>$v1){
                   $selected='';
                   if($parentId && $parentId==$k1){
                       $selected='selected';
                       $isSelected=true;
                   }
                   if($id==$k1){}else{
             ?>
             <option value="<?php echo $k1;?>" <?php  echo $selected;?>><?php echo $v1;?></option>
             <?php }    
               }
            ?>
            </select>
        <span class="help-inline">
        	<select id="category-c2" class="m-wrap medium" onchange="">
            <option value="">--请选择分类--</option>
            <?php 
            if($parentId && !$isSelected){
                $parent=$model::findOne(['id'=>$parentId]);
                $c2=$model->getCategoryList($parent->parent_id);
                foreach($c2 as $k2=>$v2){
                    $selected='';
                    if($parentId && $parentId==$k2){
                        $selected='selected';
                        $isSelected=true;
                    }
                    ?>
             <option value="<?php echo $k2;?>" <?php  echo $selected;?>><?php echo $v2;?></option>
             <?php    
               }
               if($parentId && $isSelected){
             ?>
             <script>
				$("#category-c1").val(<?php echo $parent->parent_id ?>);
             </script>
            <?php } }
            ?>
            </select>
        </span>
    </div>
</div>

<?php /**$form->field($model,'parent_id')->dropDownList($model->getCategoryList(0),
    [
        'prompt'=>'--请选择省--',
        'onchange'=>'
            $(".form-group.field-member-area").hide();
            $.post("'.yii::$app->urlManager->createUrl('/classify/site').'?typeid=1&pid="+$(this).val(),function(data){
                $("select#category-level2").html(data);
            });',
    ]) */?>

<?php /** $form->field($model, 'level')->dropDownList($model->getCategoryList($model->id),
    [
        'prompt'=>'--请选择市--',
        'id'=>'category-level2'
    ]) */ ?>

<?= $form->field($model, 'type')->dropDownList([],
	['prompt'=>'请选择']) ?>
<?= $form->field($model, 'weight')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'parent_id',['template' => "{input}"])->hiddenInput(['maxlength' => true,'value'=>$model->parent_id])->label(false) ?>
<?= $form->field($model, 'level',['template' => "{input}"])->hiddenInput(['maxlength' => true,'value'=>$model->level])->label(false) ?>

<div class="form-actions">
	<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
<script>
	$("#category-c1").change(function(){
		var pid=$(this).val();
		$.post("/classify/site?id=<?php echo $model->id;?>&pid="+pid,function(data){
            $("select#category-c2").html(data);
        });
        $("#category-parent_id").val(pid);
        if(pid)
        $("#category-level").val(2);
	});
	$("#category-c2").change(function(){
		var pid=$(this).val();
        $("#category-parent_id").val(pid);
        if(pid)
        $("#category-level").val(3);
	});
</script>
