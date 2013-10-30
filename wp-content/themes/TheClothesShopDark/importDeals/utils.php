<?php

function read_files ( $filename, $seperator ) {
	$row = 1;
	if (($handle = fopen($filename, "r")) !== FALSE) {
		switch ($seperator) {
			case 'tab':
			    while (($data = fgetcsv($handle, 100000, "\t")) !== FALSE) {
			    	if ( $row == 1 ) {
			    		$colHeads = $data;
			    		goto nextArray;
			    	}
			    	$num = count($data);
			    	if ( $row < 10000 ) :
			        for ($c=0; $c < $num; $c++) {
			        	$data[$c] = trim($data[$c]);
			        	// $data[$c] = str_replace(",", '', $data[$c]);
			        	$data[$c] = str_replace("$", '', $data[$c]);
			        	$data[$c] = str_replace("Unlisted", '', $data[$c]);
			        	if ( trim($data[$c]) != '' ) :
			            	// echo $colHeads[$c] . ":&nbsp;" . $data[$c] . "<br />\n";
			        	endif;
			        }

			    	$dataFields[$row] = $data;//explode(',', $data);//$data[0];
			        $num = count($data);
			        if ( trim($data[3]) == 'N' ) {
			        } else {
				        // echo "<p> $num fields in line $row: $data[3]<br /></p>\n";
			        }
			        endif;
			        nextArray :
			        $row++;
			    }
			    fclose($handle);
				break;
			
			case 'comma' :
			    while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
			    	if ( $row == 1 ) {
			    		$colHeads = $data;
			    		goto nextArray1;
			    	}
			    	$num = count($data);
			    	// if ( $row < 10 ) :
			        for ($c=0; $c < $num; $c++) {
			        	$data[$c] = trim($data[$c]);
			        	// $data[$c] = str_replace(",", '', $data[$c]);
			        	$data[$c] = str_replace("$", '', $data[$c]);
			        	$data[$c] = str_replace("Unlisted", '', $data[$c]);
			        	if ( trim($data[$c]) != '' ) :
			            	// echo $colHeads[$c] . ":&nbsp;" . $data[$c] . "<br />\n";
			        	endif;
			        }

			    	$dataFields[$row] = $data;//explode(',', $data);//$data[0];
			        $num = count($data);
			        if ( trim($data[3]) == 'N' ) {
			        } else {
				        // echo "<p> $num fields in line $row: $data[3]<br /></p>\n";
			        }
			        // endif;
			        nextArray1 :
			        $row++;
			    }
			    fclose($handle);
				break;
		}
	}

	return $dataFields;
}

function remove_child ( $tag, $doc, $xpath='' ) {
	unset ($elements);
	unset ($element);
	$query = new DOMXpath($doc);
	if ( $xpath != '' ) {
		$elements = $query->query($xpath);
	} else {
		$elements = $doc->getElementsByTagName($tag);
	}
	foreach ($elements as $element) {
		$element->parentNode->removeChild($element);
	}			
	// return $document;
}

function get_contents_from_url ( $id, $url ) {
	global $file_base_path;
	// echo '<pre>' . $url . '</pre>';
	$document = new DOMDocument();
	$file = $file_base_path . '/' . $id . '.html';
	if ( file_exists( $file ) ) {
		$document->loadHTMLFile ( $file );
	} else {
		$content = file_get_contents ( $url );
		$content = preg_replace("/>\s+</", "> <", $content);
		$content = preg_replace("/>\s+</", "> <", $content);
		$content = str_replace("&", "&#38;", $content);
		$content = preg_replace ("/\s+/", " ", $content);
		$content = str_replace("<div", "\r\n<div", $content);
		$document->loadHTML($content);	
	}
	remove_child ( "title", $document);
	remove_child ( "head", $document);
	remove_child ( "script", $document);
	remove_child ( "select" , $document);
	remove_child ( "iframe" , $document);

	$removeXpathElements = array (
			'*//div[@id="navtop"]',
			'*//div[@class="headerbreak"]',
			'*//div[@id="numlistings"]',
			'*//td[@class="productTileCell"]',
			'*//td[@class="distanceFromZip"]'
		);

	foreach ($removeXpathElements as $key => $value) {
		remove_child ( '' , $document, $value );
	}

	remove_child ( '' , $document, '//div[@id="header"]' );
	remove_child ( '' , $document, '//div[@class="dealerinfo"]' );
	

	remove_child ('', $document, "//script");

	remove_child ('', $document, "//div[@id='af-footer']");
	remove_child ('', $document, "//div[@id='af-header']");
	remove_child ('', $document, "//div[@class='mm4-details-tabs-content']");
	remove_child ('', $document, "//div[@class='mm4-details-similar']");
	remove_child ('', $document, "//div[@class='mm4-disclaimer']");
	//mm4-details-specs description
	remove_child ('', $document, "//div[@class='mm4-details-specs description']");
	//mm4-match-extras
	remove_child ('', $document, "//div[@class='mm4-match-extras']");		

	//mm4-details-similar
	//mm4-details-tabs-content
	// $document->saveHTMLFile($file);
	return $document;
}


function download_images1 ( $path, $url ) {
	$filepath = '';
	if($url){
		$file = fopen($url,"rb");
		if($file){
		$valid_exts = array("jpg","jpeg","gif","png"); // default image only extensions
		$ext = end(explode(".",strtolower(basename($url))));
			if(in_array($ext,$valid_exts)){
				$rand = rand(10000,99999);
				$filepath = $path . '/' . $rand . basename($url);
				$newfile = fopen($filepath, "wb"); // replace "downloads" with whatever directory you wish.
				if($newfile){
					while(!feof($file)){
					// Write the url file to the directory.
						fwrite($newfile,fread($file,1024 * 8),1024 * 8); // write the file to the new directory at a rate of 8kb/sec. until we reach the end.

					}
				}
				fclose($newfile);
			}
		}
		$rand = rand(10000,99999);
		$img_dst = $path . '/' . $rand . basename($url);
		$rand = rand(10000,99999);
		$img_dst1 = $path . '/' . $rand . basename($url);

		list($w_src, $h_src, $type) = getimagesize($filepath);
		echo "\n*******type: $type*****\n";
		switch ($type) {
		  case 1:   //   gif -> jpg
	        $img_src = imagecreatefromgif($filepath);
	        break;
	      case 2:   //   jpeg -> jpg
	        $img_src = imagecreatefromjpeg($filepath); 
	        break;
	      case 3:  //   png -> jpg
	        $img_src = imagecreatefrompng($filepath);
	        break;
	     }

	     $img_dst = imagecreatetruecolor($w_src, $h_src);	
	     try {
		     imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $w_src, $h_src, $w_src, $h_src);	
		     
		     imagejpeg($img_dst, $img_dst1); 
		     
		     unlink($filepath);
		     
		     imagedestroy($img_src);
		     imagedestroy($img_dst);

	     } catch ( Exception $e ) {
	     	print_r($e);
	     }
	}
	return $img_dst1;
}

function download_images2 ( $path, $src ) {
	if ( ! file_exists($path) ) {
		mkdir($path);
	}

	file_put_contents($path . '/' . basename($src), file_get_contents($src));

	return $path . '/' . basename($src);
}

function download_images ( $path, $src ) {
	global $post_id;
	$ch = curl_init($src);
	$rand = rand(1000, 9999);
	$image_name = $path . '/' . $post_id . '_' . $rand . '_' . strtolower(basename($src));
	$fp = fopen($image_name, 'wb');
	curl_setopt($ch, CURLOPT_FILE, $fp);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	fclose($fp);	
	return $image_name;

}

function write_to_csv ( $pages, $dealer_id ) {
	$row = 1;
	$fp = fopen(dirname(__FILE__) . '/' . $dealer_id . '.csv', 'w');
	foreach ($pages as $key ) {
		$fields = new stdClass();
		$fields = $key;
		if ( $row == 1) {
			$colheads = implode (',', array_keys((array)$fields));
			fputcsv($fp, array_keys((array)$fields));
		}
		// fputcsv($fp, implode (',', array_values((array)$fields)));
		fputcsv($fp, array_values((array)$fields));
		foreach ($fields as $_key => $value) {
			// echo $_key . '=' . $value . '<br/>';			
		}
		++$row;
	}
	fclose($fp);
}

function update_db ( $pages ) {

	foreach ($pages as $key => $value) {
		$db_values = new stdClass();
		//update DB
		$db_values->URL = '';
		$db_values->ad_price = '';
		$db_values->ad_mileage = '';
		$db_values->ad_engine = '';
		$db_values->DealershipName = '';
		$db_values->ad_vin = '';
		$db_values->ID = mysql_escape_string($key);
		$db_values->URL = mysql_escape_string($pages->$key->url);
		$db_values->ad_price = mysql_escape_string($pages->$key->Price);
		$db_values->ad_mileage = mysql_escape_string($pages->$key->Mileage);
		$db_values->ad_engine = mysql_escape_string($pages->$key->Engine);
		$db_values->DealershipName = '';
		for ( $i = 0 ; $i < 5; $i++) {
			if ( $pages->$key->images->{'thumb'.$i}->src != '' ) {
				$db_values->{'Image_'.$i} = 	mysql_escape_string($pages->$key->images->{'thumb'.$i}->src);
			} else {
				$db_values->{'Image_'.$i} = '';
			}
		}

		$sql_check = "SELECT count(*) from fetch_deals where ID = '" . $db_values->ID . "';";

		$result = mysql_query($sql_check);

		$exists = mysql_num_rows($result);

		$sql = 'INSERT into fetch_deals (';

		if ( $exists > 0 ) {
			$sql = 'UPDATE fetch_deals SET ';
			foreach ($db_values as $key => $value) {
				$sql .= " $key = '" . $value . "', ";
			}
			$sql .= "WHERE ID='" . $db_values->ID . "';";
			$sql = str_replace(", WHERE", " WHERE", $sql);
		} else {
			$sql .= "`" . implode('`,`', array_keys((array)$db_values)) . "`";
			$sql .= ') VALUES (';
			// echo '<hr/>';
			$sql .= "'" . implode('\',\'', array_values((array)$db_values)) . "'";
			$sql .= ');';
		}
		// echo '<br/>';
		// echo '<p>' . $sql . '</p>';
		$result = mysql_query($sql);
		if ( mysql_error()) {
			die(mysql_error());
		} else {
			// echo '<h1>' . mysql_affected_rows() . '</h1>';
		}			

	}	

}
?>