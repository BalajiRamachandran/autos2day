<?php

/* setup cron job */
   include dirname(__FILE__) . '/../../../wp-load.php';
   include (TEMPLATEPATH . "/lib/pages/get_posts_list.php");	

	$log = load_what_is_needed ("log");
	if ( get_option("wps_expire_deals") == 'false') {
		$args['post_status'] = array ('pending', 'approved');
	} else {
		$args['post_status'] = array ('pending', 'approved', 'publish');		
	}
	$loghtml = new stdClass;
	$loghtml->args = (object) $args;
	$loghtml->Expire_Deals = get_option("wps_expire_deals");
	$myposts = get_posts( $args );
	echo "\r\n***************************\r\n";
	echo 'Total Deal to Process: ' . count ( $myposts ) . "\r\n";
	echo "\r\n***************************\r\n";

	foreach( $myposts as $post ) :	setup_postdata ( $post );
	$loghtml->deals->{"P" . $post->ID}->Status = $post->post_status;
	$loghtml->deals->{"P" . $post->ID}->Submitted_Date = $post->post_date;
	$loghtml->deals->{"P" . $post->ID}->Expiration_Date = get_post_meta ($post->ID, "expiration-time", true);
	$loghtml->deals->{"P" . $post->ID}->Deal_Date = get_post_meta ($post->ID, "deal-date", true);
	$post_meta			= get_post_custom ( $post->ID );
	echo "\r\n***************************\r\n";
	echo 'Deal ID: ' . $post->ID . "\r\n";
	echo 'Deal Status: ' . $post->post_status . "\r\n";
	echo 'Deal Post Date: ' . $post->post_date . "\r\n";
	echo 'Deal Exp Date: ' . get_post_meta ($post->ID, "expiration-time", true) . "\r\n";
	echo 'Deal Deal Date: ' . get_post_meta ($post->ID, "deal-date", true) . "\r\n";
	echo "Expire Deals: " . get_option("wps_expire_deals") . "\r\n";

	$_post_date = $post->post_date;
	validate_exp_deal_date ( $post->ID, $post->post_date, true );
	$return = validate_deal_date ( $post_meta );
	$loghtml->deals->{"P" . $post->ID}->Deal_Validation = $return;
	echo 'Deal Validation: ' . $return . "\r\n";
	$authn_id = $post->ID;
	$skip_update = 'none';
	switch ($return) {
		case 'deal':
			if ( $post->post_status == "approved" ) {
				$post->post_status = "publish";
				$loghtml->deals->{"P" . $post->ID}->Deal_Status_Change = "publish";
				$log->general ("Publishing post: " . $post->ID, "auto_cron_" );
				// wp_update_post ( $post );
			} elseif ($post->post_status == "pending") {
				if ( get_option("wps_expire_deals") == 'false') {
					$loghtml->deals->{"P" . $post->ID}->Deal_Status_Change = "skipped";
					echo 'Skipping Expirinig Deal: ' . "\r\n";
				} else {
					$post->post_status = "expired";
					$loghtml->deals->{"P" . $post->ID}->Deal_Status_Change = "expired";
					$log->general ("Expiring post: " . $post->ID , "auto_cron_" );				
					update_post_meta ( $_post->ID, "rejected_date", date('Y-m-d H:m:s'));	
					ad_deal_notifications ( get_post_custom ($post->ID), 'rejected', get_user_meta ( $post->post_author ), $post->post_author );
					// wp_update_post ( $post );					
				}
			}
			break;
		case 'future':
			$skip_update = 'yes';
			unset ( $_post_date);
			$log->general ("Retaining future post: " . $post->ID , "auto_cron_" );
			$loghtml->deals->{"P" . $post->ID}->Deal_Status_Change = "future - skipped";
			break;
		case 'expired':
			echo 'Processing : ' . $return . "\r\n";
			echo 'Status : ' . $post->post_status . "\r\n";
			if ( $post->post_status == "approved" || $post->post_status == "publish" ) {		
				if ( get_option("wps_expire_deals") == 'false') {
					echo 'Skipping Expirinig Deal: ' . "\r\n";
					$loghtml->deals->{"P" . $post->ID}->Deal_Status_Change = "skipped";
				} else {
					$log->general ("Expiring Published post: " . $post->ID , "auto_cron_" );
					echo "Setting to : expired\r\n";
					$post->post_status = "expired";
					$loghtml->deals->{"P" . $post->ID}->Deal_Status_Change = "expired";
					// wp_update_post ( $post );									
				}		
			} elseif ( $post->post_status == "pending" ) {
				if ( get_option("wps_expire_deals") == 'false') {
					echo 'Skipping Expirinig Deal: ' . "\r\n";
					$loghtml->deals->{"P" . $post->ID}->Deal_Status_Change = "skipped";
				} else {
					$post->post_status = "expired";
					echo "Rejecting Deal\r\n";
					echo "Setting to : expired\r\n";
					$loghtml->deals->{"P" . $post->ID}->Deal_Status_Change = "rejected";
					$log->general ("Rejecting post: " . $post->ID , "auto_cron_" );
					update_post_meta ( $post->ID, "rejected_date", date('Y-m-d H:m:s'));	
					$trans_mode = "void";
					$loghtml->deals->{"P" . $post->ID}->Transaction_Mode = $trans_mode;
					try {
						include (STYLESHEETPATH . "/lib/pages/ad_authorize_payment.php");			
					} catch ( Exception $e ) {
						if ( $debug ) {
							print_r($e);
						}
						$log->general ( __LINE__ . "\t: " . implode('|', (array) $e) , "auto_cron_" );
						echo "Transaction Failure: ";
						$loghtml->deals->{"P" . $post->ID}->Transaction_Status = $e->getMessage();
						echo $e->getMessage() . "\r\n";
					}				
					ad_deal_notifications ( get_post_custom ($post->ID), 'rejected', get_user_meta ( $post->post_author ) );
					// wp_update_post ( $post );
				}
			}
			break;
		default:
			# code...
			break;
	}
	if ( $_post_date && $skip_update == 'none') {
		echo "Check Date Update: [" . $post->ID . "] and date: [" . $_post_date . "] " . $skip_update . "\r\n";
		$post->post_date = $_post_date;
		wp_update_post ( $post );
		$loghtml->deals->{"P" . $post->ID}->Update_Deal_Date_Again = $post->post_date;		
	}
	echo 'Deal Post Date: ' . $post->post_date . "\r\n";	
	endforeach;
	$xml = load_what_is_needed ("xml");
	// echo $xml->generate_valid_xml_from_array($loghtml, 'cronjob', 'deal');

?>