<div class="meta noprint">
	<ul class="l1 clearfix">
		<?php if($OPTION['wps_publish_enable']){ ?>
			<p><?php _e('' . __( 'Published:', 'wpShop' ) . ' ', 'wpShop'); ?><?php the_time($OPTION['date_format']); ?></p>
		<?php } if($OPTION['wps_posted_enable']){ ?>
			<p><?php _e( '' . __( 'Posted in:', 'wpShop' ) . ' ', 'wpShop' ); ?><?php echo get_the_category_list(', '); ?></p>
		<?php } if($OPTION['wps_tagged_enable']){
			the_tags( '<p>' . __('' . __( 'Tagged as:', 'wpShop' ) . ' ', 'wpShop' ), ',' , '</p>' ); 
		} if($OPTION['wps_prevNext_enable']){ ?>
			<p><?php previous_post_link( '%link', '<span class="meta-nav">&laquo;</span>' . __( 'Previous:', 'wpShop' ) . ' %title', TRUE ); ?> | <?php next_post_link( '%link', '' . __( 'Next:', 'wpShop' ) . ' %title <span class="meta-nav">&raquo;</span>', TRUE ); ?></p>
		<?php } ?>
	</ul>
</div><!-- meta -->