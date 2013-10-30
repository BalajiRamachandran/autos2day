<table class="voucher_details">
<tr>
	<th colspan="2">Voucher Details</th>
</tr>
<tr>
	<td>
		<table class="voucher_details_child">
			<tr><td><?php echo $post_meta['ad_year'][0];?> <?php echo $post_meta['ad_make'][0];?></td></tr>
			<tr><td><?php echo $post_meta['ad_model'][0];?> - <?php echo $post_meta['ad_trim'][0];?></td></tr>
			<tr><td><?php echo $post_meta['ad_color'][0];?>, <?php echo $post_meta['ad_miles'][0];?> Miles</td></tr>
		</table>
	</td>
<!-- 	<td>
		<table class="voucher_details_child">
			<tr><td><?php echo $user_meta['dealership_name'][0];?></td></tr>
			<tr><td><?php echo $user_meta['dealership_address_line_1'][0];?></td></tr>
			<tr><td><?php echo $user_meta['dealership_address_city'][0];?>, <?php echo $user_meta['dealership_address_state'][0];?> <?php echo $user_meta['dealership_address_zipcode'][0];?></td></tr>
			<tr><td>PH: <?php echo $user_meta['dealership_phone'][0];?></td></tr>
		</table>
	</td>
 --></tr>
<tr>
	<td style='text-align: center;' colspan="2">
		<table class="voucher_details_child">
			<?php 
				echo '<tr>';
				echo '<td colspan="2">VIN</td>';
				echo '<td>' . $post_meta['ad_vin'][0] . '</td>';												
				echo '</tr>';
				echo '<tr>';
				echo '<td colspan="2">';
				echo '<strong>VOUCHER</strong>';
				echo '</td>';
				echo '<td>';
				echo '<strong>' . $voucher_code . '</strong>';
				echo '</td>';												
				echo '</tr>';
			?>								
		</table>
	</td>
</tr>
</table>
<img src="<?php echo $qr_code?>"/>