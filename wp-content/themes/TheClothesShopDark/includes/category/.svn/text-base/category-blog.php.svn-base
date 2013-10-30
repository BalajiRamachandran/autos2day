<?php get_header();

$blog_ID 		= get_cat_ID($OPTION['wps_blogCat']);
$subcategories 	= wp_list_categories('title_li=&orderby=ID&child_of='.$blog_ID.'&echo=0');

if (is_sidebar_active('blog_category_widget_area')) {

	$WPS_sidebar		= $OPTION['wps_sidebar_option'];
	switch($WPS_sidebar){
		case 'alignRight':
			$the_float_class 	= 'narrow alignleft';
		break;
		case 'alignLeft':
			$the_float_class 	= 'narrow alignright';
		break;
	}
	
} else {
	$the_float_class 	= 'wide';
} 
?>

	<div class="<?php echo $the_float_class;?>">
		<?php
		while (have_posts()) : the_post();
			include (STYLESHEETPATH . '/includes/category/blog-posts.php');
		endwhile; 
		
		include (TEMPLATEPATH . '/wp-pagenavi.php'); 
		if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
		?> 
	</div>
		
	<?php 
	if (is_sidebar_active('blog_category_widget_area')) {
		include (STYLESHEETPATH . '/includes/widget_ready_areas/blog-category.php'); 	 
	}
get_footer();?>