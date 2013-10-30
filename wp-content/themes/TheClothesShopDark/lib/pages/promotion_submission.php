<?php
include dirname(__FILE__) . '/../../../../../wp-load.php';
unset ( $_GET['_']);

$message = "System error! Try again Latter!";
$table = "promotions";

if ( isset($_GET['othersource']) ) {
	unset ( $_GET['source'] );
	$_source  = $_GET['othersource'];
	$_name = $_GET['name'];
	$_email = $_GET['email'];
	//check dupliacate email
	$sql = "SELECT * from $table where Email = '$_email' ;";
	$result = mysql_query($sql);
	$nums = mysql_num_rows($result);
	if (  $nums > 0 ) {
		$message = "<div class='exist'>You have entered to promotion already!</div>";
	} elseif ( mysql_error()) {
	} else {
		$sql = "INSERT INTO $table (Name, Email, Source, SubmitDate ) VALUES ('$_name', '$_email', '$_source', CURDATE() );";
		$result = mysql_query( $sql );
		if ( mysql_error() ) {
			$message = "Error entering in to promotion!, Please try again latter!";// . mysql_error() . "///" . $sql;			
		} else {
			$message = "You have been successfully entered in to promotion!";
		}
	}
}
echo $message;
?>