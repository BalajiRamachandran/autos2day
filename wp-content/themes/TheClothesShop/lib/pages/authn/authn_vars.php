<?php


$authorize_net_variables = array (
    "AUTH_NET_PROFILE"      =>  "customerProfileId"
    );
$authorize_net_fieldsets = array (
        'Billing Details'   =>  'billing_address',
        'Card Details'      =>  'credit_card_details',
        'Confirm'           =>  ''
);
$billTo = array ( 
    "address"           => "Street Address", 
    "city"              => "City", 
    "state"             => "State", 
    "country"           => "Country", 
    "zip"               => "zipcode" ,
    "phoneno"           => "Phone No"
);

$billing_address_mapping = array ( 
    "address"           => "dealership_address_line_1", 
    "city"              => "dealership_address_city", 
    "state"             => "dealership_address_state", 
    "country"           => "dealership_address_country", 
    "zip"               => "dealership_address_zipcode",
    "phoneno"           => "dealership_phone"
);

$credit_card_details = array (
    "card_name"         => "Name As appears on Card", 
    "cardNumber"        => "Credit Card Number", 
    "expirationDate"    => "Expiration Month and Year"
    );

$xml = load_what_is_needed ( "xml" );
$log = load_what_is_needed ( "log" );
// include_once('../class.log.php');

// $xml = new xml();
// $log = new log();

// include_once ("./XML/vars.php");
unset($VALUES);
$user = wp_get_current_user();
$user = get_userdata( $user->ID);
if ( !is_object($user)) {
    echo 'Invalid User details';
    die();
}
$user_meta = get_user_meta ( $user->ID );

?>