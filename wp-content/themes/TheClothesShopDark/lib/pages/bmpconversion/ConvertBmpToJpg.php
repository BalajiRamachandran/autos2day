<?php
	require ( TEMPLATEPATH . '/../../../wp-load.php' );
	?>
	<style type="text/css">
	.convert_images_div {
		margin: auto;
	}
	.conversion_results {
		width: 80%;
		margin: auto;
	}
	#resultstable {
		margin-top: 50px;
		width: 100%;
	}
	#resultstable thead td {
		/*background: #DDD;*/
	}
	#convert_images {
		padding: 10px;
	}
	td {
		padding: 6px;
		text-align: center;
	}
	</style>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#resultstable thead td").addClass("ui-widget-header");
			jQuery("#resultstable tbody td").addClass("ui-widget-content");
		});
	</script>
	<?php 

	if ( isset($_POST['convert']) && $_POST['convert'] == 'true' ) {
		$upload_dir = wp_upload_dir();
		// 
		$out = array();
		exec ('/usr/bin/mogrify -verbose -format jpg ' . $upload_dir['path'] . '/*.bmp 2>&1', $out);
		
		// print_r($out);

		foreach ($out as $key => $value) {
			# code...
			if ( strpos($value, '=') === false ) {

			} else {
				$filename = substr($value, 0, strpos($value, '='));
				$url = esc_url(get_stylesheet_directory_uri() . '/lib/pages/bmpconversion/ConvertBmpToJpgAjax.php');
				?>
				<script type="text/javascript">
				jQuery.ajax({
					type: "GET",
					url: "<?php echo $url;?>",
					data: "ajax=convert_bmp_to_jpg&f=<?php echo basename($filename); ?>&file=<?php echo $filename; ?>",
					success: function(data){
						var dataText = data;
						if ( jQuery(dataText).find("conversion") ) {
							if ( jQuery(dataText).find("file") ) {
								// alert ( jQuery(dataText).find("file").text() );
								if ( jQuery(dataText).find("error") ) {
									jQuery("#resultstable").append("<tr><td class='ui-widget-content'>"+jQuery(dataText).find("file").text() + "</td><td class='ui-widget-content'><span class='.ui-icon .ui-icon-closethick'>" + jQuery(dataText).find("status").text() + "</span></td></tr>" );
								} else {
									jQuery("#resultstable").append("<tr><td class='ui-widget-content'>"+jQuery(dataText).find("file").text() + "</td><td class='ui-widget-content'>" + jQuery(dataText).find("status").text() + "</td></tr>" );
								}
							}
						} else {
						}
					}
				});

				</script>
				<?php
			}
		}
?>
<div class="conversion_results">
	<table id="resultstable">
		<thead><td>File</td><td>progress</td></thead>
		<tbody>
		</tbody>
	</table>
</div>
<?php		
	} else {
?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery.colorbox ({title: 'Click Convert to Convert All BMPs to JPGs', inline: true, href: ".convert_images_div", width: '400px', height: '200px'});
		jQuery("button").button();
	});
	</script>
<?php		
	}
?>
<div class="convert_images_div">
	<form action="#" method="POST" name="convert_images" id="convert_images">
		<center>
			<input type="hidden" name="convert" value="true"/>
			<button name="converting">Convert</button>
		</center>
	</form>
</div>
