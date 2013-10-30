<?php

require_once (dirname(__FILE__) . '/../../lib/engine/cart_actions.php');
if (isset($_GET['voucher']) && strlen($_GET['voucher']) > 0 ) {
	$VOUCHER = load_what_is_needed('voucher');
	$VOUCHER->retrieve_voucher_pdf ( $_GET['voucher'] );
}

?>