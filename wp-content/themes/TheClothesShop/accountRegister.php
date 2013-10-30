<?php
/*

Template Name: Account Register

*/

$p = explode('wp-content/',__FILE__);
include $p[0].'wp-load.php';

session_start();

if ( ! current_user_can( 'administrator' ) ) {
	auth(1);
}

get_header(); ?>

	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery("#effective_date").datepicker();
		});
	</script>


	<?php
	
	if(isset($_GET['err'])){
	
		$error_text = NULL;
	
		switch($_GET['err']){
		
			case '1':
				$error_text = __('Your email is too short.','wpShop');
			break;
			case '2':
				$error_text = __('Your username is too short.','wpShop');
			break;			
			case '3':
				$error_text = __('Your username is too long.','wpShop');
			break;			
			case '4':
				$error_text = __('Your email format is invalid.','wpShop');
			break;			
			case '5':
				$error_text = __('Your username is already taken.','wpShop');
			break;				
			case 'email':
				$error_text = __('This email is already registered, please choose another one.','wpShop');
			break;				
		}
	
		echo "<span class='login_err'>Error: $error_text</span>";
	}
	
	if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div <?php post_class('page_post'); ?> id="post-<?php the_ID(); ?>">
			<?php the_content('<p class="serif">'. __( 'Read the rest of this page &raquo;', 'wpShop' ) . '</p>'); 
			wp_link_pages(array('before' => '<p><strong>' . __( 'Pages:', 'wpShop' ) . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		</div><!-- page_post -->
	<?php endwhile; endif; ?>

	<div class="registrationForm">
		<form id="createAccount" class="clearfix" action="<?php echo get_bloginfo('template_url') . '/register.php'; ?>" method="post">
		<table>
					<tr id="ad_pt1">
						<td><?php _e('Email details','wpShop');?></td>
						<td>
							<input type="text" id="createAccountEmail1" name="email" size="35" maxlength="50" value="" onchange="showHint(this.value,'<?php echo is_in_subfolder();?>')"/ required>
						</td>
					</tr>		
<!-- 					<tr>
						<td>
							<?php _e('Username','wpShop');?>
						</td>
						<td>
							<input type="text" id="createAccountUsername" size="35" name="username" maxlength="10" value="" onkeyup="showUser(this.value,'<?php echo is_in_subfolder();?>')"/>
						</td>
					</tr>
 -->					<tr>
						<td>
							<?php _e('Dealership Contact','wpShop');?>
						</td>
						<td>
							<input type="text" id="contact" size="35" name="contact" value="" onkeyup="showUser(this.value,'<?php echo is_in_subfolder();?>')" required/>
						</td>
					</tr>
				<?php

				$table 				= is_dbtable_there('a2d_meta_master');//feusers');
				//$qStr 				="SELECT uid FROM $table WHERE uname = '$username'";	
				$qStr 				="SELECT * FROM $table WHERE meta_type = 'user' ORDER BY id";	

				$result 			= mysql_query($qStr);
				$num 				= mysql_num_rows($result);

				while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
					$id = $row[0];
					$key = $row[1];
					$desc = $row[3];
					if ( $key == "dealership_id" ) {
						$dealershipid = "SD";

					} else {


	 			   ?>
					<tr id="ad_pt<?php echo $id;?>">
						<td><?php echo $desc;?></td>
						<td>
							<?php
								if ($key == "dealership_address_state") {
								?>
								<select name="<?php echo $key;?>" id="<?php echo $key;?>" placeholder="ADDRESS_HOME_STATE" required>
			                        <option value="">Please Select One:</option>
			                        <option value="AL">AL</option>
			                        <option value="AK">AK</option>
			                        <option value="AZ">AZ</option>
			                        <option value="AR">AR</option>
			                        <option value="CA">CA</option>
			                        <option value="CO">CO</option>
			                        <option value="CT">CT</option>
			                        <option value="DC">DC</option>
			                        <option value="DE">DE</option>
			                        <option value="FL">FL</option>
			                        <option value="GA">GA</option>
			                        <option value="HI">HI</option>
			                        <option value="ID">ID</option>
			                        <option value="IL">IL</option>
			                        <option value="IN">IN</option>
			                        <option value="IA">IA</option>
			                        <option value="KS">KS</option>
			                        <option value="KY">KY</option>
			                        <option value="LA">LA</option>
			                        <option value="ME">ME</option>
			                        <option value="MD">MD</option>
			                        <option value="MA">MA</option>
			                        <option value="MI">MI</option>
			                        <option value="MN">MN</option>
			                        <option value="MS">MS</option>
			                        <option value="MO">MO</option>
			                        <option value="MT">MT</option>
			                        <option value="NE">NE</option>
			                        <option value="NV">NV</option>
			                        <option value="NH">NH</option>
			                        <option value="NJ">NJ</option>
			                        <option value="NM">NM</option>
			                        <option value="NY">NY</option>
			                        <option value="NC">NC</option>
			                        <option value="ND">ND</option>
			                        <option value="OH">OH</option>
			                        <option value="OK">OK</option>
			                        <option value="OR">OR</option>
			                        <option value="PA">PA</option>
			                        <option value="RI">RI</option>
			                        <option value="SC">SC</option>
			                        <option value="SD">SD</option>
			                        <option value="TN">TN</option>
			                        <option value="TX">TX</option>
			                        <option value="UT">UT</option>
			                        <option value="VT">VT</option>
			                        <option value="VA">VA</option>
			                        <option value="WA">WA</option>
			                        <option value="WV">WV</option>
			                        <option value="WI">WI</option>
			                        <option value="WY">WY</option>
			                    </select>

								<?php
								} elseif ($key == "dealership_address_country") {
								?>
									<select name="<?php echo $key;?>" id="<?php echo $key;?>" placeholder="ADDRESS_HOME_COUNTRY" required>
									  <option></option>
									  <option value="United States" selected>United States</option>
									  <option value="Abkhazia">Abkhazia</option>
									  <option value="Afghanistan">Afghanistan</option>
									  <option value="Albania">Albania</option>
									  <option value="Algeria">Algeria</option>
									  <option value="American Samoa">American Samoa</option>
									  <option value="Andorra">Andorra</option>
									  <option value="Angola">Angola</option>
									  <option value="Anguilla">Anguilla</option>
									  <option value="Antigua and Barbuda">Antigua and Barbuda</option>
									  <option value="Argentina">Argentina</option>
									  <option value="Armenia">Armenia</option>
									  <option value="Aruba">Aruba</option>
									  <option value="Australia">Australia</option>
									  <option value="Austria">Austria</option>
									  <option value="Azerbaijan">Azerbaijan</option>
									  <option value="The Bahamas">The Bahamas</option>
									  <option value="Bahrain">Bahrain</option>
									  <option value="Bangladesh">Bangladesh</option>
									  <option value="Barbados">Barbados</option>
									  <option value="Belarus">Belarus</option>
									  <option value="Belgium">Belgium</option>
									  <option value="Belize">Belize</option>
									  <option value="Benin">Benin</option>
									  <option value="Bermuda">Bermuda</option>
									  <option value="Bhutan">Bhutan</option>
									  <option value="Bolivia">Bolivia</option>
									  <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
									  <option value="Botswana">Botswana</option>
									  <option value="Brazil">Brazil</option>
									  <option value="Brunei">Brunei</option>
									  <option value="Bulgaria">Bulgaria</option>
									  <option value="Burkina Faso">Burkina Faso</option>
									  <option value="Burundi">Burundi</option>
									  <option value="Cambodia">Cambodia</option>
									  <option value="Cameroon">Cameroon</option>
									  <option value="Canada">Canada</option>
									  <option value="Cape Verde">Cape Verde</option>
									  <option value="Cayman Islands">Cayman Islands</option>
									  <option value="Central African Republic">Central African Republic</option>
									  <option value="Chad">Chad</option>
									  <option value="Chile">Chile</option>
									  <option value="People's Republic of China">People's Republic of China</option>
									  <option value="Republic of China">Republic of China</option>
									  <option value="Christmas Island">Christmas Island</option>
									  <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
									  <option value="Colombia">Colombia</option>
									  <option value="Comoros">Comoros</option>
									  <option value="Congo">Congo</option>
									  <option value="Cook Islands">Cook Islands</option>
									  <option value="Costa Rica">Costa Rica</option>
									  <option value="Cote d'Ivoire">Cote d'Ivoire</option>
									  <option value="Croatia">Croatia</option>
									  <option value="Cuba">Cuba</option>
									  <option value="Cyprus">Cyprus</option>
									  <option value="Czech Republic">Czech Republic</option>
									  <option value="Denmark">Denmark</option>
									  <option value="Djibouti">Djibouti</option>
									  <option value="Dominica">Dominica</option>
									  <option value="Dominican Republic">Dominican Republic</option>
									  <option value="Ecuador">Ecuador</option>
									  <option value="Egypt">Egypt</option>
									  <option value="El Salvador">El Salvador</option>
									  <option value="Equatorial Guinea">Equatorial Guinea</option>
									  <option value="Eritrea">Eritrea</option>
									  <option value="Estonia">Estonia</option>
									  <option value="Ethiopia">Ethiopia</option>
									  <option value="Falkland Islands">Falkland Islands</option>
									  <option value="Faroe Islands">Faroe Islands</option>
									  <option value="Fiji">Fiji</option>
									  <option value="Finland">Finland</option>
									  <option value="France">France</option>
									  <option value="French Polynesia">French Polynesia</option>
									  <option value="Gabon">Gabon</option>
									  <option value="The Gambia">The Gambia</option>
									  <option value="Georgia">Georgia</option>
									  <option value="Germany">Germany</option>
									  <option value="Ghana">Ghana</option>
									  <option value="Gibraltar">Gibraltar</option>
									  <option value="Greece">Greece</option>
									  <option value="Greenland">Greenland</option>
									  <option value="Grenada">Grenada</option>
									  <option value="Guadeloupe">Guadeloupe</option>
									  <option value="Guam">Guam</option>
									  <option value="Guatemala">Guatemala</option>
									  <option value="Guernsey">Guernsey</option>
									  <option value="Guinea">Guinea</option>
									  <option value="Guinea-Bissau">Guinea-Bissau</option>
									  <option value="Guyana">Guyana</option>
									  <option value="Haiti">Haiti</option>
									  <option value="Honduras">Honduras</option>
									  <option value="Hong Kong">Hong Kong</option>
									  <option value="Hungary">Hungary</option>
									  <option value="Iceland">Iceland</option>
									  <option value="India">India</option>
									  <option value="Indonesia">Indonesia</option>
									  <option value="Iran">Iran</option>
									  <option value="Iraq">Iraq</option>
									  <option value="Ireland">Ireland</option>
									  <option value="Israel">Israel</option>
									  <option value="Italy">Italy</option>
									  <option value="Jamaica">Jamaica</option>
									  <option value="Japan">Japan</option>
									  <option value="Jersey">Jersey</option>
									  <option value="Jordan">Jordan</option>
									  <option value="Kazakhstan">Kazakhstan</option>
									  <option value="Kenya">Kenya</option>
									  <option value="Kiribati">Kiribati</option>
									  <option value="North Korea">North Korea</option>
									  <option value="South Korea">South Korea</option>
									  <option value="Kosovo">Kosovo</option>
									  <option value="Kuwait">Kuwait</option>
									  <option value="Kyrgyzstan">Kyrgyzstan</option>
									  <option value="Laos">Laos</option>
									  <option value="Latvia">Latvia</option>
									  <option value="Lebanon">Lebanon</option>
									  <option value="Lesotho">Lesotho</option>
									  <option value="Liberia">Liberia</option>
									  <option value="Libya">Libya</option>
									  <option value="Liechtenstein">Liechtenstein</option>
									  <option value="Lithuania">Lithuania</option>
									  <option value="Luxembourg">Luxembourg</option>
									  <option value="Macau">Macau</option>
									  <option value="Macedonia">Macedonia</option>
									  <option value="Madagascar">Madagascar</option>
									  <option value="Malawi">Malawi</option>
									  <option value="Malaysia">Malaysia</option>
									  <option value="Maldives">Maldives</option>
									  <option value="Mali">Mali</option>
									  <option value="Malta">Malta</option>
									  <option value="Marshall Islands">Marshall Islands</option>
									  <option value="Martinique">Martinique</option>
									  <option value="Mauritania">Mauritania</option>
									  <option value="Mauritius">Mauritius</option>
									  <option value="Mayotte">Mayotte</option>
									  <option value="Mexico">Mexico</option>
									  <option value="Micronesia">Micronesia</option>
									  <option value="Moldova">Moldova</option>
									  <option value="Monaco">Monaco</option>
									  <option value="Mongolia">Mongolia</option>
									  <option value="Montenegro">Montenegro</option>
									  <option value="Montserrat">Montserrat</option>
									  <option value="Morocco">Morocco</option>
									  <option value="Mozambique">Mozambique</option>
									  <option value="Myanmar">Myanmar</option>
									  <option value="Nagorno-Karabakh">Nagorno-Karabakh</option>
									  <option value="Namibia">Namibia</option>
									  <option value="Nauru">Nauru</option>
									  <option value="Nepal">Nepal</option>
									  <option value="Netherlands">Netherlands</option>
									  <option value="Netherlands Antilles">Netherlands Antilles</option>
									  <option value="New Caledonia">New Caledonia</option>
									  <option value="New Zealand">New Zealand</option>
									  <option value="Nicaragua">Nicaragua</option>
									  <option value="Niger">Niger</option>
									  <option value="Nigeria">Nigeria</option>
									  <option value="Niue">Niue</option>
									  <option value="Norfolk Island">Norfolk Island</option>
									  <option value="Turkish Republic of Northern Cyprus">Turkish Republic of Northern Cyprus</option>
									  <option value="Northern Mariana">Northern Mariana</option>
									  <option value="Norway">Norway</option>
									  <option value="Oman">Oman</option>
									  <option value="Pakistan">Pakistan</option>
									  <option value="Palau">Palau</option>
									  <option value="Palestine">Palestine</option>
									  <option value="Panama">Panama</option>
									  <option value="Papua New Guinea">Papua New Guinea</option>
									  <option value="Paraguay">Paraguay</option>
									  <option value="Peru">Peru</option>
									  <option value="Philippines">Philippines</option>
									  <option value="Pitcairn Islands">Pitcairn Islands</option>
									  <option value="Poland">Poland</option>
									  <option value="Portugal">Portugal</option>
									  <option value="Puerto Rico">Puerto Rico</option>
									  <option value="Qatar">Qatar</option>
									  <option value="Romania">Romania</option>
									  <option value="Russia">Russia</option>
									  <option value="Rwanda">Rwanda</option>
									  <option value="Saint Barthelemy">Saint Barthelemy</option>
									  <option value="Saint Helena">Saint Helena</option>
									  <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
									  <option value="Saint Lucia">Saint Lucia</option>
									  <option value="Saint Martin">Saint Martin</option>
									  <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
									  <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
									  <option value="Samoa">Samoa</option>
									  <option value="San Marino">San Marino</option>
									  <option value="Sao Tome and Principe">Sao Tome and Principe</option>
									  <option value="Saudi Arabia">Saudi Arabia</option>
									  <option value="Senegal">Senegal</option>
									  <option value="Serbia">Serbia</option>
									  <option value="Seychelles">Seychelles</option>
									  <option value="Sierra Leone">Sierra Leone</option>
									  <option value="Singapore">Singapore</option>
									  <option value="Slovakia">Slovakia</option>
									  <option value="Slovenia">Slovenia</option>
									  <option value="Solomon Islands">Solomon Islands</option>
									  <option value="Somalia">Somalia</option>
									  <option value="Somaliland">Somaliland</option>
									  <option value="South Africa">South Africa</option>
									  <option value="South Ossetia">South Ossetia</option>
									  <option value="Spain">Spain</option>
									  <option value="Sri Lanka">Sri Lanka</option>
									  <option value="Sudan">Sudan</option>
									  <option value="Suriname">Suriname</option>
									  <option value="Svalbard">Svalbard</option>
									  <option value="Swaziland">Swaziland</option>
									  <option value="Sweden">Sweden</option>
									  <option value="Switzerland">Switzerland</option>
									  <option value="Syria">Syria</option>
									  <option value="Taiwan">Taiwan</option>
									  <option value="Tajikistan">Tajikistan</option>
									  <option value="Tanzania">Tanzania</option>
									  <option value="Thailand">Thailand</option>
									  <option value="Timor-Leste">Timor-Leste</option>
									  <option value="Togo">Togo</option>
									  <option value="Tokelau">Tokelau</option>
									  <option value="Tonga">Tonga</option>
									  <option value="Transnistria Pridnestrovie">Transnistria Pridnestrovie</option>
									  <option value="Trinidad and Tobago">Trinidad and Tobago</option>
									  <option value="Tristan da Cunha">Tristan da Cunha</option>
									  <option value="Tunisia">Tunisia</option>
									  <option value="Turkey">Turkey</option>
									  <option value="Turkmenistan">Turkmenistan</option>
									  <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
									  <option value="Tuvalu">Tuvalu</option>
									  <option value="Uganda">Uganda</option>
									  <option value="Ukraine">Ukraine</option>
									  <option value="United Arab Emirates">United Arab Emirates</option>
									  <option value="United Kingdom">United Kingdom</option>
									  <option value="Uruguay">Uruguay</option>
									  <option value="Uzbekistan">Uzbekistan</option>
									  <option value="Vanuatu">Vanuatu</option>
									  <option value="Vatican City">Vatican City</option>
									  <option value="Venezuela">Venezuela</option>
									  <option value="Vietnam">Vietnam</option>
									  <option value="British Virgin Islands">British Virgin Islands</option>
									  <option value="US Virgin Islands">US Virgin Islands</option>
									  <option value="Wallis and Futuna">Wallis and Futuna</option>
									  <option value="Western Sahara">Western Sahara</option>
									  <option value="Yemen">Yemen</option>
									  <option value="Zambia">Zambia</option>
									  <option value="Zimbabwe">Zimbabwe</option>
									</select>

								<?php

								} else {

								?>

							<input type="text" id="<?php echo $key;?>" name="<?php echo $key;?>" size="35" maxlength="50" value="" required/>
							<?php } ?>
						</td>
					</tr>
	 			   <?php
					}
				}

			?>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" class="formbutton formbutton_new" style="padding: 6px;" value="<?php _e('Register','wpShop');?>" />
				</td>
			</tr>
		</table>
	</form>
</div>
	
	<?php if ( is_sidebar_active('account_reg_widget_area') ) : ?>
		<div class="acc_widgets_area alignright">
			<?php dynamic_sidebar('account_reg_widget_area'); ?>
		</div><!-- c_box  -->
	<?php endif;
	
	
get_footer(); ?>