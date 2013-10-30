<?php

$sql = "show COLUMNS from $table";

$result = mysql_query($sql);

$transTableFields = new stdClass();

while ($row = mysql_fetch_object($result)) {
	$transTableFields->{$row->Field} = "";	
}

$transactionTypes = array (
	"prior_auth_capture", 
	"auth_only", 
	"void"
);

$search_replace = array (
	"UserId"	=>	$current_post->post_author,
	"DealDate"	=>	$current_post->post_date,
	"login"		=>	get_option('wps_authn_api_login'),
	"trans_key"	=>	get_option('wps_authn_transaction_key'),
	"amount"	=>	get_option('wps_deal_amount'),
	"CustomerID"	=>	get_user_meta($current_post->post_author, "dealership_id", true),
	"dealid"	=>	$current_post->ID,
	"name"		=>	"Autos2day - Deal Posting Charge",
	"VIN"	=>	get_post_meta ($current_post->ID, "ad_vin", true),
	"customerProfileId"	=>	get_user_meta($current_post->post_author, "customerProfileId", true),
	"customerPaymentProfileId"	=>	get_post_meta ($current_post->ID, "customerPaymentProfileId", true),
	"invoice_no"	=>	get_user_meta($current_post->post_author, "dealership_id", true) . '_' . strtotime(get_post_meta ($current_post->ID, "deal-date", true)),
	"post_title"	=>	$current_post->post_title,
	"po"			=>	"PO_".get_user_meta($current_post->post_author, "dealership_id", true) . '_' . strtotime(get_post_meta ($current_post->ID, "deal-date", true)),
	"customer_ip"	=>	get_client_ip(),
	'TransactionID'	=>	get_post_meta ( $current_post->ID, "TransactionID", true)
);


$authorizeNetResponseFields = array (
	'0' => 'ResponseCode',
	'1' => 'ResponseSubcode',
	'2' => 'ResponseReasonCode',
	'3' => 'ResponseReasonText',
	'4' => 'AuthorizationCode',
	'5' => 'AVSResponse',
	'6' => 'TransactionID',
	'7' => 'InvoiceNumber',
	'8' => 'Description',
	'9' => 'Amount',
	'10' => 'Method',
	'11' => 'TransactionType',
	'12' => 'CustomerID',
	'13' => 'FirstName',
	'14' => 'LastName',
	'15' => 'Company',
	'16' => 'Address',
	'17' => 'City',
	'18' => 'State',
	'19' => 'ZIPCode',
	'20' => 'Country',
	'21' => 'Phone',
	'22' => 'Fax',
	'23' => 'EmailAddress',
	'24' => 'ShipToFirstName',
	'25' => 'ShipToLastName',
	'26' => 'ShipToCompany',
	'27' => 'ShipToAddress',
	'28' => 'ShipToCity',
	'29' => 'ShipToState',
	'30' => 'ShipToZIPCode',
	'31' => 'ShipToCountry',
	'32' => 'Tax',
	'33' => 'Duty',
	'34' => 'Freight',
	'35' => 'TaxExempt',
	'36' => 'PurchaseOrderNumber',
	'37' => 'MD5Hash',
	'38' => 'CardCodeResponse',
	'39' => 'CardholderAuthenticationVerificationResponse',
	'40' => '',
	'41' => '',
	'42' => '',
	'43' => '',
	'44' => '',
	'45' => '',
	'46' => '',
	'47' => '',
	'48' => '',
	'49' => '',
	'50' => 'AccountNumber',
	'51' => 'CardType',
	'52' => 'SplitTenderID',
	'53' => 'RequestedAmount',
	'54' => 'BalanceOnCard'
);

?>