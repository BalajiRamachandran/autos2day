<?php
	// submit vouchers
	if ( isset( $_GET ) ) {
		if ( isset ( $_POST['voucher_code'] ) ) {
			if ( strlen( $_POST['voucher_code'] ) > 0 ) {
				$voucher_code = $_POST['voucher_code'];
				//$current_user
				// query by author and voucher #
				$table 				= is_dbtable_there('ad_vouchers');//feusers');
				$qStr 				="SELECT * FROM $table WHERE voucher = '$voucher_code'";	
				$result 			= mysql_query($qStr);
				$num 				= mysql_num_rows($result);						
				while($row = mysql_fetch_assoc($result)){		
					$post_id = $row['post_id'];					
				}
			}
			if ( $num > 0 ) {
				$qStr 			="UPDATE $table SET date_sold = CURDATE() WHERE voucher = '$voucher_code'";
				$res 			= mysql_query($qStr);
				if ( $res==true) {
					//update the post to sold_out
					update_post_meta($post_id, 'ad_post_status', 'SOLD OUT');
					// $post = get_post ( $post_id );
					// $post->post_status = 'SOLDOUT';
					// wp_update_post( $post );
					echo '<div class="success">Successfully Updated your voucher code, Thanks.</div>';	
				} else {
					echo '<div class="success">Voucher Code update failed, Please try again!.</div>';	
				}
			} else {
				echo '<div class="success">Invalid Voucher no</div>';
			}					
		}
	} 
?>
	<form action="#" method="post" name="update_voucher">
		<fieldset>
			<label for="voucher_no">DEAL SOLD: Enter your Voucher no</label>
			<input type="text" value="" tabindex="35" name="voucher_code" id="voucher_code" required/>
		</fieldset>
		<fieldset class="submit">
			<input type="submit" value="GO" tabindex="40" id="submit" name="submit" />
		</fieldset>				
	</form>
