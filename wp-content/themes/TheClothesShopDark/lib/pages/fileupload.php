<?php
require dirname(__FILE__) . '/../../../../../wp-load.php';
// get_header();
// print_r($_POST);
// print_r($_GET);
if ( isset($_POST['name']) ) {
	$return = move_uploaded_file($_FILES[$_POST['id']]['tmp_name'], $_POST['name']);
	// print_r($return);
	if ( $return ) {
		$_FILES[$_POST['id']]['tmp_name'] = $_POST['name'];
	} else {
		print_r($return);
	}
	// print_r($_FILES);
}
echo json_encode($_FILES);
?>