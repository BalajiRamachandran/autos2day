		<?php
			if ( $current_user->ID == $post->post_author || current_user_can( 'administrator' ) ) {
		?>
			<?php
			?>
			<div class="deal_date">
<!-- 				<dl>
					<dd><?php echo strtoupper($post->post_status);?></dd>
				</dl>
 -->				<dl>
					<dt>Expires </dt>
					<dd><?php echo date(get_option('expiration_format'), strtotime($post_meta['expiration-time'][0]));?></dd>
				</dl>
				<dl>
					<dt>Deal Date</dt>
					<dd><?php echo date(get_option('expiration_format'), strtotime($post_meta['deal-date'][0]));?></dd>
				</dl>					
			</div>							
		<?php } //end if?>			
