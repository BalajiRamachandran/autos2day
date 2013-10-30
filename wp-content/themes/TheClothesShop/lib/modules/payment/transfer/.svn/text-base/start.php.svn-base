<?php
echo "
<form class='order_now' method='post' action='?orderNow=4' target='_top'>
	<input type='hidden' name='item_name' value='$Your_Order - $date_order' />
	<input type='hidden' name='amount' value='$TOTAL_AM' />
	<input type='hidden' name='currency_code' value='";echo $OPTION['wps_currency_code']; echo "' />
	<div class='shopform_btn pay_now'> 
		<input type='image'  name='add' src='"; echo get_bloginfo('stylesheet_directory'); echo"/images/pay_now.png' />
	</div>	
</form>	
<br/>
<br/>
<span class='error order_remark'>". __('Remark','wpShop') . ": <u>$LANG[dont_close_browser_1]</u> $LANG[dont_close_browser_2]</span> 
";
?>