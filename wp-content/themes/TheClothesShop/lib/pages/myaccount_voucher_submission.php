<?php
   include dirname(__FILE__) . '/../../../../../wp-load.php';
?>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri() . '/css/jquery-ui-1.8.2.custom.css';?>" />
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri() . '/css/ui.jqgrid.css';?>" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri() . '/css/ui.multiselect.css';?>" />

<script src="<?php echo get_stylesheet_directory_uri() . '/js/jquery.js';?>" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri() . '/js/jquery-ui-1.8.2.custom.min.js';?>" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri() . '/js/jquery.layout.js';?>" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri() . '/js/grid.locale-en.js';?>" type="text/javascript"></script>
<script type="text/javascript">
   // jQuery.jgrid.no_legacy_api = true;
   // jQuery.jgrid.useJSON = true;
   //http://bramkaslp01/autos2day/wp-content/themes/TheClothesShop/ajax_form_posts.php?q=1&edit=true
</script>
<script src="<?php echo get_stylesheet_directory_uri() . '/js/jquery.jqGrid.min.js';?>" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri() . '/js/jquery.tablednd.js';?>" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri() . '/js/jquery.contextmenu.js';?>" type="text/javascript"></script>
<script src="<?php echo get_stylesheet_directory_uri() . '/js/ui.multiselect.js';?>" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_stylesheet_directory_uri() . '/style.css';?>" />

<style type="text/css">
/*.ui-jqgrid .ui-jqgrid-bdiv {
   overflow: hidden;
   min-height: 50px;
}
.ui-jqgrid tr.jqgrow td {
   padding: 0 0 0 6px;
}
.ui-jqgrid .ui-jqgrid-hdiv {
   overflow-x: hidden;
}
*/

.ui-jqgrid td input, .ui-jqgrid td select .ui-jqgrid td textarea {
   margin: 4px;
}
.ui-jqgrid .ui-jqgrid-bdiv {
   overflow: hidden;
}

</style>

<script type="text/javascript"> 
var gridkey = "voucherlisting";
jQuery().ready(function (){
   // jQuery(".narrow").attr("style","width:100%;");
   site_url = '<?php echo site_url();?>';
   url = '<?php echo get_protocol();?>' + NWS_template_directory_alt + '/ajax_get_vouchers.php';
   jQuery("#"+gridkey).jqGrid({
      	url: url + "?q=1",
   	datatype: "xml",
      xmlReader : { 
         root: "ObjectXml", 
         row: "Element", 
         page: "ObjectXml>page", 
         total: "ObjectXml>total", 
         records : "ObjectXml>records", 
         userData : 'userdata',
         repeatitems: false, 
         id: "ID" 
      },      
      	colNames:['ID','Email','Voucher','Dealer','Dealer Price', 'Date','Deal Date', 'Sold date','Status'],
      	colModel:[
      		{name:'id',index:'ID', width:40, xmlmap:"ID", align:"center",formatter:'showlink', formatoptions:{baseLinkUrl:site_url + '/', idName:'p'}},
            {name:'Email',index:'email', width:100, align:"center", xmlmap:"email"},     
            {name:'Voucher',index:'voucher', width:205, align:"center", sortable:false, xmlmap:"voucher"},     
            {name:'Dealer',index:'dealer', width:55, align:"center", sortable:false, xmlmap:"dealership_id"},     
            {name:'Dealer Price',index:'ad_price', width:85, align:"center", xmlmap:"Meta>ad_price", formatter:'currency', formatoptions:{decimalSeparator:".", thousandsSeparator: ",", decimalPlaces: 2, prefix: "$ "}},     
            {name:'Date',index:'date_sent', width:65, align:"center", xmlmap:"date_sent"},     
            {name:'Deal Date',index:'deal_date', width:75, align:"center", xmlmap:"Meta>deal-date"},     
            {name:'Date',index:'date_sold', width:65, align:"center", xmlmap:"date_sold"},     
            {name:'Status',index:'status', width:104, align:"left", xmlmap:"status",editable:true,
            formatter:'select', edittype:"select",editoptions: {value:"1:'';1:SOLD OUT"}}
      	],
      	rowNum:10,
      	rowList:[10,20,30],
      	pager: jQuery('#voucherpager'),
      	sortname: 'date_sent',
         multiselect: true,
         viewrecords: true,
         sortorder: "DESC",
         loadonce:false,
         caption:"List of Posts",
         height: "100%",
         editable: true,
         toolbar: [true,"top"],          
         autowidth: true,
         editurl: url + "&edit=true",
         shrinkToFit: true,
         loadComplete: function() {
         	jQuery("td[title='SOLD OUT']").each(function(){
         		jQuery(this).parent().addClass('not-editable-row');
         		jQuery(this).parent().find("input[type=checkbox]").attr('disabled', 'true');
         	});
         	var object = jQuery("#" + gridkey).jqGrid('getGridParam', 'userData');
         	// alert ( object.value );
         	// alert ( jQuery(request.responseXml ) );
         },
         gridComplete: function() {
            // jQuery(".ui-jqgrid-view, .ui-jqgrid-titlebar, .ui-jqgrid .ui-userdata, .ui-jqgrid .ui-jqgrid-hdiv, .ui-jqgrid-bdiv, #voucherpager").attr("style", "width:inherit;");//"width:100%;border: 1px solid;");//"width:inherit;");
            // jQuery(".ui-jqgrid").attr("style","width:105%;font-size: 100%;");
            // jQuery(".ui-jqgrid").attr("style","font-size:93%;");
            jQuery(".ui-jqgrid").find("table").each(function(){
               //jQuery(this).attr("style","");
            });
            // jQuery(".ui-jqgrid-view").attr("style", "width:inherit;");
            // jQuery(".ui-jqgrid .ui-userdata").attr("style", "width:inherit;");
            // jQuery(".ui-jqgrid .ui-jqgrid-hdiv").attr("style", "width:inherit;");
            
            // alert (jQuery(".ui-jqgrid").attr("style"));
         }
   });
   jQuery("#"+gridkey).jqGrid('navGrid',"#voucherpager",{edit:false,add:false,del:false,view:true},{reloadAfterSubmit:true});
   jQuery("#"+gridkey).navButtonAdd('#voucherpager', {
      caption:"Approve", /*buttonicon:"ui-icon-add",*/ 
      onClickButton: function(){ 
         var selectedRows = jQuery("#"+gridkey).jqGrid('getGridParam','selarrrow');
         if ( selectedRows != "") {
            $.ajax ({
               url: url + "?id="+selectedRows + "&action=approved"
            });
            jQuery("#"+gridkey).trigger("reloadGrid"); 
            jQuery("#"+gridkey).trigger("reloadGrid"); 
         } else {
            alert("Please Select Row!"); 
         }
   }, 
      position:"last"
   });
   // jQuery("#"+gridkey).navButtonAdd('#voucherpager', {
   //    caption:"Reject", buttonicon:"ui-icon-add", 
   //    onClickButton: function(){ 
   //       var selectedRows = jQuery("#"+gridkey).jqGrid('getGridParam','selarrrow');
   //       if ( selectedRows != "") {
   //          $.ajax ({
   //             url: url + "?id="+selectedRows + "&action=trash"
   //          });
   //          jQuery("#"+gridkey).trigger("reloadGrid");             
   //          jQuery("#"+gridkey).trigger("reloadGrid");             
   //       } else {
   //          alert("Please Select Row!"); 
   //       }
   // }, 
   //    position:"last"
   // });
   // jQuery("#"+gridkey).navButtonAdd('#voucherpager', {
   //    caption:"Reject", buttonicon:"ui-icon-add", 
   //    onClickButton: function(){ 
   //       var selectedRows = jQuery("#"+gridkey).jqGrid('getGridParam','selarrrow');
   //       if ( selectedRows != "") {
   //          $.ajax ({
   //             url: url + "?id="+selectedRows + "&action=trash"
   //          });
   //          jQuery("#"+gridkey).trigger("reloadGrid");             
   //       } else {
   //          alert("Please Select Row!"); 
   //       }
   // }, 
   //    position:"last"
   // });
});				
</script>
<?php
   echo '<table id="voucherlisting"></table>';
   echo '<div id="voucherpager"></div>';
?>