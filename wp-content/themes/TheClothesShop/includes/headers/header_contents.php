<?php 
// different page options
$search			= get_page_by_title($OPTION['wps_pgNavi_searchOption']);
$accountReg		= get_page_by_title($OPTION['wps_pgNavi_regOption']);
$accountLog		= get_page_by_title($OPTION['wps_pgNavi_logOption']);
$customerArea	= get_page_by_title($OPTION['wps_customerAreaPg']);

$lostPass		= get_page_by_title($OPTION['wps_passLostPg']);

$sortColumn 	= $OPTION['wps_pgNavi_sortOption'];
$includeLeft	= $OPTION['wps_pgNavi_inclLeftOption'];
$includeRight	= $OPTION['wps_pgNavi_inclRightOption'];
$exclude		= $OPTION['wps_pgNavi_exclOption'];
$Home			= $OPTION['wps_pgNavi_homeOption'];

// for some reason I need to get the option again although declared already in the header.
$blog_Name 	= $OPTION['wps_blogCat'];


$pageMenuArgLeft = array(
	'title_li'      =>NULL,
	'include'    	=>$includeLeft,
	'sort_column'	=>$sortColumn,
	
);

$pageMenuArgRight = array(
	'title_li'      =>NULL,
	'include'    	=>$includeRight,
	'sort_column'	=>$sortColumn,
	
);

$pageMenuArg	 = array(
	'title_li'      =>NULL,
	'sort_column'	=>$sortColumn,
	'depth'        	=> 1,
	'exclude'       =>$exclude,
);

// where do want the Login, Register, Search and Shopping Bag links?
if($OPTION['wps_lrscLinks_option']) {
	if($OPTION['wps_logoL']) {$the_div_class = 'topLinks alignright'; } else {$the_div_class = 'topLinks clearfix';} ?>
	<div class="<?php echo $the_div_class;?>">
		<ul class="alignright">
			<?php include( TEMPLATEPATH . "/includes/headers/header_links.php" );?>
		</ul>
	</div>
<?php } 

//left aligned Logo
if($OPTION['wps_logoL']) { 
	//For better SEO use h2 for the logo on subpages
	if (is_front_page()) { ?>
		<h1 id="branding"><a href="<?php bloginfo( 'url' );?>/" title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo('name'); bloginfo( 'description' ); ?></a></h1>
		
	<?php } else { ?>	
		<h2 id="branding"><a href="<?php bloginfo( 'url' );?>/" title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo('name'); bloginfo( 'description' ); ?></a></h2>
		
	<?php } 
} ?>





	<div class="centeringWrap">
		<?php if($OPTION['wps_logoL']) {$the_ul_class = 'primary_nav'; } else {$the_ul_class = 'primary_nav primary_l';} ?>
		<!--primary nav-->
		<ul class="<?php echo $the_ul_class;?>">
			
			<!-- <li class="home"><a href="<?php bloginfo( 'url' ); ?>/" ><?php echo $Home; ?></a></li> -->
			<?php if($OPTION['wps_logoL']) {
			
				// do we want a hybrid page-category navigation?
				if ($OPTION['wps_hybrid_menu_enable']) {
						
					// for 3rd level categories
					if (($topParent_cat !=0) && ($category[0]->category_parent != 0)) {
						$myCat = $topParent_cat;
						
					} else {
						$myCat = $category[0]->cat_ID;
					}
					
					$orderBy 	= $OPTION['wps_catNavi_orderbyOption'];
					$order 		= $OPTION['wps_catNavi_orderOption'];
					$include	= $OPTION['wps_catNavi_inclOption'];
					$exclude	= $OPTION['wps_catNavi_exclOption'];
					$titleLi	='';
					
					$catMenuArg = array(
						'include'   		=>$include,
						'exclude'			=>$exclude,
						'orderby'			=>$orderBy,
						'order'				=>$order,
						'title_li'			=>$titleLi,
						'depth'				=>1,
						'show_count'		=>0,
						'hide_empty'		=>0,
						'current_category' 	=>$myCat,
					);
					
					wp_list_categories($catMenuArg);
				}
			
				wp_list_pages($pageMenuArg);
				
				if($OPTION['wps_lrscLinks_option'] != TRUE) {
					include( TEMPLATEPATH . "/includes/headers/header_links.php" );
				} 
				
				// are we using a blog?
				if ($blog_Name != 'Select a Category') { 
					$blog_ID 	= get_cat_ID( $blog_Name );
				?>
					<li class="blog"><a href="<?php echo get_category_link($blog_ID);?>"><?php echo $blog_Name; ?></a></li>
					
				<?php } else {} 
				
			} else { ?>
				
				<?php 
				if ($includeLeft!='') {
					//wp_list_pages($pageMenuArgLeft);
				} ?>
				
			</ul>
			
			<?php
			// Centered Logo
			//For better SEO use h2 for the logo on subpages
			if (is_front_page()) { ?>
				<h1 id="branding"><a href="<?php bloginfo( 'url' );?>/" title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo('name'); bloginfo( 'description' ); ?>
				</a></h1>
				
			<?php } else { ?>	
				<h2 id="branding"><a href="<?php bloginfo( 'url' );?>/" title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo('name'); bloginfo( 'description' ); ?>
				</a></h2>
				
			<?php } ?>

			<?php
			
			if($includeRight=='') {$the_ul_class = 'primary_nav primary_r LRSC_nav'; } else {$the_ul_class = 'primary_nav primary_r';} ?>
			
			<ul class="<?php echo $the_ul_class;?>">
				<?php
				// where do want the Login, Register, Search and Shopping Bag links?
				?>
				<li class="home"><a href="<?php bloginfo( 'url' ); ?>/" ><?php echo $Home; ?></a></li>
				<?php 
				wp_list_pages($pageMenuArgLeft);
				if($OPTION['wps_lrscLinks_option']) {
					if ($includeRight!='') {
						wp_list_pages($pageMenuArgRight); 
					}
				} else {
					include( TEMPLATEPATH . "/includes/headers/header_links.php" );
				} 
			} ?>
		</ul>
		
	</div><!-- centeringWrap -->
	
<?php 
// have we already used a hybrid page-category navigation above?
if ($OPTION['wps_hybrid_menu_enable']) {
} else {
	if (!is_home() || $OPTION['wps_mainCatNavi_enable']) { ?>
		<div class="MainCatsNav">
			<ul>
				<?php 
				$orderBy 	= $OPTION['wps_catNavi_orderbyOption'];
				$order 		= $OPTION['wps_catNavi_orderOption'];
				$include	= $OPTION['wps_catNavi_inclOption'];
				$exclude	= $OPTION['wps_catNavi_exclOption'];
				
				$catMenuArg = array(
					'include'   		=>$include,
					'exclude'			=>$exclude,
					'orderby'			=>$orderBy,
					'order'				=>$order,
					'show_count'		=>0,
					'hide_empty'		=>0,
					'parent'			=>0,
				);
				
				// are we using drop downs?
				if($OPTION['wps_dropDown_enable']) {
					foreach ( (get_categories($catMenuArg)) as $category ) { ?> 
								
						<li <?php echo ((cat_is_ancestor_of($category->cat_ID, get_query_var('cat')) || $category->cat_ID == get_query_var('cat')) ? 'class="current-cat"': ''); ?>> 
							<a href="<?php echo get_category_link($category->cat_ID); ?>"><?php echo $category->cat_name; ?></a> 
							<?php if (get_term_children($category->cat_ID,'category')) { ?> 
								<ul><?php wp_list_categories('title_li&depth=1&child_of='.$category->cat_ID ); ?></ul> 
							<?php } ?> 
						</li>
									
					<?php }
					
				} else {			
					// for 3rd level categories
					if (($topParent_cat !=0) && ($category[0]->category_parent != 0)) {
						$myCat = $topParent_cat;
						
					} else {
						$myCat = $category[0]->cat_ID;
					}
					$titleLi	='';
					
					$catMenuArg = array(
						'include'   		=>$include,
						'exclude'			=>$exclude,
						'orderby'			=>$orderBy,
						'order'				=>$order,
						'title_li'			=>$titleLi,
						'depth'				=>1,
						'show_count'		=>0,
						'hide_empty'		=>0,
						'current_category' 	=>$myCat,
					);
					
					wp_list_categories($catMenuArg); 
				} ?>
			</ul>
		</div>
	<?php } 
} ?>