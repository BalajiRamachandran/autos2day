<?php
include dirname(__FILE__) . '/../../../wp-load.php';
?>
<?php
	global $post;
	unset($filters);
	unset ( $errors );
	if ( ! isset($_GET['debug'])) {
		if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
			header("Content-type: application/xhtml+xml;charset=utf-8"); 
		} else {
			header("Content-type: text/xml;charset=utf-8");
		}	
	}

	$log = load_what_is_needed ( "log" );
	$xml = load_what_is_needed("xml");
	$user_data = "<?xml version='1.0'?><userdata>[##xml_string##]</userdata>";
	date_default_timezone_set(get_option('timezone_string'));

	if ( $_GET['debug'] ) {
		$debug = true;
	}
	//$args['post_status'] = 'pending';
	//Array ( [q] => 1 [_search] => false [nd] => 1337884636626 [rows] => 10 [page] => 1 [sidx] => id [sord] => desc ) 
	if ( strlen($_GET['edit']) ) {
		print_r($_POST);
	}
	
	if ( !empty($_GET['action']) && !empty($_GET['id']) ) {
		$id_array = explode(",", $_GET['id']);
		$return = new stdClass();
		foreach ( $id_array as $id ) {
			$_post = wp_get_single_post( $id, OBJECT ) ;
			$return->post->id = $id;
			$return->post->id_action = $_GET['action'];
			$authn_id = $id;
			if ( $_GET ['charge'] == 'true') {
				//customerPaymentProfileId
				$trans_mode = "prior_auth_capture";
				try {
					include (STYLESHEETPATH . "/lib/pages/ad_authorize_payment.php");			
				} catch ( Exception $e ) {
					$errors->$id = $e->getMessage();
					$log->general ( __LINE__ . "\t: " . implode('|', (array) $e) , "my_deals_");
				}				

			} elseif ($_GET ['charge'] == 'false') {
				//no charge
				$trans_mode = "void";
				try {
					include (STYLESHEETPATH . "/lib/pages/ad_authorize_payment.php");			
				} catch ( Exception $e ) {
					if ( $debug ) {
						print_r($e);
					}
					$errors->$id = $e->getMessage();
					$log->general ( __LINE__ . "\t: " . implode('|', (array) $e) , "my_deals_");
				}				
			}

			if ( ! isset($errors->$id) ) {
				update_post_by_id ( $_post, $_GET['action'] );			
			} else {
			}
		}
	} elseif (
		strlen($_GET['_search']) > 0 && $_GET['_search'] == 'true'
	) {

		$searchOn = Strip($_REQUEST['_search']);
		if($searchOn=='true') {
			$searchstr = Strip($_REQUEST['filters']);
			// $wh= constructWhere($searchstr);
			if ( !empty($searchstr)) {
				$jsona = json_decode($searchstr,true);
				$gopr = $jsona['groupOp'];
				// $wh =  " AND ".getStringForGroup($jsona);
				$wh =  getStringForGroup($jsona);
				$wh['relation'] = $gopr;				
			}
			// echo "<hr/>";
			// print_r($jsona['rules']);
			// echo "<hr/>";
			//var_dump($wh);
			//echo $ss;
		}

		// //searchField=category&searchString=sedan
		// switch ($_GET['searchField']) {
		// 	case 'category' :
		// 		$term = get_term_by ( 'slug',  strtolower($_GET['searchString']), $_GET['searchField'] );
		// 		# code...
		// 		$filters->category = $term->term_id;
		// 		break;
		// 	case 'status' :
		// 		$filters->post_status = $_GET['searchString'];
		// 		break;
		// 	case 'post_date' :
		// 		$filters->post_date = $_GET['searchString'];
		// 		break;
		// 	case 'deal_date' :
		// 		$filters->deal_date = $_GET['searchString'];
		// 		break;
		// 	case 'days_published' :
		// 		// $filters->days_published = $_GET['searchString']
		// 		break;
		// }
	} else {
	}
	if ( $_GET['version'] == '1' ) {
		get_grid_posts_1 ( $_GET );
	} else {
		if ( !empty ( $filters) ) {
			get_grid_posts ( $filters, $errors );
		} else {
			get_grid_posts ( '', $errors );		
		}
	}


	function get_grid_posts_1 ( $obj ) {
		global $post;
		global $log;
		global $xml;
		global $wh;

		// add_filter( 'posts_where', 'filter_where' );

		include (TEMPLATEPATH . "/lib/pages/get_posts_list.php");

		$args['exclude_from_search'] = "";
		$args['exclude'] = "";
		$args['post_status'] = 'null';
		$args['post_status'] = array ( 'publish', 'expired', 'trash', 'pending', 'future', 'approved', 'archive');

		if ( !empty($wh) ) {
			$args['meta_query'] = $wh;
		}

		$args['offset'] = ($_GET['rows'] * $_GET['page'] ) - $_GET['rows'];
		//$args['order'] = 'DESC';
		if ( isset($_GET['sidx']) ) {
			$args['orderby'] = $_GET['sidx'];
			$subject = $_GET['sidx'];
			$pattern = '/^(ad_|percentage|view_count|days_published)/';
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

		// $count_posts = wp_count_posts();

		// $total_records = 0;
		// foreach ($count_posts as $post_key => $post_value) {
		//     if ( $post_key != 'auto-draft') {
		//         $total_records += $post_value;
		//     }
		// }

		// $allposts->total = $total_pages;

		//$_GET['rows']
		$start = $_REQUEST['rows']*$_REQUEST['page'] - $_REQUEST['rows'];
		$args['numberposts'] = -1;
		$args['posts_per_page'] = $_REQUEST['rows'];


		$searchOn = Strip($_REQUEST['_search']);
		if($searchOn=='true') {
			$sarr = Strip($_REQUEST);
			foreach( $sarr as $k=>$v) {
				switch ($k) {
					case 'category':
						// $wh .= " AND ".$k." LIKE '".$v."%'";
						$term = get_term_by ( 'slug',  $v, $k );
						$args['cat'] = $term->term_id;
						break;
					case 'status':
						$args['post_status'] = array ( $v );
						break;
					case 'tax':
					case 'total':
						$wh .= " AND ".$k." = ".$v;
						break;
				}
			}
		}

		// print_r($args);


		$myposts = new WP_Query ( $args );//get_posts( $args );


		// echo trim($xml->generate_valid_xml_from_array($myposts));

		// return;


		$allposts = loop_thru_posts ( $myposts->posts);
		
		$allposts->args = $args;
		$allposts->query = $myposts->request;
		$allposts->records = $myposts->found_posts;
		$allposts->total = $myposts->max_num_pages;
		$allposts->page = $_REQUEST['page'];
		$xmlData = trim($xml->generate_valid_xml_from_array($allposts));
		$xmlDocument = new DOMDocument();
		$xmlDocument->loadXML ( $xmlData );
		$xpath = new DOMXpath ( $xmlDocument );
		foreach ($xpath->query("*//args//Element", $xmlDocument) as $node) {
			// $node->parentNode->removeChild($node);
			// Element element2 = doc.createElement("newname");

			// // Copy the attributes to the new element
			// NamedNodeMap attrs = element.getAttributes();
			// for (int i=0; i<attrs.getLength(); i++) {
			//     Attr attr2 = (Attr)doc.importNode(attrs.item(i), true);
			//     element2.getAttributes().setNamedItem(attr2);
			// }

			// // Move all the children
			// while (element.hasChildNodes()) {
			//     element2.appendChild(element.getFirstChild());
			// }

			// // Replace the old node with the new node
			// element.getParentNode().replaceChild(element2, element);		
			$element = $xmlDocument->createElement("argsElement");
			if ($node->hasAttributes()) {
			  foreach ($node->attributes as $attr) {
			    $attrname = $attr->nodeName;
			    $attrvalue = $attr->nodeValue;
			    // echo "Attribute '$name' :: '$value'<br />";
			    $element->setAttribute($attrname, $attrvalue);
			  }
			}				
			if ($node->hasChildNodes()) {
			  foreach ($node->childNodes as $child) {
			    $element->appendChild($child);
			  }
			}			
			// echo $element->ownerDocument->saveXML($element);
			// echo $element->parentNode;
			$node->parentNode->replaceChild($element, $node);
		}
		echo $xmlDocument->saveXML();
		// echo $xmlData;
		// print_r($myposts->request);
	}

	function loop_thru_posts ( $myposts ) {
		global $log;
		foreach( $myposts as $_post ) :	setup_postdata ( $_post );
			//echo '<br/>\$_post->post_status ' . $_post->post_status;
			$log->general ( "Post status - " . $_post->post_status , "my_deals_");

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
			// Categories
			$categories = get_the_category($_post->ID);

			$allposts->$post_id = $_post;

			validate_exp_deal_date ($post_id, $_post->post_date, true );

			if ( isset($errors->$post_id ) ) {
				$_post_date = $_post->post_date;
				update_post_meta ( $_post->ID, "trans_status", $errors->$post_id);
				wp_update_post ( $_post );
				$_post->post_date = $_post_date;
				wp_update_post ( $_post );
				unset($_post_date);
				unset ( $errors->$post_id );
			}

			$allposts->$post_id->Categories = $categories[0];
			$allposts->$post_id->Meta = get_custom_meta($post_id);
			$allposts->$post_id->User = get_user_custom_meta ($_post->post_author);
			$allposts->$post_id->A2D = get_transaction_details ($post_id, get_post_meta($post_id, "TransactionID", true));
			$allposts->today = date('Y-m-d');
			$allposts->post_days = date('Y-m-d', strtotime($_post->post_date));
			$allposts->$post_id->days_old = round(abs(strtotime($allposts->today) - strtotime($allposts->post_days))/60/60/24);
			// add the voucher count
			$allposts->$post_id->vouchers_count = get_vouchers_count ( $post_id );
			// $allposts->userdata_deal_dates = "balaji";
			// $allposts->userData = 	$_GET;
			// $allposts->$post_id->Metas = get_post_custom($post_id);
			$count++;
			process_next_post:
		endforeach;	
		return $allposts;	
	}

	// Create a new filtering function that will add our where clause to the query
	function filter_where( $where = '' ) {
		// posts in the last 30 days
		$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
		return $where;
	}	


	function update_post_by_id ( $_post, $action ) {
		global $log;
		date_default_timezone_set(get_option('timezone_string'));
		$_post->post_status = $action;
		$_post_date = $_post->post_date;
		switch ($action) {
			case 'publish':
				# code...
				unset($_post_date);
				$_post->post_date = date('Y-m-d H:m:s', strtotime("-1 day"));
				$_post->post_status = $action;
				wp_update_post ( $_post );
				update_post_meta ( $_post->ID, "add_a_day", "0");
				validate_exp_deal_date ($_post->ID, $_post->post_date, true );
				break;
			case 'trash' :
				update_post_meta ( $_post->ID, "rejected_date", date(get_option("expiration_format")));	
				update_post_meta ( $_post->ID, "trans_status", "Successful");	
				ad_deal_notifications ( get_post_custom ($_post->ID), 'rejected', get_user_meta ( $_post->post_author ), $_post->post_author );
				break;
			case 'approved' :
				update_post_meta ( $_post->ID, "trans_status", "Successful");	
				update_post_meta ( $_post->ID, "approved_date", date(get_option("expiration_format")));		
				$log->general ( __LINE__ . "\t: " . "Updating the post status - " . $action , "my_deals_");
				ad_deal_notifications ( get_post_custom ($_post->ID), 'approved', get_user_meta ( $_post->post_author ), $_post->post_author );
				break;
			case 'archive' :
				$log->general ( __LINE__ . "\t: " . "Updating the post status - " . $action , "my_deals_");
				$_post->post_status = $action;
				wp_update_post ( $_post );
				break;
			case 'pending' :
				$log->general ( __LINE__ . "\t: " . "Updating the post status - " . $action , "my_deals_");
				$_post->post_status = $action;
				wp_update_post ( $_post );
				break;
			default:
				# code...
				break;
		}
		$log->general ( __LINE__ . "\t: " . implode('|', (array) $_post) , "my_deals_");
		wp_update_post ( $_post );
		if ( $_post_date ) {
			$_post->post_date = $_post_date;
		}
		$log->general ( __LINE__ . "\t: " . implode('|', (array) $_post) , "my_deals_");
		wp_update_post ( $_post );
	}

	function download_posts( $startDate, $endDate ) {
		global $post;
		global $log;
		include (TEMPLATEPATH . "/lib/pages/get_posts_list.php");	
		$args['exclude_from_search'] = "";
		$args['exclude'] = "";
		$args['post_status'] = 'null';
		$args['post_status'] = array ( 'publish', 'expired', 'trash', 'pending', 'future', 'approved');
		$args['numberposts'] = 10000;

	}

	function get_grid_posts ( $filters, $errors = '' ) {
		global $post;
		global $log;
		global $xml;


		include (TEMPLATEPATH . "/lib/pages/get_posts_list.php");

		$args['exclude_from_search'] = "";
		$args['exclude'] = "";
		$args['post_status'] = 'null';
		$args['post_status'] = array ( 'publish', 'expired', 'trash', 'pending', 'future', 'approved');
		if ( isset($filters->category) ) {
			$args['category'] = $filters->category;
		}	
		if ( isset($filters->post_status ) ) {
			$args['post_status'] = $filters->post_status;
		}	
		if ( isset($filters->post_date ) ) {
			$args['post_date'] = $filters->post_date;
			$args['year'] = date('Y', strtotime($args['post_date']));
			$args['monthnum'] = date('m', strtotime($args['post_date']));
			$args['day'] = date('d', strtotime($args['post_date']));
		}	
		if ( isset($filters->deal_date ) ) {
			// $args['year'] = date('Y', strtotime($args['post_date']));
			// $args['monthnum'] = date('m', strtotime($args['post_date']));
			// $args['day'] = date('d', strtotime($args['post_date']));
		}	

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

		$count_posts = wp_count_posts();

		$total_records = 0;
		foreach ($count_posts as $post_key => $post_value) {
		    if ( $post_key != 'auto-draft') {
		        $total_records += $post_value;
		    }
		}

		$allposts->total = $total_pages;

		//$_GET['rows']
		$start = $_REQUEST['rows']*$_REQUEST['page'] - $_REQUEST['rows'];
		$args['numberposts'] = -1;
		$args['posts_per_page'] = $_REQUEST['rows'];
		$myposts = get_posts( $args );

		// print_r($myposts);

		$allposts->page = $_GET['page'];
		$count = 0;
		foreach( $myposts as $_post ) :	setup_postdata ( $_post );
			//echo '<br/>\$_post->post_status ' . $_post->post_status;
			$log->general ( "Post status - " . $_post->post_status , "my_deals_");
			if ( $_post->post_status == "auto-draft" || $count == $_REQUEST['rows'] ) {
				goto process_next_post;
			// } elseif ($_post->post_status == "xxxxtrash") {
			// 	goto process_next_post;
			} elseif ( isset($filters->deal_date) ) {
				if ( $filters->deal_date == date('Y-m-d', strtotime(get_post_meta($_post->ID, "deal-date", true))) ) {

				} else {
					goto process_next_post;
				}
				
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
			if ( isset($errors->$post_id ) ) {
				$_post_date = $_post->post_date;
				update_post_meta ( $_post->ID, "trans_status", $errors->$post_id);
				wp_update_post ( $_post );
				$_post->post_date = $_post_date;
				wp_update_post ( $_post );
				unset($_post_date);
				unset ( $errors->$post_id );
			}

			$allposts->$post_id->Categories = $categories[0];
			$allposts->$post_id->Meta = get_custom_meta($post_id);
			$allposts->$post_id->User = get_user_custom_meta ($_post->post_author);
			$allposts->$post_id->A2D = get_transaction_details ($post_id, get_post_meta($post_id, "TransactionID", true));
			$allposts->userdata_deal_dates = "balaji";
			// $allposts->userData = 	$_GET;
			// $allposts->$post_id->Metas = get_post_custom($post_id);
			$count++;
			process_next_post:
		endforeach;
		// if ( $_REQUEST['page'] > 1 ) {
		// 	// $count += $_REQUEST['rows'] * ( $_REQUEST['page'] - 1 ); 
		// }
		$allposts->records = $total_records;//$count;
		// $allposts->args = $args;
		if ( $total_records > 0 ) {
			$allposts->total = ceil( $total_records / $_GET['rows']);
		}
		$allposts->y = '';

		if ( $_GET['edit'] == "true" ) {
			echo '<xml/>';
		}
		// $xml_data = trim($xml->generate_valid_xml_from_array($allposts));
		$xmlData = trim($xml->generate_valid_xml_from_array($allposts));
		$xmlData = str_replace("<Element/>", '', $xmlData);
		if ( ! empty( $errors ) ) {
			$xmlData = str_replace("<y></y>", $errors->errors, $xmlData);
		}

		echo $xmlData;

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

	function get_transaction_details ( $post_id, $TransactionID ) {
		$table = is_dbtable_there("a2d_transactions");
		$sql = "SELECT * from $table WHERE TransactionID = '" . $TransactionID . "'";
		$result				= mysql_query($sql);
		$num 				= mysql_num_rows($result);
		if ( $num > 0 ) {
			while ( $row = mysql_fetch_object($result) ) {
				unset ( $row->ID );
				return $row;
			}
		}
		return "";
	}

	function get_custom_meta ( $post_id ) {
		//global $post_id;
		// echo __LINE__ . ' ' . $post_id;
		$_post_metas = get_post_custom_keys ( $post_id );

		// print_r($_post_metas);

		foreach ( $_post_metas as $keys ) {
			if ( $keys == 'expiration-time' || 'deal-date' == $keys ) {
				$post_metas[$keys] = date('Y-m-d', strtotime(get_post_meta ( $post_id, $keys, true )));
			} else {
				$post_metas[$keys] = get_post_meta ( $post_id, $keys, true );
			}
				
		}
		
		// update_deal_price_percentage ( $post_metas, $post_id );

		if ( ! isset($post_metas['ad_price']) ) {
			update_post_meta ( $post_id, "ad_price", "0" );
		}
		if ( ! isset($post_metas['ad_pparty']) || strlen($post_metas['ad_pparty']) == 0 ) {
			$post_metas['ad_pparty'] = $post_metas['ad_price'];
		}
		if ( ! isset($_post_metas['percentage']) ) {
			$post_metas['percentage'] = '0';
			if ( !empty ($post_metas['ad_pparty']) ) {
				$post_metas['percentage'] = ( ( $post_metas['ad_price'] - $post_metas['ad_pparty'] ) / $post_metas['ad_pparty'] ) * 1;// / $_post_metas['PrivateParty'];				
			}
			$post_metas['percentage'] = number_format($post_metas['percentage'], 3, '.', ',');//number_format($post_metas['percentage'], 2, '.', ',');
			update_post_meta ($post_id, 'percentage', $post_metas['percentage'] );
		}


		return $post_metas;
	}
	function Strip($value)
	{
		if(get_magic_quotes_gpc() != 0)
	  	{
	    	if(is_array($value))  
				if ( array_is_associative($value) )
				{
					foreach( $value as $k=>$v)
						$tmp_val[$k] = stripslashes($v);
					$value = $tmp_val; 
				}				
				else  
					for($j = 0; $j < sizeof($value); $j++)
	        			$value[$j] = stripslashes($value[$j]);
			else
				$value = stripslashes($value);
		}
		return $value;
	}

	function array_is_associative ($array)
	{
	    if ( is_array($array) && ! empty($array) )
	    {
	        for ( $iterator = count($array) - 1; $iterator; $iterator-- )
	        {
	            if ( ! array_key_exists($iterator, $array) ) { return true; }
	        }
	        return ! array_key_exists(0, $array);
	    }
	    return false;
	}
function constructWhere($s){
	    $qwery = "";
		//['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc']
	    $qopers = array(
					  'eq'=>" = ",
					  'ne'=>" <> ",
					  'lt'=>" < ",
					  'le'=>" <= ",
					  'gt'=>" > ",
					  'ge'=>" >= ",
					  'bw'=>" LIKE ",
					  'bn'=>" NOT LIKE ",
					  'in'=>" IN ",
					  'ni'=>" NOT IN ",
					  'ew'=>" LIKE ",
					  'en'=>" NOT LIKE ",
					  'cn'=>" LIKE " ,
					  'nc'=>" NOT LIKE " );
	    if ($s) {
	        $jsona = json_decode($s,true);
	        if(is_array($jsona)){
				$gopr = $jsona['groupOp'];
				$rules = $jsona['rules'];
	            $i =0;
	            foreach($rules as $key=>$val) {
	                $field = $val['field'];
	                $op = $val['op'];
	                $v = $val['data'];
					if($v && $op) {
		                $i++;
						// ToSql in this case is absolutley needed
						$v = ToSql($field,$op,$v);
						if ($i == 1) $qwery = " AND ";
						else $qwery .= " " .$gopr." ";
						switch ($op) {
							// in need other thing
						    case 'in' :
						    case 'ni' :
						        $qwery .= $field.$qopers[$op]." (".$v.")";
						        break;
							default:
						        $qwery .= $field.$qopers[$op].$v;
						}
					}
	            }
	        }
	    }
	    return $qwery;
	}


	function getStringForGroup( $group )
	{
		$i_='';
		$sopt = array('eq' => "=",'ne' => "<>",'lt' => "<",'le' => "<=",'gt' => ">",'ge' => ">=",'bw'=>" {$i_}LIKE ",'bn'=>" NOT {$i_}LIKE ",'in'=>' IN ','ni'=> ' NOT IN','ew'=>" {$i_}LIKE ",'en'=>" NOT {$i_}LIKE ",'cn'=>" {$i_}LIKE ",'nc'=>" NOT {$i_}LIKE ", 'nu'=>'IS NULL', 'nn'=>'IS NOT NULL');
		// $sopt = array('eq' => "EQUALS",'ne' => "NOT EQUALS",'lt' => "LESS THAN",'le' => "LESS THAN OR EQUAL",'gt' => ">",'ge' => ">=",'bw'=>" {$i_}LIKE ",'bn'=>" NOT {$i_}LIKE ",'in'=>' IN ','ni'=> ' NOT IN','ew'=>" {$i_}LIKE ",'en'=>" NOT {$i_}LIKE ",'cn'=>" {$i_}LIKE ",'nc'=>" NOT {$i_}LIKE ", 'nu'=>'IS NULL', 'nn'=>'IS NOT NULL');
		$s = "(";
		$m_query = array();
		if( isset ($group['groups']) && is_array($group['groups']) && count($group['groups']) >0 )
		{
			for($j=0; $j<count($group['groups']);$j++ )
			{
				if(strlen($s) > 1 ) {
					$s .= " ".$group['groupOp']." ";
				}
				try {
					$dat = getStringForGroup($group['groups'][$j]);
					$s .= $dat;
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			}
		}
		if (isset($group['rules']) && count($group['rules'])>0 ) {
			try{
				foreach($group['rules'] as $key=>$val) {
					if (strlen($s) > 1) {
						$s .= " ".$group['groupOp']." ";
					}
					$field = $val['field'];
					$op = $val['op'];
					$v = $val['data'];
					$tmp = array();
					if ( $field != 'status' ) {
						$tmp['key'] = $field;
						$tmp['value'] = $v;
						$tmp['compare'] = $sopt[$op];						
					}

					if( $op ) {
						switch ($op)
						{
							case 'bw':
							case 'bn':
								$s .= $field.' '.$sopt[$op]."'$v%'";
								break;
							case 'ew':
							case 'en':
								$s .= $field.' '.$sopt[$op]."'%$v'";
								break;
							case 'cn':
							case 'nc':
								$s .= $field.' '.$sopt[$op]."'%$v%'";
								break;
							case 'in':
							case 'ni':
								$s .= $field.' '.$sopt[$op]."( '$v' )";
								break;
							case 'nu':
							case 'nn':
								$s .= $field.' '.$sopt[$op]." ";
								break;
							default :
								$s .= "(" . $field.' '.$sopt[$op]." '$v' )";								
								// echo "<h2>$s</h2>";
								break;
						}
					}
					if ( !empty($tmp) ) {
						array_push($m_query, $tmp);
					}
				}
			} catch (Exception $e) 	{
				echo $e->getMessage();
			}
		}
		return $m_query;
		$s .= ")";
		if ($s == "()") {
			// return array("",$prm); // ignore groups that don't have rules
			return " 1=1 ";
		} else {
			return $s;
		}
	}
	function get_vouchers_count ( $post_id ) {
		global $wpdb;
		// SELECT id, COUNT(id) as count from wp_wps_ad_vouchers where post_id = '1147'		
		$sql = "SELECT COUNT(id) as count from wp_wps_ad_vouchers where post_id = %d";
		$count = $wpdb->get_var ( $wpdb->prepare($sql, $post_id) );
		return $count;
	}
?>