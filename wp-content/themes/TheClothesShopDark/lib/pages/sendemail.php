<?php
	require_once dirname(__FILE__) . '/../../../../../wp-load.php';
	if ( count($_GET) > 3 ) {
		// print_r($_GET);
		// https://bramkaslp01/autos2day/wp-content/themes/TheClothesShopDark/lib/pages/sendemail.php
		// ?subject=Re%3A+2002+FORD+Mustang+on+Autos2Day.com
		// &to=&dealer=1&contact_name=BALAJI+RAMACHANDRAN&contact_email=vouchers1%40bramkas.com&phoneno=5406322554&comments=aaa
		return prepare_email ( $_GET );
	} 
	function prepare_email ( $obj ) {
		$dealer = $obj['dealer'];
		$to = $obj['to'];
		$name = $obj['contact_name'];
		$subject = $obj['subject'];
		$message = $obj['comments'];
		$message .= "<br/>From: " . $name . "<br/>Email: " . $obj['contact_email'] . "<br/>Phone: " . $obj['phoneno'];  
		$headers 		= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers 		.= "from: " . get_bloginfo('name') . " <" . get_option('admin_email') . ">\r\n";
		$headers 		.= "cc: " . get_bloginfo('name') . " <" . get_option('cc_admin_email') . ">\r\n";
		$headers 		.= "cc: " . get_dealer_emails ( $dealer ) . "\r\n";
		wp_mail($to, $subject, $message, $headers);
		echo "<b>You message has been sent!</b>";
	}
?>