<?php 
/*

Template Name: No Sidebar

*/

get_header();
$DEFAULT = show_default_view();

 include (TEMPLATEPATH . '/lib/pages/index_body.php'); 

 ?>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri() . '/css/jquery-ui-1.8.21.custom.css';?>" />
<script src="<?php echo get_stylesheet_directory_uri() . '/js/jquery-ui-1.8.2.custom.min.js';?>" type="text/javascript"></script>
 <script type="text/javascript">
 	jQuery(document).ready(function(){
 		jQuery( "#faq" ).accordion();
 	});
 </script>

 <?php

 if($DEFAULT){
	if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div <?php post_class('page_post wide'); ?> id="post-<?php the_ID(); ?>">
			<?php the_content('<p class="serif">'. __( 'Read the rest of this page &raquo;', 'wpShop' ) . '</p>'); 
			wp_link_pages(array('before' => '<p><strong>' . __( 'Pages:', 'wpShop' ) . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</div><!-- page_post -->
	<?php endwhile; endif;

} 
get_footer(); ?>