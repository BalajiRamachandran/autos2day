<?php
include '../../../../../wp-load.php';	
get_currentuserinfo();
global $user_level;
global $voucher_code;

if($user_level != 10) {
	$url = get_option('siteurl') . '/wp-login.php';
	header("Location: $url");exit();
}
ob_end_clean();
$VOUCHER = load_what_is_needed('voucher');
$VOUCHER->create_pdf(is_dbtable_there('ad_vouchers'),$OPTION['wps_pdf_voucher_bg'],$OPTION['wps_pdfFormat']);					
?>