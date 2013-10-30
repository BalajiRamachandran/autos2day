<?php
include '../../../wp-load.php';

/*
$cart_comp = cart_composition($_SESSION[cust_id]);

// dont show this if digital product + short address form activated
if($OPTION['wps_short_addressform']=='not_active' && $cart_comp!='digi_only'){		
	create_address_form('shipping');
}
*/

if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
	header("Content-type: application/xhtml+xml;charset=utf-8"); 
} else {
	header("Content-type: text/xml;charset=utf-8");
}	

if ( isset($_GET['vin']) && strlen($_GET['vin']) > 0 ) { //got vin
	if ( isset($_GET['z']) && strlen($_GET['z']) > 0 ) { //got zipcode
		if ( isset($_GET['m']) && strlen($_GET['m']) > 0 ) { //got zipcode
			echo get_vehichle_configuration ( $_GET );
		} elseif (isset($_GET['v']) && strlen($_GET['v']) > 0) {
			echo get_vehichle_prices ( $_GET );
		}
	}
}

function get_vehichle_prices ( $obj ) {
	$log = load_what_is_needed("log");
	$log->general("get_vehichle_prices - processing KBB web service");
	$XML = load_what_is_needed ("xml");
	$KBB = load_what_is_needed ("kbb");
	$vehicleData = get_option($obj['vin']);
	$result = $KBB->CallMethod ( 
		"GetVehicleValuesByVehicleConfigurationAllConditions", 
		array ( 
			'VIN' => $obj['vin'], 
			'ZipCode' => $obj['z'],
			'VehicleConfiguration' => $vehicleData->GetVehicleConfigurationByVINResult->VehicleConfiguration
		) 
	);
	$result->VehicleConfiguration = $vehicleData->GetVehicleConfigurationByVINResult->VehicleConfiguration;
	//delete_option($obj['vin']);
	$result_xml = $XML->generate_valid_xml_from_array($result);
	//$log->general("XML: " . $result_xml);
	return $result_xml; 
}


function get_vehichle_configuration ( $obj ) {
	$log = load_what_is_needed("log");
	$log->general("processing KBB web service");
	$xml_key = $obj['vin'] . _ . $obj['z'] . _ . $obj['m'] . '_xml';
	$XML = load_what_is_needed ("xml");
	$KBB = load_what_is_needed ("kbb");
	$result_xml = get_option($xml_key);
	$log->general("XML length: " . strlen($result_xml));
	if ( strlen($result_xml) > 10 ) {
		$log->general("XML: " . $result_xml);
		return $result_xml;
	}
	delete_option($obj['vin']);
	$log->general("Retireving data: " . $obj['vin']);
	$result = $KBB->CallMethod ( 
		"GetVehicleConfigurationByVIN", 
		array ( 
			'VIN' => $obj['vin'], 
			'ZipCode' => $obj['z'],
			'Mileage'	=> ($obj['m']) ? $obj['m'] : "63000" 
		) 
	);
	add_option($obj['vin'], $result);
	add_option($obj['vin'] . _ . $obj['z'] . _ . $obj['m'], $result);
	add_option($obj['vin'], $result);
	//unset($result->GetVehicleConfigurationByVINResult->VehicleConfiguration->OptionalEquipment);
	$result_xml = $XML->generate_valid_xml_from_array($result);//->GetVehicleConfigurationByVINResult->VehicleConfiguration);
	add_option($xml_key, $result_xml);
	//$log->general("XML: " . $result_xml);
	return get_vehichle_prices ( $obj );
	//return $result_xml; 
}
?>