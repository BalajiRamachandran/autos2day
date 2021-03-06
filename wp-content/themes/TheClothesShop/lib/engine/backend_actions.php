<?php
##################################################################################################################################
//												BACKEND-FUNCTIONS																			
##################################################################################################################################


	function make_section_header($current){
		
		global $CONFIG_WPS,$OPTION;

		$links 					= array();
		$links['settings']		= '?page=functions.php';
		$links['orders']  		= '?page=functions.php&section=orders';
		$links['inquiries'] 	= '?page=functions.php&section=inquiries';
	
		$links['inventory'] 	= '?page=functions.php&section=inventory';
	
		$links['lkeys']  		= '?page=functions.php&section=lkeys';
		$links['statistics']	= '?page=functions.php&section=statistics';
		$links['vouchers']		= '?page=functions.php&section=vouchers';
		$links['members']		= '?page=functions.php&section=members';
		
		$css_class 				= array();
		$css_class['settings']	= 'class="inactive"';
		$css_class['orders']  	= 'class="inactive"';
		$css_class['inquiries'] = 'class="inactive"';
	
		$css_class['inventory'] = 'class="inactive"';
	
		$css_class['lkeys']  	= 'class="inactive"';
		$css_class['statistics']= 'class="inactive"';
		$css_class['vouchers']	= 'class="inactive"';
		$css_class['members']	= 'class="inactive"';
		
		foreach($links as $k => $v){
			if($k == $current){
				$v 				= '#';
				$css_class[$k]	= 'class="active"';
			}
		}
		
			
		$output2 = "
		<div class='wrap'>
			<ul class='tabs mainTabs'> 
				<li><a href='$links[settings]' $css_class[settings]>".__(' Theme Options','wpShop')."</a></li>";
				//using the shopping cart?
				if($OPTION['wps_shoppingCartEngine_yes']) {
				
				
				
					if($OPTION['wps_shop_mode'] == 'Normal shop mode'){ 
						$output2 .=  "<li><a href='$links[orders]' $css_class[orders]>".__('Manage Orders','wpShop')."</a></li>";
					}elseif($OPTION['wps_shop_mode'] == 'Inquiry email mode'){
						$output2 .=  "<li><a href='$links[inquiries]' $css_class[inquiries] >".__('Manage Enquiries','wpShop')."</a></li>";
					}elseif($OPTION['wps_shop_mode'] == 'payloadz_mode'){
						$output2 .=  "<li><a href='https://www.payloadz.com/' target=_blank>".__('PayLoadz','wpShop')."</a></li>";
					}else {}
					
					// tracking inventory?
					if($OPTION['wps_track_inventory']=='active'){
						$output2 .= "<li><a href='$links[inventory]' $css_class[inventory]>".__('Manage Inventory','wpShop')."</a></li>";
					}
					// using License keys?
					$l_mode = $OPTION['wps_l_mode'];
					if(($l_mode == 'GIVE_KEYS')&&($OPTION['wps_shop_mode'] != 'payloadz_mode')&&($OPTION['wps_shop_mode'] != 'Inquiry email mode')){ 
						$output2 .= "<li><a href='$links[lkeys]' $css_class[lkeys] >".__('Upload L-Keys','wpShop')."</a></li>";
					}
					// using vouchers?
					if ($OPTION['wps_voucherCodes_enable']) {
						$output2 .= "<li><a href='$links[vouchers]' $css_class[vouchers] >".__('Vouchers','wpShop')."</a></li>";
					}
				}
				// using a membership area?
				if($OPTION['wps_lrw_yes']) {
					$output2 .= "<li><a href='$links[members]' $css_class[members] >".__('Members','wpShop')."</a></li>";
				}
				//using the shopping cart?
				if($OPTION['wps_shoppingCartEngine_yes']) {
					$output2 .= "<li><a href='$links[statistics]' $css_class[statistics] >".__('Statistics','wpShop')."</a></li>";
				}
			$output2 .= "</ul>";
			
			
	return $output2;
	}



	function make_section_footer(){
		$output 	= "</div></div></div></div>";
		$output2 	= "</div>";
	return $output2;
	}



//////////////////////////////////////////////// ORDERS ///////////////////////////////////////////////////////
	function classify_orders()
	{
		// get orders from db
		$odata[1]	= array();
		$odata[2]	= array();
		$odata[3]	= array();
		$odata[4]	= array();
		$odata[5]	= array();
		$counter1	= 0;
		$counter2	= 0;
		$counter3	= 0;
		$counter4	= 0;
		$counter5	= 0;
		$table 	= is_dbtable_there('orders');
		$qStr 	= "SELECT * FROM $table WHERE level IN ('4','5','6','7','8') ORDER BY order_time DESC";
		$res 	= mysql_query($qStr);

		while($order 	= mysql_fetch_assoc($res)){				
							
			switch($order[level]){
				// new
				case '4':					
					$details 				= show_orders($order[who]);							
					$order[items]			= $details;
					$odata[1][$counter1]	= $order;								
					$counter1++;
				break; 
				//in process
				case '5':
					$details 				= show_orders($order[who]);							
					$order[items]			= $details;
					$odata[2][$counter2]	= $order;								
					$counter2++;
				break; 
				// shipped
				case '6':
					$details 				= show_orders($order[who]);							
					$order[items]			= $details;
					$odata[3][$counter3]	= $order;								
					$counter3++;								
				break; 
				// completed
				case '7':
					$details 				= show_orders($order[who]);							
					$order[items]			= $details;
					$odata[4][$counter4]	= $order;								
					$counter4++;
				break; 
				// pending
				case '8':
					$details 				= show_orders($order[who]);							
					$order[items]			= $details;
					$odata[5][$counter5]	= $order;								
					$counter5++;
				break; 
			}
			
		}
	return $odata;
	}


	function multi_change_order_level(){

		// update orders table
		$table = is_dbtable_there('orders');						
						
		foreach($_POST as $k=>$v){	
		
			if($v == 'move'){
			
				$status						= trim($_POST['status']);
				
				if($status != 'delete'){
									
					$column_value_array 	= array();
					$where_conditions 		= array();
					
					$column_value_array['level'] 	= $status;					
					$where_conditions[0]			= "oid = $k";
										
					db_update($table, $column_value_array, $where_conditions);
					
					// send shipping information to customer
					if($status == '6'){		
							send_shipping_notification($k);	
					}		
				}
				else {
					$sql = "DELETE FROM $table WHERE oid = $k";
					mysql_query($sql);
				}
			}
		}
		
	return TRUE;
	}


	
	function display_order_entries($odata,$status,$date_format,$table_header,$table_footer,$empty_message){

		global $CONFIG_WPS,$OPTION;
		
		$INVOICE 	= load_what_is_needed('invoice');	//change.9.10

		$base_url  = '?page=functions.php&section=orders';

		if((count($odata[$status])) > 0){
			
			echo $table_header; 
			
					
					if(pdf_usable_language()){ 			
						$inv_ending = '.pdf';
					} 
					else {
						$inv_ending = '.html';
					}
				
					foreach($odata[$status] as $k => $order){
						
						$date 			= date($date_format,($order['order_time'] + get_option('wps_time_addition')));
						$style 			= ($status == 5 ? "style='background:coral;'" : NULL);
						$dl_sent_info 	= ($order[dlinks_sent] != 0 ? ' - last sent on: '.date("F j, Y, G:i",$order[dlinks_sent]) : NULL);			
						
						
						echo "
						<tr>
							<td $style><input type='checkbox' name='$order[oid]' value='move' /></td>
							<td $style>$OPTION[wps_order_no_prefix]$order[oid]</td> 
							<td $style>$date</td>
							<!--
							<td $style>$order[l_name] $order[f_name]<br/><a href='mailto:$order[email]'>".__('Send email','wpShop')."</a></td>
							-->
							<td $style>";
					
								echo address_format($order);
								echo "<br/><a href='mailto:$order[email]'>".__('Send email','wpShop')."</a>";
								if(strlen($order['telephone']) > 1){
									echo "<br/>".__('Tel:','wpShop'). $order['telephone'];
								}
							echo "</td>";
							
							echo "<td $style>";					
										
								if(diversity_check($order,0,'BE') === TRUE){
									echo address_format(retrieve_delivery_addr('BE',$order),'d-addr');
								}
								echo "
							</td>
							<td $style>";
								if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($order[amount]); 
								if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
								if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
							echo  "</td>
							<td $style>"; 
											
								echo list_order_items($order[items]);	
								echo __('Track-ID:','wpShop').' '.$order['tracking_id'];
								
								if($order['voucher'] !== 'non'){
								
									$table 	= is_dbtable_there('vouchers'); 
									$qStr 	= "SELECT * FROM $table WHERE vcode = '$order[voucher]' LIMIT 0,1";
									$res	= mysql_query($qStr);
									$row 	= mysql_fetch_assoc($res);
									
									$vEnding = ($row['voption'] == 'P' ? '%' : ' '.$OPTION['wps_currency_code']);
								
									echo __('Voucher','wpShop').' '.$order['voucher'].' '.__('Value:','wpShop').$row['vamount'].$vEnding.' '.__('redeemed.','wpShop');
								}
								if(digital_in_cart($order[who]) === TRUE){
									echo "<a href = '?page=functions.php&section=orders&subsection=dlinks&token=$order[who]'>".__('Send D-Links','wpShop')."</a>$dl_sent_info";
								}	
							
							$invoice_id = NWS_encode($OPTION['wps_invoice_prefix'].'_'.$order['tracking_id'].$inv_ending);
							//change.9.10
							echo "</td>
							<td $style><a href='".get_option('home')."/index.php?display_invoice=1&invoice=$invoice_id' 
							target='_blank'>".$INVOICE->retrieve_invoice_no($order['oid'])."</a></td>
							<td $style>"; 
							//\change.9.10
								switch($order[p_option]){
									case 'paypal':
										echo "
											P: <a href='https://www.paypal.com/vst/id={$order[txn_id]}' 
											target='_blank' title='Check PayPal txn_id {$order[txn_id]}'>".__('PayPal Standard','wpShop')."</a>
											";
									break;
									
									case 'paypal_pro':
										echo 'P: '.__('PayPal Pro','wpShop');
									break;	
									
									case 'cc_authn':
										echo 'P: '.__('Authorize.net','wpShop');
									break;	
									
									case 'cc_wp':
										echo 'P: '.__('WorldPay','wpShop');
									break;				
									
									case 'transfer':
										echo 'P: '.__('Bank Transfer','wpShop');
										$banking_url = $OPTION['wps_online_banking_url'];
										echo "								
											<a href='http://$banking_url' 
											target='_blank' title='".__('Url to your Online Banking','wpShop')."'>".__('Check Account','wpShop')."</a>
											";													
									break; 
									
									case 'cash':
										echo 'P: '.__('Cash on Location','wpShop');							
									break;	

									case 'cod':
										echo 'P: '.__('Cash on Delivery','wpShop');
									break;	
								} 
								echo "<br/>";
								echo "D: $order[d_option]";
							echo "</td>";
							
							if($OPTION['wps_customNote_enable']) {
								echo "<td $style>$order[custom_note]</td>";	
							}
							
						echo "</tr>";
					}
					
			echo $table_footer;
		}
		else {
			echo $empty_message;
		}	
	}


	
	
	
	function send_shipping_notification($oid){
	
		global $OPTION;	
		
		$EMAIL 	= load_what_is_needed('email');		//change.9.10
		
		$table 	= is_dbtable_there('orders');
		$qStr 	= "SELECT * FROM $table WHERE oid = $oid LIMIT 1";
		$res 	= mysql_query($qStr);
		$order 	= mysql_fetch_assoc($res);
		
		// we send customer a notification email about the shipping	
		$order_no				= $OPTION['wps_order_no_prefix'].$order[oid];  
		$to 					= $order[email];
		$subject_str			= __('Your Order %ORDER_OID% has been shipped','wpShop');						
		$subject 				= str_replace("%ORDER_OID%",$order_no,$subject_str);						

		if(strlen(WPLANG)< 1){  // shop runs in English 
			$filename			= WP_CONTENT_DIR . '/themes/'.WPSHOP_THEME_NAME.'/email/email-shipping.html';
		}
		else {					// shops runs in another language 
			$filename			= WP_CONTENT_DIR . '/themes/'.WPSHOP_THEME_NAME.'/email/'.WPLANG.'-email-shipping.html';
		}
		
		$message				= file_get_contents($filename);
		$admin_email_address	= $OPTION['wps_shop_email'];
		$domain					= $OPTION['wps_shop_name'];										

		$em_logo_path 	= get_bloginfo('template_directory') .'/images/logo/' . $OPTION['wps_email_logo'];	
		// might be that these char combos show up b'c image tag 
		$message		= str_replace('%5B','[', "$message");
		$message		= str_replace('%5D',']', "$message");
		
		$message		= str_replace('[##Email-Logo##]', $em_logo_path, "$message");									
		$message		= str_replace('[##biz##]',utf2latin($OPTION['wps_shop_name']), "$message");
		$message		= str_replace('[##name##]', $order[f_name].' '.$order[l_name] , "$message");					
		$message		= str_replace('[##orderid##]', $order_no, "$message");	
	
		$EMAIL->html_mail($to,$subject,$message,$admin_email_address,$domain);		//change.9.10		
	}

	
	
	
	function NWS_total_orders_there($option='all'){
		$totalOrders 	= array();
		$table 			= is_dbtable_there('orders');
		
		//total All
			$qStr 				= "SELECT * FROM $table WHERE level IN ('4','5','6','7','8')";
			$res 				= mysql_query($qStr);
			$num 				= mysql_num_rows($res);
			$totalOrders['all'] = $num;
		
		//Completed		
			$qStr 						= "SELECT * FROM $table WHERE level ='7'";
			$res 						= mysql_query($qStr);
			$num 						= mysql_num_rows($res);				
			$totalOrders['completed'] 	= $num;
			
		//Shipped		
			$qStr 						= "SELECT * FROM $table WHERE level ='6'";
			$res 						= mysql_query($qStr);
			$num 						= mysql_num_rows($res);				
			$totalOrders['shipped'] 	= $num;
			
		//In process		
			$qStr 						= "SELECT * FROM $table WHERE level ='5'";
			$res 						= mysql_query($qStr);
			$num 						= mysql_num_rows($res);				
			$totalOrders['in_process'] 	= $num;
			
		//New		
			$qStr 						= "SELECT * FROM $table WHERE level ='4'";
			$res 						= mysql_query($qStr);
			$num 						= mysql_num_rows($res);				
			$totalOrders['new'] 		= $num;
			
		//Pending		
			$qStr 						= "SELECT * FROM $table WHERE level ='8'";
			$res 						= mysql_query($qStr);
			$num 						= mysql_num_rows($res);				
			$totalOrders['pending'] 	= $num;
		
		
		return $totalOrders;
	}
	
	
	function NWS_total_earnings_there($option='all'){
		$totalEarnings 	= array();
		$table 			= is_dbtable_there('orders');
		
		//total All
			$qStr 					= "SELECT SUM(amount) AS totalEarnings FROM $table WHERE level IN ('4','5','6','7')";
			$res 					= mysql_query($qStr);
			$row 					= mysql_fetch_assoc( $res );				
			$totalEarnings['all'] 	= $row['totalEarnings'];
		
					
		//Total Year		
			// 1. what year now?
			$currentYear = date('Y');
			
			// 2. when did it start - time stamp | when did it end?
			$begin = mktime(0,0,1,1,1,$currentYear);
			$end   = mktime(23,59,59,12,31,$currentYear);
			
			#echo date("F j, Y, H:i:s",$begin); 
			#echo date("F j, Y, H:i:s",$end);
			
			
			// 3. mySql query with a where between clause 
			$begin 					= (string) $begin;
			$end 					= (string) $end;
			$qStr 					= "SELECT SUM(amount) as totalEarnings FROM $table WHERE (order_time BETWEEN '$begin' AND '$end') AND (level IN ('4','5','6','7'))";
			$res 					= mysql_query($qStr);
			$row 					= mysql_fetch_assoc( $res );				
			$totalEarnings['year'] 	= $row['totalEarnings'];
				
		//Total Month			
			// 1. what month now?
			$currentMonth = date('n');
			
			
			// 2. when did it start - time stamp | when did it end?
			$begin 		= mktime(0,0,1,$currentMonth,1,$currentYear);
			$numDays 	= date("t",$begin);
			$end   		= mktime(23,59,59,$currentMonth,$numDays,$currentYear);
			
			#echo date("F j, Y, H:i:s",$begin); 
			#echo date("F j, Y, H:i:s",$end);
			
			
			// 3. mySql query with a where between clause 
			$begin 						= (string) $begin;
			$end 						= (string) $end;
			$qStr 						= "SELECT SUM(amount) as totalEarnings FROM $table WHERE (order_time BETWEEN '$begin' AND '$end') AND (level IN ('4','5','6','7'))";
			$res 						= mysql_query($qStr);
			$row 						= mysql_fetch_assoc( $res );				
			$totalEarnings['month'] 	= $row['totalEarnings'];
					
		//Total Week			
			// 1. what week now?
			$currentWeek 	= date('W');
			$currDayinWeek 	= date('N');
			$currDayinMonth = date('j');
			switch($currDayinWeek){
				case '1':
					$firstDay 	= $currDayinMonth - 0;
					$lastDay 	= $currDayinMonth + 6;
				break;
				
				case '2':
					$firstDay 	= $currDayinMonth - 1;
					$lastDay 	= $currDayinMonth + 5;
				break;
				
				case '3':
					$firstDay 	= $currDayinMonth - 2;
					$lastDay 	= $currDayinMonth + 4;
				break;
				
				case '4':
					$firstDay 	= $currDayinMonth - 3;
					$lastDay 	= $currDayinMonth + 3;
				break;
				
				case '5':
					$firstDay 	= $currDayinMonth - 4;
					$lastDay 	= $currDayinMonth + 2;
				break;
				
				case '6':
					$firstDay 	= $currDayinMonth - 5;
					$lastDay 	= $currDayinMonth + 1;
				break;
				
				case '7':
					$firstDay 	= $currDayinMonth - 6;
					$lastDay 	= $currDayinMonth + 0;
				break;
				
			}
			
			// 2. when did it start - time stamp | when did it end?
			$begin 			= mktime(0,0,1,$currentMonth,$firstDay,$currentYear);
			$end   			= mktime(23,59,59,$currentMonth,$lastDay,$currentYear);
			
			
			#echo date("F j, Y, H:i:s",$begin); 
			#echo date("F j, Y, H:i:s",$end);
			
			
			// 3. mySql query with a where between clause 
			$begin 						= (string) $begin;
			$end 						= (string) $end;
			$qStr 						= "SELECT SUM(amount) as totalEarnings FROM $table WHERE (order_time BETWEEN '$begin' AND '$end') AND (level IN ('4','5','6','7'))";
			$res 						= mysql_query($qStr);
			$row 						= mysql_fetch_assoc( $res );				
			$totalEarnings['week'] 		= $row['totalEarnings'];	
		
		//Total Today			
			// 1. what week now?
			$today = date('j');
			
			// 2. when did it start - time stamp | when did it end?
			$begin 		= mktime(0,0,1,$currentMonth,$today,$currentYear);
			$end   		= mktime(23,59,59,$currentMonth,$today,$currentYear);
			
			#echo date("F j, Y, H:i:s",$begin); 
			#echo date("F j, Y, H:i:s",$end);
			
			
			// 3. mySql query with a where between clause 
			$begin 						= (string) $begin;
			$end 						= (string) $end;
			$qStr 						= "SELECT SUM(amount) as totalEarnings FROM $table WHERE (order_time BETWEEN '$begin' AND '$end') AND (level IN ('4','5','6','7'))";
			$res 						= mysql_query($qStr);
			$row 						= mysql_fetch_assoc( $res );				
			$totalEarnings['today'] 	= $row['totalEarnings'];
			
	return $totalEarnings;
	}

//////////////////////////////////////////////// INQUIRIES ///////////////////////////////////////////////////////
	
	function classify_inquiries()
	{
			
		// get inquires from db
		$odata[1]	= array();
		$odata[2]	= array();
		$counter1	= 0;
		$counter2	= 0;
		$table 	= is_dbtable_there('inquiries');
		$qStr 	= "SELECT * FROM $table ORDER BY inquiry_time DESC";
		$res 	= mysql_query($qStr);

		while($order 	= mysql_fetch_assoc($res)){				
							
			switch($order[level]){
				// new
				case '4':					
					$details 				= show_orders($order[who]);							
					$order[items]			= $details;
					$odata[1][$counter1]	= $order;								
					$counter1++;
				break; 
				// replied to
				case '5':
					$details 				= show_orders($order[who]);							
					$order[items]			= $details;
					$odata[2][$counter2]	= $order;								
					$counter2++;
				break; 

			}
			
		}
		return $odata;
	}
	

	function NWS_total_enquiries_there($option='all'){
		$totalEnquiries = array();
		$table 			= is_dbtable_there('inquiries');
		
		//total All
			$qStr 						= "SELECT * FROM $table";
			$res 						= mysql_query($qStr);
			$num 						= mysql_num_rows($res);
			$totalEnquiries['all'] 		= $num;
		
		//Replied to		
			$qStr 						= "SELECT * FROM $table WHERE level ='5'";
			$res 						= mysql_query($qStr);
			$num 						= mysql_num_rows($res);				
			$totalEnquiries['replied'] 	= $num;
	
			
		//New		
			$qStr 						= "SELECT * FROM $table WHERE level ='4'";
			$res 						= mysql_query($qStr);
			$num 						= mysql_num_rows($res);				
			$totalEnquiries['new'] 		= $num;
			
		return $totalEnquiries;
	}

	
	
	
	
	function display_inquiry_entries($odata,$status,$date_format,$table_header,$table_footer,$empty_message){
		global $CONFIG_WPS,$OPTION;
	
		$base_url  = '?page=functions.php&section=inquiries';
	
		if((count($odata[$status])) > 0){
			
			echo $table_header; 
			
				foreach($odata[$status] as $k => $inq){
				
					$date 			= date($date_format,$inq[inquiry_time]);
					$style 			= ($status == 5 ? "style='background:coral;'" : NULL);
					$dl_sent_info 	= ($inq[dlinks_sent] != 0 ? ' - last sent on: '.date("F j, Y, G:i",$inq[dlinks_sent]) : NULL);			
					
					echo "
					<tr>
						<td $style><input type='checkbox' name='$inq[oid]' value='move' /></td>
						<td $style>$inq[oid]</td>
						<td $style>$date</td>
						<td $style>$inq[l_name] $inq[f_name]<br/><a href='mailto:$inq[email]'>".__('Send email','wpShop')."</a></td>
						<td $style>";				
							echo address_format($inq);
						echo "
						</td>
						
						<td $style>";					
							if(diversity_check($inq,0,'BE') === TRUE){
								echo address_format(retrieve_delivery_addr('BE',$inq),'d-addr');
							}
						echo "</td>";	
					
						echo "
						<td $style>";
								if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($inq[amount]); 
								if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
								if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
						echo  "</td>
						<td $style>"; 					
							echo list_order_items($inq[items]);	
							echo __('Shipping Fee:','wpShop').' ';
								if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($inq[shipping_fee]); 
								if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
								if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
						echo  "</td>
						
						<td $style>";
							switch($inq[p_option]){
								case 'paypal':
									echo 'P: '.__('PayPal','wpShop');
								break;

								case 'cc_authn':
									echo 'P: '.__('Authorize.net','wpShop');
								break;	
								
								case 'cc_wp':
									echo 'P: '.__('WorldPay','wpShop');
								break;				
								
								case 'transfer':
									echo 'P: '.__('Bank Transfer','wpShop');
								break; 
								
								case 'cash':
									echo 'P: '.__('Cash on Location','wpShop');							
								break;	

								case 'cod':
									echo 'P: '.__('Cash on Delivery','wpShop');
								break;	
							} 
							
							echo "<br/>";
							echo "D: $inq[d_option]";
						echo "</td>";
						echo "<td $style>$inq[custom_note]</td>";	
					echo "</tr>";						
				}
					
			echo $table_footer;
		}
		else {
			echo $empty_message;
		}	
	}
	
	
	
	function change_inquiry_level($oid,$new_level){

		// update orders table
		$table = is_dbtable_there('inquiries');
		$column_value_array 	= array();
		$where_conditions 		= array();
		
		$column_value_array[level] 		= $new_level;
		
		$where_conditions[0]			= "oid = $oid";
							
		db_update($table, $column_value_array, $where_conditions);
	
	return TRUE;
	}
	
	function multi_change_inquiry_level(){

		// update inquiries table
		$table = is_dbtable_there('inquiries');						
						
		foreach($_POST as $k=>$v){	
		
			if($v == 'move'){
			
				$status						= trim($_POST['status']);
				
				if($status != 'delete'){
									
					$column_value_array 	= array();
					$where_conditions 		= array();
					
					$column_value_array['level'] 	= $status;					
					$where_conditions[0]			= "oid = $k";
										
					db_update($table, $column_value_array, $where_conditions);
						
				}
				else {
					$sql = "DELETE FROM $table WHERE oid = $k";
					mysql_query($sql);
				}
			}
		}
		
	return TRUE;
	}

//////////////////////////////////////////////// LKEYS ///////////////////////////////////////////////////////

	function save_lkeys(){

		$filename      	= 'csvfile';
		$table_name1   	= is_dbtable_there('lkeys');
								
		$delimit       	= "\n";
		$prod_quantity	= 1000;
		$row 			= 1;
		$lkeys 			= 1;
		$error			= 0;
		$err_message 	= __('There was an error with the file upload!','wpShop');
		
		
		if(strlen($_FILES[$filename]['tmp_name']) < 1){						
			$err_message .= "<br/>".__('You forgot to enter a .txt file.','wpShop');
			$error++;
		}
		if (substr($_FILES[$filename]['name'],-4) != '.txt'){ 
			$err_message .= "<br/>".__('The file needs to have the ending .txt','wpShop');
			$error++;
		}
		
		if ($_FILES[$filename]['size'] > 102400){ // size = not more than 100kB
			$err_message .= "<br/>".__('Your file exceeds the size of 100 KB.','wpShop');
			$error++;
		}						
		if ($_FILES[$filename]['error'] !== UPLOAD_ERR_OK){
			$err_message .= "<br/>".file_upload_error_message($_FILES[$filename]['error']);
			$error++;
		}
		
		if(!$_POST[name_file]){
			$err_message .= "<br/>".__('Please enter the exact name of the file the license keys are used for.','wpShop');
			$error++;
		}
		$result = $err_message;
		
		if($error == 0){

			$handle = fopen($_FILES[$filename]['tmp_name'], "r");

			while(($data = fgetcsv($handle, 1000, $delimit)) !== FALSE){

				$row++;
				$len 		= strlen($data[0]);
				$data[0]	= trim($data[0]);	
				
				if($len > 0){
					###### Insert into lkeys table #####################
					$column_array 	= array();
					$value_array   	= array();

					$column_array[0] 	= 'lid';      			$value_array[0]   	= '';
					$column_array[1] 	= 'filename';      		$value_array[1]   	= $_POST[name_file];
					$column_array[2] 	= 'lkey';      			$value_array[2]   	= $data[0];
					$column_array[3] 	= 'used';    			$value_array[3]   	= '0';	
					
					$result_db1 = db_insert($table_name1, $column_array, $value_array);

					if($result_db1 != 1){
						echo "<p>".__('There was a problem with','wpShop')." $table_name1 !</p>\n";
					}
					$lkeys++;
				}  
			}      
			fclose($handle);
			$lkeys--;
			$result = "
				<h1>".__('Upload sucessful!','wpShop')."</h1>".__('You uploaded ','wpShop').
				$lkeys.__(' new license keys.','wpShop')."
				<br/><br/>";

		}

	return $result;
	}



	function file_upload_error_message($error_code) {
		switch($error_code){ 
			case UPLOAD_ERR_INI_SIZE: 
				return __('The uploaded file exceeds the upload_max_filesize directive in php.ini','wpShop');
			break;
			case UPLOAD_ERR_FORM_SIZE: 
				return __('The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.','wpShop');
			break;
			case UPLOAD_ERR_PARTIAL: 
				return __('The uploaded file was only partially uploaded.','wpShop');
			break;
			case UPLOAD_ERR_NO_FILE: 
				return  __('No file was uploaded.','wpShop');
			break;
			case UPLOAD_ERR_NO_TMP_DIR: 
				return __('Missing a temporary folder.','wpShop');
			break;
			case UPLOAD_ERR_CANT_WRITE: 
				return __('Failed to write file to disk.','wpShop');
			break;
			case UPLOAD_ERR_EXTENSION: 
				return __('File upload stopped by extension.','wpShop');
			break;
			default: 
				return  __('Unknown upload error.','wpShop');
			break;
		} 
	} 

//////////////////////////////////////////////// MEMBERS ///////////////////////////////////////////////////////
		
		
	function display_members($num_per_page){
	
		$table  		= 'wp_users';//is_dbtable_there('feusers');
		$memb_wanted 	= trim($_GET['memb_wanted']);
		
		$data	= "<table class='widefat'>
					<thead>
						<tr>
							<th>".__('Username','wpShop')."</th>
							<th>".__('Email','wpShop')."</th>
							<th>".__('Lastname','wpShop')."</th>
							<th>".__('Firstname','wpShop')."</th>
							<th>".__('Member since','wpShop')."</th>
							<th>".__('Remove','wpShop')."</th>
						</tr>
					</thead>";
					
		$LIMIT 	= pagination_limit_clause($num_per_page);
		
		if(strlen($memb_wanted) < 1){		
			$qStr 	= "SELECT * FROM $table $LIMIT";	
		} else {
			$qStr 	= "SELECT * FROM $table WHERE level = '0' AND lname LIKE '$memb_wanted%' ORDER BY lname ASC $LIMIT";		
		}
		$res 	= mysql_query($qStr);
		$num 	= mysql_num_rows($res);


		if($num > 0){
		
			?>
			
				<script>
					function display_extra_info(uid){
						
						var user_id	= "user_" + uid;
						var value 	= document.getElementById(user_id).style.display;	
						
						if(value == 'none'){
							document.getElementById(user_id).style.display = 'block';
						}
						else{
							document.getElementById(user_id).style.display = 'none';
						}
					}
				</script>
			
			<?php
		
			$table 	= 'wp_usermeta';//is_dbtable_there('feusers_meta');	
			$uid  	= (int) $_SESSION['uid'];	
	
			while($row = mysql_fetch_assoc($res)){
			
				$qStr2 		= "SELECT meta_key,meta_value FROM $table WHERE uid = $row[uid]";
				$res2  		= mysql_query($qStr2);
				$num2 		= mysql_num_rows($res2);
				$extraData 	= NULL;
				
				if($num2 > 0){
				
					$extraData .= "<span style='text-decoration:underline;cursor:pointer;display:block;' onclick='display_extra_info($row[uid])'>".__('Additional Info:')."</span>";
					$extraData .= "<div id='user_{$row[uid]}' style='display: none;'>";
					while($row2 = mysql_fetch_assoc($res2)){
						$v_key = str_replace("_", " ",$row2['meta_key']); 
						$extraData .= $v_key.': '.$row2['meta_value']."<br/>";
					}
					$extraData .= "</div>";
				}	
					
				$data .= "<tbody><tr>";
				$data .= "<td>$row[user_login]</td>";  
				$data .= "<td><a href='mailto:{$row[user_email]}'>$row[user_email]</a>{$extraData}</td>";  
				$data .= "<td>$row[lname]</td>";  
				$data .= "<td>$row[fname]</td>";  
				$data .= "<td>$row[user_registered]</td>";  
				$data .= "<td><a href='?page=functions.php&section=members&action=del&vid={$row[uid]}'>X</a></td>";  
				$data .= "</tr></tbody>";
			}
		}
		else{
			$data .= "<tbody><tr><td colspan='7'>".__('You have no Registered Members yet.','wpShop')."</td></tr></tbody>";
		}
		$data .= "</table>";
		
	return $data;
	}
		
	function member_delete($uid){
	
		$vid	= (int) trim($uid);	
		$table 	= is_dbtable_there('feusers');
		$qStr 	= "DELETE FROM $table WHERE uid = $uid";
		$res	= mysql_query($qStr);

	return $res;		
	}
	
	function NWS_total_members_there($option='all'){
		$totalMembers 	= array();
		$table 			= is_dbtable_there('feusers');
		
		//total All
			$qStr 					= "SELECT * FROM $table";
			$res 					= mysql_query($qStr);
			$num 					= mysql_num_rows($res);
			$totalMembers['all'] 	= $num;
	
		return $totalMembers;
	}
	
	function NWS_activeWishlists_there($option='all'){
	
		$data	= array();
	
		$table 	= is_dbtable_there('wishlist');	
		$qStr 	= "SELECT uid FROM $table";
		$res 	= mysql_query($qStr);
	
		while($row = mysql_fetch_assoc($res)){
			$data[] = $row['uid'];	
		}	
		//make unique and count the results
		$activeWishlists = count(array_unique($data));
		
		return $activeWishlists;
	}




//////////////////////////////////////////////// STATISTICS ///////////////////////////////////////////////////////

	function provide_statistics($header,$header_color,$diagram_height,$diagram_color){
		global $OPTION;
		
		//change.9.10
		$STATISTICS = load_what_is_needed('statistics');
		//\change.9.10
			
		echo make_section_header('statistics');		
		$currency 	= $OPTION['wps_currency_code'];
		$header_str	= __('Sales in %CURRENCY% :: Development last 12 months','wpShop');					
		$header 	= str_replace("%CURRENCY%",$currency,$header_str);		
		
		echo "<h3>".__('Statistics','wpShop')."</h3>";	
		echo $STATISTICS->graph_monthly_sales($diagram_height,$diagram_color);		//change.9.10
		echo make_section_footer();
	}






//////////////////////////////////////////////// INVENTORY ///////////////////////////////////////////////////////

function adapt_inventory2attributes(){

	global $wpdb;

	// get any attribute keys saved in post_meta
	$table 	= $wpdb->prefix . 'postmeta';
	$qStr 	= "SELECT DISTINCT meta_key FROM $table WHERE meta_key LIKE 'item_attr_%'";
	$res 	= mysql_query($qStr);
	
	$attributes = array();
	
	while($row = mysql_fetch_assoc($res)){
		$p 				= explode("_",$row['meta_key']);		// explode them - keep [2]
		$attributes[] 	= $p[2];
	}

	// run check: can a column with that name be found in inventory table?					
	$table 	= is_dbtable_there('inventory');	
	$qStr 	= "SHOW columns FROM $table";
	$res 	= mysql_query($qStr);
	
	$cols 	= array();
	$i		= 0;
	
	while($row = mysql_fetch_assoc($res)){
	
		$cols[$i] = $row['Field']; 
	
			if($row['Field'] == 'ID_item'){
				$j = $i;
			}
	$i++;
	}		

	$j--;
	$After_Col = $cols["$j"];
	
	$sql_cols = array();
				
	foreach($attributes as $v){
		if(!in_array(ucfirst($v),$cols)){		
			$sql_cols[] = $v;
		}
	}
	$num = count($sql_cols);
	

	// no new attributes: nice
	// yes, there are new attributes - change the inventory table 
	
	if($num > 0){
				
		$qStr = "ALTER TABLE $table "; 
		
		foreach($sql_cols as $v){
			$v = ucfirst($v);					
			$qStr .= " ADD `$v` ".'VARCHAR(255) NOT NULL AFTER '.$After_Col.',';
		}
		
			$qStr = substr($qStr,0,-1); 		
			mysql_query($qStr); 
	}
}

function prepare_master_array($post,$b){	
	
	global $wpdb;
	
	$qStr 	= "SELECT meta_value,meta_key FROM $wpdb->postmeta WHERE post_id = $post AND meta_key LIKE 'item_attr_%'";									
	$res 	= mysql_query($qStr);
								
	$MASTER_V 	= array();
	$MASTER_K 	= array();
	$y			= 0;
	
		while($row = mysql_fetch_assoc($res)){
			
			$k 				= explode("_",$row[meta_key]);	// name of col		
			$MASTER_K[$y] 	= $k[2];
			
			// rows - values
			if($b[attr_op] == '2'){
			
				$p 			= array();
				$almost  	= explode("|",$row[meta_value]);
				foreach($almost as $val_price_token){
					$parts 	= explode("-",$val_price_token); 
					$p[] 	= $parts[0];
				}
			}
			else {
				$p 			= explode("|",$row[meta_value]);
			}
										
			$MASTER_V[] = $p;
							
		$y++;
		}	
		
	$result = array();
	$result[master_v] = $MASTER_V;
	$result[master_k] = $MASTER_K;
	
return $result;
}

function permutations($array)		
{
	switch (count($array)) {
		case 1:
			return $array[0];
			$error = 0;
		break;
		case 0:
			$error = 1;
		break;
	}
	
	if($error == 0){
	
		$a = array_shift($array);
		$b = permutations($array);

		$return = array();
		foreach ($a as $v) {
			foreach ($b as $v2) {
				$return[] = array_merge(array($v), (array) $v2);
			}
		}

		foreach($return as $val){

			$num = count($val);
			$res = NULL;
			
			for($i=0;$i<$num;$i++){
				$res .= $val[$i].'&&';	
			}
			
			$output[] = substr($res,0,-2);
		}		
		
		return $output;
	}
	else {
		echo "<p class='error'>Error: Requires at least one array. Check if there are product posts with custom field 'has_attributes' BUT missing the additional 'item_attr_'!</p>";
	}
}

function add_permutations_db($MASTER_K,$MASTER_V,$ID_ITEM){
								
	$table 	= is_dbtable_there('inventory');
								
	// get the cols 
	$needed_cols = NULL;													
	foreach($MASTER_K as $ckey=> $col){
		$needed_cols .=  $col . ',';											
	}
	$needed_cols .=  'ID_item,amount';
	
	// get the values + do the DB insert
	$arr = permutations($MASTER_V);			

	foreach($arr as $key => $combo){
	
		$combo 		= explode("&&",$combo);	
		$where_str 	= NULL; 
		$val_str 	= NULL;
	
		foreach($combo as $k => $att_vals){
			$c			= ucfirst($MASTER_K[$k]);
			$where_str	.= "$c = '$att_vals' AND ";
			$val_str 	.= "'$att_vals',";
		}		
		
		// ID_ITEM + start amount 0 as well
		$where_str	.= "ID_item = '$ID_ITEM'";
		$val_str 	.= "'$ID_ITEM','0'";
		
		$qStr1 	= "SELECT * FROM $table WHERE $where_str";
		$res1	= mysql_query($qStr1);
		$num 	= mysql_num_rows($res1);
		
		if($num == 0){
			$qStr2 = "INSERT INTO $table ($needed_cols) VALUES ($val_str)";
			mysql_query($qStr2);
		}
	}	
}

function inventory_order_clause(){

		$table 	= is_dbtable_there('inventory');	
		$qStr 	= "SHOW columns FROM $table";

		$res	= mysql_query($qStr);
		$cols 	= array();
		$i		= 0;

		while($row = mysql_fetch_assoc($res)){
					
			if(($row['Field'] != 'iid') && ($row['Field'] != 'ID_item') && ($row['Field'] != 'amount'))
			{
				$cols[$i] = $row['Field'];
			}
			$i++;
		}	

		$order_clause = 'ORDER BY ';
		
		foreach($cols as $v){
			$order_clause .= $v.',';
		}
		$order_clause = substr($order_clause,0,-1);			

return $order_clause;
}

function pagination_limit_clause($num_per_page){

		$limit 		= 'LIMIT ';
		$start		= 0;
		$end		= $num_per_page;
		
		if(isset($_GET['start'])){
			$start 	= (int)$_GET['start'];
		}
		if(isset($_GET['end'])){
			$end 	= (int)$_GET['end'];
		}				
		
		$limit 		= $limit.$start.','.$end;

return $limit;
}

function inventory_main_query($limit){

	global $wpdb;
	
	$table1		= $wpdb->prefix . 'postmeta';
	$table2		= $wpdb->prefix . 'posts';
	$art_wanted = trim($_GET['art_wanted']);

	if(strlen($art_wanted)<1){
	
		$qStr 	= "SELECT * FROM $table1 
						INNER JOIN $table2 ON $table1.post_id = $table2.ID 
					WHERE 
						$table1.meta_key = 'ID_item' 
					AND 
						$table2.post_status IN ('publish','draft','inherit')
					ORDER BY $table1.meta_value 
					$limit";
	}
	else{
		
		$qStr 	= "SELECT * FROM $table1 
						INNER JOIN $table2 ON $table1.post_id = $table2.ID 
					WHERE 
						$table1.meta_key = 'ID_item' 
					AND
						$table1.meta_value LIKE '$art_wanted%'						
					AND 
						$table2.post_status IN ('publish','draft','inherit')
					ORDER BY $table1.meta_value 
					$limit";	
	}
	$res 	= mysql_query($qStr);				

return $res;
}

function inventory_article_check(){

	global $wpdb;
	$table1	= $wpdb->prefix . 'postmeta';
	$table2	= $wpdb->prefix . 'posts';
	
	$qStr 	= "SELECT meta_value FROM $table1 
				INNER JOIN $table2 ON $table1.post_id = $table2.ID 
			WHERE 
				$table1.meta_key = 'ID_item' 
			AND 
				$table2.post_status IN ('publish','draft','inherit')
			ORDER BY $table1.meta_value 
			$limit";

	$res 	= mysql_query($qStr);		
	$a		= array();
	
	// an array of Item-Id's is build
	while($row = mysql_fetch_assoc($res)){
		$a[] = $row['meta_value'];
	}
	
	//based on the Item-Id's array we check the inventory table if really all permutations and cols are there
	$table 	= is_dbtable_there('inventory');
	
	
	foreach($a as $v){
		$qStr 	= "SELECT * FROM $table WHERE ID_item = '$v' LIMIT 0,1";
		$res 	= mysql_query($qStr);
		$num	= mysql_num_rows($res);
		$status = ($num == 0 ? __('Article','wpShop').' ' . $v . ' '.__('will be added to inventory','wpShop')."<br/>" : NULL);
		
		//an item is not yet in the inventory - so we add it
		if($num == 0)
		{					
			$post 	= find_post_id($v);
			$b 		= has_attributes($post,2);
			
			# attributes-yes? - which ones?
			if($b[status] == 'yes'){
			
				$MASTER 	= prepare_master_array($post,$b);
				$MASTER_V 	= $MASTER[master_v];	
				$MASTER_K 	= $MASTER[master_k];	
													
				add_permutations_db($MASTER_K,$MASTER_V,$v);	
			}
			else { // no attributes? fine - we just add it like that				
			
				$column_array 	= array(); 
				$value_array	= array();
				
				$column_array[0] = 'ID_item'; 		$value_array[0] = $v;
				$column_array[1] = 'amount'; 		$value_array[1] = 0;
				
				db_insert($table,$column_array,$value_array);								
			}
		}

		# 3. Article-Check / all permutations of all articles really there?			
		$post 	= find_post_id($v);
		$b 		= has_attributes($post,2);
			
			
		if($b['status'] == 'yes'){
		
			$MASTER 	= prepare_master_array($post,$b);
			$MASTER_V 	= $MASTER[master_v];	
			$MASTER_K 	= $MASTER[master_k];			

			$feedback 		= get_attr_permutation_nums($MASTER_V,$MASTER_K,$v);
			$num1 			= $feedback['num1'];
			$num2 			= $feedback['num2'];
			$new_attr_flag	= $feedback['new_attr_flag'];

			// it could be that an attribute option itself was changed
			$k_num = count($MASTER_K);
			for($i=0;$i<$k_num;$i++){
				$qStr 		= "SELECT * FROM $table WHERE ID_item='$v'";
				$res6 		= mysql_query($qStr);
				
				while($row6 = mysql_fetch_assoc($res6)){
					if(! in_array($row6[ucfirst($MASTER_K[$i])],$MASTER_V[$i])){
						$remove	= $row6[ucfirst($MASTER_K[$i])]; 								
						$qStr 	= "DELETE FROM $table WHERE ID_item='$v' AND ".ucfirst($MASTER_K[$i])." = '$remove'";											
						mysql_query($qStr);
					}
				}
			}
						
			// we check again		
			$MASTER 	= prepare_master_array($post,$b);
			$MASTER_V 	= $MASTER[master_v];	
			$MASTER_K 	= $MASTER[master_k];	

			$feedback 		= get_attr_permutation_nums($MASTER_V,$MASTER_K,$v);
			$num1 			= $feedback['num1'];
			$num2 			= $feedback['num2'];
			$new_attr_flag	= $feedback['new_attr_flag'];	
													
			if($num1 > $num2){
				
					//why the difference in number, is it a new attribute or a new option of an existing attribute?
				
					//DELETE - in case a new attr group was added 				
					if($new_attr_flag == 1){
						$qStr = "DELETE FROM $table WHERE ID_item='$v'";											
						mysql_query($qStr);
					}
					
					// Create all the combos
					add_permutations_db($MASTER_K,$MASTER_V,$v);	
				}		
				elseif($num1 < $num2){
				
					//why the difference in number, is it one less attribute group or one less option of an existing attribute?
					$less_attr_flag	= 0;
					
					//get all columns of inventory table 
					$result 	= mysql_query("SELECT * FROM $table LIMIT 0,1");
					$table_cols	= mysql_fetch_assoc($result);
					$avail_cols = array();
					
					foreach($table_cols as $kkey => $value){
						$avail_cols[$kkey] = $kkey;
					}
					unset($avail_cols['iid']);
					unset($avail_cols['ID_item']);
					unset($avail_cols['amount']);
				
					foreach($avail_cols as $val){
						$sql9 = "SELECT MAX(".ucfirst($val).") AS LargestVal FROM $table WHERE ID_item = '$v'";
						$res9 = mysql_query($sql9);
						$row9 = mysql_fetch_assoc($res9);
						
						if(strlen($row9['LargestVal'])>0){
							if((!in_array($val,$MASTER_K)) && (!in_array(strtolower($val),$MASTER_K))){
								$less_attr_flag	= 1;
							}
						}
					}

					if($less_attr_flag == 1){
						$qStr = "DELETE FROM $table WHERE ID_item='$v'";											
						mysql_query($qStr);
					}
					else {
						//which of the attr options doesn't exist anymmore?
						$k_num = count($MASTER_K);
						for($i=0;$i<$k_num;$i++){
							$qStr 		= "SELECT * FROM $table WHERE ID_item='$v'";
							$res6 		= mysql_query($qStr);
							
							while($row6 = mysql_fetch_assoc($res6)){
								if(! in_array($row6[ucfirst($MASTER_K[$i])],$MASTER_V[$i])){
									$remove	= $row6[ucfirst($MASTER_K[$i])]; 								
									$qStr 	= "DELETE FROM $table WHERE ID_item='$v' AND ".ucfirst($MASTER_K[$i])." = '$remove'";											
									mysql_query($qStr);
								}
							}
						}
					}
					
					// Create all the combos
					add_permutations_db($MASTER_K,$MASTER_V,$v);	
				}	
			}
			else {
			// no attributes? then there should be only 1 single record in inventory table 
					$table 	= is_dbtable_there('inventory');
					$qStr 	= "SELECT * FROM $table WHERE ID_item = '$v'";
					$res	= mysql_query($qStr);
					$num2	= mysql_num_rows($res);

					if($num2 > 1){
						$qStr = "DELETE FROM $table WHERE ID_item='$v'";											
						mysql_query($qStr);					
					
						$qStr = "INSERT INTO $table (ID_item,amount) VALUES ($v,0)";						
						mysql_query($qStr);
					}
			}
	}
}

function get_attr_permutation_nums($MASTER_V,$MASTER_K,$v){

	$feedback 			= array();
	$table 				= is_dbtable_there('inventory');
	
	// how many acc. to fields of the post?
	$permu_num 			= permutations($MASTER_V);
	$feedback['num1'] 	= count($permu_num);		
	
	// how many acc. inventory db table?
	//was a complete new attr group added?
	$feedback['new_attr_flag']	= 0;
	
	foreach($MASTER_K as $attr_col){
		$qStr 	= "SELECT MAX(".ucfirst($attr_col).") AS LargestVal FROM $table WHERE ID_item = '$v'";
		$res 	= mysql_query($qStr);
		$row 	= mysql_fetch_assoc($res);
		
		if(strlen($row['LargestVal']) == 0){
			$feedback['new_attr_flag'] = 1;
		}
	}

	$qStr 				= "SELECT * FROM $table WHERE ID_item = '$v'";
	$res				= mysql_query($qStr);
	$feedback['num2']	= mysql_num_rows($res);
			
return $feedback;
}

function inventory_amount_update(){
			
	$table 	= is_dbtable_there('inventory');
	unset($_POST[submit_this]);
	
	foreach($_POST as $k => $v){
		$qStr 	= "UPDATE $table SET amount='$v' WHERE iid = $k";
		mysql_query($qStr);
	}
		echo '	
		<script type="text/javascript"> 
		<!--  
		location.href="themes.php?page=functions.php&section=inventory";  
		//-->  
		</script>  
		<noscript>
		<meta http-equiv="refresh" content="0; URL=themes.php?page=functions.php&section=inventory"/>
		</noscript>
		';
}

function inventory_product_title($post_id){

	global $wpdb;
	
	$table	= $wpdb->prefix . 'posts';
	$qStr 	= "SELECT post_title FROM $table WHERE ID = $post_id LIMIT 0,1";
	$res 	= mysql_query($qStr);					
	$row   	= mysql_fetch_assoc($res);		

return $row['post_title'];
}

function inventory_product_image($post_id){

	global $wpdb;

	$table	= $wpdb->prefix . 'postmeta';
	$qStr 	= "SELECT * FROM $table WHERE meta_key = 'image_thumb' AND post_id = $post_id LIMIT 0,1";
	$res 	= mysql_query($qStr);					
	$row   	= mysql_fetch_assoc($res);
	
return $row['meta_value'];	
}

function inventory_has_attributs($post_id){

	global $wpdb;
	
	$table		= $wpdb->prefix . 'postmeta';
	$qStr 		= "SELECT meta_id FROM $table WHERE post_id = $post_id AND meta_key LIKE 'item_attr%'";
	$res2 		= mysql_query($qStr);	
	$num		= mysql_num_rows($res2);

return $num;
}

function header_for_attributes($meta_value){
	
	$table		= is_dbtable_there('inventory');						
	$qStr		= "SELECT * FROM $table WHERE ID_item = '$meta_value' LIMIT 0,1";
	$res 		= mysql_query($qStr);
	$row_head 	= mysql_fetch_assoc($res);						
	
	$data		= NULL;
	
	if($row_head != FALSE){
		foreach($row_head as $k => $v){		
			if($k != 'iid' && $k != 'ID_item' && $k != 'amount' && !empty($v)){
				$data .= "<th>".ucwords($k)."</th>";
			}
		}
	} else {echo "<p class='warning'>".__('Please press the "Refresh List" button at the top of the page.','wpShop')."</p>";}
	
	$data .= "<th>".__('Amount','wpShop')."</th></tr>";
		
return $data;
}

function display_attributes_data($meta_value,$order_by_clause){

	$table		= is_dbtable_there('inventory');
	$qStr		= "SELECT * FROM $table WHERE ID_item = '$meta_value' $order_by_clause"; // ORDER BY
	$qStr		= "SELECT * FROM $table WHERE ID_item = '$meta_value'"; 				 // ORDER BY
	$res 		= mysql_query($qStr);							

	$data		= NULL;

		while($row = mysql_fetch_assoc($res)){
			
				$data .= "<tr>";
				
				foreach($row as $k => $v){
					if($k != 'iid' && $k != 'ID_item' && $k != 'amount' && !empty($v)){
						$data .= "<td>$v</td>";
					}			
				}
				
				$data .= "<td><input type='text' name='$row[iid]' value='$row[amount]' /></td></tr>";
		}

return $data;
}

function display_amount($meta_value){

	$table		= is_dbtable_there('inventory');
	$qStr		= "SELECT * FROM $table WHERE ID_item = '$meta_value'"; // ORDER BY
	$res 		= mysql_query($qStr);							

return $res;
}

function NWS_total_prods_there($option='all'){
	$totalProds 	= array();
	$table 			= is_dbtable_there('inventory');
	
	//total All
		$qStr 				= "SELECT * FROM $table";
		$res 				= mysql_query($qStr);
		$num 				= mysql_num_rows($res);
		$totalProds['all'] 	= $num;
		
	//Low in Stock		
		$qStr 						= "SELECT * FROM $table WHERE amount ='1'";
		$res 						= mysql_query($qStr);
		$num 						= mysql_num_rows($res);				
		$totalProds['low'] 			= $num;
	
	//Out of Stock		
		$qStr 						= "SELECT * FROM $table WHERE amount ='0'";
		$res 						= mysql_query($qStr);
		$num 						= mysql_num_rows($res);				
		$totalProds['out'] 			= $num;
	
	return $totalProds;
}


/////////////////////////////////////////////// PAGINATION //////////////////////////////////////////////////////////
function NWS_inventory_pagination($articles=10){

	global $wpdb;

	$table 		= $wpdb->prefix . 'postmeta';
	$art_wanted = trim($_GET['art_wanted']);

	// how many articles altogether?
	if(strlen($art_wanted)<1){
		$qStr 	= "SELECT * FROM $table WHERE meta_key = 'ID_item'";
	}
	else{
		$qStr 	= "SELECT * FROM $table WHERE meta_key = 'ID_item' AND meta_value LIKE '$art_wanted%'";
	}
	$res 		= mysql_query($qStr);
	$num_art	= mysql_num_rows($res);
	
	if($num_art == 0){
		echo "<b>".__('No articles found','wpShop')."</b>";
	}
	else {
		$num_pages 	= $num_art / $articles;				
		$base_url 	= '?page=functions.php&section=inventory&art_wanted='.$_GET['art_wanted'];
		
		echo "<a class='prev page-numbers' href='{$base_url}&start=0&end=".$articles."' style='text-decoration:none;'>&laquo;</a>";
		
		for($i=0,$j=1,$s=0,$e=$articles;$i<$num_pages;$i++,$j++,$s += $articles){
		
			if($_GET['start'] != $s){
				echo "<a class='page-numbers' href='{$base_url}&start={$s}&end={$e}'>$j</a>";
			}
			else {
				echo "<span class='page-numbers current'>$j</span>";
			}
		}	
		$l = $s - $articles;
		echo "<a class='next page-numbers' href='{$base_url}&start={$l}&end={$e}' style='text-decoration:none;'>&raquo;</a>";
	}
}

function NWS_members_pagination($members=10){

	global $wpdb;

	$table 			= is_dbtable_there('feusers');
	$memb_wanted 	= trim($_GET['memb_wanted']);

	// how many members altogether?
	if(strlen($memb_wanted) < 1){
		$qStr 	= "SELECT * FROM $table WHERE level = '0'";
	}
	else{
		$qStr 	= "SELECT * FROM $table WHERE level = '0' AND lname LIKE '$memb_wanted%'";
	}
	$res 		= mysql_query($qStr);
	$memb_num	= mysql_num_rows($res);
	
	if($memb_num == 0){
		echo "<b>".__('No Members found','wpShop')."</b>";
	}
	else {
		$num_pages 	= $memb_num / $members;				
		$base_url 	= '?page=functions.php&section=members&memb_wanted='.$_GET['memb_wanted'];
		
		echo "<a class='prev page-numbers' href='{$base_url}&start=0&end=".$members."' style='text-decoration:none;'>&laquo;</a>";
		
		for($i=0,$j=1,$s=0,$e=$members;$i<$num_pages;$i++,$j++,$s += $members){
		
			if($_GET['start'] != $s){
				echo "<a class='page-numbers' href='{$base_url}&start={$s}&end={$e}'>$j</a>";
			}
			else {
				echo "<span class='page-numbers current'>$j</span>";
			}
		}	
		$l = $s - $members;
		echo "<a class='next page-numbers' href='{$base_url}&start={$l}&end={$e}' style='text-decoration:none;'>&raquo;</a>";
	}
}



function NWS_voucher_pagination($vouchers=10){

	global $wpdb;

	$table 			= is_dbtable_there('vouchers');
	$vouch_wanted 	= trim($_GET['vouch_wanted']);

	// how many vouchers altogether?
	if(strlen($vouch_wanted) < 1){
		$qStr 	= "SELECT * FROM $table WHERE duration = '1time'";
	}
	else{
		$qStr 	= "SELECT * FROM $table WHERE duration = '1time' AND vcode LIKE '$vouch_wanted%'";
	}
	$res 		= mysql_query($qStr);
	$vouch_num	= mysql_num_rows($res);
	
	if($vouch_num == 0){
		echo "<b>".__('No Vouchers found','wpShop')."</b>";
	}
	else {
		$num_pages 	= $vouch_num / $vouchers;
		$base_url 	= '?page=functions.php&section=vouchers&action=display&vouch_wanted='.$vouch_wanted;
		
		echo "<a class='prev page-numbers' href='{$base_url}&start=0&end=".$vouchers."' style='text-decoration:none;'>&laquo;</a>";
		
		for($i=0,$j=1,$s=0,$e=$vouchers;$i<$num_pages;$i++,$j++,$s += $vouchers){
		
			if($_GET['start'] != $s){
				echo "<a class='page-numbers' href='{$base_url}&start={$s}&end={$e}'>$j</a>";
			}
			else {
				echo "<span class='page-numbers current'>$j</span>";
			}
		}	
		$l = $s - $vouchers;
		echo "<a class='next page-numbers' href='{$base_url}&start={$l}&end={$e}' style='text-decoration:none;'>&raquo;</a>";
	}
}



function NWS_resellers_pagination($resellers=10){

	global $wpdb;

	$table 			= is_dbtable_there('vouchers');
	$resell_wanted 	= trim($_GET['resellers_wanted']);

	// how many vouchers altogether?
	if(strlen($resell_wanted) < 1){
		$qStr 	= "SELECT * FROM $table WHERE duration = 'indefinite'";
	}
	else{
		$qStr 	= "SELECT * FROM $table WHERE duration = 'indefinite' AND vcode LIKE '$resell_wanted%'";
	}
	$res 		= mysql_query($qStr);
	$resell_num	= mysql_num_rows($res);
	
	if($resell_num == 0){
		echo "<b>".__('No Resellers found','wpShop')."</b>";
	}
	else {
		$num_pages 	= $resell_num / $resellers;
		$base_url 	= '?page=functions.php&section=vouchers&action=reseller&resellers_wanted='.$resell_wanted;
		
		echo "<a class='prev page-numbers' href='{$base_url}&start=0&end=".$resellers."' style='text-decoration:none;'>&laquo;</a>";
		
		for($i=0,$j=1,$s=0,$e=$resellers;$i<$num_pages;$i++,$j++,$s += $resellers){
		
			if($_GET['start'] != $s){
				echo "<a class='page-numbers' href='{$base_url}&start={$s}&end={$e}'>$j</a>";
			}
			else {
				echo "<span class='page-numbers current'>$j</span>";
			}
		}	
		$l = $s - $resellers;
		echo "<a class='next page-numbers' href='{$base_url}&start={$l}&end={$e}' style='text-decoration:none;'>&raquo;</a>";
	}
}




//////////////////////////////////////////////// THEME-OPTIONS ///////////////////////////////////////////////////////


	function summarize_multi_checkbox($name_option,$option_v){
								
		global $wpdb,$CONFIG_WPS;
		
		$the_option 	= NULL;
		$option_name 	= $CONFIG_WPS[shortname].$name_option;
		$table			= $wpdb->prefix.'options';
	
		foreach($option_v as $k => $v){				

			$in_val = "$CONFIG_WPS[shortname]{$name_option}|$v";	
	
			if(array_key_exists($in_val,$_POST)){
				$data 		= explode("|",$in_val);
				$the_option .= $data[1].'|';
			}								
		}
	
		$the_option = substr($the_option, 0, -1);
		
		if($the_option[0] == '|'){
			$the_option = substr($the_option,1);
		}
	
	
		// Delete old entry					
		$qStr 			= "DELETE FROM $table WHERE option_name = '$option_name'";		
		mysql_query($qStr);

		// Insert new option
		$qStr1 = "INSERT INTO $table (option_name,option_value) VALUES ('$option_name','$the_option')";
		mysql_query($qStr1);
				
	return 'DONE';				
	}


	function optimize_table($table='options'){

		global $wpdb;
		$table = $wpdb->prefix.$table;
		$sql 	= "OPTIMIZE TABLE `$table`"; 
		mysql_query($sql);
	}
	

//////////////////////////////////////////////// Voucher Tabs ///////////////////////////////////////////////////////	
	
	function make_voucher_tabs($current){

		global $CONFIG_WPS;

		
		$links 					= array();
		$links['upload']		= '?page=functions.php&section=vouchers&action=start';
		$links['display']  		= '?page=functions.php&section=vouchers&action=display';
		$links['bgImg'] 		= '?page=functions.php&section=vouchers&action=bgImg';
		$links['pdf'] 			= '../wp-content/themes/'.$CONFIG_WPS[themename].'/lib/fpdf16/pdf_vouchers.php';
		$links['reseller']  	= '?page=functions.php&section=vouchers&action=reseller';
		
		
		$css_class 					= array();
		$css_class['upload']		= 'class="inactive"';
		$css_class['display']  		= 'class="inactive"';
		$css_class['bgImg'] 		= 'class="inactive"';
		$css_class['pdf'] 			= 'class="inactive"';
		$css_class['reseller']  	= 'class="inactive"';
		
		foreach($links as $k => $v){
			if($k == $current){
				$v 				= '#';
				$css_class[$k]	= 'class="active"';
			}
		}
		
			
		$output2 = "
			<ul class='tabs secondaryTabs v_tabs'> 
				<li><a href='$links[upload]' $css_class[upload]>".__('Upload New Single-Use Vouchers','wpShop')."</a></li>";
				$output2 .=  "<li><a href='$links[display]' $css_class[display]>".__('Manage Single-Use Vouchers','wpShop')."</a></li>";
				$output2 .=  "<li><a href='$links[bgImg]' $css_class[bgImg] >".__('Upload Background-Image','wpShop')."</a></li>";
				$output2 .= "<li><a target='_blank' href='$links[pdf]' $css_class[pdf]>".__('Create PDF','wpShop')."</a></li>";
				$output2 .= "<li><a href='$links[reseller]' $css_class[reseller] >".__('Reseller (Multi-Use) Vouchers','wpShop')."</a></li>";
			$output2 .= "</ul>";
		
	return $output2;
	}
	
	function NWS_total_vouchers_there($option='all'){
		$totalVouchers 	= array();
		$table 			= is_dbtable_there('vouchers');
		
		//total All
			$qStr 							= "SELECT * FROM $table";
			$res 							= mysql_query($qStr);
			$num 							= mysql_num_rows($res);
			$totalVouchers['all'] 			= $num;
			
		//Single Use		
			$qStr 							= "SELECT * FROM $table WHERE duration ='1time'";
			$res 							= mysql_query($qStr);
			$num 							= mysql_num_rows($res);				
			$totalVouchers['single_use'] 	= $num;
			
		//Single Use Redeemed		
			$qStr 							= "SELECT * FROM $table WHERE duration ='1time' AND used='1'";
			$res 							= mysql_query($qStr);
			$num 							= mysql_num_rows($res);				
			$totalVouchers['redeemed'] 		= $num;
			
		//Single Use Unclaimed		
			$qStr 							= "SELECT * FROM $table WHERE duration ='1time' AND used='0'";
			$res 							= mysql_query($qStr);
			$num 							= mysql_num_rows($res);				
			$totalVouchers['unclaimed'] 	= $num;
		
		//Multi Use (reseller)		
			$qStr 							= "SELECT * FROM $table WHERE duration ='indefinite'";
			$res 							= mysql_query($qStr);
			$num 							= mysql_num_rows($res);				
			$totalVouchers['multi_use'] 	= $num;
		
		return $totalVouchers;
	}
	
//////////////////////////////////////////////////////////// CHECKS //////////////////////////////////////////////////////////

function attributesDataChecker($checkno = 1){
	
	global $wpdb;

	switch($checkno){
	
		case 1:
		$table 	= $wpdb->prefix . postmeta;
		$qStr 	= "SELECT * FROM $table WHERE meta_key LIKE '%item_attr_%'";
		$res 	= mysql_query($qStr);

		while($row = mysql_fetch_assoc($res))
		{
				$meta_value = trim($row['meta_value']);
				$len 		= strlen($meta_value)-1;
				$last 		= $meta_value[$len];
				
				if($last == "|"){
					$new_meta_value =  substr($meta_value,0,-1);
					#echo "ID $meta_id - Old value: $meta_value - New value: $new_meta_value"."<br/>";
					$qStr2 	=  "UPDATE $table SET meta_value ='$new_meta_value' WHERE meta_id = $row[meta_id]";
					mysql_query($qStr2);
				}
		}
		break;
		
		case 2:
		$table 	= $wpdb->prefix . postmeta;
		$qStr 	= "SELECT * FROM $table WHERE meta_key = 'ID_item'";
		$res 	= mysql_query($qStr);

		while($row = mysql_fetch_assoc($res)){
			echo "<pre>";
				print_r($row);
			echo "</pre>";

			$parts 	= explode(" ",$row['meta_value']);
			$num 	= count($parts);
			
			if($num > 1){
				$meta_value = implode("_", $parts);
				$qStr2 		=  "UPDATE $table SET meta_value ='$meta_value' WHERE meta_id = $row[meta_id]";
				
				echo $qStr2;
				mysql_query($qStr2);
			}
		}
		break;
		
		case 3:
		echo "<b>".__('Find posts with attribut conflicts:','wpShop')."</b><br/>";

		$counter 	= 0;
		$arr 		= array();
		$table 		= $wpdb->prefix . postmeta;
		$qStr 		= "SELECT * FROM $table WHERE meta_key = 'add_attributes'";
		$res 		= mysql_query($qStr);

		while($row = mysql_fetch_assoc($res)){
			$arr[] = (int) $row['post_id'];
		}
		foreach($arr as $v){

			$qStr 	= "SELECT * FROM $table WHERE post_id = $v AND meta_key LIKE 'item_attr_%' LIMIT 0,1";
			$res 	= mysql_query($qStr);
			$num 	= mysql_num_rows($res);

			if($num == 0){
				$counter++;
			
				$f  = __('Post ','wpShop').$v. __(' has no custom field item_attr_% - Link: ','wpShop');
				$f .= "<a href='".get_option('home')."/wp-admin/post.php?action=edit&post=$v' target='_blank'>";
				$f .= get_option('home')."/wp-admin/post.php?action=edit&post=$v</a><br/>";
				echo $f;
			}
		}
		if($counter == 0){
			echo __('No conflicts found.','wpShop')."<br/><br/>";
		}
		break;
	}
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>