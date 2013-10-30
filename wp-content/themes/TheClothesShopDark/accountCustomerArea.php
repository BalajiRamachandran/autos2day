<?php
session_start();
if (!is_user_logged_in()) {
	auth(1);
}
$level = "my_account";
$log = load_what_is_needed("log");
/*
Template Name: Account Customer Area

*/
require_once(dirname(__FILE__). "/../../../wp-admin/includes/media.php");	
$WISHLIST 		= load_what_is_needed('wishlist');	
$customerArea	= get_page_by_title($OPTION['wps_customerAreaPg']);

// remove item from wishlist 
if((isset($_POST['remove_wl_item'])) && (!empty($_POST['remove_wl_item']))){
	$WISHLIST->remove_from_wishlist();
}

// move item to cart
if((isset($_POST['transfer_wl_item'])) && (!empty($_POST['transfer_wl_item']))){
	$WISHLIST->wl_cart_transfer();
}

// update an item in Wishlist 
if((isset($_POST['refresh_wl_item']))&&($_POST['refresh_wl_item'] === 'yes')){
	$WISHLIST->update_wl_item();
}	

get_header();
echo '<div id="modal_window_placeholder"></div>';

// database query - get customer data
$row = NWS_get_user_details();

date_default_timezone_set(get_option('timezone_string'));


//get user wordpress
global $current_user;
get_currentuserinfo();


$display_name = get_user_meta ($current_user->ID, 'dealership_name', true);
if ( strlen(trim($display_name)) == 0) {
	$display_name = $current_user->user_nicename;
}
?>

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri() . '/css/jquery-ui-1.8.21.custom.css';?>" />
<script src="<?php echo get_stylesheet_directory_uri() . '/js/jquery-ui-1.8.2.custom.min.js';?>" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri() . '/js/vehicle_details.js';?>" type="text/javascript"></script>
<style type="text/css">
	 .ui-datepicker-calendar {
	    /*display: none;*/
	 }​
	 .terms_of_use_modal_dialog .page_post{
	 	padding: 10px;
	 }
	 .terms_of_use_modal_dialog {
	 	color: white;
	 }
	 .status-private {
	 	padding: 10px;
	 }
	 #cboxContent {
		/*background: black;*/
		overflow: hidden;
	}
	#kbbResponse {
		display: none;
	}

</style>

<script type="text/javascript">

	jQuery(document).ready(function(){


		jQuery("#status").accordion();
		jQuery(".terms_of_use").click (function(){
			// alert ( '1' );
			// jQuery(".terms_of_use").attr("href", url);
			// jQuery(".terms_of_use").attr("title", "Autos2Day | Terms of Use");
			// jQuery(".terms_of_use").colorbox( { width: '90%' });
			jQuery("#modal_window_placeholder").dialog("destroy");
			var url = '<?php echo get_permalink(get_page_by_title( "Terms of Use" )->ID);?>';
			jQuery("#modal_window_placeholder").load(url).dialog({
				modal: true,
				title: 'Autos2Day | Terms of Use',
				height: 1200,
				minHeight: 200,
				draggable: false,
				position: "top",
				resizable: false,
				at : 'center',
				show: { effect: 'drop', direction: "up" },
				width: 1200,
				dialogClass: "terms_of_use_modal_dialog",

			});
		});
		// jQuery("#deal_submission").validate({
		//   rules: {
		//     field: {
		//       required: true,
		//       number: true
		//     }
		//   }
		// });

		jQuery("#milesshowHint").hide();
		jQuery(".modal").hide();
		// jQuery("#kbbResponse").hide();
		jQuery("deal_submission").submit(function(){
			//validate form
			// get creditcarddetails.
			alert ("1");

			return false;
		});
	});

</script>


<div class="overlay modal" >
	<p style="margin-top:22%;margin-left:100px;">Processing 
		<img class="loadingImg" src="<?php echo bloginfo('stylesheet_directory') . '/images/ajax-loader.gif';?>" alt="loading..." />			
	</p>
	<center>
		<div id="processingText"></div>
	</center>
</div>


<?php


// sidebar location

switch($OPTION['wps_sidebar_option']){
	case 'alignRight':
		$the_float_class 	= 'alignleft';
	break;
	case 'alignLeft':
		$the_float_class 	= 'alignright';
	break;
}

$url 			= get_permalink( $customerArea->ID);
$the_div_class 	= 'narrow '. $the_float_class;
?>
	<div <?php post_class('page_post '.$the_div_class); ?> id="post-<?php the_ID(); ?>" ref="1">
		<?php 
		
		// sub-action switch 
		switch($_GET[action]){
		
			case 1: // edit login data ?>
				<h4>
					<?php //_e('You may edit <!--your email address or--> your password or both! Simply fill in the forms that apply to you.','wpShop');?></h4>
		
				<?php
				if(isset($_GET['err'])){
				
					$error_text = NULL;
				
					switch($_GET['err']){
					
						case '1':
							$error_text = __('Your email format is invalid.','wpShop');	
						break;		
						case '2':
							$error_text = __('You have not repeated your email correctly! Perhaps typing slower may help.','wpShop');
						break;		
						
						case '3':
							$error_text = __('Your password is too short.','wpShop');
						break;
						
						case '4':
							$error_text = __('You have not repeated your password correctly! Perhaps typing slower may help.','wpShop');
						break;		
							
					}
				
					echo "<div class='login_err'>Error: $error_text</div>";
				}
				
				if(isset($_GET['success'])){		

					$success = __('Success!','wpShop');
					$updated = __('Updated','wpShop');
					
					if($_GET['success'] == 'password'){
						$newWhat = __('Password','wpShop');
					}				
					if($_GET['success'] == 'email'){
						$newWhat = __('Email','wpShop');
					}						
					echo "<div class='success'>$success ". $newWhat ." {$updated}.</div>";
				}			
				?>
												
				<form id="editPassword" class="clearfix" action="<?php echo get_bloginfo('template_url') . '/edit-user.php'; ?>" method="post">
					<fieldset class="clearfix">
						<legend><span><?php _e('Edit Password (Min 6 and Max 8 Characters)','wpShop');?></span></legend>
						
						<div class="alignleft">
							<label for="newPassword"><?php _e('New Password','wpShop');?></label>
							<input id="newPassword" type="password" size="35" maxlength="8" value="" tabindex="3" name="newPassword"/>
						</div>	
						
						<div class="alignright">
							<label for="rnewPassword"><?php _e('Repeat New Password','wpShop');?></label>
							<input id="rnewPassword" type="password" size="35" maxlength="8" value="" tabindex="4" name="rnewPassword"/>
						</div>	
						<input type="hidden" id="" name="editOption" value="password"/>
						<input class="formbutton" type="submit" alt="<?php _e('Send','wpShop');?>" value="<?php _e('Send','wpShop');?>" name="" title="<?php _e('Send','wpShop');?>" />
					</fieldset>
				</form>
			<?php 	
			break;
			
			// Customer Info
			case 2: 
				
				include(TEMPLATEPATH . '/lib/pages/myaccount_voucher_submission-old.php');
			
			break;
			
			case 3: 	// WISH-LIST //POST-LISTING

				// echo "option: " . $OPTION['wps_wishlistIntroText'] . "<br/>";
				// print_r ( $_GET );
				if ( ! current_user_can( 'administrator' ) ) {
					echo '<h1>' . $display_name . ' Submitted Deals</h1>';
					echo '<h3>';
					echo '<ol style="list-style-type: square;">';
					echo '<li>';
					echo 'Deals, once submitted, can be modified only by calling us.';
					echo '</li>';
					echo '<li>';
					echo 'These are only deals submitted for the next day.';
					echo '</li>';
					echo '</ol>';
					echo '</h3>';
				} else {
					echo '<h1>"' . $current_user->display_name . '" Deals to Review</h1>';
				}

				global $post;
				include (TEMPLATEPATH . "/lib/pages/get_posts_list.php");
				$myposts = get_posts( $args );
				$xml = load_what_is_needed("xml");

				if ( current_user_can( 'administrator' ) ) {
					include (TEMPLATEPATH . "/lib/pages/post_listing_admin.php");
				} else {
					include (TEMPLATEPATH . "/lib/pages/myaccount_post_listing.php");
				}



			break;
			
			// for future use
			case 4:
				include (TEMPLATEPATH . "/lib/pages/authn/card_details.php");

			break;
			
			case 5:		
				//dealer email address update
				include (STYLESHEETPATH . "/lib/pages/update_dealer.php");


			break;

			case 6:		

			break;

			case 7:		

			break;

			case 8:		

			break;

			case 9:		

				include (STYLESHEETPATH . "/lib/pages/bmpconversion/ConvertBmpToJpg.php");

			break;

			
			default:
				$current_user = wp_get_current_user();
				$user_meta = get_user_meta ( $current_user->ID );
				echo "<h3>".__('Welcome back, ', 'wpShop') . $display_name. "</h3>";

				if($OPTION['wp_logoutLink_option']){
					if($OPTION['wps_useGet4logout'] == 'yes'){
						$logoutUrl = get_real_base_url();
						echo "<p><a href='".get_bloginfo( 'template_directory' )."/logout.php?go2page=$logoutUrl'>";
						echo __('Logout', 'wpShop')."</a></p>";  
					}
					else {
						echo "<p><a href='".get_bloginfo( 'template_directory' )."/logout.php'>".__('Logout', 'wpShop')."</a></p>"; 
					}
				}

				$time_now = date('H');
				echo '<h1>Submit your Deal!</h1>';
				echo '<h2>You will be charged <strong>$' . number_format(get_option('wps_deal_amount'), 2, ',', '') . '</strong> only if your deal is approved</h2>';
				if ( isset($_GET['debug']) ) {
					echo '<blockquote>' . $time_now . '</blockquote>';
				}
				if ( $time_now < 12 && $time_now > 6 ) {
					$add_a_day = 0;
				} else {
					$add_a_day = 1;
				}
				if ( isset($_GET['debug']) ) {
					echo '<blockquote>add_a_day: ' . $add_a_day . '</blockquote>';
				}
					the_post();
					$return = '<div class="wp-insert-post">';
					// Posting form
					if ( empty( $_POST['save'] ) ) {
						echo get_post_insert_form( $current_user, $add_a_day );
					}
					// Data sent
					else {
						?>
						<script type="text/javascript">
							jQuery(".modal").show();
						</script>
						<?php
						$_POST['title'] = $_POST['ad_year'] . ' ' . $_POST['ad_make'] . ' ' . $_POST['ad_model'];

						// Not specified content
						if ( empty( $_POST['content'] ) ) {
							$return .= '<div id="wpip-message" class="wpip-error">' . __( 'Enter content!', 'wp-insert-post' ) . '<br/><a href="javascript:history.go(-1)">&lsaquo; ' . __( 'Go back', 'wp-insert-post' ) . '</a></div>';
						}

						// Title and content specified
						else {

							// New post args
							$post_args = array(
								'post_title' => apply_filters( 'the_title', $_POST['title'] ), 
								'post_content' => apply_filters( 'the_content', $_POST['content'] ), 
								'post_status' => 'pending', 
								'post_author' => $current_user->ID,
								'post_category' => array( $_POST['category'] ) 
							);

							include (TEMPLATEPATH . "/lib/pages/ad_post_meta.php");

							foreach ($meta_keys as $v) {
								if ( isset($_POST[$v])) {
				    				if ( $v == 'ad_price' ) {
				    					$_POST[$v] = str_replace(",", "", $_POST[$v]); //remove the ',' from price
				    					$_POST[$v] = str_replace("$", "", $_POST[$v]); //remove the '$' from price
				    				}
				    				if ( $v == 'ad_miles' ) {
				    					$_POST[$v] = str_replace(",", "", $_POST[$v]); //remove the ',' from price
				    				}
				    				$meta_args[$v] = $_POST[$v];
								}
							}

							//generate voucherid
							//strtoupper(substr(md5 ('2001' . 'Ford' . 'Icon' . 'trim' . 'blue' . 'vin12345656' ), 15))
							// $md5_hash = md5($meta_args['year'] . $meta_args['make'] . $meta_args['trim'] . $meta_args['model'] . $meta_args['color'] . $meta_args['vin'] );
							//$meta_args['voucherid'] = strtoupper(substr($md5_hash, -15));

							//generate expiration-time
							// $meta_args['expiration-time'] = expiration_time_set();//mktime(0, 0, 0, date("m")  , date("d")+2, date("Y"))
							// $meta_args['deal-date'] = deal_date_set();//mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
							// $meta_args['_expiration-date-category'] = $_POST['category'];
							// $meta_args['_expiration-date-processed'] = 1;

							// Post added
							$post_id = wp_insert_post( $post_args );
							$log->general("Inserted Post: " . $post_id);
							// if ( $post_id ) {
							if ( $post_id ) {
								// include (TEMPLATEPATH . "/lib/pages/vehicle_prices.php");
								$authn_id = $post_id;
								include (TEMPLATEPATH . "/lib/pages/post_submission_processing.php");
							} // else post_id 

							else {
								echo "<div class='error'>Error registering post</div>";
							}
						} // end else
					}

					$return .= '</div>';
				// } else {
				// 	echo '<div class="success">Posting Deal is closed for the day</div>';					
				// }
				echo $return;

				
				// if ( $time_now < 13 && $time_now > 6 ) {
				// 	the_post(); 
				// } else {
				// 	echo '<div class="success">Posting Deal is closed for the day</div>';
				// }
				the_content();
			break;

		} ?>
		
	</div><!-- page_post -->
	<?php
	if ( ( $_GET['action'] == '3' || $_GET['action'] == '5' ) && current_user_can( 'administrator' ) ) {

	} else {
	?>	
	<?php 
		include (TEMPLATEPATH . '/widget_ready_areas.php');
	}	
get_footer(); 
?>