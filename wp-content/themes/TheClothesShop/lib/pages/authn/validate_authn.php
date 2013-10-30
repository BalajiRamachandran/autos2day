<?php

session_start();

include_once ( dirname(__FILE__) . '/authn_vars.php');
// include_once ( dirname(__FILE__) . "/authn_util.php");


$log = load_what_is_needed ("log");
$xml = load_what_is_needed ("xml");

$AUTH_NET_PROFILE = get_user_meta ($user->ID, $authorize_net_variables['AUTH_NET_PROFILE'], true);

$customerArea = get_page_by_title(get_option('wps_customerAreaPg'));

if ( ! isset ( $AUTH_NET_PROFILE ) || strlen($AUTH_NET_PROFILE) == 0) {
	$redirect_url = get_permalink($customerArea->ID);		
	$log->general (__LINE__ . "\t" . __FILE__ . "redirecting.....1");
	header("Location: $redirect_url?myaccount=1&action=4&noauth=true");						
	exit(NULL);												
} else {
	$parsedresponse = retrieve_customer_profile( $AUTH_NET_PROFILE );
	$paymentProfiles = retrieve_payment_profiles( $user );
	if ( strpos($paymentProfiles, "<customerPaymentProfileId") === false ) {
		$redirect_url = get_permalink($customerArea->ID);		
		header("Location: $redirect_url?myaccount=1&action=4&nopayment=".$AUTH_NET_PROFILE."&l=".strlen($paymentProfiles));						
		exit(NULL);														
	} else {
	}
}

?>