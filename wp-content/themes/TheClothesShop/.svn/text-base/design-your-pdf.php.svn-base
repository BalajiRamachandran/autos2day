<?php
include '../../../wp-load.php';

$INVOICE 	= load_what_is_needed('invoice');			
$table		= is_dbtable_there('orders');
$qStr 		= "SELECT * FROM $table WHERE level = '4' ORDER BY oid DESC LIMIT 0,1";
$res 		= mysql_query($qStr);
$order 		= mysql_fetch_assoc($res);


if($order != FALSE) {
	$path 		= $INVOICE->make_pdf($order,'bill',1);		

	echo "<p>1. Adjust your settings under your <strong>'Theme Options > Shop > PDF / HTML Invoices & Vouchers'</strong></p>";
	echo "<p><a href='$path' target='_blank'>2. Please refresh the page (press F5) and then click here on this link to see your changes in the PDF</a></p>";

} else {
	echo "<p><strong>Please complete one test order!</strong></p>";
}
?>