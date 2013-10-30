/*############### Admin Tabs ######################*/	
/*
var $j = jQuery.noConflict();

$j(function(){

	$j("#themeOptionsTabs").tabs("#panesWrap > div.pane");
	$j("#AppearanceSubNavi").tabs("div.pane2");	
	$j("#ShopSubNavi").tabs("div.pane3");
	$j("#GoogleSubNavi").tabs("div.pane4");
	$j("#manageOrdersTabs").tabs("#manageOrdersPanels > div.pane");
	$j("#manageInquiriesTabs").tabs("#manageInquiriesPanels > div.pane");
	
});
*/

jQuery(function(){

	jQuery(".nws_admin_settings h2").wrapInner("<a class='show_hasadmintabs' href='#'></a>");

	jQuery(".nws_admin_settings div.hasadmintabs").hide();
	jQuery("a.show_hasadmintabs").click(function(){
		jQuery(this).parent('h2').toggleClass('open').next("div.hasadmintabs").slideToggle('fast');
		return false;
	});

	nws_tabulator_init();
	jQuery(".nws_manage_orders .tabs a[href='#pending']").addClass("pending_order");
	
	jQuery("#nws_inv_wrap .nws_inv_prod_ID").addClass('inv_closed').wrapInner("<a class='show_nws_inv_details' href='#'></a>");
	jQuery("#nws_inv_wrap div.nws_inv_details").hide();
	jQuery("#nws_inv_wrap .nws_inv_prod_ID a").click(function(){
		jQuery(this).parent('h4').toggleClass('inv_open').nextAll("div.nws_inv_details").slideToggle('fast');
		return false;
	});
	
});

function nws_tabulator_init(){
	/* if this is not the NWS admin page, quit */
	if (!jQuery(".hasadmintabs").length) return;		
	/* init markup for tabs */
	jQuery('.hasadmintabs1').prepend("<ul class='tabs'><\/ul>");
	jQuery('.hasadmintabs1 > fieldset').each(function(i){
		id      = jQuery(this).attr('id');
		caption = jQuery(this).find('h3:first').text();
		jQuery('.hasadmintabs1 > ul').append('<li><a href="#'+id+'"><span>'+caption+"<\/span><\/a><\/li>");
		//jQuery(this).find('h3').hide();					    
	});	
	/* init markup for tabs */
	jQuery('.hasadmintabs2').prepend("<ul class='tabs'><\/ul>");
	jQuery('.hasadmintabs2 > fieldset').each(function(i){
		id      = jQuery(this).attr('id');
		caption = jQuery(this).find('h3:first').text();
		jQuery('.hasadmintabs2 > ul').append('<li><a href="#'+id+'"><span>'+caption+"<\/span><\/a><\/li>");
		//jQuery(this).find('h3').hide();					    
	});	
	/* init markup for tabs */
	jQuery('.hasadmintabs3').prepend("<ul class='tabs'><\/ul>");
	jQuery('.hasadmintabs3 > fieldset').each(function(i){
		id      = jQuery(this).attr('id');
		caption = jQuery(this).find('h3:first').text();
		jQuery('.hasadmintabs3 > ul').append('<li><a href="#'+id+'"><span>'+caption+"<\/span><\/a><\/li>");
		//jQuery(this).find('h3').hide();					    
	});	
	/* init markup for tabs */
	jQuery('.hasadmintabs4').prepend("<ul class='tabs'><\/ul>");
	jQuery('.hasadmintabs4 > fieldset').each(function(i){
		id      = jQuery(this).attr('id');
		caption = jQuery(this).find('h3:first').text();
		jQuery('.hasadmintabs4 > ul').append('<li><a href="#'+id+'"><span>'+caption+"<\/span><\/a><\/li>");
		//jQuery(this).find('h3').hide();					    
	});	
	/* init markup for tabs */
	jQuery('.hasadmintabs5').prepend("<ul class='tabs'><\/ul>");
	jQuery('.hasadmintabs5 > fieldset').each(function(i){
		id      = jQuery(this).attr('id');
		caption = jQuery(this).find('h3:first').text();
		jQuery('.hasadmintabs5 > ul').append('<li><a href="#'+id+'"><span>'+caption+"<\/span><\/a><\/li>");
		//jQuery(this).find('h3').hide();					    
	});	
	/* init the tabs plugin */
	var jquiver = undefined == jQuery.ui ? [0,0,0] : undefined == jQuery.ui.version ? [0,1,0] : jQuery.ui.version.split('.');
	switch(true){
		// tabs plugin has been fixed to work on the parent element again.
		case jquiver[0] >= 1 && jquiver[1] >= 7:
			jQuery(".hasadmintabs").tabs();
			break;
		// tabs plugin has bug and needs to work on ul directly.
		default:
			jQuery(".hasadmintabs > ul").tabs(); 
	}
	/* handler for opening the last tab after submit (compability version) */
	jQuery('.hasadmintabs ul a').click(function(i){
		var form   = jQuery('.nws_admin_options');
		var action = form.attr("action").split('#', 1) + jQuery(this).attr('href');
		// an older bug pops up with some jQuery version(s), which makes it
		// necessary to set the form's action attribute by standard javascript 
		// node access:						
		form.get(0).setAttribute("action", action);
	});
}