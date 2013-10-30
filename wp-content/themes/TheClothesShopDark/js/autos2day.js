jQuery(document).ready(function(){

	jQuery(".mark_as_sold").live("click", function(){
		var url = stylesheet_directory + "/lib/pages/update_deal_sold.php?id=" + jQuery(this).attr("post_id");
		jQuery.ajax ({
			url: url,
			type: "GET",
			success: function(data){
				// jQuery(".message").html ( "<p>Successfully sent the message to dealer!</p>" );
			}			
		});
		// return false;
	});

	// jQuery(".container .type-post").css("back")
	/*
	*	checks whether is_single deal of not
	*	when is it no single deal, mouseover change background color
	*	0000060, 
	*
	*
	*/
	if ( is_single ) {

	} else {
		jQuery(".container .type-post").css("cursor", "pointer");
		jQuery(".container .type-post").live("mouseover", function(){
			 jQuery(this).addClass('colorchange');
		});
		
		jQuery(".container .type-post").live("onmouseover", function(){
			 jQuery(this).addClass('colorchange');
		});

		jQuery(".container .type-post").live("mouseout", function(){
			 jQuery(this).removeClass('colorchange');
		});

		jQuery(".container .type-post").live("onmouseout", function(){
			 jQuery(this).removeClass('colorchange');
		});
		jQuery(".container .type-post").live("click", function(){
			window.location.href = jQuery(this).find("a[rel=bookmark]").attr("href");
		});

	}

});