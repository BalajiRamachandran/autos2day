<?php get_header(); 
$category 			= get_the_category($post->ID); 
$topParent_cat 		= get_post_top_parent();
$topParent_catSlug 	= get_cat_slug($topParent_cat);
$Parent_cat 		= get_parent_cat_id();
$Parent_catSlug 	= get_cat_slug($Parent_cat);
$log 				= load_what_is_needed("log");
$post_vin 			= get_post_meta ( $post->ID, 'ad_vin', true );	
$post_meta			= get_post_meta ( $post->ID, '', false );
$custom_fields 		= get_post_custom($post->ID);
$author_data 		= get_userdata( $post->post_author );

$author 			= $post->post_author;
$user_meta 			= get_user_meta ( $author );
$dealership_id 		= get_user_meta ( $author, 'dealership_id', true );
$post_id 			= $post->ID;
$date_time_format 	= get_option("date_format") . ' ' . get_option("time_format");



$attr_option 		= get_custom_field("add_attributes"); // attributes - simple or configurable price?
//collect options
$WPS_prodImg_effect	= $OPTION['wps_prodImg_effect'];

$accountReg		= get_page_by_title($OPTION['wps_pgNavi_regOption']);
$wps_shop_mode 	= $OPTION['wps_shop_mode'];

the_post(); 

/* 
	page view count 
	BR 2012/08/09
*/
$view_count = get_post_meta ($post->ID, 'view_count', true);
if ( $view_count == '' ) {
	$view_count = 0;
}
++$view_count;
update_post_meta ( $post->ID, 'view_count', $view_count);

?>

	<script type="text/javascript">
		jQuery(document).ready(function(){
			var email = '<?php echo strlen($_POST['voucher_email'])?>';
			var a = 0;
		});
	</script>

	<div id="singleMainContent" class="clearfix">
		<?php

		// Prod Navi links at top?
		if($OPTION['wps_linksTop_enable']) {
			include (STYLESHEETPATH . '/includes/single/singleProdNavi.php');
		} 

		// "added to wishlist or cart" - feedback 
		if($_GET['added'] == 'OK'){
			$basket_url = get_option('home') .'?showCart=1&cPage='. current_page(3);
			//$basket_url = get_option('home') . '/index.php?showCart=1';	//or this as alternative
		} 
		else {
			if ( ! empty($_POST['voucher_email']) ) {
				$log->general("Starting voucher processing");
				$email_address 	= $_POST['voucher_email'];
				$visitor = trim($_POST['namex']);
				$phone_no = trim($_POST['phone_no']);
				$log->general("visitor name" . $visitor);
				upgrade_voucher_table();
				$md5_string 	= $email_address . $dealership_id . $post_vin;
				$md5_hash 		= md5 ( $md5_string );
				$voucher_code 	= substr(strtoupper($md5_hash), -10);
				$qr_code = 'https://chart.googleapis.com/chart?chs=177x177&cht=qr&chl=' . $voucher_code . '&.png';

				$log->general("Date time format " . $date_time_format);
				// store emailaddress vin and dealerid to DB
				$log->general("Query DB for " . $voucher_code);
				$table 				= is_dbtable_there('ad_vouchers');//feusers');
				$qStr 				="SELECT * FROM $table WHERE voucher = '$voucher_code'";	
				$result 			= mysql_query($qStr);
				$num 				= mysql_num_rows($result);

				$complete = 0;
				$voucher_sent = 0;

				if ( $num > 0 ) {
					$voucher_sent = 1;
					$complete = 0;
				} else {
					$voucher_sent = 0;
					$log->general("inserting voucher processing " . $voucher_code);

					$qStr 			="INSERT INTO $table (email, visitor, phone_no, dealership_id,user_id,vin,voucher,post_id,date_sent) VALUES ('$email_address','$visitor','$phone_no','$dealership_id','$author','$post_vin', '$voucher_code', '$post_id', CURDATE())";
					$res 			= mysql_query($qStr);
					if ( $res==true) {
						$complete = 1;
					}
				}
				$voucher_sent = 0;
				$complete = 1;
				if ( $complete == 1 ) {				
					$contents = array_merge((array)$post_meta, (array)$user_meta);
					$VOUCHER = load_what_is_needed('voucher');
					$log->general("creating voucher pdf");
					try {
						$pdf_file = $VOUCHER->make_voucher_pdf (
							$table, 
							$post_id, 
							$author, 
							$voucher_code, 
							$qr_code
							);
					} catch ( Exception $e ) {
						$log->general("Error Creating Pdf " . $e->getMessage());
						die ("<div class='success'>" . $e->getMessage() . "</div>");
					}				
					$log->general("completing voucher pdf " . $pdf_file);
					$voucher_count = get_post_meta($post_id, "download_voucher_count", true);
					if ( !isset($voucher_count)) {
						$voucher_count = 0;
					}
					update_post_meta ($post_id, "download_voucher_count", ++$voucher_count);
				}

				if ( $complete == 1 && $_POST['email_subscription'] == "on" ) {
					$log->general("Starting voucher email");
					$voucher_sent = 2;
					$voucher_options = array_merge((array)$post_meta, (array)$user_meta);
					$voucher_options['name'] = $visitor;
					$voucher_options['phone_no'] = $phone_no;
					$voucher_options['email'] = $email_address;
					$voucher_options['voucher_code'] = $voucher_code;
					$voucher_options['qr_code'] = $qr_code;
					$voucher_options['author'] = $author;
					$voucher_options['title'] = "<a href='" . get_permalink($post->ID) . "'>$post->post_title</a>";
					// print_r(get_dealer_emails($author));
					email_vouchers ($voucher_options );
					$log->general("completing voucher email");
				}

			}
		}
		//\change.9.9		
		?>			
		<h1 class="entry-title single-page">
			<?php the_title(); ?>
			<?php include(TEMPLATEPATH . "/lib/pages/single_product_status.php");?>
		</h1>			
		<div class="imgSection">
			<?php 
			// Set the post content to a variable
			$subject = $post->post_content;
			// Look for embeded videos or audio
			$pattern  = '/\[(\w*)\sid="([^"]+)"\swidth="([^"]+)"\sheight="([^"]+)"]/';
			// Run preg_match_all to grab all videos and save the results in $videoMatches
			preg_match_all( $pattern , $subject, $videoMatches); 
			
			//let's collect our attachments
			$data		= my_attachment_data(0);
			//count them
			$num 		= count($data);
			if($num > 0 || strlen(get_custom_field('image_thumb', FALSE))>0){
				// $WPS_prodImg_effect = "lightbox";
				// echo ( $WPS_prodImg_effect );
				// which effect?
				switch($WPS_prodImg_effect){
					case 'mz_effect': 
						include (STYLESHEETPATH . '/includes/single/mz_effect.php');
					break;
					
					case 'mzp_effect': 
						include (STYLESHEETPATH . '/includes/single/mzp_effect.php');
					break;
					
					case 'jqzoom_effect': 
						include (STYLESHEETPATH . '/includes/single/jqzoom_effect.php');
					break;
					
					case 'lightbox':
						include (STYLESHEETPATH . '/includes/single/lightbox.php');
					break;
					
					case 'no_effect': 
						include (STYLESHEETPATH . '/includes/single/no_effect.php');
					break;
				} 
				
			} else { ?>
				<p class="error">
					<?php _e('Oops! No Product Images were found.  Thanks.','wpShop'); ?><br/>
				</p>
			<?php } 
			
			if($OPTION['wps_relatedProds_enable']) {
				include (STYLESHEETPATH . '/includes/single/singleRelatedProds.php');
			} ?>
			
		</div><!-- imgSection -->
		
		<div class="prodDetails singleDetailsPage">
			<!-- <h1 class="entry-title"><?php the_title(); ?></h1>			 -->
			<div <?php post_class('single_post clearfix'); ?> id="post-<?php the_ID(); ?>">
			<?php 
				if (!empty($videoMatches[1][0])) { 
					echo filter_img_from_descr($pattern, $subject);
				} else {
			?>
				<?php include (STYLESHEETPATH . '/facebook_like.php'); ?>
				<?php include (TEMPLATEPATH . '/lib/pages/voucher_download.php'); ?>

				<table><div class="clearfix"><!----></div></table>
				<?php include (TEMPLATEPATH . '/lib/pages/single_deal_details.php'); ?>

					<?php
					the_content('<p class="serif">'. __( 'Read the rest of this page &raquo;', 'wpShop' ) . '</p>');					
					wp_link_pages(array('before' => '<p><strong>' . __( 'Pages:', 'wpShop' ) . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number'));
					if ( current_user_can( 'administrator' ) && $_POST['get_prices'] == "true") {
						include (TEMPLATEPATH . '/lib/pages/vehicle_prices.php'); 
					}
				}
			?>
			</div><!-- single_post -->			
			<?php
			if ( $complete == 1) {
			?>
			<?php
				include (TEMPLATEPATH . '/lib/pages/voucher_details.php'); 
			?>

			<?php
			}
			if ( $voucher_sent == 1 ) {
				echo '<div class="success">You have already received the voucher.</div>';			
			} elseif ($voucher_sent == 2 ) {
				echo '<div class="success">Successfully sent the voucher in email.</div>';
			}
			?>
			<?php
			include (TEMPLATEPATH . '/lib/pages/single_body.php'); 
			?>
<!-- 
			<?php 
				if ( $voucher_code) {
					?>
					<?php
						$_POST['voucher_code'] = $voucher_code;
						$ajaxURL = $_SERVER['REQUEST_URI'];
					?>
					<script type="text/javascript">
						var url = '<?php echo $ajaxURL;?>';
						location.href = url;
					</script>
					<?php
				}
			?> -->

		</div><!-- prodDetails -->
		 
		<?php if($OPTION['wps_prodNav_enable']) { ?>
			<div class="linksBottom clearfix noprint">
				<?php include (STYLESHEETPATH . '/includes/single/singleProdNavi.php');?>
			</div>
		<?php } ?>
		
	</div><!-- singleMainContent -->
	
	<div id="emailoverlay" class="overlay largeoverlay">
		<h2><?php echo $OPTION['wps_email_a_friend_title']; ?></h2>
		<p><?php echo $OPTION['wps_email_a_friend_text']; ?></p>
		<?php 
		if(function_exists('is_tellafriend')){
			if(is_tellafriend( $post->ID )) insert_cform(2); 
		} else {
			echo "
			<p>
				No form?<br/>Install the cformsII plugin' .<br/>
				Available <a href='http://www.deliciousdays.com/cforms-plugin' target='_blank'>here</a>
			</p>
			";
		} ?>
	</div><!-- emailoverlay -->
						
	<div id="sizesInfoOverlay" class="overlay" style="width: auto; height: 300px;">
			<!--cforms name="Get_voucher"-->
			<!--0000051-->
			<h3>Download Voucher</h3>
			<?php 
			// insert_cform('2');
			?>
			<form action="" method="post" name="get_voucher" id="get_voucher">
				<fieldset>
					<p>
						<label for="name">Enter your Name</label>
						<input type="text" value="" tabindex="35" name="namex" id="namex" />
					</p>
					<p>
						<label for="voucher_email">Enter your email address</label>
						<input type="text" value="" tabindex="35" name="voucher_email" id="voucher_email" type="email"/>
					</p>
					<p>
						<label for="phone_no">Enter your Phone No</label>
						<input type="text" value="" tabindex="35" name="phone_no" id="phone_no" />
					</p>
<!-- 					<p>
						<label for="visitor">Enter your Name</label>
						<input type="text" value="" tabindex="35" name="visitor" id="visitor"/>
					</p> -->
<!-- 					<div style="width: 250px;">
					<input type="checkbox" tabindex="35" name="email_subscription" id="email_subscription" checked/>
					<span style='width: 250px;'>Uncheck to stop receiving emails with deals, promotions and other offers</span>
					</div>
 -->					
 					<input type="hidden" tabindex="35" name="email_subscription" id="email_subscription" value="on"/>
 					<input type="hidden" name="post-id" value="<?php the_ID(); ?>"/>
				</fieldset>
				<fieldset class="submit">
					<input type="submit" value="GO" tabindex="40" id="submit" name="submit" />
				</fieldset>				
			</form>
		<div class="sizeChartWrap">

		</div>
	</div><!-- sizesInfoOverlay -->
		
<?php get_footer();?>