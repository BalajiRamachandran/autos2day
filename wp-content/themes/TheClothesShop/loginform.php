<?php
if($_GET['failed'] == '1'){
	echo "<div class='login_err'>".__('Sorry - logging failed! Try again.','wpShop')."</div>";
}
if($_GET['reset'] == '1'){
	echo "<div class='success'>".__('You reset password has been sent','wpShop')."</div>";
}
$lostPass	= get_page_by_title($OPTION['wps_passLostPg']);

session_start();

if (is_user_logged_in()) {
	header("Location: " . get_bloginfo('url'));
	exit(NULL);
}

//action=rp&key=b7FFGCNsP8w2PkVBIqaz&login=balaji%40hotmail.com
if ( $_GET['action'] == 'rp') {
	//reset password

}


?>
<form id="signInForm" method="post" action="<?php echo get_bloginfo('url') . '/wp-login.php?redirect_to=' . $_SERVER['REQUEST_URI']; ?>">
	<fieldset>
		<label for="log"><?php _e('Username','wpShop');?></label>
			<input type="text" name="log" id="log" size="35" value="<?php echo $_SESSION['uname']; ?>" />
		<label for="pwd"><?php _e('Password','wpShop');?></label>
		<input id="pwd" type="password" size="35" value="" name="pwd"/>
		<span class="passhelp"> <?php _e('I lost my password. Please','wpShop');?> <a href="<?php echo get_permalink($lostPass->ID); ?>"><?php _e('email it to me','wpShop');?></a></span>
		<input type='hidden' name='redirect_to' value='<?php echo get_bloginfo('url').'/my-account'; ?>' />
		<input class="formbutton" type="submit" alt="<?php _e('Sign in','wpShop');?>" value="<?php _e('Sign in','wpShop');?>" name="" title="<?php _e('Sign in','wpShop');?>" />
	</fieldset>
</form>


<!-- <form id="signInForm" method="post" action="<?php echo get_bloginfo('template_url') . '/login.php'; ?>">
	<fieldset>
		<label for="log"><?php _e('Username','wpShop');?></label>
			<input type="text" name="log" id="log" size="35" maxlength="10" value="<?php echo $_SESSION['uname']; ?>" />
		<label for="pwd"><?php _e('Password','wpShop');?></label>
		<input id="pwd" type="password" size="35" maxlength="8" value="" name="pwd"/>
		<span class="passhelp"> <?php _e('I lost my password. Please','wpShop');?> <a href="<?php echo get_permalink($lostPass->ID); ?>"><?php _e('email it to me','wpShop');?></a></span>
		<input type='hidden' name='gotoURL' value='<?php echo get_real_base_url(); ?>' />
		<input class="formbutton" type="submit" alt="<?php _e('Sign in','wpShop');?>" value="<?php _e('Sign in','wpShop');?>" name="" title="<?php _e('Sign in','wpShop');?>" />
	</fieldset>
</form>
 -->