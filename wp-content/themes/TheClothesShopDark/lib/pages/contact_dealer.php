<?php
	require_once dirname(__FILE__) . '/../../../../../wp-load.php';
?>
<style type="text/css">
	#cboxContent {
		background: none;
	}
	#cboxLoadedContent {
		padding: 10px;
	}
</style>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".contact_dealer").live("click", function(){
		jQuery.colorbox({
			opacity : '1.0', 
			href: jQuery(this).attr("ref"),
			width: '700px', 
			height: '500px', 
			title: jQuery(this).attr("title"),
			 onComplete: function() {
			 	jQuery(this).colorbox.resize();
			 }, 
			 preloading: true
		});
	});
});
</script>
<?php if($post->post_status == "publish" ) { ?>
	<span class="clearfix align-right">	
		<span class="alignleft sizing_info">
			<input type="button" class="contact_dealer download_btn download_btn_display" value="Contact Dealer" ref="<?php echo get_stylesheet_directory_uri() . '/lib/pages/contact_dealer_form.php?p=' . $post->ID;?>"/>					
		</span>
	</span>
<?php }?>
