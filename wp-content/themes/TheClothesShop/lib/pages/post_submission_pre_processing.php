<?php

		$logged_in_user = $current_user->ID;
		$log->general("Post ID: " . $post_id, $post_id . '_');
		$log->general("Logged in User: " . $logged_in_user, $post_id . '_');
		$log->general("Setting deal-date: " . date(get_option('expiration_format')), $post_id . '_');
		validate_exp_deal_date ( $post_id, date(get_option('expiration_format')), true);
		//update_post_meta($id, 'expiration-date', $ts);
		foreach ($meta_args as $k => $v) {
			if ( $k != "cc" ) {
				$log->general("Meta: " . $k . "\t" . $v, $post_id . '_');
				update_post_meta($post_id, $k, $v);	
			}
			if ( in_array($k, $tags_array) ) {
				wp_set_post_tags( $post_id, $v, true );				
			}
		}

		/* SEO */
		$post = get_post ( $post_id, 'OBJECT' );
		// update_post_meta ($post_id, "seo_title", $post->post_title);
		// update_post_meta ($post_id, "seo_keywords", );
		// update_post_meta ($post_id, "seo_title", $post->post_title);

		if ( strtoupper(gethostname()) == 'BRAMKASLP01') {
		} else {
			// include (STYLESHEETPATH . "/lib/pages/ad_authorize_payment.php");
		}
		$log->general("Processing Authorization", $post_id . '_');
		try {
			include (STYLESHEETPATH . "/lib/pages/ad_authorize_payment.php");			
		} catch ( Exception $e ) {
			$log->general("Processing Authorization Error: " . $e->getMessage(), $post_id . '_');
			echo $e->getMessage();
			die();
		}

		$_POST['image_resize'] = 'true';
?>