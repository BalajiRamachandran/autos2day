<?php 
$thumb_yes 	= $OPTION['wps_imgThumbs_enable'];
//do we have more than one images?
if(($num > 1) && (empty($videoMatches[1][0]))){ 
	if(get_option('wps_imgThumbs_enable') == TRUE){$tabsClass = 'tabsWrapAlt';} else {$tabsClass = 'tabsWrap';}?>
	
	<div class="<?php echo $tabsClass;?> noprint">
		<ul class="tabs">
			<?php
			for($i=0,$a=1;$i<$num;$i++,$a++){
				$img_src 	= $data[$i]['guid'];
				$img_size 	= $OPTION['wps_singleProdMainMulti_img_size'];
				$des_src 	= $OPTION['upload_path'].'/cache';
				$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');    
				$imgURL[] 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;			
				
				if($thumb_yes == TRUE) { 						
					// thumb is produced 
					$t_img_size = $OPTION['wps_singleProd_t_img_size'];
					$t_des_src 	= $OPTION['upload_path'].'/cache';
					$t_img_file = mkthumb($img_src,$t_des_src,$t_img_size,'width');  
					$t_imgURL[] = get_option('siteurl').'/'.$t_des_src.'/'.$t_img_file;		
					?>
					<li>
						<a class="thumbTab imgTab" href="<?php echo $data[$i]['guid']; ?>" rel="zoom-id:zoom1" rev="<?php echo $imgURL[$i];?>"><img src="<?php echo $t_imgURL[$i];?>" alt="<?php echo $data[$i]['post_title']; ?>"/></a>
					</li>
				<?php } else { ?>
					<li><a class="thumbTab numTab" href="<?php echo $data[$i]['guid']; ?>" rel="zoom-id:zoom1" rev="<?php echo $imgURL[$i]; ?>"><?php echo $a; ?></a></li>
				<?php } 
			} ?>
		</ul><!-- tabs  -->
	</div><!-- tabsWrap  -->
	
<?php } 
// was a video added?
elseif(!empty($videoMatches[1][0])) { 
	if($OPTION['wps_imagesTab_enable']) { ?>
		
		<ul class="imgtabs videotabs noprint">
			<li><a class="imagesTab" href="#"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/socialIcons/Photo-trans.png" alt="<?php _e('Product Images','wpShop'); ?>"/><?php echo $OPTION['wps_imagesTabText']; ?></a></li>
			<li><a class="videoTab" href="#"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/socialIcons/Video-trans.png" alt="<?php _e('Product Video','wpShop'); ?>"/><?php echo $OPTION['wps_videoTabText']; ?></a></li>
		</ul><!-- imgtabs  -->
		
	<?php } ?>
	
	<div class="c_box v_box">
		<div class="contentWrap mediaPanes">
			<?php 
			if($OPTION['wps_imagesTab_enable']) { ?>
				<div class="theProdMedia innerProdMedia clearfix">
					<?php
					//do we have more than one images?
					if($num > 1){ 
						//image tabs or number tabs?
						if($thumb_yes == TRUE) {$tabsClass = 'tabsWrapAlt innerTabsWrapAlt';} else {$tabsClass = 'tabsWrap innerTabsWrap';}?>
						
						<div class="<?php echo $tabsClass;?> noprint">
							<ul class="tabs innerTabs">
								<?php
								for($i=0,$a=1;$i<$num;$i++,$a++){
									$img_src 	= $data[$i]['guid'];
									$img_size 	= $OPTION['wps_singleProdMainMulti_img_size'];
									$des_src 	= $OPTION['upload_path'].'/cache';
									$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');   
									$imgURL[] 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;			
									if($thumb_yes == TRUE) { 						
										// thumb is produced 
										$t_img_size = $OPTION['wps_singleProd_t_img_size'];
										$t_des_src 	= $OPTION['upload_path'].'/cache';
										$t_img_file = mkthumb($img_src,$t_des_src,$t_img_size,'width');  
										$t_imgURL[] = get_option('siteurl').'/'.$t_des_src.'/'.$t_img_file;		
										?>
										<li>
											<a class="thumbTab imgTab" href="<?php echo $data[$i]['guid']; ?>" rel="zoom-id:zoom1" rev="<?php echo $imgURL[$i];?>"><img src="<?php echo $t_imgURL[$i];?>" alt="<?php echo $data[$i]['post_title']; ?>"/></a>
										</li>
									<?php } else { ?>
										<li><a class="thumbTab numTab" href="<?php echo $data[$i]['guid']; ?>" rel="zoom-id:zoom1" rev="<?php echo $imgURL[$i]; ?>"><?php echo $a; ?></a></li>
									<?php } 
								} ?>
							</ul><!-- imgtabs  -->
						</div><!-- innerTabsWrap  -->
						
					<?php } else {
						// do we have 1 attached image?
						if($num != 0){
							for($i=0,$a=1;$i<$num;$i++,$a++){
								$img_src 	= $data[$i]['guid'];
								$img_size 	= $OPTION['wps_singleProdMain1_img_size'];
								$des_src 	= $OPTION['upload_path'].'/cache';
								$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');      
								$imgURL[] 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;
							}
						// no attachments? pull image from custom field
						} elseif(strlen(get_custom_field('image_thumb', FALSE))>0) { 
							
							$img_src 	= get_custom_field('image_thumb', FALSE);
							$img_size 	= $OPTION['wps_singleProdMain1_img_size'];
							$des_src 	= $OPTION['upload_path'].'/cache';							
							$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');    
							$imgURL[] 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;
							
						}
					} 
					if($num != 0){ ?>
						<a href="<?php echo $data[0]['guid']; ?>" class="MagicZoom" id="zoom1" rel="show-title: false; zoom-fade: true; zoom-position: inner; selectors-change:mouseover; selectors-effect:fade;"><img src="<?php echo $imgURL[0];?>" alt="<?php echo $data[0]['post_title']; ?>"/></a>
					<?php } else { ?>
						<a href="<?php echo $img_src; ?>" class="MagicZoom" id="zoom1" rel="show-title: false; zoom-fade: true; zoom-position: inner; selectors-change:mouseover; selectors-effect:fade;"><img src="<?php echo $imgURL;?>" alt="<?php echo wp_specialchars( get_the_title($post->ID), 1 ); ?>"/></a>
					<?php } ?>
				</div>
			<?php } 
			
			include (TEMPLATEPATH . '/includes/single/video.php'); ?>
		</div>
	</div><!-- c_box  -->
	
<?php } else {
	// do we have 1 attached image?
	if($num != 0){ 

		for($i=0,$a=1;$i<$num;$i++,$a++){
			$img_src 	= $data[$i]['guid'];
			$img_size 	= $OPTION['wps_singleProdMain1_img_size'];
			$des_src 	= $OPTION['upload_path'].'/cache';
			$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');      
			$imgURL[] 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;
		}
		
	// no attachments? pull image from custom field
	} elseif(strlen(get_custom_field('image_thumb', FALSE))>0) { 
		
		$img_src 	= get_custom_field('image_thumb', FALSE);
		$img_size 	= $OPTION['wps_singleProdMain1_img_size'];
		$des_src 	= $OPTION['upload_path'].'/cache';							
		$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');    
		$imgURL 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;
		
	}
} 

if(empty($videoMatches[1][0])) { 
	if ($num > 1) {$the_div_class ='c_box';} else {$the_div_class ='c_box mzBox';} ?>
	<div class="<?php echo $the_div_class;?>">
		<div class="contentWrap">
			<?php if($num != 0){ ?>
				<a href="<?php echo $data[0]['guid']; ?>" class="MagicZoom" id="zoom1" rel="show-title: false; zoom-fade: true; zoom-position: inner; selectors-change:mouseover; selectors-effect:fade;"><img src="<?php echo $imgURL[0];?>" alt="<?php echo $data[0]['post_title']; ?>"/></a>
			<?php } else { ?>
				<a href="<?php echo $img_src; ?>" class="MagicZoom" id="zoom1" rel="show-title: false; zoom-fade: true; zoom-position: inner; selectors-change:mouseover; selectors-effect:fade;"><img src="<?php echo $imgURL;?>" alt="<?php echo wp_specialchars( get_the_title($post->ID), 1 ); ?>"/></a>
			<?php } ?>
		</div>
	</div><!-- c_box  -->
<?php } ?>