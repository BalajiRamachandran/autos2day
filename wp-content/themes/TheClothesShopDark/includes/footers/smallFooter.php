<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.min.js" type="text/javascript" charset="utf-8"></script> -->
<script src="<?php echo get_stylesheet_directory_uri() . '/js/jSocial.js';?>" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.facebook').jsocial({
			facebook    :  'facebook.com/autos2day',
			inline		: 	true,
			small 		: 	true
		});		
	});
</script>
<style type="text/css">
#footer .facebook a {
	border: 1px solid;
	color: black;
	padding: 3px 7px ;
	min-height: 20px;
	line-height: 13px;
}
</style>
<div id="footer" class="smallft clearfix noprint">
	<div class="container clearfix">
		<p class="footer_notes">
			<span class="copyright">&copy; <?php echo date('Y'); ?>. <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>. | <?php _e('All Rights Reserved','wpShop');?>.</span>
			
<!--<span><?php _e('WordPress Theme by','wpShop');?> <a href="http://www.sarah-neuber.de"><?php _e('SN Design &amp; Development','wpShop');?></a>.</span>-->
		<span>
			<a href="https://www.facebook.com/autos2day" rel="nofollow"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/socialIcons/facebook.png" alt="Facebook" height="18px" hspace="0"/><?php _e('','wpShop'); ?></a>
<!-- 			<span class="facebook" style="float:left;"></span>
 -->			&nbsp; | &nbsp;
			<a href="<?php bloginfo('url'); ?>/privacy">
				<?php _e('Privacy Policy','wpShop');?>
			</a>&nbsp; | &nbsp;
			<a href="<?php bloginfo('url'); ?>/terms-conditions">
				<?php _e('Terms & Condition','wpShop');?>
			</a>
		</span>
	</p>