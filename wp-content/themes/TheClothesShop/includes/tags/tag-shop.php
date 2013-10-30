<?php
$WPS_tagCol			= $OPTION['wps_tagCol_option'];
$WPS_sidebar		= $OPTION['wps_sidebar_option'];
$term_id 			= get_query_var('tag_id');
$taxonomy 			= 'post_tag';
$args 				='include=' . $term_id;
$terms 				= get_terms( $taxonomy, $args );


	switch($WPS_sidebar){
		case 'alignRight':
			$the_float_class 	= 'alignleft';
		break;
		case 'alignLeft':
			$the_float_class 	= 'alignright';
		break;
	}

	if($OPTION['wps_teaser_enable_option']) {$the_eqcol_class = 'eqcol'; }
	//which column option?
	switch($WPS_tagCol){
		case 'tagCol3_ws':
			$the_div_class 	= 'theTags clearfix tagCol3_ws '.$the_float_class.' '.$the_eqcol_class;
			$counter = 3;      
		break;
			
		case 'tagCol4_ws':
			$the_div_class 	= 'theTags clearfix tagCol4_ws '.$the_float_class.' '.$the_eqcol_class;
			$counter = 4;      
		break;
	}
	
	if($OPTION['wps_termDescr_enable']) {
		echo term_description();
	} ?>
	
	<div class="<?php echo $the_div_class;?>">
		<?php //set the counter according to the column selection from the theme options
		$a = 1;
		// allow user to order their Products as the want to
		$orderBy 	= $OPTION['wps_prods_orderbyOption'];
		$order 		= $OPTION['wps_prods_orderOption'];
		
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'tag' 				=>$terms[0]->slug,
			'orderby'			=>$orderBy,
			'order'				=>$order,
			'paged'				=>$paged,
			'caller_get_posts' 	=> 1
		);
		$currentTagQuery = new WP_Query($args);
		while ($currentTagQuery->have_posts()) : $currentTagQuery->the_post();
		
			$output = my_attachment_images(0,2);
			$imgNum = count($output);
			
			//set the class and resize the product image according to the column selection from the theme options 
			switch($WPS_tagCol){
				case 'tagCol3_ws':
					$the_class 		= alternating_css_class($counter,3,' c_box_first');
					if (($a==1) || ($a==2) || ($a==3)) {$the_row_class='top_row';}else{$the_row_class='';}
					$the_div_class 	= 'c_box c_box3_ws'. $the_class .' '. $the_row_class;
					$img_size 		= $OPTION['wps_prodCol3w_img_size'];
				break;
														
				case 'tagCol4_ws':
					$the_class 		= alternating_css_class($counter,4,' c_box_first');
					if (($a==1) || ($a==2) || ($a==3) || ($a==4)) {$the_row_class='top_row';}else{$the_row_class='';}
					$the_div_class 	= 'c_box '. $the_class .' '. $the_row_class;
					$img_size 		= $OPTION['wps_prodCol4_img_size'];
				break;
			} 
			
			if($imgNum != 0){
				$imgURL		= array();
				foreach($output as $v){
				
					$img_src 	= $v;
					
					// do we want the WordPress Generated thumbs?
					if ($OPTION['wps_wp_thumb']) {
						//get the file type
						$img_file_type = strrchr($img_src, '.');
						//get the image name without the file type
						$parts = explode($img_file_type,$img_src);
						// get the thumbnail dimmensions
						$width = get_option('thumbnail_size_w');
						$height = get_option('thumbnail_size_h');
						//put everything together
						$imgURL[] = $parts[0].'-'.$width.'x'.$height.$img_file_type;
					
					// no? then display the default proportionally resized thumbnails
					} else {
						$des_src 	= $OPTION['upload_path'].'/cache';							
						$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');    
						$imgURL[] 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;	
					}
			
				}
			} 

			?>
			
			<div <?php post_class("$the_div_class"); ?>>
				<?php include (TEMPLATEPATH . '/lib/pages/category_body.php'); ?>
			</div><!-- c_box  -->
			
		<?php 
		// clear for nicely displayed rows :)
		switch($WPS_tagCol){
			case 'tagCol3_ws':
				echo insert_clearfix($counter,3,' <div class="clear"></div>');
			break;
			
			case 'tagCol4_ws':
				echo insert_clearfix($counter,4,' <div class="clear"></div>');
			break;
		}
		$counter++;
		$a++;
		
		endwhile;
		wp_reset_query();
		include (TEMPLATEPATH . '/wp-pagenavi.php');
		if(function_exists('wp_pagenavi')) { wp_pagenavi(); }?>
			
	</div><!-- theTags -->
		
	<?php
	
	include (TEMPLATEPATH . '/widget_ready_areas.php');
	
	
get_footer(); ?>