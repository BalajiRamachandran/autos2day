 	<?php
	if(!is_it_affiliate()) { 
		if((($OPTION['wps_sizeChart_enable']) || ($OPTION['wps_shipping_details_enable'])) && ( $post->post_status == "publish" )) { ?>
			<span class="clearfix align-right">	
				<?php
				//if size chart display is on		
				if ( $post->post_status == "publish") {?>
						<span class="alignleft sizing_info">
							<?php 
							global $voucher_code;
							if ( strlen($voucher_code) > 0) { ?>
								<a href="#" class="download" voucher="<?php echo $voucher_code; ?>">
									<input type="button" value="<?php echo 'Download Voucher PDF';?>" onclick=""/>
								</a>
							<?php 
								} elseif (get_post_meta($post->ID, "ad_post_status", true) == 'SOLD OUT') {
							?>
							<div class="success">SOLD OUT</div>
							<?php } else { ?>
								<a href="#" rel="div.overlay:eq(3)">
									<input type="button" class="download_btn download_btn_display" value="<?php echo get_option('wps_download_voucher');?>" onclick=""/>
								</a>
							<?php } ?>
						</span>
				<?php } elseif ( $post->post_status == "soldout" ) { ?>
				<div class='success'>SOLD OUT</div>
				<?php }
				?>					
				<!-- facebook ends-->
			</span>
			
		<?php }
	} ?>