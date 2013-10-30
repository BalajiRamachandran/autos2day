<?php
$wps_shop_mode = $OPTION['wps_shop_mode'];
switch($wps_shop_mode){

	case 'affiliate_mode':
	break;
	
	case 'payloadz_mode':

		if($OPTION['wps_payloadz_viewcart_option'] == 'img'){
			echo "
			<a href='http://www.payloadz.com/go/view_cart.asp?id_user=".$OPTION['wps_payloadz_viewcart_id']."' target='paypal'>
			<img src='".$OPTION['wps_payloadz_viewcart_imglink']."' border='0'></a>
			";
		}else{
			echo "<a href='http://www.payloadz.com/go/view_cart.asp?id_user=".$OPTION['wps_payloadz_viewcart_id']."' target='paypal'>".
			__('View Cart','wpShop')."</a>";		
		}
		
	break;
	
	default:
		if($OPTION['wps_br_yes']) {$connective="<br/>";} else {$connective=": ";}
		if($wps_shop_mode =='Inquiry email mode'){ $basket =$OPTION['wps_pgNavi_inquireOption']; } else { $basket =$OPTION['wps_pgNavi_cartOption']; }
		$empty_message = "<span><img src='".NWS_bloginfo('stylesheet_directory')."/images/".$OPTION['wps_shopping_icon']."' alt='".$basket."'/>".$basket.$connective.__('0 items','wpShop')."</span>";
		 
		if(!isset($_GET['confirm'])){
			$CART = show_cart();
			if($CART[status] == 'filled'){
				$basket_url = get_option('home').'?showCart=1&cPage='. current_page(4);
				echo "<a href='$basket_url'><img src='".NWS_bloginfo('stylesheet_directory')."/images/".$OPTION['wps_shopping_icon']."' alt='".$OPTION['wps_pgNavi_cartOption']."'/>";
				
					if($wps_shop_mode =='Inquiry email mode'){ $basket =$OPTION['wps_pgNavi_inquireOption']; } else { $basket =$OPTION['wps_pgNavi_cartOption']; }
					if($OPTION['wps_br_yes']) {$connective="<br/>";} else {$connective=": ";}
					if($CART['total_item_num'] == '1'){$item = ' '.__('item','wpShop');} else {$item = ' '.__('items','wpShop');}	
					
					
					echo $basket.$connective.$CART['total_item_num'].$item;
					if($OPTION['wps_totalItemValue_enable']) { 
						echo "<br/>".__('Total','wpShop').": ";
						if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($CART['total_price']); 
						if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
						if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
					}
					
				echo "</a>";	
			}
			else {		
				echo $empty_message;
			}	
		}
		else {
			echo $empty_message;
		}

	break;
}
?>