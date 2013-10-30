<?php
$myAccount		= get_page_by_title($OPTION['wps_pgNavi_myAccountOption']);
$custServ		= get_page_by_title($OPTION['wps_customerServicePg']);
$about			= get_page_by_title($OPTION['wps_aboutPg']);
$contact		= get_page_by_title($OPTION['wps_contactPg']);
$search			= get_page_by_title($OPTION['wps_pgNavi_searchOption']);
$accountReg		= get_page_by_title($OPTION['wps_pgNavi_regOption']);
$accountLog		= get_page_by_title($OPTION['wps_pgNavi_logOption']);
$customerArea	= get_page_by_title($OPTION['wps_customerAreaPg']);

$customTax 			= $term->taxonomy;

$WPS_tagimgs		= $OPTION['wps_tagimg_file_type'];


switch($OPTION['wps_sidebar_option']){
	case 'alignRight':
		$the_float_class 	= 'alignright';
	break;
	case 'alignLeft':
		$the_float_class 	= 'alignleft';
	break;
}

//front page
if (is_home()) { 

	if ( is_sidebar_active('frontpage_3left_widget_area') || is_sidebar_active('frontpage_2left_widget_area') || is_sidebar_active('frontpage_single_widget_area')|| is_sidebar_active('frontpage_5left1_widget_area')) : ?>
	
		<ul class="secondary_content clearfix noprint">
			
			<?php
			// 5 columns
			if ( is_sidebar_active('frontpage_5left1_widget_area')): 
				if ( is_sidebar_active('frontpage_5left1_widget_area') ) : ?>
					<li class="c_box c_box5 c_box_first">
						<?php dynamic_sidebar('frontpage_5left1_widget_area'); ?>
					</li><!-- c_box  -->
				<?php endif;
				
				if ( is_sidebar_active('frontpage_5left2_widget_area') ) : ?>
					<li class="c_box c_box5">
						<?php dynamic_sidebar('frontpage_5left2_widget_area'); ?>
					</li><!-- c_box  -->
				<?php endif;
				
				if ( is_sidebar_active('frontpage_5middle_widget_area') ) : ?>
					<li class="c_box c_box5 c_box_middle">
						<?php dynamic_sidebar('frontpage_5middle_widget_area'); ?>
					</li><!-- c_box  -->
				<?php endif;
				
				if ( is_sidebar_active('frontpage_5right1_widget_area') ) : ?>
					<li class="c_box c_box5">
						<?php dynamic_sidebar('frontpage_5right1_widget_area'); ?>
					</li><!-- c_box  -->
				<?php endif;
				
				if ( is_sidebar_active('frontpage_5right2_widget_area') ) : ?>
					<li class="c_box c_box5 c_box_last">
						<?php dynamic_sidebar('frontpage_5right2_widget_area'); ?>
					</li><!-- c_box  -->
				<?php endif;
			endif;
			
			// 3 columns
			if ( is_sidebar_active('frontpage_3left_widget_area')): 
				if ( is_sidebar_active('frontpage_3left_widget_area') ) : ?>
					<li class="c_box c_box3 c_box_first">
						<?php dynamic_sidebar('frontpage_3left_widget_area'); ?>
					</li><!-- c_box  -->
				<?php endif;
				
				if ( is_sidebar_active('frontpage_3middle_widget_area') ) : ?>
					<li class="c_box c_box3 c_box_middle">
						<?php dynamic_sidebar('frontpage_3middle_widget_area'); ?>
					</li><!-- c_box  -->
				<?php endif;
				
				if ( is_sidebar_active('frontpage_3right_widget_area') ) : ?>
					<li class="c_box c_box3 c_box_last">
						<?php dynamic_sidebar('frontpage_3right_widget_area'); ?>
					</li><!-- c_box  -->
				<?php endif;
			endif;
			
			// 1 column
			if (is_sidebar_active('frontpage_single_widget_area')) :  ?>	
				<li>
					<?php dynamic_sidebar('frontpage_single_widget_area'); ?>
				</li><!-- c_box  -->
			<?php endif;
			
			// 2 columns
			if ( is_sidebar_active('frontpage_2left_widget_area')): 
				if ( is_sidebar_active('frontpage_2left_widget_area') ) : ?>
					<li class="c_box c_box2 c_box_first">
						<?php dynamic_sidebar('frontpage_2left_widget_area'); ?>
					</li><!-- c_box  -->
				<?php endif;
				
				if ( is_sidebar_active('frontpage_2right_widget_area') ) : ?>
					<li class="c_box c_box2 c_box_last">
						<?php dynamic_sidebar('frontpage_2right_widget_area'); ?>
					</li><!-- c_box  -->
				<?php endif;
			endif; ?>	
		</ul><!-- secondary_content -->
		
	<?php endif;
} 

//when in a shop category - when using a blog please see includes/widget_ready_areas/blog-category.php
elseif (is_category()) {
	$topParent 			= NWS_get_root_category($cat,'allData');
	$topParentSlug 		= $topParent->slug;
	$blog_Name 	= $OPTION['wps_blogCat'];
	// are we using a Blog?
	if ($blog_Name != 'Select a Category') {
	
		$blog_ID 	= get_cat_ID( $blog_Name );
		// we are here now
		$categ_object = get_category( get_query_var( 'cat' ), false );
		// who's our ancestor, blog or shop? First check for root category.
		if( (int)$categ_object->category_parent > 0 ) {
			if(cat_is_ancestor_of( $blog_ID, (int)$categ_object->cat_ID )) {include(TEMPLATEPATH . "/includes/widget_ready_areas/blog-category.php" );}
			else {include( TEMPLATEPATH . "/includes/widget_ready_areas/shop-category.php" );}
		} else {
		
			if((int)$categ_object->cat_ID == $blog_ID) {include (TEMPLATEPATH . "/includes/widget_ready_areas/blog-category.php" );}
			else {include( TEMPLATEPATH . "/includes/widget_ready_areas/shop-category.php" );}
		}
	
	} else {

		// do we have 2nd level categories?
		if (!empty($current_mainCats) && ($this_categorySlug == $topParentSlug)) { 
			//what column option?
			switch($WPS_catCol){
				case 'catCol3':
					$the_div_class = '';     
				break;
				case 'catCol3_ns':
					$the_div_class 	= 'sidebar category_sidebar sidebar_narrow noprint '. $the_float_class;
					$counter = 3; 
				break;
											
				case 'catCol3_ws':
					$the_div_class 	= 'sidebar category_sidebar noprint '. $the_float_class;
					$counter = 3;      
				break;
					
				case 'catCol2_ws':
					$the_div_class 	= 'sidebar category_sidebar noprint '. $the_float_class;
					$counter = 2;      
				break;
			}
			
		} else {
			
			//what column option?
			switch($WPS_prodCol){
				case 'prodCol1_ws':
					$the_div_class = 'sidebar category_sidebar noprint '. $the_float_class;     
				break;
				
				case 'prodCol2_ns':
					$the_div_class = 'sidebar category_sidebar sidebar_narrow noprint '. $the_float_class;  
				break;
											
				case 'prodCol2_ws':
					$the_div_class = 'sidebar category_sidebar noprint '. $the_float_class;     
				break;
				
				case 'prodCol3_ns':
					$the_div_class = 'sidebar category_sidebar sidebar_narrow noprint '. $the_float_class;  
				break;
											
				case 'prodCol3_ws':
					$the_div_class = 'sidebar category_sidebar noprint '. $the_float_class;     
				break;
					
				case 'prodCol4_ns':
					$the_div_class = 'sidebar category_sidebar sidebar_narrow noprint '. $the_float_class;       
				break;
				
				case 'prodCol4_ws':
					$the_div_class = 'sidebar category_sidebar noprint '. $the_float_class;       
				break;
					
				case 'prodCol5':
					$the_div_class = '';      
				break;
			}
		} ?>
		<div class="<?php echo $the_div_class;?>">
			<div class="padding">
				<?php 
				if (!empty($current_mainCats) && ($this_categorySlug != $topParentSlug)) { ?>
					<div class="widget widget_categories">
						<div class="widgetPadding">
							<h3 class="widget-title"><?php _e('Categories in this Section','wpShop'); ?></h3>
							<ul>
								<?php wp_list_categories('title_li=&orderby=ID&child_of='.$topParent->term_id.'&depth=1&hide_empty=0');?>
							</ul>
						</div>
					</div>
				<?php } 
				
				// do we want category specific sidebars?
				if(($OPTION['wps_mainCat1']!='') || ($OPTION['wps_mainCat2']!='') || ($OPTION['wps_mainCat3']!='') || ($OPTION['wps_mainCat4']!='') || ($OPTION['wps_mainCat5']!='')) {
				
					if(is_category($OPTION['wps_mainCat1']) || ($topParent->slug == $OPTION['wps_mainCat1'])) {
						if( is_sidebar_active($OPTION['wps_mainCat1'].'_category_widget_area') ) : dynamic_sidebar($OPTION['wps_mainCat1'].'_category_widget_area'); endif;
					}
					if(is_category($OPTION['wps_mainCat2']) || ($topParent->slug == $OPTION['wps_mainCat2'])) {
						if( is_sidebar_active($OPTION['wps_mainCat2'].'_category_widget_area') ) : dynamic_sidebar($OPTION['wps_mainCat2'].'_category_widget_area'); endif;
					}
					if(is_category($OPTION['wps_mainCat3']) || ($topParent->slug == $OPTION['wps_mainCat3'])) {
						if( is_sidebar_active($OPTION['wps_mainCat3'].'_category_widget_area') ) : dynamic_sidebar($OPTION['wps_mainCat3'].'_category_widget_area'); endif;
					}
					if(is_category($OPTION['wps_mainCat4']) || ($topParent->slug == $OPTION['wps_mainCat4'])) {
						if( is_sidebar_active($OPTION['wps_mainCat4'].'_category_widget_area') ) : dynamic_sidebar($OPTION['wps_mainCat4'].'_category_widget_area'); endif;
					}
					if(is_category($OPTION['wps_mainCat5']) || ($topParent->slug == $OPTION['wps_mainCat5'])) {
						if( is_sidebar_active($OPTION['wps_mainCat5'].'_category_widget_area') ) : dynamic_sidebar($OPTION['wps_mainCat5'].'_category_widget_area'); endif;
					}
					
				//no? the one for all	
				} else {
					if (is_sidebar_active('category_widget_area') ) : dynamic_sidebar('category_widget_area'); endif;
				}
			} ?>
		</div><!-- padding -->
	</div><!-- category_sidebar -->
	
<?php }
// sidebar for Post Tag Pages
elseif (is_tag()) { 
	$the_div_class 	= 'sidebar tag_sidebar noprint '. $the_float_class; ?>
	
	<div class="<?php echo $the_div_class;?>">
		<div class="padding">
		
			<?php if($OPTION['wps_blogTags_option'] != TRUE) { ?>
				<div class="tagImg">
					<div class="widgetPadding">
						<img src="<?php echo get_option('siteurl');?>/<?php echo $OPTION['upload_path'];?>/<?php echo $terms[0]->slug; ?>.<?php echo $WPS_tagimgs; ?>" alt="<?php echo $terms[0]->name; ?>" />
					</div>
				</div>
			
			<?php } 
			
			if($OPTION['wps_blogTags_option']) {
				if ( is_sidebar_active('blog_category_widget_area') ) : dynamic_sidebar('blog_category_widget_area'); endif;
			} else { 
				if ( is_sidebar_active('tag_widget_area') ) : dynamic_sidebar('tag_widget_area'); endif;
			} ?>
			
		</div><!-- padding -->
	</div><!-- tag_sidebar -->
	
<?php } 
// sidebar for Custom Taxonomy Pages
elseif (taxonomy_exists($customTax)) { 
	$the_div_class 	= 'sidebar fit_sidebar noprint '. $the_float_class; ?>
	
	<div class="<?php echo $the_div_class;?>">
		<div class="padding">
			
			<div class="tagImg">
				<div class="widgetPadding">
					<img src="<?php echo get_option('siteurl');?>/<?php echo $OPTION['upload_path'];?>/<?php echo $term->slug;?>.<?php echo $WPS_tagimgs; ?>" alt="<?php echo $term->name;?>" />
				</div>
			</div>
			
			<?php if ( is_sidebar_active('tag_widget_area') ) : dynamic_sidebar('tag_widget_area'); endif; ?>
			
		</div><!-- padding -->
	</div><!-- tag_sidebar -->
	
<?php	
// sidebar for pages 	
} elseif (is_page()){

	//get current page
	#$post_obj = $wp_query->get_queried_object();
	$depth = count($post->ancestors) + 1;
	
	// display subpages if any
	if($post->post_parent) {
		//for 2nd level pages
		if ($depth == 2) {
			$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0&depth=".$depth);
		//for 3rd level pages
		} else {
			$children = wp_list_pages("title_li=&child_of=".$post->ancestors[1]."&echo=0&depth=".$depth);
		}		
	} else {
		if ($OPTION['wps_customerServicePg']!='Select a Page' && is_page($custServ->post_title)) {
			if ($post->post_parent==0) {
				$children = '';
			} else {
				$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
			}
		} else {
			$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&depth=".$depth);
		}
	}
	
	if ((($OPTION['wps_customerAreaPg']!='Select a Page') && (is_page($customerArea->post_title))) || (($OPTION['wps_customerAreaPg']!='Select a Page') && (is_tree($customerArea->ID)))) { ?>
		<div class="sidebar page_sidebar protected_sidebar noprint <?php echo $the_float_class;?>">
			<div class="padding">
				<?php					
				switch($_GET[action]){
					case 1:
						$the_ul_class = 'edit_login_info_list';
					break;

					case 2: 
						$the_ul_class = 'my_information_list';
					break;

					case 3: 
						$the_ul_class = 'my_wishlist_list';
					break;

					case 4:
						$the_ul_class = '';
					break;

					case 5:
						$the_ul_class = '';
					break;
					
					default:
						$the_ul_class = 'account_dashboard_list';
					break;
				} ?>
			
				<div class="widget widget_subpages">
					<div class="widgetPadding">
						<h3 class="widget-title"><?php _e('Account Options &amp; Services','wpShop');?></h3>
						<ul class="<?php echo $the_ul_class;?>">
							<li class="edit_login_info"><a href='?myaccount=1&action=1'><?php _e('Change Password','wpShop');?></a></li>
							<li class="edit_login_info"><a href="<?php echo $customerArea->guid;?>"><?php _e('Post Deal','wpShop');?></a></li>
							<li class="my_wishlist1"><a href='<?php echo get_permalink(get_page_by_title( "My Account" )->ID);?>?myaccount=1&action=2'><?php _e('Submit Vouchers','wpShop');?></a></li>
							<li class="my_wishlist2"><a href='<?php echo get_permalink(get_page_by_title( "My Account" )->ID);?>?myaccount=1&action=3'><?php _e('My Deals','wpShop');?></a></li>
							<li class="my_wishlist3"><a href='<?php echo get_permalink(get_page_by_title( "My Account" )->ID);?>?myaccount=1&action=4'><?php _e('Update Payment Profiles','wpShop');?></a></li>
							<li class="my_wishlist4"><a href='<?php echo get_permalink(get_page_by_title( "Dealer FAQ" )->ID);?>'><?php _e('Dealer FAQ','wpShop');?></a></li>
							<li class="my_wishlist4"><a href='<?php echo get_permalink(get_page_by_title( "Terms of Use" )->ID);?>'><?php _e('Terms Of Use','wpShop');?></a></li>
							<?php if ( current_user_can( 'administrator' ) ) { ?>
							<li class="my_wishlist2"><a href='<?php echo get_permalink(get_page_by_title( "My Account" )->ID);?>?myaccount=1&action=9'><?php _e('Convert BMP files','wpShop');?></a></li>
							<li class="my_wishlist2"><a href='<?php echo get_permalink(get_page_by_title( "My Account" )->ID);?>?myaccount=1&action=5'><?php _e('Update Dealer Emails','wpShop');?></a></li>
							<?php } ?>
							<?php if ( current_user_can( 'administrator' ) ) {
								wp_register();
							} 
							?>
						</ul>
					</div><!-- widgetPadding -->
				</div><!-- widget -->
				
				<?php if ($children) { ?>
								
				<?php } 
				
				dynamic_sidebar('customer_area_widget_area');?>
				
			</div><!-- padding -->
		</div><!-- page_sidebar -->	
	
	
	<?php } else {
		if ( is_sidebar_active('about_page_widget_area') || is_sidebar_active('contact_page_widget_area') || is_sidebar_active('search_widget_area') || is_sidebar_active('sub_customer_service_widget_area') || is_sidebar_active('page_widget_area') ||($children)){ ?>
			<div class="sidebar page_sidebar noprint <?php echo $the_float_class;?>">
				<div class="padding">
					<?php if ($children) { ?>
					
						<div class="widget tcsWidget_subpages">
							<div class="widgetPadding">
								<h3 class="widget-title"><?php _e('In this section:','wpShop');?></h3>
								<ul><?php echo  $children; ?></ul>
							</div><!-- widgetPadding -->
						</div><!-- widget -->
					
					<?php }
					//about
					if ($OPTION['wps_aboutPg']!='Select a Page' && (is_page($about->post_title)|| is_tree($about->ID))) { if ( is_sidebar_active('about_page_widget_area') ) : dynamic_sidebar('about_page_widget_area'); endif; } 
					//contact
					elseif ($OPTION['wps_contactPg']!='Select a Page' && (is_page($contact->post_title)|| is_tree($contact->ID))) { if ( is_sidebar_active('contact_page_widget_area') ) : dynamic_sidebar('contact_page_widget_area'); endif;}
					//search
					elseif ($OPTION['wps_pgNavi_searchOption']!='Select a Page' && (is_page($search->post_title)|| is_tree($search->ID))) { if ( is_sidebar_active('search_widget_area') ) : dynamic_sidebar('search_widget_area'); endif;}
					
					//customer service subpages
					elseif ($OPTION['wps_customerServicePg']!='Select a Page' && is_tree($custServ->ID)) {  if ( is_sidebar_active('sub_customer_service_widget_area') ) : dynamic_sidebar('sub_customer_service_widget_area'); endif;}
					
					//all other pages
					else { if ( is_sidebar_active('page_widget_area') ) : dynamic_sidebar('page_widget_area'); endif;} 
					?>
					
				</div><!-- padding -->
			</div><!-- page_sidebar -->	

		<?php }
	}
// for the search|| 404	
} elseif (is_search() || is_404()) {
	if (is_sidebar_active('page404_widget_area') || is_sidebar_active('search_widget_area')){ ?>
	
		<div class="sidebar noprint <?php echo $the_float_class;?>">
			<div class="padding">
			
				<?php 
				if (is_search()) { dynamic_sidebar('search_widget_area'); }
				elseif (is_404()) { dynamic_sidebar('page404_widget_area'); }
				?>
				
			</div><!-- padding -->
		</div><!-- sidebar -->
<?php }
} else {} ?>