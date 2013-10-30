<?php
//facebook like button
?>
<div class="status-<?php echo $post->post_status;?> likebutton" style="float:right;">
	<?php 
	//echo urlencode(get_permalink());
	if ( is_ssl()) {
		$protocol = 'https';
	} else {
		$protocol = 'http';
	}
	?>
	<!--https%3A%2F%2Fbramkaslp01%2Fautos2day%2F%3Fp%3D3400-->

		<iframe
			src="<?php echo $protocol;?>://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink());?>&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21"
			scrolling="no"
			frameborder="0"
			style="border:none;
			overflow:hidden;
			width:200px;
			height:21px;"
			allowTransparency="true">
		</iframe>
</div>
