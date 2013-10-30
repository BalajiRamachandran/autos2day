<?php
	// require ( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );
	require ( dirname(__FILE__) . '/../../../../../../wp-load.php' );
	$rename_bmp_to_jpg = "UPDATE  wp_posts SET guid = replace(guid, '.bmp', '.jpg') where guid LIKE '%" . $_GET['f'] . "%'";
	$result = mysql_query($rename_bmp_to_jpg);
	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
		header("Content-type: application/xhtml+xml;charset=utf-8"); 
	} else {
		header("Content-type: text/xml;charset=utf-8");
	}	

	$conversion = new SimpleXMLElement ( "<conversion></conversion>");
	$conversion->addChild("file", $_GET['f']);
	if ( mysql_affected_rows() > 0 ) {
		$conversion->addChild("status", "Successfully Renamed");
		exec ( 'mv ' . $_GET['file'] . ' ' . $_GET['file'] . 'converted' );
	} else {
		$conversion->addChild("status")->addChild("error", "Image Reference Not found in Database");
	}
	echo $conversion->asXML();
?>