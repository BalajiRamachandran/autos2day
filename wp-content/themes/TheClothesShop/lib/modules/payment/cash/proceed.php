<?php	
include_once('functions.php');
expulsion_needed();

$CAS_DATA = cas_response();

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
	echo "</span>"; _e(' ready when Collecting your Order at:','wpShop');
echo "</h4>";
// we provide address
echo "
	<table>
		<tr><td><b>"; echo $OPTION['wps_shop_name']; echo "</b></td></tr>
		<tr><td>"; echo $OPTION['wps_shop_street']; echo "</td></tr>
		<tr><td>"; echo $OPTION['wps_shop_province']; echo "</td></tr>
		<tr><td>"; echo $OPTION['wps_shop_zip']; echo ' '; echo $OPTION['wps_shop_town']; echo "</td></tr>
		<tr><td>"; echo get_countries(2,$OPTION['wps_shop_country']); echo "</td></tr>
		<tr><td>&nbsp;</td></tr>				
		<tr><td>". __('for:','wpShop')." $CAS_DATA[itemname]</td></tr>
		<tr><td>". __('Tracking-ID:','wpShop')."  $CAS_DATA[tracking_id]". __('mention this at Pick-up','wpShop')."</td></tr>
		";

echo "</table><br/><br/>";

// if there this is a google map link we show it
$maplink = $OPTION['wps_google_maps_link'];
	
if(strlen($maplink) > 5){
	echo "<h4>".__('Our Location','wpShop')."</h4>";
	echo "<a href='$maplink' target='_blank'>".__('Google Maps - How to Find us','wpShop')."</a><br/><br/>";
	}
		
echo "<h4>".__('Print your Order?','wpShop')."</h4>
<p>
	<a href='index.php?display_invoice=1&invoice={$CAS_DATA[pdf_bill]}' target='_blank'>$bill_format_label</a>			
</p>
";

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