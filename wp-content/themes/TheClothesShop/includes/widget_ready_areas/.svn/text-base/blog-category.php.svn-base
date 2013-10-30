<?php
switch($WPS_sidebar){
	case 'alignRight':
		$the_float_class 	= 'alignright';
	break;
	case 'alignLeft':
		$the_float_class 	= 'alignleft';
	break;
}

$the_div_class 	= 'sidebar blog_sidebar noprint '. $the_float_class; ?>

<div class="<?php echo $the_div_class;?>">
	<div class="padding">
		<?php 
		$blog_ID 		= get_cat_ID($OPTION['wps_blogCat']);
		$subcategories 	= wp_list_categories('title_li=&orderby=ID&child_of='.$blog_ID.'&echo=0');
		
		if ($subcategories != '<li>'.__('No categories','wpShop').'</li>') { ?>
		
			<div class="widget widget_categories">
				<div class="widgetPadding">
					<h3 class="widget-title"><?php _e('Categories in this Section','wpShop'); ?></h3>
					<ul>
						<?php echo $subcategories; ?>
					</ul>
				</div>
			</div>
		
		<?php } 
		
		if (is_sidebar_active('blog_category_widget_area') ) : dynamic_sidebar('blog_category_widget_area'); endif;	?>

	</div><!-- padding -->
</div><!-- category_sidebar -->