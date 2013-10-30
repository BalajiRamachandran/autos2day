<?php
$lc = (WPLANG != 'se_SV' ? substr(WPLANG,3,2) : strtoupper(substr(WPLANG,0,2))); 	
// customer will get paypal's payment page in shops language
// conditional b'c se_SV would be confused with Spanish in El Salvador

$who = NWS_encode($_SESSION['cust_id']);	

echo "<br/>
<form class='order_now' method='post' action='https://www.paypal.com/cgi-bin/webscr' target='_top'>
<input type='hidden' name='cmd' value='_xclick' />
<input type='hidden' name='business' value='"; echo trim($OPTION['wps_paypal_email']); echo "'/>
<input type='hidden' name='item_name' value='$Your_Order - $date_order' />
<input type='hidden' name='amount' value='$TOTAL_AM' />
<input type='hidden' name='currency_code' value='";echo $OPTION['wps_currency_code']; echo "' />
<input type='hidden' name='quantity' value='1' />
<input type='hidden' name='custom' value='$who' />	
<input type='hidden' name='first_name' value='$order[f_name]' />
<input type='hidden' name='last_name' value='$order[l_name]' />
<input type='hidden' name='address_street' value='$order[street]' />				
<input type='hidden' name='address_zip' value='$order[zip]' />
<input type='hidden' name='address_city' value='$order[town]' />
<input type='hidden' name='address_state' value='$order[state]' />	
<input type='hidden' name='address_country' value='$order[country]' />
<input type='hidden' name='no_shipping' value='1' />
<input type='hidden' name='lc' value='$lc' />
		
<input type='hidden' name='bn'  value='ButtonFactory.PayPal.001' />
	<div class='shopform_btn pay_now'>
		<input type='image'  name='add' src='"; echo get_bloginfo('stylesheet_directory'); echo"/images/pay_now.png' />
	</div>
</form>	
<br/>
<br/>
<span class='error order_remark'>". __('Remark','wpShop') . ": <u>$LANG[dont_close_browser_1]</u> $LANG[dont_close_browser_2]</span> 
";
?>