<?php
require dirname(__FILE__) . '/../../../../../wp-load.php';
get_header();
if ( isset($argv) ) {
	$images = $argv;
}
if ( count($_GET) > 0 ) {
	$images = $_GET;
}
?>
<form name="form" id="form" method="post" class="wpip-form" enctype="multipart/form-data">
	<?php 
	for ($i=1; $i < count($_GET) ; $i++) { 
		// $count = --$i;
		echo '<input name="upload_images_i' . $i . '" id="upload_images_i' . $i . '" type="file" ref="' . urldecode($images[$i]) . '"/>';
	}
	?>
	<input type="submit" value="submit"/>
</form>
<script type="text/javascript">
jQuery(document).ready(function(){
	// jQuery("#form").submit
	jQuery("input[type=file]").each(function(){
		if ( jQuery(this).attr("ref") ) {
			jQuery(this).attr("value", jQuery(this).attr("ref"));
		}
	});
	jQuery("input").live("change", function(){
		alert ( jQuery(this).attr("value"));
	});
	jQuery("input[type=file]").each(function(){
		alert ( jQuery(this).attr("value"));
	});
});
</script>
