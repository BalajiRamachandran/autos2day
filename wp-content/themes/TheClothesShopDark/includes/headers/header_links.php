<?php 
// do we want a customer area with a wishlist?	
if($OPTION['wps_lrw_yes']) {
	//if ($_SESSION[user_logged]) {
	if ( is_user_logged_in() ) { 
	
		if($OPTION['wps_useGet4logout'] == 'yes'){
			$logoutURLExtension = '?go2page='.get_real_base_url();
		}
		else {
			$logoutURLExtension = NULL;
		}
	?>

		<li class="logout"><?php wp_loginout(); ?></li>
		<li class="myAccount <?php echo $the_li_class; ?>"><a href="<?php echo get_permalink($customerArea->ID); ?>"><?php echo $OPTION['wps_customerAreaPg'];?></a></li>
		
		<?php if (is_page($customerArea->post_title)) {
			switch($_GET[action]){
				case 1:
					$the_li_class='current_page_item';
				break;

				case 2: 
					$the_li_class='current_page_item';
				break;

				case 3: 
					$the_wishlist_class='current_page_item';
				break;

				case 4:
					$the_li_class='current_page_item';
				break;

				case 5:
					$the_li_class='current_page_item';
				break;
				
				default:
					$the_li_class='current_page_item';
				break;
			}
		} 
		if($OPTION['wps_lrscLinks_option']) { ?>
			<li class="myAccount <?php echo $the_li_class; ?>"><a href="<?php echo get_permalink($customerArea->ID); ?>"><?php echo $OPTION['wps_customerAreaPg'];?></a></li>
		<?php } ?>
		<li class="wishlist <?php echo $the_wishlist_class; ?>">
			<?php include (TEMPLATEPATH . '/lib/pages/header_wishlist.php');?>
		</li>
	<?php } else {
		if (is_page($accountLog->post_title)) {$the_li_class='current_page_item';}else {$the_li_class='';} ?>
		<li class="<?php echo $the_li_class; ?>">
			<a class="quickLogin" href="<?php echo get_permalink($accountLog->ID); ?>" rel="div.overlay:eq(0)" title="<?php _e('Login to your account','wpShop');?>">
				Dealer <?php echo $accountLog->post_title;?>
			</a>
		</li>
		
	<?php } ?>
	<?php 
	if ( current_user_can( 'administrator' ) ) {
	?>
	<?php if (is_page($accountReg->post_title)) {$the_li_class='current_page_item';}else {$the_li_class='';} ?>
	<li class="<?php echo $the_li_class; ?>"><a href="<?php echo get_permalink($accountReg->ID); ?>" title="<?php _e('Create an account','wpShop');?>"><?php echo $accountReg->post_title;?></a></li>
	<?php
	}
	?>

	<?php
} else {
	if ($OPTION['wps_lrscLinks_option'] != TRUE) {
		if (($includeRight!='')) {
			wp_list_pages($pageMenuArgRight); 
		}
	}
}

// do we want a search link?
if($OPTION['wps_search_link_enable']){
	if (is_page($search->post_title)) {$the_li_class='current_page_item';}else {$the_li_class='';} ?>
	<li class="<?php echo $the_li_class; ?>"><a class="extLoadTrigger" href="<?php echo get_permalink($search->ID); ?>" rel="div.overlay:eq(1)" title="<?php _e('Find products','wpShop');?>"><?php echo $search->post_title;?></a></li>	
<?php } 

// do we want the eCommerce engine?
if($OPTION['wps_shoppingCartEngine_yes']) {
	$wps_shop_mode = $OPTION['wps_shop_mode'];
	switch($wps_shop_mode){
		case 'affiliate_mode':
			if ($OPTION['wps_lrscLinks_option'] != TRUE) {
				if (($includeRight!='')) {
					wp_list_pages($pageMenuArgRight); 
				}
			}
		break;
		case 'payloadz_mode': ?>
			<li class="bag"><?php include (TEMPLATEPATH . '/lib/pages/header_cart.php'); ?></li>
		<?php
		break;
		default: ?>
			<li class="bag"><?php include (TEMPLATEPATH . '/lib/pages/header_cart.php'); ?></li>
		<?php
		break;
	} 
} ?>	