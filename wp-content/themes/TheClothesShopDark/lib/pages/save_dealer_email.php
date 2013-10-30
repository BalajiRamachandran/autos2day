<?php
//save_dealer_email.php
require dirname(__FILE__) . '/../../../../../wp-load.php';

if ( !empty ($_POST[id]) && $_POST[oper] == 'edit') {
	foreach ($_POST as $key => $value) {
		if ( strpos($key, 'Email_') === false ) {

		} else {
			$_key = strtolower(str_replace("_", "", $key));
			echo '<p>' . $_POST['id'] . '  ' . $_key . ' ' . $value . '</p>';
			update_user_meta ( $_POST['id'], $_key, $value);
		}
	}
}
?>