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
		$myCat			= $categ_object[0]->term_id;
		$subcategories 	= wp_list_categories('title_li=&orderby=ID&child_of='.$blog_ID.'&echo=0&current_category='.$myCat);
		
		//if ($subcategories != '<li>No categories</li>') {
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
		
		//display category related posts?
		if($OPTION['wps_blogCatRelated_posts_enable']) {
			$showposts 			= $OPTION['wps_blogCatRelated_num'];
			$cat_related_output = NWS_blogCat_related_posts($showposts);
			
			if($cat_related_output[status]){ ?>
				<div class="widget widget_related">
					<div class="widgetPadding">
						<h3 class="widget-title"><?php echo $OPTION['wps_blogCatRelated_title'];?></h3>
						<ul class="related">
							<?php echo $cat_related_output[html]; ?>
						</ul>
					</div>
				</div>
			<?php  }
		}
		
		//display tag  related posts?
		if($OPTION['wps_blogTagRelated_posts_enable']) {
			$showposts 			= $OPTION['wps_blogTagRelated_num'];
			$tag_related_output = NWS_blogTag_related_posts($showposts);
			
			if($ctag_related_output[status]){ ?>
				<div class="widget widget_related">
					<div class="widgetPadding">
						<h3 class="widget-title"><?php echo $OPTION['wps_blogTagRelated_title'];?></h3>
						<ul class="related">
							<?php echo $tag_related_output[html]; ?>
						</ul>
					</div>
				</div>
			<?php  }
		}
		
		if (is_sidebar_active('single_blog_widget_area') ) : dynamic_sidebar('single_blog_widget_area'); endif;	?>

	</div><!-- padding -->
</div><!-- category_sidebar -->