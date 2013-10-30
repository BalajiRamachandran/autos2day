<?php

	class Wishlist{
	
		//change.9.9
		function show_wishlist(){

				$table 	= is_dbtable_there('wishlist');		
				$WISHL 	= array();
				
				$qStr 			= "SELECT * FROM $table WHERE uid = '$_SESSION[uid]'";
				$res 			= mysql_query($qStr);
				$num 			= mysql_num_rows($res);
			
				if($num < 1){
					$WISHL['status'] 	= 'empty';
				}
				else {
			
					$WISHL['status']		= 'filled';
					$WISHL['total_item_num']= 0;
					$WISHL['total_price'] 	= 0;
					$WISHL['total_weight'] 	= 0;
					$WISHL['content'] 		= array();

					$item			= array();
					$i				= 0;
				
				
					while($row = mysql_fetch_assoc($res)){
										
						$personalize 			=  retrieve_personalization($row['wid']); // Personalization 
					
						$item[$i][num]			= $row['item_amount'];
						$item[$i][price] 		= $row['item_price'] * $row['item_amount'];
						$item[$i][weight] 		= $row['item_weight'] * $row['item_amount'];				
						$WISHL[content][$i]		= $row['wid'].'|'.$row['item_amount'].'|'.$row['item_name'].'|'.$row['item_price'].'|';
						$WISHL[content][$i]		.= sprintf("%01.2f",$item[$i]['price']).'|'.$row['item_id'].'|'.$row['item_thumb'].'|';
						$WISHL[content][$i]		.= $row['item_attributs'].'|'.$row['postID'].'|'.$row['buy_now'].'|'.$personalize;
						$i++;					
					}	
					
					for($a=0;$a<$i;$a++)
					{
						$WISHL['total_item_num'] 	= $WISHL['total_item_num'] + $item[$a]['num'];
						$WISHL['total_weight']		= $WISHL['total_weight'] + $item[$a]['weight'];
						$WISHL['total_price'] 		= $WISHL['total_price'] + $item[$a]['price'];				
					}
					
					$WISHL['total_price'] = sprintf("%01.2f", $WISHL['total_price']);
				}		
		return $WISHL;
		}
		//\change.9.9
	
	
		function add_toWishlist(){

			$table 	= is_dbtable_there('wishlist');

			if(($_POST[cmd] == 'add') && ($_POST[amount] != '0.00')){
					
				if(!isset($_POST[attrData])){	// different attribute collection methods - either from several $_POST values or one single combined one... 				
					$item_attributes 	= collect_attributes();
				}
				else{			
					$item_attributes 	= collect_attributes(2);
				}
				
				
				//save any available personalization data
				$personal 			= personalization_chksum();
				$already_there 		= $this->in_wishlist_already($table,$_POST[item_id],$item_attributes,$personal,$_SESSION[uid]);
				
				
			
				if($already_there == 0){
				
						// add as new item in table 
						$column_array	= array();
						$value_array	= array();           
							
						$column_array[0]	= 'wid';			$value_array[0]	= '';
						$column_array[1]	= 'item_id';		$value_array[1]	= "$_POST[item_id]";
						$column_array[2]	= 'postID';			$value_array[2]	= "$_POST[postID]";
						$column_array[3]	= 'item_name';		$value_array[3]	= "$_POST[item_name]";
						#$column_array[4]	= 'item_amount';	$value_array[4]	= "$_POST[item_number]";
						$column_array[4]	= 'item_price';		$value_array[4]	= "$_POST[amount]";
						$column_array[5]	= 'item_weight';	$value_array[5]	= "$_POST[item_weight]";
						$column_array[6]	= 'item_thumb';		$value_array[6]	= "$_POST[image_thumb]";
						$column_array[7]	= 'buy_now';		$value_array[7]	= "$_POST[buy_now]";					
						$column_array[8]	= 'item_attributs';	$value_array[8]	= $item_attributes;	
						$column_array[9]	= 'item_personal';	$value_array[9]	= $personal;						
						$column_array[10]	= 'uid';			$value_array[10]= "$_SESSION[uid]";
						$column_array[11]	= 'level';			$value_array[11]= '1';
						
						if(isset($_POST[item_file])){
							$column_array[12]	= 'item_file';		$value_array[12]	= "$_POST[item_file]";	
						}
											
						db_insert($table, $column_array, $value_array);	

						//get the inserted ID from table 
						$sql 		= "SELECT wid FROM $table ORDER BY wid DESC LIMIT 1";				
						$res		= mysql_query($sql);
						$row		= mysql_fetch_assoc($res);
						$row['cid'] = $row['wid'];
						save_personalization($row);
				}
				
				
				// save the refering website in session, needed for return to shop button in wishlist
				$_SESSION['wishlistRTUrl'] = $_POST['wishlistRTUrl'];
				
				
				// to avoid unitentional reposts
				$_POST 	= array();		
				//$url 	= $OPTION['home'] . current_page(2);		
				$url 	= current_page(3);
				$url 	.= '?added=OK&l=wl';
				header('Location: ' . $url);
				exit($url);		
			}		
		}
			
		function in_wishlist_already($table,$item_id,$item_attributes,$personal,$who){

			$qStr 	= "SELECT * FROM $table WHERE item_id = '$item_id' AND item_attributs = '$item_attributes' AND item_personal = '$personal' AND uid = '$who'";	
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

		function remove_from_wishlist(){

			global $OPTION,$customerArea;

			$table 	= is_dbtable_there('wishlist');
			$qStr 	= "DELETE FROM $table WHERE wid = $_POST[remove_wl_item]";
			mysql_query($qStr);
			
			//remove also any existing records in the personalize table
			$table2	= is_dbtable_there('personalize'); 
			$cid	= (int) $_POST[remove_wl_item];
			$qStr2 	= "DELETE FROM $table2 WHERE cid = $cid";
			mysql_query($qStr2);
			
			$url 	= get_option('siteurl') . '/'.$customerArea->post_name.'?action=3'; 
			header("Location: $url");
			exit(NULL);
		}


		function attributesExtraSql($row){

			if(strlen($row['item_attributs'])>1){
			
				$extraSQL 	= NULL;
				$parts 		= explode("#",$row['item_attributs']);

				foreach($parts as $v){
					$attrParts = explode("=",$v);
					$extraSQL .= "$attrParts[0] = '$attrParts[1]' AND ";
				}
			}
			else {
					$extraSQL = NULL;
			}	
		return $extraSQL;
		}


		function wl_cart_transfer(){

			global $OPTION,$customerArea;

			$table 	= is_dbtable_there('wishlist');
			$wid	= (int) trim($_POST['transfer_wl_item']);			//change.9.9
			$qStr 	= "SELECT * FROM $table WHERE wid = $wid LIMIT 0,1";
			$res 	= mysql_query($qStr);
			$row	= mysql_fetch_assoc($res);

			$extraSQL = $this->attributesExtraSql($row);
			
			$table 	= is_dbtable_there('inventory');
			$itemID	= trim($row['item_id']);
			$qStr 	= "SELECT amount FROM $table WHERE $extraSQL ID_item = '$itemID' LIMIT 0,1";	
			$res 	= mysql_query($qStr);
			$row2	= mysql_fetch_assoc($res);	
			$stock 	=  (int) $row2['amount'];
			
			
			if($OPTION['wps_track_inventory'] == 'not_active'){
				$stock = 100000;
			}
			else {
				$table 	= is_dbtable_there('inventory');
				$itemID	= trim($row['item_id']);
				$qStr 	= "SELECT amount FROM $table WHERE $extraSQL ID_item = '$itemID' LIMIT 0,1";	
				$res 	= mysql_query($qStr);
				$row2	= mysql_fetch_assoc($res);	
				$stock 	=  (int) $row2['amount'];	
			}
			
			
			if($stock > 0 && (($OPTION['wps_track_inventory']=='active') || ($OPTION['wps_track_inventory']=='not_active'))){
			
					
					// add as new item in table 
					$table 			= is_dbtable_there('shopping_cart');
					$column_array	= array();
					$value_array	= array();    
					
					
					$qStr 	= "SELECT cid 
									FROM $table 
								WHERE item_id = '$row[item_id]' AND item_attributs = '$row[item_attributs]' 
								AND item_personal = '$row[item_personal]' AND who = '$_SESSION[cust_id]'";
					$res	= mysql_query($qStr);
					$num	= mysql_num_rows($res);
					
					if($num == 0){
					//lets put the wishlist item into the shopping cart
					//change.9.9
						$column_array[0]	= 'cid';			$value_array[0]	= '';
						$column_array[1]	= 'item_id';		$value_array[1]	= $row['item_id'];
						$column_array[2]	= 'postID';			$value_array[2]	= $row['postID'];
						$column_array[3]	= 'item_name';		$value_array[3]	= $row['item_name'];
						$column_array[4]	= 'item_amount';	$value_array[4]	= $row['item_amount'];
						$column_array[5]	= 'item_price';		$value_array[5]	= $row['item_price'];
						$column_array[6]	= 'item_weight';	$value_array[6]	= $row['item_weight'];
						$column_array[7]	= 'item_thumb';		$value_array[7]	= $row['item_thumb'];	
						$column_array[8]	= 'item_attributs';	$value_array[8]	= $row['item_attributs'];	
						$column_array[9]	= 'item_personal';	$value_array[9]	= $row['item_personal'];					
						$column_array[10]	= 'who';			$value_array[10]= $_SESSION['cust_id'];
						$column_array[11]	= 'level';			$value_array[11]= '1';	
						$column_array[12]	= 'item_file';		$value_array[12]= $row['item_file'];	
										
						db_insert($table,$column_array,$value_array);
						update_personalization($row['wid'], mysql_insert_id()); 
					//\change.9.9
					}
					
					// remove from wishlist 
					$table 	= is_dbtable_there('wishlist');
					$qStr 	= "DELETE FROM $table WHERE wid = $wid";
					mysql_query($qStr);	
					
					$url 	= get_option('siteurl') . '/'.$customerArea->post_name.'?action=3&transfer=OK'; 
			}
			else {
					$url 	= get_option('siteurl') . '/'.$customerArea->post_name.'?action=3&transfer=NOK'; 	
			}
			header("Location: $url");
			exit(NULL);
		}
	
	
		function update_wl_item(){
		
			global $wpdb;
		
			$post_id 	= (int) $_POST['wl_item_post_id'];
			$meta_key	= $_POST['meta_key'];

			//get price from article
			$table	= $wpdb->prefix . 'postmeta';
			$sql 	= "SELECT meta_value FROM $table WHERE post_id = $post_id AND meta_key = '$meta_key'";
			$res 	= mysql_query($sql);
			$row	= mysql_fetch_assoc($res);
			
			
			//are there also attributes?
			if($_POST['add_attributes'] === '2'){
				$item_attr 	= trim($_POST['item_attributes']);
				$surcharge 	= $this->calculate_attr_surcharge($post_id,$item_attr);
				$newprice 	= (float) $row['meta_value'] + $surcharge;
			}else{
				$newprice 	= (float) $row['meta_value'];
			}

			//update wishlist record
			$table_name 		= is_dbtable_there('wishlist');
			$wid				= (int) $_POST['wl_item_wid'];
			$column_value_array = array();
			$where_conditions	= array();
			
			$column_value_array['item_price']	= $newprice;
			$where_conditions[0]				= "wid = $wid";
			
			db_update($table_name,$column_value_array,$where_conditions);		
		}		
		
		
		function calculate_attr_surcharge($post_id,$item_attr){
								
			global $wpdb;
								
			$surcharge 		= (float) 0.00;
			$table 			= $wpdb->prefix . 'postmeta';
			
			//explode data from $details[7]
			$attr1 = explode("#",$item_attr);
			
			// run thru the array to get the surcharges values
			foreach($attr1 as $v){
				$arr2 	= explode("=",$v);
				$mk 	= 'item_attr_' . $arr2[0];
				$qStr 	= "SELECT meta_value FROM $table WHERE post_id = $post_id 
								AND 
							meta_key = '$mk' LIMIT 0,1";
						
				$res 	= mysql_query($qStr);
				$row 	= mysql_fetch_assoc($res);
														
				$attr3 	= explode("|",$row['meta_value']);
				
				foreach($attr3 as $vv){
					$attr4 = explode("-",$vv);
					
					if($attr4[0] == $arr2[1] ){
						$surcharge = $surcharge + (float) $attr4[1];
					}
				}
			}
		return $surcharge;
		}
		
		
		function wl_product_check($details){
		
			global $wpdb;
			$table1		= $wpdb->prefix . 'postmeta';
			$table2		= $wpdb->prefix . 'posts';
		
			$feedback 	= array();
		
			//check if the product has been removed or changed 
			$feedback['product_changed'] = 0;
			
			// check 1: very basic, is the product still existant?
			$sql 	= "SELECT * FROM $table1,$table2 
							WHERE 
						$table1.post_id = $details[8] 
							AND
						$table1.post_id = $table2.ID
							AND
						$table2.post_status = 'publish'
							AND 
						$table1.meta_key = 'ID_item'
							AND 
						$table1.meta_value = '$details[5]'
						";
			$res 	= mysql_query($sql);			
			$num 	= mysql_num_rows($res);
			
			if($num == 0){
				$feedback['product_changed'] = 2;
			}
			
			
			// check 2: we check 'price' and 'new price' - but only when the product still exists
			if($feedback['product_changed'] == 0){
				$sql 	= "SELECT meta_value FROM $table1 WHERE post_id = $details[8] AND meta_key = 'price'";
				$res1 	= mysql_query($sql);
				$row1	= mysql_fetch_assoc($res1);
				$price	= (float) $row1['meta_value'];
				
				$feedback['current_price']	= $price;
				$feedback['field']			= 'price';

				$sql 			= "SELECT meta_value FROM $table1 WHERE post_id = $details[8] AND meta_key = 'new_price'";
				$res2 			= mysql_query($sql);
				$row2			= mysql_fetch_assoc($res2);
				
				if($row2 !== FALSE){
					$new_price					= (float) $row2['meta_value'];
					$feedback['field']			= 'new_price';
					$feedback['current_price']	= $new_price;
				}								
				
				// we also need to know if the product has price affecting attributes
				$feedback['add_attributes']	= 0;
				$sql 	= "SELECT meta_id FROM $table1 WHERE 
							post_id = $details[8] 
								AND 
							meta_key = 'add_attributes'
								AND 
							meta_value = '2'	
							";
				$res3 	= mysql_query($sql);
				$num3 	= mysql_num_rows($res3);
				
				
				// if yes, an additional price calculation for attributes surcharge has to follow + we add surcharge
				if($num3 > 0){
					$feedback['add_attributes']	= 2;
					$surcharge 					= $this->calculate_attr_surcharge($details[8],$details[7]);
					$feedback['current_price'] 	= $feedback['current_price'] + $surcharge;
				}
								
				$details[3] 		= (float) $details[3];		//wishlist price

				if($feedback['current_price'] !== $details[3]){
					$feedback['product_changed'] = 1;
				}
			}
		return $feedback;
		}
		
		
	
	}
?>