<?php
require dirname(__FILE__) . '/../../../../wp-load.php';
include_once dirname(__FILE__) . '/utils.php';
// error_reporting(E_ALL);
// ini_set("display_errors", 1); 
$log = load_what_is_needed ( "log" );
// read csv file
$filename = '';
$seperator = ',';
$image_seperator = '|';
$author = '';
$ssl = false;
$lists = array();

$get_users_args = array(
	'blog_id' => $GLOBALS['blog_id'],
	'role' => '',
	'meta_key' => '',
	'meta_value' => '',
	'meta_compare' => '',
	'meta_query' => array(),
	'include' => array(),
	'exclude' => array(),
	'orderby' => 'login',
	'order' => 'ASC',
	'offset' => '',
	'search' => '',
	'number' => '',
	'count_total' => false,
	'fields' => 'all',
	'who' => ''
 );

 $mapping = array (
	'Mileage'	=>	'ad_miles',
	'Price'		=>	'ad_price',
	'SpecialPrice'		=>	'ad_price',
	'VIN'		=>	'ad_vin',
	'Dealer Name'	=>	'author',
	'SpecialPrice'	=>	'ad_price',
	'Images'		=>	'img',
	'Exterior'		=>	'ad_color',
	'Options'		=>	'content',
	'Category'		=>	'category',
	'Odometer'		=>	'ad_miles',
	'Color'	=>	'ad_color',
	'Features'	=>	'content',
	'Photo Url List'	=>	'img',
	'Price'	=>	'ad_price'
);

$removeElements = array (

);

get_header();

$all_users = get_users($get_users_args);
include_once ( TEMPLATEPATH . '/ajax_validate_duplicate_vin.php' );

?>
<?php
if (empty($_POST)) {
	?>
		<form name="importDeals" id="importDeals" method="POST" action="#">
	  <p>
	    <label for="f">Select a File</label>
	    <select name="f" id="f">
	      <?php 

              foreach (glob($_SERVER['DOCUMENT_ROOT'] . '/importdeals/*.csv') as $key ) {
                      # code...
                      echo "<option value=" . $key . ">" . basename($key) . '</option>';
              }
              ?>
	    </select>
	  </p>
	  <p>
	    <label for="a">Select a Dealer</label>
	    <select name="a" id="a">
	    	<option value="null">Select One</option>
	      <?php 
	      	foreach ($all_users as $user_) {
	      		$display_name = get_user_meta ( $user_->ID, "dealership_name", true);
	      		if ( !empty($display_name)) {
	      			$display_id = get_user_meta ( $user_->ID, "dealership_id", true);
	      			echo "<option value=$display_id>$display_name</option>";
	      		}
	      	}
          ?>
	    </select>
	  </p>
	  <?php if ( is_ssl() ) {
	                  echo '<input type="hidden" name="https" value="https"/>';
	          }?>
	  <p>
	    <input type="submit" name="submit" value="import" />
	  </p>
	</form>

	<?php
	exit(NULL);
} else {
	if ( ! isset($_POST['f']) ) {
		die("Error");
	}
}

$filename = $_POST['f'];
$author = $_POST['a'];

$f = fopen($filename, "r") or die("unknown"); 
$line = fgets($f);
// echo $line . "\n";
if ( explode(",", $line) > explode("\t", $line) ) {
	$seperator = 'comma';
} else {
	$seperator = 'tab';
}
fclose($f);
// echo $seperator;
// die(); 

if ( empty($filename)) {
	die("No File Specified");
}

// print_r($seperator);

?>
<?php
$row = 1;
if (($handle = fopen($filename, "r")) !== FALSE) {
	switch ($seperator) {
		case 'tab':
		    while (($data = fgetcsv($handle, 100000, "\t")) !== FALSE) {
		    	if ( $row == 1 ) {
		    		$colHeads = $data;
		    		goto nextArray;
		    	}
		    	$num = count($data);
		    	if ( $row < 10000 ) :
		        for ($c=0; $c < $num; $c++) {
		        	$data[$c] = trim($data[$c]);
		        	// $data[$c] = str_replace(",", '', $data[$c]);
		        	$data[$c] = str_replace("$", '', $data[$c]);
		        	$data[$c] = str_replace("Unlisted", '', $data[$c]);
		        	if ( trim($data[$c]) != '' ) :
		            	// echo $colHeads[$c] . ":&nbsp;" . $data[$c] . "<br />\n";
		        	endif;
		        }

		    	$dataFields[$row] = $data;//explode(',', $data);//$data[0];
		        $num = count($data);
		        if ( trim($data[3]) == 'N' ) {
		        } else {
			        // echo "<p> $num fields in line $row: $data[3]<br /></p>\n";
		        }
		        endif;
		        nextArray :
		        $row++;
		    }
		    fclose($handle);
			break;
		
		case 'comma' :
		    while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
		    	if ( $row == 1 ) {
		    		$colHeads = $data;
		    		goto nextArray1;
		    	}
		    	$num = count($data);
		    	// if ( $row < 10 ) :
		        for ($c=0; $c < $num; $c++) {
		        	$data[$c] = trim($data[$c]);
		        	// $data[$c] = str_replace(",", '', $data[$c]);
		        	$data[$c] = str_replace("$", '', $data[$c]);
		        	$data[$c] = str_replace("Unlisted", '', $data[$c]);
		        	if ( trim($data[$c]) != '' ) :
		            	// echo $colHeads[$c] . ":&nbsp;" . $data[$c] . "<br />\n";
		        	endif;
		        }

		    	$dataFields[$row] = $data;//explode(',', $data);//$data[0];
		        $num = count($data);
		        if ( trim($data[3]) == 'N' ) {
		        } else {
			        // echo "<p> $num fields in line $row: $data[3]<br /></p>\n";
		        }
		        // endif;
		        nextArray1 :
		        $row++;
		    }
		    fclose($handle);
			break;
	}
}
// print_r($dataFields);
// die();
// print_r($colHeads);
$total_deals = count ( $dataFields );
?>
<?php
foreach ($mapping as $key => $value ) {
	$_index = array_search($key, $colHeads);
	if ( trim($_index) != '' ) {
		$indexes[$key] = $_index;
	} else {
		// echo '\nignoring : ' . $_index;
	}
}
?>

<?php
$index_field = 0;
echo "<div class='clearfix'><!----></div>";
foreach ($dataFields as $key ) {
	open_tag( "div",  array("class" => 'main') );
	$values = array();
	++$index_field;
	foreach ($indexes as $_key => $value) {
		$values[$mapping[$_key]] = $key[$value];
	}

	// print_r($values);
	html_echo ( "[$index_field of $total_deals] Processing VIN : " . $values['ad_vin'], 'h2', 'heading');

	if ( !empty($author) ) {
		$values['author'] = $author;
	}

	$args['meta_key'] = 'dealership_id';
	$args['meta_value'] = $values['author'];

	$users = get_users ( $args );

	// print_r($users);

	if ( empty($users) || count ( $users ) > 1 ) {
		html_echo ( "Stopped, Unknown Dealer Name : " . $values['author']);
		die( "\n\n\\nUnknown Dealer Name!" . $values['author'] . "\n\n\n" );
	} else {
		// print_r($users);
	}

	$values['author'] = $users[0]->ID;
	$values['zipcode'] = get_user_meta ( $values['author'], "dealership_address_zipcode", true);
	$values['state'] = get_user_meta ( $values['author'], "dealership_address_state", true);


	// print_r($values);
	if ( !empty ($values['img'])) {
		if ( count(explode("|", $values['img'])) > count(explode(",", $values['img'])) ) {
			$images = array_slice(explode("|", $values['img']), 0, 5);
		} else {
			$images = array_slice(explode(",", $values['img']), 0, 5);
		}
		unset ( $values['img']);
		html_echo ( "total images: " . count ( $images) );
	} else {
		html_echo ( "Skipping VIN, no images : " . $values['ad_vin']);
		goto nextVIN;
	}

	if (!empty($values['category'])) {
		$catObj = get_category_by_slug ( strtolower($values['category']));
		// print_r($catObj);
		$values['category'] = $catObj->term_id;
	}

	if ( empty($values['ad_price']) || ! isset($values['ad_price'])) {
		html_echo ( "Deal price is missing, skipping deal ");
		goto nextVIN;	
	}

	/*
	*	check vin dupliactes
	*
	*/

	$document = new DOMDocument();
	try {
		$duplicate_vin = check_duplicate ( array('vin' => $values['ad_vin'] ) );
		if ( $duplicate_vin == '<empty/>' || empty ($duplicate_vin) ) {

		} else {
			$values['error'] = 'duplicate VIN';
			$document->loadXML( $duplicate_vin);		
			$query = new DOMXpath ( $document );
			html_echo ( get_content( $query->query("//guid", $document) ));
			html_echo ( "Skipping - duuplicate VIN : " . $values['ad_vin']);
			goto nextVIN;
		}

	} catch ( Exception $e ) {
		html_echo ( "Error validating VIN : " . $e->getMessage);		
	}

	/*
	*	get vin details
	*
	*/
	include_once ( TEMPLATEPATH . '/ajax_form_nada.php');

	$obj['vin'] = $values['ad_vin'];
	$obj['z'] = $values['zipcode'];
	$obj['m'] = $values['ad_miles'];
	$obj['o'] = 'nada';
	$obj['s'] = $values['state'];

	$vin_details = get_vehichle_configuration ( $obj );
	try {
		$document->loadXML( $vin_details);		
	} catch ( Exception $e ) {
		print_r($e);
		goto nextVIN;
	}

	$query = new DOMXpath ( $document );

	$values['ad_year'] = get_content( $query->query("//VicDescriptions//VIC_Year", $document) );
	$values['ad_make'] = get_content( $query->query("//VicDescriptions//Make", $document) );
	$values['ad_model'] = get_content( $query->query("//VicDescriptions//Model", $document) );
	$values['ad_Engine'] = get_content( $query->query("//VicDescriptions//Series", $document) );
	$values['ad_trim'] = get_content( $query->query("//VicDescriptions//Bodystyle", $document) );
	$values['ad_pparty'] = get_content( $query->query("//VicDescriptions//CleanTradeIn", $document) );


	$values['title'] = $values['ad_year'] . ' ' . $values['ad_make'] . ' ' . $values['ad_model'];
	$values['content'] = str_replace(",", "\n", $values['content']);
	echo '<table>';
	foreach ($values as $key => $value) {
		echo "<tr><td>$key</td><td>$value</td></tr>";
	}
	echo '</table>';
	$values['target_path'] = wp_upload_dir();
	$post_args = array(
		'post_title' => apply_filters( 'the_title', $values['title'] ), 
		'post_content' => apply_filters( 'the_content', $values['content'] ), 
		'post_status' => 'pending', 
		'post_author' => $values['author'],
		'post_category' => array( $values['category'] ) 
	);

	include (TEMPLATEPATH . "/lib/pages/ad_post_meta.php");

	foreach ($meta_keys as $v) {
		if ( isset($values[$v])) {
			if ( $v == 'ad_price' ) {
				$values[$v] = str_replace(",", "", $values[$v]); //remove the ',' from price
				$values[$v] = str_replace("$", "", $values[$v]); //remove the '$' from price
			}
			if ( $v == 'ad_miles' ) {
				$values[$v] = str_replace(",", "", $values[$v]); //remove the ',' from price
			}
			$meta_args[$v] = $values[$v];
		}
	}

	$post_id = wp_insert_post( $post_args );	
	// wp_delete_post ( $post_id, true);

	nextVIN :	
	close_tag ( "div" );
}

function html_echo ( $str, $tag = 'p', $class = 'info' ) {
	echo "<$tag class=$class>$str</$tag>";
}

function open_tag ( $tag, $attr = array() ) {
	$array_attrs = http_build_query ( $attr );
	echo "<$tag>";
}

function close_tag ( $tag ) {
	echo "</$tag>";
}

function get_content ( $nodes ) {
	foreach ($nodes as $node ) {
		// echo __LINE__;
		return $node->textContent;
	}
}

?>
