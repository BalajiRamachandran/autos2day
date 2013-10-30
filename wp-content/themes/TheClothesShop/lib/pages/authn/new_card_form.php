<div id="wrapper">
  <div id="customerPaymentProfileId"></div>
  <div id="steps">
    <form action="" method="POST" name="formElem" class="card_details" id="formElem">
      <fieldset class="step">
        <legend>Billing Details</legend>
          <p><input type="checkbox" name="dealer_address" id="dealer_address" style="width: 10px;"/>&nbsp;Click here to pre-populate with dealership address</p>
        <?php 
            foreach ($billTo as $key => $value) {
                    $key = trim($key);
                    $value = trim($value);

                    $keyvalue = validateKeys ( $key );

                    echo '<p>';
                    echo '<label for="' . $key . '">' . $value . '</label>';
                    if ( $key == 'expirationDate' ) {
                            echo '<select name="' . $key . '">';
                            echo expirationDate_settings ();
                            echo '</select>';
                    } else {                                        
                            echo '<input type="text" name="' . $key . '" id="' . $key . '" xvalue="' . $keyvalue . '" required style="opacity: 1" ';
                            echo 'class="reset_value" placeholder="' . $value . '" required/>';
                    }
                    echo '</p>';
            
            }
        ?>
      </fieldset>
      <fieldset class="step">
        <legend>Card Details</legend>
        <?php 
            foreach ($credit_card_details as $key => $value) {
                    $key = trim($key);
                    $value = trim($value);

                    $keyvalue = validateKeys ( $key );

                    echo '<p>';
                    echo '<label for="' . $key . '">' . $value . '</label>';
                    if ( $key == 'expirationDate' ) {
                            echo '<select name="' . $key . '">';
                            echo expirationDate_settings ();
                            echo '</select>';
                    } else {                                        
                            echo '<input type="text" name="' . $key . '" id="' . $key . '" value="' . $keyvalue . '" required style="opacity: 1" ';
                            echo 'class="reset_value" placeholder="' . $value . '" required/>';
                    }
                    echo '</p>';
            
            }
        ?>
      </fieldset>
      <fieldset class="step">
        <legend>Confirm</legend>
        	<p>
        		This creates the profile in http://www.authorize.net PCi Compliance
        	</p>
        <p class="submit">
          <input type="hidden" name="formID" value="<?php echo $AUTH_NET_PROFILE;?>"/>
          <input type="hidden" name="customerProfileId" value="<?php echo $AUTH_NET_PROFILE;?>"/>
          <input type="hidden" name="company" value="<?php echo $user_meta['dealership_name'][0];?>"/>
          <input type="hidden" name="customerPaymentProfileId" value="<?php echo $customerPaymentProfileId;?>"/>
          <button id="registerButton" type="submit">Create</button>
        </p>
      </fieldset>
    </form>
  </div>
  <div id="navigation" style="display:none;">
    <ul>
      <li class="selected">
        <a href="#">Billing Details</a>
      </li>
      <li>
        <a href="#">Card Details</a>
      </li>
      <li>
        <a href="#">Confirm</a>
      </li>
    </ul>
  </div>
</div>
<?php

function expirationDate_settings () {
  $expirationDate_settings = "";
  for ( $i = 1; $i < 36; $i++ ) {
    $dateString = strtotime ( "+" . $i . " month");
    $expirationDate_settings .= '<option value="' . date('Y-m', $dateString ) . '">' . date('M-Y', $dateString ) . '</option>';
  }         
  return $expirationDate_settings;
}

function validateKeys ( $key ) {
    global $user_meta;
    global $billing_address_mapping;
    global $UPDATES;
    global $customerPaymentProfileId;
    $keyvalue = "";    
    switch ( $key ) {
      case 'card_name':
      if ( isset($user_meta['first_name']) && isset($user_meta['last_name'])) {
          $keyvalue = $user_meta['first_name'][0] . ' ' . $user_meta['last_name'][0];
      }
      break;
      default:
        if ( isset($customerPaymentProfileId) && is_object( $UPDATES ) && ( isset($UPDATES->$customerPaymentProfileId) )) {          
          if ( isset($UPDATES->$customerPaymentProfileId->billTo->$key) ) {
            $keyvalue = $UPDATES->$customerPaymentProfileId->billTo->$key;
          } elseif ( isset($UPDATES->$customerPaymentProfileId->payment->creditCard->$key) ) {
            $keyvalue = $UPDATES->$customerPaymentProfileId->payment->creditCard->$key;
          }
        } elseif ( isset($billing_address_mapping[$key])) {
            $v = $billing_address_mapping[$key];
            if ( isset($user_meta[$v])) {
              $keyvalue = $user_meta[$v][0];
            }
          } else {
            $keyvalue = "";
          }
      break;
    }
    return $keyvalue;
}
?>