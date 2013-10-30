jQuery(function ($) {
	// $.ajaxSetup forces the browser NOT to cache AJAX calls.
	$.ajaxSetup ({  
		cache: false  
	});
	
/* jQuery Tools - Overlay */
	$("#header a.quickLogin, #footnotes a[rel], #singleMainContent .shipping_info a, #singleMainContent .add_to_wishlist_inactive a, #floatswrap .order_table a[rel], #step2form a[rel], .modal").each(function(i) {
			
		$(this).overlay({
			mask: '#000'
		});			
	});
	
	// load external content
	$("#header a.extLoadTrigger").overlay({
		
		mask: '#000',
		
		onBeforeLoad: function() { 
			
			// let the user know that something is about to load 
			var ajax_load = "<img class='loadingImg' src='"+ NWS_template_directory +"/images/ajax-loader.gif' alt='loading...' />";
            // grab wrapper element inside content 
            var wrap = this.getOverlay().find("div.extLoadWrap"); 
			// get the page specified in the trigger and a specific element from inside it 
			//var toLoad = $(this.getTrigger()).attr('href')+' .page_post';
			var toLoad = $(this.getTrigger()).attr('href')+' .container .whereAmI + div';
            // load it! 
			wrap.html(ajax_load).load(toLoad); 
        }
	});
	
	// load external content (single product page)
	$("#singleMainContent .sizing_info a").overlay({
		mask: '#000',
		
		onBeforeLoad: function() { 
			
			// let the user know that something is about to load 
			var ajax_load = "<img class='loadingImg' src='"+ NWS_template_directory +"/images/ajax-loader.gif' alt='loading...' />";
            // grab wrapper element inside content 
            var wrap = this.getOverlay().find("div.sizeChartWrap"); 
			// get the page specified in the trigger and a specific element from inside it 
			var toLoad = $(this.getTrigger()).attr('href')+' .page_post';
            // load it! 
			wrap.html(ajax_load).load(toLoad); 
        }
	});	
	
	// load external content (shopping basket)
	$("#floatswrap  #customCartLink").overlay({
		mask: '#000',
		
		onBeforeLoad: function() { 
			
			// let the user know that something is about to load 
			var ajax_load = "<img class='loadingImg' src='"+ NWS_template_directory +"/images/ajax-loader.gif' alt='loading...' />";
            // grab wrapper element inside content 
            var wrap = this.getOverlay().find("div.customCartInfoWrap"); 
			// get the page specified in the trigger and a specific element from inside it 
			var toLoad = $(this.getTrigger()).attr('href')+' .page_post';
            // load it! 
			wrap.html(ajax_load).load(toLoad); 
        }
	});
	
	// order review and editing
	$("#floatswrap h4.step3 a.step3_edit").overlay({
		mask: '#000',
		
		onBeforeLoad: function() { 
			
			// let the user know that something is about to load 
			var ajax_load = "<img class='loadingImg' src='"+ NWS_template_directory +"/images/ajax-loader.gif' alt='loading...' />";
            // grab wrapper element inside content 
            var wrap = this.getOverlay().find("div.editOrderWrap"); 
			// get the page specified in the trigger and a specific element from inside it 
			var Link = $(this.getTrigger()).attr('href');
			//separate the # to get the class
			var urlParts 	= Link.split("#");			
			var baseUrl		= urlParts[0];
			var Id 			= urlParts[1];
			
			//set the form action based on the Id
			var Action 	= null;
		
			
			if ((Id == 'editDelivery') || (Id == 'editPayment')) {
			
				var Action 			= '?orderNow=3&amp;dpchange=1';
				var anotherField	= '';
			}
			else if ((Id == 'editAddress') || (Id == 'editNote')) {
				var Action 			= '?orderNow=2';
				var anotherField	= "<br/><input type='checkbox' name='terms_accepted' value='on' checked='checked'/><a href='?showTerms=1' target='_blank'>I accept the Terms &amp; Conditions</a><br/><input type='hidden' name='step2' value='1' /><br/>";
			}
			else {
				var Action 			= '?showCart=1';
				var anotherField	= '';
			}
			
			//put it together
			var toLoad = baseUrl +' #' + Id;
			//alert(toLoad);
		
			// load it! 
			wrap.html(ajax_load).load(toLoad, function() {
				$('#editOrderOverlay .editOrderWrap .editCont').append('<input type="hidden" name="saveWhat" value="'+Id+'" />'+anotherField+'<input type="submit" value="Save" name="saveEdit" class="formbutton saveEdit" />').wrap('<form method="post" action="'+Action+'"></form>'); 
			});
			
		}
	});

/* Multiple Product Pages - Image Hover */
	$('.contentWrap').hover(function(){
		var $goleft = $(this).find('.hover_link');
		$goleft.stop().animate({left:-$goleft.outerWidth()},{queue:false,duration:500});
	}, function(){
		var $goleft = $(this).find('.hover_link');
		$goleft.stop().animate({left:'0'},{queue:false,duration:500});
	});

/* Single Product Page - Related Tabs */
	$("#singleMainContent .related .tabs").tabs("div.panes > div", { event:'mouseover' });
/* Single Product Page - when videos are embedded (image/video tab) */
	$("#singleMainContent .imgtabs").tabs("div.mediaPanes > .theProdMedia");
/* Single Product Page - when videos are embedded and multible images are used (inner tabs) */
	$("#singleMainContent .innerProdMedia .innerTabs").tabs("div.inner_mediaPanes > .theInner_ProdMedia", { event:'mouseover' });
/* Single Product Page - when multible images are used (with lightbox effect or no effect) */
	$("#singleMainContent .tabs_alt").tabs("div.mediaPanes_alt > .theProdMedia_alt", { event:'mouseover' });
	
/*return false when no effect is used!*/
	$("#singleMainContent .no_effect").click(function(){
		return false;
	});

	
/* jQuery Tools - ToolTip */
	$("#header li.wishlist a[title], #trackingform img[title], .wishList_table a[title], #floatswrap .c_box_p label[title]").each(function(i) {
			
		$(this).tooltip({ 
 
			// use div.tooltip as our tooltip 
			//tip: '#tooltip', 
	 
			// use fade effect instead of the default 
			//effect: 'fade', 
	 
			// make fadeOutSpeed similar to browser's default 
			fadeOutSpeed: 2000, 
	 
			// the time before tooltip is shown 
			predelay: 0, 
	 
			// tweak the position 
			position: "bottom center"         
			 
		});		
	});
	
	
	
/* Single Product Page - Adjacent Products */
	$('.adjacentProd').hover(function(){
		var $showME = $(this).find('.adjacentImg');
		$showME.stop(false,true).fadeIn("slow");
	}, function(){
		var $showME = $(this).find('.adjacentImg');
		$showME.stop(false,true).fadeOut("slow");
	});
	
/* Single Product Page - Main Product Image Tabs Add current class  */
	$("#singleMainContent .tabs li:first-child .thumbTab").addClass('current');
	$("#singleMainContent .tabs .thumbTab").mouseover(function() {
		$(this).addClass('current').parent().siblings().children().removeClass('current');
	});
	
/*Comment Trackbacks*/
	$("ol.trackback").hide();
		$("a.show_trackbacks").click(function(){
			$("ol.trackback").slideToggle('fast');
			return false;
		});
		
/*DROP DOWN NAVI*/
	function mainmenu(){
		if(!$.browser.msie){// IE  - 2nd level Fix
		$(" #header .MainCatsNav ul ul ").css({opacity:"0.95"});
		}
		$("#header .MainCatsNav ul a").removeAttr('title');
		$("#header .MainCatsNav ul ul").css({display: "none"}); // Opera Fix
		
		$(" #header .MainCatsNav ul li").hover(function(){
			$(this).find('ul:first:hidden').slideDown("slow");
		},function(){
			$(this).find('ul:first').slideUp();
		});
	}
	
	mainmenu();
	
	/*Form Validation*/	
	$("#signInForm, #quickLoginForm, #editEmail, #editPassword, #get_voucher, #promotion").each(function(i) {
		$(this).validate({
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
				namex : {
					required : true
				},
				phone_no : {
					required : true,
					minlength: 10,
					maxlength : 10
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
				namex : {
					required : "Please enter your name"
				},
				phone_no : {
					required : "Please enter your Phone no",
					minlength: "Enter a valid phone no!"
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
				}

			}
		});			
	});
	
/* Recent Prods slider */
	
	if ($(".prods_scrollable").length != 0) {		
		$('.prods_scrollable').scrollable({mousewheel: true});
	}
});	

		


$(window).load(function(){

/* EQUAL HEIGHTS (fire this when everything has loaded for correct height calculation) */
	$.fn.equalHeights = function() {
		var maxheight = 0;
		$(this).children().each(function(){
			maxheight = ($(this).height() > maxheight) ? $(this).height() : maxheight;
		});
		$(this).children().css('height', maxheight);
	}
	$('#floatswrap .eqcol').equalHeights();

});

/* FONT REPLACEMENT */
Cufon.replace('.featured .hover_block  .subcatnavi a, .featured .hover_block  .mainCatTitle, .theCats .hover_link, .theCats .static_link', {
hover: true
});