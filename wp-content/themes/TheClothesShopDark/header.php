<?php
session_start();
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
date_default_timezone_set(get_option('timezone_string'));
include (TEMPLATEPATH . '/lib/pages/header_head.php');
$OPTION = NWS_get_global_options();

// if a blog is used
$blog_Name 	= $OPTION['wps_blogCat'];
if ($blog_Name != 'Select a Category') {
	$blog_ID 	= get_cat_ID( $blog_Name );
}

if (is_page()) {
	$parentPage_title 	= get_the_title($post->post_parent);
	$currentPage_title 	= get_the_title($post->post_nicename);
}

if (is_category() || is_single()) {
	$catDepth 			= get_depth();
}

if (is_category()) {
	$this_category 		= get_category($cat);
	$topParent 			= NWS_get_root_category($cat,'allData');
	$topParentSlug 		= $topParent->slug;
	$this_categorySlug 	= $this_category->slug;
}

//this is for the SEO Optimized category titles, keywords & description		
if(is_category() || is_tag() || is_tax()) {
	//get queried object
	$post_obj = $wp_query->get_queried_object();
	
	// title
		//get the array from options table
		$current_term_hTitle = get_option( 'term_hTitle' );
		//check if the taxonomy has a title saved in the database
		if ( is_array( $current_term_hTitle ) && array_key_exists( $post_obj->term_id, $current_term_hTitle ) ) {
			$term_hTitle = $current_term_hTitle[$post_obj->term_id];
			$term_hTitle = esc_html(stripslashes($term_hTitle));
		}
	
	// keywords
		//get the array from options table
		$current_term_keywords = get_option( 'term_keywords' );
		//check if the taxonomy has a title saved in the database
		if ( is_array( $current_term_keywords ) && array_key_exists( $post_obj->term_id, $current_term_keywords ) ) {
			$term_keywords = $current_term_keywords[$post_obj->term_id];
			$term_keywords = esc_html(stripslashes($term_keywords));
		}
	
	// description
		//get the array from options table
		$current_term_description = get_option( 'term_description' );
		//check if the taxonomy has a title saved in the database
		if ( is_array( $current_term_description ) && array_key_exists( $post_obj->term_id, $current_term_description ) ) {
			$term_description = $current_term_description[$post_obj->term_id];
			$term_description = esc_html(stripslashes($term_description));
		}
}
?>
<?php
if (is_single()) {
	global $post;

	$category 			= get_the_category($post->ID);
	$topParent_cat 		= get_post_top_parent();
	$topParent_catSlug 	= get_cat_slug($topParent_cat);
	$Parent_cat 		= get_parent_cat_id();
	$Parent_catSlug 	= get_cat_slug($Parent_cat);	
}

if (is_single() || is_page()) {
	global $post;
	// get SEO related content
	$nws_seo_title 			= esc_html(get_custom_field2($post->ID, 'seo_title', FALSE));
	$nws_seo_keywords 		= esc_html(get_custom_field2($post->ID, 'seo_keywords', FALSE));
	$nws_seo_description 	= esc_html(get_custom_field2($post->ID, 'seo_description', FALSE));
}

if (is_attachment()) {
	$category 	= get_the_category($post->post_parent);
	$topParent 	= NWS_get_root_category($category[0]->term_id,'allData');
}

if ($OPTION['wps_customerAreaPg']!='Select a Page') {
	$customerArea	= get_page_by_title(get_option('wps_customerAreaPg'));
}
$lostPass	= get_page_by_title($OPTION['wps_passLostPg']);

/*expiration-format*/
add_option('expiration_format', 'Y-m-d H:i:s', '', 'yes');
add_option('images_count', '1', '', 'yes');


?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> >
	<head>
		<title>
			<?php
			// SN change
			// SEO Optimized Titles
			if ( is_single() || is_page()) { echo ( $nws_seo_title != '' ? $nws_seo_title : the_title_attribute( 'echo=0') );} 
			elseif(is_category() || is_tag() || is_tax()) { echo ( $term_hTitle != '' ? $term_hTitle : wp_title('', false) );}			
			elseif ( is_home() || is_front_page() ) { bloginfo('name'); }
			elseif ( is_search() ) { bloginfo('name'); print ' | Search results for ' . esc_html($s); get_page_number(); }
			elseif ( is_404() ) { bloginfo('name'); print ' | Not Found'; }
			else { wp_title('|'); bloginfo('name');  get_page_number(); }
			//\ SN
			?>
		</title>
		
		<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
		
		<?php 
		// SEO Optimized Meta Descriptions and Keywords
		// SEO Optimized Meta Descriptions and Keywords
		// SN change2
		if(is_home() || is_front_page()) { ?>
			<meta name="description" content="<?php echo ( $OPTION['wps_description'] != '' ? esc_html(stripslashes($OPTION['wps_description'])) : bloginfo('description') ); ?>" />
			<meta name="keywords" content="<?php echo $OPTION['wps_keywords'];?>" />
		<?php
		//\ SN change2
		} elseif(is_category() || is_tag() || is_tax() ) { ?>
			<meta name="description" content="<?php echo ( $term_description != '' ? $term_description : esc_html(strip_tags(term_description())) );?> " />
			<meta name="keywords" content="<?php echo $term_keywords;?>" />
			
		<?php 

		} elseif (is_single() || is_page() ) { 
			
			echo ( $nws_seo_description != '' ? "<meta name='description' content='$nws_seo_description' />" : "" );
			echo ( $nws_seo_keywords != '' ? "<meta name='keywords' content='$nws_seo_keywords' />" : "" );
		//\ SN 
		} ?>
		
		
		<?php if(is_search()) { ?>
			<meta name="robots" content="noindex, nofollow" /> 
	    <?php }?>
		<?php if(is_archive() && !is_category()){ ?><meta name="robots" content="noindex" /><?php } ?>
	
		<link rel="stylesheet" type="text/css" media="all" href="<?php NWS_bloginfo('stylesheet_url','yes'); ?>" />
		<link rel="stylesheet" type="text/css" media="print" href="<?php NWS_bloginfo('template_url','yes'); ?>/css/print.css" />
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_bloginfo( 'stylesheet_directory' ) . '/css/colorbox.css'; ?>" />
		
		<?php
			
			wp_head(); 
			
			if(is_admin()){
				global $options;
				foreach ($options as $value) {
					if(!isset($value['id'])){$value['id'] 	= NULL;}		
					if(!isset($value['std'])){$value['std'] = NULL;}		
					if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); }
				}
			}
			
		?>
		<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'wpShop' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
        <link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'wpShop' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" /> 

		<meta property="og:image" content="<?php echo get_stylesheet_directory_uri() . '/images/logo-trans.png';?>"/>
		<meta property="og:type" content="Website"/>
		<meta property="og:url" content="<?php echo get_permalink();?>"/>
		<meta property="og:title" content="Deals of the Day"/>
		<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
		<meta property="fb:app_id" content="<?php echo get_option('wps_fb_app_id');?>"/>
        <meta property="og:description" content="Autos2day The main site"/>
		<script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"></script>
		<script type="text/javascript">
			var is_single;
			var stylesheet_directory = "<?php echo get_bloginfo('stylesheet_directory');?>";
		</script>
		<?php if ( is_single()) {
			?>
				<script type="text/javascript">
					is_single = '<?php echo is_single();?>';
				</script>					
			<?php
		}?>
		</head>
	
	<?php 
	// am I viewing the shopping cart? || going through checkout? || on confirmation page? || reading the terms and conditions? etc...
	if($_GET['showCart'] == '1') { ?>
		<body class="shopping_cart">
	<?php } elseif (($_GET['orderNow'] == '1') || ($_GET['orderNow'] == '2') || ($_GET['orderNow'] == '3') || ($_GET['orderNow'] == '4') 
	|| ($_GET['orderNow'] == '5') || ($_GET['orderNow'] == '6') || ($_GET['orderNow'] == '7') || ($_GET['orderNow'] == '8') || ($_GET['orderNow'] == '81')) { ?>
		<body class="shopping_cart order_checkout">
	<?php } elseif(($_GET['confirm'] == '1') || ($_GET['confirm'] == '2') || ($_GET['confirm'] == '3')) { ?>
		<body class="shopping_cart order_confirmation">
	<?php } elseif($_GET['showTerms'] == '1') { ?>
		<body class="shopping_cart terms_and_conditions">
		<?php } elseif($_GET['showMap'] == 1) { ?>
		<body class="shopping_cart map">
		<?php } elseif($_GET['checkOrderStatus'] == 1) { ?>
		<body class="shopping_cart order_status">
		
	<?php } else { ?>
		<body <?php body_class(); if (is_single()) { echo " " . $script; } ?>>
	<?php } ?>
	
	<div id="pg_wrap">
		<div id="header" class="clearfix noprint">
<!-- 			<?php
			if ( is_user_logged_in() ) {
				?>
				<div class='logged_in_banner'>
					Welcome, <?php $current_user = wp_get_current_user(); echo '<strong>' . $current_user->display_name . '</strong>';?>
				</div>
				<?php
			}			
			?>
 -->			<?php if($OPTION['wps_lrscLinks_option'] && $OPTION['wps_logoL'] != TRUE) { $the_container_class = 'container clearfix container_alt';} 
			elseif($OPTION['wps_lrscLinks_option'] && $OPTION['wps_logoL']) { $the_container_class = 'container clearfix logoL';}
			elseif($OPTION['wps_lrscLinks_option'] != TRUE && $OPTION['wps_logoL']) { $the_container_class = 'container clearfix logoL_alt';}
			else {$the_container_class = 'container clearfix';} ?>
			
			<div class="<?php echo $the_container_class;?>">
				<?php include( STYLESHEETPATH . "/includes/headers/header_contents.php" );?>
			</div><!-- container -->
		</div><!-- header-->
		
		
		<div id="myloginoverlay" class="overlay mediumoverlay">
			<h2><?php _e('Login to your Account','wpShop');?></h2>	
		
			<form id="signInForm" method="post" action="<?php echo get_bloginfo('url') . '/wp-login.php?redirect_to=' . $_SERVER['REQUEST_URI']; ?>">
				<fieldset>
					<label for="log"><?php _e('Username','wpShop');?></label>
					<input type="text" name="log" id="log" size="35" value="<?php echo $_SESSION['uname']; ?>" />
					<label for="pwd"><?php _e('Password','wpShop');?></label>
					<input id="pwd" type="password" size="35" value="" name="pwd"/>
					<span class="passhelp"> <?php _e('I lost my password. Please','wpShop');?> <a href="<?php echo get_permalink($lostPass->ID); ?>"><?php _e('email it to me','wpShop');?></a></span>
					
					<?php if(isset($_GET['showCart']) || isset($_GET['orderNow'])){
						$slash 		= (substr(get_real_base_url(),-1,1) == '/' ? '?' : '/?');
						$urlAdd 	= $_SERVER['REQUEST_URI'];
						$urlParts 	= explode("?",$urlAdd);
						$urlAdd		=  $slash . $urlParts[1];
						if(strpos($urlParts[1],'&') !== FALSE){
							$urlParts	= explode("&",$urlParts[1]);
							$urlAdd 	= $slash . $urlParts[0];
						}
					}else {
						$urlAdd = NULL;
					} ?>
					
					<input type='hidden' name='gotoURL' value='<?php echo get_real_base_url().$urlAdd ; ?>' />
					<input class="formbutton" type="submit" alt="<?php _e('Sign in','wpShop');?>" value="<?php _e('Sign in','wpShop');?>" name="" title="<?php _e('Sign in','wpShop');?>" />
				</fieldset>
			</form>
		</div><!-- myloginoverlay -->
		
		<div id="searchoverlay" class="overlay mediumoverlay">
			<h3><?php echo $OPTION['wps_search_title']; ?></h3>
			<p><?php echo $OPTION['wps_search_text']; ?></p>
			<?php //include (TEMPLATEPATH . '/searchform.php'); ?>
			<div class="extLoadWrap">
			</div>
		</div><!-- searchoverlay -->
		
		<?php 
		$term 				= get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$customTax 			= $term->taxonomy;

		switch($OPTION['wps_footer_option']){
			case 'small_footer': ?> 
				<div id="floatswrap" class="smallftfl clearfix">
			<?php	       					
			break;
										
			case 'large_footer': ?> 
				<div id="floatswrap" class="bigftfl clearfix">
				<?php 
			break;
		} 
		?>
		<?php
			if ( get_option("disable_payment_processing") == "0" ) {
				include( STYLESHEETPATH . "/lib/pages/alerts.php" );
			}
		?>
			<div class="container clearfix">
				<?php include( STYLESHEETPATH . "/includes/headers/page-titles.php" ); ?>