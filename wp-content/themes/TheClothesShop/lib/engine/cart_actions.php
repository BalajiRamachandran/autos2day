<?php
##################################################################################################################################
//												SHOPPING-CART FUNCTIONS																			
##################################################################################################################################

require_once(dirname(__FILE__). '/../../../../../wp-load.php');
// require two files that are included in the wp-admin but not on the front end.  These give you access to some special functions below.
require_once(dirname(__FILE__). "/../../../../../wp-admin/includes/file.php");
require_once(dirname(__FILE__). "/../../../../../wp-admin/includes/image.php");	
require_once(dirname(__FILE__). "/../../../../../wp-admin/includes/media.php");	
require_once(dirname(__FILE__). "/../../../../../wp-admin/includes/template.php");	
require_once(dirname(__FILE__). "/../../../../../wp-includes/media.php");	


// Customer gets a unique identifier 

function get_date_difference($c_date, $p_date) {
	$difference = strtotime($c_date) - strtotime($p_date);
	$years = abs(floor($difference / 31536000));
	return abs(floor(($difference-($years * 31536000))/86400));
}


# Convert an Array to stdClass.
function array_to_object(array $array){
    # Iterate through our array looking for array values.
    # If found recurvisely call itself.
    foreach($array as $key => $value){
        if(is_array($value)){
            $array[$key] = array_to_object($value);
        }
    }
    
    # Typecast to (object) will automatically convert array -> stdClass
    return (object)$array;
}


function create_customer_id(){

	global $OPTION;
	
	if(custid_used_for_order()){  // introduced b'c of Authn Session-Handling
		unset($_SESSION['cust_id']);	
	}

	if(!isset($_SESSION['cust_id'])){	
		$_SESSION['cust_id'] 	= time().'-'.substr(md5(time()),22);
		if(($OPTION['wps_inventory_cleaning_method'] == 'internal')&&($OPTION['wps_track_inventory'] == 'active')&&($OPTION['wps_shop_mode'] == 'Normal shop mode')){
			clean_inventory();
		}
	}
}


function is_dbtable_there($table_name){

	global $wpdb,$CONFIG_WPS;

	$table 			= $wpdb->prefix . $CONFIG_WPS['prefix'] .$table_name;				
	$db_table_num 	= mysql_num_rows(mysql_query("SHOW TABLES LIKE '".$table."'"));
	
	// if table not exist create it	
	if($db_table_num < 1)
	{
		include WP_CONTENT_DIR . '/themes/'.WPSHOP_THEME_NAME.'/lib/db/creation.php';
	}
return $table;
}

function nws_db_query($qStr,$dbh=NULL){

	global $wpdb;

	$resource 	= ($dbh == NULL ? $wpdb->dbh : $dbh);
	$result 	= mysql_query($qStr,$resource);
	
	// Check result, if FALSE then we log the details of error
	if ($result === FALSE) {
		$message  = mysql_errno() .': '. mysql_error() . ' - Query string: ' . $qStr;
		error_log_db('10008000',$message);
	}
	
return $result;
}


function add_toCart(){

	global $OPTION;

	create_customer_id();
		
	$table 	= is_dbtable_there('shopping_cart');
	$table2 = is_dbtable_there('shopping_cart_log');	
	
	if(($_POST['cmd'] == 'add') && ($_POST['amount'] != '0.00')){	
				
		if(!isset($_POST['attrData'])){	// different attribute collection methods - either from several $_POST values or one single combined one... 				
			$item_attributes 	= collect_attributes();
		}
		else{
			$item_attributes 	= collect_attributes(2);
		}
		
		//save any available personalization data
		$personal 			= personalization_chksum();	
		$already_there 		= item_already_there($table,$_POST['item_id'],$item_attributes,$personal,$_SESSION['cust_id']);

		//change.9.9
		// stock control - minus 1 item if enough items on stock, otherwise $stock is overwritten with value 0
		$stock = 1;
		if($OPTION['wps_track_inventory']=='active'){
			$stock = stock_control_deluxe($_POST['item_id'],1,$item_attributes);
		}
		
		if($stock > 0){	
			if($already_there == 0){
			
					// add as new item in table 
					$column_array	= array();
					$value_array	= array();           
						
					$column_array[0]	= 'cid';			$value_array[0]	= '';
					$column_array[1]	= 'item_id';		$value_array[1]	= $_POST['item_id'];
					$column_array[2]	= 'postID';			$value_array[2]	= $_POST['postID'];
					$column_array[3]	= 'item_name';		$value_array[3]	= $_POST['item_name'];
					$column_array[4]	= 'item_amount';	$value_array[4]	= $_POST['item_number'];
					$column_array[5]	= 'item_price';		$value_array[5]	= $_POST['amount'];
					$column_array[6]	= 'item_weight';	$value_array[6]	= $_POST['item_weight'];
					$column_array[7]	= 'item_thumb';		$value_array[7]	= $_POST['image_thumb'];	
					$column_array[8]	= 'item_attributs';	$value_array[8]	= $item_attributes;						
					$column_array[9]	= 'item_personal';	$value_array[9]	= $personal;		
					$column_array[10]	= 'who';			$value_array[10]= $_SESSION['cust_id'];
					$column_array[11]	= 'level';			$value_array[11]= '1';
					
					if(isset($_POST['item_file'])){
					$column_array[12]	= 'item_file';		$value_array[12]	= $_POST['item_file'];
					}
										
					db_insert($table,$column_array, $value_array);	

					//get the inserted ID from table 
					$sql 	= "SELECT cid FROM $table WHERE who = '$_SESSION[cust_id]' ORDER BY cid DESC LIMIT 1";
					$res	= mysql_query($sql);
					$row	= mysql_fetch_assoc($res);
					
					save_personalization($row); 
					
					// for logging
					$column_array	= array();
					$value_array	= array();           
						
					$column_array[0]	= 'cid';			$value_array[0]	= $row['cid'];
					$column_array[1]	= 'item_id';		$value_array[1]	= $_POST['item_id'];
					$column_array[2]	= 'postID';			$value_array[2]	= $_POST['postID'];
					$column_array[3]	= 'item_name';		$value_array[3]	= $_POST['item_name'];
					$column_array[4]	= 'item_amount';	$value_array[4]	= $_POST['item_number'];
					$column_array[5]	= 'item_price';		$value_array[5]	= $_POST['amount'];
					$column_array[6]	= 'item_weight';	$value_array[6]	= $_POST['item_weight'];
					$column_array[7]	= 'item_thumb';		$value_array[7]	= $_POST['image_thumb'];	
					$column_array[8]	= 'item_attributs';	$value_array[8]	= $item_attributes;						
					$column_array[9]	= 'item_personal';	$value_array[9]	= $personal;		
					$column_array[10]	= 'who';			$value_array[10]= $_SESSION['cust_id'];
					$column_array[11]	= 'level';			$value_array[11]= '1';
					
					if(isset($_POST['item_file'])){
					$column_array[12]	= 'item_file';		$value_array[12]	= $_POST['item_file'];
					}
					db_insert($table2,$column_array, $value_array);		
			}
			else {	
				//digital goods : update only if lkeys are activated			
				$qStr77 		= "SELECT item_file FROM $table WHERE item_id = '$_POST[item_id]' AND who = '$_SESSION[cust_id]' LIMIT 0,1";
				$res77 			= mysql_query($qStr77);
				$row			= mysql_fetch_assoc($res77);
				$digital 		= ($row['item_file'] == 'none' ? FALSE : TRUE);
				$digital_ok		= 'positive';
							
				if($digital === TRUE){			
					$license_op 	= $OPTION['wps_l_mode'];				
					if($license_op == 'SIMPLE'){		
						$digital_ok	= 'negative';
					}
				}			

				if($digital_ok == 'positive'){
					// update (item amount)
					$qStr = "UPDATE $table 
									SET item_amount=item_amount+1 
								WHERE 
									item_id = '$_POST[item_id]' AND item_attributs = '$item_attributes' 
									AND item_personal = '$personal'
									AND who = '$_SESSION[cust_id]'";
					mysql_query($qStr);
									
					//for logging
					$qStr = "UPDATE $table2 
									SET item_amount=item_amount+1 
								WHERE 
									item_id = '$_POST[item_id]' AND item_attributs = '$item_attributes' 
									AND item_personal = '$personal'
									AND who = '$_SESSION[cust_id]'";
					mysql_query($qStr);
				}
			}
		}
		//\change.9.9
		// to avoid unitentional reposts
		$_POST 	= array();	
		$url 	= current_page(3);	
		//change.9.9
		if ($OPTION['wps_send_to_view_cart'] ) {
			$url = get_option('home').'?showCart=1&cPage='. $url;
		} else {			
			$url 	= str_replace ('?added=OK&l=cart','',$url);		
			//in case of no add to cart we need message for single product page
			if($stock > 0){
				$url 	.= '?added=OK&l=cart';
			}
			else {
				$url 	.= '?added=NOK&l=cart';
			}
		}
		//\change.9.9
		header('Location: ' . $url);
		exit($url);		
	}	
}


function collect_attributes($option=1,$prefix = 'item_attr_'){

	$output = NULL;
					
	if($option == 1){					
		foreach($_POST as $k => $v){
			if(substr($k,0,10) == $prefix)
			{	
				$parts = explode("_",$k);
				$label = ucwords($parts[2]);
		
				$output .= $label.'='.$v.'#';
			}			
		}
		$attributes = substr($output, 0, -1);
	}
	elseif($option == 2){
	
		$attr 	= trim($_POST[attrData]);
		$attr 	= substr($attr,1);
		$parts 	= explode("#",$attr);
				
		foreach($parts as $v){
			$output .= ucwords($v).'#';
		}
		$attributes = substr($output, 0, -1);		
	}
	elseif($option == 3){
		$attributes = substr($output, 0, -1);
	}
	

return $attributes; 
} 

function display_attributes($raw_attributes,$mode='html'){

	switch($mode){
	
		case 'html':
		
			$attributes	= "";
			
			$parts 		= explode("#",$raw_attributes);
			foreach($parts as $v){
				$attributes .= $v . "<br/>";
			}
			$attributes = str_replace('=',': ',$attributes);		
		
		break;
		
		
		case 'html_be':
		
			$attributes	= "";
			
			$parts 		= explode("#",$raw_attributes);
			foreach($parts as $v){
				$attributes .= $v.'<br/>';
			}
			$attributes = str_replace('=',': ',$attributes);		
		
		break;
		
		
		case 'pdf':
		
			$len = strlen($raw_attributes);
		
			if($len > 0){
				$attributes	= array();		
				
				$parts 		= explode("#",$raw_attributes);		
				foreach($parts as $v){			
					$v 				= str_replace('=',': ',$v);	
					$attributes[] 	= ucwords($v);
				}		
			}
			else{
				$attributes = 'none';
			}
		break;
		
		case 'txt':
		
			$attributes	= '-';
			
			$parts 		= explode("#",$raw_attributes);
			foreach($parts as $v){
				$attributes .= $v.',';
			}
			$attributes = str_replace('=',':',$attributes);		
			$attributes = substr($attributes,0,-1);
			$attributes = $attributes . '-';
		
		break;
	
	}

return $attributes;
}

function item_already_there($table,$item_id,$item_attributes,$personal,$who)
{

	$qStr 	= "SELECT * FROM $table 
					WHERE 
				item_id = '$item_id' AND item_attributs = '$item_attributes' AND item_personal = '$personal' AND who = '$who'
			";	
	$res	= mysql_query($qStr);
	$num 	= mysql_num_rows($res);
	
	if($num > 0){
		$feedback = 1;
	}
	else{
		$feedback = 0;
	}

return $feedback;
}

function db_insert($table_name, $column_array, $value_array){

               $sql_string  = 'INSERT INTO ';
               $sql_string .= "$table_name";
               $sql_string .= ' (';

               	$num_cols = count($column_array);

	               for($i=0; $i<$num_cols; $i++){
				   
						if ($i == ($num_cols-1)){
	                    	$sql_string .= $column_array[$i];
	                    }
                         else{
	                    	$sql_string .= $column_array[$i];
	                    	$sql_string .= ' , ';
	                    }
	               }

               $sql_string .= ')';
               $sql_string .= ' VALUES ';
               $sql_string .= ' ( ';

                $num_vals = count($value_array);

                for($i=0; $i<$num_vals; $i++){
				
					$value_array[$i] = mysql_prep_escape($value_array[$i]);

	                    if ($i == ($num_cols-1)){
						
	                    $sql_string .= "'$value_array[$i]'";

	                    }else{
	                    $sql_string .= "'$value_array[$i]'";
	                    $sql_string .= ' , ';
	                    }
	               }

			$sql_string .= ')';
			
			$result = mysql_query("$sql_string") or die ("<b>A fatal error has occured - 553789</b>");

return $result;
}

function db_update($table_name, $column_value_array, $where_conditions){

          $sql_string = 'UPDATE ';
          $sql_string .= "$table_name ";
          $sql_string .= 'SET ';

          	foreach ($column_value_array as $k => $v){
				
				$v = mysql_prep_escape($v);
				
	            $sql_string .= "$k = '$v'";
	            $sql_string .= ' , ';
	        }

          $sql_string .= 'WHERE ';

          	$num_conditions = count($where_conditions);

          	for ($i = 0, $j = 1; $i < $num_conditions; $i++, $j++){

               	if ($j == $num_conditions){

                    $sql_string .= $where_conditions[$i];

                }else{
	               $sql_string .= $where_conditions[$i];
                    $sql_string .= ' AND ';
                }
	        }

        $sql_string = str_replace(', WHERE', ' WHERE', $sql_string);
		$result1 = mysql_query("$sql_string") or die ("<b>A fatal error has occured - 443789</b>");

		
return $result1;
}

	
function dinfo_opener($key){
	
	$cw = md5(date("W"));
	if($cw == $key){
		$feedback = TRUE;
	}
	else {
		$feedback = FALSE;
	}
	
return $feedback;
}
	
function dinfo_footer($key){
	
	$cw = md5(date("W"));
	if($cw == $key){	
		print_r($_SESSION);
		echo "<br/><br/>";
		print_r($_POST);
	}
}

function get_price($itemID){
	//
	$qStr 	= "SELECT price FROM .... WHERE item_id = '$itemID' LIMIT 1";
	$res 	= mysql_query($qStr);
	$row 	= mysql_fetch_assoc($res);

return $row[price];
}


function show_cart($order=0,$cust_id=0){
	if($cust_id == 0){
		$cust_id = $_SESSION['cust_id'];
	}

	$table 	= is_dbtable_there('shopping_cart');	
	$CART 	= array();
	$qStr 	= "SELECT * FROM $table WHERE who = '$cust_id'";
	
	if(is_array($order)){
	$qStr 			= "SELECT * FROM $table WHERE who = '$order[who]'";
	}
	
	$res 			= mysql_query($qStr);
	$num 			= mysql_num_rows($res);
	
	// remember page visitor came from 
	if((!isset($_GET['orderNow'])) && ($_GET['cPage'] != '0') && (!isset($_POST['update']))){
   
		   if(isset($_GET['cPage'])){
				$_SESSION['cPage'] = $_GET['cPage'];
		   } 
	}

	if($num < 1){
		$CART['status'] 	= 'empty';
	}
	else {
	
		$CART['status']				= 'filled';
		$CART['total_item_num'] 	= 0;
		$CART['total_price'] 		= 0;
		$CART['total_weight'] 		= 0;
		$CART['content'] 			= array();

		$item			= array();
		$i				= 0;
		
		
			while($row = mysql_fetch_assoc($res)) {
					
				$personalize 			=  retrieve_personalization($row['cid']); // Personalization 
								
				$item[$i]['num']		=  $row['item_amount'];
				$item[$i]['price'] 		=  $row['item_price'] * $row['item_amount'];
				$item[$i]['weight'] 	=  $row['item_weight'] * $row['item_amount'];				
				$CART['content'][$i]	=  $row['cid'].'|'.$row['item_amount'].'|'.$row['item_name'].'|'.$row['item_price'];
				$CART['content'][$i]	.= '|'.sprintf("%01.2f",$item[$i]['price']).'|'.$row['item_id'].'|'.$row['item_thumb'];
				$CART['content'][$i]	.= '|'.$row['item_attributs'].'|'.$row['postID'].'|'.$personalize;
				$i++;				
			}	
			
			
			for($a=0;$a<$i;$a++)
			{
				$CART['total_item_num'] 	= $CART['total_item_num'] + $item[$a]['num'];
				$CART['total_weight']		= $CART['total_weight'] + $item[$a]['weight'];
				$CART['total_price'] 		= $CART['total_price'] + $item[$a]['price'];				
			}
			
			$CART['total_price'] = sprintf("%01.2f", $CART['total_price']);
			
		}		
return $CART;
}


function update_cart(){
	global $OPTION;

	$table 			= is_dbtable_there('shopping_cart');
	$table3 		= is_dbtable_there('shopping_cart_log');	
	$stock_feedback = array();
	foreach($_POST as $k => $v){
	
	// Action according to prefix 
	
		// amount		
		$findMe   	= 'amount_';
		$pos 		= strpos($k, $findMe);
	
		if ($pos !== false){

			$parts 	= explode("_",$k);
			
			// in case sb. types in 0 or worse negative amounts - we transform it to 1
			$v = (int) $v;
			if($v < 1){$v = 1;}
			
			// we only update if the amount is an integer and not a null and not a float
			$needle 		= '.';
			$dot_found 		= strpos($v,$needle);
			$dot_found		= ($dot_found === FALSE ? 'no' : 'yes');
			
			// no point in updating the amount of an digital product which has no lkey's 
			$digital_ok		= 'positive';
			$digital 		= is_it_digital('UPDATE-CHECK',$parts[1]);
						
			if($digital === TRUE){			
				$license_op 	= $OPTION['wps_l_mode'];
				
				if($license_op == 'SIMPLE'){		
					$digital_ok	= 'negative';
				}
			}			

			if((is_numeric($v)) && ($v != '0') && ($dot_found == 'no') && ($digital_ok == 'positive')){
			
				$v = (string) $v;	
			
			// stock control
				if($OPTION['wps_track_inventory']=='active'){

					$attr 							= retrieve_attributes($parts[1]);						
					$stock_feedback["$parts[1]"] 	= stock_control_deluxe($parts[1],$v,$attr,'update');
					
						if($stock_feedback["$parts[1]"] === 'OK'){
							$qStr 	= "UPDATE $table SET item_amount='$v' WHERE cid = $parts[1]";
							mysql_query($qStr);
							// for logging
							$qStr 	= "UPDATE $table3 SET item_amount='$v' WHERE cid = $parts[1]";
							mysql_query($qStr);							
							$url_add = NULL;
						}
						else {
								$items = NULL;
						
								foreach($stock_feedback as $k => $v){
								
									if(!empty($v)){
										$items .= $k.'-'.$v.',';
									}
								}
								$url_add 	= '&sw='.substr($items,0,-1);
						}						
				}
				else {
					$qStr 	= "UPDATE $table SET item_amount='$v' WHERE cid = $parts[1]";
					mysql_query($qStr);				
				}
			}			
		}
	
		// remove 
		$findMe   	= 'rm_';
		$pos 		= strpos($k, $findMe);
		
		
		if ($pos !== false) {

			$parts 	= explode("_",$k);
			
			if($OPTION['wps_track_inventory']=='active'){	// stock control
			
				$attr 	= retrieve_attributes($parts[1]);				
				stock_control_deluxe($parts[1],$v,$attr,'remove');
			
			}
			
			$qStr2 	= "DELETE FROM $table WHERE cid='$parts[1]'";
			mysql_query($qStr2); //deleting
			//for logging reasons
			$qStr2 	= "DELETE FROM $table3 WHERE cid='$parts[1]'";
			mysql_query($qStr2); 				
			
			//remove also any existing records in the personalize table
			$table2	= is_dbtable_there('personalize'); 
			$cid	= (int) $parts[1];
			$qStr3 	= "DELETE FROM $table2 WHERE cid = $cid";
			mysql_query($qStr3);
			
		}				
	}
	// redirect to same page + stock control
	$url 	= current_page(3).$url_add;
	if($_GET['updateQty'] == '1'){
	
		if($OPTION['wps_enforce_ssl'] == 'force_ssl'){
			$parts 	= explode("://",get_option('home'));
			$url 	= 'https://'.$parts[1];
		}
		else {
			$url 	= $OPTION['home'];
		}
		$url = $url.'/index.php?orderNow=3'.$url_add;
	}
	header('Location: ' . $url);
	exit(NULL);	
}


function loop_products($CART){

	global $OPTION;
	
	$output	= array();
	$y 		= 0;
	$pids 	= array();
	
	
	switch($_GET['showCart']){
	
	case '1':
	
	foreach($CART[content] as $v){
	
		$details 	= explode("|",$v);
		
		$art_no 		= $details[5];
		$personalize 	= (!empty($details[9]) ? "<br/>".$details[9] : NULL);
					
		$attributes		= NULL;
		$attributes 	= display_attributes($details[7]);		

		$is_digital 	= is_it_digital('CART',$details[0]);
		$digital_label	= ($is_digital === TRUE ? '<span class="cart_digital_product">'.__('Digital product','wpShop').'</span>' : NULL);

		$permalink  = get_permalink(postID);
		
		if ($details[6]) {
			$img_src 	= $details[6];
			
			$img_size 	= $OPTION['wps_ProdRelated_img_size'];
			$des_src 	= $OPTION['upload_path'].'/cache';
			
			$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');    
			$imgURL 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;	
			$thumb_img 	= $imgURL;
		}
			
		$prodID 	= $details[8];
		$pids[]		= $prodID;
		$prod 		= get_post($prodID); 
		$permalink 	= get_permalink($prodID);
		
		// show related products?
		if($OPTION['wps_cartRelatedProds_enable']) {
			
			$resizedImg_src = 'cache';
			
			if($OPTION['wps_blogTags_option']){
				$WPS_taxTerm = $OPTION['wps_term_cart_relatedProds'];
				
				switch($WPS_taxTerm){
					case 'outfit_related':
						$taxTerm = 'outfit';
					break;
					case 'fit_related':
						$taxTerm = 'fit';
					break;
					case 'size_related':
						$taxTerm = 'size';
					break;
					case 'colour_related':
						$taxTerm = 'colour';
					break;
					case 'brand_related':
						$taxTerm = 'brand';
					break;
					case 'selection_related':
						$taxTerm = 'selection';
					break;
					case 'style_related':
						$taxTerm = 'style';
					break;
					case 'price_related':
						$taxTerm = 'price';
					break;
				}
				
				//check to see if the taxonomy exists first
				$taxonomy_exist = taxonomy_exists($taxTerm);
				if($taxonomy_exist) {
					$r_posts  	= NWS_cart_tag_related_posts($prodID,10,$resizedImg_src,$img_size,$taxTerm);
				
				} else {
					echo "<p class='error'>".__('It seems you have checked the option to use Tags for regular Blog Posts under ','wpShop')."<strong>".__('Theme Options > Design > General ','wpShop')."</strong>".__('so you now need to activate (Theme Options > Design > General - "Shop by" Options) one of the other available custom taxonomies and select that from the drop down list under ','wpShop')."<strong>".__('Theme Options > Design > Single Product Pages - Related Products Settings - Alternative Tag Related Products','wpShop')."</strong></p>";
				}
				
			} else {
				$r_posts 	= NWS_cart_tag_related_posts($prodID,10,$resizedImg_src,$img_size);
			}
			
			if (!empty($r_posts[status])) {
				
				if($y == 0){
					$related = $r_posts[IDs];
				}
				else{
					if(!isset($related)){
					  $related = array();
					}

					foreach($r_posts[IDs] as $v){
						array_push($related,$v);
					}									
				}
				$output['related'] 	= $related;
				$output['pids'] 	= $pids;
			}
		}
		
		echo "<tr>";
			if ($details[6]) {
				echo "<td><img src='$thumb_img' alt='$details[2]' /></td>";									
			} else {
				echo "<td><p class='error'>Oops! It seems you forgot to use the image_thumb custom field. Please refer to the instructions provided in 07_product_customFields.pdf</p></td>";	
			}
			echo "		
			<td>
				<dl>
					<dt><h4>$details[2]</h4></dt>"; 
					if($digital_label!='') { echo "<dd>$digital_label</dd>"; }
					echo "
					<dd>$art_no</dd>
					<dd>$attributes $personalize</dd>
					<dd>";
						if($OPTION['wps_shop_mode']=='Inquiry email mode' || $is_digital === TRUE){
						} else {
							echo "<a href='$permalink'>".__('Buy another','wpShop')."</a>";
						}
						if ($_SESSION[user_logged]){
							$url = get_bloginfo('template_directory').'/wishlist_mover.php'; 
							$url .= "?transfer_cart_item=1&cid={$details[0]}";
							$text = str_replace("%w",$OPTION['wps_wishListLink_option'], __('Move to %w','wpShop'));
							echo " <a href='$url'>$text</a>";
						} 
					echo "</dd>
				</dl>
				
			</td>
			<td><input class='text' type='text'  name='amount_{$details[0]}' size='3' maxlength='3' value='$details[1]'/></td>						
			<td>";
				if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($details[3]); 
				if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
				if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
			echo "</td>
			<td>";
				if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($details[4]); 
				//if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
				//if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
			echo "</td>
			<td>";
				if($OPTION['wps_currency_code_enable']) { echo $OPTION['wps_currency_code']; }
				if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
			echo"</td>
			<td><input type='checkbox' name='rm_{$details[0]}' /></td>						
		</tr>";
	$y++;
	}
	break;

	default:
	
		$i  = 0;
		
		foreach($CART[content] as $v){

		$details 	= explode("|",$v);
			
		$art_no 		= $details[5];
		$personalize 	= (!empty($details[9]) ? "<br/>".$details[9] : NULL);

		$attributes		= NULL;
		$attributes 	= display_attributes($details[7]);
		
		$is_digital 	= is_it_digital('CART',$details[0]);			
		$digital_label	= ($is_digital === TRUE ? '<span class="cart_digital_product">'.__('Digital Product','wpShop').'</span>' : NULL);

		if ($details[6]) {
			$img_src 	= $details[6];
			
			$img_size 	= $OPTION['wps_ProdRelated_img_size'];
			$des_src 	= $OPTION['upload_path'].'/cache';
			
			$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');    
			$imgURL 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;	
			$thumb_img 	= $imgURL;
		}
		
		$prodID 	= $details[8];
		$permalink 	= get_permalink($prodID);

		echo "<tr>";
			if ($details[6]) {
				echo "<td><img src='$thumb_img' alt='$details[2]' /></td>";									
			} else {
				echo "<td><p class='error'>Oops! It seems you forgot to use the image_thumb custom field. Please refer to the instructions provided in 07_product_customFields.pdf</p></td>";	
			}
			echo "					
			<td>
				<dl>
					<dt><h4>$details[2]</h4></dt>"; 
					if($digital_label!='') { echo "<dd>$digital_label</dd>"; }
					echo "
					<dd>$art_no</dd>
					<dd>$attributes $personalize</dd>
					<dd>";
						
						if ($_SESSION[user_logged]){
							$url = get_bloginfo('template_directory') . '/wishlist_mover.php'; 
							$url .= "?transfer_cart_item=1&cid={$details[0]}";
							$text = str_replace("%w",$OPTION['wps_wishListLink_option'], __('Move to %w','wpShop'));
							echo " <a href='$url'>$text</a>";
						} 
					echo "</dd>
				</dl>
			</td>
			
			<!--<td>$details[1]</td>-->
			<td>
				<form name='Quantity' id='qForm-{$i}' action='index.php?showCart=1&updateQty=1' method='post'>
				<input class='text' type='text' name='amount_{$details[0]}'  size='3' maxlength='3' 
				value='$details[1]'/>
				<span class='formbutton step3_edit step3_editQ' onClick = 'submitNewQty({$i})'>".__('UPDATE','wpShop')."</span>
				<input type='hidden' name='update' value='1'/>
				</form></td>	
			<td>";
				if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($details[3]); 
				if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
				if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
			echo "</td>
			<td class='txt_right'>";
				if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($details[4]); 
				if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; }  
				if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; }
			echo "</td>
		</tr>";
		$i++;
		}
		$output = 'step3';
	break;
	}
	
return $output;
}

function cid2item_id($cid){

	$cid 	= (int) $cid;
	$table 	= is_dbtable_there('shopping_cart');
	$qStr 	= "SELECT item_id FROM $table WHERE cid = $cid LIMIT 0,1";
	$res 	= mysql_query($qStr);
	$row	= mysql_fetch_assoc($res);
	$item_id= $row[item_id];

return $item_id;
}

function get_delivery_options($d_labels,$dpch='none'){
	global $OPTION;

	$oStr 		= $OPTION['wps_delivery_options'];
	$d_options 	= explode("|",$oStr);
	$result		= NULL;
	$a 			= 1;
		foreach($d_options as $v){
		
			switch($v){
			
				case 'pickup':
					$label 		= $d_labels[pickup];
					$checked	= ($dpch['d_option'] == 'pickup' ? 'checked="checked"' : NULL);
				break; 
				
				case 'post':
					$label 		= $d_labels[post];
					$checked	= ($dpch['d_option'] == 'post' ? 'checked="checked"' : NULL);
				break; 				
				/*
				case 'email':
					$label 		= $d_labels[email];
					$checked	= ($dpch['d_option'] == 'email' ? 'checked="checked"' : NULL);
				break;
				*/
				/*				
				case 'post2':
					$label 		= $d_labels[post2];
					$checked	= ($dpch['d_option'] == 'post2' ? 'checked="checked"' : NULL);
				break;
				case 'post3':
					$label 		= $d_labels[post3];
					$checked	= ($dpch['d_option'] == 'post3' ? 'checked="checked"' : NULL);
				break;
				case 'post4':
					$label 		= $d_labels[post4];
					$checked	= ($dpch['d_option'] == 'post4' ? 'checked="checked"' : NULL);
				break;
				*/
			
			}

			// in case none was chosen yet
			if($dpch == 'none'){
				$checked = 'checked="checked"';
			}
			
		$result .= "<input id='dOpt$a' type='radio' name='d_option' value='$v' $checked /><label for='dOpt$a'>$label</label><br/>";
		$a++;
		}	
	
	
return $result;
}

function get_payment_options($p_labels,$p_alt,$p_file_type,$dpch='none'){
	global $OPTION;

	$oStr 		= $OPTION['wps_payment_options'];
	$p_options 	= explode("|",$oStr);
	$result		= NULL;
	$a 			= 1;
	
	if(($dpch == 'none')&&(get_option('wps_payment_op_preselected')!== 'none')){
		$dpch				= array();
		if(in_array(get_option('wps_payment_op_preselected'),$p_options) === TRUE){
			$dpch['p_option'] 	= get_option('wps_payment_op_preselected');
		}
		else {
			$dpch = 'none';
		}
	}
	
		foreach($p_options as $v){
		
			switch($v){
			
				case 'paypal':
					$label 		= $p_labels[paypal];
					$checked	= ($dpch['p_option'] == 'paypal' ? 'checked="checked"' : NULL);
					$alt		= $p_alt[paypal];
					$src		= NWS_bloginfo('stylesheet_directory').'/images/payment/pps.'.$p_file_type;	
				break;

				case 'paypal_pro':
					$label 		= $p_labels[paypal_pro];
					$checked	= ($dpch['p_option'] == 'paypal_pro' ? 'checked="checked"' : NULL);
					$alt		= $p_alt[paypal_pro];
					$src		= NWS_bloginfo('stylesheet_directory').'/images/payment/ppp.'.$p_file_type;
				break;

				case 'cc_authn':
					$label 		= $p_labels[cc_authn];
					$checked	= ($dpch['p_option'] == 'cc_authn' ? 'checked="checked"' : NULL);
					$alt		= $p_alt[cc_authn];
					$src		= NWS_bloginfo('stylesheet_directory').'/images/payment/authorize.'.$p_file_type;	
				break;	
				
				case 'cc_wp':
					$label 		= $p_labels[cc_wp];
					$checked	= ($dpch['p_option'] == 'cc_wp' ? 'checked="checked"' : NULL);
					$alt		= $p_alt[cc_wp];
					$src		= NWS_bloginfo('stylesheet_directory').'/images/payment/worldpay.'.$p_file_type;	
				break;				
				
				case 'transfer':
					$label 		= $p_labels[transfer];
					$checked	= ($dpch['p_option'] == 'transfer' ? 'checked="checked"' : NULL);
					$alt		= $p_alt[transfer];
					$src		= NWS_bloginfo('stylesheet_directory').'/images/payment/bt.'.$p_file_type;
				break; 
				
				case 'cash':
					$label 		= $p_labels[cash];
					$checked	= ($dpch['p_option'] == 'cash' ? 'checked="checked"' : NULL);
					$alt		= $p_alt[cash];
					$src		= NWS_bloginfo('stylesheet_directory').'/images/payment/col.'.$p_file_type;		
				break;	

				case 'cod':
					$label 		= $p_labels[cod];
					$checked	= ($dpch['p_option'] == 'cod' ? 'checked="checked"' : NULL);
					$alt		= $p_alt[cod];
					$src		= NWS_bloginfo('stylesheet_directory').'/images/payment/cod.'.$p_file_type;		
				break;					
			}
		
			// in case none was chosen yet
			if($dpch == 'none'){
				$checked = 'checked="checked"';
			}
		
		$result .= "<label title='$label' for='pOpt$a'><input id='pOpt$a' type='radio' name='p_option' value='$v' $checked /><img src='$src' alt='$alt'/><span>$label</span></label>";
		$a++;
		}	
	
	
return $result;		
}

function delivery_payment_chosen(){

	$output	= array();

	$table 	= is_dbtable_there('orders');
	$sql 	= "SELECT d_option,p_option FROM $table WHERE who = '$_SESSION[cust_id]' LIMIT 0,1";
	$res	= mysql_query($sql);
	$row	= mysql_fetch_assoc($res);
	
	$output['d_option'] = $row['d_option'];
	$output['p_option'] = $row['p_option'];
	
return $output; 
}

function process_order($step = 1) // function manages also inquiries
{
	global $OPTION;								
	$VOUCHER = load_what_is_needed('voucher');	

	if($OPTION['wps_shop_mode']=='Inquiry email mode'){
		$table = is_dbtable_there('inquiries');
	}
	else{
		$table = is_dbtable_there('orders');
	}	
		$table2 = is_dbtable_there('delivery_addr');	

	switch($step){
	
		case 1: 

			// add delivery + payment option to orders table  - check also for dublicates 
			$order_there = order_exists($table);
			
			if($order_there == 0){
				$column_array	= array();
				$value_array	= array();           
										
				$column_array[0]	= 'oid';			$value_array[0]	= '';
				$column_array[1]	= 'who';			$value_array[1]	= "$_SESSION[cust_id]";				
				$column_array[2]	= 'd_option';		$value_array[2]	= "$_POST[d_option]";
				$column_array[3]	= 'p_option';		$value_array[3]	= "$_POST[p_option]";
				if(isset($_POST[country])){
					$column_array[4]	= 'country';		$value_array[4]	= "$_POST[country]";
				}	
				
				// does voucher code exist? - AJAX is user friendly, but we don't rely on it				
				$v_result 	= $VOUCHER->voucher_is_ok(); 
				
				if($v_result['erg'] == 1)
				{					
						$CART 	= show_cart($order);
						$row 	= mysql_fetch_assoc($v_result['res']);
						
						$camount	= (float) $CART['total_price'];
						$vamount 	= (float) $row['vamount'];
						
						if($row['voption'] == 'P'){
							$calc 		= $camount / 100;
							$vamount 	= $calc * $vamount;
						}
						
						if($vamount < $camount){
							array_push($column_array,'voucher');
							array_push($value_array,trim($_POST['v_no']));
						}
				}			
				db_insert($table, $column_array, $value_array);
			
				// add record in delivery address table
				$column_array	= array();
				$value_array	= array();   
				$column_array[0]	= 'aid';			$value_array[0]	= '';
				$column_array[1]	= 'who';			$value_array[1]	= "$_SESSION[cust_id]";					
				
				db_insert($table2, $column_array, $value_array);
				
				$_POST = array(); // in case user uses back button of browser
			}
			else{			
				if(isset($_POST[step1])){
				
					$column_value_array 	= array();
					$where_conditions 		= array();
						
					$column_value_array[d_option] 	= "$_POST[d_option]";
					$column_value_array[p_option] 	= "$_POST[p_option]";
					if(isset($_POST[country])){
						$column_value_array[country] 	= "$_POST[country]";
					}
						
					$where_conditions[0]			= "who = '$_SESSION[cust_id]'";
											
					db_update($table, $column_value_array, $where_conditions);	
				}
			}			
			break;
			
			// show the name + address form 
			case 2:
					// update orders table
					$column_value_array 	= array();
					$where_conditions 		= array();
					
					if($_POST['saveWhat'] == 'editNote'){
							$column_value_array[custom_note]= $_POST[custom_note];
					} else {
					
							$column_value_array[l_name] 	= $_POST[l_name];
							$column_value_array[f_name] 	= $_POST[f_name];
							$column_value_array[street] 	= $_POST[street];
							$column_value_array[hsno] 		= $_POST[hsno];
							$column_value_array[strno] 		= $_POST[strno];
							$column_value_array[strnam]		= $_POST[strnam];
							$column_value_array[po] 		= $_POST[po];
							$column_value_array[pb] 		= $_POST[pb];
							$column_value_array[pzone] 		= $_POST[pzone];
							$column_value_array[crossstr] 	= $_POST[crossstr];
							$column_value_array[colonyn] 	= $_POST[colonyn];
							$column_value_array[district] 	= $_POST[district];
							$column_value_array[region] 	= $_POST[region];
							$column_value_array[state] 		= $_POST[state];
							$column_value_array[zip] 		= $_POST[zip];
							$column_value_array[town] 		= $_POST[town];
							$column_value_array[country]	= $_POST[country];
							$column_value_array[email] 		= $_POST[email];
							$column_value_array[telephone] 	= $_POST[telephone];
							if($_POST['saveWhat'] != 'editAddress'){
							$column_value_array[custom_note]= $_POST[custom_note];
							}
							$column_value_array[level] 		= '2';
							
							if($_POST[delivery_address_yes] == 'on'){
							$column_value_array[d_addr]		= '1';
							}
					}
	
					$where_conditions[0]			= "who = '$_SESSION[cust_id]'";
										
					db_update($table, $column_value_array, $where_conditions);
					
					
					 
					// update delivery address table
					if($_POST['saveWhat'] != 'editNote'){
						$column_value_array 	= array();
						$where_conditions 		= array();
						
						$column_value_array[l_name] 	= $_POST['l_name|2'];
						$column_value_array[f_name] 	= $_POST['f_name|2'];
						$column_value_array[street] 	= $_POST['street|2'];
						$column_value_array[hsno] 		= $_POST['hsno|2'];
						$column_value_array[strno] 		= $_POST['strno|2'];
						$column_value_array[strnam]		= $_POST['strnam|2'];
						$column_value_array[po] 		= $_POST['po|2'];
						$column_value_array[pb] 		= $_POST['pb|2'];
						$column_value_array[pzone] 		= $_POST['pzone|2'];
						$column_value_array[crossstr] 	= $_POST['crossstr|2'];
						$column_value_array[colonyn] 	= $_POST['colonyn|2'];
						$column_value_array[district] 	= $_POST['district|2'];
						$column_value_array[region] 	= $_POST['region|2'];
						$column_value_array[state] 		= $_POST['state|2'];
						$column_value_array[zip] 		= $_POST['zip|2'];
						$column_value_array[town] 		= $_POST['town|2'];
						$column_value_array[country]	= $_POST['country|2'];
						$column_value_array[level] 		= '2';
		
						$where_conditions[0]			= "who = '$_SESSION[cust_id]'";			
											
						db_update($table2, $column_value_array, $where_conditions);
					}
			break;
		
	
			case 3:
			
				if($_GET[dpchange] == 1){

				// update orders table - add address data 
					$column_value_array 	= array();
					$where_conditions 		= array();
										
					if(isset($_POST['saveWhat'])){
						switch($_POST['saveWhat']){
							case 'editDelivery':
								$column_value_array[d_option] 	= $_POST[d_option];							
							break;
							case 'editPayment':
								$column_value_array[p_option] 	= $_POST[p_option];							
							break;
						}
						
					} else {
					
						$column_value_array[d_option] 	= $_POST[d_option];
						$column_value_array[p_option] 	= $_POST[p_option];
					}
					
					
						$where_conditions[0]			= "who = '$_SESSION[cust_id]'";
										
					db_update($table, $column_value_array, $where_conditions);								
				}
			
			
				// display final summary 
				$qStr 	= "SELECT * FROM $table WHERE who = '$_SESSION[cust_id]' LIMIT 1";
				$res 	= mysql_query($qStr);
				$row 	= mysql_fetch_assoc($res);
				
			
				$feedback = $row;	
			
			break;
		
		
		case 4:		
		break; 
		
		case 5:		
		break; 
	}
	

return $feedback;	
}

function order_exists($table){

	$qStr 	= "SELECT oid FROM $table WHERE who = '$_SESSION[cust_id]'";
	$res 	= mysql_query($qStr);
	$num 	= mysql_num_rows($res);

	if($num < 1){
		$feedback = 0;
	}
	else {
		$feedback = 1;
	}
	
return $feedback;
}

function address_form_labels(){

		$LANG 						= array();

		$LANG[lastname] 			= __('Last Name','wpShop');
		$LANG[firstname] 			= __('First Name','wpShop');
		$LANG[street_hsno] 			= __('Address','wpShop');
		$LANG[street]				= __('Street','wpShop');
		$LANG[hsno]					= __('House No.','wpShop');
		$LANG[strno]				= __('Street No.','wpShop');
		$LANG[strnam]				= __('Street Name','wpShop');
		$LANG[po]					= __('Post Office','wpShop');
		$LANG[pb]					= __('Post Box','wpShop');
		$LANG[pzone]				= __('Postal Zone','wpShop');
		$LANG[crossstr]				= __('Cross Streets','wpShop');
		$LANG[colonyn]				= __('Colony name','wpShop');
		$LANG[district]				= __('District','wpShop');		
		$LANG[region]				= __('Region','wpShop');			
		$LANG[island]				= __('Island','wpShop');		
		$LANG[state_province] 		= __('State/Province','wpShop'); 
		$LANG[zip] 					= __('Postcode','wpShop');
		$LANG[town]					= __('City','wpShop');
		$LANG[country]				= __('Country','wpShop');
		$LANG[email]				= __('Email','wpShop');
		$LANG[terms]				= __('Terms &amp; Conditions:','wpShop');
		$LANG[accept_terms]			= __('I accept the Terms &amp; Conditions of','wpShop');
		$LANG[next_step] 			= __('Next Step','wpShop');		
		$LANG[field_not_empty]		= __(' - Field cannot be Empty.','wpShop');	
		$LANG[format_email]			= __('The Format of your Email Address is not Correct.','wpShop');	
		$LANG[terms_need_accepted]	= __('Terms need to be Accepted.','wpShop');

return $LANG;
}


function create_address_form($option = 'billing',$only_one_c = 'no'){	
	
	$LANG = address_form_labels();

	// different form according to address rules of delivery country - if shop country country is only country, use this one
	if($only_one_c !== 'no'){
		$d_country = $only_one_c;
	}
	else {
		$d_country 	= trim($_GET['country']);
	}
	$ad	= get_address_format($d_country,'filter');
	
	if($option == 'billing'){
		// loop thru address fields and produce input fields accordingly
		foreach($ad as $v){
		
			if($v == 'street'){
				echo "<label for='street_hsno'>$LANG[street_hsno]:</label><input id='street_hsno' type='text' name='street' value='$_POST[street]'
				maxlength='255' /><br/>";
			}
			if($v == 'hsno'){
				echo "<label for='hsno'>$LANG[hsno]:</label><input id='hsno' type='text' name='hsno' value='$_POST[hsno]' maxlength='255' /><br/>";
			}					
			if($v == 'strnam'){
				echo "<label for='strnam'>$LANG[strnam]:</label><input id='strnam' type='text' name='strnam' value='$_POST[strnam]' maxlength='255' /><br/>";
			}	
			if($v == 'strno'){
				echo "<label for='strno'>$LANG[strno]:</label><input id='strno' type='text' name='strno' value='$_POST[strno]' maxlength='255' /><br/>";
			}				
			if($v == 'po'){
				echo "<label for='po'>$LANG[po]:</label><input id='po' type='text' name='po' value='$_POST[po]' maxlength='255' /><br/>";
			}				
			if($v == 'pb'){
				echo "<label for='pb'>$LANG[pb]:</label><input id='pb' type='text' name='pb' value='$_POST[pb]' maxlength='255' /><br/>";
			}				
			if($v == 'pzone'){
				echo "<label for='pzone'>$LANG[pzone]:</label><input id='pzone' type='text' name='pzone' value='$_POST[pzone]' maxlength='255' /><br/>";
			}				
			if($v == 'crossstr'){
				echo "<label for='crossstr'>$LANG[crossstr]:</label><input id='crossstr' type='text' name='crossstr' value='$_POST[crossstr]' maxlength='255' /><br/>";
			}				         
			if($v == 'colonyn'){
				echo "<label for='colonyn'>$LANG[colonyn]:</label><input id='colonyn' type='text' name='colonyn' value='$_POST[colonyn]' maxlength='255' /><br/>";
			}                    
			if($v == 'district'){
				echo "<label for='district'>$LANG[district]:</label><input id='district' type='text' name='district' value='$_POST[district]' maxlength='255' /><br/>";
			}				
			if($v == 'region'){
				echo "<label for='region'>$LANG[region]:</label><input id='region' type='text' name='region' value='$_POST[region]' maxlength='255' /><br/>";
			}                          
			if($v == 'state'){

				echo "<label for='state'>$LANG[state_province]:</label>"; 

				$ct 	= get_countries(3,$d_country);						
				if(display_state_list($ct)){
					echo province_me($ct,$_POST['state']);						
				}			
				else {
					echo "<input  id='state' type='text' name='state' value='$_POST[state]' maxlength='255' /><br>";
				}								
			}
			if($v == 'zip'){
					echo "<label for='zip'>$LANG[zip]:</label><input  id='zip' type='text' name='zip' value='$_POST[zip]' maxlength='255' /><br/>";
			}	
			if($v == 'place'){
					echo "<label for='town'>$LANG[town]:</label><input  id='town' type='text' name='town' value='$_POST[town]' maxlength='255' /><br/>";
			}			
		}
	}
	

	if($option == 'shipping'){
		// loop thru address fields and produce input fields accordingly 
		foreach($ad as $v){		
			
			if($v == 'street'){
					echo "<label for='dstreet_hsno'>$LANG[street_hsno]:</label><input id='dstreet_hsno' type='text' name='street|2' value='".$_POST['street|2']."' maxlength='255' /><br/>";
			}
			if($v == 'hsno'){
					echo "<label for='dhsno'>$LANG[hsno]:</label><input id='dhsno' type='text' name='hsno|2' value='".$_POST['hsno|2']."' maxlength='255' /><br/>";
			}					
			if($v == 'strnam'){
					echo "<label for='dstrnam'>$LANG[strnam]:</label><input id='dstrnam' type='text' name='strnam|2' value='".$_POST['strnam|2']."' maxlength='255' /><br/>";
			}	
			if($v == 'strno'){
					echo "<label for='dstrno'>$LANG[strno]:</label><input id='dstrno' type='text' name='strno|2' value='".$_POST['strno|2']."' maxlength='255' /><br/>";
			}				
			if($v == 'po'){
					echo "<label for='dpo'>$LANG[po]:</label><input id='dpo' type='text' name='po|2' value='".$_POST['po|2']."' maxlength='255' /><br/>";
			}				
			if($v == 'pb'){
					echo "<label for='dpb'>$LANG[pb]:</label><input id='dpb' type='text' name='pb|2' value='".$_POST['pb|2']."' maxlength='255' /><br/>";
			}				
			if($v == 'pzone'){
					echo "<label for='dpzone'>$LANG[pzone]:</label><input id='dpzone' type='text' name='pzone|2' value='".$_POST['pzone|2']."' maxlength='255' /><br/>";
			}				
			if($v == 'crossstr'){
					echo "<label for='dcrossstr'>$LANG[crossstr]:</label><input id='dcrossstr' type='text' name='crossstr|2' value='".$_POST['crossstr|2']."' maxlength='255' /><br/>";
			}				         
			if($v == 'colonyn'){
					echo "<label for='dcolonyn'>$LANG[colonyn]:</label><input id='dcolonyn' type='text' name='colonyn|2' value='".$_POST['colonyn|2']."' maxlength='255' /><br/>";
			}                    
			if($v == 'district'){
					echo "<label for='ddistrict'>$LANG[district]:</label><input id='ddistrict' type='text' name='district|2' value='".$_POST['district|2']."' maxlength='255' /><br/>";
			}				
			if($v == 'region'){
					echo "<label for='dregion'>$LANG[region]:</label><input id='dregion' type='text' name='region|2' value='".$_POST['region|2']."' maxlength='255' /><br/>";
			}                          
			if($v == 'state'){

				echo "<label for='dstate'>$LANG[state_province]:</label>"; 	
				
				$ct 	= get_countries(3,$d_country);						
				if(display_state_list($ct)){
					echo province_me($ct,$_POST['state|2'],'delivery');						
				}			
				else {
					echo "<input id='dstate' type='text' name='state|2' value='".$_POST['state|2']."' maxlength='255' /><br>";
				}	
					
			}
			if($v == 'zip'){
					echo "<label for='dzip'>$LANG[zip]:</label><input id='dzip' type='text' name='zip|2' value='".$_POST['zip|2']."' maxlength='255' /><br/>";
			}	
			if($v == 'place'){
					echo "<label for='dtown'>$LANG[town]:</label><input id='dtown' type='text' name='town|2' value='".$_POST['town|2']."' maxlength='255' /><br/>";
			}	
		}
	}
}

function check_address_form(){
	global $LANG;

			// verify data from address form 
			$feedback 				= array();
			$feedback[e_message]	= NULL;		
			$feedback[e_message2]	= NULL;			
			$feedback[error]		= 0;
			
			// Labels for field
			$labels = array();
			$labels[l_name] 	= $LANG[lastname];
			$labels[f_name] 	= $LANG[firstname];
			$labels[street] 	= $LANG[street];
			
			$labels[hsno] 		= $LANG[hsno];
			$labels[strno] 		= $LANG[strno];			
			$labels[strnam] 	= $LANG[strnam];			
			$labels[po] 		= $LANG[po];			
			$labels[pb] 		= $LANG[pb];	
			$labels[pzone] 		= $LANG[pzone];				
			$labels[crossstr] 	= $LANG[crossstr];
			$labels[colonyn] 	= $LANG[colonyn];	
			$labels[district] 	= $LANG[district];
			$labels[region] 	= $LANG[region];
	
			$labels[state]  	= $LANG[state_province];
			$labels[zip] 		= $LANG[zip];
			$labels[town] 		= $LANG[town];
			$labels[email] 		= $LANG[email];
			$labels[telephone]	= $LANG[telephone];
			
			$_POST[step2]		= TRUE; // actually a fix, if designer removes value from submit button
				
			
			// delete fields from $_POST array which shouldn't be checked
			unset($_POST['v_no']);
			$tmp = $_POST['custom_note']; 
			unset($_POST['custom_note']);
			unset($_POST['step1']);
			
			if(!isset($_POST['delivery_address_yes'])){
				unset($_POST['f_name|2']);
				unset($_POST['l_name|2']);
				unset($_POST['country|2']);
				unset($_POST['street|2']);
				unset($_POST['hsno|2']);
				unset($_POST['strnam|2']);
				unset($_POST['strno|2']);
				unset($_POST['po|2']);
				unset($_POST['pb|2']);
				unset($_POST['pzone|2']);
				unset($_POST['crossstr|2']);
				unset($_POST['colonyn|2']);
				unset($_POST['district|2']);
				unset($_POST['region|2']);
				unset($_POST['state|2']);
				unset($_POST['zip|2']);
				unset($_POST['place|2']);
				unset($_POST['town|2']);
			}	
			
			// were countries chosen?
			if($_POST['country'] == 'bc'){
				$feedback[e_message] .= "<span class='error'>$LANG[choose_billing_c]</span><br/>";  	
				$feedback['error'] 	= 1;
			}
			if($_POST['country|2'] == 'dc'){
				$feedback[e_message2] .= "<span class='error'>$LANG[choose_delivery_c]</span><br/>";  			
			}			
			
			//which variables should be in the post array (based on the country)?		
			$table			= is_dbtable_there('countries');
			$country_col 	= 'country';
			if(WPLANG == 'de_DE'){$country_col = 'de';}
			if(WPLANG == 'fr_FR'){$country_col = 'fr';}
			
			$qStr 	= "SELECT address_format FROM $table WHERE $country_col = '$_POST[country]' LIMIT 0,1";
			$res 	= mysql_query($qStr);
			$row 	= mysql_fetch_assoc($res);
			
			$address_format = str_replace('#',NULL,$row['address_format']);		
			$address_format = str_replace('%PLACE%','%TOWN%',$address_format);
			$address_format = str_replace('%place%','%town%',$address_format);
			$address_format = str_replace('name',NULL,$address_format);
			$address_format = str_replace('NAME',NULL,$address_format);
			
			$address_format = str_replace('(',NULL,$address_format);
			$address_format = str_replace(')',NULL,$address_format);
			$pAddress 		= explode('%',$address_format);
			
			$array['error'] = 0;
			
			for($i=0;$i<10;$i++){
				if((strlen($pAddress[$i]) > 1)&&(array_key_exists(strtolower($pAddress[$i]),$_POST) === FALSE)){
					$array['error'] = 1;
					$abc 			= $pAddress[$i];
				}	
			}
			if($array['error'] == 1 ){
				$feedback[error] 		= 1;
				$feedback[e_message] 	.= "<span class='error'>$LANG[wait_for_field] $LANG[refresh_and_wait]</span><br/>"; 	
			}
			
			// Any fields empty?
			foreach($_POST as $k => $v){

				$_POST[$k] = strip_tags($v); // HTML tags are removed - if any 
						
				if(substr($k,-2) !== '|2'){
				
					if($v == ''){
						$feedback[e_message] .= "<span class='error'>$labels[$k] $LANG[field_not_empty]</span><br/>";  
						$feedback[error] = 1;	
					}				
				}
				else{				
									
					if($v == ''){
						$k = substr($k,0,-2);
						$feedback[e_message2] .= "<span class='error'>$labels[$k] $LANG[field_not_empty]</span><br/>";  
						$feedback[error] = 1;	
					}				
				}			
			}
			
			
			// Format of email ok?
			if(isset($_POST[email])){
			$em_ok = NWS_validate_email($_POST[email]);
				if($em_ok == FALSE){
				
					$feedback[e_message] .= "<span class='error'>$LANG[format_email]</span><br/>";  
					$feedback[error] = 1;	
				}
			}
			
			// were the terms accepted? 
			$accepted = terms_accepted();
			if($accepted == FALSE){
					$feedback[e_message] .= "<span class='error' id='errorTermsaccepted'>$LANG[terms_need_accepted]</span><br/>";  
					$feedback[error] = 1;							
			}

			
			$_POST['custom_note'] = htmlspecialchars(strip_tags($tmp),ENT_QUOTES); 
			
return $feedback;
}

function redisplay_address_form($option = 'billing'){

	global $LANG;
	
	if($option == 'billing'){
	
		// different form according to address rules of delivery country
		$d_country 	= trim($_POST['country']);	
		$ad			= get_address_format($d_country,'filter');
	
		// loop thru address fields and produce input fields accordingly
		foreach($ad as $v){
			if($v == 'street'){				
				echo "<label for='street_hsno'>$LANG[street_hsno]:</label><input id='street_hsno' type='text' 
				name='street' value='$_POST[street]' maxlength='255' /><br/>";
			}	
			if($v == 'hsno'){
				echo "<label for='hsno'>$LANG[hsno]:</label><input id='hsno' type='text' name='hsno' value='$_POST[hsno]' 
				maxlength='255' /><br/>";				
			}	
			if($v == 'strnam'){
				echo "<label for='strnam'>$LANG[strnam]:</label><input id='strnam' type='text' name='strnam' 
				value='$_POST[strnam]' maxlength='255' /><br/>";
			}
			if($v == 'strno'){
				echo "<label for='strno'>$LANG[strno]:</label><input id='strno' type='text' name='strno' 
				value='$_POST[strno]' maxlength='255' /><br/>";
			}
			if($v == 'po'){
				echo "<label for='strno'>$LANG[strno]:</label><input id='strno' type='text' name='strno' value='$_POST[strno]' 
				maxlength='255' /><br/>";
			}
			if($v == 'pb'){
				echo "<label for='pb'>$LANG[pb]:</label><input id='pb' type='text' name='pb' value='$_POST[pb]' maxlength='255' /><br/>";
			}
			if($v == 'pzone'){
				echo "<label for='pzone'>$LANG[pzone]:</label><input id='pzone' type='text' name='pzone' 
				value='$_POST[pzone]' maxlength='255' /><br/>";				
			}
			if($v == 'crossstr'){
				echo "<label for='crossstr'>$LANG[crossstr]:</label><input id='crossstr' type='text' 
				name='crossstr' value='$_POST[crossstr]' maxlength='255' /><br/>";
			}
			if($v == 'colonyn'){
				echo "<label for='colonyn'>$LANG[colonyn]:</label><input id='colonyn' type='text' name='colonyn' 
				value='$_POST[colonyn]' maxlength='255' /><br/>";
			}
			if($v == 'district'){
				echo "<label for='district'>$LANG[district]:</label><input id='district' type='text' name='district' 
				value='$_POST[district]' maxlength='255' /><br/>";
			}
			if($v == 'region'){
				echo "<label for='region'>$LANG[region]:</label><input id='region' type='text' name='region' 
				value='$_POST[region]' maxlength='255' /><br/>";
			}
			if($v == 'state'){
					echo "<label for='state'>$LANG[state_province]:</label>"; 

					$ct 	= get_countries(3,$_POST['country']);						
					if(display_state_list($ct)){
						echo province_me($ct,$_POST['state']);						
					}			
					else {
						echo "<input  id='state' type='text' name='state' value='$_POST[state]' maxlength='255' /><br>";
					}
			}
			if($v == 'zip'){
				echo "<label for='zip'>$LANG[zip]:</label><input  id='zip' type='text' name='zip' 
				value='$_POST[zip]' maxlength='255' /><br/>";				
			}
			if($v == 'place'){
				echo "<label for='town'>$LANG[town]:</label><input  id='town' type='text' name='town' 
				value='$_POST[town]' maxlength='255' /><br/>";				
			}

		}
		
			if(isset($_POST['email'])){
				echo "<label for='email'>$LANG[email]:</label><input  id='email'type='text' name='email' 
				value='$_POST[email]' maxlength='255' /><br/>";
			}
		
			if(isset($_POST['telephone'])){
				echo "<label for='telephone'>$LANG[telephone]:</label><input id='telephone' type='text' name='telephone' 
				value='$_POST[telephone]' maxlength='255' /><br/>";
			}
	}
	
	
	if($option == 'shipping'){
	
		// different form according to address rules of shipping country
		$d_country 	= trim($_POST['country|2']);	
		$ad			= get_address_format($d_country,'filter');
	
	// loop thru address fields and produce input fields accordingly
		foreach($ad as $v){	
		
			if($v == 'street'){
				echo "<label for='dstreet_hsno'>$LANG[street_hsno]:</label><input id='dstreet_hsno' type='text' 
				name='street|2' value='".$_POST['street|2']."' maxlength='255' /><br/>";
			}	
			if($v == 'hsno'){
				echo "<label for='dhsno'>$LANG[hsno]:</label><input id='dhsno' type='text' name='hsno|2' 
				value='".$_POST['hsno|2']."' maxlength='255' /><br/>";				
			}	
			if($v == 'strnam'){
				echo "<label for='dstrnam'>$LANG[strnam]:</label><input id='dstrnam' type='text' 
				name='strnam|2' value='".$_POST['strnam|2']."' maxlength='255' /><br/>";
			}
			if($v == 'strno'){
				echo "<label for='dstrno'>$LANG[strno]:</label><input id='dstrno' type='text' name='strno|2' 
				value='".$_POST['strno|2']."' maxlength='255' /><br/>";
			}
			if($v == 'po'){
				echo "<label for='dpo'>$LANG[po]:</label><input id='dpo' type='text' name='po|2' 
				value='".$_POST['po|2']."' maxlength='255' /><br/>";
			}
			if($v == 'pb|2'){
				echo "<label for='dpb'>$LANG[pb]:</label><input id='dpb' type='text' name='pb|2' 
				value='".$_POST['pb|2']."' maxlength='255' /><br/>";
			}
			if($v == 'pzone'){
				echo "<label for='dpzone'>$LANG[pzone]:</label><input id='dpzone' type='text' name='pzone|2' 
				value='".$_POST['pzone|2']."' maxlength='255' /><br/>";		
			}
			if($v == 'crossstr'){
				echo "<label for='dcrossstr'>$LANG[crossstr]:</label><input id='dcrossstr' type='text' 
				name='crossstr|2' value='".$_POST['crossstr|2']."' maxlength='255' /><br/>";
			}
			if($v == 'colonyn'){
				echo "<label for='dcolonyn'>$LANG[colonyn]:</label><input id='dcolonyn' type='text' name='colonyn|2' 
				value='".$_POST['colonyn|2']."' maxlength='255' /><br/>";
			}
			if($v == 'district'){
				echo "<label for='ddistrict'>$LANG[district]:</label><input id='ddistrict' type='text' 
				name='district|2' value='".$_POST['district|2']."' maxlength='255' /><br/>";
			}
			if($v == 'region'){
				echo "<label for='dregion'>$LANG[region]:</label><input id='dregion' type='text' name='region|2' 
				value='".$_POST['region|2']."' maxlength='255' /><br/>";
			}
			if($v == 'state'){
				echo "<label for='dstate'>$LANG[state_province]:</label>"; 	

				$ct 	= get_countries(3,$_POST['country|2']);		

				if(display_state_list($ct)){
					echo province_me($ct,$_POST['state|2'],'delivery');						
				}			
				else {
					echo "<input id='dstate' type='text' name='state|2' value='".$_POST['state|2']."' maxlength='255' /><br>";
				}
						}
			if($v == 'zip'){
				echo "<label for='dzip'>$LANG[zip]:</label><input id='dzip' type='text' 
				name='zip|2' value='".$_POST['zip|2']."' maxlength='255' /><br/>";			
			}
			if($v == 'place'){
				echo "<label for='dtown'>$LANG[town]:</label><input id='dtown' type='text' 
				name='town|2' value='".$_POST['town|2']."' maxlength='255' /><br/>";			
			}
		}
	}
}

function what_order_level($option=1,$txn_id=0,$who=0){
	$table 	= is_dbtable_there('orders');
	
	if($option == 1){
	$qStr 	= "SELECT level FROM $table WHERE who = '$_SESSION[cust_id]'";
	}
	if($option == 2){
	$qStr 	= "SELECT level FROM $table WHERE txn_id = '$txn_id' AND who = '$who'";
	}
	
	$res 	= mysql_query($qStr);
	$row 	= mysql_fetch_assoc($res);

return $row[level];
}

function order_step_table($step,$option='4steps'){

	$LANG[payment_delivery] = __('Payment &amp; Delivery Options &raquo;','wpShop');
	$LANG[address] 			= __('Shipping &amp; Billing Address &raquo;','wpShop');
	$LANG[summary] 			= __('Order Review &raquo;','wpShop');
	$LANG[payment] 			= __('Payment &raquo;','wpShop');
	$LANG[finished] 		= __('Confirmation','wpShop');

	
	$dp = delivery_payment_chosen();
	if($dp['p_option'] == 'paypal_pro'){$option = '5steps';}
	
	switch($option){
	
		case '4steps':
			$html =  "
			<ul class='oSteps'>
				<li class='[s1]'><span>1.</span>$LANG[payment_delivery]</li>
				<li class='[s2]'><span>2.</span>$LANG[address]</li>
				<li class='[s3]'><span>3.</span>$LANG[summary]</li>
				<li class='[s4]'><span>4.</span>$LANG[finished]</li>
			</ul>
			";	
			$max = 5;
			
		break; 
		
		case '5steps':
			$html = "
			<ul class='oSteps'>
				<li class='[s1]'><span>1.</span>$LANG[payment_delivery]</li>
				<li class='[s2]'><span>2.</span>$LANG[address]</li>
				<li class='[s3]'><span>3.</span>$LANG[summary]</li>
				<li class='[s4]'><span>4.</span>$LANG[payment]</li>
				<li class='[s5]'><span>5.</span>$LANG[finished]</li>
			</ul>
			";
			$max = 6;
		break; 		
	}	
	
	$aktiv_passiv = array();
	
	
	for($i=1; $i<$max; $i++){
		if($i == $step){
	     	$aktiv_passiv[$i] = 'aktiv';
		}else{
	     	$aktiv_passiv[$i] = 'passiv';
		}
	}
	
	foreach($aktiv_passiv as $k => $v){
		$key 	= '[s'.$k.']';
		$html	= str_replace($key,$v,"$html");						
	}
	
return $html;
}

function terms_accepted(){
	if($_POST[terms_accepted] == 'on')
	{
		$result = TRUE;
		
					$table = is_dbtable_there('orders');
					$column_value_array 	= array();
					$where_conditions 		= array();
					
					$column_value_array[terms] 	= '1';				
					$where_conditions[0]			= "who = '$_SESSION[cust_id]'";
										
					db_update($table, $column_value_array, $where_conditions);			
	}
	else {
		$result = FALSE;
	}
	
return $result; 
}

function calculate_shipping($d_option,$subtotal,$weight,$num_items,$country='US'){
	global $CONFIG_WPS,$OPTION; 

	// we get main method 
	$sOption 		=  $OPTION['wps_shipping_method'];
	
	// overriding depending on exempted categories
	// check cart for products in the free shipping categories
	$table 	= is_dbtable_there('shopping_cart');
	$qStr 	= "SELECT * FROM $table WHERE who = '$_SESSION[cust_id]'";			
	$res 	= mysql_query($qStr);
	$num	= mysql_num_rows($res);
	
	// Get the list of categories that have free shipping
	$myIDs 		= get_option('wps_free_shipping_categories');  
	$myIDarray  = explode(',' ,$myIDs);

	// default: no free shipping if proven otherwise
	$freeShipping == FALSE;

	while($row = mysql_fetch_assoc($res))
	{
		if(in_category($myIDarray,$row['postID']) === TRUE)
		{
			// One or more products is not eligible for free shipping
			$freeShipping = TRUE;
		}
		else {
			$freeShipping = FALSE;
			#die($myIDs."-".$row[postID]." Evaluated False");	
		}
	}
	
	if($freeShipping == TRUE)
	{
		$sOption = 'FREE';
	}
	
	// overriding depending on delivery + payment options
	if($d_option == 'pickup')
	{
		$sOption = 'FREE';	
	}
	
	// apply parameter according to smain-method
	switch($sOption){
	
		case 'FREE':
			$sFee = 'noSFee';
			$sFee = '0.00';
		break;
		
		
		case 'FLAT':
			$sFee = $OPTION['wps_shipping_flat_parameter'];		
		break;		
		
		
		case 'FLAT_LIMIT':		
			$param 	= $OPTION['wps_shipping_flatlimit_parameter'];
			$p		= explode("|",$param);
			
			if($subtotal > $p[1]){
				$sFee	= '0.00';
			}
			else {
				$sFee 	= $p[0];
			}		
		break;		
		
		
		case 'WEIGHT_FLAT':
			$param 	= $OPTION['wps_shipping_weightflat_parameter'];
			
			//get the meassuring unit
			$meassuring_unit = $OPTION['wps_meassuring_unit'];
			switch($meassuring_unit){
				case 'grams':
					$kg		= $weight / 1000;
				break;
				case 'pounds':
					$kg		= $weight;
				break;
			}
			
			$sFee	= $kg * $param;
			$sFee 	= round($sFee,2);  
			$sFee	= sprintf("%01.2f",$sFee);
		break;		
		
		
		case 'WEIGHT_CLASS':
			
			$wClasses	= array();
			$param 		= $OPTION['wps_shipping_weightclass_parameter'];
			
			//remove any whitespace at beginning+end and also # at the end
			$param 		= trim($param);
			if(substr($param, -1) == '#'){
				$param = substr($param, 0, -1);
			}
			
			//get the meassuring unit
			$meassuring_unit = $OPTION['wps_meassuring_unit'];
			switch($meassuring_unit){
				case 'grams':
					$kg		= $weight / 1000;
				break;
				case 'pounds':
					$kg		= $weight;
				break;
			}
			
			$p 			= explode("#",$param);
			
			foreach($p as $v){					// split into different realm/dollar chunks	
				$a  				= explode("|",$v);
				$wClasses["$a[1]"]	= $a[0];	//we want array values like $array[dollar] = kg-kg
			}
			

			foreach($wClasses as $k => $v){		
			
				$b 		= explode("-",$v);		// create minimum/maximum kg values

				if($b[1] == 'ul'){				// in case the maximum value is ul we add 10.00 kg to the weight to make it fit the realm
					$b[1] = $kg + 10.00;
				}
				
				$b[0]	= (float) $b[0];		// typecast to float
				$b[1]	= (float) $b[1];				
				
				
				if($kg >= $b[0] && $kg <= $b[1])	// the actual minimum - maximum checking 
				{
					$sFee = $k;
				}				
			}
			$sFee	= sprintf("%01.2f",$sFee);
			
		break;			
		
		case 'PER_ITEM':
			$param 	= $OPTION['wps_shipping_peritem_parameter'];		
			$sFee	= $num_items * $param;
			$sFee	= sprintf("%01.2f",$sFee);
		break;		
		
		case 'PER_ITEM_SINGLE':		
			// will come later 
		break;	
	}

	// so far, so good - Delivery to country other than shop-country?
	
	// in case there is a record for different delivery address then we have to take of course the country of delivery address
	$table 	= is_dbtable_there('delivery_addr');
	$qStr 	= "SELECT country FROM $table WHERE who = '$_SESSION[cust_id]' LIMIT 0,1";
	$res9 	= mysql_query($qStr);
	$row9 	= mysql_fetch_assoc($res9);
	
	if(strlen($row9['country']) > 1){
		$country = $row9['country'];
	}
	
	$dc = get_delivery_countries();
	
	if($dc[num]!= 0){
	
		if((WPLANG == 'de_DE')||(WPLANG == 'fr_FR')){
			$col = substr(WPLANG,0,2);
		}
		else{
			$col = 'country';
		}
	
		$table 	= is_dbtable_there('countries');
		// if yes...
		// - get country + zone of buyer 
		$qStr 	= "SELECT zone FROM $table WHERE $col = '$country' LIMIT 0,1";
		$res 	= mysql_query($qStr);
		$row	= mysql_fetch_assoc($res);

		// - get surcharge		
		$th_option = $CONFIG_WPS[shortname] . '_shipping_zone'.$row[zone].'_addition';		
		$surcharge = get_option($th_option);
	
		// - add surcharge to shipping fee
		$sFee = $sFee + $surcharge;
	}
	

return sprintf("%01.2f",$sFee);
}


function update_order($weight,$sFee,$subtotal,$voucher=0.00,$tax='0.00'){					
	$table 					= is_dbtable_there('orders');
	$column_value_array 	= array();
	$where_conditions 		= array();
						   
	$column_value_array['weight'] 		= $weight;
	$column_value_array['shipping_fee'] = $sFee;					
	$column_value_array['tax'] 			= $tax;
	$column_value_array['net'] 			= ($subtotal - $voucher);
	$column_value_array['amount'] 		= ($subtotal - $voucher) + $sFee + $tax;
						
	$where_conditions[0]				= "who = '$_SESSION[cust_id]'";
	db_update($table, $column_value_array, $where_conditions);

return sprintf("%01.2f",$column_value_array[amount]);
}

function process_payment($feedback,$option){

		// update orders table according to payment status
		$table 					= is_dbtable_there('orders');
		$column_value_array 	= array();
		$where_conditions 		= array();

					
			switch($option){				
									
				case 'paypal':
					
					if($payment_status == 'Completed'){
						$column_value_array[txn_id] 		= $txn_id;
						$column_value_array[tracking_id] 	= time();
						$column_value_array[order_time] 	= time();
												
						$cart_comp = cart_composition($_SESSION[cust_id]);
						if($cart_comp == 'digi_only'){
							$column_value_array[level] 			= '7';						
						}
						else{						
							$column_value_array[level] 			= '4';
						}
					}
					elseif($payment_status == 'Pending'){
						$column_value_array[txn_id] 		= $txn_id;
						$column_value_array[tracking_id] 	= time();
						$column_value_array[order_time] 	= time();
						$column_value_array[pending_r]		= $pending_r; 
						$column_value_array[level] 			= '8';					
					}
					elseif($payment_status == 'free'){
						$column_value_array[txn_id] 		= $txn_id;
						$column_value_array[tracking_id] 	= time();
						$column_value_array[order_time] 	= time();
						$column_value_array[level] 			= '7';							
					}
					else {}
					
				
					$where_conditions[0]				= "who = '$_SESSION[cust_id]'";
																				
					db_update($table, $column_value_array, $where_conditions);	
					
					$qStr 	= "SELECT * FROM $table WHERE who = '$_SESSION[cust_id]' LIMIT 1";
					$res 	= mysql_query($qStr);
					$order 	= mysql_fetch_assoc($res);
					
				break;	
					
										
				case 'authn':						
						
					// we need to get the 'who' token 
					$qStr 	= "SELECT who FROM $table WHERE txn_id = '$feedback[temp_txn_id]' LIMIT 1";
					$res 	= mysql_query($qStr);
					$row 	= mysql_fetch_assoc($res);	
					$parts	= explode("-",$row[who]);					
					
					if($feedback[status] == 1){
						$column_value_array[txn_id] 		= $feedback['trans_id'];
						$column_value_array[tracking_id] 	= $parts[0];	
						$column_value_array[order_time] 	= time();
												
						$cart_comp = cart_composition($row[who]);
						if($cart_comp == 'digi_only'){
							$column_value_array[level] 			= '7';						
						}
						else{						
							$column_value_array[level] 			= '4';
						}
					}
					elseif($payment_status == 'Pending'){
						$column_value_array[txn_id] 		= $txn_id;
						$column_value_array[tracking_id] 	= $parts[0];	
						$column_value_array[order_time] 	= time();
						$column_value_array[pending_r]		= $pending_r; 
						$column_value_array[level] 			= '8';					
					}
					else {}
					
				
					$where_conditions[0]				= "txn_id = '$feedback[temp_txn_id]'";
																				
					db_update($table, $column_value_array, $where_conditions);	
					
					$qStr 	= "SELECT * FROM $table WHERE txn_id = '$feedback[trans_id]' LIMIT 1";
					$res 	= mysql_query($qStr);
					$order 	= mysql_fetch_assoc($res);				
				
				break;

				case 'wpay':
				
					if($feedback[status] == 'Y'){					
					
						// we need to get the 'who' token 
						$qStr 	= "SELECT who FROM $table WHERE txn_id = '$feedback[temp_txn_id]' LIMIT 1";
						$res 	= mysql_query($qStr);
						$row 	= mysql_fetch_assoc($res);	
						$parts	= explode("-",$row[who]);	
					
					
						$column_value_array[txn_id] 		= $feedback['trans_id'];
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();
												
						$cart_comp = cart_composition($row[who]);
						if($cart_comp == 'digi_only'){
							$column_value_array[level] 			= '7';						
						}
						else{						
							$column_value_array[level] 			= '4';
						}
					}
					elseif($payment_status == 'Pending'){
						$column_value_array[txn_id] 		= $txn_id;
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();
						$column_value_array[pending_r]		= $pending_r; 
						$column_value_array[level] 			= '8';					
					}
					else {}
					
				
					$where_conditions[0]				= "txn_id = '$feedback[temp_txn_id]'";
																				
					db_update($table, $column_value_array, $where_conditions);	
					
					$qStr 	= "SELECT * FROM $table WHERE txn_id = '$feedback[trans_id]' LIMIT 1";
					$res 	= mysql_query($qStr);
					$order 	= mysql_fetch_assoc($res);				
				
				break;
				
				
				case 'bt':
				
					$parts	= explode("-",$_SESSION[cust_id]);
				
					if($feedback[status] == 'Completed'){
						$column_value_array[txn_id] 		= md5(microtime());
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();
						$column_value_array[level] 			= '4';
					}
					elseif($payment_status == 'Pending'){
						$column_value_array[txn_id] 		= $txn_id;
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();
						$column_value_array[pending_r]		= $pending_r; 
						$column_value_array[level] 			= '8';					
					}
					elseif($payment_status == 'free'){
						$column_value_array[txn_id] 		= $txn_id;
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();
						$column_value_array[level] 			= '7';							
					}
					else {}
					
				
					$where_conditions[0]				= "who = '$_SESSION[cust_id]'";
																				
					db_update($table, $column_value_array, $where_conditions);	
					
					$qStr 	= "SELECT * FROM $table WHERE who = '$_SESSION[cust_id]' LIMIT 1";
					$res 	= mysql_query($qStr);
					$order 	= mysql_fetch_assoc($res);				
				
				break;
				
				
				case 'cas':
				
					$parts	= explode("-",$_SESSION[cust_id]);
				
					if($feedback[status] == 'Completed'){
						$column_value_array[txn_id] 		= md5(microtime());
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();											
						$column_value_array[level] 			= '4';
						
					}
					elseif($payment_status == 'Pending'){
						$column_value_array[txn_id] 		= $txn_id;
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();
						$column_value_array[pending_r]		= $pending_r; 
						$column_value_array[level] 			= '8';					
					}
					elseif($payment_status == 'free'){
						$column_value_array[txn_id] 		= $txn_id;
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();
						$column_value_array[level] 			= '7';							
					}
					else {}
					
				
					$where_conditions[0]				= "who = '$_SESSION[cust_id]'";
																				
					db_update($table, $column_value_array, $where_conditions);	
					
					$qStr 	= "SELECT * FROM $table WHERE who = '$_SESSION[cust_id]' LIMIT 1";
					$res 	= mysql_query($qStr);
					$order 	= mysql_fetch_assoc($res);				
				
				break;			
				
				case 'cod':
				
					$parts	= explode("-",$_SESSION[cust_id]);
				
					if($feedback[status] == 'Completed'){
						$column_value_array[txn_id] 		= md5(microtime());
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();											
						$column_value_array[level] 			= '4';
						
					}
					elseif($payment_status == 'Pending'){
						$column_value_array[txn_id] 		= $txn_id;
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();
						$column_value_array[pending_r]		= $pending_r; 
						$column_value_array[level] 			= '8';					
					}
					elseif($payment_status == 'free'){
						$column_value_array[txn_id] 		= $txn_id;
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();
						$column_value_array[level] 			= '7';							
					}
					else {}
					
				
					$where_conditions[0]				= "who = '$_SESSION[cust_id]'";
																				
					db_update($table, $column_value_array, $where_conditions);	
					
					$qStr 	= "SELECT * FROM $table WHERE who = '$_SESSION[cust_id]' LIMIT 1";
					$res 	= mysql_query($qStr);
					$order 	= mysql_fetch_assoc($res);				
				
				break;				
				
				
				case 'paypal_pro':
				
					$parts	= explode("-",$_SESSION[cust_id]);
				
					if($feedback[status] == 'Completed'){
						$column_value_array[txn_id] 		= md5(microtime());
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();
						$column_value_array[level] 			= '4';
					}
					elseif($payment_status == 'Pending'){
						$column_value_array[txn_id] 		= $txn_id;
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();
						$column_value_array[pending_r]		= $pending_r; 
						$column_value_array[level] 			= '8';					
					}
					elseif($payment_status == 'free'){
						$column_value_array[txn_id] 		= $txn_id;
						$column_value_array[tracking_id] 	= $parts[0];
						$column_value_array[order_time] 	= time();
						$column_value_array[level] 			= '7';							
					}
					else {}
					
				
					$where_conditions[0]				= "who = '$_SESSION[cust_id]'";
																				
					db_update($table, $column_value_array, $where_conditions);	
					
					$qStr 	= "SELECT * FROM $table WHERE who = '$_SESSION[cust_id]' LIMIT 1";
					$res 	= mysql_query($qStr);
					$order 	= mysql_fetch_assoc($res);				
				
				break;				
			}											

			
		// voucher management 
		$qStr 	= "SELECT voucher FROM $table WHERE who = '$order[who]' LIMIT 0,1"; 
		$res 	= mysql_query($qStr);
		$row	= mysql_fetch_assoc($res);
		
		if($row['voucher'] != 'non'){  //..then update vouchers table 
		
			$table2	= is_dbtable_there('vouchers');	
			$qStr 	= "SELECT duration FROM $table2 WHERE vcode = '$row[voucher]' LIMIT 0,1"; 
			$res2 	= mysql_query($qStr);
			$row2	= mysql_fetch_assoc($res2);
			
			$column_value_array 	= array();
			$where_conditions 		= array();						
			
			if($row2[duration] == '1time'){
			$column_value_array['used'] 		= '1';
			}
			$column_value_array['time_used'] 	= date("F j, Y");
			$column_value_array['who'] 			= $_SESSION[cust_id];
			$where_conditions[0]				= "vcode = '$row[voucher]'";
																				
			db_update($table2, $column_value_array, $where_conditions);	
		}
			
			
			
return $order;
}


function get_chosen_doption(){
				
					$table = is_dbtable_there('orders');
						
					$d_op 				= array(); 	
					$qStr 				= "SELECT * FROM $table WHERE who = '$_SESSION[cust_id]' LIMIT 1";
					$res 				= mysql_query($qStr);
					$row 				= mysql_fetch_assoc($res);
					$d_op[method]		= $row[d_option];
					$d_op[tracking_id]	= $row[tracking_id];

return $d_op;
}

function url_be($option='orders'){

	global $OPTION;

	switch($option){
	
		case 'orders':
			$url = get_option('siteurl').'/wp-admin/themes.php?page=functions.php&section=orders';
		break;
		
		case 'lkeys':
			$url = get_option('siteurl').'/wp-admin/themes.php?page=functions.php&section=lkeys';
		break;		
		
		
	}
return $url;
}


function NWS_validate_email($email){
		
		if(eregi ("^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,6}$", $email)){
            	$feedback = TRUE;
	     }
	     else

	     {
            	$feedback = FALSE;
	     }
		 
return $feedback;
}

function change_order_level($oid,$new_level){

					// update orders table
					$table = is_dbtable_there('orders');
					$column_value_array 	= array();
					$where_conditions 		= array();
					
					$column_value_array[level] 		= $new_level;
					
					$where_conditions[0]			= "oid = $oid";
										
					db_update($table, $column_value_array, $where_conditions);
	
return TRUE;
}

function show_orders($who){
	
	$table 	= is_dbtable_there('shopping_cart');	
	$CART 	= array();
	

	$qStr 			= "SELECT * FROM $table WHERE who = '$who'";
	$res 			= mysql_query($qStr);
	$num 			= mysql_num_rows($res);
	
		$item			= array();
		$i				= 0;
		
		
			while ($row = mysql_fetch_assoc($res)) {
				
				$personalize 			=  retrieve_personalization($row[cid]); // Personalization 
			
				$item[$i][num]			= $row[item_amount];
				$item[$i][price] 		= $row[item_price] * $row[item_amount];
				$item[$i][weight] 		= $row[item_weight] * $row[item_amount];
				$CART[$i]				= $row[cid].'|'.$row[item_amount].'|'.$row[item_name].'|'.$row[item_price].'|';
				$CART[$i]				.= sprintf("%01.2f",$item[$i][price]).'|'.$row[item_id].'|'.$row[item_attributs].'|'.$personalize;
				$i++;
			}	
			
return $CART;
}

function list_order_items($order_items){

					$data = "<table>
								<thead>
									<tr>
										<th>".__('Qty','wpShop')."</th>
										<th>".__('ID','wpShop')."</th>
										<th>".__('Item','wpShop')."</th>
										<th>".__('Unit','wpShop')."</th>
										<th>".__('Total','wpShop')."</th>
									</tr>
								</thead>
					";
					
					
					foreach($order_items as $v){
					
						$details 		= explode("|",$v);						
						$attributes 	= "<br/>".display_attributes($details[6],'html_be');
						$personalize 	= (!empty($details[7]) ? "<br/>".$details[7] : NULL);						
						
						if(is_it_digital('BE',$details[0])){
						
							// we only give 'already deliverd' not if p_option is not bank transfer
							$table1 	= is_dbtable_there('shopping_cart');
							$table2 	= is_dbtable_there('orders');
						
							$qStr 		= "SELECT $table2.p_option FROM $table1,$table2 
											WHERE $table1.cid = $details[0] AND $table1.who = $table2.who";
							$res 		= mysql_query($qStr);
							$row		= mysql_fetch_assoc($res);
							$p_option 	= $row[p_option];
						
							if($p_option == 'transfer'){
								$digital_delivered 	= "<b style='color: green;'>".__('Digital good','wpShop')."</b>";
							}
							else {
								$digital_delivered 	= "<b style='color: green;'>".__('Digital good - already delivered','wpShop')."</b>";
							}
							
							$extra_style		= 'style="background: #9CFF78;"';
						}
						else{
							$digital_delivered 	= NULL;
							$extra_style		= NULL;						
						}
						
						$data .= "<tr $extra_style>
						<td>$details[1]x</td>
						<td>$details[5]</td>
						<td><b>$details[2]</b> $attributes $personalize $digital_delivered</td>
						<td>";
							if($OPTION['wps_currency_symbol'] !='') { $data .= $OPTION['wps_currency_symbol'];} $data .= format_price($details[3]); 
							if($OPTION['wps_currency_code_enable']) { $data .= " " . $OPTION['wps_currency_code']; }  
							if($OPTION['wps_currency_symbol_alt'] !='') { $data .= " " . $OPTION['wps_currency_symbol_alt']; }
						$data .= "</td>
						<td>";
							if($OPTION['wps_currency_symbol'] !='') { $data .= $OPTION['wps_currency_symbol'];} $data .= format_price($details[4]); 
							if($OPTION['wps_currency_code_enable']) { $data .= " " . $OPTION['wps_currency_code']; }  
							if($OPTION['wps_currency_symbol_alt'] !='') { $data .= " " . $OPTION['wps_currency_symbol_alt']; }
						$data .= "</td>
						</tr>";
					
					
					}
					$data .= "</table>";
					
return $data;
}

function check_order_status($tid){

	$labels 		= array();
	$labels['4'] 	= __('Your Order has been received and is currently in Queue to be Processed.','wpShop');
	$labels['5'] 	= __('Your Order is currently being Processed.','wpShop');
	$labels['6'] 	= __('Your Order has been Shipped.','wpShop');
	$labels['7'] 	= __('Order Completed. Items Delivered.','wpShop');
	$labels['8'] 	= __('Your Payment is still Pending.','wpShop');

	$table 	= is_dbtable_there('orders');
	$qStr 	= "SELECT * FROM $table WHERE tracking_id = '$tid' LIMIT 1";
	$res 	= mysql_query($qStr);
	$row 	= mysql_fetch_assoc($res);	
	$status = $row[level];
	
	$feedback = $labels[$status];

return $feedback;
}


function get_countries($option=1,$land='US'){

	$table 	= is_dbtable_there('countries');
	
	
if($option == 1){

	if(WPLANG == 'de_DE'){
		$orderby = 'ORDER BY de ASC';
	}
	elseif(WPLANG == 'fr_FR'){
		$orderby = 'ORDER BY fr ASC';
	}
	else{
		$orderby = 'ORDER BY country ASC';
	}


	$output			= array();
	$qStr 			= "SELECT * FROM $table $orderby";
	$res 			= mysql_query($qStr);
	
	while($row = mysql_fetch_assoc($res)){
		if(WPLANG == 'de_DE'){
			$output[] 	= $row['de'].'|'.$row['abbr'];	
		}
		if(WPLANG == 'fr_FR'){
			$output[] 	= $row['fr'].'|'.$row['abbr'];	
		}
		else{
			$output[] 	= $row['country'].'|'.$row['abbr'];
		}
	}
}	

if($option == 2){

	$qStr 			= "SELECT * FROM $table WHERE abbr = '$land' LIMIT 0,1";  
	$res 			= mysql_query($qStr);
	$row			= mysql_fetch_assoc($res);	
	$output			= $row['country'];
	if(WPLANG == 'de_DE'){
		$output			= $row['de'];	
	}
	if(WPLANG == 'fr_FR'){
		$output			= $row['fr'];	
	}
}	


if($option == 3){

		$qStr 			= "SELECT * FROM $table WHERE country = '$land' LIMIT 1";
	if(WPLANG == 'de_DE'){
		$qStr 			= "SELECT * FROM $table WHERE de = '$land' LIMIT 1";	
	}
	if(WPLANG == 'fr_FR'){
		$qStr 			= "SELECT * FROM $table WHERE fr = '$land' LIMIT 1";	
	}
	$res 			= mysql_query($qStr);
	$row			= mysql_fetch_assoc($res);	
	$output			= $row['abbr'];
}	


// for zone selection 
if($option == 4){

	if(WPLANG == 'de_DE'){
		$orderby = 'ORDER BY de ASC';
	}
	elseif(WPLANG == 'fr_FR'){					
		$orderby = 'ORDER BY fr ASC';
	}
	else{
		$orderby = 'ORDER BY country ASC';
	}


	$output			= array();
	$qStr 			= "SELECT * FROM $table $orderby";
	$res 			= mysql_query($qStr);
	
	while($row = mysql_fetch_assoc($res)){
		if(WPLANG == 'de_DE'){
			$output[] 	= $row['de'].'|'.$row['abbr'].'|'.$row['zone'];	
		}
		elseif(WPLANG == 'fr_FR'){
			$output[] 	= $row['fr'].'|'.$row['abbr'].'|'.$row['zone'];			
		}
		else{
			$output[] 	= $row['country'].'|'.$row['abbr'].'|'.$row['zone'];
		}
	}
}


return $output;
}

function update_zone_one($old){

		global $CONFIG_WPS,$OPTION;

				$new 	= $OPTION['wps_shop_country'];
				$table 	= is_dbtable_there('countries');
				
				if(strlen($new) > 0){ 
				
					$qStr1 = "UPDATE $table 
							SET zone = '0'
							WHERE abbr = '$old'";
					mysql_query($qStr1);
				
					$qStr2 = "UPDATE $table 
							SET zone = '1'
							WHERE abbr = '$new'";
					mysql_query($qStr2);
				}
}


function get_delivery_countries($option='with_zones'){

		global $CONFIG_WPS,$OPTION;
		
		switch(WPLANG){	
			case 'de_DE':
				$col = 'de';
			break;
			case 'fr_FR':
				$col = 'fr';
			break;
			default:
				$col = 'country';
			break;
		}
		
		switch($option){
			
			case 'with_zones':
		
				$output = array();
				
				$table 	= is_dbtable_there('countries');
				$qStr 	= "SELECT * FROM $table WHERE zone IN (2,3,4,5,6) ORDER BY $col";
				$res 	= mysql_query($qStr);					
				$num 	= mysql_num_rows($res);

				if($num > 0){
					$output['res'] = $res;
				}
				else{
					$output['res'] = 'none';
				}
				
				$output['num'] = $num;
			
			break;
			
			case 'no_zone':
			
				$table 	= is_dbtable_there('countries');
				$abbr	= $OPTION['wps_shop_country'];
				$qStr 	= "SELECT * FROM $table WHERE abbr = '$abbr' LIMIT 0,1";	
				$res 	= mysql_query($qStr);
				$row 	= mysql_fetch_assoc($res);
				$output = $row[$col];
				
			break;
		}
				
return $output;			
}


function get_chosen_delivery_country(){

	global $OPTION;

			if($OPTION['wps_shop_mode']=='Inquiry email mode'){
				$table = is_dbtable_there('inquiries');
			}
			else{
				$table = is_dbtable_there('orders');
			}
	
			$qStr 	= "SELECT country FROM $table WHERE who = '$_SESSION[cust_id]' LIMIT 0,1";
			$res 	= mysql_query($qStr);					
			$data 	= mysql_fetch_assoc($res);
				
return $data['country'];			
}

function thumbs_height($pic_path,$new_width){

	  $size		= getimagesize($pic_path);
	  $w		= $size[0];
	  $h		= $size[1];
	  
	  $height	= intval($h*$new_width/$w);

return $height;
}

function cart_thumb_height($thumb_file,$thumb_path,$addition = NULL){

	$pic_path	= $thumb_path . $addition . $thumb_file;
	$th_height	= thumbs_height($pic_path,$OPTION['wps_cart_thumb_width']);

return $th_height;
}

function current_page($option=1){

	global $OPTION;

	if($option == 1){	// this is used for getting the url for "continue shopping button"
		if((!isset($_GET[orderNow]))  && (!isset($_POST[update]))){
			$path  = dirname($_SERVER['PHP_SELF']);
			$cPage = ($path == '/' ? '' : $path).$_SERVER['REQUEST_URI'];
		}
		else {
			$cPage = '0';
		}
	}					// 2-3 is used e.g. for add to cart 
	elseif($option == 2){
			$path  = dirname($_SERVER['PHP_SELF']);
			$cPage = ($path == '/' ? '' : $path).$_SERVER['REQUEST_URI'];	
	}
	elseif($option == 3){	
	/*
			$path  		= $OPTION['home'];
			$addition 	= $_SERVER['REQUEST_URI'];				
			$url 		=  parse_url($path);
			$cPage 		= 'http://'.$url[host].$addition;	
	*/
			$path  		= get_option('home');
			$addition 	= explode($path,$_SERVER['REQUEST_URI']);	
			$cPage 		= $addition[0];				
	}
	elseif($option == 4){	// header cart url
			$path  		= get_option('home');
			$addition 	= explode($path,$_SERVER['REQUEST_URI']);	
			$add		= str_replace('?added=OK','',$addition[0]);
			$add 		= str_replace('&l=cart','',$add);
			$add 		= str_replace('?failed=1','',$add);
			$cPage 		= $add;				
	}
	else {}
		
return $cPage;
}

function payment_pending($txn_id){

	$table 	= is_dbtable_there('orders');
	
	$qStr 			= "SELECT * FROM $table WHERE txn_id = '$txn_id' LIMIT 1";
	$res 			= mysql_query($qStr);
	$row			= mysql_fetch_assoc($res);

	if($row[pending_r] != 'na'){
		$status = 1;
	}
	else {
		$status = 0;
	}
	 
return $status;
}

function get_doption_tracking_id(){

	$table 			= is_dbtable_there('orders');
	
	$data			= array();
	
	$qStr 			= "SELECT * FROM $table WHERE who = '$_SESSION[cust_id]' LIMIT 1";
	$res 			= mysql_query($qStr);
	$row			= mysql_fetch_assoc($res);

	$data[d_option]		= $row[d_option];
	$data[tracking_id]	= $row[tracking_id];
	
	
return $data;
}

##################################################################################################################################
// 												DIGITAL - GOODS 
##################################################################################################################################
function make_random_str($length = 4){
  	$salt = "abchefghjkmnpqrstuvwxyz0123456789";
  		srand((double)microtime()*1000000);
      	$i = 0;
	      while ($i <= $length) {
	            $num = rand() % 33;
	            $tmp = substr($salt, $num, 1);
	            $pass = $pass . $tmp;
	            $i++;
	      }
		  
return $pass;
}

function lkeys_enough($fname){

	global $OPTION;
	
	$EMAIL 		= load_what_is_needed('email');		//change.9.10

	$table 		= is_dbtable_there('lkeys');
	$qStr 		= "SELECT lid FROM $table WHERE filename = '$fname' AND used = '0'";
	$res 		= mysql_query($qStr);
	$num 		= mysql_num_rows($res);	
	
	$minimum 	= $OPTION['wps_lkeys_warn_num'];
	
	if($num < $minimum){

				$search		= array("[##header##]","[##fname##]","[##minimum##]","[##url##]");						
				$replace 	= array($EMAIL->email_header(),$fname,$minimum,url_be('lkeys'));			//change.9.10
				
				$EMAIL->email_owner_lkey_warning($fname,$search,$replace);			//change.9.10
	}
}

function find_masterdata_path($option=1){
		global $OPTION;
		
		$wpDir	= explode('/wp-content',WP_CONTENT_DIR);
		$dr 	= $wpDir[0];
		
		
		
		$pparts = count(explode("/",$dr));		
		
		$dir 	= array();
		$dir[0]	= ''; 
		$dir[1]	= '../'; 
		$dir[2]	= '../../'; 
		$dir[3]	= '../../../'; 
		$dir[4]	= '../../../../'; 
		$dir[5]	= '../../../../../'; 
		$dir[6]	= '../../../../../../'; 
		$dir[7]	= '../../../../../../../'; 
		$dir[8]	= '../../../../../../../../'; 
		$dir[9]	= '../../../../../../../../../'; 
		$dir[10]	= '../../../../../../../../../../'; 
		$dir[11]	= '../../../../../../../../../../../'; 
	
		$needle = 'masterdata/find_me.txt';
		$len1	= strlen('find_me.txt');
		
		for($i=0; $i< $pparts; $i++){
										
			$path	= $dir[$i].$needle;
				
			if(($fp = @fopen($path, "r")) === false){
				$feedback = 'Folder masterdata wasnt found. Change directory or contact theme author for support.';
			}
			else {
				$len2 		= strlen($path);
				$len		= $len2 - $len1;
				$start		= 0;
				
				
				if($option == 1){	// to fit echo at the theme options 
					$len 	= $len -3;
					$start	= 3;
				}
				
				$feedback 	= substr($path,$start,$len);		
				
				if($feedback{0} != '.'){
					$feedback = $feedback . " &nbsp;&nbsp; <span style='color: red;'>Your masterdata directory is at the wrong spot in your webspace 
								- Move it!</span>";
				}
				else {				
				
					// it was correctly configured in theme options we give additional positive feedback
					$saved_path = $OPTION['wps_master_dir'];
					if($feedback == $saved_path){
						$feedback = $feedback . " &nbsp;&nbsp; <span style='color: green;'>Correctly saved!</span>";			
					}
					else {
						$feedback = $feedback . " &nbsp;&nbsp; <span style='color: red;'>Not yet correctly saved!</span>";
					}
					
				$add1 = NULL;
				}
				break;
			}		
		}
return $feedback;	
}

function get_lmode(){

	global $OPTION;

	$l_mode		= $OPTION['wps_l_mode'];

return $l_mode;
}

function is_it_affiliate() {
	$len = strlen(get_custom_field('buy_now', FALSE));

	if($len > 0){
		$status = TRUE;
	}
	else{
		$status = FALSE;
	}
	return $status;
}

function is_it_digital($option='FE',$cid=0){

	switch($option){

		case 'FE':
			$len = strlen(get_custom_field('item_file', FALSE));

			if($len > 0){
				$status = TRUE;
			}
			else{
				$status = FALSE;
			}
		break;
		
		case 'BE':
			$table 	= is_dbtable_there('shopping_cart');
			$qStr 	= "SELECT item_file FROM $table WHERE cid = $cid LIMIT 1";				
			$res 	= mysql_query($qStr);
			$row	= mysql_fetch_assoc($res);

			if($row[item_file] != 'none'){
				$status = TRUE;
			}
			else{
				$status = FALSE;
			}			
			
		break;	
		
		case 'CART':  // this is at the moment exactly like BE-however in future there will/could be differences
			$table 	= is_dbtable_there('shopping_cart');
			$qStr 	= "SELECT item_file FROM $table WHERE cid = $cid LIMIT 1";				
			$res 	= mysql_query($qStr);
			$row	= mysql_fetch_assoc($res);

			if($row[item_file] != 'none'){
				$status = TRUE;
			}
			else{
				$status = FALSE;
			}			
			
		break;	
		
		
		case 'UPDATE-CHECK': 
			
			$table 	= is_dbtable_there('shopping_cart');
			$qStr 	= "SELECT item_file FROM $table WHERE cid = $cid LIMIT 1";
			$res 	= mysql_query($qStr);
			$row	= mysql_fetch_assoc($res);
			
			if($row[item_file] != 'none'){
				$status = TRUE;
			}
			else{
				$status = FALSE;
			}			
			
		break;
	}

return $status;
}

function digital_in_cart($who){

	$table 	= is_dbtable_there('shopping_cart');
	$qStr 	= "SELECT * FROM $table WHERE who = '$who' AND item_file != 'none'";				
	$res 	= mysql_query($qStr);
	$num	= mysql_num_rows($res);


	if($num > 0){
		$status = TRUE;
	}
	else{
		$status = FALSE;
	}

return $status;
}

function cart_composition($who){

	$table 	= is_dbtable_there('shopping_cart');
	
	$qStr 	= "SELECT * FROM $table WHERE who = '$who'";			
	$res 	= mysql_query($qStr);
	$num	= mysql_num_rows($res);
	$dgoods	= 0;
	
	while($row = mysql_fetch_assoc($res)){
	
		if($row[item_file] != 'none'){
			$dgoods++;
		}	
	}
	
	if($num == $dgoods){
		$status = 'digi_only';
	}
	elseif(($num > $dgoods) && ($dgoods != 0)){
		$status = 'mixed';
	}
	elseif($dgoods == 0){
		$status = 'digi_none';
	}
	else{}
	
return $status;
}

function get_real_base_url($option='normal'){

global $OPTION;

	if($option == 'normal'){	
				
		if(($_SERVER['HTTPS'] == 'on')||($_SERVER['HTTPS'] == '1') || ($_SERVER['SSL'] == '1')){
			$protocol 	= 'https://';
		}
		elseif($_SERVER['HTTPS'] == 'off'){
			$protocol 	= 'http://';
		}
		elseif(empty($_SERVER['HTTPS'])){
			$protocol 	= 'http://';
		}
		else {}
				
	}
	if($option == 'force_ssl'){
		$protocol 	= 'https://';
	}
	if($option == 'force_http'){
		$protocol 	= 'http://';
	}
	$base_url	= parse_url(get_option('home'));
	$base_url	= $protocol.$base_url['host'].$_SERVER['REQUEST_URI'];
	

	// if with ? parameter? - remove ? + all what follows
	if((strpos($base_url,'?')) !== FALSE){
		$url = substr($base_url,0,strpos($base_url,'?'));
	}
	else {
		$url = $base_url;
	}

	// with an / ending?  and not in a subfolder = remove it  
	if(((substr($url,-1)) == '/') && (strlen($base_url['path']) > 1)){
		$url = substr($url,0,-1);
	}
	
	/*
	// with a / ending?  remove it  
	if((substr($url,-1)) == '/'){
		$url = substr($url,0,-1);
	}
	*/
		
return $url;
}

function expulsion_needed($url_addition = NULL){

	if(!$_POST){
		expulsion($url_addition);
	}
}

function expulsion($url_addition = NULL){

global $OPTION;

			$url = get_option('home').$url_addition ;
			
			echo "	
			<script type='text/javascript'> 
			<!--  
			location.href='$url';  
			//-->  
			</script>  
			<noscript>
			<meta http-equiv='refresh' content='0; url=$url'/>
			</noscript>
			";			
			exit(NULL);
}

function retrieve_address_data(){

			$table1 = is_dbtable_there('orders');
			$table2 = is_dbtable_there('delivery_addr');
		
			$sql1 	= "SELECT * FROM $table1 WHERE who = '$_SESSION[cust_id]' LIMIT 0,1";
			$sql2 	= "SELECT * FROM $table2 WHERE who = '$_SESSION[cust_id]' LIMIT 0,1";
		
			$res1 	= mysql_query($sql1);
			$res2 	= mysql_query($sql2);
		
			$row1 	= mysql_fetch_assoc($res1);
			$row2 	= mysql_fetch_assoc($res2);
					
			$_POST 	= array();
			
			foreach($row1 as $k => $v){
				if(!empty($v)){
					$_POST[$k] = $v;
				}
			}			
			
			foreach($row2 as $k => $v){
				
				if(!empty($v)){
					$a = $k.'|2';
					$_POST[$a] = $v; 
				}
			}
			
return $_POST;
}

function send_user_dlinks($who,$option='BE'){

	global $OPTION;
	
	$EMAIL 			= load_what_is_needed('email');			//change.9.10	
	$DIGITALGOODS 	= load_what_is_needed('digitalgoods');	//change.9.10
	
	// create links + save in db table 
	$table 	= is_dbtable_there('shopping_cart');
	$qStr 	= "SELECT * FROM $table WHERE who = '$who'";
	$res 	= mysql_query($qStr);


	$links				= array();
	$message_links 		= NULL;
	$domain1			= get_bloginfo('template_directory');
	$domain 			= substr($domain1, 7);  
	
	while($row = mysql_fetch_assoc($res)){ 
		
		$linkParam 				= $DIGITALGOODS->create_dlink($row[item_file],$who,2);	//change.9.10
		$links[$row[item_file]] = "$row[item_name]#$row[item_id]#$domain1/dl.php?dl=$linkParam&rd=$who";	
	}
	
	// get the email of customer
	$table 	= is_dbtable_there('orders');
	$qStr 	= "SELECT * FROM $table WHERE who = '$who' LIMIT 0,1";
	$res2 	= mysql_query($qStr);	
	$row2 	= mysql_fetch_assoc($res2);
	
	// send an email with links
		$to 					= $row2[email];
		$subject 				= __('Your download links','wpShop');	
		
	
		foreach($links as $k => $v){ 					
			$p					= explode("#",$v);
			$message_links		.= "<tr><td>$p[0]</td><td>$p[1]</td><td><a href='$p[2]'>Download $k</a></td></tr>";	
		}				
														
														
		if(strlen(WPLANG)< 1){  // shop runs in English 				
				$filename			= WP_CONTENT_DIR . '/themes/' . WPSHOP_THEME_NAME .'/email/email-download-links.html';
		}
		else {					// shops runs in another language 
				$filename 			= WP_CONTENT_DIR . '/themes/' .  WPSHOP_THEME_NAME .'/email/'.WPLANG.'-email-download-links.html';
		}
		
		$message		= file_get_contents($filename);
								
		$em_logo_path 	= get_bloginfo('template_directory') .'/images/logo/' . $OPTION['wps_email_logo'];	
		$message		= str_replace('[##Email-Logo##]', $em_logo_path, "$message");						
		$message		= str_replace('[##biz##]',$OPTION['wps_shop_name'], "$message");
		$cust_name		= $row2[f_name] .' '. $row2[l_name];
		$message		= str_replace('[##name##]', $cust_name, "$message");	

		// we tell the user about the duration time of his links
		if($OPTION['wps_duration_links'] > 3600){
			$hours			= $OPTION['wps_duration_links'] / 3600;
			$duration		= $hours .' '. __('hours',wpShop);
		}
		else{
			$minutes		= $OPTION['wps_duration_links'] / 60;
			$duration		= $minutes .' '. __('minutes',wpShop);
		}
		$message		= str_replace('[##duration##]',$duration, "$message");					
		$message		= str_replace('[##links##]', $message_links , "$message");	
		#$message		= str_replace('[##tracking-id##]', $order[tracking_id] , "$message");	
		

		$admin_email_address	= $OPTION['wps_shop_email'];
		$domain					= $OPTION['wps_shop_name']; 
		
		$EMAIL->html_mail($to,$subject,$message,$admin_email_address,$domain);		//change.9.10
		
		// enter the tstamp into orders db-table
		$table 	= is_dbtable_there('orders');
		$qStr 	= "UPDATE $table SET dlinks_sent = ".time()." WHERE who = '$_GET[token]'";			
		mysql_query($qStr);		
}

##################################################################################################################################
//												RELATED - PRODUCTS																			
##################################################################################################################################
function retrieve_related_products($related,$pids){

global $OPTION;

	// remove doubles
	$result = array_unique($related);
	// remove the shopping cart prods from the related prods array
	foreach($pids as $k => $v){				
		if(in_array($v,$result)== TRUE){
			$key = array_search($v,$result);
			unset($result[$key]);
		}
	}	

	//get related products data		
	foreach($result as $rcat){
		$GetPost 		= get_post($rcat); 
		$title_attr2 	= get_the_title($GetPost->ID);
		$title_attr		= str_replace("%s",get_the_title($GetPost->ID), __('Permalink to %s', 'wpShop'));
		$output 		= my_attachment_images($GetPost->ID,1);
		
		$imgNum 	= count($output);
		//do we have 1 attached image?
		if($imgNum != 0){
			$imgURL		= array();
			foreach($output as $v){
				$img_src 	= $v;
				$img_size 	= $OPTION['wps_ProdRelated_img_size'];
				$des_src 	= $OPTION['upload_path'].'/cache';							
				$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');    
				$imgURL[] 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;				
			}
		// no attachments? pull image from custom field
		} elseif(strlen(get_custom_field2($GetPost->ID,'image_thumb', FALSE))>0) { 
			$img_src 	= get_custom_field2($GetPost->ID,'image_thumb', FALSE);
			$img_size 	= $OPTION['wps_ProdRelated_img_size'];
			$des_src 	= $OPTION['upload_path'].'/cache';							
			$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');     
			$imgURL 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;
		}

		// put output together
		$permalink 	= get_permalink($GetPost->ID);
					
		
		// for attached images
		if($imgNum != 0){ 

			$result[html]	.= "
				<a href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL[0]' alt='$title_attr2'/></a>";	
				
		// for  image from custom field
		} elseif(strlen(get_custom_field2($GetPost->ID,'image_thumb', FALSE))>0) {  
			$result[html]	.= "
				<a href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL' alt='$title_attr2'/></a>";
			
		} else { 									
			$err_message 	= __('Oops! No Product Images were Found.','wpShop');									
			$result[html] 	= "<p title='$title_attr2' class='error'>$err_message</p>";
		} 
		
	} 

return $result['html'];
}

##################################################################################################################################
// 												ATTRIBUTE - MANAGMENT
##################################################################################################################################
function get_attribute_dropdown($post,$orderby,$order,$option=1,$basispr=10000.00){

	global $wpdb;

	$subfolder	= '/'.is_in_subfolder().'/';
	$num 		= 0;
	
	switch($option){
	
		case 1:

		$qStr 			= "SELECT * FROM $wpdb->postmeta WHERE post_id = $post AND meta_key LIKE 'item_attr_%' ORDER BY $orderby $order";
		$res 			= mysql_query($qStr);
		$num 			= mysql_num_rows($res); 
		$i				= 1;					
		$output 		= NULL; 	
		$choose_label	= __('Select','wpShop');
		
		while($row = mysql_fetch_assoc($res)){
		
				$mkey_p     = explode("_",$row[meta_key]);
				$value 		= get_custom_field($row[meta_key], FALSE); 	
				$parts 		= explode("|",$value);								
											
				#$output		.=  "<label>$choose_label $mkey_p[2]:</label><br/><select name='$row[meta_key]' size='1'>";
				
				$output		.=  "<div class='prod_variation prod_select_drop_down'><label>$choose_label $mkey_p[2]:</label>";
				$output		.=  "<select name='$row[meta_key]' id='attr_{$i}' onchange='checkStock(this.value,$subfolder,$basispr,$num);' size='1'>\n";
				
				$output		.= "\n<option value='pch'>".__('Please Select','wpShop')."</option>\n";
				foreach($parts as $v){
					$output		.= "<option value='$v'>$v</option>\n";
				}
				$output		.= "</select></div>";		
				$i++;
		}
		break;
	
		case 2:
		$qStr 			= "SELECT * FROM $wpdb->postmeta WHERE post_id = $post AND meta_key LIKE 'item_attr_%' ORDER BY $orderby $order";
		$res 			= mysql_query($qStr);
		$num 			= mysql_num_rows($res);
		$output 		= NULL;
		$i				= 1;
		$prefix 		= 'attr_';
		$choose_label	= __('Select','wpShop');
		
		
		while($row = mysql_fetch_assoc($res)){
		
			
				$mkey_p     = explode("_",$row[meta_key]);
				$value 		= get_custom_field($row[meta_key], FALSE); 	
				$parts 		= explode("|",$value);								
							
				
				 //onblur='showUser(this.value);
				 // collectAmounts($basispr,$num,this.value);'>";
				$output		.= "<div class='prod_variation prod_select_drop_down'><label>$choose_label $mkey_p[2]:</label>";
				//$output		.= "<select name='attr_{$i}' id='attr_{$i}' size='1' onchange='showUser(this.value,$basispr,$num);'>";
				$output		.= "<select name='$row[meta_key]' id='attr_{$i}' size='1' onchange='checkStock(this.value,$subfolder,$basispr,$num);'>";
				$output		.= "\n<option value='pch'>".__('Please Select','wpShop')."</option>\n";
				

				foreach($parts as $v){
					
					$values 	= explode("-",$v);
					$attr		= $prefix.$i;
					$val 		= $values[1].'#'.$mkey_p[2].':'.$values[0];
					if($_SESSION[$attr] == $val){
						$selected = "selected='selected'";
					}
					else{
						$selected = NULL;
					}
					$output	.= "<option value='$values[1]#$mkey_p[2]=$values[0]' $selected>$values[0]</option>\n";
				}
				$output		.= "</select></div>";		
			
		$i++;
		}		
		break;

	}

return $output; 
}

function has_attributes($post,$option=1){

	if($option == 1){
		$attr_option 	= get_post_meta($post->ID,'add_attributes',true);
	}
	else {
		$attr_option 	= get_post_meta($post,'add_attributes',true);
	}
	
	
	
	if($attr_option == '1' || $attr_option == '2'){
		$result = 'yes';
	}
	else{
		$result = 'no';
	}
	
	
	if($option != 1){
		$feedback 			= array();
		$feedback[status]	= $result;
		$feedback[attr_op]	= $attr_option;
		$result				= $feedback;
	}
	
return $result;	
}

function find_post_id($ID_item){
	
	global $wpdb;

	$qStr 		= "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'ID_item' AND meta_value = '$ID_item' LIMIT 0,1";
	$res 		= mysql_query($qStr);
	$row 		= mysql_fetch_assoc($res);
	$result		= $row[post_id];

return $result;
}

function retrieve_attributes($cid){

	$table 		= is_dbtable_there('shopping_cart');
	$qStr		= "SELECT item_attributs FROM $table WHERE cid='$cid' LIMIT 0,1";
	$res 		= mysql_query($qStr);	
	$row		= mysql_fetch_assoc($res);
	$attr		= $row[item_attributs];
	
return $attr;
}

##################################################################################################################################
// 												INQUIRIES - MANAGMENT
##################################################################################################################################
//change.9.9
function sent_inquiry_email($inq){

	global $OPTION;
	
	$EMAIL 	= load_what_is_needed('email');		//change.9.10

	// Email to shop owner	
	$to 					= $OPTION['wps_shop_email'];	
	$subject_str			= __('You received a new Enquiry from %FIRSTNAME% %LASTNAME%','wpShop');
	$subject				= str_replace('%FIRSTNAME%',$inq[f_name], "$subject_str");
	$subject				= str_replace('%LASTNAME%',$inq[l_name], "$subject");			
								
	if(strlen(WPLANG)< 1){  // shop runs in English 
		$filename			= WP_CONTENT_DIR.'/themes/'. WPSHOP_THEME_NAME .'/email/email-new-inquiry.html';
	}
	else {					// shops runs in another language - /*adjust*/
		$filename 			= WP_CONTENT_DIR.'/themes/'. WPSHOP_THEME_NAME .'/email/'.WPLANG.'-email-new-inquiry.html';
	}

	$message				= file_get_contents($filename);					
	$admin_email_address	= $OPTION['wps_shop_email'];
	$domain					= $OPTION['wps_shop_name'];   
					
	$em_logo_path 	= get_bloginfo('template_directory') .'/images/logo/' . $OPTION['wps_email_logo'];	
	$message		= str_replace('[##Email-Logo##]', $em_logo_path, "$message");						
	$message		= str_replace('[##biz##]',$OPTION['wps_shop_name'], "$message");
	$message		= str_replace('[##name##]', $inq['f_name'].' '.$inq['l_name'] , "$message");					
	$message		= str_replace('[##address##]', address_format($inq), "$message");	
	$message		= str_replace('[##email##]', $inq['email'], "$message");					
	$message		= str_replace('[##delivery##]', $inq['d_option'], "$message");
	$message		= str_replace('[##payment##]', $inq['p_option'], "$message");
	$message		= str_replace('[##remarks##]', $inq['custom_note'], "$message");						
	$message		= str_replace('[##home-url##]',substr(get_option('siteurl'),7), "$message");						
	$message		= str_replace('[##tracking-id##]', $inq['tracking_id'] , "$message");	

	if($inq['d_addr'] == '1'){
		$d_addr = address_format(retrieve_delivery_addr('FE'),'d-addr');
	}
	else {
		$d_addr  = ' -- '.__('same as billing address','wpShop').' -- ';
	}
	$message	= str_replace('[##delivery_address##]', $d_addr , "$message");	
	
	
	$CART 		= show_cart();
	if($CART[status] == 'filled'){
	$email_order = NULL;
		foreach($CART[content] as $v){
		
			$details = explode("|",$v);		

			$attributes 	= display_attributes($details[7]);
			$attributes 	= "<br/><span style='font-size: 0.8em; margin-left: 10px;'>" . $attributes . "</span>";	
			$personalize 	= (!empty($details[9]) ? "<br/>".$details[9] : NULL);								
			
			if(strlen(WPLANG) > 0){
				#$attributes = utf8_decode($attributes);	
				#$details[2] = utf8_decode($details[2]);	
			}
			$details[3] = format_price($details[3]);		
			$details[4] = format_price($details[4]);		
			
			$email_order .= "
				<tr>
					<td>$details[5]</td
					<td>$details[2] $attributes $personalize</td>
					<td>$details[1]</td>
					<td>";
						$email_order .= $details[3]; 
						$email_order .= " " . $OPTION['wps_currency_code'];
					$email_order .= "</td>
					<td>";
						$email_order .= $details[4]; 
						$email_order .= " " . $OPTION['wps_currency_code']; 
					$email_order .= "</td>
				</tr>								
			";
			
		}
		
	$Subtotal 		= __('Subtotal:','wpShop');
	$Shipping_fee	= __('Shipping Fee','wpShop');
	$Total			= __('Total:','wpShop');	
	
	$CART['total_price']	= format_price($CART['total_price']);
	$inq['shipping_fee']	= format_price($inq['shipping_fee']);
	$inq['amount'] 			= format_price($inq['amount']);
		
	$email_order .= "	
		<tr>
			<td colspan='4' align='right'>
			<b>$Subtotal</b>
			</td>
			<td>$CART[total_price] " . $OPTION['wps_currency_code'] . "</td>
		</tr>
		<tr>
			<td colspan='4' align='right'>$Shipping_fee</td>
			<td>$inq[shipping_fee] " . $OPTION['wps_currency_code'] . "</td>
		</tr>";

 	
	$email_order .= "
		<tr>
			<td colspan='4' align='right'>
				<b>$Total</b><br/>";
				if ($OPTION['wps_tax_info_enable']){ 
					$email_order .= __('incl.','wpShop') . $OPTION['wps_tax_percentage'] . "% ".$OPTION['wps_tax_abbr'];
				}
			$email_order .= "</td>";
			$email_order .= "<td>";
			$email_order .= $inq['amount']; 							
			$email_order .= " " . $OPTION['wps_currency_code'];
			$email_order .= "</td>
		</tr>
		";
	}
	$message			= str_replace('[##order##]', $email_order , "$message");	
	$html_email_order	= $email_order; 											
	
	// get alternative txt for mime mail or for just txt mails /////////////////////////////////////////////////////////
	if(WPSHOP_EMAIL_FORMAT_OPTION == 'txt' || WPSHOP_EMAIL_FORMAT_OPTION == 'mime'){

		$filename  		= substr($filename,0,strrpos($filename,"."));
		$filename_txt 	= $filename.'.txt';
		$message_txt 	= file_get_contents($filename_txt);				
		
		
		if($CART[status] == 'filled'){
		$email_order = NULL;
			foreach($CART[content] as $v){
			
				$details = explode("|",$v);		

				$attributes 	= display_attributes($details[7]);
				
				$personalize 	= (!empty($details[9]) ? "\n".$details[9] : NULL);						
				
				if(strlen(WPLANG) > 0){
					#$attributes = utf8_decode($attributes);	
					#$details[2] = utf8_decode($details[2]);	
				}
				$details[3] = amount_format($details[3]);
				$details[4] = amount_format($details[4]);

				$email_order .= "$details[1] x $details[5] - $details[2] $attributes (".__('item price','wpShop').": $details[3] ". $OPTION['wps_currency_code'] . ") = $details[4] " . $OPTION['wps_currency_code']."\n\n";
						
			}

		$email_order .= "\n\n\n";
		$email_order .= "$Subtotal $CART[total_price] " . $OPTION['wps_currency_code']."\n";
		$email_order .= __('Shipping Fee','wpShop').": $inq[shipping_fee] " . $OPTION['wps_currency_code']."\n";
		$email_order .= "$Total $inq[amount] " . $OPTION['wps_currency_code']." (".__('incl.','wpShop').$OPTION['wps_tax_percentage'] ."% ". $OPTION['wps_tax_abbr'].")"."\n";

		}									
		
		$message_txt	= str_replace('[##biz##]', $OPTION['wps_shop_name'], "$message_txt");		
		$message_txt	= str_replace('[##name##]', $inq['f_name'].' '.$inq['l_name'] , "$message_txt");					
		$message_txt	= str_replace('[##address##]', address_format($inq), "$message_txt");	
		$message_txt	= str_replace('[##email##]', $inq['email'], "$message_txt");					
		$message_txt	= str_replace('[##delivery##]', $inq['d_option'], "$message_txt");
		$message_txt	= str_replace('[##payment##]', $inq['p_option'], "$message_txt");
		$message_txt	= str_replace('[##remarks##]', $inq['custom_note'], "$message_txt");						
		$message_txt	= str_replace('[##home-url##]',substr(get_option('siteurl'),7), "$message_txt");						
		$message_txt	= str_replace('[##tracking-id##]', $inq['tracking_id'] , "$message_txt");	
		$message_txt	= str_replace('[##order##]', $email_order , "$message_txt");						
		$message_txt	= str_replace('<br/>',' - ', "$message_txt");
	}
	switch(WPSHOP_EMAIL_FORMAT_OPTION){

		//change.9.10
		
		case 'mime':
			$EMAIL->mime_mail($to,$subject,$message,$message_txt,$admin_email_address,$domain,'zend'); // native	//change.9.10
		break;
		
		case 'txt':
			$EMAIL->send_mail($to,$subject,$message_txt,$admin_email_address,$domain);		//change.9.10
		break;
	}	
		
	// Email to customer				
	$subject				= __('Thank you for your Enquiry!','wpShop');				
	$to 					= $inq[email];
									
	if(strlen(WPLANG)< 1){  // shop runs in English 
		$filename			= WP_CONTENT_DIR.'/themes/'. WPSHOP_THEME_NAME .'/email/email-new-inquiry-thanks.html';
	}
	else {					// shops runs in another language - /*adjust*/
		$filename 			= WP_CONTENT_DIR.'/themes/'. WPSHOP_THEME_NAME .'/email/'.WPLANG.'-email-new-inquiry-thanks.html';
	}

	$message				= file_get_contents($filename);					
	$admin_email_address	= $OPTION['wps_shop_email'];
	$domain					= $OPTION['wps_shop_name']; 
	
	$em_logo_path 	= get_bloginfo('template_directory') .'/images/logo/' . $OPTION['wps_email_logo'];	
	$message		= str_replace('[##Email-Logo##]', $em_logo_path, "$message");						
	$message		= str_replace('[##biz##]',$OPTION['wps_shop_name'], "$message");			
	$message		= str_replace('[##name##]', $inq['f_name'].' '.$inq[l_name] , "$message");
	$message		= str_replace('[##email##]', $inq['email'], "$message");						
	$message		= str_replace('[##tracking-id##]', $inq['tracking_id'] , "$message");	
	$message		= str_replace('[##remarks##]', $inq['custom_note'], "$message");	
	$message		= str_replace('[##order##]', $html_email_order , "$message");
												
				
	// get alternative txt for mime mail or for just txt mails /////////////////////////////////////////////////////////
	if(WPSHOP_EMAIL_FORMAT_OPTION == 'txt' || WPSHOP_EMAIL_FORMAT_OPTION == 'mime'){

		$filename  		= substr($filename,0,strrpos($filename,"."));
		$filename_txt 	= $filename.'.txt';
		$message_txt 	= file_get_contents($filename_txt);	
		
		$message_txt	= str_replace('[##biz##]',$OPTION['wps_shop_name'], "$message_txt");		
		$message_txt	= str_replace('[##remarks##]', $inq['custom_note'], "$message_txt");						
		$message_txt	= str_replace('[##order##]', $email_order , "$message_txt");
		$message_txt	= str_replace('[##tracking-id##]', $inq['tracking_id'] , "$message_txt");	
		$message_txt	= str_replace('<br/>',' - ', "$message_txt");	
	}				

	switch(WPSHOP_EMAIL_FORMAT_OPTION){

		//change.9.10
		
		case 'mime':
			$EMAIL->mime_mail($to,$subject,$message,$message_txt,$admin_email_address,$domain,'zend'); // native	//change.9.10
		break;
		
		case 'txt':
			$EMAIL->send_mail($to,$subject,$message_txt,$admin_email_address,$domain);	//change.9.10
		break;
	}

	// update inquiry table - email was sent 				
	$table 					= is_dbtable_there('inquiries');
	$column_value_array 	= array();
	$where_conditions 		= array();
		
	$column_value_array[email_sent]		= 1;
	$where_conditions[0]				= "who = '$_SESSION[cust_id]'";
																				
	db_update($table, $column_value_array, $where_conditions);	

	// delete cust_id in session 
	unset($_SESSION['cust_id']);					
}
//\change.9.9


function adjust_add2cart_img(){

	global $OPTION;
	
	$shopMode 	= $OPTION['wps_shop_mode'];
	$pic 		= ($shopMode =='Inquiry email mode' ? 'add_inquiry.png':'add_to_cart.png' );
	
return $pic;
}


function process_inquiry(){

	// update orders table according to payment status
	$table 					= is_dbtable_there('inquiries');
	$column_value_array 	= array();
	$where_conditions 		= array();
	

	$column_value_array['amount'] 		= $_POST['amount'];
	$column_value_array['shipping_fee']	= $_POST['shipping'];
	$column_value_array['custom_note'] 	= $_POST['custom_note'];
	$column_value_array['tracking_id'] 	= 'I-'.time();
	$column_value_array['inquiry_time'] = time();
	$column_value_array['level'] 		= '4';
	
	$where_conditions[0]				= "who = '$_SESSION[cust_id]'";
																				
	db_update($table, $column_value_array, $where_conditions);	
			
	
	$qStr 		= "SELECT * FROM $table WHERE who = '$_SESSION[cust_id]' LIMIT 1";
	$res 		= mysql_query($qStr);
	$inquiry 	= mysql_fetch_assoc($res);
														
return $inquiry;
}


function check_inquiry_status($tid){

	$labels 		= array();
	$labels['4'] 	= __('Your Enquiry has been received and is being currently Processed.','wpShop');
	$labels['5'] 	= __('Your Enquiry was Replied to.','wpShop');
	
	$table 	= is_dbtable_there('inquiries');
	$qStr 	= "SELECT * FROM $table WHERE tracking_id = '$tid' LIMIT 1";
	$res 	= mysql_query($qStr);
	$row 	= mysql_fetch_assoc($res);	
	$status = $row[level];
	
	$feedback = $labels[$status];

return $feedback;
}

##################################################################################################################################
// 												FORMAT - MANAGMENT
##################################################################################################################################
function amount_format($amount){
	switch(WPLANG){
		case 'de_DE':
			$a 		= sprintf("%01.2f", $amount);
			$output = str_replace('.',',',$a);
		break;
		
		case 'fr_FR':
			$a 		= sprintf("%01.2f", $amount);
			$output = str_replace('.',',',$a);
		break;
		
		case 'it_IT':
			$a 		= sprintf("%01.2f", $amount);
			$output = str_replace('.',',',$a);
		break;

		default:
			$output = sprintf("%01.2f", $amount);
		break;
	}

return $output;
}

function get_address_format($d_country,$option = 0){
		
	// get the address format of the country
	$table 	= is_dbtable_there('countries');
	if((WPLANG == 'de_DE')||(WPLANG == 'fr_FR')){
		$col	= substr(WPLANG,0,2);
	}
	else {
		$col	= 'country';
	}
	$qStr 	= "SELECT address_format FROM $table WHERE $col = '$d_country' LIMIT 0,1";
	$res 	= mysql_query($qStr);
	$row 	= mysql_fetch_assoc($res);
	
	// make all strings to lower case 
	$ad		= strtolower($row['address_format']);

	if($option === 'filter'){
		$arr 	= explode("%",str_replace('#',NULL,$ad));

		foreach($arr as $k => $v){
			if((strlen($v)<2) || ($v == 'name') || ($v == 'country')){
				unset($arr[$k]);
			}
		}
		$new = array_merge(array(),$arr);	

		return $new;
	}
	else {
		return $ad;
	}
}

function address_format($ad,$option='html',$pdf=0){

	global $OPTION;

	$address = NULL;
	
	// get format string for country from DB 
	if($OPTION['wps_shop_mode']=='Inquiry email mode'){
		$table1 	= is_dbtable_there('inquiries');
	}
	else {
		$table1 	= is_dbtable_there('orders');
	}
	
		$table2 	= is_dbtable_there('countries');
		
	
	switch(WPLANG){
		case 'de_DE':
			$where_col = $table2 . '.de'; 
		break;

		case 'fr_FR':
			$where_col = $table2 . '.fr';
		break;
		
		default:
			$where_col = $table2 . '.country';
		break;
	}

	// BE  - needs slightly different query
	if(strpos(dirname($_SERVER['PHP_SELF']),'/wp-admin') !== FALSE) {
		$oid	= (int) $ad[oid];
		$qStr 	= "SELECT address_format FROM $table1,$table2 WHERE $table1.country = $where_col AND $table1.oid = $oid LIMIT 0,1";	
		
		if($option == 'd-addr'){
			$table3 = is_dbtable_there('delivery_addr');
			$aid	= (int) $ad[aid];
			$qStr 	= "SELECT address_format FROM $table3,$table2 WHERE $table3.country = $where_col AND $table3.aid = $aid LIMIT 0,1";	
		}
		
		
	}
	else{ // FE
		if($option == 'bill_header'){ // this is for the pdf bill header
		
			$where_col 		= $table2 . '.abbr';
			$shop_country	= $OPTION['wps_shop_country'];
			$qStr 			= "SELECT address_format FROM $table2 WHERE abbr = '$shop_country' LIMIT 0,1";									
		}
		elseif($option == 'pdf_cust_address'){
			$qStr 	= "SELECT address_format FROM $table1,$table2 
						WHERE $table1.country = $where_col AND $table1.who = '$ad[who]' LIMIT 0,1";			
		}
	
		elseif($option == 'd-addr'){
			$table3 = is_dbtable_there('delivery_addr');
			$qStr 	= "SELECT address_format FROM $table2,$table3 
						WHERE $table3.country = $where_col AND $table3.who = '$_SESSION[cust_id]' LIMIT 0,1";	
		}
		else {
			
			$who_custId = ($ad['p_option'] == 'paypal' ? $ad['who'] : $_SESSION['cust_id']);
			$qStr 		= "SELECT address_format FROM $table1,$table2 WHERE $table1.country = $where_col AND $table1.who = '$who_custId' LIMIT 0,1";	
			
		}
	}
	$res 	= mysql_query($qStr);
	$row 	= mysql_fetch_assoc($res);
	
	// replace tokens with data - we have a html and pdf option
	$address 	= str_replace("#","<br/>",$row[address_format]);
	
	$name		= $ad[f_name] . ' ' . $ad[l_name];
	if (strpos($address,'NAME') !== false) {
			$address 	= str_replace("NAME",strtoupper($name),$address);
	}
	if (strpos($address,'name') !== false) {
			$address 	= str_replace("name",$name,$address);
	}
	
	$address = address_token_replacer($address,'%STREET%',$ad);
	$address = address_token_replacer($address,'%HSNO%',$ad);
	$address = address_token_replacer($address,'%STRNO%',$ad);
	$address = address_token_replacer($address,'%STRNAM%',$ad);
	$address = address_token_replacer($address,'%PB%',$ad);
	$address = address_token_replacer($address,'%PO%',$ad);	
	$address = address_token_replacer($address,'%PZONE%',$ad);
	$address = address_token_replacer($address,'%CROSSSTR%',$ad);		
	$address = address_token_replacer($address,'%COLONYN%',$ad);
	$address = address_token_replacer($address,'%DISTRICT%',$ad);
	$address = address_token_replacer($address,'%REGION%',$ad);	
	$address = address_token_replacer($address,'%PLACE%',$ad);
	$address = address_token_replacer($address,'%STATE%',$ad);
	$address = address_token_replacer($address,'%ZIP%',$ad);
	$address = address_token_replacer($address,'%COUNTRY%',$ad);
	
	
	if($option == 'pdf_delivery_address'){	
	
		$table3 	= is_dbtable_there('delivery_addr');
		$who_custId = ($ad['p_option'] == 'paypal' ? $ad['who'] : $_SESSION['cust_id']);
		$qStr 		= "SELECT * FROM $table2,$table3 WHERE $table3.country = $where_col AND $table3.who = '$who_custId' LIMIT 0,1";		
		$res 		= mysql_query($qStr);
		$dAd		= mysql_fetch_assoc($res);
	
		
		$addressD 	= str_replace("#","<br/>",$dAd[address_format]);
		
		$name		= $dAd[f_name] . ' ' . $dAd[l_name];
		if (strpos($addressD,'NAME') !== false) {
				$addressD 	= str_replace("NAME",strtoupper($name),$addressD);
		}
		if (strpos($addressD,'name') !== false) {
				$addressD 	= str_replace("name",$name,$addressD);
		}
		
		$addressD = address_token_replacer($addressD,'%STREET%',$dAd);
		$addressD = address_token_replacer($addressD,'%HSNO%',$dAd);
		$addressD = address_token_replacer($addressD,'%STRNO%',$dAd);
		$addressD = address_token_replacer($addressD,'%STRNAM%',$dAd);
		$addressD = address_token_replacer($addressD,'%PB%',$dAd);
		$addressD = address_token_replacer($addressD,'%PO%',$dAd);
		$addressD = address_token_replacer($addressD,'%PZONE%',$dAd);
		$addressD = address_token_replacer($addressD,'%CROSSSTR%',$dAd);		
		$addressD = address_token_replacer($addressD,'%COLONYN%',$dAd);
		$addressD = address_token_replacer($addressD,'%DISTRICT%',$dAd);
		$addressD = address_token_replacer($addressD,'%REGION%',$dAd);	
		$addressD = address_token_replacer($addressD,'%PLACE%',$dAd);
		$addressD = address_token_replacer($addressD,'%STATE%',$dAd);
		$addressD = address_token_replacer($addressD,'%ZIP%',$dAd);
		$addressD = address_token_replacer($addressD,'%COUNTRY%',$dAd);
	}
	
	
	// pdf should be produced? we process the html first and simply replace <br/>
	if($option == 'pdf' || $option == 'pdf_cust_address'){		
		$addr_parts = explode("<br/>",$address);
		
		foreach($addr_parts as $p){
			$pdf->Cell(0,6,utf8_decode($p),0,1);		
		}
	}
	
	
	if($option == 'pdf_delivery_address'){		

		$addr_parts 	= explode("<br/>",$address);
		$addrD_parts 	= explode("<br/>",$addressD);
		
		// we count the differnt arrays to determine if the address have a differnt amount of lines
		$num1 			= count($addr_parts);
		$num2 			= count($addrD_parts);
		
		$pdf->SetFont('Arial','I',8);
		
		$pdf->Cell(50,6,__('Billing address:','wpShop'),'R',0);	
		$pdf->Cell(5,6,NULL,0,0);	
		$pdf->Cell(50,6,__('Delivery address:','wpShop'),0,1);	
		
		$pdf->SetFont('Arial','',10);
		
		foreach($addr_parts as $key => $p){
			
			$d = $addrD_parts[$key];
		
			$pdf->Cell(50,6,utf8_decode($p),'R',0);	
			$pdf->Cell(5,6,NULL,0,0);	
			$pdf->Cell(50,6,utf8_decode($d),0,1);	
		}
		// yes, the delivery address has more line
		if($num2 > $num1){
		
			$diff = $num2 - $num1;
			$key++;
			for($i=0,$j=$key;$i<$diff;$i++,$j++){
			
				$d = $addrD_parts[$key];
				
				$pdf->Cell(50,6,NULL,'R',0);	
				$pdf->Cell(5,6,NULL,0,0);	
				$pdf->Cell(50,6,utf8_decode($d),0,1);				
			}
		}
	}	
	
		
return $address;
}


function address_token_replacer($address,$needle,$replace){
	$needle_lower 	= strtolower($needle);
	$key 			= $needle_lower;
	$key 			= substr(substr($key, 1), 0, -1);	//remove % form end and beginning
 
	if(($needle == '%PLACE%') || ($needle == '%place%')){
		$key = 'town';
	}

	if (stripos($address,$needle) !== false) {	
		if(strpos($address,$needle) !== false){
				
				if(extension_loaded('mbstring')){
					$address = str_replace($needle,mb_strtoupper($replace["$key"]),$address);
				}
				else {
					$address = str_replace($needle,strtoupper($replace["$key"]),$address);
				}
				
		}
		else{
			$address = str_replace($needle_lower,$replace["$key"],$address);
		}
	}	
return $address;
}

function province_me($ct,$sel=1,$option='billing'){
	
	$table 	= is_dbtable_there('countries');
	$sql 	= "SELECT states FROM $table WHERE abbr = '$ct' LIMIT 0,1";
	$res	= mysql_query($sql);
	$row	= mysql_fetch_assoc($res);
	
	$arr 	= explode('#',$row['states']);
	
	if($option == 'billing'){
		$data 	= "<select id='statelist' name='state' size='1' title='State selection'>";	
	}
	if($option == 'delivery'){	
		$data 	= "<select id='statelist' name='state|2' size='1' title='State selection'>";
	}
	
	foreach($arr as $v){
	
		$kv 		= explode('|',$v);
		$selected 	= ($kv[0] == $sel ? 'selected="selected"' : NULL);

		$data .= "<option value='$kv[0]' {$selected}>$kv[1]</option>";
	}
	
	$data .= "</select><br />";
	
return $data;
}

function display_state_list($d_country){

	$result = FALSE;
	$table 	= is_dbtable_there('countries');
	$sql 	= "SELECT display_state_list FROM $table WHERE abbr = '$d_country'";
	$res	= mysql_query($sql);
	$row	= mysql_fetch_assoc($res);

	if($row['display_state_list'] == 1){
		$result = TRUE;
	}

return $result;
}

##################################################################################################################################
// 												DELIVERY-ADDRESS
##################################################################################################################################
function retrieve_delivery_addr($option='FE',$order=1){

	$table 	= is_dbtable_there('delivery_addr');

	if($option == 'FE'){
		$sql	= "SELECT * FROM $table WHERE who = '$_SESSION[cust_id]' LIMIT 0,1";
		$res	= mysql_query($sql);
		$row 	= mysql_fetch_assoc($res);
	}
	else {
		$sql	= "SELECT * FROM $table WHERE who = '$order[who]' LIMIT 0,1";
		$res	= mysql_query($sql);
		$row 	= mysql_fetch_assoc($res);
	}

return $row; 
}

function diversity_check($order,$billing,$option='FE'){

	$fields 	= 'l_name|f_name|street|hsno|strno|strnam|po|pb|pzone|crossstr|colonyn|district|region|state|zip|town|country';
	$diverse	= FALSE;
	
	
	// BE needs a bit a different handling	
	if($option == 'BE'){
		$table 	= is_dbtable_there('delivery_addr');
		$sql	= "SELECT * FROM $table WHERE who = '$order[who]' LIMIT 0,1";
		$res	= mysql_query($sql);
		$billing= mysql_fetch_assoc($res);
	}	
	
	
	foreach($order as $k => $v){
		if((strpos($fields,$k) !== FALSE) && (!empty($order[$k]))){
		
			$order[$k] 		= str_replace(' ', '',$order[$k]);
			$billing[$k] 	= str_replace(' ', '',$billing[$k]);
		
			if($order[$k] != $billing[$k]){			
				$diverse = TRUE;
			}		
		}
	}
return $diverse; 
}

##################################################################################################################################
// 												ERROR - HANDLING
##################################################################################################################################
//change.9.10
function error_explanation($errNo,$withDiv='no'){

	include WP_CONTENT_DIR . '/themes/'.WPSHOP_THEME_NAME.'/lib/static-info/errors/error_details.php';		

	if($withDiv == 'no'){
		$explanation = $ERROR_DETAILS[$errNo];
	}
	else {
		$explanation = "<div class='error_explanation' style='color: green; background: lime;'>";
		$explanation .= $ERROR_DETAILS[$errNo];
		$explanation .= "</div>";
	}
	
return $explanation;
}
//\change.9.10


##################################################################################################################################
// 												STOCK-CONTROL
##################################################################################################################################
function stock_control_deluxe($ID_item,$amount=1,$attr,$option='add',$post_id=NULL)
{
		global $wpdb,$OPTION;
		
		$EMAIL 	= load_what_is_needed('email');		//change.9.10
		
		switch($option)
		{
			//change.9.9
			case 'add':
				// how many articles right now on stock?
				$table 	= is_dbtable_there('inventory');	
				$at 	= attr_sql_addition($attr);
				
				$qStr1 	= "SELECT amount FROM $table WHERE ID_item = '$ID_item' $at LIMIT 0,1";
				$res1 	= mysql_query($qStr1);
				$row	= mysql_fetch_assoc($res1);					
				$numNow = (int) $row['amount'];

				// minus amount + update db, but only if amount is not zero
				if($numNow > 0){
					$stockNow 	= $numNow - $amount;
					
					// stock equal or below threshold - we sent email to merchant 
					if( $stock  <=  $OPTION['wps_stock_warn_threshold']){
						$search		= array("[##header##]","[##ID_item##]");						
						$replace 	= array($EMAIL->email_header(),$ID_item);		//change.9.10
						$EMAIL->stock_low_email($ID_item,$search,$replace);			//change.9.10
					}					
				
					$qStr 	= "UPDATE $table SET amount = '$stockNow' WHERE ID_item = '$ID_item' $at";
					mysql_query($qStr);
					$stock 	= 1;		
				}
				else {$stock = 0;}		
			break;
			//\change.9.9
			
			case 'update':
							
				// how many articles are in cart 
				$table 	= is_dbtable_there('shopping_cart');
				$at 	= attr_sql_addition($attr,2);
				$qStr 	= "SELECT * FROM $table WHERE who = '$_SESSION[cust_id]' AND cid = '$ID_item' $at LIMIT 0,1";
				$res 	= mysql_query($qStr);
				$row1	= mysql_fetch_assoc($res);
				$num 	= (int) $row1[item_amount]; 								
					
				// compare the updated amount number with number in cart
								
					// if higher: get difference, subtract from currently_in_stock
					if($amount > $num){
					
										
						$difference = $amount - $num;
										
						// how many articles right now on stock?
						$table 	= is_dbtable_there('inventory');	
						$at 	= attr_sql_addition($attr);						
						$qStr1 	= "SELECT amount FROM $table WHERE ID_item = '$row1[item_id]' $at LIMIT 0,1";
										
						$res1 	= mysql_query($qStr1);
						$row	= mysql_fetch_assoc($res1);							
						$numNow = (int) $row['amount'];		
																
						$newNum = $numNow - $difference;
						
						if($newNum >= 0){ // we cannot have minus articles :-)	
						
							$qStr 	= "UPDATE $table SET amount = '$newNum' WHERE ID_item = '$row1[item_id]' $at";		
						
							mysql_query($qStr);						
							$stock = 'OK';
							
									// stock equal or below threshold - we sent email to merchant 
									if($num  <=  $OPTION['wps_stock_warn_threshold']){
										$ID_item	= cid2item_id($ID_item);
										$search		= array("[##header##]","[##ID_item##]");						
										$replace 	= array($EMAIL->email_header(),$ID_item);	//change.9.10
										$EMAIL->stock_low_email($ID_item,$search,$replace);		//change.9.10
									}
						}
						else {
							$stock = $numNow;
						}
					}
					
					// if lower:  get difference, raise currently_in_stock by difference 
					if($amount < $num){
																				
						$difference = $num - $amount;						
						
						// how many articles right now on stock?
						$table 	= is_dbtable_there('inventory');
						$at 	= attr_sql_addition($attr);						
						$qStr1 	= "SELECT amount FROM $table WHERE ID_item = '$row1[item_id]' $at LIMIT 0,1";						

						$res1 	= mysql_query($qStr1);
						$row	= mysql_fetch_assoc($res1);							
						$numNow = (int) $row['amount'];
						
						$stock 	= $numNow + $difference;	
						
						$qStr 	= "UPDATE $table SET amount = '$stock' WHERE ID_item = '$row1[item_id]' $at";
						mysql_query($qStr);
						$stock = 'OK';						
					}
			
			break;
			
			case 'remove':
				// how many articles are in cart 
				$table 	= is_dbtable_there('shopping_cart');
				$at 	= attr_sql_addition($attr);
				$qStr 	= "SELECT * FROM $table WHERE who = '$_SESSION[cust_id]' AND cid = '$ID_item' LIMIT 0,1";				
				$res 	= mysql_query($qStr);
				$row	= mysql_fetch_assoc($res);
				$num 	= (int) $row[item_amount]; 
				
				// how many articles right now on stock?
				$table 	= is_dbtable_there('inventory');				
				$qStr1 	= "SELECT amount FROM $table WHERE ID_item = '$row[item_id]' $at LIMIT 0,1";				
				$res1 	= mysql_query($qStr1);				
				$row1	= mysql_fetch_assoc($res1);						
				$numNow = (int) $row1['amount'];			
					
				// add both article in cart + number of stock 
				$numNew	= $numNow + $num;
				$qStr 	= "UPDATE $table SET amount = '$numNew' WHERE ID_item = '$row[item_id]' $at";
				mysql_query($qStr);					
			break;
						
			case 'end_control':  // before order is sent off - not needed at the moment
							
			break;
			
			
			case 'amount_now':
				
				$table 		= is_dbtable_there('inventory');
				
				
				// lets get the ID_item
				$qStr 		= "SELECT meta_value FROM $wpdb->postmeta WHERE post_id = $post_id AND meta_key = 'ID_item' LIMIT 0,1";
				$res 		= mysql_query($qStr);
				$row 		= mysql_fetch_assoc($res);
				$ID_item	= $row[meta_value];

		
				$at 	= attr_sql_addition($attr);
				$qStr 	= "SELECT amount FROM $table WHERE ID_item = '$ID_item' $at LIMIT 0,1";			
				$res 	= mysql_query($qStr);
				$num	= mysql_num_rows($res); // 0 = stock option was not set for article
				if($num > 0){
					$row	= mysql_fetch_assoc($res);						
					$stock 	= (int) $row['amount'];	
				}
				else{
					$stock = 'not_set';
				}
			break;
		}
		
return $stock;		
}

function attr_sql_addition($attr,$option=1){

	if(strlen($attr)){
		$at = NULL;
		
		switch($option){
			
			case 1:
				$parts = explode("#",$attr);
				foreach($parts as $v){
					$p = explode("=",$v);
					$at .= ' AND ' . strtolower($p[0]) . ' = ' . "'$p[1]'";
				}			
			break;
			
			case 2:
				$at .= " AND item_attributs = '$attr'";
			break;
		}
	}
	else{
		$at = NULL;
	}
	
return $at;
}

function all_gone($pid){
	
	$ID_item 	= postid_2_IDitem($pid);
	
	$table 		= is_dbtable_there('inventory');
	$qStr 		= "SELECT sum(amount) FROM $table WHERE ID_item = '$ID_item'";
	$res 		= mysql_query($qStr);
	$erg		= (int) mysql_result($res,0,0);
		
	$feedback 	= ($erg == 0 ? TRUE : FALSE);
	
return $feedback;
}

function clean_inventory(){

	global $OPTION;

	$table1 = is_dbtable_there('orders');
	$table2 = is_dbtable_there('shopping_cart');
	$table3 = is_dbtable_there('inventory');

	$sql1 	= "SELECT who FROM $table1 WHERE level IN('0','4','5','6','7','8')";
	$sql2 	= "SELECT who, item_id, item_amount, item_attributs FROM $table2";
	
	// we check who ordered
	$res 	= mysql_query($sql1);
	while($row = mysql_fetch_assoc($res)){
			$arr1[] = $row['who'];
	}	
	
	// we check who has what items in shopping cart
	$res 	= mysql_query($sql2);
	while($row = mysql_fetch_assoc($res)){
			$arr2[] = array('who' => $row['who'], 'item_id' => $row['item_id'], 'amount' => $row['item_amount'], 'attr' => $row['item_attributs']);
	}	
	
	// timelimit is defined
	$tlimit 	= time() - $OPTION['wps_inventory_cleaning_interval'];

	$del_attr 	= NULL;
	$info		= NULL;
	$found		= 0;
	

	
	// is the who of the order table found in shopping cart table with a time after time limit? 
	if((!empty($arr2)) && ($arr1 != NULL)){
		foreach($arr2 as $k => $v){
		
			if(!in_array($v['who'],$arr1)){
			
				$found++;
				$info .= $v['who'] . "<br/>";	
			
				$t = explode("-",$v['who']);
				if($t[0] < $tlimit){
			
					$w = "UPDATE $table3 SET amount = amount+$v[amount] WHERE ID_item = '$v[item_id]' AND ";
				
					if(!empty($v[attr])){
					
						$del_attr = NULL;
						
						$p = explode("#",$v[attr]);
						foreach($p as $at){
								$a = explode("=",$at);
						
								$w .= strtolower($a[0])." = '$a[1]' AND ";
						}
						$del_attr = "AND item_attributs = '$v[attr]'";
					}
					$w = substr($w,0,-4);
					
					$y = "DELETE FROM $table2 WHERE who = '$v[who]' $del_attr";			
					$info .= "<span style='font-size:13px;'>$v[who] is not in orders table - Item-ID: $k - $v[amount] - $w | $y</span>" . "<br/>";
					
					mysql_query($w);
					mysql_query($y);
					
					$info .= "$v[who] - done." . "<br/>";
				}
			}		
		}
	}
	
	if($found == 0){
		$info = 'No orphaned articles found.';
	}
	else {
		inventory_notifier(); //we notify shop owner by email about status
	}
	
	
	// test feedback for owner 
	#echo $info;
	
	
	// test notification via email 
	#$to 			= $OPTION['wps_shop_email'];
	#$subject 		= 'Inventory cleaned';
	#$text 			= "Inventory was cleaned up. $info";
	#mail($to,$subject,$text,"From: Test <$to>");
}

function inventory_notifier(){

	global $OPTION;

	// how many items are now on 0 ? 
	$table	= is_dbtable_there('inventory');
	$sql	= "SELECT * FROM $table WHERE amount = '0' ORDER BY ID_item";
	$res 	= mysql_query($sql);
	$num 	= mysql_num_rows($res);
	
	
	if($num > 0){
		$notification = "The amount of the following article is on 0: \n\n";
			while($row = mysql_fetch_assoc($res)){

				$notification .= $row['ID_item'].' : ';
				
				unset($row['iid']);
				unset($row['amount']);
				unset($row['ID_item']);

					foreach($row as $k => $v){
						$notification .= ' '.$k.': '.$v.' - ';
					}
				$notification .= "\n";
			}
	}
	else {
		$notification = "The amount for all articles is sufficient. \n\n";	
	}
	
		//for testing purposes		
		#echo $notification;

		//mail to shop owner
		/*
		$to 			= $OPTION['wps_stock_warn_email'];
		$from 			= $OPTION['wps_shop_email'];
		$shopname		= $OPTION['wps_shop_name'];
		$subject 		= 'Inventory notification';
		$text 			= $notification;
		mail($to,$subject,$text,"From: $shopname <$from>");
		*/
}

function postid_2_IDitem($post_id){

	global $wpdb;

	$qStr 	= "SELECT meta_value FROM $wpdb->postmeta WHERE post_id = '$post_id' AND meta_key = 'ID_item' LIMIT 0,1";					
	$res	= mysql_query($qStr);
	$row	= mysql_fetch_assoc($res);
	$ID_item= $row[meta_value];

return $ID_item;
}

##################################################################################################################################
// 												GOOGLE  
##################################################################################################################################
function google_analytics($profile_id='1111'){

$code = "
	<script type=\"text/javascript\">
	var gaJsHost = ((\"https:\" == document.location.protocol) ? \"https://ssl.\" : \"http://www.\");
	document.write(unescape(\"%3Cscript src='\" + gaJsHost + \"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E\"));
	</script>
	<script type=\"text/javascript\">
	try {
	var pageTracker = _gat._getTracker(\"$profile_id\");
	pageTracker._trackPageview();
	} catch(err) {}</script>
";

return $code ;
}

function google_adsense($ad_no){

	echo stripslashes(get_option('wps_google_adsense_'.$ad_no));

}

##################################################################################################################################
// 												SESSION - HANDLING 
##################################################################################################################################
function custid_used_for_order(){

		if(!isset($_SESSION['cust_id'])){$_SESSION['cust_id'] = NULL;}
		$table 	= is_dbtable_there('orders');
		$qStr 	= "SELECT oid FROM $table WHERE who = '$_SESSION[cust_id]' AND level IN ('4','5','6','7','8')";
		$res 	= mysql_query($qStr);
		$num 	= mysql_num_rows($res);
		
		$result = ($num != 0 ? TRUE : FALSE);
		
	return $result;
	}

##################################################################################################################################
// 												ENCODING 
##################################################################################################################################
function utf2latin($text)
{ 
		$text=htmlentities($text,ENT_COMPAT,'UTF-8'); 
return html_entity_decode($text,ENT_COMPAT,'ISO-8859-1'); 
} 


function encode_email_subject($subject){		
	
	switch(WPLANG){
		
		case 'ja':
			mb_language("ja");
			$subject = mb_convert_encoding($subject,"ISO-2022-JP","AUTO");
			$subject = base64_encode($subject); 
			// Add the encoding markers to the subject 
			$subject = "=?ISO-2022-JP?B?" . $subject . "?=";
		break;
	
		default:
			if(extension_loaded('mbstring')){ 
				$subject = mb_convert_encoding($subject,"iso-8859-1","auto");	
			} 
		
			// Now, base64 encode the subject 
			$subject 	= base64_encode($subject); 
			// Add the encoding markers to the subject 
			$subject 	= "=?iso-8859-1?B?" . $subject . "?=";		
		break;
	}
	
return $subject;
}



function pdf_encode($data){
		
		if(extension_loaded('mbstring')){ 
			$data = mb_convert_encoding($data,"iso-8859-1","auto");	
		}
		// utf8_decode() might be also interesting...
		
		$data = stripslashes($data);
	
return $data;
}


function utf8_decode_custom($value){
	
	switch(WPLANG){
	
		case 'he_IL':
			$result = $value;
		break;
		case 'ja':
			$result = $value;
		break;
		default:
			$result = utf8_decode($value);
		break;
	}

return $result;
}


function pdf_usable_language(){

	$feedback 		= FALSE;
	
	$language_arr 	= array();
	$language_arr[]	= '';
	$language_arr[]	= 'de_DE';
	$language_arr[]	= 'it_IT';
	$language_arr[]	= 'fr_FR';
	$language_arr[]	= 'es_ES';
	$language_arr[]	= 'nl_NL';
	$language_arr[]	= 'en_US';
	$language_arr[]	= 'en_UK';
	$language_arr[]	= 'en_ZA';
	#$language_arr[]	= '';		//add next language here
		
	if (in_array(WPLANG,$language_arr)){
		$feedback = TRUE;
	}

return $feedback;
}


##################################################################################################################################
// 												MEMBERSHIP
##################################################################################################################################
function clean_data($_POST){
	     foreach ($_POST as $k => $v) {
			$POST[$k] = htmlentities(strip_tags(stripslashes($v)));
			$POST[$k] = addslashes($POST[$k]);
	     }
return $POST;
}

function validate_user_email($email,$option=1){
	
		$valid = FALSE;
		if($option == 2){
				$valid = 'invalid';
		}
		
	    if(eregi("^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,6}$", $email))
		{
		     $valid = TRUE;
			 
			 if($option == 2){
				$valid = 'valid';
			 }
		}
	 
	return $valid;
	}

function generateRandomString($length = 6, $letters = '1234567890qwertyuiopasdfghjklzxcvbnm'){
	  $s = '';
	  $lettersLength = strlen($letters)-1;
	 
	  for($i = 0 ; $i < $length ; $i++)
	  {
	  $s .= $letters[rand(0,$lettersLength)];
	  }
	 
return $s;
}	

function auth($option=0){
	global $OPTION;

	$accountLog				= get_page_by_title($OPTION['wps_pgNavi_logOption']);
	$hostname 				= $_SERVER['HTTP_HOST'];
	$path 					= dirname($_SERVER['PHP_SELF']);
	$timenow       			= time();
	$browser_ver			= get_browser_version();       
	$authorized 			= 1;
	$throw_out				= $option;
	// echo "SESSION\n";

	 $current_user = wp_get_current_user();

	 if(!isset($_SESSION['user_logged'])){
		$authorized = 0;
	 }

	 if($_SESSION['user_logged'] != true){
		$authorized = 0;
	 }

	 if($timenow > $_SESSION['timeout']){
		$authorized = 0;
	 }

	 if($_SESSION['browser'] != $browser_ver){
		$authorized = 0;
	 }
	 if ( is_user_logged_in() ) {
	 	$authorized = 1;
	 }


	 if ($authorized == 0){
		//unset_user_session(); 
		
		if($throw_out == 1)
		{
			$url = get_option('siteurl').'/'.$accountLog->post_name.'';
			//echo "$url\n";
			header("Location: $url");
			exit(NULL);
		}		   
	  }

return $authorized;
}
	
function get_browser_version($option=1){
	if($option == 0)
	{
	$browser_ver	= strtolower($_SERVER['HTTP_USER_AGENT']); 
	}
	
	if($option == 1)
	{
	$browser_ver	= md5(strtolower($_SERVER['HTTP_USER_AGENT'])); 
	}
return $browser_ver; 
}

function unset_user_session(){
	$_SESSION[user_logged] = false;
	unset($_SESSION[username]);
	unset($_SESSION[timeout]);
	unset($_SESSION[browser]);
}

function logout(){	
	unset_user_session();
	
	$hostname 	= $_SERVER['HTTP_HOST'];
	$path 		= dirname($_SERVER['PHP_SELF']);
	header('Location: http://'.$hostname.($path == '/' ? '' : $path).'/'.$this_page);
	exit();
 }

function is_in_subfolder(){

	global $OPTION;

	$subfolder  = substr(strstr(get_option('siteurl'),$_SERVER['HTTP_HOST']),strlen($_SERVER['HTTP_HOST']));
	$result  	= (strlen($subfolder) > 0 ? $subfolder : 'none');
	 
	if($result[0] == "/"){
	   $result = substr($result,1);
	   
	   if(substr_count($result,"/")>0){
			$result = str_replace("/","##slash##",$result);
	   }
	}
	
return $result;
} 
 
function get_member_billing_addr($option=1){

	$table 	= is_dbtable_there('feusers');
	$sql 	= "SELECT * FROM $table WHERE uid = '$_SESSION[uid]' LIMIT 0,1";
	$res 	= mysql_query($sql);

	if($option == 1){
		$row 	= mysql_fetch_assoc($res);
	}
	if($option == 2){
		$row 	= mysql_fetch_assoc($res);
		foreach($row as $k => $v){
		
			if(!empty($v)){
				$_POST[$k] = $v;
			}
		}
		$_POST['f_name'] = $_POST['fname'];
		$_POST['l_name'] = $_POST['lname'];
	}		

return $row; 
}
 
function NWS_get_user_details(){

	$table 	= is_dbtable_there('feusers');
	$qStr 	= "SELECT * FROM $table WHERE uid = $_SESSION[uid] LIMIT 0,1";
	$res 	= mysql_query($qStr);
	$row 	= mysql_fetch_assoc($res, MYSQL_ASSOC); 
	
return $row;
} 
 

	
##################################################################################################################################
// 												SSL
##################################################################################################################################
function adjust2ssl($val){
	if($_SERVER['HTTPS'] == 'on' || $_SERVER['SSL'] == '1'){
		$val = preg_replace('|/+$|', '', $val);
		$val = preg_replace('|http://|', 'https://', $val);
	}
return $val;
}	


function NWS_bloginfo($option,$echo = 'no'){

	$val = get_bloginfo($option); 
	if($_SERVER['HTTPS'] == 'on' || $_SERVER['SSL'] == '1') {
		$val = preg_replace('|/+$|', '', $val);
		$val = preg_replace('|http://|', 'https://', $val);
	}	

	if($echo == 'yes'){
		echo $val;
	}
	else {
		return $val;
	}
}


function get_protocol(){

	if(($_SERVER['HTTPS'] == 'on')||($_SERVER['HTTPS'] == '1') || ($_SERVER['SSL'] == '1')){
		$protocol 	= 'https://';
	}
	elseif($_SERVER['HTTPS'] == 'off'){
		$protocol 	= 'http://';
	}
	elseif(empty($_SERVER['HTTPS'])){
		$protocol 	= 'http://';
	}
	else {}
	
return $protocol;
}


##################################################################################################################################
// 												PERSONALIZATION
##################################################################################################################################
function get_item_personalization($post,$orderby,$order){

	global $wpdb;
	
	
	$qStr 	= "SELECT * FROM $wpdb->postmeta WHERE post_id = $post AND meta_key LIKE 'item_pers_%' ORDER BY $orderby $order";
	$res 	= mysql_query($qStr);
	$i		= 1;
	$output = NULL; 	
	
	while($row = mysql_fetch_assoc($res)){
		$mkey_p     = explode("_",$row[meta_key]);
		$value 		= get_custom_field($row[meta_key], FALSE);
		$output		.=  "<label for='item_pers_{$i}'>$value</label>";
		switch($mkey_p[2]){
			case 'single':
			$output		.=  "<input class='pers_text' type='text' id='item_pers_{$i}' name='item_pers_{$i}' />";
			$output		.=  "<input type='hidden' id='item_pers_hid_{$i}' name='personalize_label_{$i}' value='$value' />";
			break;
			
			case 'multi':
				$output		.=  "<textarea class='pers_textarea' rows='8' cols='30' id='item_pers_{$i}' name='item_pers_{$i}' >";
				$output		.= "</textarea>";
				$output		.=  "<input type='hidden' id='item_pers_hid_{$i}' name='personalize_label_{$i}' value='$value' />";
			break;
		}
		
		$i++;
	}
	return $output; 
}

function has_personalization($post){
	global $wpdb;

	$qStr 	= "SELECT * FROM $wpdb->postmeta WHERE post_id = $post AND meta_key LIKE 'item_pers_%'";
	$res 	= mysql_query($qStr);
	$num 	= mysql_num_rows($res);
	
	$result = ($num > 0 ? $result=TRUE : $result=FALSE);
	
	return $result;	
}

function personalization_chksum(){

	$chk	= NULL;
	
	foreach($_POST as $k => $v){

		if((strpos($k,'item_pers_') !== false)&&(!empty($v))){
				$parts 		= explode("_",$k);
				$labelKey	= 'personalize_label_'.$parts[2];
				
				$chk .= $k.$_POST[$labelKey].$v;
		}		
		$i++;
	}
	
	$chksum = ($chk != NULL ? md5($chk) : 'no');
	
return $chksum;
}

function save_personalization($row){

	$table	= is_dbtable_there('personalize');
	$cid	= $row['cid'];							

	foreach($_POST as $k => $v){

		if((strpos($k,'item_pers_') !== false)&&(!empty($v))){
				$parts 		= explode("_",$k);
				$labelKey	= 'personalize_label_'.$parts[2];

				$column_array 		= array();
				$value_array 		= array();

				$column_array[0]	= 'pers_id';		$value_array[0] = '';
				$column_array[1]	= 'cid';			$value_array[1] = $cid;
				$column_array[2]	= 'pers_name';		$value_array[2] = $k;
				$column_array[3]	= 'pers_label';		$value_array[3] = $_POST[$labelKey];
				$column_array[4]	= 'pers_value';		$value_array[4] = $v;
					
				db_insert($table,$column_array,$value_array);		
		}		
	}
	
return $cid;
}

function update_personalization($oldVal,$newVal){

	// when moving an item from cart to wishlist the cid value needs to be updated + vice versa
	$table	= is_dbtable_there('personalize');
		
	$qStr = "UPDATE $table 
				SET cid = $newVal
			WHERE 
				cid = $oldVal";

	mysql_query($qStr);
	
return $newVal;
}

function retrieve_personalization($cid,$mode='html'){  	

	$personalize 	= NULL;
	$table			= is_dbtable_there('personalize');	
	$sql 			= "SELECT * FROM $table WHERE cid = $cid ORDER BY pers_name";
	$res			= mysql_query($sql);
	$num 			= mysql_num_rows($res);
	
	switch($mode){
	
		case 'html':
			if($num > 0){
				while($data = mysql_fetch_assoc($res)){			
					$personalize .= $data['pers_label'] .":<br/>". $data['pers_value']."<br/>";
				}
			}
		break;

		case 'txt_mail':
			if($num > 0){
				while($data = mysql_fetch_assoc($res)){			
					$personalize .= $data['pers_label'] .': '. $data['pers_value']."\n";
				}
			}
		break;
		
		case 'pdf':
			if($num > 0){
				$personalize 	= array();
				$i				= 0;
				while($data = mysql_fetch_assoc($res)){			
					$personalize[$i] = $data['pers_label'] .': '. $data['pers_value'];
					$i++;
				}
			}
			else {
				$personalize = 'none';
			}
		break;
	}
return $personalize;
}

##################################################################################################################################
// 												ENCRYPTION - DECRYPTION
##################################################################################################################################
function NWS_encode($string){ 

	$key 	= get_option('wps_paypal_encode_key');
	$key 	= sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
	
    for ($i = 0; $i < $strLen; $i++){
        $ordStr = ord(substr($string,$i,1));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
    }
	
return $hash;
}

function NWS_decode($string){

	$key 	= get_option('wps_paypal_encode_key');
    $key 	= sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
	
    for ($i = 0; $i < $strLen; $i+=2) {
        $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
	
return $hash;
}

##################################################################################################################################
// 												PRICE - FORMAT
##################################################################################################################################
function format_price($price){
	
	global $OPTION;
	
	switch($OPTION['wps_price_format']){
	
		case '1':
			$price = number_format($price, 2, ',', '');
		break;		
		
		case '2':
			$price = number_format($price, 2, '.', '');
		break;		
		
		case '3':
			$price = number_format($price, 2, ',', '.');
		break;		
		
		case '4':
			$price = number_format($price, 2, '.', ',');
		break;		
		
		case '5':
			$price = number_format($price, 2, ',', ' ');
		break;		
		
		case '6':
			$price = number_format($price, 2, ',', "'");
		break;
		
		case '7':
			$price = number_format($price,0, ',',' ');
		break;
		
		case '8':
			$price = number_format($price,0, '.', ',');
		break;		
		
		case '9':
			$price = number_format($price,0);
		break;
		
		default:
		break;
	}
	
return $price;
}

##################################################################################################################################
// 												TRANSLATE MONTHS
##################################################################################################################################

function NWS_translate_date(){
	
	global $OPTION;
	
	$en_langs 	= array();
	$en_langs[] = 'en_GB';
	$en_langs[] = 'en_US';
	$en_langs[] = 'en_AU';
	$en_langs[] = 'en_CA';
	$en_langs[] = 'en_IE';
	$en_langs[] = 'en_NZ';
	$en_langs[] = 'en_PH';
	$en_langs[] = 'en_ZA';
	$en_langs[] = '';
		
	if(in_array(WPLANG,$en_langs) === FALSE){
	
		$monthEN 					= date('F');

		$months_trans				= array();		
		$months_trans['January']	= __('January','wpShop');
		$months_trans['February']	= __('February','wpShop');
		$months_trans['March']		= __('March','wpShop');
		$months_trans['April']		= __('April','wpShop');
		$months_trans['May']		= __('May','wpShop');
		$months_trans['June']		= __('June','wpShop');
		$months_trans['July']		= __('July','wpShop');
		$months_trans['August']		= __('August','wpShop');
		$months_trans['September']	= __('September','wpShop');
		$months_trans['October']	= __('October','wpShop');
		$months_trans['November']	= __('November','wpShop');
		$months_trans['December']	= __('December','wpShop');
		
		
		switch(WPLANG){
			case 'de_DE': 
				#$date_order			= date($OPTION['date_format']);		// use maybe a theme option
				$date_order			= date("j.n.Y");
			break;
			default:
				$date_order			= date($OPTION['date_format']);
			break;
		}
		
		// in case a month name should appear it will be translated 
		$date_order 				= str_replace($monthEN,$months_trans[$monthEN],$date_order);
	}
	else {
		$date_order					= date($OPTION['date_format']);	
	}

return $date_order;
}

##################################################################################################################################
// 												FILTERING
##################################################################################################################################
function mysql_prep_escape($value) 
{ 
	if(get_magic_quotes_gpc() == 1){ 
		$value = mysql_real_escape_string($value);
	} else { 
		$value = addslashes($value); 
	} 
return $value; 
}

function dbquery_now($val){
	$result = NULL;
return $result;
}
 
##################################################################################################################################
// 												MODULES
##################################################################################################################################
function list_modules($cat = 'something'){

	$arr = array();

		// this change was necessary b'c a PHP warning showed up at theme preview before activation - only difference is @
		if(($_GET['preview'] == '1') && (isset($_GET['template'])) && (isset($_GET['stylesheet']))){
	
			if($handle = @opendir(WP_CONTENT_DIR . '/themes/'.WPSHOP_THEME_NAME.'/lib/modules/'.$cat.'/')) 
			{
			 while(($file = readdir($handle)) !== FALSE){
			 
				if(($file != ".")&&($file != "..")){
					$arr[] = $file;	
				}
			 }
			 closedir($handle);
			}
		}
		else{
		
			if($handle = opendir(WP_CONTENT_DIR . '/themes/'.WPSHOP_THEME_NAME.'/lib/modules/'.$cat.'/')) 
			{
			 while(($file = readdir($handle)) !== FALSE){
			 
				if(($file != ".")&&($file != "..")){
					$arr[] = $file;	
				}
			 }
			 closedir($handle);
			}
		}
	
return $arr;
}

//change.9.10
function load_what_is_needed($class){
	
	$path 	= WP_CONTENT_DIR . '/themes/'.WPSHOP_THEME_NAME.'/lib/engine/';
	$class	= trim($class);
	
	require_once($path.'class.' . $class . '.php');
	$object = new $class();
	
return $object;
}
//\change.9.10

##################################################################################################################################
// 												THEME - INSTALLATION STATUS - UPGRADES
##################################################################################################################################
//rev16022011-9.9
function installation_status(){

		$table 	= is_dbtable_there('status');
		$qStr	= "SELECT status FROM $table WHERE id = 1 LIMIT 0,1";
		$res 	= mysql_query($qStr);
		$row 	= mysql_fetch_assoc($res);
			
return (int)$row['status'];			
}

function installation_status_change(){

	if((isset($_POST['install-step'])) && (isset($_POST['step']))){
	
		$status = (int)$_POST['step'];
		$table 	= is_dbtable_there('status');
		$qStr	= "UPDATE $table SET status = $status WHERE id = 1";
		$res 	= mysql_query($qStr);
	}	
}

//this function should be merged later with silent db ugrade
function update_the_theme_if_necessary($return=0){

	global $wpdb,$CONFIG_WPS,$OPTION;

	$table 	= is_dbtable_there('status');
	$qStr 	= "SELECT th_vers FROM $table LIMIT 0,1";
	$res 	= mysql_query($qStr);
	if($res === FALSE){
		$pfix 	= $wpdb->prefix . $CONFIG_WPS[prefix];	
		$sql	= array();
		$sql[0] = "ALTER TABLE {$pfix}orders ADD `custom_note` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `email`";
		$sql[1] = "ALTER TABLE {$pfix}orders ADD `d_addr` ENUM( '0', '1' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' AFTER `country` ";
		$sql[2] = "ALTER TABLE {$pfix}shopping_cart ADD `item_personal` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `item_attributs`";
		$sql[3] = "ALTER TABLE {$pfix}inquiries ADD `custom_note` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `email`";
		$sql[4] = "ALTER TABLE {$pfix}wishlist ADD `item_personal` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `item_attributs`";

		$sql[5] = "ALTER TABLE {$pfix}feusers ADD `street` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `lname`";
		$sql[6] = "ALTER TABLE {$pfix}feusers ADD `hsno` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `street`";
		$sql[7] = "ALTER TABLE {$pfix}feusers ADD `strno` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `hsno`";
		$sql[8] = "ALTER TABLE {$pfix}feusers ADD `strnam` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `strno`";
		$sql[9] = "ALTER TABLE {$pfix}feusers ADD `po` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `strnam`";
		$sql[10] = "ALTER TABLE {$pfix}feusers ADD `pb` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `po`";
		$sql[11] = "ALTER TABLE {$pfix}feusers ADD `pzone` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `pb`";
		$sql[12] = "ALTER TABLE {$pfix}feusers ADD `crossstr` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `pzone`";
		$sql[13] = "ALTER TABLE {$pfix}feusers ADD `colonyn` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `crossstr`";
		$sql[14] = "ALTER TABLE {$pfix}feusers ADD `district` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `colonyn`";
		$sql[15] = "ALTER TABLE {$pfix}feusers ADD `region` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `district`";
		$sql[16] = "ALTER TABLE {$pfix}feusers ADD `state` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `region`";
		$sql[17] = "ALTER TABLE {$pfix}feusers ADD `zip` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `state`";
		$sql[18] = "ALTER TABLE {$pfix}feusers ADD `town` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `zip`";
		$sql[19] = "ALTER TABLE {$pfix}feusers ADD `country` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `town`";
		
		$sql[20] = "DROP TABLE {$pfix}countries";
		
		$sql[21] = "ALTER TABLE {$pfix}inquiries CHANGE `amount` `amount` DECIMAL( 12, 2 ) NOT NULL";
		$sql[22] = "ALTER TABLE {$pfix}inquiries CHANGE `shipping_fee` `shipping_fee` DECIMAL( 12, 2 ) NOT NULL";		 
		$sql[23] = "ALTER TABLE {$pfix}orders CHANGE `shipping_fee` `shipping_fee` DECIMAL( 12, 2 ) NOT NULL";		 
		$sql[24] = "ALTER TABLE {$pfix}orders CHANGE `amount` `amount` DECIMAL( 12, 2 ) NOT NULL";
		$sql[25] = "ALTER TABLE {$pfix}shopping_cart CHANGE `item_price` `item_price` DECIMAL( 12, 2 ) NOT NULL";
		$sql[26] = "ALTER TABLE {$pfix}wishlist CHANGE `item_price` `item_price` DECIMAL( 12, 2 ) NOT NULL";
		
		$val 	 = get_option('siteurl') . '/wp-content/themes/'. $CONFIG_WPS[themename] .'/ipn.php?pst='.md5(get_option('wps_paypal_pdttoken').NONCE_KEY);
		$sql[27] = "UPDATE $wpdb->options SET option_value = '$val' WHERE option_name = 'wps_ipn_url'";
		
		$sql[28] = "ALTER TABLE {$pfix}status ADD `th_vers` VARCHAR( 50 ) NOT NULL";
		$sql[29] = "UPDATE {$pfix}status SET `th_vers` = '1.0.5' WHERE id =1";
		
		foreach($sql as $v){
			mysql_query($v);
		}
		if($return == 0){
		echo "<div style='color: green; font-weight:800;background:#A5D69C;'>".
				__('Success! Database values for theme `TheFurnitureStore` were updated.<br/>
				Attention! Pls. reset the country zones for shipping if necessary.','wpShop')."</div>";	
		}
		else{
			$feedback =  "<div style='color: green; font-weight:800;background:#A5D69C;'>".
						__('Success! Database values for theme `TheFurnitureStore` were updated.<br/>
						Attention! Pls. reset the country zones for shipping if necessary.','wpShop')."</div>";		

			return $feedback;
		}
	}
}


//silent DB-upgrade for change9.4 + 9.6 ,if needed
function silent_db_upgrade(){	
	
	global $wpdb,$CONFIG_WPS;
	
	$table 	= is_dbtable_there('status');
	$sql	= "SELECT th_vers FROM $table WHERE id = 1 LIMIT 0,1";
	$res	= mysql_query($sql);
	$row 	= mysql_fetch_assoc($res);
	
	if($row['th_vers'] !== 'change.9.6'){
	
		$collate1 = 'COLLATE utf8_general_ci';									
		$collate2 = 'DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci';		

		$pfix 	= $wpdb->prefix . $CONFIG_WPS['prefix'];				
		$sql94	= array();
		
		$sql94[0] = "ALTER TABLE {$pfix}orders ADD `net` decimal(12,2) NOT NULL AFTER `weight`";
		$sql94[1] = "ALTER TABLE {$pfix}orders ADD `tax` varchar(50) $collate1 NOT NULL AFTER `shipping_fee`";		
		$sql94[2] = "ALTER TABLE {$pfix}orders ADD `telephone` VARCHAR( 100 ) NOT NULL AFTER `email`";
		$sql94[3] = "ALTER TABLE {$pfix}inquiries ADD `net` decimal(12,2) NOT NULL AFTER `weight`";		
		$sql94[4] = "ALTER TABLE {$pfix}inquiries ADD `tax` varchar(50) $collate1 NOT NULL AFTER `shipping_fee`";
		$sql94[5] = "ALTER TABLE {$pfix}inquiries ADD `telephone` VARCHAR( 100 ) NOT NULL AFTER `email`";		
		$sql94[6] = "ALTER TABLE {$pfix}shopping_cart CHANGE `item_weight` `item_weight` DECIMAL( 10, 2 ) NOT NULL";	
		$sql94[7] = "ALTER TABLE {$pfix}orders CHANGE `level` `level` ENUM( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' )";		
		$sql94[8] = "DROP TABLE {$pfix}countries";		
		$sql94[9] = "UPDATE {$pfix}status SET `th_vers` = 'change.9.6' WHERE id = 1";	

		foreach($sql94 as $v){
			mysql_query($v);
		}
	}
}

##################################################################################################################################
// 												PAGE - INTEGRATION 
##################################################################################################################################
function show_default_view()
{
	$count 			= 0;
	
	$shop_actions 	= array();
	
	$shop_actions[] = 'showCart';
	$shop_actions[] = 'orderNow';
	$shop_actions[] = 'confirm';
	$shop_actions[] = 'showTerms';
	$shop_actions[] = 'showMap';
	$shop_actions[] = 'checkOrderStatus';
	
	$url 			= $_SERVER['REQUEST_URI'];

	foreach($shop_actions as $v){
		
		$findMe = '?'.$v.'='; 
		$pos 	= strpos($url,$findMe);
		
		if($pos !== FALSE){
			$count++;
		}	
	}
		
	$status = ($count > 0 ? FALSE : TRUE);

return $status;
}

function display_html($filename=NULL,$data=NULL,$ending='.php'){
	global $LANG,$OPTION;
	include(WP_CONTENT_DIR.'/themes/'.WPSHOP_THEME_NAME.'/tpl/'.$filename.$ending);
}
function get_post_insert_form( $current_user, $add_a_day ) {
		$response = retrieve_payment_profiles( $current_user ); 
		$parsedResponse = parse_api_response($response);

		$dropdown_cats_args = array(
			'hide_empty' 		=> 0,
			'echo' 				=> 0,
			'show_count' 		=> 0,
			'hierarchical' 		=> 1,
			'name' 				=> 'category',
			'show_option_all' 	=> __( 'Please Select One' ),
			'taxonomy'			=> 'category',
			'selected'			=> 0,
			'exclude'			=> get_option('wps_mainCat_excl'),
			'class'				=>	'deal-category'
		);

		$return = "<div style='margin-bottom: 20px;'>";
		$return .= "	<span id='txtHint'></span>";
		$return .= "</div>";
		$return .= "<div style='clear:both;'></div>"; 
		$return .= '<form action="#wpip-message" name="deal_submission" id="deal_submission" method="post" class="wpip-form" enctype="multipart/form-data">';
		// $return .= '<div class="wpip-box">';
		// $return .= '<span class="wpip-label">' . __( 'Title', 'wp-insert-post' ) . '</span>';
		// $return .= '<input type="text" name="title" size="40" placeholder="Title" required/></div>';
		$return .= '<div class="wpip-box">';
		$return .= '	<span class="wpip-label">' . __( 'Category', 'wp-insert-post' ) . '</span>';
		$return .= wp_dropdown_categories( $dropdown_cats_args );
		$return .= '</div>';
		$return .= '<div class="wpip-box">';
		$return .= '	<span class="wpip-label">' . __( 'Miles', 'wp-insert-post' ) . '</span>';
		$return .= '	<input type="text" name="ad_miles" id="ad_miles" size="40" />';	
		$return .= '	<div id="milesshowHint"></div>';		
		$return .= '</div>';
		$return .= '<div class="wpip-box">';
		$return .= '	<span class="wpip-label">' . __( 'VIN', 'wp-insert-post' ) . '</span>';
		//$return .= '<input type="text" name="ad_vin" maxlength="17" size="17"/>';		
		$return .= '	<input type="text" name="ad_vin" id="ad_vin" maxlength="17" size="17" style="display:inline;"';		
		$return .= " onkeyup=\"checkVoucher("."'".is_in_subfolder() . "', '" . get_protocol();
		$return .= "','". get_user_meta($current_user->ID, "dealership_address_zipcode", true);
		$return .= "','". get_user_meta($current_user->ID, "dealership_address_state", true);
		$return .= "','". get_option("autos2day_tradein_company");
		$return .= "', this, jQuery(this).parent().prev());\"";
		$return .= " onblur=\"checkVoucher("."'".is_in_subfolder() . "', '" . get_protocol();
		$return .= "','". get_user_meta($current_user->ID, "dealership_address_zipcode", true);
		$return .= "','". get_user_meta($current_user->ID, "dealership_address_state", true);
		$return .= "','". get_option("autos2day_tradein_company");
		$return .= "', this, jQuery(this).parent().prev());\"";
		$return .= " 	/>"; 
		$return .= " 	<span class='button_id'><input name='vin_go' id='vin_go' type='button' value='GO' style='display:inline; float:none;'/></span>"; 
		$return .= '</div>';	
		$return .= '<div class="wpip-box" id="kbbResponse">';
		$return .= '	<div class="wpip-box">';
		$return .= '		<span class="wpip-label">' . __( 'Year', 'wp-insert-post' ) . '</span>';
		$return .= '		<input type="text" name="ad_year" id="kbbResponseYear" size="40" />';	
		$return .= '	</div>';	
		$return .= '	<div class="wpip-box">';
		$return .= '		<span class="wpip-label">' . __( 'Make', 'wp-insert-post' ) . '</span>';
		$return .= '		<input type="text" name="ad_make" id="kbbResponseMake" size="40" />';	
		$return .= '	</div>';	
		$return .= '	<div class="wpip-box">';
		$return .= '		<span class="wpip-label">' . __( 'Model', 'wp-insert-post' ) . '</span>';
		$return .= '		<input type="text" name="ad_model" id="kbbResponseModel" size="40" />';	
		$return .= '	</div>';	
		$return .= '	<div class="wpip-box">';
		$return .= '		<span class="wpip-label">' . __( 'Trim', 'wp-insert-post' ) . '</span>';
		$return .= '		<select name="ad_trim" id="kbbResponseTrim">';	
		$return .= '		</select>';	
		$return .= '	</div>';	
		$return .= '	<div class="wpip-box">';
		$return .= '		<span class="wpip-label">' . __( 'Engine', 'wp-insert-post' ) . '</span>';
		$return .= '		<select id="ad_Engine" name="ad_engine">';	
		$return .= '		</select>';	
		$return .= '	</div>';	
		// if ( get_option("autos2day_tradein_company") != "nada") { // do not display for nada
		// 	$return .= '	<div class="wpip-box">';
		// 	$return .= '		<span class="wpip-label">' . __( 'Transmission', 'wp-insert-post' ) . '</span>';
		// 	$return .= '		<select id="ad_Transmission" name="ad_trans">';	
		// 	$return .= '		</select>';	
		// 	$return .= '	</div>';	
		// 	$return .= '	<div class="wpip-box">';
		// 	$return .= '		<span class="wpip-label">' . __( 'Drive Tran', 'wp-insert-post' ) . '</span>';
		// 	$return .= '		<select id="ad_DriveTrain" name="ad_drive">';	
		// 	$return .= '		</select>';	
		// 	$return .= '	</div>';				
		// }
		$return .= '	<div class="wpip-box hide-display">';
		$return .= '		<span class="wpip-label">' . __( 'PrivateParty', 'wp-insert-post' ) . '</span>';
		$return .= '		<select id="ad_pparty" name="ad_pparty">';	
		$return .= '		</select>';	
		$return .= '	</div>';	

		// $return .= '<div class="wpip-box">';
		// $return .= '<span class="wpip-label">' . __( 'Year', 'wp-insert-post' ) . '</span>';
		// #$return .= '<input type="text" name="ad_year" size="40"  required/>';
		// //$return .= 
		// $return .= '<select name="ad_year" id="ad_year" required value="">';
		// $return .= '<option value="null">Select Year</option>';
		// for ( $count = 2000; $count < 2012; $count +=1 ) {
		// 	$return .= '<option value="' . $count . '">' . $count . '</option>';
		// }
		// $return .= '</select>';
		// $return .= '</div>';
		// $return .= '<div class="wpip-box">';
		// $return .= '<span class="wpip-label">' . __( 'Make', 'wp-insert-post' ) . '</span>';
		// $return .= '<select name="ad_make" id="ad_make" required>';
		// $return .= '<option value="null" selected>Select One</option>';
		// foreach ($Make as $key) {
		// 	$return .= '<option ';
		// 	$return .= 'value="' . $key['col_2'] . '" ';
		// 	$return .= 'MakeId="' . $key['col_1'] . '">' . $key['col_2'] . '</option>';
		// }
		// //$return .= '<input type="text" name="ad_make" size="40"  required/>';
		// $return .= '</select>';
		// $return .= '</div>';
		// $return .= '<div class="wpip-box">';
		// $return .= '<span class="wpip-label">' . __( 'Model', 'wp-insert-post' ) . '</span>';
		// $return .= '<select name="ad_model" id="ad_model" required>';
		// $return .= '<option value="null" selected>Select One</option>';
		// foreach ($Model as $key) {
		// 	$return .= '<option ';
		// 	$return .= 'ModelId="' . $key['ModelId'] .  '" ';
		// 	$return .= 'refMakeId="' . $key['MakeId'] .  '" ';
		// 	$return .= 'value="' . $key['DisplayName'] . '" ';
		// 	$return .= '>' . $key['DisplayName'] . '</option>';
		// }
		// $return .= '</select>';
		// //$return .= '<input type="text" name="ad_model" size="40"  required/>';
		// $return .= '</div>';			
		// $return .= '<div class="wpip-box">';
		// $return .= '<span class="wpip-label">' . __( 'Trim', 'wp-insert-post' ) . '</span>';
		// $return .= '<select name="ad_trim" id="ad_trim" required>';
		// $return .= '<option value="null" selected>Select One</option>';
		// foreach ($Trim as $key) {
		// 	$return .= '<option ';
		// 	$return .= 'TrimId="' . $key['TrimId'] .  '" ';
		// 	$return .= 'refModelId="' . $key['ModelId'] .  '" ';
		// 	$return .= 'value="' . $key['TrimName'] . '" ';
		// 	$return .= '>' . $key['DisplayName'] . '</option>';
		// }
		// $return .= '</select>';
		// //$return .= '<input type="text" name="ad_trim" size="40"  />';			
		// $return .= '</div>';			
		$return .= '<div class="wpip-box">';
		$return .= '	<span class="wpip-label">' . __( 'Color', 'wp-insert-post' ) . '</span>';
		$return .= '	<input type="text" name="ad_color" id="ad_color" size="40" />';
		$return .= '</div>';			
		$return .= '<div class="wpip-box">';
		$return .= '	<span class="wpip-label">' . __( 'Price', 'wp-insert-post' ) . '</span>';
		$return .= '	<input type="text" name="ad_price" size="40" />';
		$return .= '</div>';			
		$return .= '<div class="wpip-box">';
		$return .= '	<span class="wpip-label">' . __( 'Description', 'wp-insert-post' ) . '</span>';
		$return .= '	<textarea name="content" id="content" rows="7" cols="70" maxlength="500" ></textarea>';
		$return .= '	<span class="wpip-label"></span><span class="charremain"></span>';
		$return .= '</div>';
		if ( get_option("disable_payment_processing") == "0" ) {
			$return .= '<fieldset>';
			$return .= '	<legend>Creditcard Details</legend>';
			$return .= '	<div class="wpip-box">';
			$return .= '		<select name="customerPaymentProfileId">';
			foreach ( $parsedResponse->profile->paymentProfiles as $key ) {
				$return .= '		<option value="' . $key->customerPaymentProfileId . '">' . $key->payment->creditCard->cardNumber . '</option>';
			}
			$return .= '		</select>';
			$return .= '	</div>';
		}
		// $return .= '	<div class="wpip-box">';
		// $return .= '		<span class="wpip-label">' . __( 'Type', 'wp-insert-post' ) . '</span>';
		// $return .= '		<select name="cc_type" required>';
		// $return .= '			<option value="null">Select One</option>';
		// $return .= '			<option value="VISA">VISA</option>';
		// $return .= '			<option value="MC">Master Card</option>';
		// $return .= '		</select>';
		// $return .= '	</div>';

		// $return .= '	<div class="wpip-box">';
		// $return .= '		<span class="wpip-label">' . __( 'Credit Card', 'wp-insert-post' ) . '</span>';
		// $return .= '		<input type="text" name="cc" size="40"  required/>';
		// $return .= '	</div>';
		// $return .= '	<div class="wpip-box">';
		// $return .= '		<span class="wpip-label">' . __( 'Expiration', 'wp-insert-post' ) . '</span>';
		// $return .= '		<select id="ad_cc_exp" name="ad_cc_exp">';	
		// for ( $i = 1; $i < 24; $i++ ) {
		// 	$dateString = strtotime ( "+" . $i . " month");
		// 	$return .= '		<option value="' . date('m/Y', $dateString ) . '">' . date('M-Y', $dateString ) . '</option>';
		// 	// echo date('m/Y', $dateString ) . "\t" . date('M-Y', $dateString ) . "<br/>";
		// }
		// $return .= '		</select>';	
		// // $return .= '		<input type="text" id="ad_cc_month" name="ad_cc_month" size="40"  required/>';
		// $return .= '	</div>';			
		// $return .= '	<div class="wpip-box">';
		// $return .= '		<span class="wpip-label">' . __( 'Expiry Year', 'wp-insert-post' ) . '</span>';
		// $return .= '		<input type="text" name="ad_cc_year" size="40"  required/>';
		// $return .= '	</div>';
		$return .= '	<div class="wpip-box">';
		// $return .= '		<span class="wpip-label">' . __( 'Expiry Year', 'wp-insert-post' ) . '</span>';
		$return .= '		<input type="checkbox" name="accept_terms" id="accept_terms" size="40"  />';
		$return .= '		<span class="accept_terms">I accept the <span class="terms_of_use_modal"></span><a href="#" class="terms_of_use">terms of use</a> of Autos2Day</span>		';
		$return .= '	</div>';
		$return .= '</fieldset>';	
		$return .= "<fieldset>";
		$return .= "	<legend>Upload Images</legend>";
		$images_count = get_option('deal_images_count');
		if ( strtoupper(gethostname()) == 'BRAMKASLP01') {
			$images_count = "1";
		}
		for ( $count = 0; $count < $images_count ; $count += 1 ) {
			$imageCount = $count;
			$description_image = "none";
			switch ( $count ) {
				case '0':
					$description_image = "Main Image";
					break;
				case '1':
					$description_image = "Second Image";
					break;
				case '2':
					$description_image = "Third Image";
					break;
				case '3':
					$description_image = "Fourth Image";
					break;
				case '4':
					$description_image = "Fifth Image";
					break;
			}

			$return .= '	<div class="wpip-box">';
			$return .= '		<span class="wpip-label">' . __ ( $description_image, 'wpShop' ) . '</span>';
			$return .= '		<input name="upload_images_i' . $count . '" id="upload_images_i' . $count . '" type="file" />';
			$return .= '	</div>';
		}
		$return .= '</fieldset>';
		$return .= '<div class="wpip-box">';
		$return .= '	<input type="submit" value="' . __( 'Submit', 'wp-insert-post' ) . '" />';
		$return .= '</div>';
		$return .= '<input type="hidden" name="save" value="true" />';
		$return .= '<input type="hidden" name="add_a_day" id="add_a_day" value="' . $add_a_day . '" />';
		$return .= '<input type="hidden" name="subfolder" id="subfolder" value="' . is_in_subfolder() . '" />';
		$return .= '<input type="hidden" name="protocol" id="protocol" value="' . get_protocol() . '" />';
		$return .= '<input type="hidden" name="zipcode" id="zipcode" value="' . get_user_meta($current_user->ID, "dealership_address_zipcode", true) . '" />';
		$return .= '<input type="hidden" name="dealership_address_state" id="dealership_address_state" value="' . get_user_meta($current_user->ID, "dealership_address_state", true) . '" />';
		$return .= '<input type="hidden" name="operation" id="operation" value="' . get_option("autos2day_tradein_company") . '" />';
		// $return .= '<input type="hidden" id="kbbResponsePrivatParty" name="ad_pparty" value="" />';
		$return .= '</div>';			
		$return .= '</form>';
		//$return .= media_upload_form( $errors );
		return $return;				
}

function email_vouchers ($voucher_options) {
	global $OPTION;	
	global $log;
	
	$EMAIL 	= load_what_is_needed('email');		//change.9.10

	$random_hash = md5(date('r', time()));

	$ending = '.pdf';
	$path	= WP_CONTENT_DIR . '/themes/'.WPSHOP_THEME_NAME.'/pdf/bills/';

	$file 	= $path.$OPTION[wps_invoice_prefix].'_'.$voucher_options['voucher_code'].$ending;
	$attachment = $file;//chunk_split(base64_encode(file_get_contents($file)));
	
	// we send customer a notification email about the shipping	
	$to 					= $voucher_options['email'];
	$subject_str			= __('Your Requested Voucher %VOUCHER_NO% for the Deal','wpShop');						
	$subject 				= str_replace("%VOUCHER_NO%",$voucher_options['voucher_code'],$subject_str);						

	if(strlen(WPLANG)< 1){  // shop runs in English 
		$filename			= WP_CONTENT_DIR . '/themes/'.WPSHOP_THEME_NAME.'/email/email-voucher.html';
	}
	else {					// shops runs in another language 
		$filename			= WP_CONTENT_DIR . '/themes/'.WPSHOP_THEME_NAME.'/email/'.WPLANG.'-email-voucher.html';
	}
	
	$message				= file_get_contents($filename);

	$admin_email_address	= $OPTION['wps_shop_email'];
	$domain					= $OPTION['wps_shop_name'];										

	$em_logo_path 	= get_bloginfo('template_directory') .'/images/logo/' . $OPTION['wps_email_logo'];	
	// might be that these char combos show up b'c image tag 
	$message		= str_replace('%5B','[', "$message");
	$message		= str_replace('%5D',']', "$message");

	$message		= str_replace('[##voucher_code##]', $voucher_options['voucher_code'], "$message");
	$message		= str_replace('[##email##]', $voucher_options['email'], "$message");
	$message		= str_replace('[##name##]', $voucher_options['name'], "$message");
	$message		= str_replace('[##phone##]', $voucher_options['phone_no'], "$message");
	$message		= str_replace('[##title##]', $voucher_options['title'], "$message");
	$message		= str_replace('[##qr_code##]', $voucher_options['qr_code'], "$message");	

	foreach ( $voucher_options as $key => $value ) {
		if ( $key == "ad_price") {
			$message		= str_replace('[##' . $key . '##]', number_format($value[0], 2, '.', ','), "$message");	
			//number_format(get_custom_field('ad_price'), 2, '.', ',')
		}
		$message		= str_replace('[##' . $key . '##]', $value[0], "$message");	
	}


	$message		= str_replace('[##Email-Logo##]', $em_logo_path, "$message");									
	$message		= str_replace('[##biz##]',utf2latin($OPTION['wps_shop_name']), "$message");
	$message		= str_replace('[##name##]', $order[f_name].' '.$order[l_name] , "$message");					

	// $_message = "--PHP-mixed-$random_hash\r\n";
	// $_message .= "Content-Type: multipart/alternative; boundary=\"PHP-alt-$random_hash\"\r\n\r\n";
	// $_message .= "--PHP-alt-$random_hash\r\n";
	// // $_message .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
	// // $_message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";							
	// // $_message .= $message;
	// $_message .= "\r\n\r\n--PHP-alt-$random_hash\r\n";
	// $_message .= "Content-Type: text/html; charset=\"iso-8859-1\r\n";
	// $_message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
	// $_message .= $message;
	// $_message .="\r\n\r\n--PHP-alt-$random_hash--\r\n\r\n";

	// //include attachment
	// $_message .= "--PHP-mixed-$random_hash\r\n"
	// ."Content-Type: application/pdf; name=\"". basename($attachment) . "\"\r\n"
	// ."Content-Transfer-Encoding: base64\r\n"
	// ."Content-Disposition: attachment\r\n\r\n";
	// $_message .= $attachment;
	// $_message .= "/r/n--PHP-mixed-$random_hash--";
	//$message = $_message;
	// print_r($message);
	$success = $EMAIL->html_mail($to,$subject,$message,$admin_email_address, $domain, $attachment, $voucher_options['author']);		//change.9.10		

}

function process_the_content ( $content ) {
	echo preg_replace("\[admin\].*\[/admin\]", "", $content);
}

function post_expiration_date ( $post_date ) {
	$mktime = strtotime($post_date);
	$post_expiration = mktime(12, 0, 0, date("m", $mktime)  , date("d", $mktime)+2, date("Y", $mktime));
	return $post_expiration;
}

function expiration_time_set ( $post_date = '' , $add_a_day ) {
	global $log;
	if ( !isset($log)) {
		$log = load_what_is_needed ( "log" );
	}	
	$add_a_day = $add_a_day + 2;
	$log->general ( __LINE__ . " add_a_day " . $add_a_day);
	if ( $post_date == '' ) {
		return mktime(12, 0, 0, date("m")  , date("d")+$add_a_day, date("Y"));		
	} else {
		$mktime = strtotime($post_date);
		return mktime(12, 0, 0, date("m", $mktime)  , date("d", $mktime)+$add_a_day, date("Y", $mktime));
	}

}

function deal_date_set ($post_date = '', $add_a_day) {
	$add_a_day = $add_a_day + 1;
	global $log;
	if ( !isset($log)) {
		$log = load_what_is_needed ( "log" );
	}	
	$log->general ( __LINE__ . " add_a_day " . $add_a_day);

	if ($post_date == '') {
		return mktime(12, 0, 0, date("m")  , date("d")+$add_a_day, date("Y"));		
	} else {
		$mktime = strtotime($post_date);
		return mktime(12, 0, 0, date("m", $mktime)  , date("d", $mktime)+$add_a_day, date("Y", $mktime));
	}
}

function validate_exp_deal_date ( $post_id, $post_date, $force = '' ) {
	global $add_a_day;
	if ( $add_a_day == '' ) {
		$add_a_day = get_post_meta($post_id, "add_a_day", true);
	}
	$log = load_what_is_needed("log");

	update_post_meta($post_id, 'expiration-time', '');
	update_post_meta($post_id, 'deal-date', '');

	$log->general("arguments: post_id " . $post_id );
	$log->general("arguments: post_date " . $post_date . ' ' . date('Y', $post_expiration));
	$log->general("arguments: force " . $force );


	
	if ( ( strlen($post_expiration) == 0 || strlen($deal_date) == 0 ) || $force != '' ) {
		$expiration_time = expiration_time_set($post_date, $add_a_day);
		update_post_meta($post_id, 'expiration-time', date(get_option("expiration_format"), $expiration_time));
		$deal_date = deal_date_set($post_date, $add_a_day);
		update_post_meta($post_id, 'deal-date', date(get_option("expiration_format"), $deal_date));
		


		$post_expiration = get_post_meta ($post_id, 'expiration-time', true);
		$deal_date = get_post_meta ($post_id, 'deal-date', true);


		$log->general("Post id: " . $post_id . " et exp: " . date('y-m-d', strtotime($post_expiration)));
		$log->general("Post id: " . $post_id . " dd exp: " . date('y-m-d', strtotime($deal_date)));
		$log->general("Post id: " . $post_id . ' post-date: ' . $post_date . ' exp: ' . date('y-m-d', strtotime($post_date)));
	}
}

function validate_deal_date ( $post_meta ) {
	global $log;
	if ( !isset($log)) {
		$log = load_what_is_needed ( "log" );
	}	
	date_default_timezone_set(get_option('timezone_string'));

	$current_time = strtotime(date(get_option("expiration_format")));
	$deal_date = date('Y-m-d', strtotime($post_meta['deal-date'][0]));
	$expirate_date = date('Y-m-d', strtotime($post_meta['expiration-time'][0]));

	$deal_time = strtotime($deal_date);
	$exp_time = strtotime($expirate_date);
	$log->general ( "current date: " . $current_date);
	$log->general ( "Deal date: " . $deal_date);
	$log->general ( "Exp date: " . $expirate_date);
	if ( $current_time < $deal_time ) {
		$return = "future";
	} elseif ( $current_time < $exp_time && $current_time > $deal_time ) {
		// echo '<p>not expired' . $current_date_only . ' <= ' . $exp_date_only . '</p>';
		$return = "deal";
	} elseif ( $current_time > $exp_time ) {
		if ( get_option("wps_expire_deals") == 'false') {
			$return = "deal";
		} else {
			$return = "expired";
		}

	}
	// $current_date = strtotime(date('Y-m-d'));

	// if ( $current_date == $deal_date ) {
	// 	// deal
	// 	$return = "deal";
	// } elseif ( $current_date < $deal_date ) {
	// 	// pending
	// 	$return = "pending";
	// } elseif ( $current_date == $expiration_date || $current_date > $expiration_date ) {
	// 	//expired
	// 	$return = "expired";
	// } else {
	// 	$return = "none";
	// }

	return $return;
}

function set_deal_expiration ( $post, $post_meta ) {
	$log = load_what_is_needed("log");
	if ( strtotime(date('Y-m-d')) > strtotime(date('Y-m-d', $post_meta['expiration-time'][0])) ) {
		$log->general(__LINE__ . " expiration-date: " . date('Y-m-d', $post_meta['expiration-time'][0]) );
		$post->post_status = "expired";
		wp_update_post ( $post );
	}	
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}

function send_xml_request($content)
{
	$g_apihost = get_option("wps_authn_cim_url_host");
	$g_apipath = get_option("wps_authn_cim_url_path");

	return send_request_via_fsockopen($g_apihost,$g_apipath,$content);
}

//function to send xml request via fsockopen
//It is a good idea to check the http status code.
function send_request_via_fsockopen($host,$path,$content)
{
	$posturl = "ssl://" . $host;
	$header = "Host: $host\r\n";
	$header .= "User-Agent: PHP Script\r\n";
	$header .= "Content-Type: text/xml\r\n";
	$header .= "Content-Length: ".strlen($content)."\r\n";
	$header .= "Connection: close\r\n\r\n";
	$fp = fsockopen($posturl, 443, $errno, $errstr, 30);
	if (!$fp)
	{
		$body = false;
	}
	else
	{
		error_reporting(E_ERROR);
		fputs($fp, "POST $path  HTTP/1.1\r\n");
		fputs($fp, $header.$content);
		fwrite($fp, $out);
		$response = "";
		while (!feof($fp))
		{
			$response = $response . fgets($fp, 128);
		}
		fclose($fp);
		error_reporting(E_ALL ^ E_NOTICE);
		
		$len = strlen($response);
		$bodypos = strpos($response, "\r\n\r\n");
		if ($bodypos <= 0)
		{
			$bodypos = strpos($response, "\n\n");
		}
		while ($bodypos < $len && $response[$bodypos] != '<')
		{
			$bodypos++;
		}
		$body = substr($response, $bodypos);
	}
	return $body;
}

//function to send xml request via curl
function send_request_via_curl($host,$path,$content)
{
	$posturl = "https://" . $host . $path;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $posturl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($ch);
	return $response;
}


//function to parse the api response
//The code uses SimpleXML. http://us.php.net/manual/en/book.simplexml.php 
//There are also other ways to parse xml in PHP depending on the version and what is installed.
function parse_api_response($content)
{
	$parsedresponse = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOWARNING);
	if ("Ok" != $parsedresponse->messages->resultCode) {
		if ( 'Error' == $parsedresponse->messages->resultCode ) {
			if ( $parsedresponse->messages->message->code == 'E00039') {

			}
		} else {
			// print_r($parsedresponse);
			// echo "The operation failed with the following errors:<br>";
			// foreach ($parsedresponse->messages->message as $msg) {
			// 	echo "[" . htmlspecialchars($msg->code) . "] " . htmlspecialchars($msg->text) . "<br>";
			// }
			// echo "<br>";		
		}
	}
	return $parsedresponse;
}

function MerchantAuthenticationBlock() {
	return
        "<merchantAuthentication>".
        "<name>" . get_option("wps_authn_api_login") . "</name>".
        "<transactionKey>" . get_option("wps_authn_transaction_key") . "</transactionKey>".
        "</merchantAuthentication>";
}

function MerchantAuthentication ( $object ) {
    global $user;
    $object->merchantAuthentication->name             =   get_option('wps_authn_api_login');
    $object->merchantAuthentication->transactionKey   =   get_option('wps_authn_transaction_key');
    return $object;
}

function addXMLNamespace ( $content, $contentid ) {
    $content = str_replace("<" . $contentid, "<" . $contentid . " xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\"", $content);    
    return $content;
}

function retrieve_customer_profile ( $AUTH_NET_PROFILE ) {
	// global $AUTH_NET_PROFILE;
	global $xml;
	global $log;
	global $user;

	$log = load_what_is_needed ("log");
	$xml = load_what_is_needed ("xml");

    $log->general (__LINE__ . ' Creating getCustomerProfileRequest : ' . $AUTH_NET_PROFILE);

    // set / retrieve 
    //customerProfileId = $AUTH_NET_PROFILE
    //getCustomerProfileRequest
    $getCustomerProfileRequest                                           =   new stdClass();
    $getCustomerProfileRequest                                           =   MerchantAuthentication ( $getCustomerProfileRequest );
    $getCustomerProfileRequest->customerProfileId                        =   $AUTH_NET_PROFILE;
    $content                                                             =   $xml->generate_valid_xml_from_array($getCustomerProfileRequest, "getCustomerProfileRequest");
    $content                                                             =   addXMLNamespace ($content, "getCustomerProfileRequest");
    $response = send_xml_request($content);
    $parsedresponse = parse_api_response($response);
    if ( isset($parsedresponse->profile->paymentProfiles) ) {
    		$paymentProfileArray = $response;
    }

    update_user_payment_profile ( $paymentProfileArray );
	return $parsedresponse;
}

function update_user_payment_profile ($paymentProfileArray) {
	global $user;
    update_user_meta ( $user->ID, "customerPaymentProfileId", $paymentProfileArray );	
}

function retrieve_payment_profiles ( $user ) {
	global $log;
	$payment_profiles = get_user_meta ($user->ID, "customerPaymentProfileId", true);
	return $payment_profiles;
}

function process_payment_hold () {
	global $AUTH_NET_PROFILE;
	global $xml;
	global $log;
	global $user;

}

function ad_new_user_notification($user_id, $plaintext_pass = '', $user_details = '' ) {
	$user 			= new WP_User($user_id);

	$user_login 	= stripslashes($user->user_login);
	$user_email 	= stripslashes($user->user_email);
	
	if ( empty($plaintext_pass) )
		return;
	
	$file_name 		= WP_CONTENT_DIR.'/themes/'. WPSHOP_THEME_NAME .'/email/'.'en_US'.'-email-registration.html';
	$message 		= file_get_contents( $file_name );

	$file_name 		= WP_CONTENT_DIR.'/themes/'. WPSHOP_THEME_NAME .'/email/'.'en_US'.'-email-headers.html';
	$message 		= file_get_contents( $file_name );

	$message 		= str_replace ( "[##contents##]", apply_filters('the_content', get_page_by_title ('DealerRegistrationEmail')->post_content), $message);


	$message		= str_replace('[##user_name##]',$user_login, "$message");
	$message		= str_replace('[##user_pass##]',$plaintext_pass, "$message");	
	
	$message		= str_replace('[##dealership_name##]',$user_details['dealership_name'], "$message");	

	// wp_mail($user_email, sprintf(__('Registration Confirmation: %s'), $blogname), $message, $headers);
	$blogname 		= wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	send_notification ($user_email, sprintf(__('Registration Confirmation: %s'), $blogname), $message, $headers );

}

function ad_deal_notifications ( $deal_data, $type, $user_details, $user_id  ) {
	global $log;
	if ( !isset($log)) {
		$log = load_what_is_needed ( "log" );
	}
	$user = get_user_by('id', $user_id);
	$blogname 		= wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$file_name 		= WP_CONTENT_DIR.'/themes/'. WPSHOP_THEME_NAME .'/email/'.'en_US'.'-email-headers.html';
	$message 		= file_get_contents( $file_name );


	if ( $type == 'rejected' ) {
		$subject 		= sprintf(__('Deal did not Qualify: %s'), $blogname);
		$file_name 		= WP_CONTENT_DIR.'/themes/'. WPSHOP_THEME_NAME .'/email/'.'en_US'.'-email-deal-rejected.html';
		$message 		= str_replace ( "[##contents##]", apply_filters('the_content', get_page_by_title ('DealRejectionEmail')->post_content), $message);

	} elseif ( $type == 'approved' ) {
		$subject 		= sprintf(__('Deal has been approved: %s'), $blogname);
		$file_name 		= WP_CONTENT_DIR.'/themes/'. WPSHOP_THEME_NAME .'/email/'.'en_US'.'-email-deal-approved.html';
		$message 		= str_replace ( "[##contents##]", apply_filters('the_content', get_page_by_title ('DealApprovalEmail')->post_content), $message);
	}
	
	// $message 		= file_get_contents( $file_name );
	
	$message		= str_replace('[##dealership_name##]',$user_details['dealership_name'][0], "$message");

	foreach ($deal_data as $key => $value) {
		$_key = "[##" .$key . "##]";
		$message		= str_replace($_key,$value[0], "$message");	
	}
	
	foreach ($user_details as $key => $value) {
		$_key = "[##" .$key . "##]";
		$message		= str_replace($_key,$value[0], "$message");	
	}
	$log->general ( $type . ": Sending emails: " . (get_option("wps_rejection_emails") == 'true' ) . ' settings: ', "send_notification_");		
	if ( $type == 'rejected' && get_option("wps_rejection_emails") != 'false' ) {
		send_notification ($user->user_email, $subject, $message, $headers );
	} elseif ( $type == 'approved' && get_option("wps_approved_emails") != 'false' ) {
		send_notification ($user->user_email, $subject, $message, $headers );
	} else {
		$log->general ( $type . ": Sending emails: " . get_option("wps_rejection_emails"));		
	}
}

function send_notification ($to, $subject, $message, $headers ) {
	// if ( strtoupper(gethostname()) == 'BRAMKASLP01') {
	// 	return;
	// } else {
	// }
	global $log;
	if ( !isset($log)) {
		$log = load_what_is_needed ( "log" );
	}

	$domain 		= utf8_decode($OPTION['wps_shop_name']); 	
					
	
	$em_logo_path 	= get_bloginfo('template_directory') .'/images/logo/' . get_option('wps_email_logo');

	$message		= str_replace('%5B','[', "$message");
	$message		= str_replace('%5D',']', "$message");
	$message		= str_replace('[##Email-Logo##]', $em_logo_path, "$message");						
	$message		= str_replace('[##biz##]',$OPTION['wps_shop_name'], "$message");
	$message		= str_replace('[##site_url##]',site_url(), "$message");
	$message		= str_replace('[##dealers_admin##]',get_option('cc_admin_email'), "$message");	
	$message		= str_replace('[##shop_tel##]',get_option('shop_tel_num'), "$message");	
	$message		= str_replace('[##disclaimer##]',get_option('email_disclaimer'), "$message");	
	
	
	// The blogname option is escaped with esc_html on the way into the database in sanitize_option
	// we want to reverse this for the plain text arena of emails.

	$headers 		= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers 		.= "from: " . get_bloginfo('name') . " <" . get_option('admin_email') . ">\r\n";
	$headers 		.= "cc: " . get_bloginfo('name') . " <" . get_option('cc_admin_email') . ">\r\n";

	$log->general ( "subject email to: " . $subject, "send_notification_");
	$log->general ( "email to: " . $to, "send_notification_");
	$log->general ( "message email to: " . $message, "send_notification_");
	$log->general ( "headers to: " . $headers, "send_notification_");
	$log->general ( "sending email to : " . $to, "send_notification_");
	$log->general ( "sending email subject : " . $subject, "send_notification_");
	wp_mail($to, $subject, $message, $headers);
}


?>