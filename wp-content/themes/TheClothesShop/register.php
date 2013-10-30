<?php
$p = explode('wp-content/',__FILE__);
include $p[0].'wp-load.php';

session_start();

$_SESSION['POST_DATA'] = $_POST;
$accountLog		= get_page_by_title($OPTION['wps_pgNavi_logOption']);
$accountReg		= get_page_by_title($OPTION['wps_pgNavi_regOption']);

$EMAIL 			= load_what_is_needed('email');		//change.9.10
$log 			= load_what_is_needed("log");

// Verify inputs
$POST 			= clean_data($_POST);
$email			= trim($POST['email']);
$username 		= trim($POST['username']);
if ( !isset($POST['username'])) {
	$username 		= $email;
}
$url 			= $OPTION['siteurl'].'/'.$accountReg->post_name.'';

// anything empty, too short, too long?
	if(strlen($email) < 6){
		header("Location: $url".'?err=1');exit(NULL);
	}
	if(strlen($username) < 6){
		header("Location: $url".'?err=2');exit(NULL);
	}
	// if(strlen($username) > 10){
	// 	header("Location: $url".'?err=3');exit(NULL);
	// }

	// valid email?
	if(validate_user_email($email) !== TRUE){
		header("Location: $url".'?err=4');exit(NULL);
	}

//wp_create_user( $username, $password, $email );

// $user_id = username_exists( $username );
// if ( !$user_id ) {
// 	$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
// 	$user_id = wp_create_user( $username, $random_password, $email );
// } else {
// 	$random_password = __('User already exists.  Password inherited.');
// }


// user name already taken?
	
	$table 				= 'wp_users';//is_dbtable_there('wp_users');//feusers');
	$qStr 				="SELECT ID FROM $table WHERE user_login = '$username'";	
	$result 			= mysql_query($qStr);
	$num 				= mysql_num_rows($result);
	if($num > 0)
	{
		header("Location: $url".'?err=5');exit(NULL);	
	}

// create password
	$pw = generateRandomString();



	require_once( ABSPATH . WPINC . '/registration.php');

	$userid = register_new_user($username, $email, $_POST);
	
	if ($userid->errors['email_exists']) {
		header("Location: $url".'?err=email');
		exit(NULL);
	}
	// print_r($userid);
	// echo '<hr/>';	
	// print_r($_POST);
	// echo '<hr/>';
	// print_r($name);
	// die();

	if ( $userid ) {
		$res=true;
	}

	if ( $res ) {
		$log->general ("User registration: " . $userid . " contact: " . $_POST['contact']);
		$contact_name = explode(" ", $_POST['contact']); 
		$table 				= is_dbtable_there('a2d_meta_master');//feusers');
		//$qStr 				="SELECT uid FROM $table WHERE uname = '$username'";	
		$qStr 				="SELECT * FROM $table WHERE meta_type = 'user'";	

		$result 			= mysql_query($qStr);
		$num 				= mysql_num_rows($result);

		while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			$id 			= $row[0];
			$key 			= $row[1];
			$desc 			= $row[3];

			if ( $key == "dealership_id" ) {
				$value 		= "SD" . sprintf('%05d', $userid);
			} else {
				$value 		= "";
				if ( isset($_POST[$key])) {
					$value = $_POST[$key];
				}
			}

			update_user_meta ( $userid,  $key, $value);
		}		
	}
	// print_r($contact_name);
	update_user_meta ( $userid,  'show_admin_bar_front', 'false');
	update_user_meta ( $userid,  'first_name', $contact_name[0]);
	update_user_meta ( $userid,  'last_name', $contact_name[1]);
	// die();
	//
	//
	//
	//


	//wp_update_user ( array ('ID' => $userid, 'user_url' => 'url', 'first_name' => $name[0]));
	

// // db insert
// 	$pwdb			= md5(trim($pw));

// 	$table 			= 'wp_users';//is_dbtable_there('feusers');
// 	$now			= time();
// 	$sql 			= "INSERT INTO $table (uname,pw,email,since) VALUES ('$username','$pwdb','$email',CURDATE())";	
// 	$res 			= mysql_query($sql);


// // email to new user
// 	$search		= array("[##header##]","[##pw##]","[##login_link##]","[##username##]");
// 	//change.9.10
// 	$replace 	= array($EMAIL->email_header(),$pw,get_option('siteurl').'/'.$accountLog->post_name.'',$username);	 
// 	$EMAIL->email_new_user_welcome($email,$search,$replace);  
// 	//\change.9.10
	  
	  
// // email to shop owner
// 	$search		= array("[##header##]","[##username##]");
// 	//change.9.10
// 	$replace 	= array($EMAIL->email_header(),$username);	  		
// 	$EMAIL->email_new_user_owner_notify($email,$search,$replace);  
	//\change.9.10 

// redirect user 
if($res == true){

       // Weiterleitung zur gesch&uuml;tzten Startseite
       if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1') {
			if (php_sapi_name() == 'cgi') {
			 header('Status: 303 See Other');
			 }
			else {
			 header('HTTP/1.1 303 See Other');
			 }
        }


       // we send the users to different pages acc. to user level
       if( $res == true ){
       	unset ( $_SESSION['POST_DATA'] );
		$url = get_permalink( $accountLog->ID );
		$url = get_option('home').'/'.$accountLog->post_name.'?reg=ok';
		header("Location: $url");
       }
       else{
		header('Location: http://'.$hostname.($path == '/' ? '' : $path));
       }
       exit();
       }



/**
 * Handles registering a new user.
 *
 * @param string $user_login User's username for logging in
 * @param string $user_email User's email address to send password and add
 * @return int|WP_Error Either user's ID or error on failure.
 */
function register_new_user( $user_login, $user_email, $user_data ) {
	$errors = new WP_Error();

	$sanitized_user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );

	// Check the username
	if ( $sanitized_user_login == '' ) {
		$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Please enter a username.' ) );
	} elseif ( ! validate_username( $user_login ) ) {
		$errors->add( 'invalid_username', __( '<strong>ERROR</strong>: This username is invalid because it uses illegal characters. Please enter a valid username.' ) );
		$sanitized_user_login = '';
	} elseif ( username_exists( $sanitized_user_login ) ) {
		$errors->add( 'username_exists', __( '<strong>ERROR</strong>: This username is already registered, please choose another one.' ) );
	}

	// Check the e-mail address
	if ( $user_email == '' ) {
		$errors->add( 'empty_email', __( '<strong>ERROR</strong>: Please type your e-mail address.' ) );
	} elseif ( ! is_email( $user_email ) ) {
		$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: The email address isn&#8217;t correct.' ) );
		$user_email = '';
	} elseif ( email_exists( $user_email ) ) {
		$errors->add( 'email_exists', __( '<strong>ERROR</strong>: This email is already registered, please choose another one.' ) );
	}

	do_action( 'register_post', $sanitized_user_login, $user_email, $errors );

	$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

	if ( $errors->get_error_code() )
		return $errors;

	$user_pass = wp_generate_password( 12, false);

	$user_id = wp_create_user( $sanitized_user_login, $user_pass, $user_email );

	if ( ! $user_id ) {
		$errors->add( 'registerfail', sprintf( __( '<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !' ), get_option( 'admin_email' ) ) );
		return $errors;
	}

	update_user_option( $user_id, 'default_password_nag', true, true ); //Set up the Password change nag.

	ad_new_user_notification( $user_id, $user_pass, $user_data );
	return $user_id;
}

	
?>