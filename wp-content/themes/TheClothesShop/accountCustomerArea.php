<?php
session_start();
if (!is_user_logged_in()) {
	auth(1);
}

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

<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#milesshowHint").hide();
		jQuery(".modal").hide();
		jQuery("#kbbResponse").hide();

		//jQuery("#effective_date").datepicker();
		// jQuery("select").each(function(){
		// 	jQuery(this).change(function(){
		// 		if ( jQuery(this).val() != "null") {
		// 			if ( jQuery(this).find("option:selected").attr("MakeId") != "" ) {
		// 				hide_options ( jQuery(this).parent().next(), "refMakeId", jQuery(this).find("option:selected").attr("MakeId"), "" );
		// 			}
		// 			if ( jQuery(this).find("option:selected").attr("ModelId") != "" ) {
		// 				hide_options ( jQuery(this).parent().next(), "refModelId", jQuery(this).find("option:selected").attr("ModelId"), "" );
		// 			}

		// 			reset_select_elements ( jQuery(this).parent(), "" );
		// 		} else {
		// 			reset_select_elements ( jQuery(this).parent(), "true" );
		// 			//hide_options (jQuery(this).parent().next(), "refMakeId", jQuery(this).attr("MakeId"), "show" );
		// 		}
		// 	});				
		// });
		// jQuery("#ad_make").change(function(){
		// 	if ( jQuery(this).val() != "null") {
		// 		reset_select_elements ( jQuery(this).parent(), "" );
		// 	} else {
		// 		reset_select_elements ( jQuery(this).parent(), "true" );
		// 	}
		// });
	});

	function checkVoucher(subfolder, protocol, zipcode, vin_no, prev_sibling)
	{	
		if ( jQuery(vin_no).val().length < 17 ) {
			jQuery("#txtHint").show();
			jQuery("#txtHint").text( "VIN should be 17 Characters!" );
			jQuery("#txtHint").attr("class", "success");
			return;
		} else {
			jQuery("#txtHint").hide();				
		}
		if ( jQuery(prev_sibling)) {
			miles = jQuery(prev_sibling).find("input").val();
		}
		if ( miles == "" || miles == "undefined") {
			jQuery("#txtHint").show();
			jQuery("#txtHint").text("Please enter the mileage");
			jQuery("#txtHint").attr("class", "success");
			jQuery(prev_sibling).find("input").focus();
			return;
		} else {
			jQuery("#milesshowHint").hide();
		}
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
		{
		  alert ("Browser does not support HTTP Request");
		  return;
		}
		jQuery(".modal").show();  				
		var url		= protocol + NWS_template_directory_alt +"/ajax_form_kbb.php";
		//alert ( url );
		//var vid 	= document.getElementById("vid").value;
								
		url	= url+"?vin="+jQuery(vin_no).val()+"&z="+zipcode+"&m="+miles;	
		url	= url+"&sid="+Math.random();
		url	= encodeURI(url);
		xmlhttp.onreadystatechange=stateRetrieveVin;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
	}


	function stateRetrieveVin() {
		if (xmlhttp.readyState==4) {
			jQuery(".modal").hide();
			var xml = xmlhttp.responseText;
			var errors = jQuery.trim(jQuery(xml).find("Errors").text());
			if ( errors.length > 0 ) {
				jQuery("#txtHint").show();
				jQuery("#txtHint").text( "Invalid VIN!" );
				jQuery("#txtHint").attr("class", "success");
				return;
			}


			//alert ( jQuery(xmlhttp.responseText).find("Make").find("Value").text() );
			var ad_year = jQuery(xml).find("Year").find("id").text();
			var ad_make = jQuery(xml).find("Make").find("Value").text();
			var ad_model = jQuery(xml).find("Model").find("Value").text();
			var ad_trim = jQuery(xml).find("Trim").find("Value").text();

			//PrivatePartyExcellent
			var ad_pparty = "";
			jQuery(xml).find("PriceType").each(function(){
				if ( jQuery.trim(jQuery(this).text()) == "PrivatePartyExcellent") {
					ad_pparty = jQuery.trim(jQuery(this).parent().find("Value").text());
				}
			});		

			// var ad_pparty = jQuery(xml).find("Trim").find("Value").text();

			var Options = new Object();

			jQuery(xml).find("Element").each(function(){
				jQuery(this).find("OptionTypeDisplayName").each(function(index, element){
					var OptionalEquipment = jQuery.trim(jQuery(this).text());
					if ( ( OptionalEquipment == "Transmission") || (OptionalEquipment == "Engine") || (OptionalEquipment == "DriveTrain") ) {
						var parent = jQuery(this).parent();
						jQuery(parent).find("DisplayName").each(function(){
							var DisplayName = jQuery.trim(jQuery(this).text());
							if ( Options[OptionalEquipment] != "" || Options[OptionalEquipment] != "undefined" ) {
								Options[OptionalEquipment] = Options[OptionalEquipment] + "|" + DisplayName;
							} else {
								Options[OptionalEquipment] = DisplayName;
							}
						});
					}
				});
			});

			for (var k in Options) {
			    // use hasOwnProperty to filter out keys from the Object.prototype
			    if (Options.hasOwnProperty(k)) {
			    	var values = Options[k].replace("undefined|", "").split('|');
			    	for ( var i = 0; i < values.length; i++) {
			    		jQuery("#ad_"+k).append("<option value=\""+values[i]+"\">"+values[i]+"</option>");
			    	}
			        //alert('key is: ' + k + ', value is: ' + Options[k]);
			        //<input type="text" name="ad_trans" id="kbbResponseTransmission" size="40"  required/>
			        //<select name="ad_trans"
			    }
			}
			jQuery("#kbbResponseYear").val(ad_year);
			jQuery("#kbbResponseMake").val(ad_make);
			jQuery("#kbbResponseModel").val(ad_model);
			jQuery("#kbbResponseTrim").val(ad_trim);
			jQuery("#kbbResponsePrivatParty").val(ad_pparty);


			jQuery("#kbbResponse").show();
			jQuery("#ad_color").focus();
			// jQuery("#kbbResponseMake").text(jQuery(xml).find("Make").find("Value").text());
			// jQuery("#kbbResponseModel").text(jQuery(xml).find("Model").find("Value").text());
			// jQuery("#kbbResponseTrim").text(jQuery(xml).find("Trim").find("Value").text());
			// jQuery("#kbbResponse").text(xmlhttp.responseText);
		}
	}

	function reset_select_elements ( element, disabled ) {
		if ( disabled == "") {
			jQuery(element).next().each(function(){
				jQuery(this).find("select").val("null");
				jQuery(this).find("select").attr("disabled", disabled);	
				reset_select_elements ( jQuery(this), "true" );
			});					
		} else {
			jQuery(element).nextAll().each(function(){
				jQuery(this).find("select").val("null");
				if ( disabled ) {					
					jQuery(this).find("select").attr("disabled", disabled);
					jQuery(this).find("option").attr('style', 'display: block;');	
				}
			});				
		}	
	}
	function hide_options ( object, attr_key, value, show ) {
		jQuery(object).find("option").each(function() {
			if ( jQuery(this).attr(attr_key) ) {
				// alert ( jQuery(this).attr(attr_key) + "====" + value );					
				if ( jQuery(this).attr(attr_key) != value && value != "" ) {
					jQuery(this).hide();
				} else {
					jQuery(this).attr('style', 'display: block;');
				}
				if ( show ) {
					jQuery(this).attr('style', 'display: block;');				
				}
			}
		});
	}
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
												
<!--
				<form id="editEmail" class="clearfix" action="<?php echo get_bloginfo('template_url') . '/edit-user.php'; ?>" method="post">
					<fieldset class="clearfix">
						<legend><span><?php _e('Edit Email Address','wpShop');?></span></legend>
						
						<div class="alignleft">
							<label for="newEmail"><?php _e('New Email Address','wpShop');?></label>
							<input type="text" id="newEmail" name="newEmail" size="35" maxlength="40" tabindex="1" 
							value="<?php echo $_SESSION[email]; ?>"/>
						</div>
						
						<div class="alignright">
							<label for="rnewEmail"><?php _e(' Repeat New Email Address','wpShop');?></label>
							<input type="text" id="rnewEmail" name="rnewEmail" size="35" maxlength="40" tabindex="2" value=""/>
						</div>
						<input type="hidden" id="" name="editOption" value="email"/>
						<input class="formbutton" type="submit" alt="<?php _e('Send','wpShop');?>" value="<?php _e('Send','wpShop');?>" name="" title="<?php _e('Send','wpShop');?>" />
					</fieldset>
				</form>
				<hr/>
-->
				<form id="editPassword" class="clearfix" action="<?php echo get_bloginfo('template_url') . '/edit-user.php'; ?>" method="post">
					<fieldset class="clearfix">
						<legend><span><?php _e('Edit Password','wpShop');?></span></legend>
						
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

				// foreach( $myposts as $post ) :	setup_postdata ( $post );
				// 	echo "<br/>post id: " . $post->ID				;
				// 	print_r($myposts[$post->ID]);
				// endforeach;


				if ( current_user_can( 'administrator' ) ) {
					include (TEMPLATEPATH . "/lib/pages/post_listing_admin.php");
				} else {
					include (TEMPLATEPATH . "/lib/pages/myaccount_post_listing.php");
				}



			break;
			
			// for future use
			case 4:

			break;
			
			case 5:		

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
				if ( $time_now < 13 && $time_now > 6 || current_user_can( 'administrator' ) ) {
					$add_a_day = 1;
				} else {
					$add_a_day = 0;
				}
					the_post();
					$return = '<div class="wp-insert-post">';
					// Posting form
					if ( empty( $_POST['save'] ) ) {
						echo get_post_insert_form( $current_user );
					}
					// Data sent
					else {
						?>
						<script type="text/javascript">
							jQuery(".modal").show();
						</script>
						<?php
						$_POST['title'] = $_POST['ad_year'] . ' ' . $_POST['ad_make'] . ' ' . $_POST['ad_model'];
						// Not specified title
						if ( empty( $_POST['title'] ) ) {
							//$return .= '<div id="wpip-message" class="wpip-error">' . __( 'Specify title!', 'wp-insert-post' ) . '<br/><a href="javascript:history.go(-1)">&lsaquo; ' . __( 'Go back', 'wp-insert-post' ) . '</a></div>';
						}

						// Not specified content
						elseif ( empty( $_POST['content'] ) ) {
							$return .= '<div id="wpip-message" class="wpip-error">' . __( 'Enter content!', 'wp-insert-post' ) . '<br/><a href="javascript:history.go(-1)">&lsaquo; ' . __( 'Go back', 'wp-insert-post' ) . '</a></div>';
						}

						// Title and content specified
						else {

							// New post args
							$post_args = array(
								'post_title' => apply_filters( 'the_title', $_POST['title'] ), // заголовок записи
								'post_content' => apply_filters( 'the_content', $_POST['content'] ), // контент записи
								'post_status' => 'pending', // статус публикуемой записи
								'post_author' => $current_user->ID,//1, // автор записи
								'post_category' => array( $_POST['category'] ) // категоия записи
							);

							include (TEMPLATEPATH . "/lib/pages/ad_post_meta.php");

							foreach ($meta_keys as $v) {
								if ( isset($_POST[$v])) {
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
	if ( $_GET['action'] == '3' && current_user_can( 'administrator' ) ) {

	} else {
	?>	
	<?php 
		include (TEMPLATEPATH . '/widget_ready_areas.php');
	}	
get_footer(); 
?>