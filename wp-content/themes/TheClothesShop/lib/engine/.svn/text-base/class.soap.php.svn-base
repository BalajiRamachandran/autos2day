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
        $defaultValues = array ( 
                'VehicleClass'          =>  'UsedCar',
                'ApplicationCategory'   =>  'Dealer',
                'VersionDate'           =>  date('Y-m-d')
            );        
        return array_merge((array)$defaultValues, (array)$KeyArgs);
    }

    function Authenticate (  ) {
        $objClient = self::getObject ();
        $auth = array (
            'Username' => get_option('KBB_Username'), 
            'Password' => get_option('KBB_Password')
        );        
        $authKey = $objClient->Login($auth);
        $authResult = $authKey->LoginResult;        
        return $authResult;
    }

    function CallMethod ( $Method, $KeyArgs ) {
        $objClient = self::getObject ();
        $authResult = self::Authenticate();
        $KeyArgs = self::addAuthKey ( $authResult, $KeyArgs  );
        $KeyArgs = self::getDefaultValues ($KeyArgs);
        switch ($Method) {
            case 'ValidateVIN':
                # code...
                return $objClient->$Method($KeyArgs);
                break;
            case 'GetVehicleConfigurationByVIN':
                return $objClient->$Method($KeyArgs);
                break;
            case 'GetVehicleValuesByVehicleConfigurationAllConditions' :
                $vehicleConfiguration = self::CallMethod("GetVehicleConfigurationByVIN", $KeyArgs);
                //print_r ( $KeyArgs );
                return $vehicleConfiguration;
                //return $objClient->$Method($KeyArgs);
            default:
                # code...
                break;
        }
    }

    // function build_args ( $Method, $args ) {
    //     switch ($Method) {
    //         case 'ValidateVIN':
    //             return array ('VIN' => $args->VIN );
    //             break;
    //         case 'GetVehicleConfigurationByVIN':
    //             return return array ('VIN' => $args->VIN, 'ZipCode' => $args->ZipCode, 'VersionDate' => date('Y-m-d'));
    //             break;
    //         case 'GetVehicleValuesByVehicleConfigurationAllConditions' :
    //             //print_r ( $KeyArgs );
    //             return $objClient->$Method($KeyArgs);
    //         default:
    //             # code...
    //             break;
    //     }

    // }

    function addAuthKey ( $authResult, $KeyArgs ) {
        $array_ = array ( 'AuthenticationKey' => $authResult );
        $KeyArgs = array_merge((array)$array_, (array)$KeyArgs);
        return $KeyArgs;
    }


    function object_to_array(stdClass $Class){
        # Typecast to (array) automatically converts stdClass -> array.
        $Class = (array)$Class;
        
        # Iterate through the former properties looking for any stdClass properties.
        # Recursively apply (array).
        foreach($Class as $key => $value){
            if(is_object($value)&&get_class($value)==='stdClass'){
                $Class[$key] = object_to_array($value);
            }
        }
        return $Class;
    }

    # Convert an Array to stdClass.
    function array_to_object(array $array){
        # Iterate through our array looking for array values.
        # If found recurvisely call itself.
        foreach($array as $key => $value){
            if(is_array($value)){
                $array[$key] = array_to_object($value);
            }
        }
        
        # Typecast to (object) will automatically convert array -> stdClass
        return (object)$array;
    }



}
?>
