<?php
	
	$result = get_option($post_vin . "_prices");

	// echo "count: " . count($result);

	// print_r($result);

	if ( count($result) > 1 ) {
		$log->general("retrieving data from DB");
	} else {
		$KBB = load_what_is_needed ("kbb");
		$log->general("processing KBB web service");
		$XML = load_what_is_needed ("xml");
		$vehicleData = get_option($post_vin);
		$zipcode = get_user_meta($author, 'dealership_address_zipcode', true);
		$result = $KBB->CallMethod ( 
			"GetVehicleValuesByVehicleConfigurationAllConditions", 
			array ( 
				'VIN' => $post_vin, 
				'ZipCode' => get_user_meta($author, 'dealership_address_zipcode', true),
				'VehicleConfiguration' => $vehicleData->GetVehicleConfigurationByVINResult->VehicleConfiguration
			) 
		);
		add_option($post_vin . "_prices", $result);
	}
	$html = '<table>';
	$html .= '<tr>';
	$html .= '<th>';
	$html .= 'PriceType';
	$html .= '</th>';
	$html .= '<th>';
	$html .= 'Value';
	$html .= '</th>';
	$html .= '</tr>';
	foreach ($result as $key => $value) {
		if ( is_object($value)) {
			if ( get_custom_field('ad_price') < $value->Value ) { 
				$p_class = 'true'; 
			} else { 
				$p_class .= 'false'; 
			}
			$html .= '<tr>';
			$html .= '<td class="price_' . $p_class .'">';
			$html .= $value->PriceType;
			$html .= '</td>';
			$html .= '<td class="price_' . $p_class .'">';
			$html .= get_option('wps_currency_symbol') . format_price($value->Value);
			$html .= '</td>';
			$html .= '</tr>';
		}
	}
	$html .= '</table>';
	echo $html;
?>