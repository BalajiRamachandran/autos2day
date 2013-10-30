<?php
function cod_response(){
	global $OPTION;			

	$INVOICE 	= load_what_is_needed('invoice');	//change.9.10
	$EMAIL 		= load_what_is_needed('email');		//change.9.10
	
	// Process cash on delivery transaction 
	$feedback 			= array();
	$feedback[status] 	= 'Completed';
	$feedback[itemname]	= $_POST[item_name];
		
	// Update DB 
	$order = process_payment($feedback,'cod');		

	if($order == FALSE){expulsion();}  // if customer refreshes last confirmation page -> redirect
	
	// We add some additional values for confirmation screen needed for e.g. info about pick-up etc.
	$feedback[d_option] 	= $order[d_option];
	$feedback[tracking_id]	= $order[tracking_id];
					
	// we create a pdf for bill + save name of pdf 
	if(pdf_usable_language()){ 
		$INVOICE->make_pdf($order);		//change.9.10
		$feedback[pdf_bill] = NWS_encode($OPTION[wps_invoice_prefix].'_' . $order[tracking_id] . '.pdf');
	}else{
		$INVOICE->make_html($order);	//change.9.10
		$feedback[pdf_bill] = NWS_encode($OPTION[wps_invoice_prefix].'_' . $order[tracking_id] . '.html');
	}
	
	// Email to customer 
	$EMAIL->email_confirmation($order,$feedback);		//change.9.10
												
				
	// Email to shop owner
	$search		= array("[##header##]","[##f_name##]","[##l_name##]","[##amount##]","[##currency##]","[##url##]");
	$replace 	= array($EMAIL->email_header(),$order['f_name'],$order['l_name'],$order['amount'],$OPTION['wps_currency_code'],url_be());		//change.9.10
	$EMAIL->email_owner_order_notification($feedback,$search,$replace);		//change.9.10

	// delete  old custom_id - in order to avoid mixed up orders 
	unset($_SESSION[cust_id]);
	
return $feedback;
}
?>