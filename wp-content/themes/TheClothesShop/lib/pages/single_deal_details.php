<?php

	echo "<table width='100%' class='deal_info_display'>";
	echo "<tr>";
	echo "<th>Year</th>";
	echo "<th>Make</th>";
	echo "<th>Model</th>";
	echo "<th>Trim</th>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>" . get_custom_field("ad_year")  . "</td>";
	echo "<td>" . get_custom_field("ad_make")  . "</td>";
	echo "<td>" . get_custom_field("ad_model")  . "</td>";
	echo "<td>" . get_custom_field("ad_trim")  . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>Color</th>";
	echo "<th>Mileage</th>";
	echo "<th>Price</th>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>" . get_custom_field("ad_color")  . "</td>";
	echo "<td>" . get_custom_field("ad_miles")  . "</td>";
	echo "<td class='price_option'>" .$OPTION['wps_currency_symbol'] . format_price(get_custom_field('ad_price'));
	// $current_user = get_current_user_info();
	// if ( $current_user->ID == $post->post_author) {
	// 	echo "<button class='modify_price'>Edit Price</button>";
	// }
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "<table width='100%' class='deal_info_display'>";
	echo "<tr>";
	echo "<th colspan='2'>Dealer Details</th>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>" . get_user_meta($post->post_author, "dealership_name", true)  . "</td>";
	echo "<td rowspan='5'>";
	include (STYLESHEETPATH . '/lib/pages/contact_dealer.php');
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><span class='askfor'>Ask For</span>:&nbsp;" . get_user_meta($post->post_author, "first_name", true) . ' ' . get_user_meta($post->post_author, "last_name", true)  . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>" . get_user_meta($post->post_author, "dealership_address_line_1", true)  . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>" . get_user_meta($post->post_author, "dealership_address_city", true) . ', ' . get_user_meta($post->post_author, "dealership_address_state", true) . ' ' . get_user_meta($post->post_author, "dealership_address_zipcode", true)  . "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>Phone:&nbsp;" . get_user_meta($post->post_author, "dealership_phone", true)  . "</td>";
	echo "</tr>";
	echo "</table>";
	echo "<table width='100%' class='deal_info_display'>";
	echo "<tr>";
	echo "<th>Description</th>";
	// $current_user = get_current_user_info();
	// if ( $current_user->ID == $post->post_author) {
	// 	echo "<th><button class='modify_content'>Edit Description</button></th>";
	// }
	echo "</tr>";
	echo "</table>";
?>
<!-- <form name="modify_attrs" id="modify_attrs">
	<fieldset>
		<caption><h3>Modify Deal</h3></caption>
		<label for="field_name"><span id="field_string"></span></label>
		<input>
	</fieldset>
</form> -->