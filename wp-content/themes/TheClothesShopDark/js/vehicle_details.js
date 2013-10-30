jQuery(document).ready(function() {
	jQuery("#deal_submission").validate({

		rules: {
			accept_terms: {
				required: true
			},
			customerPaymentProfileId: {
				required: true
			},
			ad_color: {
				required: true
			},
			ad_price: {
				required: true,
				number : true
			},
			content: {
				required: true
			},
			upload_images_i0: {
				required: true
			},
			upload_images_i1: {
				required: true
			},
			upload_images_i2: {
				required: true
			},
			upload_images_i3: {
				required: true
			},
			upload_images_i4: {
				required: true
			},
			ad_miles : {
				required : true,
				digits : true
			}
		},
			
		messages: {
			ad_miles : {
				required : "Please enter the mileage!",
				digits : "Only numbers allowed!"
			},
			accept_terms: {
				required: "Please accept the terms of use."
			},
			customerPaymentProfileId: {
				required: "Please select a Payment method to continue."
			},
			ad_color: {
				required: "Please enter the color of the car."
			},
			ad_price: {
				required: "Please enter the price of the car.",
				number : "Only valid money format is allowed, ex: $10.00"
			},
			content: {
				required: "Please enter Description Max 500 Characters."
			},
			upload_images_i0: {
				required: "Please Upload Main image."
			},
			upload_images_i1: {
				required: "Please Upload Second image."
			},
			upload_images_i2: {
				required: "Please Upload Third image."
			},
			upload_images_i3: {
				required: "Please Upload Fourth image."
			},
			upload_images_i4: {
				required: "Please Upload Fifth image."
			}
		}

	});	
	jQuery('#textContent').bind('keyup', function() { 
		var charactersUsed = jQuery(this).val().length;
		var charremain = jQuery(this).attr("maxlength") - charactersUsed;
		jQuery(".charremain").html("Remaining characters: " + charremain + " (Max " + jQuery(this).attr("maxlength") + ")" );
	});
	jQuery(document).find("#nada_test").submit(function() {
		var url 	= "ajax_form_nada.php";
		url 		= url+"?vin="+jQuery("#vin_no").val()+"&z="+jQuery("#m").val()+"&m="+jQuery("#m").val()+"&o="+jQuery("#o").val()+"&s="+jQuery("#s").val();
		url			= url+"&sid="+Math.random();

		jQuery.ajax({
			type:"GET",
			url: url,
			success: function(data){
				PopulateValues ( data );
			}
		});
		return false;
	});
	jQuery("#kbbResponseTrim").change(function(){
		jQuery("[ref='"+jQuery("#kbbResponseTrim").val()+"']").attr("selected", "selected");
	});
	jQuery("#vin_go").click(function(){
		var subfolder = jQuery("#subfolder").val();
		var protocol = jQuery("#protocol").val();
		var zipcode = jQuery("#dealership_address_zipcode").val();
		var state = jQuery("#dealership_address_state").val();
		var operation = jQuery("#operation").val();
		var prev_sibling = jQuery(this).parent().prev();
		var vin_no = jQuery('#ad_vin');
		// alert ( protocol );
		checkVoucher(subfolder, protocol, zipcode, state, operation, vin_no, prev_sibling);		
	});

});

function checkVoucher(subfolder, protocol, zipcode, state, operation, vin_no, prev_sibling)
{	
	if ( jQuery(vin_no).val().length < 17 ) {
		jQuery("#txtHint").show();
		jQuery("#txtHint").text( "VIN should be 17 Characters!" );
		jQuery("#txtHint").attr("class", "success");
		return;
	} else {
		jQuery("#txtHint").hide();				
	}
	if ( jQuery(prev_sibling)) {
		miles = jQuery(prev_sibling).find("input").val();
	}
	if ( miles == "" || miles == "undefined") {
		jQuery("#txtHint").show();
		jQuery("#txtHint").text("Please enter the mileage");
		jQuery("#txtHint").attr("class", "success");
		jQuery(prev_sibling).find("input").focus();
		return;
	} else {
		jQuery("#milesshowHint").hide();
	}
	// var operation = '<?php echo get_option("autos2day_tradein_company");?>';
	jQuery(".modal").show();  				
	var url		= protocol + NWS_template_directory_alt +"/ajax_validate_duplicate_vin.php";
	url			= url+"?vin="+jQuery(vin_no).val()+"&sid="+Math.random();
	url			= encodeURI(url);
	var duplicate = 0;
	jQuery.ajax({
		type:"GET",
		url: url,
		success: function(data){
			var d_url = "";
			if ( jQuery(data).find("post_title").text() ) {
				d_url = jQuery(data).find("guid").text();
				d_id = jQuery(data).find("ID").text();
				jQuery(".modal").hide();
				jQuery("#txtHint").show();
				jQuery("#txtHint").text('');
				jQuery("#txtHint").append("Duplicate VIN. Refer: <a href=\"" + d_url + "\">" + d_id + "</a>");
				duplicate = 1;		
			} else {
				url			= protocol + NWS_template_directory_alt +"/ajax_form_" + operation + ".php";
				//alert ( url );
				//var vid 	= document.getElementById("vid").value;
										
				url	= url+"?vin="+jQuery(vin_no).val()+"&z="+zipcode+"&m="+miles+"&o="+operation+"&s="+state;	
				url	= url+"&sid="+Math.random();
				url	= encodeURI(url);
				jQuery.ajax({
					type:"GET",
					url: url,
					success: function(data){
						jQuery(".modal").hide();
						PopulateValues ( data );
						jQuery("#kbbResponse").show();
						jQuery("#ad_color").focus();			
					}
				});

			}
		}
	});
	// xmlhttp.onreadystatechange=stateRetrieveVin;
	// xmlhttp.open("GET",url,true);
	// xmlhttp.send(null);
}

function PopulateValues ( xml ) {
		var ad_pparty 	= "";//jQuery(xml).find("VicValues").find("Value").text();
		var ad_year 	= jQuery(xml).find("VicDescriptions").find("VIC_Year").text();
		var ad_make 	= jQuery(xml).find("VicDescriptions").find("Make").text();
		var ad_model 	= jQuery(xml).find("VicDescriptions").find("Model").text();
		jQuery("#ad_pparty").html('');
		// var ad_trim = jQuery(xml).find("VicDescriptions").find("BodyStyle").text();
		jQuery("#kbbResponseTrim").html('');
		jQuery("#kbbResponseYear").html('');
		jQuery("#kbbResponseMake").html('');
		jQuery("#kbbResponseModel").html('');
		jQuery("#ad_Engine").html('');
		jQuery(xml).find("VicDescriptions").find("Bodystyle").each(function(){
			jQuery("#kbbResponseTrim").append("<option value=\""+jQuery(this).text()+"\">"+jQuery(this).text()+"</option>");
			jQuery("#ad_pparty").append("<option ref=\""+ jQuery(this).text() +"\" value=\""+jQuery(this).parent().find("CleanTradeIn").text()+"\">"+jQuery(this).parent().find("CleanTradeIn").text()+"</option>");
		});

		var ad_engine = jQuery(xml).find("VicDescriptions").find("Series").text();
		jQuery("#ad_Engine").append("<option value=\""+ad_engine+"\">"+ad_engine+"</option>");

		jQuery("#kbbResponseYear").val(ad_year);
		jQuery("#kbbResponseMake").val(ad_make);
		jQuery("#kbbResponseModel").val(ad_model);

		// jQuery("#kbbResponseTrim").val(ad_trim);
		jQuery("#kbbResponsePrivatParty").val(ad_pparty);

		jQuery(xml).find("VacValues").find("Element").each(function(){
			var VacValues = jQuery(this);
			if ( jQuery(VacValues).find("IncludedVAC").parent().find("Accessory") ) {
				var Accessory = jQuery(VacValues).find("IncludedVAC").parent().find("Accessory").text();
				jQuery("#IncludedVac").append("<option value=\""+Accessory+"\">"+Accessory+"</option>");
				jQuery("#description").innerHTML += Accessory + " ";
			} else {
				var Accessory = jQuery(VacValues).find("Accessory").text();
				jQuery("#Options").append("<option value=\""+Accessory+"\">"+Accessory+"</option>");
			}
		});		
}