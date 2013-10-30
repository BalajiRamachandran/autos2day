<?php 
get_header(); 
$DEFAULT = show_default_view();
include (TEMPLATEPATH . '/lib/pages/index_body.php');

if($DEFAULT){
	// this is a "fake cronjob" = whenever default index page is called - the age of dlinks is checked - and removed if necessary
	$DIGITALGOODS = load_what_is_needed('digitalgoods');	//change.9.10
	$DIGITALGOODS->delete_dlink();							//change.9.10
	
	//what featured content?
	$featuredType = $OPTION['wps_featuredType'];
	
	if(($OPTION['wps_mainCatNavi_enable']) || ($OPTION['wps_logoL'])) {$the_ul_class = 'featured clearfix featured_alt';} else {$the_ul_class = 'featured clearfix';}	?>
<!-- 	<p class="front-page-text">We Negotiate, Rate  and Rank using our advanced scoring algorithm and Publish the top 10 used car deals in your city. You get the 10 most valuable used cars in your city at unbelievable prices  every 24 hours!</p>
 -->	
<!--  		<div class="clearfix"></div>
 		<div class="widgetPadding clearfix">
		<div class="textwidget">We Negotiate, Rate  and Rank using our advanced scoring algorithm and Publish the top 10 used car deals in your city. You get the 10 most valuable used cars in your city at unbelievable prices  every 24 hours!</div>
	</div>
 -->	<ul class="<?php echo $the_ul_class;?>">
		<?php if ($featuredType !='featured_pages') {
			?>
<!-- 		<div class="widgetPadding clearfix"><h2 class="widget-title">We Negotiate, Rate  and Rank using our advanced scoring algorithm and Publish the top 10 used car deals in your city. 
You get the 10 most valuable used cars in your city at unbelievable prices  every 24 hours!</h2>
			<div class="textwidget"><p>This is a widget ready area for the customer account section</p>
		</div>
		</div>
 -->			<?php			
			echo '<p style="font-size: 1em;line-height: 1em;">We Negotiate, Rate  and Rank using our advanced scoring algorithm and Publish the top 10 used car deals in your city. 
You get the 10 most valuable used cars in your city at unbelievable prices  every 24 hours!</p>';
			include (TEMPLATEPATH . '/includes/featured/featured_cats.php'); 
		} else {
			include (TEMPLATEPATH . '/includes/featured/featured_pages.php'); 
		} ?>
	</ul><!-- featured -->
	
	<?php include (TEMPLATEPATH . '/widget_ready_areas.php'); 
} 
silent_db_upgrade();
get_footer(); ?>