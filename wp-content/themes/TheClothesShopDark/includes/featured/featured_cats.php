<?php 
//collect category options
$orderBy 	= $OPTION['wps_mainCat_orderbyOption'];
$order 		= $OPTION['wps_mainCat_orderOption'];

if ($featuredType =='featured_cats_pages_cats') {
	$incl_left 	= $OPTION['wps_mainCat_incl_left'];
	$incl_right = $OPTION['wps_mainCat_incl_right'];
}

// are we using a Blog?
$blog_Name 	= $OPTION['wps_blogCat'];

// do we want Main Categories on either side and Pages in the Middle?
if ($featuredType =='featured_cats_pages_cats') {
	//collect the main categories to the left
	$mainCategories = get_terms('category', 'orderby='.$orderBy.'&order='.$order.'&parent=0&hide_empty=0&include='.$incl_left);
	//collect the main categories to the right
	$mainCategoriesR = get_terms('category', 'orderby='.$orderBy.'&order='.$order.'&parent=0&hide_empty=0&include='.$incl_right);
	
} else {
	if ($OPTION['wps_mainCat_excl'] != '') {
		$excl = $OPTION['wps_mainCat_excl'];
		//collect the main categories
		$mainCategories = get_terms('category', 'orderby='.$orderBy.'&order='.$order.'&parent=0&hide_empty=0&exclude='.$excl);
	} else {
		//collect the main categories
		$mainCategories = get_terms('category', 'orderby='.$orderBy.'&order='.$order.'&parent=0&hide_empty=0');
	}
}
//count the cats
$num = count ($mainCategories);


// if we want Main Categories on either side and Pages in the Middle then get sum!
if ($featuredType =='featured_cats_pages_cats') {
	//count the  right cats
	$numR 	= count ($mainCategoriesR);
	$num 	= $num + $numR;
}

//set the right class according to number found

if ( $num > 0 ) {
	$the_class = 'mainCat' . $num;	
}

// if ($num==1){ $the_class = 'mainCat1';}
// elseif ($num==2){ $the_class = 'mainCat2';}
// elseif ($num==3){ $the_class = 'mainCat3';}
// elseif ($num==4){ $the_class = 'mainCat4';}
// elseif ($num==5){ $the_class = 'mainCat5';}
// else{}

// do we want to feature pages as well? 
if ($featuredType =='featured_cats_and_pages' || $featuredType =='featured_cats_pages_cats') {
	//collect page options
	$orderBy 	= $OPTION['wps_featPg_orderbyOption'];
	$order 		= $OPTION['wps_featPg_orderOption'];
	$incl 		= $OPTION['wps_featPg_inclOption'];
	
	// the subpages
	$sub_orderBy 	= $OPTION['wps_featchildPg_orderbyOption'];
	$sub_order 		= $OPTION['wps_featchildPg_orderOption'];
	$sub_excl 		= $OPTION['wps_featchildPg_excl'];
	
	$mainPages = get_pages('include='. $incl .'&sort_column='. $orderBy .'&sort_order='. $order);
	
	//count the pgs
	$pg_num = count ($mainPages);
	// add the categories
	$num_cats_pgs = $num + $pg_num;
	//set the right class according to number found
	if ($num_cats_pgs==1){ $the_class = 'mainCat1';}
	elseif ($num_cats_pgs==2){ $the_class = 'mainCat2';}
	elseif ($num_cats_pgs==3){ $the_class = 'mainCat3';}
	elseif ($num_cats_pgs==4){ $the_class = 'mainCat4';}
	elseif ($num_cats_pgs==5){ $the_class = 'mainCat5';}
	else{}
	
} 



$a			= 1;
foreach ($mainCategories as $mainCategory) {

	$mainCategoryArgs = array(
		'cat'				=> '$mainCategory->term_id;',
		'showposts'			=> 1,
		'caller_get_posts' 	=> 1
	);
	//collect options
	$orderBy 		= $OPTION['wps_secondaryCat_orderbyOption'];
	$order 			= $OPTION['wps_secondaryCat_orderOption'];
	$excl			= $OPTION['wps_secondaryCat_excl'];
	//collect the child categories
	$mainCat 		= $mainCategory->term_id;
	$childCategories = get_terms('category', 'orderby='.$orderBy.'&order='.$order.'&parent='.$mainCat.'&hide_empty=0&exclude='.$excl);
	
	//form the main category query
	$mainCatsQuery = new WP_Query($mainCategoryArgs);
	// if ($mainCatsQuery->have_posts()) : while ($mainCatsQuery->have_posts()) : $mainCatsQuery->the_post();
		$the_cat_class = $mainCategory->slug;			
		$the_li_class 	= 'hover_block hover_block'. $a .' '. $the_class .' '. $the_cat_class;?>
		<li class="<?php echo $the_li_class;?>">
			<div class="contentWrap">
				<?php 
				// do we have 2nd level categories? If yes display a list of them
				if (!empty($childCategories) && $OPTION['wps_secondaryCat_remove'] != TRUE) {
					
					if ($OPTION['wps_secondaryCat_col_enable']) {
				
						$cats = explode("<br />",substr(trim(wp_list_categories('title_li=&echo=0&orderby='.$orderBy.'&order='.$order.'&exclude='.$excl.'&child_of='.$mainCat.'&hide_empty=0&style=none')),0,-6));
						//how many rows?
						$wanted_rows	= $wanted_rows	= $OPTION['wps_secondaryCat_rows'];
						$num			= count($cats);
						$counter		= 1;			
						$container 		= '<ul class="subcatnavi c_box c_box_first">';
						
						foreach($cats as $cat){
							//set an active class on the current category				
							$parts1 = explode("</a>",$cat);						
							$parts2 = explode(">",$parts1[0]);
							$catnam	= trim($parts2[1]);	
							
							
							if($counter % $wanted_rows == 0){
								$container .= "<li>".$cat .'</li></ul><ul class="subcatnavi c_box">';					
							} else {
								$container .= "<li>".$cat.'</li>';
							}
							
							$counter++;
						}
						
						$ending = substr($container,-29);
						if($ending == '<ul class="subcatnavi c_box">'){
							$container = substr($container,0,-29);
						}
						
						echo $container;
					
					} else { ?>
						<ul class="subcatnavi">
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
						
					<?php }
				} 
				//if we don't have any then display an image
				else { ?>
					<a href="<?php echo get_category_link($mainCategory->term_id);?>">
						<img src="<?php echo site_url();?>/<?php echo $OPTION['upload_path'];?>/<?php echo $mainCategory->slug; ?>_alt.<?php echo $OPTION['wps_catimg_file_type']; ?>" alt="<?php echo $mainCategory->name; ?>" />
					</a>
				<?php } 
				
				if ($OPTION['wps_staticImgs']) { ?>
					<a class="static_img" href="<?php echo get_category_link($mainCategory->term_id);?>">
				<?php } else { ?>
					<a class="hover_link" href="<?php echo get_category_link($mainCategory->term_id);?>">
				<?php } ?>
					<img src="<?php echo site_url();?>/<?php echo $OPTION['upload_path'];?>/<?php echo $mainCategory->slug; ?>.<?php echo $OPTION['wps_catimg_file_type']; ?>" alt="<?php echo $mainCategory->name; ?>" />
				</a>
			</div>
			
			<?php if ($OPTION['wps_featTitle_remove'] != TRUE) { ?>
				<a class="mainCatTitle" href="<?php echo get_category_link($mainCategory->term_id);?>"><?php echo $mainCategory->name; ?></a>
			<?php } ?>
			
		</li>
		
		<?php 
		
		$a++;
		
	// endwhile; endif; 
							
}
if ($featuredType =='featured_cats_and_pages' || $featuredType =='featured_cats_pages_cats') {
	foreach ($mainPages as $mainPage) {
		$mainPagesArgs = array(
			'page_id'	=> '$mainPage->ID;',
			'showposts'	=> 1
		);
		// the subpages
		$sub_orderBy 	= $OPTION['wps_featchildPg_orderbyOption'];
		$sub_order 		= $OPTION['wps_featchildPg_orderOption'];
		$sub_excl 		= $OPTION['wps_featchildPg_excl'];
		
		//collect the child pages
		$childPages = get_pages('child_of='. $mainPage->ID .'&parent='. $mainPage->ID .'&exclude='. $sub_excl .'&sort_column='. $sub_orderBy .'&sort_order='. $sub_order);
		
		//form the main page query
		$mainPgQuery = new WP_Query($mainPagesArgs);
		if ($mainPgQuery->have_posts()) : while ($mainPgQuery->have_posts()) : $mainPgQuery->the_post();
		
		$the_pg_class = $mainPage->post_name;			
		$the_li_class 	= 'hover_block hover_block'. $a .' '. $the_class .' '. $the_pg_class;?>
			<li class="<?php echo $the_li_class;?>">
				<div class="contentWrap">
					<?php 
					// do we have 2nd level pages? If yes display a list of them
					if (!empty($childPages) && $OPTION['wps_featchildPg_remove'] != TRUE) { ?>
						<ul class="subcatnavi">
							<?php  foreach ($childPages as $childPage) {
								$childPagesArgs = array(
									'page_id'	=> '$mainPage->ID;',
									'showposts'	=> 1
								);
								
								//form the child page query
								$childPgQuery = new WP_Query($childPagesArgs);
								if ($childPgQuery->have_posts()) : while ($childPgQuery->have_posts()) : $childPgQuery->the_post(); ?> 
									<li class="<?php echo $childPage->post_name; ?> pgID<?php echo $childPage->ID; ?>"><a href="<?php echo get_page_link($childPage->ID);?>"><?php echo $childPage->post_title; ?></a></li>
								<?php endwhile; endif; 
							
							} ?>
						</ul>
					<?php } 
					//if we don't have any then display an image
					else { ?>
						<a href="<?php echo get_page_link($mainPage->ID);?>">
							<img src="<?php echo get_option('siteurl');?>/<?php echo $OPTION['upload_path'];?>/<?php echo $mainPage->post_name; ?>_alt.<?php echo $OPTION['wps_pgimg_file_type']; ?>" alt="<?php echo $mainPage->post_title; ?>" />
						</a>
					<?php } 
					
					if ($OPTION['wps_staticImgs']) { ?>
						<a class="static_img" href="<?php echo get_page_link($mainPage->ID);?>">
					<?php } else { ?>
						<a class="hover_link" href="<?php echo get_page_link($mainPage->ID);?>">
					<?php } ?>
						<img src="<?php echo get_option('siteurl');?>/<?php echo $OPTION['upload_path'];?>/<?php echo $mainPage->post_name; ?>.<?php echo $OPTION['wps_pgimg_file_type']; ?>" alt="<?php echo $mainPage->post_title; ?>" />
					</a>
				</div>
				
				<?php if ($OPTION['wps_featTitle_remove'] != TRUE) { ?>
					<a class="mainCatTitle" href="<?php echo get_page_link($mainPage->ID);?>"><?php echo $mainPage->post_title; ?></a>
				<?php } ?>
			
			</li>
			
			<?php 
			
			$a++;
			
		endwhile; endif; 
								
	}
}
if ($featuredType =='featured_cats_pages_cats' && $OPTION['wps_mainCat_incl_right'] != '') {

	foreach ($mainCategoriesR as $mainCategoryR) {
		$mainCategoryArgs = array(
			'cat'				=> '$mainCategoryR->term_id;',
			'showposts'			=> 1,
			'caller_get_posts' 	=> 1
		);
		//collect options
		$orderBy 		= $OPTION['wps_secondaryCat_orderbyOption'];
		$order 			= $OPTION['wps_secondaryCat_orderOption'];
		$excl			= $OPTION['wps_secondaryCat_excl'];
		//collect the child categories
		$mainCatR 		= $mainCategoryR->term_id;
		$childCategoriesR = get_terms('category', 'orderby='.$orderBy.'&order='.$order.'&parent='.$mainCatR.'&hide_empty=0&exclude='.$excl);
		
		//form the main category query
		$mainCatsQuery = new WP_Query($mainCategoryArgs);
		if ($mainCatsQuery->have_posts()) : while ($mainCatsQuery->have_posts()) : $mainCatsQuery->the_post();
			$the_cat_class = $mainCategoryR->slug;			
			$the_li_class 	= 'hover_block hover_block'. $a .' '. $the_class .' '. $the_cat_class;?>
			<li class="<?php echo $the_li_class;?>">
				<div class="contentWrap">
					<?php 
					// do we have 2nd level categories? If yes display a list of them
					if (!empty($childCategoriesR) && $OPTION['wps_secondaryCat_remove'] != TRUE) {
						
						if ($OPTION['wps_secondaryCat_col_enable']) {
					
							$cats = explode("<br />",substr(trim(wp_list_categories('title_li=&echo=0&orderby='.$orderBy.'&order='.$order.'&exclude='.$excl.'&child_of='.$mainCatR.'&hide_empty=0&style=none')),0,-6));
							//how many rows?
							$wanted_rows	= $wanted_rows	= $OPTION['wps_secondaryCat_rows'];
							$num			= count($cats);
							$counter		= 1;			
							$container 		= '<ul class="subcatnavi c_box c_box_first">';
							
							foreach($cats as $cat){
								//set an active class on the current category				
								$parts1 = explode("</a>",$cat);						
								$parts2 = explode(">",$parts1[0]);
								$catnam	= trim($parts2[1]);	
								
								
								if($counter % $wanted_rows == 0){
									$container .= "<li>".$cat .'</li></ul><ul class="subcatnavi c_box">';					
								} else {
									$container .= "<li>".$cat.'</li>';
								}
								
								$counter++;
							}
							
							$ending = substr($container,-29);
							if($ending == '<ul class="subcatnavi c_box">'){
								$container = substr($container,0,-29);
							}
							
							echo $container;
						
						} else { ?>
							<ul class="subcatnavi">
								<?php  foreach ($childCategoriesR as $childCategoryR) {
									$childCategoryArgsR = array(
										'cat'		=> '$childCategoryR->term_id;',
										'showposts'	=> 1,
										'caller_get_posts' => 1
									);
									
									//form the child category query
									$childCatsQueryR = new WP_Query($childCategoryArgsR);
									if ($childCatsQueryR->have_posts()) : while ($childCatsQueryR->have_posts()) : $childCatsQueryR->the_post(); ?> 
										<li class="<?php echo $childCategoryR->slug; ?> catID<?php echo $childCategoryR->term_id; ?>"><a href="<?php echo get_category_link($childCategoryR->term_id);?>"><?php echo $childCategoryR->name; ?></a></li>
									<?php endwhile; endif; 
								
								} ?>
							</ul>
							
						<?php }
					} 
					//if we don't have any then display an image
					else { ?>
						<a href="<?php echo get_category_link($mainCategoryR->term_id);?>">
							<img src="<?php echo $OPTION['siteurl' ];?>/<?php echo $OPTION['upload_path'];?>/<?php echo $mainCategoryR->slug; ?>_alt.<?php echo $OPTION['wps_catimg_file_type']; ?>" alt="<?php echo $mainCategoryR->name; ?>" />
						</a>
					<?php } 
					
					if ($OPTION['wps_staticImgs']) { ?>
						<a class="static_img" href="<?php echo get_category_link($mainCategoryR->term_id);?>">
					<?php } else { ?>
						<a class="hover_link" href="<?php echo get_category_link($mainCategoryR->term_id);?>">
					<?php } ?>
						<img src="<?php echo $OPTION['siteurl' ];?>/<?php echo $OPTION['upload_path'];?>/<?php echo $mainCategoryR->slug; ?>.<?php echo $OPTION['wps_catimg_file_type']; ?>" alt="<?php echo $mainCategoryR->name; ?>" />
					</a>
				</div>
				<?php if ($OPTION['wps_featTitle_remove'] != TRUE) { ?>
					<a class="mainCatTitle" href="<?php echo get_category_link($mainCategoryR->term_id);?>"><?php echo $mainCategoryR->name; ?></a>
				<?php } ?>
			</li>
			
			<?php 
			
			$a++;
			
		endwhile; endif; 
	}
}?>