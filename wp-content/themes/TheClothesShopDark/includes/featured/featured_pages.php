<?php 
//collect page options
$orderBy 	= $OPTION['wps_featPg_orderbyOption'];
$order 		= $OPTION['wps_featPg_orderOption'];
$incl 		= $OPTION['wps_featPg_inclOption'];

$mainPages = get_pages('include='. $incl .'&sort_column='. $orderBy .'&sort_order='. $order);

//count the pgs
$pg_num = count ($mainPages);

//set the right class according to number found
if ($pg_num==1){ $the_class = 'featCont1';}
elseif ($pg_num==2){ $the_class = 'featCont2';}
elseif ($pg_num==3){ $the_class = 'featCont3';}
elseif ($pg_num==4){ $the_class = 'featCont4';}
elseif ($pg_num==5){ $the_class = 'featCont5';}
else{}

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
				if (!empty($childPages)) { ?>
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
			<a class="mainCatTitle" href="<?php echo get_page_link($mainPage->ID);?>"><?php echo $mainPage->post_title; ?></a>
		</li>
		
		<?php 
		
		$a++;
		
	endwhile; endif; 
							
} ?>