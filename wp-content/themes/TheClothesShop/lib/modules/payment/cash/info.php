<?php
$pgateway_be_info 		= __('Payment on Location','wpShop');
$pgateway_be_short_label= 'P: '.__('Cash on Location','wpShop');
$pgateway_short_label	= __('Payment at our Shop','wpShop');
$pgateway_icon_file		= 'col.png';
$pgateway_step2_label	= $OPTION['wps_pol_label'];
$pgateway_step2_alt		= $OPTION['wps_pol_label'];
$pgateway_be_options 	= array(
							array(		"type" 	=> "fieldset_start",
										"class" =>"shop",
										"id" 	=>"sec_cashOnLocation_settings"),
							array( 		"name" 	=> __('Cash on Location','wpShop'),
										"type" 	=> "title"),										
							array(    	"type" 	=> "open"),
							array(  	"name" 	=> __('"Payment on Location" Label Text','wpShop'),
										"desc" 	=> __('This will be used for the label text of the "Payment on Location" Payment Option','wpShop'),
										"id" 	=> $CONFIG_WPS['shortname']."_pol_label",
										"type" 	=> "text",
										"std" 	=> "Payment on Location"),
							array(   	"type" => "close"),
							array(   	"type" => "close"),
							array(		"type" 	=> "fieldset_end"));