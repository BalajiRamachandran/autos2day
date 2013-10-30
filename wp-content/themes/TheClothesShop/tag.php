<?php get_header();
if($OPTION['wps_blogTags_option']) {
	include(STYLESHEETPATH . "/includes/tags/tag-blog.php" );
} else {
	include(STYLESHEETPATH . "/includes/tags/tag-shop.php" );
}
?>