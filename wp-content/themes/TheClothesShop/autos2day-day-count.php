<?php

/* setup cron job */
   include dirname(__FILE__) . '/../../../wp-load.php';
   include (TEMPLATEPATH . "/lib/pages/get_posts_list.php");	

	$log = load_what_is_needed ("log");
	$args['post_status'] = array ('publish');		
	$loghtml = new stdClass;
	$loghtml->args = (object) $args;
	$myposts = get_posts( $args );
	echo "\r\n***************************\r\n";
	echo 'Total Deal to Process: ' . count ( $myposts ) . "\r\n";
	echo "\r\n***************************\r\n";

	foreach( $myposts as $post ) :	setup_postdata ( $post );
	$_post_date = $post->post_date;
	$skip_update == 'none';
	$post_meta = get_post_meta ( $post->ID, '', false );
	// if ( isset($post_meta['last_published']) && $post_meta['last_published'][0] != date('Y-m-d') ) {
	// 	update_post_meta ( $post->ID, 'dates_published', $post_meta['last_published'][0] . ', ' . date('Y-m-d'));
	// }	
	update_post_meta ( $post->ID, 'last_published', date('Y-m-d'));
	update_post_meta ( $post->ID, 'days_published', get_post_meta ($post->ID, 'days_published', true) + 1 );
	echo "\n" . get_post_meta ($post->ID, 'days_published', true);
	endforeach;
?>