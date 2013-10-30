<?php
			$target_path = wp_upload_dir();

			$file_name = $_FILES[$var]['name'];
			$log->general("Upload Image: " . $var . "\t" . $file_name, $post_id . '_');
			$file_name = str_replace ( "-", "" , $file_name);
			$file_name = str_replace ( " ", "" , $file_name);
			$file_name = str_replace ( "_", "" , $file_name);
			if ( strlen(basename($file_name)) > 10 ) {
				$file_name = substr($file_name, '-10');
			}
			$file_name = strtolower($file_name);
			$log->general("Upload Image(Renamed): " . $var . "\t" . $file_name, $post_id . '_');
			$log->general("Upload Image(Renamed): " . $var . "\terror: " . $_FILES[$var]['error'], $post_id . '_');
		    $file_array = array(
		        'name'      => $post_id . '_' . substr(md5($_FILES[$var]['name']), '-3') . $file_name,
		        'type'      => $_FILES[$var]['type'],
		        'tmp_name'  => $_FILES[$var]['tmp_name'],
		        'error'     => $_FILES[$var]['error'],
		        'size'      => $_FILES[$var]['size']
		    );
?>