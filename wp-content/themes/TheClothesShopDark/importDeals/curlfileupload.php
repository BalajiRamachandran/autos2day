<?php
	$ch = curl_init();
	$data = array('name' => $_GET['m'], 'id' => $_GET['n'], $_GET['n'] => '@' . $_GET['f']);
	curl_setopt($ch,CURLOPT_VERBOSE,1);
	// curl_setopt($ch,CURLOPT_PROXYTYPE,CURLPROXY_HTTP);
	// curl_setopt($ch,CURLOPT_PROXY,'http://proxy.shr.secureserver.net:3128');
	curl_setopt($ch, CURLOPT_URL, $_GET['u']);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	  // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// curl_exec($ch);
	// $return_response = curl_exec($ch);
	// print_r($return_response);
	if(curl_exec($ch) === false) {
		echo "Error : " . curl_error($ch);
	}


// $ch = curl_init();
// curl_setopt($ch,CURLOPT_VERBOSE,1);
// //curl_setopt($ch,CURLOPT_HTTPPROXYTUNNEL,true);
// curl_setopt($ch,CURLOPT_PROXYTYPE,CURLPROXY_HTTP);
// curl_setopt($ch,CURLOPT_PROXY,'http://proxy.shr.secureserver.net:3128');
// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
// curl_setopt($ch,CURLOPT_URL,$url);
// curl_setopt($ch,CURLOPT_TIMEOUT,120);
// $result = curl_exec($ch);
// curl_close($ch);	
?>