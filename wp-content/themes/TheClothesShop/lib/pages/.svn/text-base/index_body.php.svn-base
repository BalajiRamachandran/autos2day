<?php
	// show the shopping cart
	if($_GET['showCart'] == '1'){					
						
		$CART 						= show_cart();
		
		if($OPTION['wps_shop_mode'] =='Inquiry email mode'){
			$LANG['your_shopping_cart']	= __('Your Items for Enquiry','wpShop');
			$LANG['cart_empty'] 		= __('You have Added no Enquiries!','wpShop');	
			$LANG['continue_shopping'] 	= __('Continue Browsing','wpShop');	
			$LANG['start_shopping'] 	= __('Start Browsing','wpShop');	
			$LANG['order_now'] 			= __('Inquire Now','wpShop');			
		}else{
			$LANG['your_shopping_cart']	= $OPTION['wps_pgNavi_cartOption'];
			$LANG['cart_empty'] 		= str_replace("%s",$OPTION['wps_pgNavi_cartOption'], __('Your %s is Empty!','wpShop'));	
			$LANG['continue_shopping'] 	= __('Continue Shopping','wpShop');	
			$LANG['start_shopping'] 	= __('Start Shopping','wpShop');			
			$LANG['order_now'] 			= __('Order Now','wpShop');
		}			
		$LANG['article'] 				= __('Item','wpShop');
		$LANG['amount'] 				= __('Quantity','wpShop');
		$LANG['unit_price'] 			= __('Item Price','wpShop');
		$LANG['total'] 					= __('Item Total','wpShop');
		$LANG['remove'] 				= __('Remove','wpShop');			
		$LANG['subtotal_cart']			= __('Subtotal:','wpShop');
		$LANG['incl']					= __('incl.','wpShop');
		$LANG['excl']					= __('excl.','wpShop');
		$LANG['shipping_costs']			= $OPTION['wps_shippingInfo_linkTxt'];
		$LANG['update'] 				= __('Update','wpShop');	
		$LANG['shipping_fee_1']			= __('Shipping','wpShop');		
		
		
		// stock control warning 
		if((isset($_GET['sw']))&&(!empty($_GET['sw'])) && (strpos($_GET['sw'],'OK')=== FALSE)){
		
		$fb1 		= str_replace("%s",$OPTION['wps_pgNavi_cartOption'], __('We are sorry but due to Limited Availibility you can Only Add %amount% more Items of Article %article% into your %s','wpShop'));
		$fb2 		= __('We are sorry but Article %article% is Out of Stock.','wpShop');
		
		$stock_note = NULL;
		$parts 		= explode(",",$_GET['sw']);
		
			foreach($parts as $v){
				$items 		= explode("-",$v);		
				$iid 		= cid2item_id($items[0]);
				
				if(strlen($items[1])>0){
					$fb = ($items[1] == 0 ? $fb2 : $fb1);	
					$stock_info = str_replace('%article%',$iid,$fb);	
					$stock_info = str_replace('%amount%',$items[1],$stock_info);	
					$stock_note .= $stock_info."<br/>";
				}
			}
			echo "<p class='failure'>$stock_note</p>";
		}

		if($OPTION['wps_shop_mode']=='Inquiry email mode'){ $form_class = 'order_form c_order inquiry_form'; } else {$form_class = 'order_form c_order';}		
		

			// moved to wishlist - feedback 
			if($_GET['wltransfer'] == 'OK'){
				$customerArea	= get_page_by_title($OPTION['wps_customerAreaPg']);
				$wishlist_url = get_permalink($customerArea->ID)."?myaccount=1&action=3"; ?>
				<div class='success'><?php printf(__ ('Your item has been successfully moved to your %s!', 'wpShop'), $OPTION['wps_wishListLink_option'])?><a href="<?php echo $wishlist_url;?>"><?php printf(__ (' View %s','wpShop'), $OPTION['wps_wishListLink_option'])?></a></div>
			<?php }
							
		if($CART[status] == 'filled'){	
			echo "
			
			<form class='$form_class' action='?showCart=1' style='margin-top: 0px;' method='post'>";
		}
		
				display_html('shopping_cart_header',$LANG);				
						
					if($CART[status] == 'filled'){
						$relatedData = loop_products($CART);						
					}
					else {
						display_html('shopping_cart_empty',$LANG);	
					}
			
		
			if($CART[status] == 'filled'){	
				echo "
					<tr class='sums'>
						<td colspan='4' style='text-align:right;'>
							<b>$LANG[subtotal_cart]</b>";				
								
								echo " <br/><br/><span> "; 
								if($OPTION['wps_tax_info_enable']){
									show_cart_tax_info();
								}
								
								$cart_comp = cart_composition($_SESSION['cust_id']);
		
								switch($cart_comp){
								
									case 'digi_only':
										echo "</span>";
									break;
									
									case 'mixed':
										if($OPTION['wps_tax_info_enable'] && $OPTION['wps_shipping_details_enable']){
											echo ",";
										}
										if($OPTION['wps_shipping_details_enable']) {
											echo "$LANG[excl]	<a rel='div.overlay:eq(2)' href='#' title='' >$LANG[shipping_costs]</a>";
										}
										
										echo "</span>";
										
										if($OPTION['wps_shipping_details_enable']) {
											echo "
											<div id='handlingInfoOverlay' class='overlay'>
												<h2>$LANG[shipping_costs]</h2>
												<div>"; echo $OPTION['wps_shipping_details'];"</div>
											</div>";
										}					
									break;	
									
									case 'digi_none':
										if($OPTION['wps_tax_info_enable'] && $OPTION['wps_shipping_details_enable']){
											echo ",";
										}
										
										if($OPTION['wps_shipping_details_enable']) {
											echo "$LANG[excl]	<a rel='div.overlay:eq(2)' href='#' title='' >$LANG[shipping_costs]</a>";
										}
										
										echo "</span>";
										
										if($OPTION['wps_shipping_details_enable']) {
											echo "
											<div id='handlingInfoOverlay' class='overlay'>
												<h2>$LANG[shipping_costs]</h2>
												<div>"; echo $OPTION['wps_shipping_details'];"</div>
											</div>";
										}	
									break;			
								}
																			
						echo "
						</td>
						<td><b>"; if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(sprintf("%01.2f",$CART[total_price]))."</b></td>
						<td><b>"; if($OPTION['wps_currency_code_enable']) { echo $OPTION['wps_currency_code']; } if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } echo "</b></td>
						<td>&nbsp;</td>
					</tr>
				</table>
				
				<input class='update_cart'  type='submit' name='update' value='' />
				
			</form>
		
			<a class='cartActionBtn cont_shop' href='$_SESSION[cPage]'>$LANG[continue_shopping]</a>
			<form action='".get_real_base_url($OPTION['wps_enforce_ssl'])."?orderNow=1' id='proceed2Checkout' 
			style='margin-top: 0px;' method='post'>		
				<div class='shopform_btn'>	
					<input class='checkout' type='image'  name='checkout' src='";echo get_bloginfo('stylesheet_directory');echo "/images/checkout.png' />
				</div>
			</form>
			";
		
			
		} else {
			echo "</table>";
		}
		
		// related products here - if any
		if(($OPTION['wps_cartRelatedProds_enable'])&&(!empty($relatedData[related]))){ ?>		
			<div class="shoppingCartRelated clearfix">
				<h2><?php _e('You may also be interested in:','wpShop');?></h2>
					<?php echo retrieve_related_products($relatedData[related],$relatedData[pids]);?>
			</div>
		<?php }
	}
	elseif($_GET['orderNow'] == '1'){		
	
		$LANG['choose_delivery_option'] 	= __('Select Delivery Option:','wpShop');
		$LANG['choose_payment_option'] 		= __('Select Payment Option:','wpShop');
		$LANG['enter_voucher'] 				= __('Enter Voucher Code','wpShop');
		$LANG['choose_delivery_country'] 	= __('Select Delivery Country:','wpShop');
		$LANG['next_step'] 					= __('Next Step','wpShop');
	
		$order_level = what_order_level();
		if($order_level == 2){
	
			$dpch 	= delivery_payment_chosen();
			$go 	= '3&dpchange=1';
		}
		else{
			$go 	= '2';
			$dpch 	= 'none';
		}
		
	
		echo order_step_table(1);
		
		if($OPTION['wps_shop_mode'] == 'Inquiry email mode')
		{
			echo "<p class='info'>";
	
			_e('This Website will send your Order first as an <strong>Email Enquiry</strong> to us. However, for an exact calculation of all necessary costs, please select your preferred Delivery and Payment Option below.','wpShop');
	
			echo "</p>";
		}
		
		// removed <br/>
		echo "
		<form class='step1 checkoutSteps' action='?orderNow={$go}' method='post'>";
			
			//display delivery options
			echo "<div id='editDelivery' class='editCont c_box c_box_step1 c_box_d top_row c_box_first'>
				<h4>$LANG[choose_delivery_option]</h4>";
			
				$cart_comp = cart_composition($_SESSION[cust_id]);
				
				switch($cart_comp){
				
					case 'digi_only':	
						$label 		= __('Digital Goods','wpShop');
						$label_info = __('You will receive your Download Links on this Website right after your Payment has been Successfully Completed','wpShop');
						echo "
						<p class='info'>$label_info</p>
						<input type='radio' name='d_option' value='download' checked='checked' /><label>$label</label>
						";
					break;
			
					case 'mixed':
						$label_info = __('You will receive your Download Links on this Website right after your Payment has been Successfully Completed','wpShop');
						$d_labels			= array();
						$d_labels[pickup]	= $OPTION['wps_pickUp_label'];
						$d_labels[post]		= $OPTION['wps_delivery_label'];
						#$d_labels[email]	= $OPTION['wps_emailDelivery_label'];
						
						echo "<p class='info'>$label_info</p>";
						echo get_delivery_options($d_labels,$dpch);	
					break;	
					
					case 'digi_none':
						$d_labels			= array();
						$d_labels[pickup]	= $OPTION['wps_pickUp_label'];
						$d_labels[post]		= $OPTION['wps_delivery_label'];
						#$d_labels[email]	= $OPTION['wps_emailDelivery_label'];
						echo get_delivery_options($d_labels,$dpch); 
					break;			
				}
			
			echo "</div>";
			
		
			//display payment options
			echo "<div id='editPayment' class='editCont c_box c_box_step1 c_box_p top_row'>
				<h4>$LANG[choose_payment_option]</h4>";
	
				$p_labels				= array();
				$p_labels[paypal]		= $OPTION['wps_pps_label'];
				$p_labels[paypal_pro]	= $OPTION['wps_ppp_label'];
				$p_labels[transfer]		= $OPTION['wps_bt_label'];
				$p_labels[cash]			= $OPTION['wps_pol_label'];
				$p_labels[cc_authn]		= $OPTION['wps_auth_label'];
				$p_labels[cc_wp]		= $OPTION['wps_wp_label'];
				$p_labels[cod]			= $OPTION['wps_cod_label'] .' '. $OPTION['wps_cod_who_note'];
				
				$p_alt[paypal]			= $OPTION['wps_pps_label'];
				$p_alt[paypal_pro]		= $OPTION['wps_ppp_label'];
				$p_alt[transfer]		= $OPTION['wps_bt_label'];
				$p_alt[cash]			= $OPTION['wps_pol_label'];
				$p_alt[cc_authn]		= $OPTION['wps_auth_label'];
				$p_alt[cc_wp]			= $OPTION['wps_wp_label'];
				$p_alt[cod]				= $OPTION['wps_cod_label'].' '. $OPTION['wps_cod_who_note'];
			
				$p_file_type = "png";
				
				
				echo get_payment_options($p_labels,$p_alt,$p_file_type,$dpch); 
		
		echo "</div>";
		
		echo "<div class='clear'></div>";
	
		$dc	= get_delivery_countries();
		
		//are we using vouchers? display voucher field
		if ($OPTION['wps_voucherCodes_enable']) {
			echo "<div class='voucher_wrap'>
				<h4>$LANG[enter_voucher]</h4>";
		
				$custid = str_rot13($_SESSION[cust_id]);	
				echo "
				<label for='vid'>".__('Voucher / Discount Code: ','wpShop')."</label>
				<input type='text' name='v_no' id='vid' maxlength='50' 
				onkeyup=\"checkVoucher("."'".is_in_subfolder()."','".get_protocol()."','$custid');\" 
				onblur=\"checkVoucher("."'".is_in_subfolder()."','".get_protocol()."','$custid');\" /> 
				<span id='txtHint'></span>"; 
				
			echo "</div>";
		}
		echo "	
		<input class='next_step' type='submit' name='step1' value='' />
		
	</form>";
	
	}
	
	elseif($_GET['orderNow'] == '2'){

		process_order();
		
		$LANG['billing_address'] 			= __('Billing Address:','wpShop');
		$LANG['shipping_address'] 			= __('Delivery Address:','wpShop');
		$LANG['shipping_address_message'] 	= __('Fill In Only If Different From Billing Address','wpShop');
		
		$LANG['lastname'] 			= __('Last Name','wpShop');
		$LANG['firstname'] 			= __('First Name','wpShop');
		$LANG['street_hsno'] 		= __('Address','wpShop');
		$LANG['street']				= __('Street','wpShop');
		$LANG['hsno']				= __('House No.','wpShop');
		$LANG['strno']				= __('Street No.','wpShop');
		$LANG['strnam']				= __('Street Name','wpShop');
		$LANG['po']					= __('Post Office','wpShop');
		$LANG['pb']					= __('Post Box','wpShop');
		$LANG['pzone']				= __('Post Zone','wpShop');
		$LANG['crossstr']			= __('Cross Streets','wpShop');
		$LANG['colonyn']			= __('Colony name','wpShop');
		$LANG['district']			= __('District','wpShop');		
		$LANG['region']				= __('Region','wpShop');			
		$LANG['island']				= __('Island','wpShop');		
		$LANG['state_province'] 	= __('State/Province','wpShop'); 
		$LANG['zip'] 				= __('Postcode','wpShop');
		$LANG['town']				= __('City','wpShop');
		$LANG['country']			= __('Country','wpShop');
		$LANG['email']				= __('Email','wpShop');
		$LANG['telephone']			= __('Telephone','wpShop');		
		$LANG['terms']				= __('Terms &amp; Conditions:','wpShop');
		$LANG['accept_terms']		= __('I accept the Terms &amp; Conditions of','wpShop');
		$LANG['next_step'] 			= __('Next Step','wpShop');		
		$LANG['field_not_empty']	= __(' - Field cannot be Empty.','wpShop');	
		$LANG['format_email']		= __('Your Email Address Format is not Correct.','wpShop');
		$LANG['choose_billing_c']	= __('You must select a country for your Billing Address.','wpShop');
		$LANG['choose_delivery_c']	= __('You must select a country for your Delivery Address','wpShop');
		$LANG['terms_need_accepted']= __('Terms must be Accepted.','wpShop');
		$LANG['wait_for_field'] 	= __('Error: You clicked on "Next" before all fields of the address form were fully loaded.','wpShop'); 
		$LANG['refresh_and_wait'] 	= __('Please <a href="?orderNow=reload_form">click here to refresh the page </a> and wait for the address fields to appear after you have selected your country.','wpShop'); 
		
		$feedback = check_address_form();

	
		if($_SESSION['user_logged'] === TRUE){
			get_member_billing_addr(2);
		}
		
		
		if($_GET['dpchange'] == 1){		//query order+delivery address data
			retrieve_address_data();
		}
		
		echo order_step_table(2);
		
		//get cart composition
		$cart_comp = cart_composition($_SESSION[cust_id]);
		
		echo "
		<form class='step2 checkoutSteps clearfix' action='?orderNow=2' name='step2form' id='step2form' method='post'>";
			echo "<div id='editAddress' class='editCont clearfix'>";		
				// Display Billing Address Form
				echo "<div class='c_box c_box_step2 c_box_first top_row'>
					
					<h4 class='step2'>$LANG[billing_address] </h4>";
					
					echo "
					<label for='firstname'>$LANG[firstname]:</label><input id='firstname' type='text' name='f_name' value='$_POST[f_name]' maxlength='255' /><br/>
					<label for='lastname'>$LANG[lastname]:</label><input id='lastname' type='text' name='l_name' value='$_POST[l_name]' maxlength='255' /><br/>";			
					
					if($cart_comp=='digi_only') {
						if($_GET['option'] != 'billingAddressFE'){
							echo "<label for='email'>$LANG[email]:</label><input  id='email'type='text' name='email' value='$_POST[email]' maxlength='255' /><br/>";
						}

						if($OPTION['wps_checkout_showtel'] == 'Yes'){
							echo "<label for='telephone'>".__('Telephone','wpShop').":</label><input id='telephone' type='text' name='telephone' value='$_POST[telephone]' maxlength='255' /><br/>";
						}
					}
					
					if($cart_comp!='digi_only'){
			
						$dc	= get_delivery_countries();
						
						if($dc['num'] > 0){
						echo "<label>$LANG[country]:</label>";		
						echo "<select name='country' size='1' id='billingCountry' 
							onChange=\"getBaddressForm("."'".is_in_subfolder()."','".get_protocol()."');\">";
								echo "<option value='bc'>".__('-- Select a Country --','wpShop')."</option>";		

								$shop_country 	= get_countries(2,$OPTION['wps_shop_country']);
								$selected 		= ($_POST['country'] == $shop_country ? 'selected="selected"' : NULL);
								echo "<option value='$shop_country' $selected >$shop_country</option>";
								
									while($row = mysql_fetch_assoc($dc['res'])){
									
										if(WPLANG == 'de_DE'){
											$countryName = $row['de'];
										}
										elseif(WPLANG == 'fr_FR'){
											$countryName = $row['fr'];
										}
										else {
											$countryName = $row['country'];
										}
									
										$selected	= ($_POST['country'] == $countryName ? 'selected="selected"' : NULL);
										echo "<option value='$countryName' $selected >$countryName</option>";						
									}
						echo "</select>";
						echo "<input type='hidden' id='editOption' name='editOption' value='billingAddressCT' />";	
						##################################################
					
						echo "<br/><span id='billingAddress'></span>";	// provided by AJAX	
						echo "<br/><span id='billingAddressCheck'>";
							redisplay_address_form();
						echo "</span>";
						}
						else {
							$only_country = get_delivery_countries('no_zone');
							create_address_form('billing',$only_country);
							echo "<label>$LANG[country]:</label>";
							echo "<input id='billingCountry' type='text' name='country' value='$only_country' readonly='readonly' 
							style='background:silver' /><br/><br/>";
							
							
							echo "<label for='email'>$LANG[email]:</label>
							<input  id='email'type='text' name='email' value='$_POST[email]' maxlength='255' /><br/>";							
							
								if($OPTION['wps_checkout_showtel'] == 'Yes'){
									echo "<label for='telephone'>".__('Telephone','wpShop').":</label>
									<input id='telephone' type='text' name='telephone' value='$_POST[telephone]' maxlength='255' /><br/>";
								}
						}
					}
				echo "</div>"; // end Billing Address
					
					
				// Display Delivery Address Form
				$visibility = ($_POST['delivery_address_yes'] == 'on'? 'visible' : 'hidden');
				if($_GET['dpchange'] == 1){		
					$visibility = ($_POST['d_addr'] == '1' ? 'visible' : 'hidden');
				}
				
				echo "<div id='delivery_address' class='c_box c_box_step2 top_row' name='delivery_address' style='visibility: $visibility;'>
					<h4 class='step2'>$LANG[shipping_address]</h4>
					<p>$LANG[shipping_address_message]<br/>$feedback[e_message2]</p>";
					
					##################################################
					
					echo "
					<label for='dfirstname'>$LANG[firstname]:</label><input id='dfirstname' type='text' name='f_name|2' value='".$_POST['f_name|2']."' 
					maxlength='255' /><br/>
					<label for='dlastname'>$LANG[lastname]:</label><input id='dlastname' type='text' name='l_name|2' value='".$_POST['l_name|2']."' 
					maxlength='255' /><br/>";
					
					$dc	= get_delivery_countries();
						
					if($dc['num'] > 0){	
						
						echo "<label>$LANG[country]:</label>";
						echo "<select name='country|2' size='1' id='deliveryCountry'
						onChange=\"getDaddressForm("."'".is_in_subfolder()."','".get_protocol()."');\">";
						echo "<option value='dc'>".__('-- Select a Country --','wpShop')."</option>";	
						
						$shop_country 	= get_countries(2,$OPTION['wps_shop_country']);
						$selected 		= ($_POST['country|2'] == $shop_country ? 'selected="selected"' : NULL);
						
						echo "<option value='$shop_country' $selected >$shop_country</option>";
					
							while($row = mysql_fetch_assoc($dc['res'])){
							
								if(WPLANG == 'de_DE'){
									$countryName = $row['de'];
								}
								elseif(WPLANG == 'fr_FR'){
									$countryName = $row['fr'];
								}
								else {
									$countryName = $row['country'];
								}
								$selected	= ($_POST['country|2'] == $countryName ? 'selected="selected"' : NULL);
								echo "<option value='$countryName' $selected >$countryName</option>";						
							}
						echo "</select>";
						echo "<br/><span id='deliveryAddress'></span>";			
						echo "<br/><span id='deliveryAddressCheck'>";	
							redisplay_address_form('shipping');
						echo "</span>";
					}
					else {
						$only_country = get_delivery_countries('no_zone');
						create_address_form('shipping',$only_country);
						echo "<label>$LANG[country]:</label>";
						echo "<input id='deliveryCountry' type='text' name='country|2' value='$only_country' readonly='readonly' 
						style='background:silver' /><br/>";
					}
			
				echo "</div>"; // end Delivery Address
			
				echo "<div class='clear'></div>";
							
					$checked 	= ($_POST['delivery_address_yes'] == 'on' ? 'checked="yes"' : NULL );
					$visibility = ($_POST['delivery_address_yes'] == 'on' ? 'visible;' : 'hidden;' );
					if($_GET['dpchange'] == 1){
					$checked 	= ($_POST['d_addr'] == '1' ? 'checked="yes"' : NULL );
					$visibility = ($_POST['d_addr'] == '1' ? 'visible;' : 'hidden;' );
					}
					
				if($cart_comp!='digi_only') {	
					echo "
						<div>	
							<label for='delivery_address_yes' onClick='copy_addr_form();'
							style='visibility: $visibility text-decoration: underline;' id='delivery_address_yes'>".__('Copy data to Delivery Address','wpShop')."</label>
							<br/>
							<input type='checkbox' id='display_switch' name='delivery_address_yes' 
							 $checked onClick='display_delivery_address();'/> 
							<label for='delivery_address_yes'>".__('I have a different delivery address.','wpShop')."</label>
						</div>
					";
				}
			echo "</div>"; // end Address Wrap
			
			//display Custom Note if enabled
			if($OPTION['wps_customNote_enable']) {
				echo "<div id='editNote' class='editCont custom_note'>";
					echo "<h4 class='step2'>".$OPTION['wps_customNote_label']."</h4>";
					if($OPTION['wps_customNote_remark'] != '') {
						echo "<p>".$OPTION['wps_customNote_remark']."</p>";
					}
					echo "<textarea name='custom_note' cols='50' rows='10'>".$_POST['custom_note']."</textarea>
				</div>";
			}
			
			//display Terms & Conditions checkbox
			echo "
			<div class='terms_conditions clearfix'>
				<h4 class='step2'>$LANG[terms] </h4>
				<p id='e_message'>$feedback[e_message]</p>
				<input type='checkbox' name='terms_accepted' /> 
				<a rel='div.overlay:eq(2)' href='?showTerms=1' target='_blank'>$LANG[accept_terms] "; 
				echo stripslashes ($OPTION['wps_shop_name']);
				echo ".</a><br/><br/>	
				<input class='next_step' type='submit' name='step2' value='' />
			</div>";
		echo "</form>";
		
		echo "<div id='termsConditionsOverlay' class='largeoverlay overlay'>
			<h2>".__('Terms &amp; Conditions','wpShop')."</h2>
			
			<div class='termsConditionsWrap'>"; echo nl2br($OPTION['wps_terms_conditions']);
			
		echo "</div></div>";
	
				
	}	
	elseif($_GET['orderNow'] == '3'){
						
		$VOUCHER = load_what_is_needed('voucher');
		
		$LANG['delivery'] 				= __('Delivery Option:','wpShop');
		$LANG['payment']				= __('Payment Option:','wpShop');
		$LANG['change'] 				= __('edit','wpShop');
		$LANG['address_data']			= __('Address:','wpShop');
		$LANG['name_email']				= __('Your Name and Email:','wpShop');
		$LANG['comments']				= __('Your Order Comments:','wpShop');
		$LANG['your_order']				= __('Your Order:','wpShop');
		$LANG['article'] 				= __('Item','wpShop');
		$LANG['amount'] 				= __('Quantity','wpShop');
		$LANG['unit_price'] 			= __('Item Price','wpShop');
		$LANG['total'] 					= __('Item Total','wpShop');
		$LANG['subtotal_cart']			= __('Subtotal:','wpShop');
		$LANG['shipping_fee_1']			= __('Shipping:','wpShop');
		$LANG['total_cart']				= __('Order Total:','wpShop');
		$LANG['incl']					= __('incl.','wpShop');
		$LANG['remark'] 				= __('Remark','wpShop');
		$LANG['dont_close_browser_1'] 	= __('Please, do NOT close this Browser Window until you see the Confirmation Page','wpShop');
		$LANG['dont_close_browser_2']	= __('- so that the Order Process can be Completed.','wpShop');		
		
			
		$order 		= process_order(3);
		$CART 		= show_cart();
		$cart_comp 	= cart_composition($_SESSION['cust_id']);	
		
		//get shipping fees
		if($cart_comp != 'digi_only'){  // however the shipping option might be, no shipping for a digital product only 		
			$shipping = calculate_shipping($order['d_option'],$CART['total_price'],$CART['total_weight'],$CART['total_item_num'],$order['country']);
		}
		else {
			$shipping = '0.00';
		}
		
		//get taxes		
		$taxable_amount = (get_option('wps_salestax_onshipping') == 'Yes' ? $CART['total_price'] + $shipping : $CART['total_price']);		
		$tax_data 		= provide_tax_data($order,$taxable_amount);		
		
		//update the order
		if(($order['voucher'] != 'non')&&($VOUCHER->code_exist($order['voucher']))){
					
						$order_am	= (float) $CART['total_price'];
						$vdata 		= $VOUCHER->subtract_voucher($order_am,$order);
					
			$TOTAL_AM	= update_order($CART['total_weight'],$shipping,$CART[total_price],sprintf("%01.2f",$vdata['subtr_am']),$tax_data['amount']);			
		}
		else {
			$TOTAL_AM	= update_order($CART['total_weight'],$shipping,$CART[total_price],NULL,$tax_data['amount']);	
		}
		

		$d_labels			= array();
		$d_labels['pickup']		= __('Pick Up','wpShop');
		$d_labels['post']		= __('Delivery','wpShop');
		$d_labels['download']	= __('You will Receive your Download Links on this Website, after your Payment has been Successfully Completed.','wpShop');
		$d_labels['email']		= __('Delivery by Email','wpShop');
		
		
		$p_labels				= array();
		$p_labels['paypal']		= __('PayPal','wpShop');
		$p_labels['paypal_pro']	= __('Credit Card - PayPal Pro','wpShop');
		$p_labels['transfer']	= __('Bank Transfer in Advance','wpShop');
		$p_labels['cash']		= __('Payment at our Shop','wpShop');
		$p_labels['cc_authn']	= __('Credit Card Authorize.net','wpShop');
		$p_labels['cc_wp']		= __('Credit Card WorldPay','wpShop');
		$p_labels['cod']		= __('Cash on Delivery','wpShop') .' '. $OPTION['wps_cod_who_note'];
		
		echo order_step_table(3); 
		
		// display delivery
		echo "<div class='c_box c_box_step3 c_box_first top_row'>";
			echo "<h4 class='step3'>$LANG[delivery]<a class='formbutton step3_edit' href='?orderNow=1#editDelivery' rel='div.overlay:eq(2)'>
			$LANG[change]</a></h4>";	
			echo "<p>";
				echo $d_labels["$order[d_option]"];
			echo "</p>";			
		echo "</div>";
		
		// display payment
		echo "<div class='c_box c_box_step3 top_row'>";
			echo "<h4 class='step3'>$LANG[payment]<a class='formbutton step3_edit' href='?orderNow=1#editPayment' rel='div.overlay:eq(2)'>
			$LANG[change]</a></h4>";
			echo "<p>";
				echo $p_labels["$order[p_option]"];
			echo "</p>";
		echo "</div>";
		
		// display billing and shipping address
		echo "<div class='c_box c_box_step3 top_row'>";
			if($OPTION['wps_short_addressform']=='not_active'){
				echo "<h4 class='step3'>$LANG[address_data]<a class='formbutton step3_edit' href='?orderNow=2&dpchange=1#editAddress' rel='div.overlay:eq(2)'>$LANG[change]</a></h4>";
			}else{
				echo "<h4 class='step3'>$LANG[name_email]<a class='formbutton step3_edit' href='?orderNow=2&dpchange=1#editAddress' rel='div.overlay:eq(2)'>$LANG[change]</a></h4>";
			}
		
				
			if($order['d_addr'] == '1'){
				echo "<h5>".__('Billing Address','wpShop')."</h5>";
			}else{
				echo "<h5>".__('Billing and Shipping Address','wpShop')."</h5>";
			}
			echo"<p>";
				
				if(($OPTION['wps_short_addressform']=='active') && (cart_composition($_SESSION['cust_id']) == 'digi_only')){	
					echo "$order[l_name] $order[f_name]";
				}
				else {
					echo address_format($order);
				}
				
				echo "<br/>$order[email]";
				if(strlen($order['telephone'])>1){
					echo "<br/>$order[telephone]";		
				}
			echo"</p>";
			
			// if there is a different delivery address then show it 
			//if($address_diff){		
			if($order['d_addr'] == '1'){		
				echo "<h5>".__('Delivery Address:','wpShop')."</h5>";	
				echo "<p>";
					echo address_format(retrieve_delivery_addr(),'d-addr');	
				echo "</p>";
			}
	
		
		echo "</div>";
		echo "<div class='clear'></div>";		
		//display custom note if filled
		if ($order[custom_note] != '') {
			echo "<h4 class='step3'>$LANG[comments]<a class='formbutton step3_edit' href='?orderNow=2&dpchange=1#editNote' rel='div.overlay:eq(2)'>$LANG[change]</a></h4>";
			echo "<p>$order[custom_note]</p>";
		}
		#######################################
		?>
			<script>
				function submitNewQty(formNum){					
					var formK = "qForm-" + formNum;
					document.getElementById(formK).submit();
				}
			</script>
		<?php		
		#######################################
		// display order table
			//echo "<h4 class='step3'>$LANG[your_order]<a class='formbutton step3_edit' href='?orderNow=2&dpchange=1#editOrder' rel='div.overlay:eq(2)'>$LANG[change]</a></h4>";	
			echo "<h4 class='step3'>$LANG[your_order]</h4>";
				
				// stock control warning 
				if((isset($_GET['sw']))&&(!empty($_GET['sw'])) && (strpos($_GET['sw'],'OK')=== FALSE)){
				
				$fb1 		= str_replace("%s",$OPTION['wps_pgNavi_cartOption'], __('We are sorry but due to Limited Availability you can Only Add %amount% more Items of Article %article% into your %s','wpShop'));
				$fb2 		= __('We are sorry but Article %article% is Out of Stock.','wpShop');
				
				$stock_note = NULL;
				$parts 		= explode(",",$_GET[sw]);
				
					foreach($parts as $v){
						$items 		= explode("-",$v);		
						$iid 		= cid2item_id($items[0]);
						
						if(strlen($items[1])>0){
							$fb = ($items[1] == 0 ? $fb2 : $fb1);	
							$stock_info = str_replace('%article%',$iid,$fb);	
							$stock_info = str_replace('%amount%',$items[1],$stock_info);	
							$stock_note .= $stock_info."<br/>";
						}
					}
					echo "<p class='failure'>$stock_note</p>";
				}
	
				display_html('shopping_cart_header');
		
			if($CART[status] == 'filled'){
				loop_products($CART);		
		
				echo "
					<tr class='sums'>
						<td colspan='3' align='right'>
						&nbsp;
						</td>
						<td>$LANG[subtotal_cart]</td>
						<td class='txt_right'>";
							if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($CART[total_price]); 
							if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
							if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
						echo "</td>
					</tr>
				";			
					
				
				// row for voucher, if exist
				if(($order[voucher] != 'non')&&($VOUCHER->code_exist($order[voucher]))){						
					echo "
						<tr class='sums'>
							<td colspan='3'>&nbsp;</td><td>".__('- Voucher:','wpShop')."</td>
							<td class='txt_right'>";
								if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(sprintf("%01.2f",$vdata['subtr_am'])); 
								if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
								if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
							echo "</td> 
						</tr>
					";						
				}		
				
				//row for tax before shipping
				if(($OPTION['wps_tax_info_enable']) && ($tax_data['sameState'] == '1') && ($OPTION['wps_salestax_onshipping'] == 'No')){
					echo "
					<tr class='sums order_total'>
						<td colspan='3' align='right'>&nbsp;
						</td>
						<td>";	
							echo $tax_data['rate']."% ". $OPTION['wps_tax_abbr'] .":";
						echo "	
						</td>
						<td class='txt_right'><span class='total_cart_price'>";
							if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} 
							echo round_tax_amount($tax_data['amount']); 
							if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
							if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
						echo "</span></td>
					</tr>";			
				}
					
				echo "
					<tr class='sums no_border'>
						<td colspan='3'>&nbsp;</td><td>$LANG[shipping_fee_1]</td>
						<td class='txt_right'>";
							if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($shipping); 
							if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
							if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
						echo "</td>
					</tr>
				";
														
				//row for tax after shipping					
				if(($OPTION['wps_tax_info_enable']) && ($tax_data['sameState'] == '1') && (get_option('wps_salestax_onshipping') == 'Yes')){
					echo "
					<tr class='sums order_total'>
						<td colspan='3' align='right'>&nbsp;
						</td>
						<td>";	
							echo $tax_data['rate']."% ". $OPTION['wps_tax_abbr'] .":";
						echo "	
						</td>
						<td class='txt_right'><span class='total_cart_price'>";
							if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} 
							echo round_tax_amount($tax_data['amount']); 
							if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
							if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
						echo "</span></td>
					</tr>";			
				}
														
				echo "
					<tr class='sums order_total'>
						<td colspan='3' align='right'>&nbsp;
						</td>
						<td>
							<b>$LANG[total_cart]</b><br/>";
						// good place for note: all prices do include sales tax
						echo "	
						</td>
						<td class='txt_right'><span class='total_cart_price'>";
							if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(sprintf("%01.2f",$TOTAL_AM)); 
							if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
							if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
						echo "</span></td>
					</tr>
				</table>
				<br/>
				";
			}
		

		
		// Order Date Stamp 
		$date_order = NWS_translate_date();        
		$Your_Order = __('Order No.','wpShop') . $OPTION['wps_order_no_prefix'].$order['oid']; 
		
		// is shop running in inquiry email mode?
		if($OPTION['wps_shop_mode'] == 'Inquiry email mode')
		{
			echo "<br/>
			<form class='inquire_now clearfix' method='post' action='?orderNow=6' target='_top'>
				<input type='hidden' name='cmd' value='_xclick' />
				<input type='hidden' name='business' value='"; echo $OPTION['wps_paypal_email']; echo "'/>
				<input type='hidden' name='item_name' value='$Your_Order - $date_order' />
				<input type='hidden' name='amount' value='$TOTAL_AM' />
				<input type='hidden' name='shipping' value='$shipping' />
				<input type='hidden' name='currency_code' value='";echo $OPTION['wps_currency_code']; echo "' />
				<input type='hidden' name='quantity' value='1' />
				<input type='hidden' name='custom' value='$_SESSION[cust_id]' />	
				<input type='hidden' name='first_name' value='$order[f_name]' />
				<input type='hidden' name='last_name' value='$order[l_name]' />
				<input type='hidden' name='address_street' value='$order[street]' />				
				<input type='hidden' name='address_zip' value='$order[zip]' />
				<input type='hidden' name='address_city' value='$order[town]' />
				<input type='hidden' name='address_state' value='$order[state]' />	
				<input type='hidden' name='address_country' value='$order[country]' />
				<input type='hidden' name='custom_note' value='$order[custom_note]' />
				<input type='hidden' name='no_shipping' value='1' />
						
				<input type='hidden' name='bn'  value='ButtonFactory.PayPal.001' />
				<div class='shopform_btn'>
					<input type='image'  name='add' src='"; echo bloginfo('stylesheet_directory'); echo"/images/send_inquiry.png' />
				</div>
			</form>	
			";	
		}
		else{	
		
			// call start of Payment method 	
			include WP_CONTENT_DIR.'/themes/'.WPSHOP_THEME_NAME.'/lib/modules/payment/'.$order['p_option'].'/start.php';
			
		} ?>
		
		<div id="editOrderOverlay" class="overlay overlayAlt">
			<div class="editOrderWrap">
			
			</div>
		</div><!-- editOrderOverlay -->
		
	<?php }
	
	elseif($_GET['orderNow'] == '4'){	 // Bank transfer in advance
			include WP_CONTENT_DIR.'/themes/'.WPSHOP_THEME_NAME.'/lib/modules/payment/transfer/proceed.php';
	}
	elseif($_GET['orderNow'] == '5'){	 // Cash at shop/hand over
			include WP_CONTENT_DIR.'/themes/'.WPSHOP_THEME_NAME.'/lib/modules/payment/cash/proceed.php';
	}
	elseif($_GET['orderNow'] == '6'){	 // Sent an email inquiry
	
		// update inquiry table
		$inq = process_inquiry();
		
		// sent inquiry as email to shop-owner, but only if it wasn't sent yet
		if($inq['email_sent'] == '0'){
			sent_inquiry_email($inq);
		}
		
		echo order_step_table(4); 
		echo"<h2>".__('Thank you for your Enquiry! You will hear from us soon.','wpShop')."</h2>";
		 
		echo "<a class='cartActionBtn cont_shop' href='".get_option('home')."' target='_top'>".__('Continue Shopping!','wpShop')."</a>";

	}	
	elseif($_GET['orderNow'] == '7'){	 // Cash on delivery 
			include WP_CONTENT_DIR.'/themes/'.WPSHOP_THEME_NAME.'/lib/modules/payment/cod/proceed.php';
	}
	elseif($_GET['orderNow'] == '8'){	// PayPal Pro
			include WP_CONTENT_DIR.'/themes/'.WPSHOP_THEME_NAME.'/lib/modules/payment/paypal_pro/proceed.php';
	}
	elseif($_GET['orderNow'] == '81'){  // Response from PayPal-Pro
		include WP_CONTENT_DIR.'/themes/'.WPSHOP_THEME_NAME.'/lib/modules/payment/paypal_pro/response.php';			
	}
	elseif($_GET['confirm'] == '1'){	 // Response from PayPal
		include WP_CONTENT_DIR.'/themes/'.WPSHOP_THEME_NAME.'/lib/modules/payment/paypal/response.php';
		
		if(isset($_GET['merchant_return_link'])){
			include WP_CONTENT_DIR.'/themes/'.WPSHOP_THEME_NAME.'/footer.php';
		exit(NULL);
		}
	}
	elseif($_GET['confirm'] == '2'){  // Response from Authorize.net
		include WP_CONTENT_DIR.'/themes/'.WPSHOP_THEME_NAME.'/lib/modules/payment/cc_authn/response.php';
	}
	elseif($_GET['confirm'] == '3'){  // Response from WorldPay
		include WP_CONTENT_DIR.'/themes/'.WPSHOP_THEME_NAME.'/lib/modules/payment/cc_wp/response.php';
	}
	elseif($_GET['showTerms'] == '1'){
		echo "<p>";
		echo nl2br($OPTION['wps_terms_conditions']);
		echo "</p>";
	}
	elseif($_GET['showMap'] == 1){
			
		$maplink = $OPTION['wps_google_maps_link'];
		echo "
		
		<a href='$maplink' target='_blank'>".__('Google-Map-Link','wpShop')."</a>
		";
		
	}
	elseif($_GET['checkOrderStatus'] == 1){
		if($OPTION['wps_shop_mode'] == 'Inquiry email mode'){
			
			$tid = trim($_POST['tid']);
			echo "<p>";
			echo  check_inquiry_status($tid);	
			echo "</p>";
		}
		else {
			
			$tid = trim($_POST['tid']);
			echo "<p>";
			echo  check_order_status($tid);	
			echo "</p>";
		}
	}
	else {}
?>