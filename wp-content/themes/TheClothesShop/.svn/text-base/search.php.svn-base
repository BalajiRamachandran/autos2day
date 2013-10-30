<?php get_header();
//collect options
$WPS_prodCol		= $OPTION['wps_prodCol_option'];
$WPS_sidebar		= $OPTION['wps_sidebar_option'];

// sidebar location?
switch($WPS_sidebar){
	case 'alignRight':
		$the_float_class 	= 'alignleft';
	break;
	case 'alignLeft':
		$the_float_class 	= 'alignright';
	break;
}
// teaser?
if($OPTION['wps_teaser_enable_option']) {$the_eqcol_class = 'eqcol'; }
//what column option?
switch($WPS_prodCol){
	case 'prodCol3_ns':
		$the_div_class 	= 'theProds clearfix theProds_alt_n '.$the_float_class.' '.$the_eqcol_class;
		$the_div_class2 = 'theProds clearfix theProds_alt_n '.$the_float_class;
		$counter = 3; 
	break;
								
	case 'prodCol3_ws':
		$the_div_class 	= 'theProds clearfix theProds_alt '.$the_float_class.' '.$the_eqcol_class;
		$the_div_class2 = 'theProds clearfix theProds_alt '.$the_float_class;
		$counter = 3;      
	break;
		
	case 'prodCol4_ns':
		$the_div_class 	= 'theProds clearfix theProds_alt_n '.$the_float_class.' '.$the_eqcol_class;
		$the_div_class2 = 'theProds clearfix theProds_alt_n '.$the_float_class;
		$counter = 4;      
	break;
	
	case 'prodCol4_ws':
		$the_div_class 	= 'theProds clearfix theProds_alt '.$the_float_class.' '.$the_eqcol_class;
		$the_div_class2 = 'theProds clearfix theProds_alt '.$the_float_class;
		$counter = 4;      
	break;
		
	case 'prodCol5':
		$the_div_class 	= 'theProds clearfix '.$the_eqcol_class;
		$the_div_class2 = 'theProds clearfix';
		$counter = 5;      
	break;
}
//set the counter according to the column selection from the theme options
$a = 1;
 
if (have_posts()){ ?>
	<div class="<?php echo $the_div_class;?>">
		<?php while (have_posts()) : the_post();
			$output = my_attachment_images(0,2);
			$imgNum = count($output);
			//set the class and resize the product image according to the column selection from the theme options 
			switch($WPS_prodCol){
				case 'prodCol3_ns':
					$the_class 		= alternating_css_class($counter,3,' c_box_first');
					if (($a==1) || ($a==2) || ($a==3)) {$the_row_class='top_row';}else{$the_row_class='';}
					$the_div_class 	= 'c_box c_box3_ns '. $the_class .' '. $the_row_class;
					$img_size 		= $OPTION['wps_prodCol3n_img_size'];
				break;
				
				case 'prodCol3_ws':
					$the_class 		= alternating_css_class($counter,3,' c_box_first');
					if (($a==1) || ($a==2) || ($a==3)) {$the_row_class='top_row';}else{$the_row_class='';}
					$the_div_class 	= 'c_box c_box3_ws '. $the_class .' '. $the_row_class;
					$img_size 		= $OPTION['wps_prodCol3w_img_size'];
				break;
														
				case 'prodCol4_ns':
					$the_class 		= alternating_css_class($counter,4,' c_box_first');
					if (($a==1) || ($a==2) || ($a==3) || ($a==4)) {$the_row_class='top_row';}else{$the_row_class='';}
					$the_div_class 	= 'c_box '. $the_class .' '. $the_row_class;
					$img_size 		= $OPTION['wps_prodCol5_img_size'];
				break;
				
				case 'prodCol4_ws':
					$the_class 		= alternating_css_class($counter,4,' c_box_first');
					if (($a==1) || ($a==2) || ($a==3) || ($a==4)) {$the_row_class='top_row';}else{$the_row_class='';}
					$the_div_class 	= 'c_box c_box4_ws '. $the_class .' '. $the_row_class;
					$img_size 		= $OPTION['wps_prodCol4_img_size'];
				break;
				
				
				case 'prodCol5':
					$the_class 		= alternating_css_class($counter,5,' c_box_first');
					if (($a==1) || ($a==2) || ($a==3) || ($a==4) || ($a==5)) {$the_row_class='top_row';}else{$the_row_class='';}
					$the_div_class 	= 'c_box '. $the_class .' '. $the_row_class;
					$img_size 		= $OPTION['wps_prodCol5_img_size'];
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
	
			$postType = get_post_class();
			if (in_array("page", $postType)) { ?>
				<div <?php post_class('search_post '.$the_div_class); ?> id="post-<?php the_ID(); ?>">
					<div class="contentWrap">
						<h4><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'wpShop'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
						<?php the_excerpt(); ?>
					</div><!-- contentWrap  -->
				</div><!-- search_post -->
			
			<?php  } else { ?>
			
				<div <?php post_class('search_post '.$the_div_class); ?> id="post-<?php the_ID(); ?>">
					<?php include (TEMPLATEPATH . '/lib/pages/category_body.php');?>			
				</div><!-- search_post -->
			<?php  } 
	
			// clear for nicely displayed rows :)
			switch($WPS_prodCol){
				case 'prodCol3_ns':
					echo insert_clearfix($counter,3,' <div class="clear"></div>');
				break;
				
				case 'prodCol3_ws':
					echo insert_clearfix($counter,3,' <div class="clear"></div>');
				break;
				
				case 'prodCol4_ns':
					echo insert_clearfix($counter,4,' <div class="clear"></div>');
				break;
				
				case 'prodCol4_ws':
					echo insert_clearfix($counter,4,' <div class="clear"></div>');
				break;
												
				case 'prodCol5':
					echo insert_clearfix($counter,5,' <div class="clear"></div>');		
				break;
			}

			$counter++;
			$a++;

		endwhile; 
		wp_reset_query();
		include (TEMPLATEPATH . '/wp-pagenavi.php');
		if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
	
	</div><!-- theProds -->

<?php } else { ?>
		
	<div class="<?php echo $the_div_class2;?>">
		<h4><?php _e('Nothing found','wpShop');?></h4>
		<p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.','wpShop');?></p>
		<div class="main_col_searchform">
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		</div>
	</div><!-- theProds -->	
			
<?php }

	switch($WPS_prodCol){
		case 'prodCol3_ns':
			include (TEMPLATEPATH . '/widget_ready_areas.php');   
		break;
									
		case 'prodCol3_ws':
			include (TEMPLATEPATH . '/widget_ready_areas.php');      
		break;
			
		case 'prodCol4_ns':
			include (TEMPLATEPATH . '/widget_ready_areas.php');       
		break;
		
		case 'prodCol4_ws':
			include (TEMPLATEPATH . '/widget_ready_areas.php');       
		break;
			
		case 'prodCol5':
		break;
	}
get_footer(); ?>