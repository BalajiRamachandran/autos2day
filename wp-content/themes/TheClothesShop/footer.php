<?php $OPTION = NWS_get_global_options();?>	

			</div><!-- container -->
		</div><!-- floatswrap-->
	</div><!-- pg_wrap -->
		<?php 
			switch($OPTION['wps_footer_option']){
				case 'small_footer':
					include (TEMPLATEPATH . '/includes/footers/smallFooter.php');        					
				break;
					
				case 'large_footer':
					include (TEMPLATEPATH . '/includes/footers/largeFooter.php');    
				break;
			}
		?>
		</div><!-- end container -->				
	</div><!-- end footer -->
	
<?php wp_footer(); ?>
		
</body>
</html>