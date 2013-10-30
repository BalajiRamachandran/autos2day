<?php
$topParent 			= NWS_get_root_category($cat,'allData');
$topParentSlug 		= $topParent->slug;

switch($WPS_sidebar){
	case 'alignRight':
		$the_float_class 	= 'alignright';
	break;
	case 'alignLeft':
		$the_float_class 	= 'alignleft';
	break;
}

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
						<?php 	wp_list_categories('title_li=&orderby=ID&child_of='.$topParent->term_id.'&depth=1&hide_empty=0');?>
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
			// if (is_sidebar_active('category_widget_area') ) : dynamic_sidebar('category_widget_area'); endif;
		}?>
	</div><!-- padding -->
</div><!-- category_sidebar -->