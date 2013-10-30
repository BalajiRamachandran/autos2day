<?php
require_once (dirname(__FILE__) . '/nada_utils.php');
class nada {



    // $VINValidation = array (
    //     'V' => "Valid VIN",
    //     'I' => "Incomplete",
    //     'N' => "Not Valid",
    //     'E' => "Error Encountered"
    // );


    function getDefaultValues ($KeyArgs, $vinObject ) {
        $vinObject->Period          = '201205';//date('Ym');
        $vinObject->VinPrefix       = substr($KeyArgs['VIN'], 0, 8) . '%' . substr($KeyArgs['VIN'], 9, 1);
        $vinObject->STATE           = $KeyArgs['State'];
        $vinObject->Mileage->Value  = $KeyArgs['Mileage'];
        return $vinObject;
    }


    function object_2_array(stdClass $Class){
        # Typecast to (array) automatically converts stdClass -> array.
        $Class = (array)$Class;
        
        # Iterate through the former properties looking for any stdClass properties.
        # Recursively apply (array).
        foreach($Class as $key => $value){
            if(is_object($value)&&get_class($value)==='stdClass'){
                $Class[$key] = self::object_2_array($value);
            }
        }
        return $Class;
    }


    function object_2_xml(stdClass $Class){
        # Typecast to (array) automatically converts stdClass -> array.
        $Class = (array) $Class;
        
        # Iterate through the former properties looking for any stdClass properties.
        # Recursively apply (array).
        foreach($Class as $key => $value){
            if(is_object($value)&&get_class($value)==='stdClass'){
                $Class[$key] = self::object_2_xml($value);
            }
        }
        return $Class;
    }

    # Convert an Array to stdClass.
    function array_2_object(array $array){
        # Iterate through our array looking for array values.
        # If found recurvisely call itself.
        foreach($array as $key => $value){
            if(is_array($value)){
                $array[$key] = self::array_to_object($value);
            }
        }
        
        # Typecast to (object) will automatically convert array -> stdClass
        return (object)$array;
    }

    function CallMethod ( $Method, $KeyArgs ) {
        $log = load_what_is_needed ("log");
        $log->general ( "KeyArgs: " . var_export($KeyArgs, true)  );
        $vinObject = new stdClass();
        $log->general ("NADA Authentication : " . $Method);
        $vinObject = self::getDefaultValues ($KeyArgs, $vinObject);
        foreach ($vinObject as $key => $value) {
            $log->general ( "vinValues: " . $key  );
            if ( is_array($value) || is_object($value) ) {
                $log->general ( "vinValues: " . var_export($value, true)  );
            } else {
                $log->general ( "vinValues: " . $value  );
            }
            # code...
        }
        $log->general ("NADA Authentication : " . __LINE__ . ' ' . $vinObject->Period);
        switch ($Method) {
            case 'GetVehicleConfigurationByVIN':
                $vinObject = self::get_VinPrefix ($vinObject, $vinObject->VinPrefix);  
                $vinObject = self::get_VinAlternateVics($vinObject);       
                $vinObject = self::ValidateAlternateVics ( $vinObject ); 
                $vinObject = self::CleanUpObjects ( $vinObject );     
                return $vinObject;
                break;
            case 'GetVehicleValuesByVehicleConfigurationAllConditions' :
                break;
            default:
                # code...
                break;
        }
    }

    function CleanUpObjects (  $xv  ) {
        $object_to_remove = array ( "nokeys", "tables", "Period", "STATE", "Mileage", "VinPrefix", "VicValues", "VinAlternateVics", "VacValues");

        foreach ( array("DEFAULT", "ALTERNATE") as $k ) {
            if ( isset( $xv->$k ) ) {
                $xv->$k->VicDescriptions = (object) array_merge((array)$xv->$k->VicDescriptions, (array)$xv->$k->VicValues);
                if ( isset($xv->$k->VicDescriptions->Value) && isset($xv->$k->VicDescriptions->Amount ) ) {
                    $xv->$k->VicDescriptions->CleanTradeIn = $xv->$k->VicDescriptions->Value + $xv->$k->VicDescriptions->Amount;
                }
                foreach ( $object_to_remove as $object ) {
                    debug_print ( "removing object: " . $object . ' in ' . $k );
                    unset($xv->$k->$object);
                }
            }
        }
        if ( isset($xv->ALTERNATE) ) {
            foreach ($xv->DEFAULT->VicDescriptions as $key => $value ) {
                $value = trim($value);
                if ( isset($xv->ALTERNATE->VicDescriptions->$key) && ( !is_array($value) ) && (!is_object($value)) ) {
                    $ad_value = trim($xv->ALTERNATE->VicDescriptions->$key);
                    // debug_print ( "cmp: " . strcmp($value, $ad_value));
                    if ( strcmp($value, $ad_value) == 0 ) {         
                        unset ( $xv->ALTERNATE->VicDescriptions->$key );
                    } else {
                        // debug_print ( "removing object: " . $key . ' in ' );
                        // unset ( $xv->ALTERNATE->VicDescriptions->$key );
                    }
                } 
            }
            foreach ($xv->DEFAULT->VacValues as $key => $value ) {
                // debug_print ( $key );
                // debug_print ( $xv->ALTERNATE->VacValues );
                if ( isset($xv->ALTERNATE->VacValues->$key) ) {
                    // debug_print ( $xv->ALTERNATE->VacValues->$key );
                    unset($xv->ALTERNATE->VacValues->$key);
                }
            }
        }    
        return $xv;
    }

    function prepareVinAltValues (  $_vin_values ) {
        $_vin_values->VinPrefix->VIC_Year       = $_vin_values->VinAlternateVics->Alternate_VIC_Year;
        $_vin_values->VinPrefix->VIC_Make       = $_vin_values->VinAlternateVics->Alternate_VIC_Make;
        $_vin_values->VinPrefix->VIC_Body       = $_vin_values->VinAlternateVics->Alternate_VIC_Body;
        $_vin_values->VinPrefix->VIC_Series     = $_vin_values->VinAlternateVics->Alternate_VIC_Series;
        unset($_vin_values->VinAlternateVics);
        return $_vin_values;
    }


    function processCarDetails ( $_vin_values ) {
        //get VicDescriptions
        $_vin_values = self::get_VicDescriptions($_vin_values);

        // $_vin_values = get_Mileage($_vin_values);

        // $_vin_values = get_Segments($_vin_values);
        //VinVacs
        $_vin_values = self::get_VinVacs($_vin_values);

        $_vin_values = self::get_VacBodyIncludes ( $_vin_values );
        //VacValues
        $_vin_values = self::get_VacValues($_vin_values);
        

        $_vin_values = self::get_VacDescriptions($_vin_values);
        //BookFlags
        // $vinObject = get_GvwRatings($vinObject);

        //VicValues
        $_vin_values = self::get_VicValues($_vin_values);
        // echo '<hr/>'; print_r($vinObject); die();
        // VacIncludes
        // $vinObject = get_VacIncludes ( $vinObject );


        return $_vin_values;
    }

    function get_VicDescriptions ( $_vin_values ) {
        $period = $_vin_values->Period;
        $table = "VicDescriptions";
        $fields = array("VIC_Body", "VIC_Series", "VIC_Year", "VIC_Make", "BookFlag");
        $field_values = $_vin_values->VinPrefix;
        
        $pattern = array("__Mileage__"); 
        $replacement = array($_vin_values->Mileage->Value);
        $query = file_get_contents(dirname(__FILE__) . "/vicdescriptions.sql");
        // $query = str_replace(__, "##", $query);
        foreach ( $_vin_values->VinPrefix as $key => $value ) {
            array_push ( $pattern, '__' . $key . '__');
            array_push ( $replacement, $value);
        }
        foreach ($pattern as $key => $value) {
            $query = str_replace($pattern[$key], $replacement[$key], $query);
            # code...
        }

        $condition          = get_condition($fields, $field_values);

        $sql                = $query;//"SELECT * FROM $table WHERE " . $condition . " and Period = '$period'";
        $result             = process_query($sql);
        $num                = mysql_num_rows($result);
        $_vin_values        = get_table_setting ($num, $table, $_vin_values);

        while ($row = mysql_fetch_object($result)) {
            $_vin_values->$table = $row;
            //array_push ( $_vin_values, $row);
        }
        return $_vin_values;
    }

    function get_VinVacs ( $_vin_values ) {
        $period             = $_vin_values->Period;
        $table              = "VinVacs";
        $fields             = array("VinPrefix");
        $field_values       = $_vin_values->VinPrefix;
        
        $condition          = get_condition($fields, $field_values);
        $sql                = "SELECT * FROM $table WHERE " . $condition . " and Period = '$period'";
        $result             = process_query($sql);
        $num                = mysql_num_rows($result);
        $_vin_values        = get_table_setting ($num, $table, $_vin_values);

        while ($row = mysql_fetch_object($result)) {
            $_vin_values->$table = $row;
            //array_push ( $_vin_values, $row);
        }
        return $_vin_values;
    }


    function get_VacBodyIncludes ( $_vin_values ) {
        $period             = $_vin_values->Period;
        $table              = "VacBodyIncludes";
        $fields             = array("VIC_Body", "VIC_Make", "VIC_Year", "VIC_Series");
        $field_values       = $_vin_values->VicDescriptions;
        $condition          = get_condition ($fields, $field_values);

        $sql                = "SELECT * FROM $table WHERE " . $condition . " and Period = '$period'";
        $result             = process_query($sql);
        $num                = mysql_num_rows($result);
        $_vin_values        = get_table_setting ($num, $table, $_vin_values);
        
        while ($row = mysql_fetch_object($result)) {
            // $_vin_values->$table->{$table . '_' . $row->IncludedVAC} = $row;
            $row->VAC = $row->IncludedVAC;
            $_vin_values->VacValues->{$row->IncludedVAC} = $row;
            debug_print ( $_vin_values->VacValues->{$row->IncludedVAC} );
        }
        return $_vin_values;        
    }

    function get_VacValues($_vin_values) {
        $period             = $_vin_values->Period;
        $table              = "VacValues";
        $fields             = array("VIC_Make", "VIC_Year", "OptionTable", "ValueType");
        $field_values       = $_vin_values->VicDescriptions;
        $condition          = get_condition($fields, $field_values); 
        $sql                = "SELECT * FROM $table WHERE " . $condition . " " . addRegionCondition ( $_vin_values ) . " and Period = '$period'";
        $result             = process_query($sql);
        $num                = mysql_num_rows($result);
        $_vin_values        = get_table_setting ($num, $table, $_vin_values);
        while ($row = mysql_fetch_object($result)) {
            $row->VAC = get_converted_format ( "VAC", $row->VAC );
            if ( isset( $_vin_values->$table->{$row->VAC} ) ) {
                foreach ($row as $key => $value) {
                    $_vin_values->$table->{$row->VAC}->$key = $value;
                }
            } else {
                $_vin_values->$table->{$row->VAC} = $row;
            }
            //array_push ( $_vin_values, $row);
        }

        return $_vin_values;
    }

    function get_VacDescriptions( $_vin_values ) {
        $period             = $_vin_values->Period;
        $table              = "VacDescriptions";

        if ( is_object($_vin_values->VacValues)) {
            goto get_VacDescriptions_continue;
        } else {
            goto get_VacDescriptions_next;
        }

        get_VacDescriptions_continue:

        foreach ( $_vin_values->VacValues as $key => $array_value ) {       
            if ( strlen($condition) > 0 ) {
                $condition .= " OR ";
            }
            $condition .= " VAC = '" . get_converted_format("VAC", $key) . "' ";
        }
        $sql                = "SELECT * FROM $table WHERE " . $condition . " and Period = '$period'";
        $result             = process_query($sql);
        $num                = mysql_num_rows($result);
        $_vin_values        = get_table_setting ($num, $table, $_vin_values);
        while ($row         = mysql_fetch_object($result)) {
            debug_print ( $_vin_values->VacValues->{$row->VAC} );
            foreach ( $row as $k => $v ) {
                if ( $k != "VAC") {
                    $_vin_values->VacValues->{$row->VAC}->$k = $v;  
                }
            }
        }

        get_VacDescriptions_next:

        return $_vin_values;
    }

    function get_VicValues($_vin_values) {
        $period             = $_vin_values->Period;
        $table              = "VicValues";
        $fields             = array("VIC_Make", "VIC_Year", "VIC_Series", "VIC_Body", "ValueType");
        $field_values       = $_vin_values->VicDescriptions;
        $condition          = get_condition($fields, $field_values);
        $sql                = "SELECT * FROM $table WHERE " . $condition . " " . addRegionCondition ( $_vin_values ) . " and Period = '$period'";
        $result             = process_query($sql);
        $num                = mysql_num_rows($result);
        $_vin_values        = get_table_setting ($num, $table, $_vin_values);
        while ($row = mysql_fetch_object($result)) {
            $_vin_values->$table = $row;
            //array_push ( $_vin_values, $row);
        }

        return $_vin_values;    
    }



    function ValidateAlternateVics ( $_vin_values ) {
        foreach ($_vin_values as $key => $value ) {
            # code...
            $DEFAULT->$key      = $value;
            $ALTERNATE->$key    = $value;
        }

        if ( isset ( $_vin_values->VinAlternateVics ) ) {
            $DEFAULT        = self::processCarDetails ( $DEFAULT );
            $ALTERNATE      = self::processCarDetails ( self::prepareVinAltValues ( $ALTERNATE ) );
        } else {
            $DEFAULT        = self::processCarDetails ( $DEFAULT );
            unset ($ALTERNATE);
        }

        $xv->DEFAULT        = $DEFAULT;
        if ( isset( $ALTERNATE )) {
            $xv->ALTERNATE  = $ALTERNATE;    
        }

        unset($DEFAULT);
        unset($ALTERNATE);
        unset($vinObject);

        return $xv;
    }    
    /*
    *   function:   get_VinPrefix
        arguements: vinObject and VinPrefix
        returns:    vinObject
    */
    function get_VinPrefix ( $_vin_values, $vin_prefix ) {
        $period             = $_vin_values->Period;
        $table              = 'VinPrefix';
        $fields             = array ("VinPrefix");
        $field_values       = array ('VinPrefix' => $vin_prefix);
        
        $pattern            = array("__Mileage__"); 
        $replacement        = array($_vin_values->Mileage->Value);

        foreach ( $_vin_values as $key => $value ) {
            if ( is_array($value) || is_object($value) ) {
            } else {
                array_push ( $pattern, '__' . $key . '__');
                array_push ( $replacement, $value);         
            }
        }
        $query              = file_get_contents(dirname(__FILE__) . "/vinprefix.sql");
        foreach ($pattern as $key => $value) {
            $query          = str_replace($pattern[$key], $replacement[$key], $query);
        }

        $condition = "";
        foreach ( $fields as $field ) {
            if ( strlen($condition) > 0 ) {
                $condition .= "and ";
            }
            $condition .= $field . " LIKE '" . $field_values[$field] . "'";
        }
        $sql                = $query;//"SELECT * FROM $table WHERE " . $condition . " and Period = '$period'";

        $result             = process_query($sql);
        $num                = mysql_num_rows($result);
        $_vin_values        = get_table_setting ($num, $table, $_vin_values);

        while ($row = mysql_fetch_object($result)) {
            debug_print ( $row );
            $_vin_values->$table = $row;
        }

        return $_vin_values;
    }

    function get_VinAlternateVics ( $_vin_values ) {
        $period = $_vin_values->Period;
        $table = "VinAlternateVics";
        $fields = array("Default_Vic_Body", "Default_Vic_Series", "Default_Vic_Year", "Default_Vic_Make");
        $field_values = array ( 
            "Default_Vic_Make"      => $_vin_values->VinPrefix->VIC_Make, 
            "Default_Vic_Year"      => $_vin_values->VinPrefix->VIC_Year ,
            "Default_Vic_Series"    => $_vin_values->VinPrefix->VIC_Series ,
            "Default_Vic_Body"      => $_vin_values->VinPrefix->VIC_Body 
        );

        $condition          = get_condition($fields, $field_values);
        $sql                = "SELECT * FROM $table WHERE " . $condition . " and Period = '$period'";
        $result             = process_query($sql);
        $num                = mysql_num_rows($result);
        $_vin_values        = get_table_setting ($num, $table, $_vin_values);

        while ($row = mysql_fetch_object($result)) {
            $_vin_values->$table = $row;
            //array_push ( $_vin_values, $row);
        }

        return $_vin_values;
    }
}
?>
