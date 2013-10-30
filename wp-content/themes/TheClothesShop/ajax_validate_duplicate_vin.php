<?php

include '../../../wp-load.php';
include (TEMPLATEPATH . "/lib/pages/get_posts_list.php");	
$xml = load_what_is_needed ("xml");
$debug = $_REQUEST['debug'];
if ( $text_output ) {
	$debug = true;
}

if (!isset($debug) && $debug != date('Ymd') || ( ! $text_output ) )	 {
	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
		header("Content-type: application/xhtml+xml;charset=utf-8"); 
	} else {
		header("Content-type: text/xml;charset=utf-8");
	}	
}

if ( isset($_GET['vin']) && strlen($_GET['vin']) > 0 ) { //got vin
	//query database
	echo check_duplicate ( $_GET );
}

function check_duplicate ( $obj ) {
	global $xml;
	$args['meta_key'] = 'ad_vin';
	$args['meta_value'] = $obj['vin'];
	if ( isset($obj['debug'])) {
		print_r($args);
	}
	$myposts = get_posts ( $args );
	if ( isset($obj['debug'])) {
		print_r($myposts);
	}
	foreach( $myposts as $post ) :	setup_postdata ( $post );
		if ( $post->post_status == 'approved' || $post->post_status == 'pending' || $post->post_status == 'publish' ) {			
			return $xml->generate_valid_xml_from_array($post, "post");
			exit(NULL);
		}
	endforeach;
	return "<empty/>";	
}


?>