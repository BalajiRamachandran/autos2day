<?php
include_once('functions.php');
expulsion_needed();

$PDT_DATA = banktransfer_response(); 


if(pdf_usable_language()){
				$bill_format_label = __('Your Bill in PDF Format','wpShop');
}else{
				$bill_format_label = __('Your Bill in HTML Format','wpShop');					
}

echo order_step_table(4);
echo"<h2>".__('Thank you for your order!','wpShop')."</h2>";

echo "<h4>";
	echo _e('Please have the Amount of ','wpShop'); 
	echo "<span class='pay_amount'>"; 
		if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($_POST[amount]); if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
	echo "</span>"; _e(' to our Bank Account using the following information:','wpShop');
echo "</h4>";

echo "
	<table>
		<tr><td>". __('Name of Recipient:','wpShop') . "</td><td>"; echo $OPTION['wps_banktransfer_account_owner']; echo "</td></tr>
		<tr><td>". __('for:','wpShop')."</td><td>$_POST[item_name]</td></tr>
		<tr><td>". __('Name of Bank:','wpShop')."</td><td>"; echo $OPTION['wps_banktransfer_bankname']; echo "</td></tr>
		<tr><td>". __('Routing Number:','wpShop')."</td><td>"; echo $OPTION['wps_banktransfer_bankno']; echo "</td></tr>
		<tr><td>". __('Account Number:','wpShop')."</td><td>"; echo $OPTION['wps_banktransfer_accountno']; echo "</td></tr>
		";
		$iban 	= $OPTION['wps_banktransfer_iban'];
		$bic 	= $OPTION['wps_banktransfer_bic'];
		if(!empty($iban)){
		echo "<tr><td>IBAN:</td><td>"; echo $OPTION['wps_banktransfer_iban']; echo "</td></tr>";
		}
		if(!empty($bic)){				
		echo "<tr><td>BIC/SWIFT:</td><td>"; echo $OPTION['wps_banktransfer_bic']; echo "</td></tr>";
		}
echo "</table><br/><br/>						
	<p>".__('When we have Received your Payment on our Account, we will begin to Process your Order.','wpShop')."</p>";

echo "<h4>".__('Print your Order?','wpShop')."</h4>
<p><a href='index.php?display_invoice=1&invoice={$PDT_DATA[pdf_bill]}' target='_blank'>$bill_format_label</a></p>";

$shop_slug = $OPTION['wps_shop_slug'];
if(strlen($shop_slug) > 0){
	echo "<h5>".__('Like to Continue Shopping?','wpShop')." <a href='category/"; echo $OPTION['wps_shop_slug']; echo "'>".__('Click here.','wpShop')."</a></h5>";					
}else{
	echo "<h5>".__('Like to Continue Shopping?','wpShop')." <a href='".get_real_base_url('force_http')."'>".__('Click here.','wpShop')."</a></h5>";					
}

$custom_tracking = $OPTION['wps_custom_tracking'];
if($custom_tracking !=''){
	echo $custom_tracking;
}
?>