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

//						upload_attachments ( $_FILES );
		for ( $count = 0; $count < 5 ; $count += 1 ) {
			$var = 'upload_images_i' . $count;
			$target_path = wp_upload_dir();

			$file_name = $_FILES[$var]['name'];
			$log->general("Upload Image: " . $var . "\t" . $file_name, $post_id . '_');
			$file_name = str_replace ( "-", "" , $file_name);
			$file_name = str_replace ( " ", "" , $file_name);
			$file_name = str_replace ( "_", "" , $file_name);
			if ( strlen(basename($file_name)) > 10 ) {
				$file_name = substr($file_name, '-10');
			}
			$file_name = strtolower($file_name);
			$log->general("Upload Image(Renamed): " . $var . "\t" . $file_name, $post_id . '_');
			$log->general("Upload Image(Renamed): " . $var . "\terror: " . $_FILES[$var]['error'], $post_id . '_');
		    $file_array = array(
		        'name'      => $post_id . '_' . substr(md5($_FILES[$var]['name']), '-3') . $file_name,
		        'type'      => $_FILES[$var]['type'],
		        'tmp_name'  => $_FILES[$var]['tmp_name'],
		        'error'     => $_FILES[$var]['error'],
		        'size'      => $_FILES[$var]['size']
		    );

		    if ( !empty( $file_array['name'] ) ) {
		        // upload the file to the server									        
		        $upload_overrides 		= array ( 'test_form' => false, 'test_upload' => false );
		        $uploaded_file 			= wp_handle_upload( $file_array, $upload_overrides );
		        // $uploaded_file 			= media_handle_upload ($var, $post_id, array(), $upload_overrides  );
		        // echo "\nProcessing uploaded_file\n";
		        // if ( isset($uploaded_file['error'])) {
		        // 	print_r($uploaded_file);
		        // 	wp_delete_post ( $post_id, true );
		        // 	return;
		        // }
		        // checks the file type and stores in in a variable
		        $wp_filetype 			= wp_check_filetype( basename( $uploaded_file['file'] ), null );   
		        // print_r($wp_filetype);
		        // set up the array of arguments for "wp_insert_post();"

		        //wp_handle_upload
		        //image_resize
		        // echo "\nfiletype\n";
		        // print_r($wp_filetype);

		        $attachment = array(
		            'post_mime_type' => $wp_filetype['type'],
		            'post_title' => preg_replace('/\.[^.]+$/', '', basename( $uploaded_file['file'] ) ),
		            'post_content' => '',
		            'post_author' => $post->post_author,
		            'post_status' => 'inherit',
		            'post_type' => 'attachment',
		            'post_parent' => $post_id,
		            'guid' => $target_path['baseurl'] . '/' . $file_array['name']
		        );

		        // echo "\nattachments\n";
		        // print_r($attachment);

		        // insert the attachment post type and get the ID
		        $attachment_id = wp_insert_post( $attachment );
		        $log->general("Attachment Id: " . $attachment_id, $post_id . '_');
		        // generate the attachment metadata
		        $attach_data = wp_generate_attachment_metadata( $attachment_id, $uploaded_file['file'] );
		        // update the attachment metadata
		        $return = wp_update_attachment_metadata( $attachment_id,  $attach_data );
		        // echo "wp_update_attachment_metadata: " . $return;

		    } // end if ( !empty( $file_array['name'] ) )
		    // die();
		} // end for ( $count = 0; $count < 5 ; $count += 1 )



		// Sucessfull message
		$return .= '<div id="wpip-message" class="wpip-success">' . __( 'Entry successfull added!', 'wp-insert-post' ) . '<br/><a href="' . get_permalink() . '">' . __( 'Add another &raquo;', 'wp-insert-post' ) . '</a></div>';

		// Redirect
		$return .= '
			<script type="text/javascript">
				setTimeout( "location.href = \'' . get_permalink() . '\';", 2000 );
			</script>
		';
?>
	<script type="text/javascript">
		jQuery(".modal").hide();
	</script>