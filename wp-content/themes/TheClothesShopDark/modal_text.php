<?php 
/*

Template Name: Content Only

*/

// get_header();
$DEFAULT = show_default_view();

 // include (TEMPLATEPATH . '/lib/pages/index_body.php'); 

 ?>
 <?php

 if($DEFAULT){
	if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div <?php post_class('page_post wide'); ?> id="post-<?php the_ID(); ?>">
			<?php 
			echo get_the_content();
			// wp_link_pages(array('before' => '<p><strong>' . __( 'Pages:', 'wpShop' ) . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</div><!-- page_post -->
	<?php endwhile; endif;

} 
// get_footer(); 
?>