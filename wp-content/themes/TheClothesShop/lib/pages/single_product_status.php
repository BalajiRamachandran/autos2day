<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery(".review_status").click(function(){
			if ( jQuery(this).attr("class").toLowerCase().indexOf("publish") != -1 ) {
				//publish the post and refresh
				var url = '<?php echo get_permalink();?>';
			} else {
			}
		});
	});
</script>

<?php
	if ( $post->post_status == "pending") {
		?>
<!-- 		<div class="deal_status">
		<a href="#" class="review_status publish">publish</a>
		<a href="#" class="review_status trash">trash</a>
 -->	</div>
<!-- 		<div class="ribbon-wrapper">
			<div class="ribbon-front">
				<a href="#" class="review_status publish">publish</a>
			</div>
	 		<div class="ribbon-edge-topleft"></div>
	 		<div class="ribbon-edge-topright"></div>
			<div class="ribbon-edge-bottomleft"></div>
			<div class="ribbon-edge-bottomright"></div>
	 		<div class="ribbon-back-left"></div>
			<div class="ribbon-back-right"></div>
		</div>
		<div class="ribbon-wrapper">
			<div class="ribbon-front">
				<a href="#" class="review_status trash">trash</a>
			</div>
	 		<div class="ribbon-edge-topleft"></div>
			<div class="ribbon-edge-topright"></div>
			<div class="ribbon-edge-bottomleft"></div>
			<div class="ribbon-edge-bottomright"></div>
	 		<div class="ribbon-back-left"></div>
			<div class="ribbon-back-right"></div>
		</div>
 -->	<?php
		// echo '<ol class="single_product_status">';
		// echo '<li class="review_status publish" post="' . $post_id . '"><a href="#">publish</a></li>';
		// echo '<li class="review_status trash"  post="' . $post_id . '"><a href="#">trash</a></li>';
		// echo '</ol>';
	} 
?>
