<?php
/*
*	upgrade voucher table
*	when visitor field does not exist add to table.
*
*/

function upgrade_voucher_table() {
	global $log;
	$table = "wp_wps_ad_vouchers";
	$sql = "SHOW COLUMNS FROM $table";
	$result = mysql_query($sql);
	$fieldExists = false;
	$fields['phone'] = false;
	$fields['visitor'] = false;
	while ( $row = mysql_fetch_object($result)) {
	    if ( $row->Field == 'visitor' ) {
			$log->general("Visitor field exist!");
	        $fields['visitor'] = true;
	    }
	    if ( $row->Field == 'phone_no' ) {
			$log->general("Phone No field exist!");
	        $fields['phone'] = true;
	    }
	}
	if ( ! $fields['visitor'] ) {
		$log->general("Visitor field do not exist!");
	    $sql = "ALTER TABLE $table ADD `visitor` VARCHAR(100) NOT NULL AFTER `email`";
		$log->general($sql);
		$result = mysql_query($sql);
		$log->general("Visitor field: " . mysql_affected_rows());

		if ( mysql_error()) {
			$log->general(__LINE__ . ' ' . mysql_error());
			die( "System Error, Please try again!" );
		}
	}	
	if ( ! $fields['phone'] ) {
		$log->general("Phone field do not exist!");
	    $sql = "ALTER TABLE $table ADD `phone_no` VARCHAR(100) NOT NULL AFTER `visitor`";
		$log->general($sql);
		$result = mysql_query($sql);
		$log->general("Phone field: " . mysql_affected_rows());

		if ( mysql_error()) {
			$log->general(__LINE__ . ' ' . mysql_error());
			die( "System Error, Please try again!" );
		}
	}	
	$log->general("table upgrade compelted!");
}

function prepare_vouchers() {
	global $dealership_id;
	global $post_vin;
	global $email_address;

}

function get_restricted_fields () {
	return array ('user_url', 'user_registered', 'user_activation_key', 'user_pass', 'user_status', 'user_login', 'user_nicename', 'display_name');
}

function get_field_desc () {
	return array (
		'dealership_id' => 'Dealership ID', 
		'dealership_name'	=>	'Dealership Name', 
		'user_activation_key' => '', 
		'user_pass' => '', 
		'user_status' => ''
	);
}

function get_dealer_emails ( $dealer ) {
	$meta = get_user_meta ( $dealer, '', false);
	$emails = array();
	foreach ($meta as $key => $value) {
		if ( strpos($key, 'email') === false ) {
		} else {
			array_push($emails, $value[0]);
		}
	}
	return implode(', ', $emails);
}

function get_current_user_info() {
	global $current_user;
	if ( empty($current_user)) {
		$current_user = get_currentuserinfo();
	}
	return $current_user;
}

function my_custom_post_status(){
	register_post_status( 'Archive', array(
		'label' => _x( 'Archive', 'post' ),
		'public' => false,
		'internal'    => true,
		'exclude_from_search' => false,
		'show_in_admin_all_list' => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Archive <span class="count">(%s)</span>', 'Archive <span class="count">(%s)</span>' ),
	) );
	// register_post_status( 'approved', array(
	// 	'label'       => _x( 'Approved', 'post' ),
	// 	'internal'    => true,
	// 	'_builtin'    => true, /* internal use only. */
	// 	'label_count' => _n_noop( 'Approved <span class="count">(%s)</span>', 'Approved <span class="count">(%s)</span>' ),
	// 	'show_in_admin_status_list' => true,
	// 	'exclude_from_search' => false,
	// ) );

}
add_action( 'init', 'my_custom_post_status' );

?>