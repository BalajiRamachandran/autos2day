<?php get_header();

$WPS_catCol			= $OPTION['wps_catCol_option'];
$WPS_prodCol		= $OPTION['wps_prodCol_option'];
$WPS_sidebar		= $OPTION['wps_sidebar_option'];
$WPS_showposts		= $OPTION['wps_showpostsOverwrite_Option'];
$this_category 		= get_category($cat);
$topParent 			= NWS_get_root_category($cat,'allData');
$topParentSlug 		= $topParent->slug;
$this_categorySlug 	= $this_category->slug;
$log				= load_what_is_needed("log");

//collect options
$orderBy 	= $OPTION['wps_secondaryCat_orderbyOption'];
$order 		= $OPTION['wps_secondaryCat_orderOption'];
$excl		= $OPTION['wps_secondaryCat_excl'];
//collect the main categories
$current_mainCats = get_terms('category', 'orderby='.$orderBy.'&order='.$order.'&parent='.$this_category->term_id.'&hide_empty=0&exclude='.$excl);

switch($WPS_sidebar){
	case 'alignRight':
		$the_float_class 	= 'alignleft';
	break;
	case 'alignLeft':
		$the_float_class 	= 'alignright';
	break;
}

// do we have 2nd level categories? If yes, display them
if (!empty($current_mainCats) && ($this_categorySlug == $topParentSlug)) { 

	//which column option?
	switch($WPS_catCol){
		case 'catCol3':
			$the_div_class 	= 'theCats clearfix';
			$counter = 3;      
		break;
		case 'catCol3_ns':
			$the_div_class 	= 'theCats clearfix theCats_alt catCol3 catCol3_ns '. $the_float_class;
			$counter = 3; 
		break;
									
		case 'catCol3_ws':
			$the_div_class 	= 'theCats clearfix theCats_alt catCol3 catCol3_ws '. $the_float_class;
			$counter = 3;      
		break;
			
		case 'catCol2_ws':
			$the_div_class 	= 'theCats clearfix theCats_alt catCol2_ws '. $the_float_class;
			$counter = 2;      
		break;
	}
	
	if($OPTION['wps_catDescr_enable']) {
		echo term_description();
	} 
	
	?>

	<div class="<?php echo $the_div_class;?>">
		<?php $a = 1;
		foreach ($current_mainCats as $current_mainCat) {
			$current_mainCatArgs = array(
				'cat'		=> '$current_mainCat->term_id;',
				'showposts'	=> 1,
				'caller_get_posts' => 1
			);
			//collect the child categories
			$currentCat = $current_mainCat->term_id;
			$orderBy 	= $OPTION['wps_tertiaryCat_orderbyOption'];
			$order 		= $OPTION['wps_tertiaryCat_orderOption'];
			$childCategories = get_terms('category', 'orderby='.$orderBy.'&order='.$order.'&parent='.$currentCat.'&hide_empty=0');
			
			//form the main category query
			$current_mainCatsQuery = new WP_Query($current_mainCatArgs);
			if ($current_mainCatsQuery->have_posts()) : while ($current_mainCatsQuery->have_posts()) : $current_mainCatsQuery->the_post(); 
				//set the class according to the column selection from the theme options
				switch($WPS_catCol){
					case 'catCol3':
						$the_cat_class 	= $current_mainCat->slug;
						$the_class 		= alternating_css_class($counter,3,' c_box_first');
						if (($a==1) || ($a==2) || ($a==3)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box '. $the_class .' '. $the_row_class .' '. $the_cat_class;      
					break;
					case 'catCol3_ns':
						$the_cat_class 	= $current_mainCat->slug;
						$the_class 		= alternating_css_class($counter,3,' c_box_first');
						if (($a==1) || ($a==2) || ($a==3)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box c_box3_alt c_box3_alt_n '. $the_class .' '. $the_row_class .' '. $the_cat_class; 
					break;
												
					case 'catCol3_ws':
						$the_cat_class 	= $current_mainCat->slug;
						$the_class 		= alternating_css_class($counter,3,' c_box_first');
						if (($a==1) || ($a==2) || ($a==3)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box c_box3_alt '. $the_class .' '. $the_row_class .' '. $the_cat_class;     
					break;
						
					case 'catCol2_ws':
						$the_cat_class 	= $current_mainCat->slug;
						$the_class 		= alternating_css_class($counter,2,' c_box_first');
						if (($a==1) || ($a==2)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box c_box2_alt '. $the_class .' '. $the_row_class .' '. $the_cat_class;
					break;
				}
				
				?>
				<div class="<?php echo $the_div_class;?>">
			
					<div class="contentWrap">
					
						<ul class="c_box_padding subsubcatnavi">
							<li><a href="<?php echo get_category_link($current_mainCat->term_id);?>"><?php _e('View All','wpShop');?></a></li>
							<?php  foreach ($childCategories as $childCategory) {
								$childCategoryArgs = array(
									'cat'		=> '$childCategory->term_id;',
									'showposts'	=> 1,
									'caller_get_posts' => 1
								);
								//form the child category query
								$childCatsQuery = new WP_Query($childCategoryArgs);
								if ($childCatsQuery->have_posts()) : while ($childCatsQuery->have_posts()) : $childCatsQuery->the_post(); ?> 
									<li class="<?php echo $childCategory->slug; ?> catID<?php echo $childCategory->term_id; ?>"><a href="<?php echo get_category_link($childCategory->term_id);?>"><?php echo $childCategory->name; ?></a></li>
								<?php endwhile; endif; 
							
							} ?>
						</ul>
						
						<?php
						//display alternative category image instead of subcategory link list
						?>
						<!--<a class="alt_cat_img" href="<?php echo get_category_link($current_mainCat->term_id);?>">
							<img src="<?php echo get_option('siteurl');?>/<?php echo $OPTION['upload_path'];?>/<?php echo $current_mainCat->slug; ?>_alt.<?php echo $OPTION['wps_catimg_file_type2']; ?>" alt="<?php echo $current_mainCat->name; ?>" />
						</a>-->
						
						
						<?php if ($OPTION['wps_staticImgsCats']) {
						
							// set the class according to Text or Image display?
								switch($OPTION['wps_catDisplay_option']){
									case 'cat_img':
										$the_link_class 	= 'static_link static_link_alt ';
									break;
															
									case 'text_title':
										$the_link_class 	= 'static_link';		
									break;
								} 
						} else { 
						
							// set the class according to Text or Image display?
								switch($OPTION['wps_catDisplay_option']){
									case 'cat_img':
										$the_link_class 	= 'hover_link hover_link_alt ';
									break;
															
									case 'text_title':
										$the_link_class 	= 'hover_link';		
									break;
								}
							} ?>
							
							<a class="<?php echo $the_link_class;?>" href="<?php echo get_category_link($current_mainCat->term_id);?>">
						<?php 
							// Text or Image display?
							switch($OPTION['wps_catDisplay_option']){
								case 'cat_img':?>
									<img class="hover_img" src="<?php echo get_option('siteurl');?>/<?php echo $OPTION['upload_path'];?>/<?php echo $current_mainCat->slug; ?>.<?php echo $OPTION['wps_catimg_file_type2']; ?>" alt="<?php echo $current_mainCat->name; ?>" />
								<?php
								break;
														
								case 'text_title':
									echo $current_mainCat->name;		
								break;
							}?>
						</a>
					</div>
					
					
					<!--
					display category title
					<a class="catTitle" href="<?php //echo get_category_link($current_mainCat->term_id);?>"><?php //echo $current_mainCat->name; ?></a>-->
					<?php 
					//display category description
					//echo term_description($current_mainCat->term_id,'category');?>
				</div>
				
				<?php 
				// clear for nicely displayed rows :)
				switch($WPS_catCol){
					case 'catCol3':
						echo insert_clearfix($counter,3,' <div class="clear"></div>');    
					break;
					case 'catCol3_ns':
						echo insert_clearfix($counter,3,' <div class="clear"></div>');
					break;
												
					case 'catCol3_ws':
						echo insert_clearfix($counter,3,' <div class="clear"></div>');     
					break;
						
					case 'catCol2_ws':
						echo insert_clearfix($counter,2,' <div class="clear"></div>');     
					break;
				}
				
				$counter++;
				$a++;
			endwhile; endif; 
			wp_reset_query();						
		} ?>
	</div><!-- theCats -->
		
	<?php
	switch($WPS_catCol){
		case 'catCol3':
			  
		break;
		case 'catCol3_ns':
			include (TEMPLATEPATH . '/widget_ready_areas.php'); 
		break;
		case 'catCol3_ws':
			include (TEMPLATEPATH . '/widget_ready_areas.php');    
		break;
		case 'catCol2_ws':
			include (TEMPLATEPATH . '/widget_ready_areas.php');     
		break;
	}
} 

// display the products

else { 

	if($OPTION['wps_teaser_enable_option']) {$the_eqcol_class = 'eqcol'; }
	//what column option?
	switch($WPS_prodCol){
		case 'prodCol1_ws':
			$the_div_class 	= 'theProds clearfix theProds_alt '.$the_float_class;
			$counter = 1;      
		break;
		
		case 'prodCol2_ns':
			$the_div_class 	= 'theProds clearfix theProds_alt_n '.$the_float_class.' '.$the_eqcol_class;
			$counter = 2; 
		break;
									
		case 'prodCol2_ws':
			$the_div_class 	= 'theProds clearfix theProds_alt '.$the_float_class.' '.$the_eqcol_class;
			$counter = 2;      
		break;
		
		case 'prodCol3_ns':
			$the_div_class 	= 'theProds clearfix theProds_alt_n '.$the_float_class.' '.$the_eqcol_class;
			$counter = 3; 
		break;
									
		case 'prodCol3_ws':
			$the_div_class 	= 'theProds clearfix theProds_alt '.$the_float_class.' '.$the_eqcol_class;
			$counter = 3;      
		break;
			
		case 'prodCol4_ns':
			$the_div_class 	= 'theProds clearfix theProds_alt_n '.$the_float_class.' '.$the_eqcol_class;
			$counter = 4;      
		break;
		
		case 'prodCol4_ws':
			$the_div_class 	= 'theProds clearfix theProds_alt '.$the_float_class.' '.$the_eqcol_class;
			$counter = 4;      
		break;
			
		case 'prodCol5':
			$the_div_class 	= 'theProds clearfix '.$the_eqcol_class;
			$counter = 5;      
		break;
		}
		
		if($OPTION['wps_catDescr_enable']) {
			echo term_description();
		} 
	?>

	<div class="<?php echo $the_div_class;?>">
	
		<?php //set the "$a" counter
		
		$a = 1;
		// allow user to order their Products as the want to
		$orderBy 	= $OPTION['wps_prods_orderbyOption'];
		$order 		= $OPTION['wps_prods_orderOption'];
		
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$categoryvariable=$cat;
		
		if($this_category->category_parent == $topParent->term_id){
		//"View All" really View all
			switch($WPS_showposts){
			
				case 'showpostsOverwrite_yes':
					$args = array(
						'cat' 		=>$categoryvariable,
						'orderby'	=>$orderBy,
						'order'		=>$order,
						'showposts'	=> -1
					);
				break;
				
				case 'showpostsOverwrite_no':
					$args = array(
						'cat' 		=>$categoryvariable,
						'orderby'	=>$orderBy,
						'order'		=>$order,
						'paged'		=>$paged
					);
				break;
			}
			
		} else {
		
			$args = array(
				'cat' 		=>$categoryvariable,
				'orderby'	=>$orderBy,
				'order'		=>$order,
				'paged'		=>$paged,
			);
		}

		$posts_posted = false;

		$myModifiedQuery = new WP_Query($args);
		if ($myModifiedQuery->have_posts()){
			while ($myModifiedQuery->have_posts()) {
				$myModifiedQuery->the_post();
				$post_date = $post->post_date;
				$log->general(__FILE__ . " Post-id: " . $post->ID );
				$log->general(__FILE__ . " Post-status: " . $post->post_status );
				
				validate_exp_deal_date($post->ID, $post_date, true);

				/*
				get post_meta
				*/
				$post_meta			= get_post_custom ( $post->ID );
				// if ( ! isset($post_meta['deal-date'])) {
				// 	//set deal date and expiration-time
				// 	// get post-date
				// 	$post_expiration = post_expiration_set ( $post_date );
				// 	$deal_date = deal_date_set ( $post_date );
				// }
				// if post->deal-date eq current date then display otherwise do not.
				//print_r($post_meta);

				//echo date('Y-m-d', $post_meta['expiration-time'][0]);
				// set the timezone
				if ( !isset($_GET['debug']) || get_option("wps_expire_deals")) {
					if ( validate_deal_date($post_meta) ) {
						//echo '<h2>Same day</h2>';
						$log->general(__LINE__ . " Deal-date: " . date('Y-m-d', $post_meta['deal-date'][0]) );
						goto process_deal_here;
					} else {
						$log->general(__LINE__ . " Skipping Deal-date: " . date('Y-m-d', $post_meta['deal-date'][0]) );
						set_deal_expiration ( $post, $post_meta );
						//goto process_deal_here;//
						goto process_deal_next;
					}
				}
				process_deal_here:
				$posts_posted = true;
				if ($OPTION['wps_staticImgsProds']) {
					$output = my_attachment_images(0,1);
				} else {
					$output = my_attachment_images(0,2);
				}
				$imgNum = count($output);
				
				//set the class and resize the product image according to the column selection from the theme options 
				switch($WPS_prodCol){
					case 'prodCol1_ws':
						$the_class 		= alternating_css_class($counter,1,' c_box_first');
						if (($a==1)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box c_box1_ws '. $the_class .' '. $the_row_class;
						$img_size 		= $OPTION['wps_prodCol1_img_size'];
					break;
					
					case 'prodCol2_ns':
						$the_class 		= alternating_css_class($counter,2,' c_box_first');
						if (($a==1) || ($a==2)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box c_box2_ns '. $the_class .' '. $the_row_class;
						$img_size 		= $OPTION['wps_prodCol2n_img_size'];
					break;
					
					case 'prodCol2_ws':
						$the_class 		= alternating_css_class($counter,2,' c_box_first');
						if (($a==1) || ($a==2)) {$the_row_class='top_row';}else{$the_row_class='';}
						$the_div_class 	= 'c_box c_box2_ws '. $the_class .' '. $the_row_class;
						$img_size 		= $OPTION['wps_prodCol3_img_size'];
					break;
					
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
						//unset ($OPTION['wps_wp_thumb']);
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
					<?php include (TEMPLATEPATH . '/lib/pages/category_body.php');?>
				</div><!-- c_box  -->
				
				<?php 
				// clear for nicely displayed rows :)
				switch($WPS_prodCol){
					case 'prodCol1_ws':
						echo insert_clearfix($counter,1,' <div class="clear"></div>');
					break;
					
					case 'prodCol2_ns':
						echo insert_clearfix($counter,2,' <div class="clear"></div>');
					break;
					
					case 'prodCol2_ws':
						echo insert_clearfix($counter,2,' <div class="clear"></div>');
					break;
					
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
			process_deal_next:
			}

			
			if($this_category->category_parent == $topParent->term_id){
				
				switch($WPS_showposts){
					case 'showpostsOverwrite_yes':
					break;
					
					case 'showpostsOverwrite_no':
						include (TEMPLATEPATH . '/wp-pagenavi.php');
						if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
					break;
				}
				
			} else {
				include (TEMPLATEPATH . '/wp-pagenavi.php');
				if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
			} 
		} else {
		}

		if ( ! $posts_posted ) {
			echo '<div class="success">No Deals on this Category</div>';
		}
		?>
		
	</div><!-- theProds -->
<?php 
	switch($WPS_prodCol){
		case 'prodCol1_ws':
			include (TEMPLATEPATH . '/widget_ready_areas.php');      
		break;
		
		case 'prodCol2_ns':
			include (TEMPLATEPATH . '/widget_ready_areas.php');   
		break;
									
		case 'prodCol2_ws':
			include (TEMPLATEPATH . '/widget_ready_areas.php');      
		break;
		
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
}
get_footer();?>