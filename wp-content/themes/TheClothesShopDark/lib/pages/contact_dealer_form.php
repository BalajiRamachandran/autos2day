<?php
	require_once dirname(__FILE__) . '/../../../../../wp-load.php';
	global $post;
?>
<script type="text/javascript">

jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, ""); 
	return this.optional(element) || phone_number.length > 9 &&
		phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
}, "Please specify a valid phone number");

jQuery(document).ready(function(){
	jQuery(".message").hide();
	jQuery(".contact_dealer_form form").validate({
		rules: {
			contact_name : {
				required : true
			},
			contact_email : {
				required : true,
				email : true
			},
			othersource : {
				required : true
			},
			source : {
				required : true
			},
			comments : {
				required : true
			},
			phoneno : {
				required : true,
				minlength: 10,
				maxlength: 10
			}
		},
			
		messages: {
			contact_name : {
				required : "Enter your Name"
			},
			contact_email : {
				required : "Enter your email",
				email : "Enter valid email"
			},
			othersource : {
				required : "Enter the other source"
			},
			source : {
				required : "Select a source"
			},
			comments : {
				required : "Comments are required!"
			},
			phoneno : {
				required : "Enter your phone number",
				minlength : "Enter valid 10 digint phone number"
			}
		},
		 submitHandler: function(form) {
			var formdata = jQuery(form).serialize();
			var urlpath = '<?php echo get_stylesheet_directory_uri();?>';
			url = urlpath  + '/lib/pages/sendemail.php?' + formdata;
			// jQuery.parent.colorbox.close();
			jQuery(form).hide();
			jQuery(".message").show();
			jQuery(".message").html( '<center><p>Contacting Dealer</p><img src="'+urlpath+'/images/ajax-loader.gif"/></center>' );
			// // alert ( urlpath);
			jQuery.ajax({
				type:"GET",
				url: url,
				success: function(data){
					jQuery(".message").html ( "<p>Successfully sent the message to dealer!</p>" );
				},
				error : function ( data ) {
					jQuery(".message").html ( "<p>Contact dealer failed! Please try again latter!</p>" );
				}
			});
			return false;
		 },
        invalidHandler: function(form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                window.setTimeout('$.colorbox.resize()',10);
        	 }
     	}
                	
	});
	// jQuery("#contactdealerform").submit(function(){
	// 	return false;
	// 	var formdata = jQuery(this).serialize();
	// 	var urlpath = '<?php echo get_stylesheet_directory_uri();?>';
	// 	url = urlpath  + '/lib/pages/sendemail.php?' + formdata;
	// 	jQuery(this).hide();
	// 	jQuery(".message").show();
	// 	jQuery(".message").html( '<center><p>Contacting Dealer</p><img src="'+urlpath+'/images/ajax-loader.gif"/></center>' );
	// 	// // alert ( urlpath);
	// 	jQuery.ajax({
	// 		type:"GET",
	// 		url: url,
	// 		success: function(data){
	// 			jQuery(".message").html ( data );
	// 		}
	// 	});
	// 	return false;
	// });
});
</script>
<div class="contact_dealer_form">
	<h3>Contact Dealer Form</h3>
	<form class="contactdealerform" name="contactdealerform" id="contactdealerform" method="POST" action="#">
		<?php if ( $_GET['p'] ) { $post = get_post ( $_GET['p'], OBJECT); } ?>
		<input type="hidden" name="subject" value="Re: <?php echo $post->post_title;?> on Autos2Day.com"/>
		<input type="hidden" name="to" value="<?php echo get_user_by ( 'id', $post->post_author )->user_email;?>"/>
		<input type="hidden" name="dealer" value="<?php echo $post->post_author;?>"/>
		<input type="hidden" name="link" value="<?php echo get_permalink($post->ID);?>"/>
	    <p>
	      <label for="contact_name">Name</label>
	      <input type="text" id="contact_name" name="contact_name" />
	    </p>
	    <p>
	      <label for="contact_email">Email</label>
	      <input type="text" id="contact_email" name="contact_email" />
	    </p>
	    <p>
	      <label for="phoneno">Phone No</label>
	      <input type="text" id="phoneno" name="phoneno" />
	    </p>
	    <p>
	      <label for="comments">Question/Comments</label>
	      <textarea rows='2' cols='30' id='comments' name='comments' ></textarea>
	    </p>
	    <p>
	    	<button type="submit">Submit</button>
	    </p>
	</form>
	<div class="message"></div>
</div>
