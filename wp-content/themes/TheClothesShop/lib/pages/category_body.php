<?php 
$attr_option 		= get_custom_field("add_attributes"); // attributes - simple or configurable price?
$expiration_format	= get_option('expiration_format');
?>
	<?php 
	// if ( current_user_can('administrator') ) {
		// echo get_permalink();
		if ( isset($level) ) {
		?>
		<div class="ribbon-wrapper">
			<div class="ribbon-front">
				<a href="#" class="review_status publish"><?php echo $post->post_status;?></a>
			</div>
	 		<div class="ribbon-edge-topleft"></div>
	 		<div class="ribbon-edge-topright"></div>
			<div class="ribbon-edge-bottomleft"></div>
			<div class="ribbon-edge-bottomright"></div>
	 		<div class="ribbon-back-left"></div>
			<div class="ribbon-back-right"></div>
		</div>	
		<?php 
		}
	?>
<div class="contentWrap">
	<?php 
	$img_height_attrs = ' height="100px"';
	$img_width_attrs = ' width="122px"';
	if (isset($level) && $level == 'my_account') { 
		$width_attrs = ' style="width:71%;"';
	} else {		
		$width_attrs = ' style="width:83%;"';
	}
	//get image attachments!
	// added for getting images in my-account
	if($imgNum != 0){ 
		// changed from $imgNum == 1 to $imgNum != 0
		if(($imgNum != 0) || ($OPTION['wps_hover_remove_option'])){ ?>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf( __('Permalink to %s', 'wpShop'), the_title_attribute('echo=0') ); ?>">
				<img src="<?php echo $imgURL[0];?>" alt="<?php the_title_attribute(); ?>" <?php echo $img_height_attrs;?> <?php echo $img_width_attrs;?>/>
			</a>
			
		<?php } else { ?>
			
			<a class="hover_link" href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf( __('Permalink to %s', 'wpShop'), the_title_attribute('echo=0') ); ?>">
				<img src="<?php echo $imgURL[0];?>" alt="<?php the_title_attribute(); ?>"/>
			</a>
			<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf( __('Permalink to %s', 'wpShop'), the_title_attribute('echo=0') ); ?>">
				<img src="<?php echo $imgURL[1];?>" alt="<?php the_title_attribute(); ?>"/>
			</a>
		
		<?php } 
		
		// no attachments? pull image from custom field
	} elseif(strlen(get_custom_field('image_thumb', FALSE))>0){
		// resize the image.
		$img_src 	= get_custom_field('image_thumb', FALSE);
		$des_src 	= $OPTION['upload_path'].'/cache';							
		$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');    
		$imgURL 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;	
		
		// do we want the WordPress Generated thumbs?
		if ($OPTION['wps_wp_thumb']) {
			//get the file type
			$img_file_type = strrchr($img_src  , '.');
			//get the image name without the file type
			$parts = explode($img_file_type,$img_src);
			// get the thumbnail dimmensions
			$width = get_option('thumbnail_size_w');
			$height = get_option('thumbnail_size_h');
			//put everything together
			$imgURL = $parts[0].'-'.$width.'x'.$height.$img_file_type;
		}
		?>
		
		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf( __('Permalink to %s', 'wpShop'), the_title_attribute('echo=0') ); ?>">
			<img src="<?php echo $imgURL;?>" alt="<?php the_title_attribute(); ?>"/>
		</a>
		
	<?php 
	// no images altogether? Let them know!
	} else { ?>
		<p class="error">
			<?php _e('Oops! No Images!','wpShop'); ?>
		</p>
	<?php }
	
	// do we want a teaser?
	if($OPTION['wps_teaser_enable_option']) { ?>
		<div class="teaser" <?php echo $width_attrs;?>>
			<?php 
			//display prod title?
			if($OPTION['wps_prod_title']) { ?>
				<h5 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'wpShop'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
						<?php the_title(); ?>
					</a>
					&nbsp;-&nbsp;
					<?php global $level; if ( $level != 'my_account') {
						?>
					<span class="presented-by">
						<a href="<?php the_permalink(); ?>">
							<?php echo 'Presented by '. get_user_meta ($post->post_author, "dealership_name", true ); ?>
						</a>
					</span> 
						<?php
					} else {
					}
					?>
						<!-- 					<div class="deal_date">
						<?php 
							if (current_user_can( 'administrator' ) ) {
						?>
						<dl>
							<dt>Status</dt>
								<dd class='class_<?php echo $post->post_status;?>'><?php echo $post->post_status;?>
								</dd>
						</dl>
						<?php }?>
					</div>					
 -->				</h5>
					<?php 
						$post_meta = get_post_custom($post->ID);
						// echo $post->post_date;
					?>
					<div class="item_description">
						<table width='100%'  class='table_desc'>
							<tr>
								<td>
									<ol class="post_listing">
<!-- 										<li>
											<?php echo $post_meta['ad_year'][0]?> <?php echo $post_meta['ad_make'][0]?> <?php echo $post_meta['ad_model'][0]?>
										</li> 
-->
									<?php
									if (isset($level) && $level == 'my_account') { 
									} else {

									?>
<!-- 										<li>
											<?php echo $post_meta['ad_trim'][0]?>
										</li>
										<li>
											<?php echo $post_meta['ad_engine'][0]?>
										</li> -->
									<?php } ?>
										<?php if ( ! empty($post_meta['ad_trim'][0]) ) {
											?>
											<li>
												<?php echo $post_meta['ad_trim'][0];?>
											</li>
											<?php
										}
										?>
										<?php if ( ! empty($post_meta['ad_engine'][0]) ) {
											?>
											<li>
												<?php echo $post_meta['ad_engine'][0];?>
											</li>
											<?php
										}
										?>
										<?php if ( ! empty( $post_meta['ad_color'][0] ) ) {
											?>
											<li>
												<?php echo $post_meta['ad_color'][0];?>
											</li>
											<?php
										}
										?>
										<?php if ( ! empty($post_meta['ad_miles'][0]) ) {
											?>
											<li>
												<?php echo $post_meta['ad_miles'][0] . ' Miles';?>
											</li>
											<?php
										}
										?>
									</ol>
								</td>
								<td style="text-align: right;">
									<span class="ad_price">
										<?php echo $OPTION['wps_currency_symbol'];?>&nbsp;<?php echo number_format(get_custom_field('ad_price'), 2, '.', ','); ?>									
										<?php 
											if (get_post_meta($post->ID, "ad_post_status", true) == 'SOLD OUT') {
												echo '<br/>(SOLD)';
											}
										?>
									</span>
									<br/>
									<span style="position: absolute; bottom: 0; width: 300px; right: 0; font-weight: bold; padding: 3px; color: blue;">
										<?php 
										global $level;
										if ( $level == 'my_account' && get_post_meta($post->ID, "ad_post_status", true) != 'SOLD OUT') {
											//mark as sold
											// echo "<button name='mark_as_sold' class='mark_as_sold' post_id='$post->ID'>Mark AS SOLD</button>";
										} else {
										?>
										<a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'wpShop'), the_title_attribute('echo=0') ); ?>">
											Click Here for more information
										</a>
										<?php
										} 

										?>

									</span>
								</td>								
							</tr>
						</table>
					</div>

			<?php }
			
			if($OPTION['wps_teaser2_enable_option']) { 
			
				if(strlen(get_custom_field('item_remarks', FALSE))>0){ ?>
					<div class="item_description">
						<?php get_custom_field('item_remarks', TRUE); ?>
					</div>
				<?php }
			}
			
			//display prod price?
			if($OPTION['wps_prod_price'] && strlen(get_custom_field('price', FALSE))>0){ ?>
			
				<p class="price_value">
					<?php if(strlen(get_custom_field('new_price', FALSE))>0){ ?>
														
							<span class="was price">
								<?php if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(get_custom_field('price'));?></span>
							<span class="is price">
								<?php if($attr_option == 2){_e('From: ','wpShop');} 
									if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(get_custom_field('new_price')); 
									if($OPTION['wps_currency_code_enable']) { echo ' '. $OPTION['wps_currency_code']; }
									if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } ?>
							</span>
													
					<?php } elseif(strlen(get_custom_field('price', FALSE))>0){ ?>
													
							<span class="price solo"><?php if($attr_option == 2){_e('From: ','wpShop');} 
								if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(get_custom_field('price')); 
								if($OPTION['wps_currency_code_enable']) { echo ' '. $OPTION['wps_currency_code']; }
								if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } ?></span>
													
					<?php }	?>
				</p><!-- price_value -->
			
			<?php }
			
			//display add to basket btn?
			if($OPTION['wps_shoppingCartEngine_yes'] && $OPTION['wps_prod_btn'] && strlen(get_custom_field('disable_cart', FALSE))==0) { 
				// shop mode
				$wps_shop_mode 	= $OPTION['wps_shop_mode'];
				
				if($wps_shop_mode =='Inquiry email mode'){ ?>
					<span class="shopform_btn add_to_enquire_alt"><a href="<?php the_permalink(); ?>"><?php printf(__ ('Add to %s!','wpShop'), $OPTION['wps_pgNavi_inquireOption'])?></a></span>
				<?php } elseif ($wps_shop_mode=='Normal shop mode' && !is_it_affiliate()){ ?>
					<span class="shopform_btn add_to_cart_alt"><a  href="<?php the_permalink(); ?>"><?php printf(__ ('Add to %s!','wpShop'), $OPTION['wps_pgNavi_cartOption'])?></a></span>
				<?php } elseif ($wps_shop_mode=='affiliate_mode' || is_it_affiliate()){ ?>
					<span class="shopform_btn buy_now_alt"><a href="<?php get_custom_field('buy_now', TRUE); ?>" <?php if($OPTION['wps_affili_newTab']) { ?> title="<?php _e('Opens is new tab','wpShop'); ?>" target="_blank"<?php } ?>><?php _e('Buy Now','wpShop'); ?></a></span>
				<?php } else {}
			}
			
			if ($OPTION['wps_teaser2_enable_option'] != TRUE){
				if((strlen(get_custom_field('item_remarks', FALSE))>0) || ($out_of_stock === TRUE)){ ?>
						<p class="item_remarks">
							<?php if($out_of_stock === TRUE && $OPTION['wps_sold_out_enable']){  
								echo "<span class='sold_out'>$OPTION[wps_soldout_notice]</span>";
							} ?>
							<span><?php get_custom_field('item_remarks', TRUE); ?></span>
							
						</p><!-- item_remarks  -->
				<?php }	
			} 
			
			//if on a search page, do we want the post excerpt?
			if (is_search()) {
				if($OPTION['wps_search_teaser_option']) { 
					the_excerpt(); ?>
					<p class="read_more">
						<a href="<?php the_permalink(); ?>"><?php echo $OPTION['wps_readMoreLink']; ?></a>
					</p>
				<?php }
			} 
			
			//the ratings
			if($OPTION['wps_multiProd_rate_enable'] && function_exists('the_ratings')) { the_ratings(); }
			
			?>
		</div><!-- teaser  -->
		<?php 
		// include (TEMPLATEPATH . '/lib/pages/post_info.php');
		?>
	<?php } ?>
</div><!-- contentWrap  -->