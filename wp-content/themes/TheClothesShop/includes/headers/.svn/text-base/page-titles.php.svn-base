<?php
// Page Titles. Brace yourself! (modify at your own risk)
if ((is_front_page() != true) && is_page()) { ?>
	<h1 class="page-title whereAmI">
		<?php 
		//	for the customer membership area if one is created
		if (($OPTION['wps_customerAreaPg']!='Select a Page') && (is_page($customerArea->post_title))) {
			switch($_GET[action]){
				case 1: ?>
					<a href="<?php echo get_permalink($customerArea->ID); ?>"><?php echo $OPTION['wps_customerAreaPg'];?></a><?php echo ' &raquo '; _e('Change Password', 'wpShop');
				break;

				case 2: ?>
					<a href="<?php echo get_permalink( $customerArea->ID); ?>"><?php echo $OPTION['wps_customerAreaPg'];?></a><?php echo ' &raquo '; _e('Submit Vouchers', 'wpShop');
				break;

				case 3: ?>
					<a href="<?php echo get_permalink( $customerArea->ID); ?>"><?php echo $OPTION['wps_customerAreaPg'];?></a><?php echo ' &raquo '; echo $OPTION['wps_wishListLink_option'];
				break;

				case 4: ?>
					<a href="<?php echo get_permalink( $customerArea->ID); ?>"><?php echo $OPTION['wps_customerAreaPg'];?></a><?php echo ' &raquo '; _e('', 'wpShop');
				break;

				case 5: ?>
					<a href="<?php echo get_permalink( $customerArea->ID); ?>"><?php echo $OPTION['wps_customerAreaPg'];?></a><?php echo ' &raquo '; _e('', 'wpShop');
				break;
				
				default:
					echo $OPTION['wps_customerAreaPg'];
				break;
			}
		
		//	for the customer membership area subpages if some exist	
		} elseif (($OPTION['wps_customerAreaPg']!='Select a Page') && (is_tree($customerArea->ID))) { ?> 
			<a href="<?php echo get_permalink( $customerArea->ID); ?>"><?php echo $OPTION['wps_customerAreaPg'];?></a> &raquo; <?php echo $currentPage_title; 
		
		// otherwise
		} else {
			if ($parentPage_title == $currentPage_title) { echo $currentPage_title;} else { ?> <a href="<?php echo get_permalink($post->post_parent); ?>" title="<?php echo $parentPage_title; ?>"><?php echo $parentPage_title;?></a> &raquo; <?php echo $currentPage_title; }
		} ?>
	</h1>
	
<?php } elseif (is_category()) { 
	
	if ((cat_is_ancestor_of( $blog_ID, $this_category->cat_ID )) || ($this_category->cat_ID == $blog_ID)){$the_h2_class='blog-cat-title';}
	elseif (!cat_is_ancestor_of( $blog_ID, $this_category->cat_ID )&&($this_category->category_parent != 0)) {$the_h2_class='cat-title-alt';}?>
	
	<h1 class="cat-title whereAmI <?php echo $the_h2_class;?>">
		<?php
		// when on 1st level category
		if(($this_categorySlug == $topParentSlug) || ($this_category->category_parent == 0)){
			echo $topParent->name;
		} 
		// when on 2nd level category
		elseif(($this_categorySlug != $topParentSlug) && ($this_category->category_parent == $topParent->term_id)){ ?>			
			<a href="<?php echo get_category_link($topParent->term_id);?>"><?php echo $topParent->name;?></a> &raquo; <?php echo $this_category->name;?>
		<?php } 
		// when one 3rd level category
		elseif (($this_categorySlug != $topParentSlug) && ($this_category->category_parent != $topParent->term_id)) { ?>
			<a href="<?php echo get_category_link($topParent->term_id);?>"><?php echo $topParent->name;?></a> &raquo; <a href="<?php echo get_category_link($this_category->parent);?>"><?php echo get_cat_name($this_category->parent); ?></a>  &raquo; <?php echo $this_category->name;?>
		<?php } else {}?>
	</h1>

<?php } elseif (is_single()) { ?>
	
	<h1 class="single-title whereAmI">
		<?php
		$category 	= get_the_category($post->ID);
		
		
		// if prods are in 1st level categories
		if ($category[0]->category_parent == 0) { ?>
			<a href="<?php echo get_category_link($category[0]->term_id);?>"><?php echo $category[0]->name;?></a>
		<?php } 
		// if prods are in 3rd level categories
		elseif(($topParent_cat !=0) && ($category[0]->category_parent != 0)) {?>
			<a href="<?php echo get_category_link($topParent_cat);?>"><?php echo get_cat_name($topParent_cat); ?></a> &raquo; <?php echo get_cat_name($category[0]->category_parent); ?>
		<?php } 
		// if prods are in 2nd level categories
		else { ?>
			<a href="<?php echo get_category_link($category[0]->category_parent);?>"><?php echo get_cat_name($category[0]->category_parent); ?></a> &raquo; <?php echo $category[0]->name;?>
		<?php } ?>
	</h1>
	
<?php } elseif (is_tag()) { ?>
	<h1 class="tag-title whereAmI">
		<?php single_tag_title();?>
	</h1>
	
<?php } elseif (taxonomy_exists($customTax)){ ?>
	<h1 class="tag-title whereAmI">
		<?php _e('Shop by ','wpShop'); echo $customTax;?>: <?php echo $term->name; ?>
	</h1>
	
<?php } elseif (is_archive()) { 
	the_post();                    
				
	if ( is_day() ) { ?>
		<h1 class="archive-title daily-title whereAmI"><?php printf( __( 'Daily Archives: <span>%s</span>', 'wpShop' ), get_the_time($OPTION['date_format']) ) ?></h1>
	<?php } elseif ( is_month() ) { ?>
		<h1 class="archive-title monthly-title whereAmI"><?php printf( __( 'Monthly Archives: <span>%s</span>', 'wpShop' ), get_the_time('F Y') ) ?></h1>
	<?php } elseif ( is_year() ) { ?>
		<h1 class="archive-title yearly-title whereAmI"><?php printf( __( 'Yearly Archives: <span>%s</span>', 'wpShop' ), get_the_time('Y') ) ?></h1>
	<?php }	elseif (is_author()) { ?>
		<h1 class="archive-title author-title whereAmI"><?php printf( __( 'Author Archives: <span>%s</span>', 'wpShop' ), "$authordata->display_name" ) ?></h1>
	<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h1 class="archive-title whereAmI"><?php _e( 'Blog Archives', 'wpShop' ) ?></h1>
	<?php }
	rewind_posts();

} elseif (is_search()) { ?>
	<h1 class="search-title whereAmI">
		<?php _e('Search Results for: ','wpShop'); ?><?php the_search_query(); ?>
	</h1>
	
<?php } elseif (is_404()) { ?>
	<h1 class="notFound-title whereAmI">
		<?php _e('We are Sorry!','wpShop'); ?>
	</h1>

<?php } elseif (($_GET['showCart'] == '1') || ($_GET['orderNow'] == '1') || ($_GET['orderNow'] == '2') || ($_GET['orderNow'] == '3') || ($_GET['orderNow'] == '4') || ($_GET['orderNow'] == '5') || ($_GET['orderNow'] == '6') || ($_GET['orderNow'] == '7')  || ($_GET['orderNow'] == '8') || ($_GET['orderNow'] == '81') || ($_GET['confirm'] == '1') || ($_GET['confirm'] == '2') || ($_GET['confirm'] == '3') || ($_GET['showTerms'] == '1') || ($_GET['showMap'] == 1) || ($_GET['checkOrderStatus'] == 1)) {
	include( TEMPLATEPATH . "/lib/pages/page_titles.php" );
} else {} // end "Page Titles" section

// Sub Navigation for product categories and on single view for orientation. Again, brace yourself! (modify at your own risk)
if (((is_category()) && ($this_category->category_parent != 0)) || (is_single())) {

	// are we using a Blog?
	if ($blog_Name != 'Select a Category') {
		if (is_category()) {
			// we are here now
			$categ_object = $this_category;
			// who's our ancestor, blog or shop? First check for root category.
			if((int)$categ_object->category_parent > 0 ) {
				if(cat_is_ancestor_of( $blog_ID, (int)$categ_object->cat_ID )) {}
				else {include( TEMPLATEPATH . "/includes/headers/sub-cat-navi.php" );}
			} else {
				if((int)$categ_object->cat_ID == $blog_ID) {}
				else {include( TEMPLATEPATH . "/includes/headers/sub-cat-navi.php" );}
			}
		} elseif (is_single()) {
			$categ_object = $category;
			// who's our ancestor, blog or shop?
			if ((cat_is_ancestor_of( $blog_ID, (int)$categ_object[0]->term_id ))|| ($categ_object[0]->term_id ==$blog_ID)) {} else {include( TEMPLATEPATH . "/includes/headers/sub-cat-navi.php" );}
		}
	} else {include( TEMPLATEPATH . "/includes/headers/sub-cat-navi.php" );}
} //end "Sub Navigation" section ?>