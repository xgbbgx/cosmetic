<select data-placeholder="二级分类" class="span12 m-wrap" multiple="multiple" tabindex="-1" size=10>
	<?php 
	   foreach ($category as $c){
	      echo '<option value="'.$c['id'].'">'.$c['name'].'</option>';
	   }
	?>
</select>
<script>
$("#category<?php echo $d;?>").find('select').on('change',function(){
	var d='<?php echo $d?>';
	var d_1=parseInt(d)+1;
	if(d_1<3){
		category($(this).val(),parseInt(d)+1);
	}
	$('#category_sel_id').val($(this).val());
});
</script>