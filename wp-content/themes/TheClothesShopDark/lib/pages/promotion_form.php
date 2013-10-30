<?php
//promotion form
	require_once dirname(__FILE__) . '/../../../../../wp-load.php';
	$protocol = 'http://';
	if ( is_ssl() ) {
		$protocol = 'https://';
	}
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("*[source='Other']").hide();
	jQuery("#source").live("change", function(){
		if ( jQuery("#source").val() == "Other" ) {
			jQuery("*[source='Other']").show();
			jQuery("#othersource").val('');
		} else {
			jQuery("*[source='Other']").hide();
			jQuery("#othersource").val(jQuery("#source").val());
		}
	});
	jQuery(".pform form").validate({
		rules: {
			signInUsername: {
				required: true,
				minlength: 5,
				maxlength: 10
			},
			signInPassword: {
				required: true,
				minlength: 4,
				maxlength: 8
			},
			newEmail: {
				required: true,
				email: true
			},
			rnewEmail: {
				required: true,
				email: true,
				equalTo: "#newEmail"
			},
			newPassword: {
				required: true,
				minlength: 4
			},
			rnewPassword: {
				required: true,
				minlength: 4,
				equalTo: "#newPassword"
			},
			voucher_email: {
				required : true,
				email: true
			},
			visitor : {
				required : true
			},
			name : {
				required : true
			},
			email : {
				required : true,
				email : true
			},
			othersource : {
				required : true
			},
			source : {
				required : true
			}
		},
			
		messages: {
			signInUsername: {
				required: "Please enter your username.",
				minlength: "Your username must have at least 6 characters!"
			},
			signInPassword: {
				required: "Please enter your password.",
				minlength: "Your password must have at least 4 characters!"
			},
			newEmail: {
				required: "Please enter an email.",
				email: "Please enter a valid email address!"
			},
			rnewEmail: {
				required: "Please enter an email.",
				email: "Please enter a valid email address!",
				equalTo: "Oops! Be sure to type the same email again!"
			},
			newPassword: {
				required: "Please enter a password.",
				minlength: "Your password must have at least 4 characters!"
			},
			rnewPassword: {
				required: "Please enter a password.",
				minlength: "Your password must have at least 4 characters!",
				equalTo: "Oops! Be sure to type the same password again!"
			},
			voucher_email: {
				required : "Please enter an email",
				email: "Please enter a valid email address!"
			},
			visitor : {
				required : "Please enter your name"
			},
			name : {
				required : "Enter your Name"
			},
			email : {
				required : "Enter your email",
				email : "Enter valid email"
			},
			othersource : {
				required : "Enter the other source"
			},
			source : {
				required : "Select a source"
			}

		}		
	});
	jQuery("#promotion").submit(function(){
		// alert ( jQuery("#promotion").serialize() );
		// var protocol = "<?php echo $protocol;?>";
		var error = 0;
		jQuery(".error").each ( function() {
			// alert ( jQuery(this).attr("id") );
			// alert ( jQuery(this).css('display') );
			if ( jQuery(this).css('display') != 'none') {
				error = 1;
			}
		});
		if ( error == "1" ) {
			return false;
		} else {
			// alert ( error );
		}
		// return false;
		var urlpath = "<?php echo get_stylesheet_directory_uri();?>";
		urlpath = urlpath  + '/lib/pages/promotion_submission.php?' + jQuery("#promotion").serialize();
		// alert ( urlpath);
		jQuery.ajax({
			type:"GET",
			url: urlpath,
			success: function(data){
				jQuery("#promotion").html ( data );
			}
		});

		// jQuery("#promotion").html("Thanks for entering!");
		// parent.jQuery.colorbox.close();
		return false;
	});
});
</script>
<div class="pform">
	<div class="banner-head">
		<h3>Choose your next car through Autos2Day <br/>to receive a <?php echo get_option("wps_promotion");?>.</h3>
	</div>
	<?php 

	$page = get_page_by_title("25$ Promotion");
	echo apply_filters( 'the_content', $page->post_content ); 

	?>
<!-- 	<div class="banner-sub-head">
		<h4>To redeem your gas card, you need to submit through the contact us link on our home page with following information</h4>
	</div>
	<div class="banner-content">
		<h5>Rules</h5>
	    <p>Purchase Information - VIN number, Make, Model, Voucher code.</p>
	    <p>Mailing information - Customer Name, Email(name and email should match your entry below), Dealership name.</p>
	    <p>Once we verify your purchase, we will mail you the gas card within 2-4 weeks."</p>
	    <blockquote>Promotion valid until October 31st, 2012.</blockquote>
	</div>
 -->  <div class="clearfix">
    <!---->
  </div>
  <p />
  <form name="promotion" id="promotion" method="POST" action="<?php echo home_url();?>">
    <p>
      <label for="source">How did you hear about us?</label>
      <select name="source" id="source">
        <option value="">Select One</option>
        <option>Newspaper</option>
        <option>Radio</option>
        <option>Other</option>
      </select>
    </p>
    <p source="Other">
      <label for="othersource">Specify</label>
      <input type="text" name="othersource" id="othersource" />
    </p>
    <p>
      <label for="name">Name</label>
      <input type="text" id="name" name="name" />
    </p>
    <p>
      <label for="email">Email</label>
      <input type="text" id="email" name="email" />
    </p>
    <p>
      <label></label>
      <button ref="jbutton" type="submit" value="true">Submit</button>
    </p>
  </form>
</div>
