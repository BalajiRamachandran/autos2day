<?php
require dirname(__FILE__) . '/../../../../../wp-load.php';
/*
*	saves the user information to database
*/
if ( ! isset($_GET['debug'])) {
	if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
		header("Content-type: application/xhtml+xml;charset=utf-8"); 
	} else {
		header("Content-type: text/xml;charset=utf-8");
	}	
}

$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
if(!$sidx) $sidx =1;

$xml = load_what_is_needed ( "xml" );
$log = load_what_is_needed ( "log" );
$result = count_users();
$offset = $limit*$page - $limit;
// $number = $number ? $number : 10;
$get_users_args = array(
	'blog_id' => $GLOBALS['blog_id'],
	'role' => '',
	'meta_key' => '',
	'meta_value' => '',
	'meta_compare' => '',
	'meta_query' => array(),
	'include' => array(),
	'exclude' => array(),
	'order' => $sord,
	'search' => '',
	'count_total' => true,
	'fields' => 'all',
	'who' => '',
	'offset' => $offset,
	'number' => $limit
 );

$all_users = get_users($get_users_args);
$total_users = $result['total_users'];
$xmlUsers = new stdClass();
foreach ($all_users as $user ) {
	$userMeta = get_user_meta ( $user->ID );
	$xmlUsers->{$user->ID} = $user;
	foreach ($userMeta as $key => $value) {
		$xmlUsers->{$user->ID}->meta->$key = $value[0];
	}
	if ( empty($xmlUsers->{$user->ID}->meta->email1)) {
		$xmlUsers->{$user->ID}->meta->email1 = '';
	}
	if ( empty($xmlUsers->{$user->ID}->meta->email2)) {
		$xmlUsers->{$user->ID}->meta->email2 = '';
	}
	if ( empty($xmlUsers->{$user->ID}->meta->email3)) {
		$xmlUsers->{$user->ID}->meta->email3 = '';
	}
	if ( empty($xmlUsers->{$user->ID}->meta->email4)) {
		$xmlUsers->{$user->ID}->meta->email4 = '';
	}
}

if( $total_users > 0 ) {
	$total_pages = ceil($total_users/$limit);
} else {
	$total_pages = 0;
}

if ($page > $total_pages) { $page = $total_pages; };


$xmlUsers->page = $page;
$xmlUsers->limit = $limit;

$xmlUsers->records = $total_users;
$xmlUsers->total = $total_pages;
$xmlUsers->offset = $offset;

echo $xml->generate_valid_xml_from_array($xmlUsers, 'Users', 'user');

?>