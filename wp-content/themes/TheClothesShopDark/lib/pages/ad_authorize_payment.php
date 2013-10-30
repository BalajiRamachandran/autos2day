<?php
	include dirname(__FILE__) . '/../../../../../wp-load.php';
	// include ( TEMPLATEPATH . '/lib/pages/authn/authn_util.php' );

	if ( get_option("disable_payment_processing") == "0" ) {
		$table = is_dbtable_there("a2d_transactions");

		/* Default */

		if ( !isset($trans_mode) || $trans_mode == '' ) {
			$trans_mode = 'auth_only';
		}

		/* Read File */

		$transauth = file_get_contents(STYLESHEETPATH . '/configs/' . $trans_mode . '.xml');
		/* Pass postID */
		// $current_post_id = 2979;
		
		/* Get Post*/
		$current_post = wp_get_single_post ( $authn_id, 'OBJECT' );

		include_once ( STYLESHEETPATH . '/lib/pages/authn_response_fields.php');

		unset ($transTableFields->ID);

		switch ( $trans_mode ) {
			case 'auth_only':
				$search_replace['DateAuthorized'] = current_time('mysql');
				unset ($transTableFields->DateCharged);
				unset ($transTableFields->DateVoided);
				break;
			case 'void':
				$search_replace['DateVoided'] = current_time('mysql');
				unset ($transTableFields->DateCharged);
				unset ($transTableFields->DateAuthorized);
				//2173052588
				break;
			case 'prior_auth_capture':
				$search_replace['DateCharged'] = current_time('mysql');
				unset ($transTableFields->DateVoided);
				unset ($transTableFields->DateAuthorized);		
				break;
			default:
				break;
		}

		$transTableFields->Notes = $trans_mode;

		foreach ($search_replace as $key => $value) {
			$transauth = str_replace('_' . $key . '_', $value, $transauth);		
		}
		
		$response = send_xml_request ( $transauth );
		$parsedresponse = parse_api_response ( $response );
		/* process Error */
		if ( $parsedresponse->messages->resultCode == 'Error' ) {
			// echo '<div class="success">' . '[' . $parsedresponse->messages->message->code . ']' . $parsedresponse->messages->message->text;
			// echo '<br/>';
				if ( $debug ) {
					echo "authn_id: " . $authn_id . '<br/>';
					echo "<p>debug: " . $debug . '</p>';
					print_r($current_post);
					print_r($search_replace );
					echo htmlspecialchars($transauth);
					echo '<br/>';
					echo var_dump($parsedresponse);
				}
			// echo '</div>';
			if ( $trans_mode == 'auth_only') {
				 // wp_delete_post( $current_post->ID );
				 $current_post->post_status = "payment_failed";
			}
			throw new Exception('[' . $parsedresponse->messages->message->code . ']' . $parsedresponse->messages->message->text);
			die();		
		}

		$parsedresponse->directResponse = str_replace("|", "", $parsedresponse->directResponse);

		$directResponseFields = explode(",", $parsedresponse->directResponse);
		
		$Responses = new stdClass();

		foreach ($authorizeNetResponseFields as $key => $value) {
			if ( $directResponseFields[$key] != '' ) {
				$Responses->$value = $directResponseFields[$key];
				if ( isset($transTableFields->$value) ) {
					$transTableFields->$value = $Responses->$value;
				}
			}
		}

		foreach ($transTableFields as $key => $value) {
			if ( $value == '' && isset($search_replace[$key]) ) {
				$transTableFields->$key = $search_replace[$key];
			}
		}

		if ( $Responses->ResponseCode != 1 ) {
			echo '<div class="success">' . $Responses->ResponseReasonText . '</div>';
			throw new Exception($Responses->ResponseReasonText);
			die();
		} else {
			update_post_meta ( $current_post->ID, "TransactionID", $transTableFields->TransactionID ) ;
		}

		if ( $trans_mode == 'auth_only' ) {
			$sql = "INSERT INTO $table ";
			$sql .= "(  " . implode(", ", ( array_keys ( get_object_vars ( $transTableFields ) ) )) . "  )";
			$sql .= "VALUES (  '" . implode("', '", ( array_values ( get_object_vars ( $transTableFields ) ) )) . "'  )";		
			update_post_meta ( $current_post->ID, "ChargeStatus", "Authorized" ) ;	
		} elseif ( $trans_mode == 'void' ) {
			$sql = "UPDATE $table ";
			$sql .= "SET TransactionType = '" . $transTableFields->TransactionType . "'" ;
			$sql .= ", Notes = '" . $transTableFields->Notes . "'" ;
			$sql .= ", DateVoided = '" . $transTableFields->DateVoided . "'" ;
			// $sql .= "'" . str_replace("=", "'='", urldecode(http_build_query($transTableFields, "", "', '"))) . "'";
			$sql .= " WHERE TransactionID = '" . $transTableFields->TransactionID . "'";
			update_post_meta ( $current_post->ID, "ChargeStatus", "Voided" ) ;
		} elseif ( $trans_mode == 'prior_auth_capture' ) {
			$sql = "UPDATE $table ";
			$sql .= "SET TransactionType = '" . $transTableFields->TransactionType . "'" ;
			$sql .= ", Notes = '" . $transTableFields->Notes . "'" ;
			$sql .= ", DateCharged = '" . $transTableFields->DateCharged . "'" ;
			// $sql .= "'" . str_replace("=", "'='", urldecode(http_build_query($transTableFields, "", "', '"))) . "'";
			$sql .= " WHERE TransactionID = '" . $transTableFields->TransactionID . "'";
			update_post_meta ( $current_post->ID, "ChargeStatus", "Charged" ) ;
		}

		$result 			= mysql_query($sql);
		$num 				= mysql_num_rows($result);

		if ( mysql_error() ) {
			echo '<div class="success">' . mysql_error() . '</div>';
			throw new Exception(mysql_error());
			//void transaction
			die();
		}
		unset($authn_id );		
	}


?>