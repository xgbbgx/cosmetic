<?php 
    use backend\assets\ElfinderAsset;

    ElfinderAsset::register($this);
?>
<div class="row-fluid sortable">
	<div class="box span12">
		<div class="file-manager"></div>
	</div><!--/span-->

</div><!--/row-->
<script>
jQuery(document).ready(function() {    
var elf = $('.file-manager').elfinder({
	url : '/misc/elfinder-connector/connector.php'  // connector URL (REQUIRED)
}).elfinder('instance');
});
</script>