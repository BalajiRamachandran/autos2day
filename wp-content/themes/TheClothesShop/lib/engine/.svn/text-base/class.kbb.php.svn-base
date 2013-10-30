<?php

class Kbb {



    // $VINValidation = array (
    //     'V' => "Valid VIN",
    //     'I' => "Incomplete",
    //     'N' => "Not Valid",
    //     'E' => "Error Encountered"
    // );


    function getObject () {
        $objClient = new SoapClient(
            get_option('KBB_URL'), 
            array(
                'trace' => 1, 
                'exceptions' => true 
                )
            ); 
        return $objClient;
    }

    function getDefaultValues ($KeyArgs) {
        $log = load_what_is_needed ("log");
        $defaultValues = array ( 
                'VehicleClass'          =>  'UsedCar',
                'ApplicationCategory'   =>  'Dealer',
                'VersionDate'           =>  date('Y-m-d')
            );   
        $KeyArgs['VehicleClass'] = 'UsedCar';
        $KeyArgs['ApplicationCategory'] = 'Dealer';
        $KeyArgs['VersionDate'] = date('Y-m-d');
        return $KeyArgs;
    }

    function addAuthKey ( $authResult, $KeyArgs ) {
        $array_ = array ( 'AuthenticationKey' => $authResult );
        $KeyArgs = array_merge((array)$array_, (array)$KeyArgs);
        return $KeyArgs;
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


    function Authenticate ( $KeyArgs ) {
        global $OPTION;
        $objClient = self::getObject ();
        $log = load_what_is_needed ("log");
        $auth = array (
            'Username' => get_option('KBB_Username'), 
            'Password' => get_option('KBB_Password')
        );        
        $auth_key = $_SERVER['HTTP_HOST'] . '_KBB_AuthResult';
        $log->general (
            "KBB Authentication Username: " . $auth['Username'] . ' Password: ' . $auth['Password']
        );
        $log->general ( __LINE__ . ' reauth: ' . $KeyArgs['reauth']);
        if ( get_option($auth_key) && $KeyArgs['reauth'] < 1 ) {
            return get_option($auth_key);
        }
        $log->general ( __LINE__ . ' reauth: ' . $KeyArgs['reauth']);
        $KeyArgs['reauth'] = "0";
        unset($KeyArgs['reauth']);        
        $authKey = $objClient->Login($auth);
        $authResult = $authKey->LoginResult;    
        delete_option($auth_key);    
        add_option( $auth_key, $authResult, '', 'yes' );
        return $authResult;
    }

    function CallMethod ( $Method, $KeyArgs ) {
        $log = load_what_is_needed ("log");
        $objClient = self::getObject ();
        $authResult = self::Authenticate( $KeyArgs );
        $log->general ("KBB Authentication authResult: " . $authResult);
        $KeyArgs = self::addAuthKey ( $authResult, $KeyArgs  );
        $KeyArgs = self::getDefaultValues ($KeyArgs);
        $log->general ("KBB Authentication : " . $Method);
        switch ($Method) {
            case 'ValidateVIN':
                # code...
                return $objClient->$Method($KeyArgs);
                break;
            case 'GetVehicleConfigurationByVIN':
                try {
                    $vinValidation = $objClient->ValidateVIN( $KeyArgs );
                } catch ( Exception $e ) {
                    $log->general ("Exception : " . $e->faultstring);
                    if ( $e->faultstring == "Access is denied." ) {
                        $KeyArgs['reauth'] += 1;
                        if ( $KeyArgs['reauth'] > 3) {
                            $response->Error = "Authentication Failed";
                            return $response;
                            die();
                        }
                        self::CallMethod($Method, $KeyArgs);
                    }
                }
                if ( $vinValidation->ValidateVINResult != "V" ) {
                    $vinValidation->Errors = "Invalid VIN no";
                    return $vinValidation;
                    break;
                }
                $log->general ("KBB Authentication : " . $vinValidation->ValidateVINResult);
                $response = $objClient->$Method($KeyArgs);
                return $response;
                break;
            case 'GetVehicleValuesByVehicleConfigurationAllConditions' :
                $VehicleValues = $objClient->$Method($KeyArgs);
                return $VehicleValues;//->GetVehicleValuesByVehicleConfigurationAllConditionsResult->ValuationPrices->Valuation;
                //return $objClient->$Method($KeyArgs);
                break;
            default:
                # code...
                break;
        }
    }
}
?>
