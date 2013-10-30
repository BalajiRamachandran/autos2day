<?php
//display only if we have not disabled the Shopping Cart for this prod post
if(strlen(get_custom_field('disable_cart', FALSE))==0){

	$accountReg		= get_page_by_title($OPTION['wps_pgNavi_regOption']);

	// inventory control
	if($OPTION['wps_track_inventory'] == 'active'){

		$stock_amount = stock_control_deluxe(0,0,$attr,'amount_now',$post->ID);	
		echo '<script>var tracking = "on";</script>';
	}
	else {
		echo '<script>var tracking = "off";</script>';
	}

					
	if(get_post_meta($post->ID, 'new_price', true)) { 
	$values 		= get_post_custom_values("new_price"); 
	$basis_price 	= $values[0]; 										
	} 
	elseif(get_post_meta($post->ID, 'price', true)){ 
	$values 		= get_post_custom_values("price"); 
	$basis_price 	= $values[0];	
	}

	// digital affiliate prod?
	if(is_it_digital() && is_it_affiliate()){ ?>
		<span class="alignleft affili_digi_product"><?php _e('Affiliate / Digital product','wpShop');?></span>
	<?php }

	// digital prod?
	elseif(is_it_digital()){ ?>

		<p class="digi_prod"><?php _e('Digital product','wpShop');?></p>
		
	<?php } 

	// affiliate prod?
	elseif(is_it_affiliate()) { ?>

		<p class="affili_prod"><?php _e('Affiliate product','wpShop');?></p>

	<?php } else {} ?>
 
	<p class="price_value clearfix">

		<?php 
		// if price affecting selectable options are used
		if($attr_option == 2){ ?>		
			<span class="price basisprice"><?php _e('Starting from: ','wpShop'); if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($basis_price); if($OPTION['wps_currency_code_enable']) { echo ' ' . $OPTION['wps_currency_code']; } if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } ?></span>
			<span class="price endprice clearfix"><?php if ($OPTION['wps_prod_ID']) { ?><span class="alignright itemID"><?php get_custom_field('ID_item', TRUE); ?></span><?php } _e('Final Price: ','wpShop'); if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} ?><span id="priceTotal"></span><?php if($OPTION['wps_currency_code_enable']) { echo ' ' . $OPTION['wps_currency_code']; } if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } ?></span></span>
		<?php } 
		
		// otherwise display price
		if($attr_option != 2){ ?>

			<?php 
			if(get_post_meta($post->ID, 'new_price', true)) { 
				$values 	= get_post_custom_values("new_price"); 
				$new_price 	= $values[0]; ?>
				
				<span class="was price"><?php if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(get_custom_field('price')); ?></span>
				<span class="is price">
					<?php 
					if ($OPTION['wps_prod_ID']) { ?><span class="alignright itemID"><?php get_custom_field('ID_item', TRUE); ?></span><?php }
					if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(get_custom_field('new_price')); if($OPTION['wps_currency_code_enable']) { echo ' ' . $OPTION['wps_currency_code']; } if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } ?>
				</span>
		
			<?php } 
			elseif(get_post_meta($post->ID, 'price', true)){ 
				$values 		= get_post_custom_values("price"); 
				$price 	= $values[0];?>
		
				<span class="price solo">
					<?php 
					if ($OPTION['wps_prod_ID']) { ?><span class="alignright itemID"><?php get_custom_field('ID_item', TRUE); ?></span><?php }
					if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(get_custom_field('price')); if($OPTION['wps_currency_code_enable']) { echo ' ' . $OPTION['wps_currency_code']; } if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } ?>
				</span>
		
			<?php } 
		} ?>	
	</p><!-- price_value -->
	
	<?php 
	//if tax percentage display is on || inventory is active
	if ((($OPTION['wps_shop_country']=='US' && ($OPTION['wps_tax_info_enable'] && $OPTION['wps_salestax_sourcing_r'] =='taxincluded')) || $OPTION['wps_shop_country']!='US' && $OPTION['wps_tax_info_enable']) || ($OPTION['wps_track_inventory'] == 'active')){ ?>
		
		<p class="clearfix">
			<?php 
			// display tax info
			if (($OPTION['wps_shop_country']=='US' && ($OPTION['wps_tax_info_enable'] && $OPTION['wps_salestax_sourcing_r'] =='taxincluded')) || $OPTION['wps_shop_country']!='US' && $OPTION['wps_tax_info_enable']){ ?>
				<span class="alignleft tax_info"><?php _e('incl.','wpShop');?> <?php echo $OPTION['wps_tax_percentage']; ?> % <?php echo $OPTION['wps_tax_abbr']; ?> </span>
			<?php } 
			// display what is currently_in_stock	
			if($OPTION['wps_track_inventory'] == 'active' && $stock_amount !== 'not_set' && !is_it_digital()){															
				if($OPTION['wps_display_product_amounts'] =='active'){																	
						//we need additional method for prods without attributes
						if($attr_option == 1 || $attr_option == 2 ){$stock_amt = '&nbsp;';}else{$stock_amt = $stock_amount;}
						echo "<span class='alignright stock_info'>".__('Stock on Hand: ','wpShop')."<span id='stock_amount'>$stock_amt</span></span>";		
				}
			} ?>
		</p>


	<?php }
	?>

	<script type="text/javascript">
	var xmlhttp;
	jQuery(document).ready(function(){
		jQuery(".download").click(function(){
			var voucher_code = jQuery(this).attr("voucher");
			var site_url = '<?php echo site_url();?>' + "/?voucher_code=" + voucher_code;
			var cart_actions = "'/../../lib/engine/cart_actions.php';";
			var download =  window.open(site_url,'RecipeWindow','width=600,height=600');
		});
	});
	function stateChanged1() {
		if (xmlhttp.readyState==4) {
		}
	}
	</script>
	<!--
	<script src="<?php echo get_stylesheet_directory_uri() . '/js/jquery.countdown.js';?>" type="text/javascript"></script>
	-->
	<?php 
	// validate_exp_deal_date ($post->ID, $post->post_date, true );
	// $post_meta = get_post_meta ( $post->ID );
	// print_r ( $post_meta );
	// print_r($post->post_date);
	// echo '<hr/>';
	// echo get_option('expiration_format');
	// echo "deal-date: " . date ('Y-m-d H:i:s', strtotime($post_meta['expiration-time']));
	// echo '<hr/>';	
	// echo date(get_option('expiration_format'), strtotime($post->post_date));
	// validate_exp_deal_date ( $post_id, date(get_option('expiration_format')), true);
	// echo '<hr/>';

	?>

	<script type="text/javascript">
	// jQuery(function () {
	// 	var austDay = new Date();
	// 	// austDay = new Date(austDay.getFullYear() + 1, 1 - 1, 26);
	// 	austDay = new Date('<?php echo date("Y", strtotime($post_meta["expiration-time"][0]));?>', '<?php echo date("m", strtotime($post_meta["expiration-time"][0]));?>' - 1, '<?php echo date("d", strtotime($post_meta["expiration-time"][0]));?>', 0, 0, 0);
	// 	jQuery('#defaultCountdown').countdown({until: austDay});
	// 	// jQuery('#year').text(austDay.getFullYear());
	// });
	</script>

	<div id="defaultCountdown"></div>
	<?php
	$expiration_date = $post_meta['expiration-time'][0];
	if ( isset($expiration_date) && get_option("wps_expire_deals") != 'false') {
		?>
		<div class="expires">Expires: <?php echo $expiration_date;?></div>
		<?php
	}
	?>

	<?php
	//"<?php require_once(dirname(__FILE__) . " + cart_actions + "); $VOUCHER = load_what_is_needed(" + voucher + "); $VOUCHER->retrieve_voucher_pdf ( " + voucher_code + ");;
 	?>
 	



<?php }
 
//display only if we have disabled the Shopping Cart for this prod post
if(strlen(get_custom_field('disable_cart', FALSE))>0){ 
	if(strlen(get_custom_field('item_remarks', FALSE))>0){ ?>
		<h4><?php get_custom_field('item_remarks', TRUE); ?></h4>
	<?php } 
		//get the enquiry form!
		if(function_exists('is_tellafriend') && strlen(get_custom_field('enquire', FALSE))>0){ ?>
			<div id="prod_enquiry">
				<?php if(is_tellafriend( $post->ID )) insert_cform(3); ?>
			</div><!-- prod_enquiry -->	
		<?php } else {}
} ?>