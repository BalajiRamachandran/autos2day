<?php

function get_table_setting ( $num, $table, $_vin_values ) {
	if ( $num > 0 ) {
		// $_vin_values[$table] = array();
		$_vin_values->tables .= "$table|";
	} else {
		$_vin_values->nokeys .= "[$table]";
	}
	return $_vin_values;	
}

function addRegionCondition ( $_vin_values ) {
	$condition = " and Region = '";
	//Region = '" . $_vin_values->States->RegionCode  . "'
	if ( isset($_vin_values->VinPrefix->RegionCode) ) {
		$condition .= $_vin_values->VinPrefix->RegionCode;
	}
	$condition .= "' ";
	return $condition;
}

function addOptionTable ( $_vin_values ) {
	$condition = " and OptionTable = '";
	//Region = '" . $_vin_values->States->RegionCode  . "'
	if ( isset($_vin_values->VicDescriptions->OptionTable) ) {
		$condition .= $_vin_values->VicDescriptions->OptionTable;
	}
	$condition .= "' ";
	return $condition;
}	

function process_query ( $sql ) {
	mysql_connect(get_option('nada_db_host'), get_option('nada_db_user'), get_option('nada_db_pwd'));
	mysql_select_db(get_option('nada_db'));
	$result = mysql_query($sql);
	debug_print ( $sql );
	if ( mysql_error() ) {
		die ( "<p>SQL error: " . $sql . ' ' . mysql_error() . "</p>");
	}	
	return $result;
}

function debug_print ( $str ) {
	if (isset($_REQUEST['debug']) && $_REQUEST['debug'] = date('Ymd') ) {
		echo '<p>';
		if ( is_array($str) || is_object($str) ) {
			print_r($str);
		} else {
			echo $str;			
		}
		echo '</p>';
	}	
}

function get_condition ( $fields, $field_values, $_fields = '', $keyString = 'and') {
	$field_values = (array) $field_values;
	foreach ( $fields as $field ) {
			if ( strlen($condition) > 0 ) {
				$condition .= "$keyString ";
			}
			if ( is_array($_fields)) {
				$value = $field_values[$_fields[$field]];
			} else {
				$value = $field_values[$field];
			}
			$condition .= $field . " = '";
			$condition .= get_converted_format ( $field, $value );
			$condition .= "' ";
		}
	return $condition;	
}

function get_converted_format ( $field, $value ) {
	$return = '';
	switch ( $field ) {
		case 'OptionTable':
			$return = intval($value);
			break;
		case 'VAC':
			$return = str_pad($value, 3, '0', STR_PAD_LEFT);
			break;
		case 'ValueType':
			$return = "T";
			break;
		default:
			$return = $value;
			break;
	}		
	return $return;		
}

?>