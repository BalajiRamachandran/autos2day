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
 -->		
 			<?php
 				date_default_timezone_set(get_option('timezone_string'));
 				$go_live_date = date( 'Y-m-d',  strtotime(get_option ("wps_go_live")));
 				if ( strtotime($go_live_date) > strtotime(date('Y-m-d')) ) {
 					?>

 					
 				<script type="text/javascript">

 				jQuery(document).ready(function(){
 					// jQuery(".go_live").animate({boxShadow: '0 0 30px #44f'});
 					var _year = '<?php echo date("Y", strtotime($go_live_date)); ?>';
 					var _month = '<?php echo date("m", strtotime($go_live_date)) - 1; ?>';
 					var _day = '<?php echo date("d", strtotime($go_live_date)); ?>';
 					jQuery(".go_live_date").countdown({until: new Date(_year, _month, _day), compact: true,
 						layout: 'Launching in T-minus.... <b>{wnn} {wl} {dnn} {dl} {hnn}{sep}{mnn}{sep}{snn}</b> {desc}', 
    					description: '',
    					format: 'YOWDHMS'
 					});
 				});

 				</script>

				<link href='https://fonts.googleapis.com/css?family=Squada+One|Balthazar|Yellowtail' rel='stylesheet' type='text/css'>
				<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
	 			<style type="text/css">
	 				.hasCountdown {
	 					  font:3em "Yellowtail"; color:#fff;  
	 				}
	 			</style>
				<?php
	 				echo "<div class='go_live'><p><span class='go_live_date'></span></p></div>";
 				}
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
 				jQuery("button[ref='jbutton']").each(function(){
 					jQuery(this).button();
 				});
 				jQuery(".cardgiveaway").click(function(){
 					jQuery.colorbox({opacity : '1.0', href: jQuery(this).attr("ref"), width: '700px', height: '500px', title: jQuery(this).attr("title"),
 						 onComplete: function() {jQuery(this).colorbox.resize();}, preloading: true

	 				});
 				});
 			});
 			</script>
 			<div class="cardgiveaway banner" ref="<?php echo get_stylesheet_directory_uri() . '/lib/pages/promotion_form.php';?>" title="<?php echo get_option('wps_promotion');?>!"><?php echo get_option('wps_promotion');?>!</div>
 			<?php			
 				$homepage = get_page_by_title ("Home Page Content");
 				echo '<div class="main_text"><p>' . $homepage->post_content . '</p></div>';
 				echo '<p></p>';
			include (STYLESHEETPATH . '/includes/featured/featured_cats.php'); 
		} else {
			include (STYLESHEETPATH . '/includes/featured/featured_pages.php'); 
		} ?>
	</ul><!-- featured -->
	
	<?php include (TEMPLATEPATH . '/widget_ready_areas.php'); 
} 
silent_db_upgrade();
get_footer(); ?>