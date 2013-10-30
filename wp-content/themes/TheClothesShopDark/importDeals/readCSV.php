<?php
require dirname(__FILE__) . '/../../../../wp-load.php';
include dirname(__FILE__) . '/utils.php';
set_time_limit ( 1700 );
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
if (empty($_GET)) {
	$objects = array();
	foreach ($argv as $key ) {
		if ( strpos($key, '=') === false ) {
		} else {
			$tmp = explode('=', $key);		
			$objects[$tmp[0]] = $tmp[1];
		}
	}

	$filename = $objects['f'];
	$seperator = $objects['s'];
	$image_seperator = $objects['is'];
	$ssl = $objects['https'];
	$author = $objects['a'];

} else {
	if ( isset($_GET['f']) ) {
		$filename = $_GET['f'];
	}

	if ( isset($_GET['s']) ) {
		$seperator = $_GET['s'];
	}


	if ( isset($_GET['is']) ) {
		$image_seperator = $_GET['is'];
	}


	if ( isset($_GET['a']) ) {
		$author = $_GET['a'];
	}

	if ( isset($_GET['https']) ) {
		$ssl = true;
	}
}


$mapping = array (
	'Mileage'	=>	'ad_miles',
	'Price'		=>	'ad_price',
	'SpecialPrice'		=>	'ad_price',
	'SellingPrice'		=>	'ad_price',
	'LotPrice'		=>	'ad_price',
	'Internet_Price'		=>	'ad_price',
	'VIN'		=>	'ad_vin',
	'VIN_No'		=>	'ad_vin',
	'Dealer Name'	=>	'author',
	'SpecialPrice'	=>	'ad_price',
	'WebPrice'		=>	'ad_price',
	'Images'		=>	'img',
	'Exterior'		=>	'ad_color',
	'Options'		=>	'content',
	'Taglines'		=>	'content',
	'Category'		=>	'category',
	'Odometer'		=>	'ad_miles',
	'Miles'		=>	'ad_miles',
	'Color'	=>	'ad_color',
	'Features'	=>	'content',
	'Photo Url List'	=>	'img',
	'Image_List'	=>	'img',
	'Photo_URLs'	=>	'img',
	'ImageURLs'	=>	'img',
	'Price'	=>	'ad_price'
);

$removeElements = array (

);

if ( empty($filename)) {
	die("No File Specified");
}

echo "\n****************Processing $filename*********************\n";
echo "\n****************Seperator $seperator*********************\n";
echo "\n****************image_seperator $image_seperator*********************\n";
echo "\n****************Processing $filename*********************\n";

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
echo '<p>Total Deals: ' . count ( $dataFields ) . '</p>';

foreach ($mapping as $key => $value ) {
	$_index = array_search($key, $colHeads);
	if ( trim($_index) != '' ) {
		$indexes[$key] = $_index;
	} else {
		// echo '\nignoring : ' . $_index;
	}
}
// print_r($indexes);
?>

<?php $args = array(
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
 ); ?>
<?php
$index_field = 0;
echo '<table>';
foreach ($dataFields as $key ) {
	echo '<tr>';
	$values = array();
	++$index_field;
	foreach ($indexes as $_key => $value) {
		$values[$mapping[$_key]] = $key[$value];
	}
	if ( $author ) {
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

	if ( empty($values['ad_miles'])) {
		$values['error'] = "No Miles available";
		echo "<td>$values[error]</td>";
		goto nextVIN;
	}

	$values['author'] = $users[0]->ID;
	echo "<td>$values[author]</td>";
	$values['zipcode'] = get_user_meta ( $values['author'], "dealership_address_zipcode", true);
	echo "<td>$values[zipcode]</td>";
	$values['state'] = get_user_meta ( $values['author'], "dealership_address_state", true);
	echo "<td>$values[state]</td>";


	// echo '\n**********VIN: **********' . $values['ad_vin'] . "\n";
	// html_echo ( "[$index_field of $total_deals] Processing VIN : " . $values['ad_vin']);
	echo "<td>$values[ad_vin]</td>";

	// print_r($values);
	if ( !empty ($values['img'])) {
		if ( count(explode("|", $values['img'])) > count(explode(",", $values['img'])) ) {
			$images = array_slice(explode("|", $values['img']), 0, 5);
		} else {
			$images = array_slice(explode(",", $values['img']), 0, 5);
		}
	} else {
		$values['error'] = "No Images Found";
		echo "<td>$values[error]</td>";
		goto nextVIN;
	}
	unset ( $values['img']);
	
	if (!empty($values['category'])) {
		$catObj = get_category_by_slug ( strtolower($values['category']));
		// print_r($catObj);
		$values['category'] = $catObj->term_id;
		echo "<td>$values[category]</td>";

	}

	if ( empty($values['ad_price']) || ! isset($values['ad_price'])) {
		echo '\n**********PRICE MISSING: ********** for ' . $values['ad_vin'] . "\n";
		// print_r($values);
		$values['error'] = 'Price Missing';
		$lists[] = $values;
		echo "<td>$values[error]</td>";
		goto nextVIN;	
	}

	$document = new DOMDocument();

	// $vin_index = array_search('VIN', $colHeads);
	// echo $mapping['VIN'] . "\t" . $key[$vin_index] . "\n";
	// $dealer_name = array_search('Dealer Name', $colHeads);
	$_GET['vin'] = $values['ad_vin'];

	$duplicate_vin = get_data ( get_template_directory_uri() . '/ajax_validate_duplicate_vin.php?vin=' . $values['ad_vin'] );

	if ( $duplicate_vin == '<empty/>' || empty ($duplicate_vin) ) {

	} else {
		$values['error'] = 'duplicate VIN';
		$lists[] = $values;
		$document->loadXML( $duplicate_vin);		
		$query = new DOMXpath ( $document );
		// echo "URL: " . get_content( $query->query("//guid", $document) ) . "\n";
		html_echo ( "Skipping - duuplicate VIN : " . $values['ad_vin']);
		// die();
		echo "<td>" . get_content( $query->query("//guid", $document) ) . "</td>";

		goto nextVIN;
	}


	//url	= url+"?vin="+jQuery(vin_no).val()+"&z="+zipcode+"&m="+miles+"&o="+operation+"&s="+state;	


	// include_once ( TEMPLATEPATH . '/ajax_form_nada.php');

	$obj['vin'] = $values['ad_vin'];
	$obj['z'] = $values['zipcode'];
	$obj['m'] = $values['ad_miles'];
	$obj['o'] = 'nada';
	$obj['s'] = $values['state'];


	$vin_details = get_data ( get_template_directory_uri() . '/ajax_form_nada.php?' . http_build_query($obj) );

	echo get_template_directory_uri() . '/ajax_form_nada.php?' . http_build_query($obj) . "<br/>";

	try {
		$document->loadXML( $vin_details);		
	} catch ( Exception $e ) {
		echo "<td>$e->getMessage</td>";
		// print_r($e);
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

	// print_r($values);

	// goto nextVIN;

	$post_id = wp_insert_post( $post_args );	
	
	$values['post_id'] = $post_id;

	echo "<td>$values[post_id]</td>";


	// echo "\n*****************POST: $post_id*******************\n";

	include ( TEMPLATEPATH . '/lib/pages/post_submission_pre_processing.php');

	$values = process_next_steps ( $images, $values, $post_id );
	$values['error'] = 'No Errors';
	echo "<td>$values[error]</td>";
	$lists[] = $values;

	nextVIN :
	echo '</tr>';

}

echo '</table>';

function process_next_steps ($images, $values, $post_id) {
	global $log;
	$target_path = wp_upload_dir();
	$files = array();
	foreach ($images as $image => $image_value) {
		if ( $image < 5 ) {
			$uploaded_img = download_images ( sys_get_temp_dir(), $image_value );
			$uploaded_img_array[] = basename($uploaded_img);

		}
		// print_r($post);
		// print_r($_FILES);
		// wp_delete_post ($post_id);
		// die();
	}
	$obj['files'] = implode(',', $uploaded_img_array);
	echo "<td>$obj[files]</td>";
	$obj['cwd'] = sys_get_temp_dir();
	$obj['post_id'] = $post_id;

	$url = get_stylesheet_directory_uri() . '/importDeals/fileupload.php?' . http_build_query($obj);

	$data = get_data ( $url );

	echo "<td>$data</td>";

	// wp_delete_post($post_id, true);
	return $values;	
}

foreach ($lists as $key ) {
	print_r($key);
}

function get_content ( $nodes ) {
	foreach ($nodes as $node ) {
		// echo __LINE__;
		return $node->textContent;
	}
}
function html_echo ( $string, $tag = 'p') {
	// echo '<' . $tag . '>' . $string . '</' . $tag . '>';
	// echo $string . "\n";
}

function get_data($url)
{
  $ch = curl_init();
  $timeout = 25;
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch,CURLOPT_HTTPPROXYTUNNEL, 1);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  
  $data = curl_exec($ch);
  if ( curl_error($ch) && curl_errno($ch) != '0') {
  	$data .= curl_errno($ch);
  }
  curl_close($ch);
  return $data;
}

function split_names ( $str ) {
	$tmp = '';
	if ( strpos($str, '=') === false) {

	} else {
		$tmp = explode('=', $str);
		$str = $tmp[1];
	}
	return $str;
}


?>
