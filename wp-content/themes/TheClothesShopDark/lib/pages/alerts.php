<?php
	require_once dirname(__FILE__) . '/../../../../../wp-load.php';

	if (
		is_user_logged_in() 
		&& get_option("disable_payment_processing") == "0"
		&& ( !isset($AUTH_NET_PROFILE) || strlen($AUTH_NET_PROFILE) == 0 ) 
		&& (strpos($_SERVER['REQUEST_URI'], "myaccount=1&action=4") === false) 
		) {
		?>
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() . '/css/jquery-ui-1.8.21.custom.css';?>" type="text/css" media="all" />
	<script type="text/javascript">
	    jQuery(document).ready(function(){
	        jQuery(".alert").show();
	        // jQuery(".alert").effect("shake", { times:3 }, 300);
	        jQuery(".alert-close").click(function(){
	            jQuery(".alert").hide();
	        });
	    });
	</script>
	<style type="text/css">
	.alert {
	    margin: auto;
	    width: 800px;
	    border: 1px solid;
	    margin-bottom: 5px;
	    padding: 5px;
	    margin-top: 10px;
	    border-radius: 15px;
	/*		    -webkit-box-shadow: 2px 5px 12px #555;    
	    box-shadow: 2px 5px 12px #555;    
	    -moz-box-shadow: 2px 5px 12px #555;    
	*/
	    -webkit-box-shadow: 0 0 20px #fff;    
	    box-shadow: 0 0 20px #fff;    
	    -moz-box-shadow: 0 0 20px #fff;    
	}
	.alert-content {
		margin: 10px auto;
	    padding-top: 5px;
	    padding-bottom: 5px;    
	}
	.alert .alert-close {
	    float: right;
	    text-decoration: underline;
	}
	.alert p {
	    text-align: center;
	    line-height: 1em;
	    margin: 0px;
	    padding-top: 6px;
	}
	</style>
	<div class='alert'>
	    <span class="ui-icon ui-icon-closethick alert-close">close</span>
	    <div class="alert-content">
	    	<center>
	    		<?php
	    			echo apply_filters('the_content', get_page_by_title ('Alerts')->post_content); 
	    		?>
	    		<p><a href="<?php echo get_permalink(get_page_by_title('My Account')->ID) . '?myaccount=1&action=4'?>">Click here to Update</a></p>
	    	</center>
	    </div>
	</div>

	<?php
	}

?>