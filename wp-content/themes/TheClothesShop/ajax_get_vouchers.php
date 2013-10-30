<?php
include dirname(__FILE__) . '/../../../wp-load.php';
?>
<?php
	global $post;
	//$args['post_status'] = 'pending';
	//Array ( [q] => 1 [_search] => false [nd] => 1337884636626 [rows] => 10 [page] => 1 [sidx] => id [sord] => desc ) 
	$log = load_what_is_needed("log");
	if ( strlen($_GET['action']) > 0 && strlen($_GET['id']) > 0 ) {
		$id_array = explode(",", $_GET['id']);
		$return = new stdClass();
		foreach ( $id_array as $id ) {
			$_post = wp_get_single_post( $id, OBJECT ) ;
			update_post_by_id ( $_post, $_GET['action'] );
			$return->post->id = $id;
			$return->post->id_action = $_GET['action'];
		}
		// if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
		// 	header("Content-type: application/xhtml+xml;charset=utf-8"); 
		// } else {
		// 	header("Content-type: text/xml;charset=utf-8");
		// }	
		//echo trim($xml->generate_valid_xml_from_array($return));
	} else {
		get_vouchers ();
	}

	function update_post_by_id ( $_post, $action ) {
		$_post->post_status = $action;
		wp_update_post ( $_post );
	}

	function get_vouchers () {
		global $log;
		global $current_user;
		$userdata = array();

		$page = $_GET['page']; // get the requested page 
		$limit = $_GET['rows']; // get how many rows we want to have into the grid 
		$sidx = $_GET['sidx']; // get index row - i.e. user click to sort 
		$sord = $_GET['sord']; // get the direction		
		if(!$sidx) $sidx =1;
		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		$results = array();
		$xml = load_what_is_needed("xml");
		get_currentuserinfo();
		$condition = '';
		if ( ! current_user_can( 'administrator' ) ) {
			$condition = " WHERE user_id = '$current_user->ID' " ;
		}

		$table 				= is_dbtable_there('ad_vouchers');//feusers');
		$qStr 				= "SELECT COUNT(*) AS count FROM $table $condition";//= "SELECT * FROM $table WHERE user_id = '$current_user->ID' LIMIT ";
		$log->general ( __FILE__ . ' sql: ' . $qStr);
		$result 			= mysql_query($qStr);
		$row 				= mysql_fetch_array($result,MYSQL_ASSOC);
		$num 				= $row['count'];//= mysql_num_rows($result);	

		if( $num >0 ) { 
			$total_pages = ceil($num/$limit); 
		} else { 
			$total_pages = 0; 
		}		

		if ($page > $total_pages) 
			$page=$total_pages;

		$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		$results['records'] = $num;
		$results['page'] = $page;
		$results['total'] = $total_pages;
		$results['user_can'] = current_user_can( 'administrator' );
		$results['_records'] = $num;
		$results['_page'] = $page;
		$results['_total'] = $total_pages;

		$qStr = "SELECT * FROM $table $condition ORDER BY $sidx $sord LIMIT $start , $limit";

		$result 			= mysql_query($qStr);

		while( $row = mysql_fetch_assoc($result )){
			if ( $row['post_id'] != '' ) {
				$row['Meta'] = get_custom_meta ( $row['post_id'] );				
			}
			array_push($results, $row);
		}
		// $results['userdata'] = $userdata;
		// array_push($results, $userdata);
		if ( ! isset($_GET['debug'])) {
			if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
				header("Content-type: application/xhtml+xml;charset=utf-8"); 
			} else {
				header("Content-type: text/xml;charset=utf-8");
			}	
		}
		$result_xml = trim($xml->generate_valid_xml_from_array($results));
		$pattern = '/\<(user_can|_page|_total|_records)\>(.+)\<\/\1\>/i';
		$replacement = '<userdata name="$1">$2</userdata>';
		$result_xml = preg_replace($pattern, $replacement, $result_xml);
		echo $result_xml;
	}

	function get_grid_posts () {
		global $post;
		global $log;
		include (TEMPLATEPATH . "/lib/pages/get_posts_list.php");	
		$args['exclude_from_search'] = "";
		$args['exclude'] = "";
		$args['post_status'] = 'null';
		$args['numberposts'] = 10000;
		$args['offset'] = ($_GET['rows'] * $_GET['page'] ) - $_GET['rows'];
		//$args['order'] = 'DESC';
		if ( isset($_GET['sidx']) ) {
			$args['orderby'] = $_GET['sidx'];
			$subject = $_GET['sidx'];
			$pattern = '/^(ad_|percentage)/';
			preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE);
			$allposts->str_ad = count($matches);//strpos($_GET['sidx'], "ad_");		
			if ($allposts->str_ad != '0') {
				$args['orderby'] = 'meta_value';
				$args['meta_key'] = $_GET['sidx']; 
			}
			if ($subject == 'ad_price' || $subject == 'percentage') {
				$args['orderby'] = 'meta_value_num';// + 0;
			}
		}
		if ( isset($_GET['sord']) ) {
			$args['order'] = $_GET['sord'];
		}

		$myposts = get_posts( $args );

		$allposts->page = $_GET['page'];

		$xml = load_what_is_needed("xml");
		foreach( $myposts as $_post ) :	setup_postdata ( $_post );
			//echo '<br/>\$_post->post_status ' . $_post->post_status;
			$log->general ( "Post status - " . $_post->post_status );
			if ( $_post->post_status == "auto-draft" ) {
				goto process_next_post;
			// } elseif ($_post->post_status == "xxxxtrash") {
			// 	goto process_next_post;
			} else {
			}

			process_posts:
			$post_id = $_post->ID;
			unset ( $_post->comment_status );
			unset ( $_post->ping_status );
			unset ( $_post->post_password );
			unset ( $_post->to_ping );
			unset ( $_post->post_content_filtered );
			unset ( $_post->menu_order );
			unset ( $_post->comment_count );
			unset ( $_post->filter );
			unset ( $_post->post_mime_type );
			unset ( $_post->pinged );
			unset ( $_post->post_date_gmt );
			unset ( $_post->post_excerpt );
			unset ( $_post->post_name );
			unset ( $_post->post_modified_gmt );
			unset ( $_post->post_content );
			unset ( $_post->post_parent );
			unset ( $_post->post_type );
			$categories = get_the_category($_post->ID);
			$allposts->$post_id = $_post;
			validate_exp_deal_date ($post_id, $_post->post_date, true );

			$allposts->$post_id->Categories = $categories[0];
			$allposts->$post_id->Meta = get_custom_meta($post_id);
			$allposts->$post_id->User = get_user_custom_meta ($_post->post_author);
			// $allposts->$post_id->Metas = get_post_custom($post_id);
			$count++;
			process_next_post:
		endforeach;
		if ( $_REQUEST['page'] > 1 ) {
			$count += $_REQUEST['rows'] * ( $_REQUEST['page'] - 1 ); 
		}
		$allposts->records = $count;
		$allposts->args = $args;
		if ( $count > 0 ) {
			$allposts->total = ceil( $count / $_GET['rows']);
		}

		if ( $_GET['edit'] == "true" ) {
			echo '<xml/>';
		}
		if ( ! isset($_GET['debug'])) {
			if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
				header("Content-type: application/xhtml+xml;charset=utf-8"); 
			} else {
				header("Content-type: text/xml;charset=utf-8");
			}	
		}
		echo trim($xml->generate_valid_xml_from_array($allposts));

	}

	function get_user_custom_meta ( $author ) {
		$user_metas = get_user_meta ( $author );
		foreach ( $user_metas as $keys => $values ) {
			if ( strpos($keys, '_') != 0 ) {
				$_user_metas[$keys] = $values[0];	
			}
		}
		return $_user_metas;

	}

	function get_custom_meta ( $post_id ) {
		//global $post_id;
		// echo __LINE__ . ' ' . $post_id;
		$_post_metas = get_post_custom_keys ( $post_id );

		// print_r($_post_metas);

		foreach ( $_post_metas as $keys ) {
			if ( $keys == 'expiration-time' || 'deal-date' == $keys ) {
				$post_metas[$keys] = date('Y-m-d', get_post_meta ( $post_id, $keys, true ));
			} else {
				$post_metas[$keys] = get_post_meta ( $post_id, $keys, true );
			}
				
		}
		
		// // $post_metas = $_post_metas;

		// // print_r($_post_metas);

		// if ( !isset($post_metas['ad_price']) ) {
		// 	update_post_meta ( $post_id, "ad_price", "0" );
		// }
		// if ( !isset($post_metas['ad_pparty']) ) {
		// 	$post_metas['ad_pparty'] = $post_metas['ad_price'];
		// }
		// if ( ! isset($_post_metas['percentage']) ) {
		// 	$post_metas['percentage'] = ( $post_metas['ad_price'] - $post_metas['ad_pparty'] );// / $_post_metas['PrivateParty'];
		// 	update_post_meta ($post_id, 'percentage', $post_metas['percentage'] );
		// }


		return $post_metas;
	}
?>