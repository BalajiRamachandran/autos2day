<?php
require dirname(__FILE__) . '/../../../../wp-load.php';
include dirname(__FILE__) . '/utils.php';

$destination = $_SERVER['DOCUMENT_ROOT'] . '/imported/';

foreach ($_FILES as $key ) {
	$tmp_name = $key[tmp_name][0];
	$filename = $destination . $key[name][0];
	if ( ! move_uploaded_file( $tmp_name, $filename) ) {
		die("Upload Failed!");
	}
}

// error_reporting(E_ALL);
// ini_set("display_errors", 1); 
$log = load_what_is_needed ( "log" );
// read csv file
$author = '';
$ssl = false;
$lists = array();
if ( is_ssl() ) {
	$ssl = true;
}

if ( isset($_POST['a']) ) {
	$author = $_POST['a'];
}

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
	'ImageURLs'	=>	'img',
	'Price'	=>	'ad_price'
);

?>

<?php
	$f = fopen($filename, "r") or die("unknown"); 
	$line = fgets($f);
	// echo $line . "\n";
	if ( explode(",", $line) > explode("\t", $line) ) {
		$seperator = 'comma';
	} else {
		$seperator = 'tab';
	}
	fclose($f);
	switch ($seperator) {
		case 'tab':
			$colHeads = str_getcsv($line, "\t");
			break;
		case 'comma':
			$colHeads = str_getcsv($line, ",");
			break;
		
		default:
			# code...
			break;
	}
?>

<?php
$dataFields = read_files ( $filename, $seperator );


$total_deals = count ( $dataFields );

foreach ($mapping as $key => $value ) {
	$_index = array_search($key, $colHeads);
	if ( trim($_index) != '' ) {
		$indexes[$key] = $_index;
	} else {
		// echo '\nignoring : ' . $_index;
	}
}
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
 ); 


?>
<?php
$index_field = 0;

foreach ($dataFields as $key ) {
	$values = array();
	++$index_field;
	print_r($key);
	print_r($indexes);

	foreach ($indexes as $_key => $value) {
		print_r($_key);
		$values[$mapping[$_key]] = $key[$value];
	}
	if ( $author ) {
		$values['author'] = $author;
	}
	print_r($values);
	die();

	$args['meta_key'] = 'dealership_id';
	$args['meta_value'] = $values['author'];
	$values['content'] = str_replace (",", ", ", $values['content']);


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

	if ( !empty ($values['img'])) {
		if ( count(explode("|", $values['img'])) > count(explode(",", $values['img'])) ) {
			$images = array_slice(explode("|", $values['img']), 0, 5);
		} else {
			$images = array_slice(explode(",", $values['img']), 0, 5);
		}
	} else {
		$values['error'] = "No Images Found";
		print_r($values);		
		goto nextVIN;
	}
	unset ( $values['img']);

	print_r($values);
	echo '<hr/>';
	goto nextVIN;

	if (!empty($values['category'])) {
		$catObj = get_category_by_slug ( strtolower($values['category']));
		// print_r($catObj);
		$values['category'] = $catObj->term_id;
	}

	if ( empty($values['ad_price']) || ! isset($values['ad_price'])) {
		echo '\n**********PRICE MISSING: ********** for ' . $values['ad_vin'] . "\n";
		// print_r($values);
		$values['error'] = 'Price Missing';
		$lists[] = $values;
		goto nextVIN;	
	}

	$document = new DOMDocument();

	// $vin_index = array_search('VIN', $colHeads);
	// echo $mapping['VIN'] . "\t" . $key[$vin_index] . "\n";
	// $dealer_name = array_search('Dealer Name', $colHeads);
	$_GET['vin'] = $values['ad_vin'];
	$text_output = true;
	include_once ( TEMPLATEPATH . '/ajax_validate_duplicate_vin.php' );
	try {
		$duplicate_vin = check_duplicate ( array('vin' => $values['ad_vin'] ) );
		if ( $duplicate_vin == '<empty/>' || empty ($duplicate_vin) ) {
			$values['duplicate_vin'] = 'false';
		} else {
			$values['error'] = 'duplicate VIN';
			$lists[] = $values;
			// $document->loadXML( $duplicate_vin);		
			// $query = new DOMXpath ( $document );
			// echo "URL: " . get_content( $query->query("//guid", $document) ) . "\n";
			// html_echo ( "Skipping - duuplicate VIN : " . $values['ad_vin']);
			// die();
			goto nextVIN;
		}

	} catch ( Exception $e ) {
		$values['error'] = $e->getMessage;
		$lists[] = $values;		
		goto nextVIN;
	}


	//url	= url+"?vin="+jQuery(vin_no).val()+"&z="+zipcode+"&m="+miles+"&o="+operation+"&s="+state;	

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
	
	$values['post_id'] = $post_id;

	// wp_delete_post ( $post_id, true);
	

	include ( TEMPLATEPATH . '/lib/pages/post_submission_pre_processing.php');

	$values = process_next_steps ( $images, $values, $post_id );
	$values['error'] = 'No Errors';
	$lists[] = $values;

	nextVIN :

}

foreach ($lists as $key ) {
	# code...
	echo '<p id="' . $key['post_id'] . '">' . http_build_query ( $key ) . '</p>';
}
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

<div id="consolelog"><!----></div>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("p[id]").each(function(){
		jQuery("#consolelog").append ( jQuery(this).attr("id"));
	});
});
</script>

<?php

function process_next_steps ($images, $values, $post_id) {
	global $log;
	$target_path = wp_upload_dir();
	$files = array();
	foreach ($images as $image => $image_value) {
		if ( $image < 5 ) {
			$uploaded_img = download_images ( $target_path['path'], $image_value );
			$values[$image_value] = $uploaded_img;
			$var = 'upload_images_i' . $image;
			$rand = rand(10000,99999);
			$move_image = $target_path['path'] . '/' . $rand . basename($uploaded_img);
			$args = array (
				'f'	=>	$uploaded_img,
				'n'	=>	$var,
				'u'	=>	get_stylesheet_directory_uri() . '/lib/pages/fileupload.php',
				'm'	=>	$move_image
			);
			$_FILES[$var]['error'] = 0;
			$_FILES[$var]['tmp_name'] = $uploaded_img;
			$move_image = $uploaded_img;

			unset ( $file_obj);
			unset ( $_files );

			include ( TEMPLATEPATH . '/lib/pages/fix_image_names.php');

	        $wp_filetype 			= wp_check_filetype( basename( $move_image ), null );   

	        $attachment = array(
	            'post_mime_type' => $wp_filetype['type'],
	            'post_title' => preg_replace('/\.[^.]+$/', '', basename( $move_image ) ),
	            'post_content' => '',
	            'post_author' => $post->post_author,
	            'post_status' => 'inherit',
	            'post_type' => 'attachment',
	            'post_parent' => $post_id,
	            'guid' => $target_path['baseurl'] . '/' . basename( $move_image )
	        );
	        // insert the attachment post type and get the ID
	        $attachment_id = wp_insert_post( $attachment );
	        $log->general("Attachment Id: " . $attachment_id, $post_id . '_');
	        // generate the attachment metadata
	        $attach_data = wp_generate_attachment_metadata( $attachment_id, $uploaded_file['file'] );
	        // update the attachment metadata
	        $return = wp_update_attachment_metadata( $attachment_id,  $attach_data );
		}
	}
	return $values;	
}

function get_content ( $nodes ) {
	foreach ($nodes as $node ) {
		// echo __LINE__;
		return $node->textContent;
	}
}
function html_echo ( $string, $tag = 'p') {
	// echo '<' . $tag . '>' . $string . '</' . $tag . '>';
	echo $string . "\n";
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
  $data = curl_exec($ch);
  if ( curl_error($ch)) {
  	$data = curl_error($ch);
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