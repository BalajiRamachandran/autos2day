<?php
/*
*  Update Dealer Details
*
*
*
*/
require dirname(__FILE__) . '/../../../../../wp-load.php';
// get_header();
?>
<script type="text/javascript">
	var is_single;
	var stylesheet_directory = "<?php echo get_bloginfo('stylesheet_directory');?>";
</script>

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
..ui-paging-info {
   color: black;
}
.ui-jqgrid td input, .ui-jqgrid td select .ui-jqgrid td textarea {
   margin: 4px;
}
.ui-jqgrid .ui-jqgrid-bdiv {
   overflow: hidden;
}
.ui-jqgrid .ui-pg-input {
	height: inherit;
}
.ui-jqgrid .ui-pg-table td {
	color: black;
}

</style>

<script type="text/javascript"> 
   jQuery(document).ready(function(){
      url = stylesheet_directory + '/lib/pages/update_dealer_email.php';
      url_save = stylesheet_directory + '/lib/pages/save_dealer_email.php';
      jQuery("input[rel*='date']").each(function(){
            jQuery(this).datepicker( { currentText: "Now", dateFormat: "yy-mm-dd", minDate: -90, maxDate: 0 } );
      });
      display_grid ( url_save, url  );
   });


   function display_grid ( url_save, url, param ) {
   	var lastsel;

     jQuery(".narrow").attr("style","width:100%;");
      site_url = '<?php echo site_url();?>';
      if ( (param == 'undefined') || (param = '') ) {
         param = "&none=none";
      }
      jQuery("#user_dealer_listing").jqGrid({
         url: url,
         datatype: "xml",
         xmlReader : { 
            root: "Users", 
            row: "user", 
            page: "Users>page", 
            total: "Users>total", 
            records : "Users>records", 
            userdata : "userdata",
            repeatitems: false, 
            id: "ID" 
         },      
            colNames:[
               'User ID',
               'Dealership<br/>ID', 
               'Dealership Name', 
               'Email',
               'Email 1',
               'Email 2',
               'Email 3',
               'Email 4'],
            colModel:[
               {name:'id',index:'ID', width:30, xmlmap:"ID", align:"center", xmlmap:"ID", sorttype: "int"},
               {name:'Dealership ID',index:'dealership_id', width:45, align:"center", search: false, xmlmap:"meta>dealership_id", sorttype: "string"},
               {name:'Dealership Name',index:'dealership_name', width:90, align:"center", search: false, xmlmap:"meta>dealership_name", sorttype: "string"},     
               {name:'Email',index:'user_email', width:100, align:"center", sortable:false, xmlmap:"user_email", sorttype: "string"},     
               {name:'Email 1',index:'email1', width:100, align:"center", sortable:false, search: false, editable: true, xmlmap:"meta>email1", sorttype: "string"},     
               {name:'Email 2',index:'email2', width:100, align:"center", sortable:false, search: false, editable: true, xmlmap:"meta>email2", sorttype: "string"},     
               {name:'Email 3',index:'email3', width:100, align:"center", sortable:false, search: false, editable: true, xmlmap:"meta>email3", sorttype: "string"},     
               {name:'Email 4',index:'email4', width:100, align:"center", sortable:false, search: false, editable: true, xmlmap:"meta>email4", sorttype: "string"}     
            ],
            rowNum:10,
            rowList:[10, 50,100,150,200],
            pager: jQuery('#user_dealer_pager'),
            sortname: 'ID',
            multiselect: true,
            viewrecords: true,
            sortorder: "DESC",
            loadonce:false,
            caption:"Dealer Lists",
            height: "100%",
            editable: true,
            toolbar: [true,"top"],          
            autowidth: true,
            shrinkToFit: true,
            recordpos: 'right',
            beforeRequest: function () {
            },
            gridComplete: function() {
               jQuery(".ui-jqgrid").find("table").each(function(){
               });
               jQuery(".ui-jqgrid-bdiv").css("height", "auto");
            },
			onSelectRow: function(id){
				if(id && id!==lastsel){
					jQuery('#user_dealer_listing').jqGrid('restoreRow',lastsel);
					jQuery('#user_dealer_listing').jqGrid('editRow',id,true);
					lastsel=id;
				}
			},            
            // afterComplete : function (response, postdata, formid) {
			editurl: url_save + "?q=1"
            //    alert ( postdata);
            //    alert ( response);
            //    alert ( formid );
            // }
      });
      jQuery("#user_dealer_listing").jqGrid('navGrid',"#user_dealer_pager",{edit:false,add:false,del:false,view:true});//,{},{},{}, {});
      // jQuery("#deallisting").jqGrid('navGrid',"#listingpager",{edit:false,add:false,del:false,view:true},{},{},{}, {multipleSearch:true, multipleGroup:true});
   }

</script>
<?php   
   // echo '<form name="exportData" id="exportData" action="">' . "\r\n";
   // echo '  <table>' . "\r\n";
   // echo '    <tr>' . "\r\n";
   // echo '      <td>StartDate</td>' . "\r\n";
   // echo '      <td>' . "\r\n";
   // echo '        <input type="text" rel="date" id="startDate" required/>' . "\r\n";
   // echo '      </td>' . "\r\n";
   // echo '      <td>EndDate</td>' . "\r\n";
   // echo '      <td>' . "\r\n";
   // echo '        <input type="text" rel="date" id="endDate" required/>' . "\r\n";
   // echo '      </td>' . "\r\n";
   // echo '      <td>' . "\r\n";
   // echo '        <input type="submit" value="GO" />' . "\r\n";
   // echo '      </td>' . "\r\n";
   // echo '    </tr>' . "\r\n";
   // echo '  </table>' . "\r\n";
   // echo '</form>' . "\r\n";

   echo '<table id="user_dealer_listing"></table>';
   echo '<div id="user_dealer_pager"></div>';
?>