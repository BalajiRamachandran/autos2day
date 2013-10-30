<?php if (is_single() && $OPTION['wps_linksTop_enable']) {$the_div_class="SubCatNav single_SubCatNav";} else {$the_div_class="SubCatNav";}?>
<div class="<?php echo $the_div_class; ?>">
	<ul class="viewAll">
		<?php
		if (is_category()) {
			if ($this_category->category_parent == $topParent->term_id){ 
				if ($catDepth==1) { ?>
					<li><a href="<?php echo get_category_link($this_category->parent);?>"><?php _e('View All','wpShop');?></a></li>
				<?php } else { ?>
					<li class="active"><a href="<?php echo get_category_link($this_category->term_id);?>"><?php _e('View All','wpShop');?></a></li>
				<?php }
			} else { ?>
				<li><a href="<?php echo get_category_link($this_category->parent);?>"><?php _e('View All','wpShop');?></a></li>
			<?php }
			
		} elseif (is_single()) {
			if ($category[0]->category_parent != 0){ 
				if ($catDepth==1) { ?>
					<li><a href="<?php echo get_category_link($category[0]->term_id);?>"><?php _e('View All','wpShop');?></a></li>
				<?php } else { ?>
					<li><a href="<?php echo get_category_link($category[0]->category_parent);?>"><?php _e('View All','wpShop');?></a></li>
				<?php }
			} else { ?>
				<li><a href="<?php echo get_category_link($category[0]->term_id);?>"><?php _e('View All','wpShop');?></a></li>
			<?php }
		
		} else {} ?>
	</ul>

	<?php
	$orderby 	= $OPTION['wps_catSubNav_orderbyOption'];
	$order 		= $OPTION['wps_catSubNav_orderOption'];
	
	if (is_category()) {
		if($this_category->category_parent == $topParent->term_id){
			
			$cats = explode("<br />",substr(trim(wp_list_categories('title_li=&echo=0&orderby='.$orderby.'&order='.$order.'&child_of='.$this_category->term_id.'&hide_empty=0&style=none')),0,-6));
			
			if (trim($cats[0]) == 'No cate') {
				$cats = explode("<br />",substr(trim(wp_list_categories('title_li=&echo=0&orderby='.$orderby.'&order='.$order.'&child_of='.$this_category->parent.'&hide_empty=0&depth=1&style=none')),0,-6));
			}
		} else {
			$cats = explode("<br />",substr(trim(wp_list_categories('title_li=&echo=0&orderby='.$orderby.'&order='.$order.'&child_of='.$this_category->parent.'&hide_empty=0&style=none')),0,-6));
		}	
	} elseif (is_single()) {
	
		if ($category[0]->category_parent != 0){
			if ($catDepth==1) {
				$cats = explode("<br />",substr(trim(wp_list_categories('title_li=&echo=0&orderby='.$orderby.'&order='.$order.'&child_of='.$category[0]->term_id.'&hide_empty=0&style=none')),0,-6));
				if (trim($cats[0]) == 'No cate') {
					$cats = explode("<br />",substr(trim(wp_list_categories('title_li=&echo=0&orderby='.$orderby.'&order='.$order.'&child_of='.$category[0]->category_parent.'&hide_empty=0&depth=1&style=none')),0,-6));
				}
			} else { 
				$cats = explode("<br />",substr(trim(wp_list_categories('title_li=&echo=0&orderby='.$orderby.'&order='.$order.'&child_of='.$category[0]->category_parent.'&hide_empty=0&style=none')),0,-6));
			}
		} else {
			$cats = explode("<br />",substr(trim(wp_list_categories('title_li=&echo=0&orderby='.$orderby.'&order='.$order.'&child_of='.$category[0]->term_id.'&hide_empty=0&style=none')),0,-6));
		}
	} else {}
	
	//only run the foreach if categories were found
	if (trim($cats[0]) != 'No cate') {  
		//how many rows?
		$wanted_rows	= $OPTION['wps_catSubNav_rows'];
		$num			= count($cats);
		$counter		= 1;			
		$container 		= '<ul>';
		
		foreach($cats as $cat){
			//set an active class on the current category				
			$parts1 = explode("</a>",$cat);						
			$parts2 = explode(">",$parts1[0]);
			$catnam	= trim($parts2[1]);	
			if (is_category()) {
				$the_li_class = ($this_category->name == $catnam ? 'active' : NULL);
			} elseif (is_single()) {
				$the_li_class = ($category[0]->name == $catnam ? 'active' : NULL);
			} else {}
			
				if($counter % $wanted_rows == 0){
					$container .= "<li class='$the_li_class'>".$cat .'</li></ul><ul>';					
				} else {
					$container .= "<li class='$the_li_class'>".$cat.'</li>';
				}
			
			$counter++;
		}
		
		$ending = substr($container,-4);
		if($ending == '<ul>'){
			$container = substr($container,0,-4);
		}
		
		echo $container;
	} ?>
</div>