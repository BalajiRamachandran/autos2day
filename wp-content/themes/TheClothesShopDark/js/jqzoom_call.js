jQuery(function ($) {

/*jQzoom*/
	var options = {
	    zoomWidth: 549,
	    zoomHeight: 250,
        xOffset: 36,
        yOffset: -10,
        position: 'right',
		showEffect: 'fadein',
		hideEffect:'fadeout',
		fadeinSpeed:'slow',
		fadeoutSpeed:'slow'
	};
	
	$('#singleMainContent .jqZoom').jqzoom(options);


});