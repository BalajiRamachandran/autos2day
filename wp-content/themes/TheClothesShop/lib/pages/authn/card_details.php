<?php
session_start();

include_once ( dirname(__FILE__) . '/scripts.php');
include_once ( dirname(__FILE__) . '/authn_vars.php');

// get_header();
?>

<?php

$action = $_POST['action'];
$customerProfileId = $_POST['customerProfileId'];
$customerPaymentProfileId = $_POST['customerPaymentProfileId'];

?>

<?php

$AUTH_NET_PROFILE = get_user_meta ($user->ID, $authorize_net_variables['AUTH_NET_PROFILE'], true);

?>


<style type="text/css">
.widefattable {
    /*background: #DDD;*/
    border: 1px solid;
    padding: 10px;
}
.no_profile_exists td {
    font-size: 110%;
}
span.reference{
    position:fixed;
    left:5px;
    top:5px;
    font-size:10px;
    text-shadow:1px 1px 1px #fff;
}
span.reference a{
    color:#555;
    text-decoration:none;
    text-transform:uppercase;
}
span.reference a:hover{
    color:#000;
    
}
h1{
    color:#ccc;
    font-size:36px;
    text-shadow:1px 1px 1px #fff;
    padding:20px;
}
#content {
    width: 80%;
}
.widefattable td {
    text-align: center;
}
.widefattable thead td {
    text-align: center;
    padding: 10px;
    border: 1px solid;
    font-size: 110%;
}
.widefattable button {
    padding: 6px;
    width: 100px;
}
#steps form p {
    padding: 0px;
}
</style>
<form action="#" id="id_action" method="POST">
</form>
<script type="text/javascript">
jQuery(document).ready(function() {
    // jQuery("#wrapper").hide();
    if ( jQuery(".card_details #customerPaymentProfileId").val() != '' ) {
        jQuery("*[xvalue]").each(function(){
            jQuery(this).val(jQuery(this).attr("xvalue"));
        });        
    }
    jQuery("#dealer_address").change(function(){
         if ( jQuery("#dealer_address").is(":checked") ) {
            jQuery("*[xvalue]").each(function(){
                jQuery(this).val(jQuery(this).attr("xvalue"));
            });
         } else {
            jQuery("*[xvalue]").each(function(){
                jQuery(this).val('');
            });            
         }
    });
    jQuery (".widefattable button").click(function(){
            jQuery("#id_action").html('');
            jQuery("#id_action").append("<input type='hidden' name='customerProfileId' value='" + jQuery(this).attr("customerProfileId") + "'" + "/>");
            jQuery("#id_action").append("<input type='hidden' name='customerPaymentProfileId' value='" + jQuery(this).attr("customerPaymentProfileId") + "'" + "/>");
            jQuery("#id_action").append("<input type='hidden' name='action' value='" + jQuery(this).attr("id") + "'/>");
            jQuery("#id_action").submit();

    });
});
</script>

<div id="content">

<?php



if ( isset( $customerProfileId ) && ! isset($action) ) {
    $log->general (__LINE__ . ' Creating Payment profile for: ' . $customerProfileId);
    $log->general (__LINE__ . ' Creating Payment profile action for: ' . $action);
// Array
// (
//     [address] => 42319 CAPITAL TERR
//     [city] => CHANTILLY
//     [state] => VA
//     [country] => United States
//     [zipcode] => 20152
//     [card_name] => Balaji Ramachandran
//     [cardNumber] => 41111
//     [expirationDate] => 07/2012
//     [customerProfileId] => 8073563
// )    
    // insert/update address and cc details.
    $CustomerName = explode(" ", trim($_POST['card_name']));
    $createCustomerPaymentProfileRequest                                                        =   new stdClass();
    $createCustomerPaymentProfileRequest                                                        =   MerchantAuthentication ( $createCustomerProfileRequest );
    $createCustomerPaymentProfileRequest->customerProfileId                                     =   $customerProfileId;
    $createCustomerPaymentProfileRequest->paymentProfile->billTo->firstName                     =   $CustomerName[0];
    $createCustomerPaymentProfileRequest->paymentProfile->billTo->lastName                      =   $CustomerName[1];
    $createCustomerPaymentProfileRequest->paymentProfile->billTo->address                       =   $_POST['address'];
    $createCustomerPaymentProfileRequest->paymentProfile->billTo->city                          =   $_POST['city'];
    $createCustomerPaymentProfileRequest->paymentProfile->billTo->state                         =   $_POST['state'];
    $createCustomerPaymentProfileRequest->paymentProfile->billTo->zip                           =   $_POST['zip'];
    $createCustomerPaymentProfileRequest->paymentProfile->billTo->country                       =   $_POST['country'];
    $createCustomerPaymentProfileRequest->paymentProfile->payment->creditCard->cardNumber       =   $_POST['cardNumber'];
    $createCustomerPaymentProfileRequest->paymentProfile->payment->creditCard->expirationDate   =   $_POST['expirationDate'];
    $createCustomerPaymentProfileRequest->validationMode                                        =   "testMode";
    $content                                                                                    =   $xml->generate_valid_xml_from_array($createCustomerPaymentProfileRequest, "createCustomerPaymentProfileRequest");
    $content                                                                                    =   addXMLNamespace ($content, "createCustomerPaymentProfileRequest");
    $response = send_xml_request($content);
    $parsedresponse = parse_api_response($response);

    if ( $parsedresponse->messages->resultCode == 'Error' ) {
        // header('Location: ' . $_REQUEST['REQUEST_URI'] . "?" . http_build_query ($parsedresponse->messages->message)  );
        $ERROR = $parsedresponse->messages->message;
        // exit(NULL);
    }

} elseif ( isset($action) ) {

    $log->general (__LINE__ . ' processing action : ' . $action);

    switch($action) {
        case 'update':
            break;
        case 'delete':
            $customerProfileId = $customerProfileId;
            $deleteCustomerPaymentProfileRequest                    =   new stdClass();
            $deleteCustomerPaymentProfileRequest                    =   MerchantAuthentication ( $deleteCustomerPaymentProfileRequest );
            $deleteCustomerPaymentProfileRequest->customerProfileId =   $customerProfileId;
            $deleteCustomerPaymentProfileRequest->customerPaymentProfileId =   $customerPaymentProfileId;
            $content                                                       =   $xml->generate_valid_xml_from_array($deleteCustomerPaymentProfileRequest, "deleteCustomerPaymentProfileRequest");
            $content                                                       =   addXMLNamespace ($content, "deleteCustomerPaymentProfileRequest");
            $response = send_xml_request($content);
            $parsedresponse = parse_api_response($response);
            break;
        case 'add' :
            $customerProfileId = get_user_meta ($user->ID, "customerProfileId", true);
            break;
        case 'create':
            $createCustomerProfileTransactionRequest    =   new stdClass();
            $createCustomerProfileTransactionRequest                    =   MerchantAuthentication ( $createCustomerProfileTransactionRequest );
            // $createCustomerProfileTransactionRequest->transaction->
            break;
        default:
            break;
    }
} else {
    //no action
    // no profile.
    if ( isset($_GET['noauth']) && strlen( $AUTH_NET_PROFILE ) == 0 ) {
        $log->general (__LINE__ . ' Creating profile for : ' . $user->ID);
        include (dirname(__FILE__) . '/create_customer_profile.php');
    }
}

?>


<?php
    $parsedresponse = retrieve_customer_profile( $AUTH_NET_PROFILE );
    if (isset($_GET['nopayment']) && !isset($parsedresponse->profile->paymentProfiles)) {
        $action = 'add';
    } else {
        $response = retrieve_payment_profiles( $user );
        $parsedresponse = parse_api_response($response);    
    }
    include (dirname(__FILE__) . "/profile_details.php");    

?>


    <?php

    $log->general (__LINE__ . ' Action : ' . $action); 
    if ( isset($_POST['action']) ) {
        $action = $_POST['action'];
    }
    if ( isset($action) ) {
        switch( $action) {
            case 'add' :
                include (dirname(__FILE__) . '/new_card_form.php');
            break;
            case 'update' :
                include (dirname(__FILE__) . '/new_card_form.php');
            break;
            default:
                echo 'unknown ' . $action;
            break;
        }

        // print_r($user_meta);
        ?>
        <script type="text/javascript">
            jQuery("#wrapper").show();
            jQuery("#wrapper").dialog( { closeOnEscape: false, dialogClass: 'no-close', closeText: 'hide', minHeight: 500, minWidth: 720, width: 620, modal: true, resizable: false, title: '<?php echo $_POST[action];?>' });
        </script>
        <?php
    } 
?>
</div>


<?php


?>