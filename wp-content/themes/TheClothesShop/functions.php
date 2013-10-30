<?php
// necessary b'c php4 is still around now and then...
if(is_admin()&& isset($_GET['activated'] ) && $pagenow == "themes.php" ){			
	if(!version_compare(PHP_VERSION, '5.0.0', '>=')){			
		echo "<div class='error'>".
			__('You are using a PHP version lower than 5.0.0 - please contact your host to upgrade to version 5.','wpShop').
		"</div>";
	}
	if(((int) ini_get('memory_limit')) < 64){
		echo "<div class='error'>".
			__('The php memory limit of your webspace is too low: ','wpShop') . (int) ini_get('memory_limit') . 'MB' . "<br/>" .
			__('This theme requires a php memory limit of 128MB - please contact your host to upgrade your webspace.','wpShop') . 
		"</div>";	
	}
}
// SSL 	
	add_filter('option_siteurl', 'adjust2ssl');
	add_filter('option_home', 'adjust2ssl');
	add_filter('option_url', 'adjust2ssl');
	add_filter('option_wpurl', 'adjust2ssl');
	add_filter('option_stylesheet_url', 'adjust2ssl');
	add_filter('option_template_url', 'adjust2ssl');

	if(!isset($_SERVER['HTTPS'])){$_SERVER['HTTPS'] = NULL;}	
	if(!isset($_SERVER['SSL'])){$_SERVER['SSL'] = NULL;}		
	
	
// Load required files, modules + define necessary constants
	define('WPSHOP_LIB', 'lib/');
	require_once(WPSHOP_LIB . 'engine/options.php');

	$OPTION 					= NWS_get_global_options();
	$CONFIG_WPS 				= array();
	$CONFIG_WPS['themename'] 	= $OPTION['template'];
	$CONFIG_WPS['shortname'] 	= 'wps';
	$CONFIG_WPS['prefix'] 		= 'wps_';

	// Current theme
	define('WPSHOP_THEME_NAME',$OPTION['template']);

	// Email delivery typ	
	define('WPSHOP_EMAIL_FORMAT_OPTION',$OPTION['wps_email_delivery_type']); // txt,mime, later html
	
	require_once(WPSHOP_LIB . 'engine/cart_actions.php');
	/* registering custom_engine.php */
	require_once(WPSHOP_LIB . '../../TheClothesShopDark/lib/engine/custom_engine.php');
	// register payment+delivery modules
	$CONFIG_WPS['p_modules'] = list_modules('payment');
	$CONFIG_WPS['d_modules'] = list_modules('delivery');	
			
	if(!isset ($OPTION['wps_shop_country'])){
		require_once(WPSHOP_LIB . 'modules/tax/globalTax/DE.php');
	} else {
		require_once(WPSHOP_LIB . 'modules/tax/globalTax/'.$OPTION['wps_shop_country'].'.php');	
	}
	if(is_admin()){
		require_once(WPSHOP_LIB . 'engine/theme_options.php');
		require_once(WPSHOP_LIB . 'engine/backend_actions.php');
	}

	require_once(WPSHOP_LIB . 'engine/NWS_functions.php');
	require_once(WPSHOP_LIB . 'engine/NWS_taxonomies.php');
	require_once(WPSHOP_LIB . 'engine/NWS_shortcodes.php');
	require_once(WPSHOP_LIB . 'engine/NWS_widgets.php');
	//change.9.10  // link to lib\static-info\errors\error_details.php	removed
	
if(is_admin()){

	// Add admin css
	function nws_admin_styles(){
		echo "<link rel='stylesheet' media='all' type='text/css' href='".get_bloginfo('template_url')."/css/admin.css' />";
	}

	// Add admin scripts
	function nws_admin_scripts(){
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('thickbox');
		wp_enqueue_script( 'myadmin.js', get_template_directory_uri().'/js/myadmin.js', array('jquery'), '1',true );
	}


	// Add theme options
	function nws_add_admin(){
		global $CONFIG_WPS,$OPTION,$options;

		if($_GET['page'] == basename(__FILE__)){

			if('save' == $_REQUEST['action']){
				
					// we need to know which country is currently zone 1 country
					$cAbbrOld 	= $OPTION['wps_shop_country'];
					
					
					foreach($options as $value){	
					
						if(($value['type'] == 'checkbox') && (!isset($_POST[ $value['id'] ]))){
							$actualValue = 'false';
						}
						else {
							$actualValue = $_REQUEST[ $value['id'] ];
						}
				
						update_option($value['id'],$actualValue); 
					}
					
			
					// we set the shop country as zone 1 in countries db-table
					update_zone_one($cAbbrOld);
						
					summarize_multi_checkbox('_payment_options',$CONFIG_WPS[p_modules]);
					summarize_multi_checkbox('_delivery_options',$CONFIG_WPS[d_modules]);	
		
					optimize_table();
		
					//header("Location: themes.php?page=functions.php&saved=true");
					header("Location: admin.php?page=functions.php&saved=true");
					die;

			} else if( 'reset' == $_REQUEST['action'] ){

				foreach ($options as $value) {
					delete_option( $value['id'] ); }

				//header("Location: themes.php?page=functions.php&reset=true");
				header("Location: admin.php?page=functions.php&reset=true");
				die;
			}
		}

	add_object_page($CONFIG_WPS['themename'],__('eCommerce','wpShop'), 'administrator', basename(__FILE__), 'NWS_theme_admin', get_bloginfo('template_directory'). '/images/admin/shopping_cart.png'); 
	add_submenu_page(basename(__FILE__), $CONFIG_WPS['themename'],__('Theme Options','wpShop'), 'administrator', basename(__FILE__), 'NWS_theme_admin');
		//using the shopping cart?
		if($OPTION['wps_shoppingCartEngine_yes']) {
			if($OPTION['wps_shop_mode'] == 'Normal shop mode'){ 
				add_submenu_page(basename(__FILE__), $CONFIG_WPS['themename'],__('Manage Orders','wpShop'), 'administrator', basename(__FILE__).'&section=orders','NWS_theme_admin');
			}elseif($OPTION['wps_shop_mode'] == 'Inquiry email mode'){
				add_submenu_page(basename(__FILE__), $CONFIG_WPS['themename'],__('Manage Enquiries','wpShop'), 'administrator', basename(__FILE__).'&section=inquiries','NWS_theme_admin');  
			} else{}
			if($OPTION['wps_track_inventory']=='active'){
				add_submenu_page(basename(__FILE__), $CONFIG_WPS['themename'],__('Manage Inventory','wpShop'), 'administrator', basename(__FILE__).'&section=inventory','NWS_theme_admin'); 
			}
			$l_mode = $OPTION['wps_l_mode'];
			if(($l_mode == 'GIVE_KEYS')&&($OPTION['wps_shop_mode'] != 'payloadz_mode')&&($OPTION['wps_shop_mode'] != 'Inquiry email mode')){ 
				add_submenu_page(basename(__FILE__), $CONFIG_WPS['themename'],__('Manage LKeys','wpShop'), 'administrator', basename(__FILE__).'&section=lkeys','NWS_theme_admin'); 
			} 
			if ($OPTION['wps_voucherCodes_enable']) {
				add_submenu_page(basename(__FILE__), $CONFIG_WPS['themename'],__('Manage Vouchers','wpShop'), 'administrator', basename(__FILE__).'&section=vouchers','NWS_theme_admin');
			}
		}
		// using the membership area?
		if($OPTION['wps_lrw_yes']) { 
			add_submenu_page(basename(__FILE__), $CONFIG_WPS['themename'],__('Manage Members','wpShop'), 'administrator', basename(__FILE__).'&section=members','NWS_theme_admin'); 
		}
		if($OPTION['wps_shoppingCartEngine_yes']) {
			add_submenu_page(basename(__FILE__), $CONFIG_WPS['themename'],__('Statistics','wpShop'), 'administrator', basename(__FILE__).'&section=statistics','NWS_theme_admin');
		}
	}

	wp_enqueue_style('thickbox');
	add_action('admin_head', 'nws_admin_styles');
	add_action('init', 'nws_admin_scripts');
	add_action('admin_menu', 'nws_add_admin');
}

// Add translations
if(!function_exists ( 'NWS_theme_init' )){
	function NWS_theme_init(){
		load_theme_textdomain('wpShop', get_template_directory().'/languages/');
	}
	add_action('init', 'NWS_theme_init');
}
?>