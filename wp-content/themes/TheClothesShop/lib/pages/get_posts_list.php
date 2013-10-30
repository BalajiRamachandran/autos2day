<?php
	$current_user = wp_get_current_user();
	$args = array( 
		'numberposts' => 100000, 
		'orderby'     => 'post_date',
		'post_status' 	=>	'null',
		'post_parent'	=>	0
	);
	// if non admin limit to their posts
	if ( ! current_user_can( 'administrator' ) ) {
		// print_r($current_user);
		// $args['meta_key'] = 'author';
		// $args['meta_value'] = $current_user->ID;
	} else {
	}
?>