<?php get_header();

// are we using a Blog?
$blog_Name 	= $OPTION['wps_blogCat'];

if ($blog_Name != 'Select a Category') {
	// template switch between Blog and Shop
	$blog_ID 	= get_cat_ID( $blog_Name );
	// we are here now
	$categ_object = get_category( get_query_var( 'cat' ), false );
	// who's our ancestor, blog or shop? First check for root category.
	if( (int)$categ_object->category_parent > 0 ) {
		if(cat_is_ancestor_of( $blog_ID, (int)$categ_object->cat_ID )) {include(TEMPLATEPATH . "/includes/category/category-blog.php" );}
		else {include( TEMPLATEPATH . "/includes/category/category-shop.php" );}
	} else {
		if((int)$categ_object->cat_ID == $blog_ID) {include (TEMPLATEPATH . "/includes/category/category-blog.php" );}
		else {include( TEMPLATEPATH . "/includes/category/category-shop.php" );}
	}
} else {
	include( TEMPLATEPATH . "/includes/category/category-shop.php" );
} ?>