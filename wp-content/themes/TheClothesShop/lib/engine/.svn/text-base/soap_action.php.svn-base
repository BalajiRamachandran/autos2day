<?php

class SoapAction {

    $defaultValues = array ( 
            'vehicleClass'          =>  'UsedCar',
            'applicationCategory'   =>  'Dealer',
            'versionDate'           =>  date('Y-m-d')
        );

    $VINValidation = array (
        'V' => "Valid VIN",
        'I' => "Incomplete",
        'N' => "Not Valid",
        'E' => "Error Encountered"
    );


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
        switch ($Method) {
            case 'ValidateVIN':
                # code...
                return $objClient->$Method($KeyArgs);
                break;
            case 'GetVehicleConfigurationByVIN':
                return $objClient->$Method($KeyArgs);
                break;
            case 'GetVehicleValuesByVehicleConfigurationAllConditions' :
                //print_r ( $KeyArgs );
                return $objClient->$Method($KeyArgs);
            default:
                # code...
                break;
        }
    }

    function build_args ( $Method, $args ) {
        switch ($Method) {
            case 'ValidateVIN':
                return array ('VIN' => $args->VIN );
                break;
            case 'GetVehicleConfigurationByVIN':
                return return array ('VIN' => $args->VIN, 'ZipCode' => $args->ZipCode, 'VersionDate' => date('Y-m-d'));
                break;
            case 'GetVehicleValuesByVehicleConfigurationAllConditions' :
                //print_r ( $KeyArgs );
                return $objClient->$Method($KeyArgs);
            default:
                # code...
                break;
        }

    }

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

//phpinfo();

soap_service ( $wsdl );

function soap_service ($wsdl) {
// Setting "trace" will allow us to view the request that we are making, after we have made it.


    // require_once('class.Convert.php');
    // $object = new Convert();

    $objClient = new SoapClient($wsdl, array('trace' => 1, 'exceptions' => true )); 

    // // These parameters satisfy this specific remote call.
    // $arrParameters_Login = array('username' => 'IDWSSample', 'password' => 'TcYg7m*a');

    // // Invoke the remote call "login()".
    // $objLogin =  $objClient->login($arrParameters_Login); 

    // // Grab session ID that this remote call will provide.
    // $strSessionID = $objLogin->loginReturn->sessionId;

    $auth = array (
        'Username' => 'IDWSSample', 
        'Password' => 'TcYg7m*a'
    );

    echo '<h3>Login</h3>';
    $authKey = $objClient->Login($auth);

    $authResult = $authKey->LoginResult;



    $defaultValues = array ( 
            'vehicleClass'  =>  'UsedCar',
            'applicationCategory'   =>  'Dealer',
            'versionDate'   =>  date('Y-m-d')
        );

    $args = array (
        'VIN'   =>  '1FAFP444X2F238390'
        );

    $response = "";
    
    echo '<h3>ValidateVIN</h3>';

    $response = CallMethod ( 
        $objClient, 
        $authResult, 
        "ValidateVIN", 
        array( 
            'VIN' => '1FAFP444X2F238390' 
        )  
    );
    print_r ( $response );

    echo '<h3>GetVehicleConfigurationByVIN</h3>';
    $vehicleConfiguration = CallMethod ( 
        $objClient, 
        $authResult, 
        "GetVehicleConfigurationByVIN", 
        array( 
            'VIN' => '1FAFP444X2F238390',
            'ZipCode'   =>  '20152',
            'VersionDate'   =>  date('Y-m-d') 
        )  
    );

    //print_r ( $vehicleConfiguration );

    echo '<h3>GetVehicleValuesByVehicleConfigurationAllConditions</h3>';

    $vehicleConfiguration->GetVehicleConfigurationByVINResult->VehicleConfiguration->Mileage = "65000";

    //print_r((array)$vehicleConfiguration->GetVehicleConfigurationByVINResult->VehicleConfiguration);

    $request = array( 
            'VIN' => '1FAFP444X2F238390',
            'ZipCode'   =>  '20152',
            'VersionDate'   =>  date('Y-m-d'),
            'VehicleConfiguration'  =>  object_to_array($vehicleConfiguration->GetVehicleConfigurationByVINResult->VehicleConfiguration )
    );

    $request = array_merge((array) $request, (array) $defaultValues );

    $GetVehicleValuesByVehicleConfigurationAllConditions = CallMethod ( 
        $objClient, 
        $authResult, 
        "GetVehicleValuesByVehicleConfigurationAllConditions", 
        $request
    );

    echo '<h4>GetVehicleValuesByVehicleConfigurationAllConditions - Response</h4>';

    print_r ( $GetVehicleValuesByVehicleConfigurationAllConditions->GetVehicleValuesByVehicleConfigurationAllConditionsResult->ValuationPrices->Valuation );

    // $response = $objClient->ValidateVIN (
    //     array(
    //         'VIN' => '1FAFP444X2F238390', 
    //         'AuthenticationKey' => $authResult 
    //     ) 
    // );

    // echo "<hr/>";
    // print_r($objClient->__getLastRequest());
    // echo "<hr/>";
    // print_r($objClient->__getLastResponse());
    // echo "<hr/>";

    // print_r($objClient->__getLastRequest());
    // echo '<h1>sessionId</h1>';
    // print_r($objClient->__getLastResponse());
}



    // // Set headers-- The remote call "query()" will require a header pointing to our session.

    // $strHeaderComponent_Session = "<SessionHeader><sessionId>$strSessionID</sessionId></SessionHeader>";

    // $objVar_Session_Inside = new SoapVar($strHeaderComponent_Session, XSD_ANYXML, null, null, null);
    // $objHeader_Session_Outside = new SoapHeader('namespace.com', 'SessionHeader', $objVar_Session_Inside);

    // // More than one header can be provided in this array.
    // $objClient->__setSoapHeaders(array($objHeader_Session_Outside));

    // // Set the query parameters.

    // $strQuery = 'select empID from Time where empID = 92389278';
    // $arrParameters_Query = array('queryString' => $strQuery);

    // // Make call.

    // $objResponse = $objClient->query($arrParameters_Query);

    // header('Content-Type: text/xml; ');
    // print($objClient->__getLastRequest());

//header('Content-Type: application/soap+xml; charset=UTF-8');
#require_once('nusoap.php'); 
#$wsdl = "kbb.wsdl";
// $client = new SoapClient($wsdl, array(
//                         'login' => "IDWSSample",
//                         'password'       => "TcYg7m*a",
//                         'cache_wsdl'=>WSDL_CACHE_NONE, 
//                         'soap_version' => SOAP_1_2,
//                         "user_agent"=>"some_string",
//                         'exceptions' => true, 
//                         'keep_live' => 0,
//                         'trace' => 1,
//                         'uri'   => "http://tempuri.org/",
//                         'connection_timeout' => 120,
//                         'location'  =>  "http://sample.idws.syndication.kbb.com/3.0/VehicleInformationService.svc?wsdl"
//                         ));

function soap_version_2 ( $wsdl ) {
try {
    $client = new SoapClient($wsdl, array(
    'login' => "IDWSSample",
    'password'       => "TcYg7m*a",
    'cache_wsdl'=>WSDL_CACHE_NONE, 
    'soap_version' => SOAP_1_2,
    'exceptions' => true, 
    'keep_live' => 0,
    'trace' => 1,
    'connection_timeout' => 120
    ));

} catch (Exception $e) {
    print_r($e->getMessage());
}
$response = "";
try { 
    $response=$client->GetAvailableMethods(); 
} 
    catch (Exception $e) 
{ 
    echo '<br/>Caught exception: ',  print_r ( $e ), "<hr/>"; 
}
echo "<hr/>RESPONSE HEADERS:<br/>" . $client->__getLastResponseHeaders() . "<br/>";
echo "REQUEST HEADERS:<br/>" . $client->__getLastRequestHeaders() . "<br/>";
echo "Client <br/>" . var_dump ( $client ) . "<hr/>";
print_r ( $client );
echo "Client <br/>";

print_r ( $response );    
}
?>
