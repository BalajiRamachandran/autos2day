<?php
    //create customer profile
    $createCustomerProfileRequest                                           =   new stdClass();
    $createCustomerProfileRequest                                           =   MerchantAuthentication ( $createCustomerProfileRequest );
    // $createCustomerProfileRequest->merchantAuthentication->transactionKey   =   get_option('wps_authn_transaction_key');
    $createCustomerProfileRequest->profile->merchantCustomerId              =   get_user_meta ($user->ID, 'dealership_id', true);
    $createCustomerProfileRequest->profile->description                     =   get_user_meta ($user->ID, 'dealership_name', true);
    $createCustomerProfileRequest->profile->email                           =   $user->user_email;

    $content = $xml->generate_valid_xml_from_array($createCustomerProfileRequest, "createCustomerProfileRequest");
    $content = str_replace("<createCustomerProfileRequest", "<createCustomerProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\"", $content);
    // xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
    $response = send_xml_request($content);
    $parsedresponse = parse_api_response($response);
    $resultCode = (string) $parsedresponse->messages->resultCode; 
    if ( $resultCode == 'Error' ) {
        if ( trim($parsedresponse->messages->message->code) == 'E00039' ) {
            //already exists
            $pattern = '/(\d+)/';
            preg_match($pattern, $parsedresponse->messages->message->text, $matches);   
            authn_update_user_meta ($user->ID, $authorize_net_variables['AUTH_NET_PROFILE'], $matches[0]);            
        } else {
            $VALUES['text'] = $parsedresponse->messages->message->text;
            $VALUES['code'] = $parsedresponse->messages->message->code;
            include (dirname(__FILE__) . '/display_error.php');
            exit(NULL);
        }
    } elseif ($resultCode == 'Ok') {
        if ( isset($parsedresponse->customerProfileId) ) {
            authn_update_user_meta ($user->ID, $authorize_net_variables['AUTH_NET_PROFILE'], $parsedresponse->customerProfileId);
        } else {
        }
    } else {
        print_r($parsedresponse);
        $VALUES['text'] = $parsedresponse->messages->message->text;
        $VALUES['code'] = $parsedresponse->messages->message->code;
        include (dirname(__FILE__) . '/display_error.php');
        exit(NULL);
    }

    $AUTH_NET_PROFILE = get_user_meta ($user->ID, $authorize_net_variables['AUTH_NET_PROFILE'], true);
    if ( ! isset($AUTH_NET_PROFILE) ) {
    } else {
        $action = 'add';
    }


    function authn_update_user_meta ($userid, $profile, $value) {
        update_user_meta ( $userid, $profile, (string)$value);            
    }
?>