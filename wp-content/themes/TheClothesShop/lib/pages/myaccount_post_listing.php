<?php
	$WPS_catCol			= $OPTION['wps_catCol_option'];
	$WPS_prodCol		= $OPTION['wps_prodCol_option'];
	$WPS_sidebar		= $OPTION['wps_sidebar_option'];
	$WPS_showposts		= $OPTION['wps_showpostsOverwrite_Option'];
	echo '<div class="theProds clearfix theProds_alt alignleft">';
	foreach( $myposts as $post ) :	setup_postdata ( $post );
		if ( $post->post_author == $current_user->ID ) {

		} else {
			goto process_next;
		}

		$post_meta = get_post_custom ($post->ID); 

		if ( $post->post_status == "trash" || $post->post_status == "auto-draft" || $post->post_status == "expired" ) {
			$log->general ( "Skipping My Posts: " . $post->ID . ' status: ' . $post->post_status);
			goto process_next;
		}

		$log->general ( "My Posts: " . $post->ID . ' status: ' . $post->post_status);


		$current_date = date(get_option('expiration_format'));
		validate_exp_deal_date ($post->ID, $post->post_date, true);

		$post_expiration = get_post_meta ($post->ID, 'expiration-time', true);
		
		// if expiration-time is not set, lets define this

		if ( strlen($post_expiration) > 0 ) {

		} else {
			$post_expiration = post_expiration_date ( $post->post_date );
			// $mktime = strtotime($post->post_date);
			// $post_expiration = mktime(0, 0, 0, date("m", $mktime)  , date("d", $mktime)+2, date("Y", $mktime));
		}
		if ( strtotime($post_expiration) > strtotime($current_date)) {
			//continue
			$log->general ( __LINE__ . " My Posts: " . $post->ID . ' status: ' . $post->post_status);
			goto process_post;
		} else {
			if ( $post->post_status == "publish" ) {
				$post->post_status = "expired";
				wp_update_post( $post );
			}
			if ( ! current_user_can( 'administrator' ) ) {
				goto process_next;
			}
		}
		process_post:
		$post_date = $post->post_date;
		if (( $post->post_author == $current_user->ID ) || ( current_user_can( 'administrator' ) ) ) {
			$output = my_attachment_images($post->ID,2);
			$imgNum = count($output);
				//set the class and resize the product image according to the column selection from the theme options 
				switch($WPS_prodCol){
					case 'prodCol1_ws':
						$the_class 		= alternating_css_class($counter,1,' c_box_first');
						if (($a==1)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box c_box1_ws '. $the_class .' '. $the_row_class;
						$img_size 		= $OPTION['wps_prodCol1_img_size'];
					break;
					
					case 'prodCol2_ns':
						$the_class 		= alternating_css_class($counter,2,' c_box_first');
						if (($a==1) || ($a==2)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box c_box2_ns '. $the_class .' '. $the_row_class;
						$img_size 		= $OPTION['wps_prodCol2n_img_size'];
					break;
					
					case 'prodCol2_ws':
						$the_class 		= alternating_css_class($counter,2,' c_box_first');
						if (($a==1) || ($a==2)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box c_box2_ws '. $the_class .' '. $the_row_class;
						$img_size 		= $OPTION['wps_prodCol3_img_size'];
					break;
					
					case 'prodCol3_ns':
						$the_class 		= alternating_css_class($counter,3,' c_box_first');
						if (($a==1) || ($a==2) || ($a==3)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box c_box3_ns '. $the_class .' '. $the_row_class;
						$img_size 		= $OPTION['wps_prodCol3n_img_size'];
					break;
					
					case 'prodCol3_ws':
						$the_class 		= alternating_css_class($counter,3,' c_box_first');
						if (($a==1) || ($a==2) || ($a==3)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box c_box3_ws '. $the_class .' '. $the_row_class;
						$img_size 		= $OPTION['wps_prodCol3w_img_size'];
					break;
															
					case 'prodCol4_ns':
						$the_class 		= alternating_css_class($counter,4,' c_box_first');
						if (($a==1) || ($a==2) || ($a==3) || ($a==4)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box '. $the_class .' '. $the_row_class;
						$img_size 		= $OPTION['wps_prodCol5_img_size'];
					break;
					
					case 'prodCol4_ws':
						$the_class 		= alternating_css_class($counter,4,' c_box_first');
						if (($a==1) || ($a==2) || ($a==3) || ($a==4)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box c_box4_ws '. $the_class .' '. $the_row_class;
						$img_size 		= $OPTION['wps_prodCol4_img_size'];
					break;
					
					
					case 'prodCol5':
						$the_class 		= alternating_css_class($counter,5,' c_box_first');
						if (($a==1) || ($a==2) || ($a==3) || ($a==4) || ($a==5)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box '. $the_class .' '. $the_row_class;
						$img_size 		= $OPTION['wps_prodCol5_img_size'];
					break;
				} 

		
			echo '<div class="post-' . $post->ID . ' post type-post status-publish format-standard hentry category-sedan c_box c_box1_ws c_box_first ">';
			//added for imageurl for my-account
			$imgURL		= array();
			foreach($output as $v){
			
				$img_src 	= $v;
				// do we want the WordPress Generated thumbs?
				// $OPTION['wps_wp_thumb'] = 0;
				if ($OPTION['wps_wp_thumb']) {
					//get the file type
					$img_file_type = strrchr($img_src, '.');
					//get the image name without the file type
					$parts = explode($img_file_type,$img_src);
					// get the thumbnail dimmensions
					$width = get_option('thumbnail_size_w');
					$height = get_option('thumbnail_size_h');
					//put everything together
					$imgURL[] = $parts[0].'-'.$width.'x'.$height.$img_file_type;
				
				// no? then display the default proportionally resized thumbnails
				} else {
					$des_src 	= $OPTION['upload_path'].'/cache';							
					// $des_src 	= $OPTION['upload_path'].'';							
					$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');
					$imgURL[] 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;	
				}
		
			}
			//end: added for imageurl for my-account
			include (TEMPLATEPATH . '/lib/pages/category_body.php');
			echo '</div>';
		} else {
		}
		process_next:
	endforeach; 
	echo '</div>';
?>