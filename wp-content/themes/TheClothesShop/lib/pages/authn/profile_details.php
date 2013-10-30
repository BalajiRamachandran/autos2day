<table class='widefattable' width="100%">
    <thead>
        <tr>
            <td colspan="5"><?php echo 'Customer Profile: ' . $parsedresponse->profile->customerProfileId;?></td>
        </tr>
        <tr>
            <?php
            if ( !isset($parsedresponse->profile->paymentProfiles)) {
                ?>
                <td colspan="5">You must have One payment profile to continue.</td>
                <?php
            }
            ?>
        </tr>
        <tr>
            <td>customerProfileId</td>
            <td>PaymentProfileId</td>
            <td>CreditCard</td>
            <td>Expiration</td>
            <td>Action</td>
        </tr>
    </thead>
<?php
$UPDATES = new stdClass();
if ( isset($parsedresponse->profile) && isset($parsedresponse->profile->paymentProfiles) ) {

    foreach ( $parsedresponse->profile->paymentProfiles as $key ) {
    unset($action);
    $profileId = (string) $key->customerPaymentProfileId;
    $UPDATES->$profileId = $key;
    ?>
    <tr>
        <?php
            $attrs = ' customerProfileId="' . $parsedresponse->profile->customerProfileId . '"';
            $attrs .= ' customerPaymentProfileId="' . $key->customerPaymentProfileId . '"';
        ?>
        <td><?php echo $parsedresponse->profile->customerProfileId; ?></td>
        <td><?php echo $key->customerPaymentProfileId; ?></td>
        <td><?php echo $key->payment->creditCard->cardNumber; ?></td>
        <td><?php echo $key->payment->creditCard->expirationDate; ?></td>
        <td>
            <button id="update" <?php echo $attrs; ?>>Update</button>
            <?php if(count($parsedresponse->profile->paymentProfiles) > 1) {?>
            &nbsp;|&nbsp;
            <button id="delete" <?php echo $attrs; ?>>Delete</button>
            <?php }?></td>
    </tr>
    <?php
    }

} else {
    if ( count ( $parsedresponse->profile->paymentProfiles ) == 0 ) {
        echo '<tr><td colspan="5"><center>No Payment Profile Exists<br/>Please add a payment profile to proceed.</center></td></tr>';
        $action = 'add';
    }    
}
echo '<tr class="no_profile_exists"><td colspan="5" style="text-align: right;"><button id="add" style="float: none;">Add</button></td></tr>';
?>
</table>