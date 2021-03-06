<?php
##################################################################################################################################
// 												THEME - ADMIN - OPTIONS
##################################################################################################################################
if(!function_exists('get_currentuserinfo')){exit();}

function get_all_themes(){

	global $OPTION;

	if(is_admin()){
		$result = array();
		
		$path 	= '../wp-content/themes';
		
		if($handle = opendir($path)){
			while (false !== ($file = readdir($handle))){
			
				if($file != '.' && $file != '..' && $file != 'classic' && $file != 'default' && $file != 'index.php' && $file != WPSHOP_THEME_NAME){
					$result[] = "$file";
				}	
			}
			closedir($handle);
		}
		return $result;
	}
}

load_theme_textdomain('wpShop', get_template_directory().'/languages/');
$countries 	= get_countries();
$zone1		= get_countries(2,$OPTION['wps_shop_country']);
$masterpath	= find_masterdata_path(1);

// depending on installation status user sees different things in backend
installation_status_change();
$install_status = installation_status();

if($install_status < 8){
	$useSection		= 1;
}
else {
	update_the_theme_if_necessary(); 
	$useSection		= 1; // for possible later changes
}
// get categories
$categories 	= get_categories('hide_empty=0&orderby=name');
$nws_wp_cats 	= array();
foreach ($categories as $category_list ) {
    $nws_wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}
array_unshift($nws_wp_cats, "Select a Category"); 

//get pages
$pages = get_pages('parent=0&sort_column=post_title');
$nws_wp_pages = array();
foreach ($pages as $pages_list ) {
    $nws_wp_pages[$pages_list->ID] = $pages_list->post_title;
}
array_unshift($nws_wp_pages, "Select a Page"); 

$options   = array (

/***
Design Settings
***/
				
array ( 	"name" 	=> __('Design','wpShop'),
			"type" 	=> "heading",
			"class" =>"design"),
					
	array (		"type" 	=> "section_start",
				"class" =>"hasadmintabs hasadmintabs1"),
//###############################################################################################################
		// Tab 1 General				
		array (		"type" 	=> "fieldset_start",
					"class" =>"design",
					"id" 	=>"sec_generalDesign_settings"),

			array ( 	"name" 	=> __('General','wpShop'),
						"type" 	=> "title"),

				array(    	"type" 	=> "open"),

							//removed option 'choose child theme'
								
					array(  	"name" 	=> __('Activate the Shopping Cart?','wpShop'),
								"desc" 	=> __('Check this setting if you want to use the NWS Shopping Cart','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shoppingCartEngine_yes",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Activate the Customer Membership Area?','wpShop'),
								"desc" 	=> __('Check this setting if you want to enable the Customer Area for Registered Users of your Shop.','wpShop')."<br/><b>".__('Note: Registered Users are independent to the WordPress Users and can me managed under the "Members" main link above','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_lrw_yes",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(    	"name" 	=> __('Blog Category','wpShop'),
								"desc" 	=> __('If you want to maintain a blog along with your Shop then please select the Main Category you have already created for your blog','wpShop')."<br/><b>".__('Your blog category will only appear in the drop down after you have ','wpShop')."<a href='".get_option('siteurl')."/wp-admin/categories.php'>".__('created it.','wpShop')."</a></b><br/><b>".__('To create/use Blog Subcategories: If you want to categorize your Regular Blog Posts you should create subcategories under the Main Category that you have identified above.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_blogCat",
								"type" 	=> "select",
								"vals" 	=> $nws_wp_cats,
								"std" 	=> "Select a category"), 
					
					array(  	"name" 	=> __('Use Tags on Regular Blog Posts?','wpShop'),
								"desc" 	=> __('Since Tags are not (at the time of creating this theme) hierarchical you can only use them for your Shop Product Posts or for your Regular Blog Posts not both! Only check this setting if you plan to use them for your Regular Blog Posts.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogTags_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(    	"name" 	=> __('Customer Service page','wpShop'),
								"desc" 	=> __('Please select the page you created for your "Customer Service" page.','wpShop')."<br/><b>".__('Note: Remember to use the "Customer Service" template for this page!','wpShop')."</b><br/><b>".__('The page will only appear in the drop down after you have ','wpShop')."<a href='".get_option('siteurl')."/wp-admin/page-new.php'>".__('created it.','wpShop')."</a></b>",
								"id" 	=> $CONFIG_WPS['shortname']."_customerServicePg",
								"type" 	=> "select",
								"vals" 	=> $nws_wp_pages,
								"std" 	=> "Select a Page"),
					
					array(    	"name" 	=> __('About page','wpShop'),
								"desc" 	=> __('In order to use the independent widget ready area for the "About" page sidebar then select the page you created and that will serve as your "About".','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_aboutPg",
								"type" 	=> "select",
								"vals" 	=> $nws_wp_pages,
								"std" 	=> "Select a Page"),
					
					array(    	"name" 	=> __('Contact page','wpShop'),
								"desc" 	=> __('In order to use the independent widget ready area for the "Contact" page sidebar then select the page you created and that will serve as your "Contact".','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_contactPg",
								"type" 	=> "select",
								"vals" 	=> $nws_wp_pages,
								"std" 	=> "Select a Page"),
					
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),
			
			// Featured Area
			array( 		"name" 	=> __('Your Front Page Featured Section','wpShop'),
						"type" 	=> "title"),
									
				array(    	"type" 	=> "open"),

					array(  	"name" 	=> __('Featured Content','wpShop'),
								"desc" 	=> __('Select the type of featured content for the Front Page Featured Area.','wpShop')."<br/><b>".__('Please Note: Each Option can be further customized using the settings further down this page.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_featuredType",
								"type" 	=> "select2",
								"std" 	=> "Categories",
								"vals" 	=> array(__('Main Categories','wpShop')."|featured_cats",__('Main Categories and Pages','wpShop')."|featured_cats_and_pages",__('Main Categories on either side and Pages in the Middle','wpShop')."|featured_cats_pages_cats",__('Pages','wpShop')."|featured_pages")),
								
					array(  	"name" 	=> __('Remove Featured Category / Page Title?','wpShop'),
								"desc" 	=> __('Check this setting if you want to remove the Featured Category or Page Title from displaying below each featured image','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_featTitle_remove",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
					
					array(  	"name" 	=> __('Main Category Specific Images - File Type','wpShop'),
								"desc" 	=> __('Select the file type you are using for your Main Category specific images that display on the Front Page Featured Area.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_catimg_file_type",
								"type" 	=> "select2",
								"std" 	=> "jpg",
								"vals" 	=> array("jpg|jpg","png|png","gif|gif")),
					
					array(  	"name" 	=> __('Your Main Categories (1st Level) - Order by','wpShop'),
								"desc" 	=> __('All available options are in the drop down','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_mainCat_orderbyOption",
								"type" 	=> "select2",
								"std" 	=> "Sort by ID",
								"vals" 	=> array(__('Sort categories by name','wpShop')."|name",__('Sort by ID','wpShop')."|ID",__('Sort by slug','wpShop')."|slug","Sort by count|count")),

					array(    	"name" 	=> __('Your Main Categories (1st Level) - Order','wpShop'),
								"desc" 	=> __('All available options are in the drop down','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_mainCat_orderOption",
								"type" 	=> "select2",
								"std" 	=> "Ascending",
								"vals" 	=> array(__('Ascending','wpShop')."|ASC",__('Descending','wpShop')."|DESC")),
										
					array(    	"name" 	=> __('Exclude Main Categories','wpShop'),
								"desc" 	=> __('There may be cases when you need to exclude certain Main Categories from showing in the Featured Area. Here you can specify the Main Category IDs to be excluded. Comma seperate multiple IDs.','wpShop')."<br/><b>".__('Please note that this setting will exclude them only from the Featured Area!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_mainCat_excl",
								"std" 	=> "",
								"type" 	=> "text"),
								
					array(    	"name" 	=> __('Main Categories - Include Left','wpShop'),
								"desc" 	=> __('If you have selected to feature "Main Categories on either side and Pages in the Middle", specify the Main Category IDs to be included to the left of your featured Pages. Comma seperate multiple IDs.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_mainCat_incl_left",
								"std" 	=> "",
								"type" 	=> "text"),
								
					array(    	"name" 	=> __('Main Categories - Include Right','wpShop'),
								"desc" 	=> __('If you have selected to feature "Main Categories on either side and Pages in the Middle", specify the Main Category IDs to be included to the right of your featured Pages. Comma seperate multiple IDs.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_mainCat_incl_right",
								"std" 	=> "",
								"type" 	=> "text"),
								
					array(  	"name" 	=> __('Do NOT Display Subcategories','wpShop'),
								"desc" 	=> __('By default if a Main Category contains Subcategories these will be collected and displayed behind the Main Category Specific Image. Check this setting if you do not want to display the Subcategories.','wpShop')."<br/><b>".__('Please remember to prepare an alternative image to display instead. It will need to be named after the Main Category slug and with the suffix "_alt" eg some-slug_alt.jpg','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_secondaryCat_remove",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(    	"name" 	=> __('Exclude Subcategories','wpShop'),
								"desc" 	=> __('There may be cases when you need to exclude certain Subcategories from showing behind the Main Category Images on the Front Page. Here you can specify the Subcategory IDs to be excluded. Comma seperate multiple IDs.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_secondaryCat_excl",
								"std" 	=> "",
								"type" 	=> "text"),
										
					array(  	"name" 	=> __('Divide Subcategories into columns?','wpShop'),
								"desc" 	=> __('Check this option if you wish to divide your Subcategories behind the Main Category Images on the Front Page into more than one column.','wpShop')."<br/><b>".__('Note: Ideal for a large number of subcategories','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_secondaryCat_col_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(    	"name" 	=> __('Number of rows?','wpShop'),
								"desc" 	=> __('Enter the number of rows these subcategories should be displayed in.','wpShop')."<br/><b>".__('Note: Number of rows not columns!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_secondaryCat_rows",
								"std" 	=> "",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Your Featured Pages (1st Level)- Include','wpShop'),
								"desc" 	=> __('If you have selected to include pages in your Featured Section, please specify the Main Level Page IDs to be included. Comma seperate multiple IDs.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_featPg_inclOption",
								"std" 	=> "",
								"type" 	=> "text"),
										
					array(  	"name" 	=> __('Your Featured Pages (1st Level) - Order by','wpShop'),
								"desc" 	=> __('All available options are in the drop down','wpShop')."<br/><b>".__('Please Note: This applies if you have selected to include pages in your Featured Section','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_featPg_orderbyOption",
								"type" 	=> "select2",
								"std" 	=> "Sort by ID",
								"vals" 	=> array(__('Sort Pages by Page Order','wpShop')."|menu_order",__('Sort by numeric Page ID','wpShop')."|id",__('Sort Pages alphabetically by title','wpShop')."|post_title",__('Sort by creation time','wpShop')."|post_date",__('Sort alphabetically by Post slug','wpShop')."|post_name")),

					array(    	"name" 	=> __('Your Featured Pages (1st Level) - Order','wpShop'),
								"desc" 	=> __('All available options are in the drop down','wpShop')."<br/><b>".__('Please Note: This applies if you have selected to include pages in your Featured Section','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_featPg_orderOption",
								"type" 	=> "select2",
								"std" 	=> "Ascending",
								"vals" 	=> array(__('Ascending','wpShop')."|ASC",__('Descending','wpShop')."|DESC")),
								
					array(  	"name" 	=> __('Do NOT Display Subpages','wpShop'),
								"desc" 	=> __('By default if a Main Page contains Subpages these will be collected and displayed behind the Main Page Specific Image. Check this setting if you do not want to display the Subpages.','wpShop')."<br/><b>".__('Please remember to prepare an alternative image to display instead. It will need to be named after the Main Page slug and with the suffix "_alt" eg some-slug_alt.jpg','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_featchildPg_remove",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('Subpages (2nd Level) - Order by','wpShop'),
								"desc" 	=> __('If your Featured Pages have child pages these will display as a list of links behind the Page Specific Image. All available options are in the drop down','wpShop')."<br/><b>".__('Please Note: This applies if you have selected to include pages in your Featured Section','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_featchildPg_orderbyOption",
								"type" 	=> "select2",
								"std" 	=> "Sort by ID",
								"vals" 	=> array(__('Sort Pages by Page Order','wpShop')."|menu_order",__('Sort by numeric Page ID','wpShop')."|id",__('Sort Pages alphabetically by title','wpShop')."|post_title",__('Sort by creation time','wpShop')."|post_date",__('Sort alphabetically by Post slug','wpShop')."|post_name")),

					array(    	"name" 	=> __('Subpages (2nd Level) - Order','wpShop'),
								"desc" 	=> __('All available options are in the drop down','wpShop')."<br/><b>".__('Please Note: This applies if you have selected to include pages in your Featured Section','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_featchildPg_orderOption",
								"type" 	=> "select2",
								"std" 	=> "Ascending",
								"vals" 	=> array(__('Ascending','wpShop')."|ASC",__('Descending','wpShop')."|DESC")),
										
					array(    	"name" 	=> __('Exclude Subpages','wpShop'),
								"desc" 	=> __('There may be cases when you need to exclude certain Subpages from showing behind the Main Page Images on the Front Page. Here you can specify the Subpage IDs to be excluded. Comma seperate multiple IDs.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_featchildPg_excl",
								"std" 	=> "",
								"type" 	=> "text"),
										
					array(  	"name" => __('Featured Page-Specific Images - File Type','wpShop'),
								"desc" => __('Choose the file type of your Featured Page-Specific Images.','wpShop'),
								"id" => $CONFIG_WPS['shortname']."_pgimg_file_type",
								"type" => "select2",
								"std" => "jpg",
								"vals" => array("jpg|jpg","png|png","gif|gif")),
								
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),
			
			// Image effects
			array( 		"name" 	=> __('Image Effects','wpShop'),
						"type" 	=> "title"),
									
				array(    	"type" 	=> "open"),

					array(  	"name" 	=> __('Remove Slide effect on Front Page','wpShop'),
								"desc" 	=> __('Check this box if you wish to have static category specific images on the Front Page','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_staticImgs",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
					
					array(  	"name" 	=> __('Remove Slide effect on Main Category Pages','wpShop'),
								"desc" 	=> __('Check this box if you wish to have static category specific images on the Category Pages that display categories','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_staticImgsCats",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('Remove Slide effect on Multiple Product Pages (category, custom taxonomy pages)','wpShop'),
								"desc" 	=> __('Check this box if you wish to have static Product images on Category Pages that display Products','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_staticImgsProds",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),
			
			// Sidebar
			array( 		"name" 	=> __('Your Sidebar','wpShop'),
						"type" 	=> "title"),
									
				array(    	"type" 	=> "open"),

					array(  	"name" 	=> __('Sidebar Location Options','wpShop'),
								"desc" 	=> __('Select the position of your Sidebar.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_sidebar_option",
								"type" 	=> "select2",
								"std" 	=> "Align Right",
								"vals" 	=> array(__('Align Right','wpShop')."|alignRight",__('Align Left','wpShop')."|alignLeft")),
								
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),
			
			// Category specific Sidebars
			array( 		"name" 	=> __('Category Specific Widget Ready Sidebars','wpShop'),
						"type" 	=> "title"),
									
				array(    	"type" 	=> "open"),

					array(    	"name" 	=> __('Main Category(1) - Slug','wpShop'),
								"desc" 	=> __('Please enter the','wpShop')."<b>".__(' SLUG ','wpShop')."</b>".__('of each main (1st level) category you have created in the above and in the following input fields. Fill in one field for each and','wpShop')."<b>".__(' in the order they were created. ','wpShop')."</b>".__('This will mean that the main category with the','wpShop')."<b>".__(' lowest ID ','wpShop')."</b>".__('should be entered ','wpShop')."<b>".__(' first ','wpShop')."</b>".__('and the one with the ','wpShop')."<b>".__(' highest ID ','wpShop')."</b>".__('should be entered ','wpShop')."<b>".__(' last.','wpShop')."</b><br/>".__('Note: This is needed in order to use the Category Specific Widget Ready Sidebar for each main category as well as linking to the correct Size Chart when on the single product view (see the Shop settings for this)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_mainCat1",
								"std" 	=> "",
								"type" 	=> "text"),
					
					array(    	"name" 	=> __('Main Category(2) - Slug','wpShop'),
								"desc" 	=> __('See instructions above.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_mainCat2",
								"std" 	=> "",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Main Category(3) - Slug','wpShop'),
								"desc" 	=> __('See instructions above.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_mainCat3",
								"std" 	=> "",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Main Category(4) - Slug','wpShop'),
								"desc" 	=> __('See instructions above.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_mainCat4",
								"std" 	=> "",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Main Category(5) - Slug','wpShop'),
								"desc" 	=> __('See instructions above.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_mainCat5",
								"std" 	=> "",
								"type" 	=> "text"),
								
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),
			
			// Custom Taxonomies
			array( 		"name" 	=> __('"Shop by" Options','wpShop'),
						"type" 	=> "title"),
									
				array(    	"type" 	=> "open"),

					array(  	"name" 	=> __('Shop by Outfit','wpShop'),
								"desc" 	=> __('Check this setting if you want to use the "Shop by Outfit" custom taxonomy.','wpShop')."<br/><b>".__('After activating one or more custom taxonomies please remember to save your ','wpShop')."<a href='".get_option('siteurl')."/wp-admin/options-permalink.php'>".__('permalink structure','wpShop')."</a>".__(' again!','wpShop')."</b><br/><b>".__('If any of the options below do not meet your online shop needs please feel free to request custom made ones.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_shopByOutfit_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),

					array(  	"name" 	=> __('Shop by Fit','wpShop'),
								"desc" 	=> __('Check this setting if you want to use the "Shop by Fit" custom taxonomy.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shopByFit_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Shop by Size','wpShop'),
								"desc" 	=> __('Check this setting if you want to use the "Shop by Size" custom taxonomy.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shopBySize_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Shop by Colour','wpShop'),
								"desc" 	=> __('Check this setting if you want to use the "Shop by Colour" custom taxonomy.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shopByColour_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Shop by Brand','wpShop'),
								"desc" 	=> __('Check this setting if you want to use the "Shop by Brand" custom taxonomy.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shopByBrand_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Shop by Selection','wpShop'),
								"desc" 	=> __('Check this setting if you want to use the "Shop by Selection" custom taxonomy.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shopBySelection_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Shop by Style','wpShop'),
								"desc" 	=> __('Check this setting if you want to use the "Shop by Style" custom taxonomy.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shopByStyle_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Shop by Price','wpShop'),
								"desc" 	=> __('Check this setting if you want to use the "Shop by Price" custom taxonomy.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shopByPrice_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),
			
			// Search
			array( 		"name" 	=> __('Your Search','wpShop'),
						"type" 	=> "title"),
									
				array(    	"type" 	=> "open"),
				
					array(  	"name" 	=> __('Display a "Search" link?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display a "search" link. Leave unchecked if you checked the option above to display a regular search input field.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_search_link_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(    	"name" 	=> __('Page Navigation - "Search" Page','wpShop'),
								"desc" 	=> __('If you have checked the setting to display a Search link, select the Page you have created for this purpose.','wpShop')."<br/><b>".__('Note: Remember to use the "My Search" custom page template for this page!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_pgNavi_searchOption",
								"type" 	=> "select",
								"vals" 	=> $nws_wp_pages,
								"std" 	=> "Search"),

					array(		"name" 	=> __('Search Title','wpShop'),
								"desc" 	=> __('Enter the title you would like to have appear in place of "Looking for something specific?" (inside the overlay that opens when you click on the Search link)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_search_title",
								"std" 	=> "Looking for something specific?",
								"type"	=> "text"),
								
					array(		"name" 	=> __('Search Text','wpShop'),
								"desc" 	=> __('Enter the text you would like to have appear below the "Looking for something specific?" title','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_search_text",
								"std" 	=> "",
								"type" 	=> "textarea"),
								
					array(		"name" 	=> __('Exclude Categories from Search Results','wpShop'),
								"desc" 	=> __('If you are using a Blog, please exclude it\'s category ID as well as the IDs of it\'s subcategories from being searched like so: -x,-y,-z where x,y,z the IDs','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_search_excl",
								"std" 	=> "",
								"type"	=> "text"),
								
					array(  	"name" 	=> __('Search Results Excerpt','wpShop'),
								"desc" 	=> __('Check this setting if you want to display an excerpt (teaser text) taken from the Product\'s Description or the excerpt write panel below the Product\'s image in Search Results.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_search_teaser_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),	
			
			// Footer
			array( 		"name" 	=> __('Your Footer','wpShop'),
						"type" 	=> "title"),
									
				array(    	"type" 	=> "open"),

					array(  	"name" 	=> __('Footer Size Options','wpShop'),
								"desc" 	=> __('Select the size of your footer.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_footer_option",
								"type" 	=> "select2",
								"std" 	=> "Small Footer",
								"vals" 	=> array(__('Small Footer','wpShop')."|small_footer",__('Large Footer','wpShop')."|large_footer")),
								
				array (    	"type" 	=> "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),	

		// Tab 2 Navigation			
		array (		"type" 	=> "fieldset_start",
					"class" =>"design",
					"id" 	=>"sec_navigation_settings"),
							
			array ( 	"name" 	=> __('Navigation','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
				
					array(    	"name" 	=> __('Main Page Navigation - "Home" Link title','wpShop'),
								"desc" 	=> __('The first text link of your main site page navigation will be the usual "Home" and the URL assigned to "Home" is pulled from the Blog address (URL). You may change the title to something else other than "Home" if desired.','wpShop')."<br/><b>".__('Note: You are NOT needed to create a page called "Home".','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_pgNavi_homeOption",
								"std" 	=> "",
								"type" 	=> "text"),
								
					array(    	"name" 	=> __('Split Main Page Navigation - Include Left','wpShop'),
								"desc" 	=> __('Enter the Page IDs (numeric value) to appear to the left of your logo.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pgNavi_inclLeftOption",
								"std" 	=> "",
								"type" 	=> "text"),
								
					array(  	"name" 	=> __('Your "Login", "Register", "Search" and "Shopping Bag" Links','wpShop'),
								"desc" 	=> __('By default, these links appear as part of the split main navigation to the right of the Logo. Check this setting if you want to move these links above and to the right of the Logo. This opens up the possibility to have more links of your choice populate the main page navigation area so use the setting below to include the page IDs you want.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_lrscLinks_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
									
					array(    	"name" 	=> __('Split Main Page Navigation - Include Right','wpShop'),
								"desc" 	=> __('Enter the Page IDs (numeric value) to appear to the right of your logo.','wpShop')."<br/><b>".__('Note: Fill this in ONLY if','wpShop')."<br/>".__('1. you have selected "Affiliate mode" as the Shop mode or ','wpShop')."<br/>".__('2. if you have checked the option above that moves your "Login", "Register", "Search" and "Shopping bag" links above the logo or','wpShop')."<br/>".__('3. if you have not activated the Customer Membership Area','wpShop')."<br/>".__('Otherwise this field must stay empty.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_pgNavi_inclRightOption",
								"std" 	=> "",
								"type" 	=> "text"),
								
					array(  	"name" 	=> __('Position Logo to the Left','wpShop'),
								"desc" 	=> __('By default the Logo will be placed in the center splitting the main page navigation to left and right links. Check this setting if you like the logo to move to the left.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_logoL",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
									
					array(    	"name" 	=> __('One-line Main Page Navigation - Exclude','wpShop'),
								"desc" 	=> __('Fill this field only if you have selected to move the logo up and to the left. Enter the IDs of the 1st (main) level pages to EXCLUDE from the main page navigation.','wpShop')."<br/><b>".__('You may for example like to exclude your Customer Area, Search, Login and Register pages.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_pgNavi_exclOption",
								"std" 	=> "",
								"type" 	=> "text"),
								
					array(  	"name" 	=> __('Main Page Navigation - Sorting','wpShop'),
								"desc" 	=> __('Select how your pages should be sorted. All available options are in the drop down','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pgNavi_sortOption",
								"type" 	=> "select2",
								"std" 	=> "Sort Pages by Page Order",
								"vals" 	=> array(__('Sort Pages by Page Order','wpShop')."|menu_order",__('Sort by numeric Page ID','wpShop')."|id",__('Sort Pages alphabetically by title','wpShop')."|post_title",__('Sort by creation time','wpShop')."|post_date",__('Sort alphabetically by Post slug','wpShop')."|post_name")),

					array(  	"name" 	=> __('Page - Category Hybrid Navigation?','wpShop'),
								"desc" 	=> __('Some of you have asked for the option of combining the main page navigation with categories. Checking this setting will give you the following: (Home link) (list of Top Level Categories) (list of Top Level Pages) (Blog link -if a blog is used). Use the page settings above to sort your pages. Use the category navigation settings below for sorting your category links.','wpShop')."<br/><b>".__('Note: This type of menu works only with the "Left Logo and One-Line Navigation" combination.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_hybrid_menu_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			// Special Navigation Settings
			array( 		"name" 	=> __('Special Navigation Links (Top Right)','wpShop'),
						"type" 	=> "title"),
								
				array(    	"type" 	=> "open"),
					
					array(    	"name" 	=> __('"My Account" Page','wpShop'),
								"desc" 	=> __('Select the Page you have created for this purpose. (Applies if you have activated the Customer Membership Area)','wpShop')."<br/><b>".__('Note: Appears after a Customer has logged in. This must be a 1st level page and please remember to use the "Account Customer Area" custom page template for this page!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_customerAreaPg",
								"type" 	=> "select",
								"vals" 	=> $nws_wp_pages,
								"std" 	=> "Select a Page"),
					
					array(    	"name" 	=> __('"Login" Page','wpShop'),
								"desc" 	=> __('Select the Page you have created for this purpose. (Applies if you have activated the Customer Membership Area)','wpShop')."<br/><b>".__('Note: This must be a 1st level page and please remember to use the "Account Login" custom page template for this page!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_pgNavi_logOption",
								"type" 	=> "select",
								"vals" 	=> $nws_wp_pages,
								"std" 	=> "Login"),
								
					array(    	"name" 	=> __('"Register" Page','wpShop'),
								"desc" 	=> __('Select the Page you have created for this purpose. (Applies if you have activated the Customer Membership Area)','wpShop')."<br/><b>".__('Note: This must be a 1st level page and please remember to use the "Account Register" custom page template for this page!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_pgNavi_regOption",
								"type" 	=> "select",
								"vals" 	=> $nws_wp_pages,
								"std" 	=> "Register"),
								
					array(    	"name" 	=> __('"Wishlist" Link Text','wpShop'),
								"desc" 	=> __('Enter the link text you\'d like in place of "Wishlist". (Applies if you have activated the Customer Membership Area)','wpShop')."<br/><b>".__('Note: This is NOT a separate page so do not create one. Appears after a Customer has logged in.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_wishListLink_option",
								"std" 	=> "My Wishlist",
								"type" 	=> "text"),
					
					array(    	"name" 	=> __('"Shopping Basket" Link Title','wpShop'),
								"desc" 	=> __('Enter the link title you\'d like to have in it\'s place.','wpShop')."<br/><b>".__('Note: You are not needed to create a separate page for this.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_pgNavi_cartOption",
								"std" 	=> "Shopping Basket",
								"type" 	=> "text"),
								
					array(    	"name" 	=> __('"Enquiry Basket" Link Title','wpShop'),
								"desc" 	=> __('Enter the link title you\'d like to have in it\'s place.','wpShop')."<br/><b>".__('Note: You are not needed to create a separate page for this. Displays if you have selected the "Enquiry Shop Mode" (See Shop settings).','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_pgNavi_inquireOption",
								"std" 	=> "Enquiry Basket",
								"type" 	=> "text"),
								
					array(    	"name" 	=> __('Shopping Basket / Enquiry Basket Icon','wpShop'),
								"desc" 	=> __('Enter the image file name you created.','wpShop')."<br/><b>".__('Make sure you have uploaded it inside your activated child theme\'s images folder!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_shopping_icon",
								"std" 	=> "shopping_icon.png",
								"type" 	=> "text"),
								
					array(  	"name" 	=> __('Set the Shopping Cart Item Number text on a new line?','wpShop'),
								"desc" 	=> __('','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_br_yes",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Display the Shopping Basket Total Item Value','wpShop'),
								"desc" 	=> __('','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_totalItemValue_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),

				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			//	Category Navigation Settings
			array( 		"name" 	=> __('Category Navigation Settings','wpShop'),
						"type" 	=> "title"),
						"id" 	=> "catNaviOptions",
						
				array(    	"type" 	=> "open"),
				
					array(  	"name" 	=> __('Category Main Navigation - Order by','wpShop'),
								"desc" 	=> "All available options are in the drop down",
								"id" 	=> $CONFIG_WPS['shortname']."_catNavi_orderbyOption",
								"type" 	=> "select2",
								"std" 	=> "Sort categories by name",
								"vals" 	=> array(__('Sort categories by name','wpShop')."|name",__('Sort by ID','wpShop')."|ID",__('Sort by slug','wpShop')."|slug",__('Sort by count','wpShop')."|count")),

					array(    	"name" 	=> __('Category Main Navigation - Order','wpShop'),
								"desc" 	=> "All available options are in the drop down",
								"id" 	=> $CONFIG_WPS['shortname']."_catNavi_orderOption",
								"type" 	=> "select2",
								"std" 	=> "Ascending",
								"vals" 	=> array(__('Ascending','wpShop')."|ASC",__('Descending','wpShop')."|DESC")),
								
					array(    	"name" 	=> __('Category Main Navigation - Include Only','wpShop'),
								"desc" 	=> __('Your Category list will by default include all your categories so if you want to include only certain ones then enter the','wpShop')."<a target='_blank' href='http://www.wprecipes.com/how-to-find-wordpress-category-id'>".__(' category IDs ','wpShop')."</a>".__('you would like to have included. Leave empty if you want the Default Option.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_catNavi_inclOption",
								"std" 	=> "",
								"type" 	=> "text"),
								
					array(    	"name" 	=> __('Category Main Navigation - Exclude Only','wpShop'),
								"desc" 	=> __('Your Category list will by default exclude none of your categories so if you want to exclude certain ones then enter the','wpShop')."<a target='_blank' href='http://www.wprecipes.com/how-to-find-wordpress-category-id'>".__(' category IDs ','wpShop')."</a>".__('you would like to have excluded. Leave empty if you want the Default Option.','wpShop')."<br/><b>".__('Note: If you are using a Blog section along with your Shop you will want to exclude it\'s category ID here!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_catNavi_exclOption",
								"std" 	=> "",
								"type" 	=> "text"),
								
					array(  	"name" 	=> __('Display Main Category Navigation on Front Page?','wpShop'),
								"desc" 	=> __('By default the Main Category Navigation does not appear on the Front page. Check this if you like it to.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_mainCatNavi_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
					
					array(  	"name" 	=> __('Main Category Navigation- Use Drop Downs?','wpShop'),
								"desc" 	=> __('Check this box if you want to display your Subcategories in a drop down when hovering the Main Category Links','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_dropDown_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
					
					array(    	"name" 	=> __('Category Subnavigation - Number of rows','wpShop'),
								"desc" 	=> __('When you view a category page that displays products and the current category has subcategories then these are displayed in a convenient sub-navigation for orientation and usability reasons above the main content area, as you see ','wpShop')."<a href='http://theclothesshop.sarah-neuber.de/category/women/womens-tops' target='_blank'>".__('here','wpShop')."</a>".__(' Enter the number of rows these subcategories should be displayed in.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_catSubNav_rows",
								"std" 	=> "2",
								"type" 	=> "text"),
								
					array(  	"name" 	=> __('Category Subnavigation - Order by','wpShop'),
								"desc" 	=> "All available options are in the drop down",
								"id" 	=> $CONFIG_WPS['shortname']."_catSubNav_orderbyOption",
								"type" 	=> "select2",
								"std" 	=> "Sort categories by name",
								"vals" 	=> array(__('Sort categories by name','wpShop')."|name",__('Sort by ID','wpShop')."|ID",__('Sort by slug','wpShop')."|slug",__('Sort by count','wpShop')."|count")),

					array(    	"name" 	=> __('Category Subnavigation - Order','wpShop'),
								"desc" 	=> "All available options are in the drop down",
								"id" 	=> $CONFIG_WPS['shortname']."_catSubNav_orderOption",
								"type" 	=> "select2",
								"std" 	=> "Ascending",
								"vals" 	=> array(__('Ascending','wpShop')."|ASC",__('Descending','wpShop')."|DESC")),
								
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),
//###############################################################################################################
		//Tab 3 Multiple Product Pages
		array (		"type" 	=> "fieldset_start",
					"class" =>"design",
					"id" 	=>"sec_multiProd_settings"),
					
			array ( 	"name" 	=> __('Multiple Product Pages','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
				
					array(  	"name" 	=> __('Display Category Decription','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the current category description below the category title (on category pages)','wpShop')."<br/><b>".__('Note: The Description text can be entered in the "Description" text area when you edit each category. You may use some html.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_catDescr_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),

					array(  	"name" 	=> __('Category Columns?','wpShop'),
								"desc" 	=> __('Choose the number of columns you would like to have ','wpShop')."<b>".__('when on a main category page that displays subcategories as you see ','wpShop')."<a target='_blank' href='http://theclothesshop.sarah-neuber.de/category/women'>".__('here','wpShop')."</a></b><br/><b>".__('The settings below give you more control over the content that displays on these particular pages.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_catCol_option",
								"type" 	=> "select2",
								"std" 	=> "3 Columns",
								"vals" 	=> array(__('3 Columns','wpShop')."|catCol3",__('3 Columns with narrow sidebar','wpShop')."|catCol3_ns",__('3 Columns with wide sidebar','wpShop')."|catCol3_ws",__('2 Columns with wide sidebar','wpShop')."|catCol2_ws")),
					
					array(  	"name" 	=> __('Your Secondary Categories (2nd Level) - Order by','wpShop'),
								"desc" 	=> __('All available options are in the drop down','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_secondaryCat_orderbyOption",
								"type" 	=> "select2",
								"std" 	=> "Sort by ID",
								"vals" 	=> array(__('Sort by ID','wpShop')."|ID",__('Sort by Count','wpShop')."|count",__('Sort categories by Name','wpShop')."|name",__('Sort categories by Slug','wpShop')."|slug")),

					array(    	"name" 	=> __('Your Secondary Categories (2nd Level) - Order','wpShop'),
								"desc" 	=> __('All available options are in the drop down','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_secondaryCat_orderOption",
								"type" 	=> "select2",
								"std" 	=> "Ascending",
								"vals" 	=> array(__('Ascending','wpShop')."|ASC",__('Descending','wpShop')."|DESC")),
										
					array(  	"name" 	=> __('Your Tertiary Categories (3rd Level) - Order by','wpShop'),
								"desc" 	=> __('All available options are in the drop down','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_tertiaryCat_orderbyOption",
								"type" 	=> "select2",
								"std" 	=> "Sort by ID",
								"vals" 	=> array(__('Sort by ID','wpShop')."|ID",__('Sort by Count','wpShop')."|count",__('Sort categories by Name','wpShop')."|name",__('Sort categories by Slug','wpShop')."|slug")),

					array(    	"name" 	=> __('Your Tertiary Categories (3rd Level) - Order','wpShop'),
								"desc" 	=> __('All available options are in the drop down','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_tertiaryCat_orderOption",
								"type" 	=> "select2",
								"std" 	=> "Ascending",
								"vals" 	=> array(__('Ascending','wpShop')."|ASC",__('Descending','wpShop')."|DESC")),
										
					array(  	"name" 	=> __('Image or Text?','wpShop'),
								"desc" 	=> __('Choose whether you would like each category here (2nd level) appear with just the Category\'s Text Title or a category specific image.','wpShop')."<br/>".__(' The Text Title (if chosen) will be used with ','wpShop')."<a href='http://cufon.shoqolate.com/generate/' target='_blank'>Cufon</a>",
								"id" 	=> $CONFIG_WPS['shortname']."_catDisplay_option",
								"type" 	=> "select2",
								"std" 	=> "Text Title",
								"vals" 	=> array(__('Text Title','wpShop')."|text_title",__('Category Specific Image','wpShop')."|cat_img")),
										
					array(  	"name" 	=> __('Subcategory Specific Images - File Type','wpShop'),
								"desc" 	=> __('If you have chosen "Category Specific Image" from above choose the file type of your subcategory specific images.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_catimg_file_type2",
								"type" 	=> "select2",
								"std" 	=> "jpg",
								"vals" 	=> array("jpg|jpg","png|png","gif|gif")),

				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),

			// tag pages
			array( 		"name" 	=> __('Tag and Custom Taxonomy pages','wpShop'),
						"type" 	=> "title"),
								
				array(    	"type" 	=> "open"),	

					array(  	"name" 	=> __('Term Specific Images - File Type','wpShop'),
								"desc" 	=> __('Select the file type of your term (tags and custom taxonomy terms) specific images.','wpShop')."<br/>".__('This refers to tag specific images that display in the sidebar as you can see','wpShop')."<a target='_blank' href='http://theclothesshop.sarah-neuber.de/outfits/weekend-outfit-1'>".__('here','wpShop')."</a>",
								"id" 	=> $CONFIG_WPS['shortname']."_tagimg_file_type",
								"type" 	=> "select2",
								"std" 	=> "jpg",
								"vals" 	=> array("jpg|jpg","png|png","gif|gif")),
								
					array(  	"name" 	=> __('Display Tag / Custom Term Decription?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the current tag / custom term\s description below the tag / custom term specific image','wpShop')."<br/><b>".__('Note: The Description text can be entered in the "Description" text area when you edit each tag or custom term. You may use some html.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_termDescr_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),

				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),

			// Product Posts
			array( 		"name" 	=> __('Product Post Settings on Category and other Multiple Product Pages','wpShop'),
						"type" 	=> "title"),
								
				array(    	"type" 	=> "open"),	

					array(  	"name" 	=> __('Product Columns on Category pages','wpShop'),
								"desc" 	=> __('Select the number of columns you would like to have ','wpShop')."<br/><b>".__('This setting will apply on category pages that display products!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_prodCol_option",
								"type" 	=> "select2",
								"std" 	=> "5 Columns",
								"vals" 	=> array(__('5 Columns','wpShop')."|prodCol5",__('4 Columns with narrow sidebar','wpShop')."|prodCol4_ns",__('4 Columns with wide sidebar','wpShop')."|prodCol4_ws",__('3 Columns with narrow sidebar','wpShop')."|prodCol3_ns",__('3 Columns with wide sidebar','wpShop')."|prodCol3_ws",__('2 Columns with wide sidebar','wpShop')."|prodCol2_ws",__('2 Columns with narrow sidebar','wpShop')."|prodCol2_ns",__('1 Column with wide sidebar','wpShop')."|prodCol1_ws")),
					
										
					array(  	"name" 	=> __('Product Columns on Tag and Custom Taxonomy pages','wpShop'),
								"desc" 	=> __('Select the number of columns you would like to have','wpShop')."<b>".__(' when on a tag or custom taxonomy page ','wpShop')."</b>".__('eg. ','wpShop')."<a href='http://theclothesshop.sarah-neuber.de/tag/weekend-outift-1' target='_blank'>".__('here','wpShop')."</a>",
								"id" 	=> $CONFIG_WPS['shortname']."_tagCol_option",
								"type" 	=> "select2",
								"std" 	=> "3 Columns",
								"vals" 	=> array(__('3 Columns with wide sidebar','wpShop')."|tagCol3_ws",__('4 Columns with wide sidebar','wpShop')."|tagCol4_ws")),
										
					array(  	"name" 	=> __('Your Products - Order by','wpShop'),
								"desc" 	=> __('All available options are in the drop down','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prods_orderbyOption",
								"type" 	=> "select2",
								"std" 	=> "Order by ID",
								"vals" 	=> array(__('Order by ID','wpShop')."|ID",__('Order by Title','wpShop')."|title",__('Order by Date','wpShop'). "|date",__('Order by Parent','wpShop'). "|parent",__('Order by Comment Count','wpShop'). "|comment_count",__('Random Order','wpShop'). "|rand",__('None','wpShop'). "|none")),
					
					array(    	"name" 	=> __('Your Products - Order','wpShop'),
								"desc" 	=> __('All available options are in the drop down','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prods_orderOption",
								"type" 	=> "select2",
								"std" 	=> "Ascending",
								"vals" 	=> array(__('Ascending','wpShop')."|ASC",__('Descending','wpShop')."|DESC")),
								
					array(    	"name" 	=> __('Overwrite the "Blog pages show at most" Admin Setting','wpShop'),
								"desc" 	=> __('When on "View All" you may want to overwrite the "Blog pages show at most" setting in Settings > Reading in order to show all products in that particular category.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_showpostsOverwrite_Option",
								"type" 	=> "select2",
								"std" 	=> "Yes",
								"vals" 	=> array(__('Yes','wpShop')."|showpostsOverwrite_yes",__('No','wpShop')."|showpostsOverwrite_no")),
								
					array(  	"name" 	=> __('Use WordPress generated image thumbnails?','wpShop'),
								"desc" 	=> __('Do you prefer to use the WordPress generated image thumbnails over the default proportionally resized thumbnails? Checking this option will display square-sized product images.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_wp_thumb",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),
			
			//Product Teaser & Ratings
			array( 		"name" 	=> __('Product Teaser &amp; Ratings','wpShop'),
						"type" 	=> "title"),
								
				array(    	"type"	=> "open"),
				
					array(  	"name" 	=> __('Show teaser','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the product title, price and an optional short remark below each product image','wpShop')."<br/><b>".__('Note: For the optional short remark you must use the item_remarks custom field with your remark for the value','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_teaser_enable_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Show teaser between Product Title and Price','wpShop'),
								"desc" 	=> __('By default the theme will display the short teaser remark below the price.Check this setting if you want to display it between the product title and the price ','wpShop')."<br/><b>".__('Note: Unlike the default teaser remark this one is wrapped in a div so you can use some html like p. You\'ll use the item_remarks custom field again as above.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_teaser2_enable_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(		"name" 	=> __('Display Product Title?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the Product Title','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prod_title",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(		"name" 	=> __('Display Product Price?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the Product Price','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prod_price",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(		"name" 	=> __('Display Product "Add to Basket" button?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the "Add to Basket" button','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prod_btn",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
				
					array(		"name" 	=> __('Activate Product Ratings on Multiple Product Pages?','wpShop'),
								"desc" 	=> __('Requires that you install and active the','wpShop')."<a target='_blank' href='http://wordpress.org/extend/plugins/wp-postratings/'>".__(' WP-Postratings ','wpShop')."</a>".__('plugin','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_multiProd_rate_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
		array (		"type" 	=> "fieldset_end"),	
//###############################################################################################################
		//Tab 4 Customer Membership
		array (		"type" 	=> "fieldset_start",
					"class" =>"design",
					"id" 	=>"sec_membership_settings"),
							
			array ( 	"name" 	=> __('Customer Membership','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
					
					array(    	"name" 	=> __('"Recover Password" Page','wpShop'),
								"desc" 	=> __('Select the Page you have created for this purpose. (Applies if you have activated the Customer Membership Area)','wpShop')."<br/><b>".__('Note: This must be a 1st level page and please remember to use the "Recover Password" custom page template for this page!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_passLostPg",
								"type" 	=> "select",
								"vals" 	=> $nws_wp_pages,
								"std" 	=> "Recover Password"),
										
					array(  	"name" 	=> __('Show Logout Link?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display a log-out link in the Customer Membership Area landing page. (Applies if you have activated the "Customer Membership Area")','wpShop')."<br/><b>".__('Note: When a Customer is logged in, a Log-out link will always display in the Main Navigation in the header.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_logoutLink_option",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(    	"name" 	=> __('Wishlist intro text','wpShop'),
								"desc" 	=> __('Optional. Enter some intro text here that will display when on the "My Wishlist" section.','wpShop')."<br/><b>".__('Note: The text will be wrapped in a paragraph so if you like to use html tags please use only inline elements.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_wishlistIntroText",
								"std" 	=> "Some optional text can be entered here from your Theme Options",
								"type" 	=> "textarea"),
								
					array(  	"name" 	=> __('Login Duration','wpShop'),
								"desc" 	=> __('Select how long you would like your customers to stay logged in before the system automatically logs them out!.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_login_duration",
								"type" 	=> "select2",
								"std" 	=> "30 min",
								"vals" 	=> array(__('30 min','wpShop')."|1800",__('1 hour','wpShop')."|3600",__('2 hours','wpShop')."|7200",__('4 hours','wpShop')."|14400",__('6 hours','wpShop')."|21600",__('8 hours','wpShop')."|28800",__('10 hours','wpShop')."|36000",__('12 hours','wpShop')."|43200",__('14 hours','wpShop')."|50400",__('16 hours','wpShop')."|57600",__('18 hours','wpShop')."|64800",__('20 hours','wpShop')."|72000",__('22 hours','wpShop')."|79200",__('24 hours','wpShop')."|86400")),
								
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			//requesting additional information from registered customers
			array ( 	"name" 	=> __('Optional Member Info Section','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
				
					array(    	"name" 	=> __('Main title','wpShop'),
								"desc" 	=> __('Heading to preceed the section. If left empty, the Optional Member Info blok will not appear.','wpShop')."<br/><b>".__('The purpose of this extra section is to be able to get some additional information from your registered customers and use as needed. This information will be saved in your Members Overview table','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_extrainfo_header",
								"std" 	=> "",
								"type" 	=> "text"),	
								
					array(    	"name" 	=> __('Additional Instructions','wpShop'),
								"desc" 	=> __('This can be used for some intro text or additional instructions for the form input fields that follow below. The text will be wrapped in a paragraph html tag so if you need any formating please use inline elements only.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_extrainfo_instruct",
								"std" 	=> "",
								"type" 	=> "textarea"),						
					
					array(    	"name" 	=> __('The Form Fields -Text Inputs','wpShop'),
								"desc" 	=> __('Enter the label text for each text input field. Each line break will give you a new text input field so if you want multiple text inputs enter the label text for each on a new line.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_extra_formfields",
								"std" 	=> "",
								"type" 	=> "textarea"),
								
					array(    	"name" 	=> __('Number of Columns','wpShop'),
								"desc" 	=> __('Please select','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_extra_formfieldsCol",
								"type" 	=> "select",
								"std" 	=> "1",
								"vals" => array("1", "2")),
								
				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),
//###############################################################################################################
		// Tab 5 Single Products			
		array (		"type" 	=> "fieldset_start",
					"class" =>"design",
					"id" 	=>"sec_singleProd_settings"),
							
			//layout, navigation settings				
			array ( 	"name" 	=> __('Single Product Pages','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),

					array(  	"name" 	=> __('Display Links to Previous and Next Products','wpShop'),
								"desc" 	=> __('Check this setting if you want to display previous and next product links. They will appear below the product\'s description and "View Cart" link to the right','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prodNav_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('Display also at the top?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display previous and next product links also at the top of the page','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_linksTop_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(		"name" 	=> __('Previous Product Link Text','wpShop'),
								"desc" 	=> __('Enter the link text for the Previous Product','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prevProdLinkText",
								"std" 	=> "Previous Product",
								"type" 	=> "text"),
					
					array(		"name" 	=> __('Next Product Link Text','wpShop'),
								"desc" 	=> __('Enter the link text for the Next Product','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_nextProdLinkText",
								"std" 	=> "Next Product",
								"type" 	=> "text"),
				
				array(   	"type" => "close"),
			array(   	"type" => "close"),
				
			//image effects				
			array ( 	"name" 	=> __('Product Image and Video/ Audio Settings','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
				
					array(		"name" 	=> __('I am self-hosting video / audio','wpShop'),
								"desc" 	=> __('Check this option if you are.','wpShop')."<a target='_blank' href='http://flowplayer.org/'>".__(' Flowplayer ','wpShop')."</a>".__('will be activated for you.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_flowplayer_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
			
					array(    	"name" 	=> __('Product Image','wpShop'),
								"desc" 	=> __('Select the effect to be used on the Product\'s image(s)','wpShop')."<br/><b>".__('Note: There is no need to install any plugins. The necessary javascript files are already in place.','wpShop')."</b><br/><b>".__('If you select any of the Magic Zoom effects you will need to','wpShop')."<a target='_blank' href='http://www.magictoolbox.com/?ac=2WA2V3J'>".__(' purchase a license','wpShop')."</a></b>",
								"id" 	=> $CONFIG_WPS['shortname']."_prodImg_effect",
								"type" 	=> "select2",
								"std" 	=> "Magic Zoom",
								"vals" 	=> array(__('Magic Zoom','wpShop')."|mz_effect",__('Magic Zoom Plus','wpShop')."|mzp_effect",__('JQZoom','wpShop')."|jqzoom_effect",__('Lightbox','wpShop')."|lightbox",__('None! No effects please.','wpShop')."|no_effect")),
								
					array(  	"name" 	=> __('Multiple Product Images - Use Image Thumbs?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display Image Thumbnails over the default Numbered Thumbs next to the product\'s main image.','wpShop')."<br/><b>".__('Note: They only appear if more than one product image has been attached!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_imgThumbs_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('Lightbox - Use Caption?','wpShop'),
								"desc" 	=> __('Check this setting if you want to show a caption below the image after it opens in the lightbox (fancybox) ','wpShop')."<br/><b>".__('Note: The caption is taken from the image\'s title attribute.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_caption_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(		"name" 	=> __('Video Tab','wpShop'),
								"desc" 	=> __('If you have embedded a Video then enter the text you\'d like for it\'s Tab','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_videoTabText",
								"std" 	=> "View a Sample",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Display Images Tab?','wpShop'),
								"desc" 	=> __('If you have embedded a Video then you have the option to display other Product Images alongside it. Check this option if you would like that.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_imagesTab_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(		"name" 	=> __('Images Tab','wpShop'),
								"desc" 	=> __('If you have embedded a Video and you have selected to display other Product Images alongside it, enter the text you\'d like for the Images Tab','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_imagesTabText",
								"std" 	=> "Images",
								"type" 	=> "text"),
								
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			//Product Variations
			array( 		"name" 	=> __('Product Variations (Select Dropdowns)','wpShop'),
						"type" 	=> "title"),
								
				array(    	"type"	=> "open"),
				
					array(  	"name" 	=> __('Order by','wpShop'),
								"desc" 	=> __('All the available options are found in the dropdown','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prodVariations_orderBy",
								"type" 	=> "select2",
								"std" 	=> "Order by ID",
								"vals" 	=> array(__('Order Alphabeticaly by Key Name','wpShop')."|meta_key", __('Order by Time Created','wpShop')."|meta_id")),
								
					array(    	"name" 	=> __('Order','wpShop'),
								"desc" 	=> __('All the available options are found in the dropdown','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prodVariations_order",
								"type" 	=> "select2",
								"std" 	=> "ASC",
								"vals" 	=> array(__('Ascending','wpShop')."|ASC", __('Descending','wpShop')."|DESC")),
				
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			//Product Personalization
			array( 		"name" 	=> __('Product Personalization (Text Inputs and Textareas)','wpShop'),
						"type" 	=> "title"),
								
				array(    	"type"	=> "open"),
				
					array(  	"name" 	=> __('Order by','wpShop'),
								"desc" 	=> __('All the available options are found in the dropdown','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prodPersonalization_orderBy",
								"type" 	=> "select2",
								"std" 	=> "Order by ID",
								"vals" 	=> array(__('Order Alphabeticaly by Key Name','wpShop')."|meta_key", __('Order by Time Created','wpShop')."|meta_id")),
								
					array(    	"name" 	=> __('Order','wpShop'),
								"desc" 	=> __('All the available options are found in the dropdown','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prodPersonalization_order",
								"type" 	=> "select2",
								"std" 	=> "ASC",
								"vals" 	=> array(__('Ascending','wpShop')."|ASC", __('Descending','wpShop')."|DESC")),
				
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			//Product Ratings
			array( 		"name" 	=> __('Product Ratings','wpShop'),
						"type" 	=> "title"),
								
				array(    	"type"	=> "open"),
				
					array(		"name" 	=> __('Activate Product Ratings on Single Product Pages?','wpShop'),
								"desc" 	=> __('Requires that you install and active the','wpShop')."<a target='_blank' href='http://wordpress.org/extend/plugins/wp-postratings/'>".__(' WP-Postratings ','wpShop')."</a>".__('plugin','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_singleProd_rate_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			//related prods settings				
			array ( 	"name" 	=> __('Related Products Settings','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),

					array(  	"name" 	=> __('Display Related Products?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display (Category and/or Tag) Related Products. The section will appear below the Product\'s image(s) and only if (Category and/or Tag) Related Products exist.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_relatedProds_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('Display Tag Related Products?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display Tag Related Products. The section will appear below the product\'s image(s) and only if tag Related Products exist.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_tagRelatedProds_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(		"name" 	=> __('Tag Related Tab','wpShop'),
								"desc" 	=> __('The first tab displays Tag Related Products (if Tags are used for Product Posts and any are found). Enter the text for this tab.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_tag_relatedProds",
								"std" 	=> "Complete the Set",
								"type" 	=> "text"),
										
					array(  	"name" 	=> __('Alternative Tag Related Products','wpShop'),
								"desc" 	=> __('Since WordPress Tags are not (at the point of creating this theme) hierarchical you can only use them either for your Product Posts or your Blog Posts not both! If you have checked the option to use Tags for regular Blog Posts under "General Options" then you need to select one of the other available custom taxonomies to be queried in place of Tags for "Tag Related Products".','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_term_relatedProds",
								"type" 	=> "select2",
								"std" 	=> "",
								"vals" 	=> array(__('Outfit','wpShop')."|outfit_related",__('Fit','wpShop')."|fit_related",__('Size','wpShop')."|size_related",__('Colour','wpShop')."|colour_related",__('Brand','wpShop')."|brand_related",__('Selection','wpShop')."|selection_related",__('Style','wpShop')."|style_related",__('Price','wpShop')."|price_related")),
								
					array(		"name" 	=> __('Number of Tag Related Products','wpShop'),
								"desc" 	=> __('Enter the desired number of Tag Related Products to display. If you want more than 4, you will need to make sure there\'s enough space for them to fit by either decreasing the image size (see image options) and/or adjusting the css','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_tag_relatedProds_num",
								"std" 	=> "4",
								"type" 	=> "text"),					
										
					array(  	"name" 	=> __('Display Category Related Products?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display Category Related Products. The section will appear below the product\'s image(s) and only if Category Related Products exist.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_catRelatedProds_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(		"name" 	=> __('Category Related Tab','wpShop'),
								"desc" 	=> __('The second tab displays Category Related Products (if any are found). Enter the text for this tab.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_cat_relatedProds",
								"std" 	=> "You may also like",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Category Related Products -Number','wpShop'),
								"desc" 	=> __('Enter the desired number of Category Related Products to display. If you want more than 4, you will need to make sure there\'s enough space for them to fit by either decreasing the image size (see image options) and/or adjusting the css','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_cat_relatedProds_num",
								"std" 	=> "4",
								"type" 	=> "text"),	
								
					array(  	"name" 	=> __('Category Related Products - Order by','wpShop'),
								"desc" 	=> __('All available options are in the dropdown','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_cat_relatedProds_orderby",
								"type" 	=> "select2",
								"std" 	=> "Random Order",
								"vals" 	=> array(__('Random Order','wpShop')."|rand", __('Order by ID','wpShop')."|ID", __('Order by Title','wpShop')."|title", __('Order by Date','wpShop')."|date", __('Order by Parent','wpShop')."|parent", __('Order by Comment Count','wpShop')."|comment_count", __('None','wpShop')."|none")),

					array(    	"name" 	=> __('Category Related Products - Order','wpShop'),
								"desc" 	=> __('All available options are in the dropdown','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_cat_relatedProds_order",
								"type" 	=> "select2",
								"std" 	=> "Ascending",
								"vals" 	=> array(__('Ascending','wpShop')."|ASC",__('Descending','wpShop')."|DESC")),
										
					array(  	"name" 	=> __('Select the Open Related Product Tab','wpShop'),
								"desc" 	=> __('Select which of the 2 tabs you\'d like to have open when the page loads','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_relatedOpen_tab",
								"type" 	=> "select2",
								"std" 	=> "",
								"vals" 	=> array(__('Tag Related Tab','wpShop')." |tag_related_tab",__('Category Related Tab','wpShop')."|cat_related_tab")),
										
					array(  	"name" 	=> __('Display Shopping Bag Related Products?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display Related Products when viewing the Shopping Bag page.','wpShop')."<br/><b>".__('Note: This option requires the use of tags so leave it unchecked until you are ready to start tagging your products! If you have checked the option to use Tags for regular Blog Posts under "General Settings" then you need to select one of the other available custom taxonomies from below to be queried instead.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_cartRelatedProds_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('Alternative Shopping Bag Related Products','wpShop'),
								"desc" 	=> __('See explanation above.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_term_cart_relatedProds",
								"type" 	=> "select2",
								"std" 	=> "",
								"vals" 	=> array(__('Outfit','wpShop')."|outfit_related",__('Fit','wpShop')."|fit_related",__('Size','wpShop')."|size_related",__('Colour','wpShop')."|colour_related",__('Brand','wpShop')."|brand_related",__('Selection','wpShop')."|selection_related",__('Style','wpShop')."|style_related",__('Price','wpShop')."|price_related")),
								
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			//Shipping and Supplementary Info Links	
			array( 		"name" 	=> __('Shipping and Supplementary Info Links','wpShop'),
						"type" 	=> "title"),
								
				array(    	"type"	=> "open"),
				
					array(  	"name" 	=> __('Display Product ID?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the Product ID (ID_item)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prod_ID",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
				
					array(  	"name" 	=> __('Display Shipping &amp; Handling link','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the Shipping &amp; Handling Details link on the single product view and the Shopping Basket View','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_details_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(    	"name" 	=> __('Shipping &amp; Handling link title text','wpShop'),
								"desc" 	=> __('Enter the Shipping &amp; Handling link title text','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shippingInfo_linkTxt",
								"std" 	=> "Shipping &amp; Handling Info",
								"type" 	=> "text"),
										
					array(  	"name" 	=> __('Shipping &amp; Handling Details','wpShop'),
								"desc" 	=> __('Enter a brief description of your shipping and handling charges. The text you enter here will be wrapped in a "div" html element so if you want to have paragraphs you may wrap your text blocks in "p" html elements.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_details",
								"std" 	=> "Here you may include some useful information for your customers regarding your Shipping &amp; Handling Fees, Returns Policy whether you ship Internationaly or not etc. Let them know that these charges will be calculated on Step 3 (Order Review).",
								"type" 	=> "textarea"),
										
					array(  	"name" 	=> __('Display "Supplementary Info" link','wpShop'),
								"desc" 	=> __('Check this setting if you want to display a "Supplementary Info" link. It is used to "pull" any kind of supplementary information contained anywhere else on the site and display it within an "overlay" such as "Size Charts", "Product Care Instructions" etc. The path to the page you want to get the contents of must be provided using the settings below.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_sizeChart_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
					
					array(    	"name" 	=> __('"Supplementary Info" link title text','wpShop'),
								"desc" 	=> __('Enter the "Supplementary Info" link text you would like to have appear on the single product view','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_sizeChart_link",
								"std" 	=> "Size Chart",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('"Supplementary Info" (for products in your 1st main category) links to','wpShop'),
								"desc" 	=> __('Please enter the link PATH to the "Supplementary Info" page for products under the main (1st level) category you have created. The numbering system here used refers to the main categories','wpShop')."<b>".__(' in the order they were created. ','wpShop')."</b>".__('This will mean that products in the main category with the lowest ID are targeted first and the products that belong to the category with the highest ID are targeted last.','wpShop')."<br/>".__('Note: Fill in only if applicable. Otherwise leave empty!','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_sizeChart1_link",
								"std" 	=> "",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('"Supplementary Info" (for products in your 2nd main category) links to','wpShop'),
								"desc" 	=> __('See instructions above','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_sizeChart2_link",
								"std" 	=> "",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('"Supplementary Info" (for products in your 3rd main category) links to','wpShop'),
								"desc" 	=> __('See instructions above','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_sizeChart3_link",
								"std" 	=> "",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('"Supplementary Info" (for products in your 4th main category) links to','wpShop'),
								"desc" 	=> __('See instructions above','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_sizeChart4_link",
								"std" 	=> "",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('"Supplementary Info" (for products in your 5th main category) links to','wpShop'),
								"desc" 	=> __('See instructions above','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_sizeChart5_link",
								"std" 	=> "",
								"type" 	=> "text"),
								
					array(  	"name" 	=> __('Redirect to Shopping Basket?','wpShop'),
								"desc" 	=> __('When a Product is added to the Shopping Basket then by default the page will reload and a confirmation message appears. Check this setting if you want to overwrite this and send the user to the Shopping Basket Page instead.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_send_to_view_cart",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			//Social and subscribe settings		
			array( 		"name" 	=> __('Your "Share" and "Subscribe" Settings','wpShop'),
						"type" 	=> "title"),
								
				array(    	"type"	=> "open"),

					array(  	"name" 	=> __('"Email a Friend"?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the "Email a Friend" link','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_emailFriend_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('"Print"?','wpShop'),
								"desc" 	=> __('Check this settting if you want to display the "Print" link','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_print_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('"Share"?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the "Share" link','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_share_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('"Subscribe"?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the "Subscribe" link','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_subscribe_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),

					array(		"name" 	=> __('Feedburner RSS Link','wpShop'),
								"desc" 	=> __('Enter Your Feedburner Link It will look something like this: ','wpShop')."'http://feeds2.feedburner.com/snDesign'",
								"id" 	=> $CONFIG_WPS['shortname']."_feedburner_rsslink",
								"std" 	=> "http://feeds2.feedburner.com/snDesign",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Feedburner Email Subscription Link','wpShop'),
								"desc" 	=> __('Enter Your Feedburner Email Subscription link you are given after you have activated "Email Subscriptions" from your account. It will look something like this: ','wpShop')."'http://feedburner.google.com/fb/a/mailverify?uri=snDesign&amp;loc=en_US'",
								"id" 	=> $CONFIG_WPS['shortname']."_feedburner_emaillink",
								"std" 	=> "http://feedburner.google.com/fb/a/mailverify?uri=snDesign&loc=en_US",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Twitter','wpShop'),
								"desc" 	=> __('Enter Your Twitter username','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_twitter",
								"std" 	=> "srhnbr",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Subscribe Title','wpShop'),
								"desc" 	=> __('Enter the title you would like to have in place of "Stay Informed" (appears inside the overlay that opens when the "Subscribe" link is clicked)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_subscribe_title",
								"std" 	=> "Stay Informed",
								"type"	=> "text"),
										
					array(		"name" 	=> __('Subscribe Text','wpShop'),
								"desc" 	=> __('Enter the text you would like to have appear below the "Stay Informed" title','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_subscribe_text",
								"std" 	=> "",
								"type" 	=> "textarea"),
										
					array(		"name" 	=> __('Share Title','wpShop'),
								"desc" 	=> __('Enter the title you would like to have in place of "Bookmark and Share" (appears inside the overlay that opens when the "Share" link is clicked)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_share_title",
								"std" 	=> "Bookmark & Share",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Share Text','wpShop'),
								"desc" 	=> __('Enter the text you would like to have appear appear below the "Bookmark and Share"','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_share_text",
								"std" 	=> "",
								"type" 	=> "textarea"),
										
					array(		"name" 	=> __('Email a Friend Title','wpShop'),
								"desc" 	=> __('Enter the title you would like to have in place of "Email a Friend About this Item" (appears inside the overlay that opens when the "Email a Friend" link is clicked)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_email_a_friend_title",
								"std" 	=> "Email a Friend About this Item",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Email a Friend Text','wpShop'),
								"desc" 	=> __('Enter the text you would like to have appear below the "Email a Friend About this Item" title','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_email_a_friend_text",
								"std" 	=> "",
								"type" 	=> "textarea"),
										
				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),	
//###############################################################################################################
		// Tab 6 Blog			
		array (		"type" 	=> "fieldset_start",
					"class" =>"design",
					"id" 	=>"sec_blog_settings"),
							
			// Category settings				
			array ( 	"name" 	=> __('Blog','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),

					array(  	"name" 	=> __('"Date Published"?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the Post\'s "Publish" Date (appears on Multiple Post Pages)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_date_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),

					array(  	"name" 	=> __('Number of comments?','wpShop'),
								"desc" 	=> __('Check this box if you want to display the Post\'s Comments number (appears on Multiple Post Pages)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_commentsNum_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),					

					array(  	"name" 	=> __('Teaser','wpShop'),
								"desc" 	=> __('Select the type of teaser content you\'d like to have (appears on Multiple Post Pages)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogPostContent_option",
								"type" 	=> "select2",
								"std" 	=> "Post Excerpt with 'read more' link",
								"vals" 	=> array(__('Post Excerpt with "read more" link','wpShop')." |excerpt_link",__('Post Content with "read more" link','wpShop')."|content_link")),

					array(  	"name" 	=> __('Teaser Word Limit','wpShop'),
								"desc" 	=> __('If you have chosen "Post content" above enter the number of words to appear before the "cut" off point','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogWordLimit",
								"std" 	=> "30",
								"type" 	=> "text"),
										
					array(  	"name" 	=> __('"Read More" Link Text','wpShop'),
								"desc" 	=> __('Enter the link text to display for your "Read More" link','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_readMoreLink",
								"std" 	=> "read more",
								"type" 	=> "text"),
										
					array(  	"name" 	=> __('Display Meta Information?','wpShop'),
								"desc" 	=> __('Check this box if you want to display the Post\'s categories and tags - if any are used (appears on Multiple Post Pages)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blog_cat_meta_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
				array(   	 "type" => "close"),
			array(   	"type" => "close"),
			
			// Single Blog Post Pages - Sidebar Content
			array( 		"name" 	=> __('Single Blog Post Pages - Sidebar Content','wpShop'),
						"type" 	=> "title"),
								
				array(    	"type" 	=> "open"),	

					array(  	"name" 	=> __('Display Category Related Posts?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display Category Related Posts. The section will appear in the sidebar of single blog posts and only if category related posts exist.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogCatRelated_posts_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(		"name" 	=> __('How many Category Related Posts','wpShop'),
								"desc" 	=> __('Enter a number','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogCatRelated_num",
								"std" 	=> "4",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Category Related Title','wpShop'),
								"desc" 	=> __('Enter the text title you\'d like to have over the "Category Related Posts" list.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogCatRelated_title",
								"std" 	=> "Category Related",
								"type" 	=> "text"),
										
					array(  	"name" 	=> __('Display Tag Related Posts?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display Tag Related Posts. The section will appear in the sidebar of single blog posts and only if tag related posts exist.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogTagRelated_posts_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),

					array(		"name" 	=> __('How many Tag Related Posts','wpShop'),
								"desc" 	=> __('Enter a number','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogTagRelated_num",
								"std" 	=> "4",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Tag Related Title','wpShop'),
								"desc" 	=> __('Enter the text title you\'d like to have over the "Tag Related Posts" list','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogTagRelated_title",
								"std" 	=> "Tag Related",
								"type" 	=> "text"),
										
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			// Single Blog Post Pages - Main Content (meta)
			array( 		"name" 	=> __('Single Blog Post Pages - Meta Info','wpShop'),
						"type" 	=> "title"),
								
				array(    	"type" 	=> "open"),	

					array(  	"name" 	=> __('"Date Published"?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the Post\'s "Publish" Date','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_publish_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('"Posted in"?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the Categories the Post belongs to.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_posted_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('"Tagged as"?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the Tags the Post is tagged as.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_tagged_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('"Previous and Next" Post Links?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display previous and next post links','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prevNext_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			//Single Blog Post Pages - "Share" and "Subscribe" Settings
			array( 		"name" 	=> __('Single Blog Post Pages - Your "Share" and "Subscribe" Settings','wpShop'),
						"type" 	=> "title"),
								
				array(    	"type"	=> "open"),

					array(  	"name" 	=> __('"Email a Friend"?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the "Email a Friend" link','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogEmailFriend_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('"Print"?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the "Print" link','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogPrint_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('"Share"?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the "Share" link','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogShare_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('"Subscribe"?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the "Subscribe" link','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogSubscribe_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),

					array(		"name" 	=> __('Feedburner RSS Link','wpShop'),
								"desc" 	=> __('Enter Your Feedburner Link It will look something like this: ','wpShop')."'http://feeds2.feedburner.com/snDesign'",
								"id" 	=> $CONFIG_WPS['shortname']."_blogFeedburner_rsslink",
								"std" 	=> "http://feeds2.feedburner.com/snDesign",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Feedburner Email Subscription Link','wpShop'),
								"desc" 	=> __('Enter Your Feedburner Email Subscription link you are given after you have activated "Email Subscriptions" from your account. It will look something like this: ','wpShop')."'http://feedburner.google.com/fb/a/mailverify?uri=snDesign&amp;loc=en_US'",
								"id" 	=> $CONFIG_WPS['shortname']."_blogFeedburner_emaillink",
								"std" 	=> "http://feedburner.google.com/fb/a/mailverify?uri=snDesign&loc=en_US",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Twitter','wpShop'),
								"desc" 	=> __('Enter Your Twitter username','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogTwitter",
								"std" 	=> "srhnbr",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Subscribe Title','wpShop'),
								"desc" 	=> __('Enter the title you would like to have in place of "Stay Informed" (inside the overlay that opens when the "Subscribe" link is clicked)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogSubscribe_title",
								"std" 	=> "Stay Informed",
								"type"	=> "text"),
										
					array(		"name" 	=> __('Subscribe Text','wpShop'),
								"desc" 	=> __('Enter the text you would like to have appear below the "Stay Informed" title','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogSubscribe_text",
								"std" 	=> "",
								"type" 	=> "textarea"),
										
					array(		"name" 	=> __('Share Title','wpShop'),
								"desc" 	=> __('Enter the title you would like to have in place of "Bookmark and Share" (inside the overlay that opens when the "Share" link is clicked','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogShare_title",
								"std" 	=> "Bookmark & Share",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Share Text','wpShop'),
								"desc" 	=> __('Enter the text you would like to have appear appear below the "Bookmark and Share"','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogShare_text",
								"std" 	=> "",
								"type" 	=> "textarea"),
										
					array(		"name" 	=> __('Email a Friend Title','wpShop'),
								"desc" 	=> __('Enter the title you would like to have in place of "Email a Friend About this Item" (inside the overlay that opens when the "Email a Friend" link is clicked)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogEmail_a_friend_title",
								"std" 	=> "Share this Post with a Friend",
								"type" 	=> "text"),
										
					array(		"name" 	=> __('Email a Friend Text','wpShop'),
								"desc" 	=> __('Enter the text you would like to have appear below the "Email a Friend About this Item" title','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_blogEmail_a_friend_text",
								"std" 	=> "",
								"type" 	=> "textarea"),
										
				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),
//###############################################################################################################
		// Tab 7 Image Sizes			
		array (		"type" 	=> "fieldset_start",
					"class" =>"design",
					"id" 	=>"sec_imageSizes_settings"),
							
			array ( 	"name" 	=> __('Image sizes','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),	

					array(    	"name" 	=> __('1 Column with wide Sidebar and Optional Teaser to the right','wpShop'),
								"desc" 	=> __('Do not edit if your css skills are below average as changing the size requires layout changes! Sizes are calculated in px.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prodCol1_img_size",
								"std" 	=> "400",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('2 Columns with narrow Sidebar','wpShop'),
								"desc" 	=> __('Do not edit if your css skills are below average as changing the size requires layout changes! Sizes are calculated in px.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prodCol2n_img_size",
								"std" 	=> "355",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('3 Columns without Sidebar or 2 columns with wide Sidebar','wpShop'),
								"desc" 	=> __('Do not edit if your css skills are below average as changing the size requires layout changes! Sizes are calculated in px.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prodCol3_img_size",
								"std" 	=> "290",
								"type" 	=> "text"),
								
					array(    	"name" 	=> __('3 Columns with narrow Sidebar','wpShop'),
								"desc" 	=> __('Do not edit if your css skills are below average as changing the size requires layout changes! Sizes are calculated in px.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prodCol3n_img_size",
								"std" 	=> "225",
								"type" 	=> "text"),
								
					array(    	"name" 	=> __('3 Columns with wide Sidebar','wpShop'),
								"desc" 	=> __('Do not edit if your css skills are below average as changing the size requires layout changes! Sizes are calculated in px.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prodCol3w_img_size",
								"std" 	=> "181",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('4 Columns with wide Sidebar','wpShop'),
								"desc" 	=> __('Do not edit if your css skills are below average as changing the size requires layout changes! Sizes are calculated in px.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prodCol4_img_size",
								"std" 	=> "127",
								"type" 	=> "text"),
								
					array(    	"name" 	=> __('5 Columns without Sidebar or 4 Columns with narrow Sidebar','wpShop'),
								"desc" 	=> __('Do not edit if your css skills are below average as changing the size requires layout changes! Sizes are calculated in px.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_prodCol5_img_size",
								"std" 	=> "160",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Main Image in Single Product Pages (when 1 image is used)','wpShop'),
								"desc" 	=> __('Do not edit if your css skills are below average as changing the size requires layout changes! Sizes are calculated in px.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_singleProdMain1_img_size",
								"std" 	=> "355",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Main Image in Single Product Pages (when multiple images are used)','wpShop'),
								"desc" 	=> __('Do not edit if your css skills are below average as changing the size requires layout changes! Sizes are calculated in px.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_singleProdMainMulti_img_size",
								"std" 	=> "290",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Image thumbnails in Single Product Pages (when multiple images are used)','wpShop'),
								"desc" 	=> __('Do not edit if your css skills are below average as changing the size requires layout changes! Sizes are calculated in px.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_singleProd_t_img_size",
								"std" 	=> "50",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Product Related, Shopping Basket and Wishlist Product Images','wpShop'),
								"desc" 	=> __('Do not edit if your css skills are below average as changing the size requires layout changes! Sizes are calculated in px.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_ProdRelated_img_size",
								"std" 	=> "81",
								"type" 	=> "text"),
										
				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),
	array (		"type" 	=> "section_end"),
//###############################################################################################################
//###############################################################################################################
/*** 
Shop Settings
***/
array ( 	"name" 	=> __('Shop','wpShop'),
			"type" 	=> "heading",
			"class" =>"shop"),
					
	array (		"type" 	=> "section_start",
				"class" =>"hasadmintabs hasadmintabs2"),					
//###############################################################################################################
		// Tab 1 General
		array (		"type" 	=> "fieldset_start",
					"class" =>"shop",
					"id" 	=>"sec_general_shop_settings"),

			array ( 	"name" 	=> __('General','wpShop'),
						"type" 	=> "title"),

				array (    	"type" 	=> "open"),

					array(   	"name" 	=> __('Shop mode','wpShop'),
								"desc" 	=> __('Select','wpShop')."<b>".__(' "Enquiry email mode" ','wpShop')."</b>".__('if you want the contents of the shopping basket to be collected and be send to you as an Enquiry email instead of redirecting your customers to a payment gateway- otherwise leave on "Regular shop mode".','wpShop')."<br/><b>".__('"Affiliate mode" ','wpShop')."</b>".__('will transform your shop to one selling ONLY affiliate products. Note: If you plan to sell your own products as well as affiliate products you only need to use an additional custom field "buy_now" on your affiliate product posts with the link to the product for the value. So in this case please leave this setting on "Regular Shop Mode"','wpShop')."<br/><b>".__('"PayLoadz mode" ','wpShop')."</b>".__('means that you redirect your customers to PayLoadz when it comes to paying and downloading your digital goods. Can be used if you ONLY sell Digital Goods','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shop_mode",
								"std" 	=> "Regular shop mode",
								"vals" 	=> array(__('Regular shop mode','wpShop')."|Normal shop mode",__('Enquiry email mode','wpShop')."|Inquiry email mode",__('Affiliate mode','wpShop')."|affiliate_mode",__('PayLoadz mode','wpShop')."|payloadz_mode"),
								"type" 	=> "select2"),	
										
					array(  	"name" 	=> __('Open Affiliate Products in new Window or Tab?','wpShop'),
								"desc" 	=> __('Check this setting if you want to open Affiliate Product Links in a new window or tab','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_affili_newTab",
								"type" 	=> "checkbox",
								"std" 	=> "false"),

					array(    	"name" 	=> __('Name','wpShop'),
								"desc" 	=> __('What your shop is called. Usually the same as the Blog-Title you set in WordPress','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shop_name",
								"std" 	=> "The Clothes Shop",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Address','wpShop'),
								"desc" 	=> __('Enter the Shop\'s street address and number','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shop_street",
								"std" 	=> "Some Street 1",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('State / Province','wpShop'),
								"desc" 	=> __('Enter the Shop\'s state / province.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shop_province",
								"std" 	=> "Some State",
								"type" 	=> "text"),

					array(    	"name" 	=> __('Postcode','wpShop'),
								"desc" 	=> __('Enter the Shop\'s Postcode','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shop_zip",
								"std" 	=> "11111",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('City / Town','wpShop'),
								"desc" 	=> __('Enter the Shop\'s City / Town','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shop_town",
								"std" 	=> "Some Town",
								"type" 	=> "text"),
										
					array(  	"name" 	=> __('Country of your Shop','wpShop'),
								"desc" 	=> __('Where the shop is based.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shop_country",
								"type" 	=> "select2",
								"std" 	=> "US",
								"vals" 	=> $countries),	

					array(    	"name" 	=> __('Telephone','wpShop'),
								"desc" 	=> __('Enter the Shop\'s Phone no','wpShop'),
								"id" 	=> "shop_tel_num",
								"std" 	=> "11111",
								"type" 	=> "text"),
										
					array(  	"name" 	=> __('Email of your Shop','wpShop'),
								"desc" 	=> __('Enter the primary email of your shop. Different notifications (new orders etc.) from the system will be send to this email ','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shop_email",
								"type" 	=> "text",
								"std" 	=> ""),	
								
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),
				
			// Currency
			array ( 	"name" 	=> __('Currency Settings','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
										
					// Currency 
					array(  	"name" => __('Currency','wpShop'),
								"desc" => __('Select your currency','wpShop')."<br/><b>".__('Please Note: If you are using PayPal as a Payment Gateway please make sure that your currency is supported (by PayPal) in order to receive payments. ','wpShop')."<a href='https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_currency_codes' target='_blank'>".__('PayPal-Supported Currencies and Currency Codes','wpShop')."</a></b>",
								"id" => $CONFIG_WPS['shortname']."_currency_code",
								"type" => "select",
								"std" => "EUR",
								"vals" => array('AED','AFN','ALL','AMD','ANG','AOA','ARS','AUD','AWG','AZN','BAM','BBD','BDT','BGN','BHD','BIF','BMD','BND','BOB','BRL','BSD',
								'BTN','BWP','BYR','BZD','CAD','CDF','CHF','CLP','CNY','COP','CRC','CUP','CVE','CZK','DJF','DKK','DOP','DZD','EEK','EGP','ERN','ETB','EUR',
								'FJD','FKP','GBP','GEL','GGP','GHS','GIP','GMD','GNF','GTQ','GYD','HKD','HNL','HRK','HTG','HUF','IDR','ILS','IMP','INR','IQD','IRR','ISK',
								'JEP','JMD','JOD','JPY','KES','KGS','KHR','KMF','KPW','KRW','KWD','KYD','KZT','LAK','LBP','LKR','LRD','LSL','LTL','LVL','LYD','MAD','MDL',
								'MGA','MKD','MMK','MNT','MOP','MRO','MTL','MUR','MVR','MWK','MXN','MYR','MZN','NAD','NGN','NIO','NOK','NPR','NZD','OMR','PAB','PEN','PGK',
								'PHP','PKR','PLN','PYG','QAR','RON','RSD','RUB','RWF','SAR','SBD','SCR','SDG','SEK','SGD','SHP','SLL','SOS','SPL','SRD','STD','SVC','SYP',
								'SZL','THB','TJS','TMM','TND','TOP','TRY','TTD','TVD','TWD','TZS','UAH','UGX','USD','UYU','UZS','VEF','VND','VUV','WST','XAF','XAG','XAU',
								'XCD','XDR','XOF','XPD','XPF','XPT','YER','ZAR','ZMK','ZWD')),
										
					array(  	"name" 	=> __('Display the Currency Code','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the Currency Code.(displays last after the price!)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_currency_code_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
										
					array(  	"name" 	=> __('Currency symbol','wpShop'),
								"desc" 	=> __('Enter the symbol for your chosen currency (displays first before the price!) eg.','wpShop')."<b> $ </b>".__('for dollars or','wpShop')."<b> &euro; </b>".__('for euros','wpShop')."<br/><b>".__('Note: Some currencies need to be written in a special code in order to be rendered correctly in the browser so please refer','wpShop')."<a href='http://tlt.its.psu.edu/suggestions/international/web/codehtml.html#currency' target='_blank'>".__(' to this guide ','wpShop')."</a></b>",
								"id" 	=> $CONFIG_WPS['shortname']."_currency_symbol",
								"type" 	=> "text",
								"std" 	=> ""),
								
					array(  	"name" 	=> __('Alternative Currency Code or Symbol','wpShop'),
								"desc" 	=> __('Some countries display a certain code or symbol at the end of prices. Use this setting if you want to add something to display after the price.','wpShop')."<br/><b>".__(' Make sure that you properly encode your symbol so it renders correctly in the browser!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_currency_symbol_alt",
								"type" 	=> "text",
								"std" 	=> ""),
								
					array(    	"name" 	=> __('Price Formating','wpShop'),
								"desc" 	=> __('Prices are formatted differently from country to country. Select the Price Formating fitting to your currency.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_price_format",
								"std" 	=> "2",
								"vals" 	=> array(	__('Decimal seperator with , no divider for thousands','wpShop')."|1",
													__('Decimal seperator with . no divider for thousands','wpShop')."|2",
													__('Decimal seperator with , and . divider for thousands - used e.g in Brazil, Germany','wpShop')."|3",
													__('Decimal seperator with . and , divider for thousands - used e.g in UK, USA','wpShop')."|4",
													__('Decimal seperator with , and divider for thousands whith whitespace - used e.g in France','wpShop')."|5",
													__('Decimal seperator with , and \' divider for thousands - used e.g in Switzerland','wpShop')."|6",
													__('No decimal digits and an empty space as divider for thousands','wpShop')."|7",
													__('No decimal digits and , divider for thousands','wpShop')."|8",
													__('No decimal digits and no divider for thousands','wpShop')."|9"
												),
								"type" 	=> "select2"),
					/*					
					array(  	"name" 	=> __('Display Tax','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the tax information.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_tax_info_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
									
					array(    	"name" 	=> __('Tax Abbreviation','wpShop'),
								"desc" 	=> __('Set the Tax abbr. eg VAT','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_tax_abbr",
								"std" 	=> "VAT",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Tax Percentage','wpShop'),
								"desc" 	=> __('Set the Tax percentage using a number or a decimal number. This is used as information only for your customers. It displays simply as "incl. 19% VAT" next to the product price. The system will NOT add this to the shopping cart total so you will have to calculate and add any VAT costs in your prices!','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_tax_percentage",
								"std" 	=> "",
								"type" 	=> "text"),
					*/
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),
			
			// Tax
			array ( 	"name" 	=> __('Tax Settings','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
											
					"tax_module_data_follows" => array(    	"name" 	=> __('Shop is based in country: ','wpShop'),
								"desc" 	=> "<strong style='font-size: 1.2em;'>".get_countries(2,$OPTION['wps_shop_country'])."</strong><br/><small>".__('If the above field is empty or states the wrong country, make sure you set the Country where you Shop is located (Country of your Shop) and save your settings. Then return here.','wpShop')."</small>",
								"id" 	=> $CONFIG_WPS['shortname']."_tax_country",
								"value" => $OPTION['wps_shop_country'],
								"type" 	=> "text-link"),
								
					1 ,		
					
					// following fields are in there since ages			
					array(  	"name" 	=> __('Display Tax','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the tax information.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_tax_info_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
									
					array(    	"name" 	=> __('Tax Abbreviation','wpShop'),
								"desc" 	=> __('Set the Tax abbr. eg VAT','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_tax_abbr",
								"std" 	=> "VAT",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Tax Percentage','wpShop'),
								"desc" 	=> __('Set the Tax percentage using a number or a decimal number.','wpShop')."<br/><b>".__('Applies only if you have selected "Tax is included in prices" above.','wpShop')."</b><br/>".__('This is used as information only for your customers. It displays simply as "incl. 19%" next to the product price. The system will NOT add this to the shopping cart total so you will have to calculate and add any tax costs in your prices yourself!','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_tax_percentage",
								"std" 	=> "",
								"type" 	=> "text"),

				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),
			
			// Shipping, delivery, payment				
			array ( 	"name" 	=> __('Delivery & Payment Settings','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
				
					
					array(  	"name" 	=> __('Delivery Options','wpShop'),
								"desc" 	=> __('Activate the Delivery Options you want to make available to your customers.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_delivery_options",
								"vals" 	=> array(__('Pick up','wpShop')."|pickup",__('Delivery','wpShop')."|post"), 
								"type" 	=> "multi-checkbox",
								"std" 	=> "false"),

					array(  	"name" 	=> __('"Pick up" Label Text','wpShop'),
								"desc" 	=> __('This will be used for the label text of the "Pick up" Delivery Option','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pickUp_label",
								"type" 	=> "text",
								"std" 	=> "Pick up (&euro;0.00)"),
								
					array(  	"name" 	=> __('"Delivery" Label Text','wpShop'),
								"desc" 	=> __('This will be used for the label text of the "Delivery" Delivery Option','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_delivery_label",
								"type" 	=> "text",
								"std" 	=> "Delivery (2-3 Business Days, Delivery Charges Apply)"),
								
					array(  	"name" 	=> __('"Delivery by Email" Label Text','wpShop'),
								"desc" 	=> __('This will be used for the label text of the "Delivery by Email" Delivery Option','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_emailDelivery_label",
								"type" 	=> "text",
								"std" 	=> "Delivery by Email (Instant after Payment Confirmation, &euro;0.00)"),

										
					array(  	"name" 	=> __('Payment Options','wpShop'),
								"desc" 	=> __('Activate the Payment Options you want to make available to your customers.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_payment_options",
								"vals" 	=> array(__('PayPal Payments Standard','wpShop')."|paypal",__('PayPal Payments Pro (Accept Credit Cards directly on your Website - for US, Canada and UK Merchants)','wpShop')."|paypal_pro",__('Credit Card Payments with Authorize.net (Only for Merchants with a US Bank Account)','wpShop')."|cc_authn",__('Credit Card Payments with WorldPay.com (For International Merchants)','wpShop')."|cc_wp",__('Bank Transfer in Advance','wpShop')."|transfer",__('Payment on Location','wpShop')."|cash",__('Cash on Delivery','wpShop')."|cod"), 
								"type" 	=> "multi-checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Payment Options Preselected','wpShop'),
								"desc" 	=> __('Select the Payment option you will want to show as preselected.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_payment_op_preselected",
								"vals"  => array(__('Cash on Location','wpShop')."|cash",
								__('Creditcard Authorize.net','wpShop')."|cc_authn",
								__('Creditcard WorldPay','wpShop')."|cc_wp",
								__('Cash on Delivery','wpShop')."|cod",
								__('Paypal','wpShop')."|paypal",
								__('Paypal Pro','wpShop')."|paypal_pro",
								__('Bank Transfer','wpShop')."|transfer",
								__('None','wpShop')."|none"
								),
								"type" 	=> "select2",
								"std" 	=> "none"),	
								
					array(  	"name" 	=> __('"PayPal Payments Standard" Label Text','wpShop'),
								"desc" 	=> __('This will be used for the label text of the "PayPal Payments Standard" Payment Option','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pps_label",
								"type" 	=> "text",
								"std" 	=> "PayPal (PayPal Payments Standard)"),
								
					array(  	"name" 	=> __('"PayPal Payments Pro" Label Text','wpShop'),
								"desc" 	=> __('This will be used for the label text of the "PayPal Payments Pro" Payment Option','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_ppp_label",
								"type" 	=> "text",
								"std" 	=> "Credit Card (PayPal Payments Pro)"),
								
					array(  	"name" 	=> __('"Authorize.net" Label Text','wpShop'),
								"desc" 	=> __('This will be used for the label text of the "Authorize.net" Payment Option','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_auth_label",
								"type" 	=> "text",
								"std" 	=> "Credit Card (Authorize.net)"),
								
					array(  	"name" 	=> __('"WorldPay.com" Label Text','wpShop'),
								"desc" 	=> __('This will be used for the label text of the "WorldPay.com" Payment Option','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_wp_label",
								"type" 	=> "text",
								"std" 	=> "Credit Card (WorldPay.com)"),
								
					array(  	"name" 	=> __('"Bank Transfer" Label Text','wpShop'),
								"desc" 	=> __('This will be used for the label text of the "Bank Transfer" Payment Option','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_bt_label",
								"type" 	=> "text",
								"std" 	=> "Bank Transfer"),
								
					array(  	"name" 	=> __('"Cash on Delivery" Label Text','wpShop'),
								"desc" 	=> __('This will be used for the label text of the "Cash on Delivery" Payment Option','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_cod_label",
								"type" 	=> "text",
								"std" 	=> "Cash on Delivery"),
								
					array(  	"name" 	=> __('"Payment on Location" Label Text','wpShop'),
								"desc" 	=> __('This will be used for the label text of the "Payment on Location" Payment Option','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pol_label",
								"type" 	=> "text",
								"std" 	=> "Payment on Location"),
										
										
					array(    	"name" 	=> __('SSL for checkout?','wpShop'),
								"desc" 	=> __('If you want the Checkout process to run over the secure SSL Protocol, select "Yes". This requires that SSL is enabled for your domain. To find out if it is, simply replace http:// with https:// in the url and see if your web contents still appear.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_enforce_ssl",
								"std" 	=> "normal",
								"vals" 	=> array(__('No','wpShop')."|normal",__('Yes','wpShop')."|force_ssl"),
								"type" 	=> "select2"),
								
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),
			
			// Custom Note & Terms & Conditions				
			array ( 	"name" 	=> __('Vouchers, Custom Note in Order Checkout, Terms & Conditions  (Order Checkout Steps 1, 2)','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
				
					array(  	"name" 	=> __('Activate Voucher / Coupon Codes','wpShop'),
								"desc" 	=> __('Check this setting if you plan on giving out voucher codes.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_voucherCodes_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Request Customer Telephone Number in Checkout Step 2','wpShop'),
								"desc" 	=> __('If you select Yes, then one extra telephone input field is shown in the checkout form.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_checkout_showtel",
								"std" 	=> "No",
								"vals" 	=> array("No", "Yes"),
								"type" 	=> "select"),
				
					array(  	"name" 	=> __('Activate "Custom Note"','wpShop'),
								"desc" 	=> __('Check this setting if you want to give your customers the option to add a "Custom Note" to an order.','wpShop')."<br/><b>".__('Note: This will display a single textarea in Step 2 of the checkout process. Any text entered by the customer refers to the entire order. If you want Product Personalization (textareas and / or text inputs on a per product basis) please use the appropriate custom fields as described in the product custom fields PDF provided in the Documentation','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_customNote_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
						
					array(  	"name" 	=> __('"Custom Note" Label Text','wpShop'),
								"desc" 	=> __('This will be used for the label text of the textarea','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_customNote_label",
								"type" 	=> "text",
								"std" 	=> "Custom Note"),
								
					array(  	"name" 	=> __('"Custom Note" Additional Text','wpShop'),
								"desc" 	=> __('If you want to provide any further info to your customers regarding the use of the "Custom Note" field use the textarea here.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_customNote_remark",
								"type" 	=> "textarea",
								"std" 	=> "This optional custom note can be used to send a message to the Shop Merchant or as a personal note to be delivered along with the order eg. when an order is a gift to someone."),
										
					array(  	"name" 	=> __('Your terms &amp; conditions','wpShop'),
								"desc" 	=> __('Enter the terms and conditions, your customers must agree to before ordering.','wpShop')."<br/>".__('This is wrapped in a div html element so feel free to use headings (h4, h5) and paragraphs (p) for better control on the text formatting','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_terms_conditions",
								"type" 	=> "textarea",
								"std" 	=> "Our terms & conditions are..."),
								
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),			
		array (		"type" 	=> "fieldset_end"),	
//###############################################################################################################
		//Tab 2 Inventory			
		array (		"type" 	=> "fieldset_start",
					"class" =>"shop",
					"id" 	=>"sec_inventory_settings"),
							
			array ( 	"name" 	=> __('Inventory','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),

					array(  	"name" 	=> __('Activate Stock Control','wpShop'),
								"desc" 	=> __('Select "yes" if you want to keep track of your Product Stock. You can then manage your Inventory from the link that will appear at the top of this page after activation.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_track_inventory",
								"std" 	=> "not_active",
								"vals" 	=> array(__('Yes','wpShop')."|active",__('No','wpShop')."|not_active"),
								"type" 	=> "select2"),

					array(  	"name" 	=> __('Display Stock Amounts','wpShop'),
								"desc" 	=> __('Select "yes" if you want to display the "Stock on Hand" of each product.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_display_product_amounts",
								"std" 	=> "not_active",
								"vals" 	=> array(__('Yes','wpShop')."|active",__('No','wpShop')."|not_active"),
								"type" 	=> "select2"),

					array(  	"name" 	=> __('Sold-out Notice','wpShop'),
								"desc" 	=> __('Enter the notice that is to be displayed when a product is sold out.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_soldout_notice",
								"std" 	=> "SOLD OUT",
								"type" 	=> "text"),	
				
					array(  	"name" 	=> __('Cleaning time interval','wpShop'),
								"desc" 	=> __('The shop has a routine to return "abandoned" items into the inventory. Here you select the time interval when this should happen here. Below you will be asked to select the method.','wpShop')."<br/><b>".__('"Abandoned items" can be for example items that customers added in their Shopping Baskets but never went through or completed the Checkout.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_inventory_cleaning_interval",
								"type" 	=> "select2",
								"std" 	=> "14400",
								"vals" 	=> array(__('5 minutes','wpShop')."|300", __('10 minutes','wpShop')."|600", __('1 hour','wpShop')."|3600",__('2 hours','wpShop')."|7200",__('4 hours','wpShop')."|14400",
								__('8 hours','wpShop')."|28800",__('16 hours','wpShop')."|57600",__('24 hours','wpShop')."|86400",__('48 hours','wpShop')."|172800",__('72 hours','wpShop')."|259200",__('96 hours','wpShop')."|345600")),
								
					array(  	"name" 	=> __('Cleaning method','wpShop'),
								"desc" 	=> __('For calling the inventory cleaning routine you can either use a Cronjob or an internal function.','wpShop')."<br/><b>".__('The Internal function is programmed to be called once when the Frontpage is "requested" for the first time.','wpShop')."</b><br/><b>".__('If you have high trafic then a','wpShop')."<a target='_blank' href='http://faq.1and1.com/what_is_/32.html'>".__(' "Cronjob" ','wpShop')."</a>".__('is a better choice for performance reasons. Contact your host for more information.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_inventory_cleaning_method",
								"std" 	=> "internal",
								"vals" 	=> array(__('Cronjob','wpShop')."|cronjob",__('Internal','wpShop')."|internal"),
								"type" 	=> "select2"),
				
					array(  	"name" 	=> __('Low-Stock Alert Threshold','wpShop'),
								"desc" 	=> __('You will receive a Low-Stock Alert Email if the stock of a product reaches this amount.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_stock_warn_threshold",
								"std" 	=> "2",
								"type" 	=> "text"),		

					array(  	"name" 	=> __('Low-Stock Alert Email','wpShop'),
								"desc" 	=> __('The Low-Stock Alert Email will be sent to this email address.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_stock_warn_email",
								"std" 	=> "",
								"type" 	=> "text"),					

				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),	
//###############################################################################################################    
		//Tab 3 Digital Products			
		array (		"type" 	=> "fieldset_start",
					"class" =>"shop",
					"id" 	=>"sec_digiProds_settings"),
							
			array ( 	"name" 	=> __('Digital Products','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
						
					array(  	"name" 	=> __('Path to Master Data Directory','wpShop'),
								"desc" 	=> __('This is the path to your master data directory, please copy what is given to you here and paste it above without any whitespaces: ','wpShop')."<b>$masterpath</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_master_dir",
								"type" 	=> "text",
								"std" 	=> "../path/to/masterdata/"),

					array(  	"name" 	=> __('Licensing mode','wpShop'),
								"desc" 	=> __('Select your Licensing Mode. ','wpShop')."<br/><b>".__('SIMPLE','wpShop')."</b>".__(' means: your customers do not get a license key with your product. ','wpShop')."<br/><b>".__('GIVE_KEYS','wpShop')."</b>".__(' means: you provide licence keys for your digital products.','wpShop')."<br/>".__('What kind of keys these will be and how your product uses them is upto you and your software. We have just provided the ability for your customers to receive one licence key per digital product purchased','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_l_mode",
								"type" 	=> "select",
								"std" 	=> "SIMPLE",
								"vals" 	=> array("SIMPLE", "GIVE_KEYS")),
										
					array(  	"name" 	=> __('License Key Warning threshold','wpShop'),
								"desc" 	=> __('Enter the minimum number of unused License keys at which point an email reminder will be send to you.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_lkeys_warn_num",
								"type" 	=> "text",
								"std" 	=> "30"),

					array(  	"name" 	=> __('Download Link Duration','wpShop'),
								"desc" 	=> __('Select the time after which download links will become invalid or removed.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_duration_links",
								"type" 	=> "select2",
								"std" 	=> "300",
								"vals" 	=> array(__('5 minutes','wpShop')."|300", __('10 minutes','wpShop')."|600", __('1 hour','wpShop')."|3600",__('2 hours','wpShop')."|7200",__('4 hours','wpShop')."|14400",
								__('8 hours','wpShop')."|28800",__('16 hours','wpShop')."|57600",__('24 hours','wpShop')."|86400",__('48 hours','wpShop')."|172800",__('72 hours','wpShop')."|259200")),
					
					array(  	"name" 	=> __('Display short Address Form','wpShop'),
								"desc" 	=> __('Activating this setting shortens the Address Form (in step 2 in Checkout) to just Name &amp; Email. This will take effect only when digital products are in the basket.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_short_addressform",
								"type" 	=> "select2",
								"std" 	=> "not_active",
								"vals" 	=> array(__('Active','wpShop')."|active", __('Not active','wpShop')."|not_active")),
						
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),			
		array (		"type" 	=> "fieldset_end"),							
//###############################################################################################################
		//Tab 4 Payloadz			
		array (		"type" 	=> "fieldset_start",
					"class" =>"shop",
					"id" 	=>"sec_payloadz_settings"),
							
			array ( 	"name" 	=> __('PayLoadz','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),

					array(    	"name" 	=> __('View cart - ID','wpShop'),
								"desc" 	=> __('PayLoadz provides this under "CodeGenerator" &gt; "View Cart" Code.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_payloadz_viewcart_id",
								"std" 	=> "1234567890",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('View-Cart Link option','wpShop'),
								"desc" 	=> __('"View Cart" can be shown as an image or text link.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_payloadz_viewcart_option",
								"std" 	=> "img",
								"vals" 	=> array(__('Image','wpShop')."|img",__('Text link','wpShop')."|tl"),
								"type" 	=> "select2"),
										
					array(    	"name" 	=> __('View-Cart Image Link','wpShop'),
								"desc" 	=> __('If you have selected an image for your "View-Cart" link, you can change the url to point to a different button (graphic).','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_payloadz_viewcart_imglink",
								"std" 	=> 'https://www.payloadz.com/images/viewcart.gif',
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Add-2-Cart Link option','wpShop'),
								"desc" 	=> __('"Add to Cart" can be shown as an image or text link.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_payloadz_addcart_option",
								"std" 	=> "img",
								"vals" 	=> array(__('Image','wpShop')."|img",__('Text link','wpShop')."|tl"),
								"type" 	=> "select2"),
										
					array(    	"name" 	=> __('Add-2-Cart Image Link','wpShop'),
								"desc" 	=> __('If you have selected an image for your "Add-to-Cart" link, you can change the url to point to a different button (graphic).','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_payloadz_addcart_imglink",
								"std" 	=> 'http://www.paypal.com/images/x-click-but22.gif',
								"type" 	=> "text"),
										
				array(    	"type" 	=> "close"),
			array(   	"type" => "close"),			
		array (		"type" 	=> "fieldset_end"),	
//###############################################################################################################  			
		//Tab 5 Payloadz			
		array (		"type" 	=> "fieldset_start",
					"class" =>"shop",
					"id" 	=>"sec_paypal_settings"),
							
			array ( 	"name" 	=> __('Paypal','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),

					array(    	"name" 	=> __('Email','wpShop'),
								"desc" 	=> __('Enter your email -it must be the SAME AS the one you use in your PayPal account!','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_paypal_email",
								"std" 	=> "",
								"type" 	=> "text"),										

								
					array(    	"name" 	=> __('PDT-Identity Token','wpShop'),
								"desc" 	=> __('Enter your Payment Data Transfer (PDT) Identity Token here - available in your PayPal account (Premier or Business) ','wpShop')."- <a href='https://www.paypal.com/cgi-bin/customerprofileweb?cmd=_profile-website-payments' target='_blank'>".__('PayPal direct link (you need to be logged in)','wpShop')."</a>",
								"id" 	=> $CONFIG_WPS['shortname']."_paypal_pdttoken",
								"std" 	=> "",
								"type" 	=> "text"),
					

					array(    	"name" 	=> __('PayPal Encode Key','wpShop'),
								"desc" 	=> __('This is used for additional security on transactions. Set a word string of your own.','wpShop')."<br/><b>".__('You may use letters and numbers but not whitespaces and no symbols!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_paypal_encode_key",
								"std" 	=> "HastaLaVista",
								"type" 	=> "text"),	
										
					array(    	"name" 	=> __('Path: Return Url','wpShop'),
								"desc" 	=> __('Enter this in your PayPal account under "Profile > Website Payment Preferences > Return Url"','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_confirm_url",
								"std" 	=> get_option('home') . '/?confirm=1',
								"type" 	=> "pathinfo"),

					array(    	"name" 	=> __('Path: IPN Notification Url','wpShop'),
								"desc" 	=> __('Enter this in your PayPal account under "Profile > Instant Payment Notification Preferences > Notification Url"','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_ipn_url", 	
								"vals" 	=> get_option('siteurl') . '/wp-content/themes/'. $CONFIG_WPS['themename'] .'/ipn.php?pst='.md5(LOGGED_IN_KEY.'-'.NONCE_KEY),
								"type" 	=> "pathinfo2"),
				
				array(   	"type" => "close"),
			array(   	"type" => "close"),

			array( 		"name" => __('Paypal PRO','wpShop'),
						"type" => "title"),
								
				array(    	"type" => "open"),
									
					array(    	"name" => __('API username','wpShop'),
								"desc" => __('Enter your API username.','wpShop'),
								"id" => $CONFIG_WPS['shortname']."_paypal_api_user",
								"std" => "",
								"type" => "text"),
										
					array(    	"name" => __('API password','wpShop'),
								"desc" => __('Enter your API password.','wpShop'),
								"id" => $CONFIG_WPS['shortname']."_paypal_api_pw",
								"std" => "",
								"type" => "text"),					
										
					array(    	"name" => __('API signature','wpShop'),
								"desc" => __('Enter your API signature.','wpShop'),
								"id" => $CONFIG_WPS['shortname']."_paypal_api_signature",
								"std" => "",
								"type" => "text"),
							
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
		array (		"type" 	=> "fieldset_end"),			
//###############################################################################################################		
		//Tab 6 Authorize.net			
		array (		"type" 	=> "fieldset_start",
					"class" =>"shop",
					"id" 	=>"sec_authorize_settings"),
							
			array ( 	"name" 	=> __('Authorize.net','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
				
					array(    	"name" 	=> __('API Login','wpShop'),
								"desc" 	=> __('Enter your API Login provided by Authorize.net','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_authn_api_login",
								"std" 	=> "",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Transaction Key','wpShop'),
								"desc" 	=> __('Enter the transaction Key you received from Authorize.net','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_authn_transaction_key",
								"std" 	=> "",
								"type" 	=> "text"),					
										
					array(    	"name" 	=> __('Url','wpShop'),
								"desc" 	=> __('Change to "https://secure.authorize.net/gateway/transact.dll" when you are ready to go ','wpShop')."<b>".__('live/public','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_authn_url",
								"std" 	=> "https://test.authorize.net/gateway/transact.dll",
								"vals" 	=> array("https://secure.authorize.net/gateway/transact.dll","https://test.authorize.net/gateway/transact.dll"),
								"type" 	=> "select"),	
										
					array(    	"name" 	=> __('Test-Request','wpShop'),
								"desc" 	=> __('Change to "true" if you want to test your ','wpShop')."<b>".__('live/public','wpShop')."</b>".__(' Authorize.net account - otherwise leave on "false".','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_authn_test_request",
								"std" 	=> "false",
								"vals" 	=> array("false","true"),
								"type" 	=> "select"),

					array(    	"name" 	=> __('CIM Url','wpShop'),
								"desc" 	=> __('Change to "api.authorize.net" when you are ready to go ','wpShop')."<b>".__('live/public','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_authn_cim_url_host",
								"std" 	=> "testapi.authorize.net",
								"vals" 	=> array("apitest.authorize.net","api.authorize.net"),
								"type" 	=> "select"),	

					array(    	"name" 	=> __('CIM Api path','wpShop'),
								"desc" 	=> __('CIM Api Path ','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_authn_cim_url_path",
								"std" 	=> "/xml/v1/request.api",
								"vals" 	=> array("/xml/v1/request.api"),
								"type" 	=> "select"),
									
				array(   	"type" => "close"),	
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),	
//############################################################################################################### 
		//Tab 7 WorldPay			
		array (		"type" 	=> "fieldset_start",
					"class" =>"shop",
					"id" 	=>"sec_worldpay_settings"),
							
			array ( 	"name" 	=> __('WorldPay','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),

					array(    	"name" 	=> __('Installation-ID','wpShop'),
								"desc" 	=> __('Enter the installation id you have received from WorldPay.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_wpay_instId",
								"std" 	=> "1234",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Testmode','wpShop'),
								"desc" 	=> __('Ready to go live/public with WorldPay? Change this value to "false".','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_wpay_testmode",
								"std" 	=> "true",
								"vals" 	=> array("false","true"),
								"type" 	=> "select"),					
									
					array(    	"name" 	=> __('Payment Response Url','wpShop'),
								"desc" 	=> __('Enter this url as described here:','wpShop').' '."<a target='_blank' href='http://www.rbsworldpay.com/support/kb/bg/paymentresponse/pr5101.html'>http://www.rbsworldpay.com/support/kb/bg/paymentresponse/pr5101.html</a>",
								"id" 	=> $CONFIG_WPS['shortname']."_wp_callback_url", 	
								"vals" 	=> get_option('siteurl').'/wpay.php?pst='.md5(LOGGED_IN_KEY.'-'.NONCE_KEY),
								"type" 	=> "pathinfo2"),
										
				array(   	"type" => "close"),
			array(   	"type" => "close"),			
		array (		"type" 	=> "fieldset_end"),	
//###############################################################################################################
		//Tab 8 Bank Transfer			
		array (		"type" 	=> "fieldset_start",
					"class" =>"shop",
					"id" 	=>"sec_banktransfer_settings"),
							
			array ( 	"name" 	=> __('Bank Transfer','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),

					array(    	"name" 	=> __('Name of Bank','wpShop'),
								"desc" 	=> __('Enter the name of your Bank.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_banktransfer_bankname",
								"std" 	=> "",
								"type" 	=> "text"),
								
					array(  	"name" 	=> __('Display Routing Number','wpShop'),
								"desc" 	=> __('Check this setting if you want to display your Bank\'s Routing Number','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_banktransfer_routing_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Routing Number Text','wpShop'),
								"desc" 	=> __('Here you can enter the Routing number text or initials commonly used in your country.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_banktransfer_routing_text",
								"std" 	=> "Routing Number",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Routing Number','wpShop'),
								"desc" 	=> __('Enter your Bank\'s Routing number','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_banktransfer_bankno",
								"std" 	=> "",
								"type" 	=> "text"),					
										
					array(    	"name" 	=> __('Account Number','wpShop'),
								"desc" 	=> __('Enter your Bank Account Number.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_banktransfer_accountno",
								"std" 	=> "",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Bank Account Owner','wpShop'),
								"desc" 	=> __('Enter the name of the person/company/institution who is the official Owner of the Bank Account.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_banktransfer_account_owner",
								"std" 	=> "",
								"type" 	=> "text"),

					array(    	"name" 	=> __('IBAN','wpShop'),
								"desc" 	=> __('Enter your IBAN code. Leave empty if not needed.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_banktransfer_iban",
								"std" 	=> "",
								"type" 	=> "text"),					
										
					array(    	"name" 	=> __('BIC/SWIFT','wpShop'),
								"desc" 	=> __('Enter your BIC code - also called SWIFT. Leave empty if not needed.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_banktransfer_bic",
								"std" 	=> "",
								"type" 	=> "text"),
										
										
					array(    	"name" 	=> __('Url to your Online Banking','wpShop'),
								"desc" 	=> __('Enter here your Url to your Online Banking in the form of www.bank.com - makes checking your bank account a bit easier.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_online_banking_url",
								"std" 	=> "www.bankofengland.co.uk",
								"type" 	=> "text"),					

				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),			
//###############################################################################################################
		//Tab 8 Cash on Delivery			
		array (		"type" 	=> "fieldset_start",
					"class" =>"shop",
					"id" 	=>"sec_cashOnDelivery_settings"),
							
			array ( 	"name" 	=> __('Cash on Delivery','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),

					array(    	"name" 	=> __('Delivery service','wpShop'),
								"desc" 	=> __('Enter the name of the company who will do the cash on delivery service for you. It will be added to the delivery options for your customers to select.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_cod_service",
								"std" 	=> "Deutsche Bundespost",
								"type" 	=> "text"),
										
					array(    	"name" 	=> __('Delivery Service 2','wpShop'),
								"desc" 	=> __('A large Delivery Company may offer more than one delivery option. Here you may specify which one. Leave empty if not using.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_cod_who_note",
								"std" 	=> "Deutsche Bundespost",
								"type" 	=> "text"),

				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),		
//###############################################################################################################
		//Tab 9 Shipping			
		array (		"type" 	=> "fieldset_start",
					"class" =>"shop",
					"id" 	=>"sec_shipping_settings"),
							
			array ( 	"name" 	=> __('Shipping','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),

					array(  	"name" 	=> __('Shipping Calculation Options','wpShop'),
								"desc" 	=> __('Select your Shipping Calculation Method.','wpShop')."<br/><br/><b>".__('FREE: ','wpShop')."</b>".__('what it says. Shipping is free regardless of item number or weight','wpShop')."<br/><br/><b>".__('FLAT: ','wpShop')."</b>".__('a one time fee aplied regardless of item number or weight','wpShop')."<br/><br/><b>".__('FLAT_LIMIT: ','wpShop')."</b>".__('same as FLAT above with the only difference that for orders above a certain value shipping is free (you will be asked to set this value later on)','wpShop')."<br/><br/><b>".__('WEIGHT_FLAT: ','wpShop')."</b>".__('a set fee amount per kilogramm (the only acceptable weight meassurement for now). Using this option will mean that you need to set the weight in gramms eg. 500 for each product using the custom field "item_weight"','wpShop')."<br/><br/><b>".__('WEIGHT_CLASS: ','wpShop')."</b>".__('a different fee amount applied to different weight classes. Using this option will means that you need to set the weight in gramms eg. 500 for each product using the custom field "item_weight','wpShop')."<br/><br/><b>".__('PER_ITEM: ','wpShop')."</b>".   __('a fee applied according to item number in cart','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_method",
								"type" 	=> "select",
								"std" 	=> "FLAT",
								"vals" 	=> array("FREE", "FLAT", "FLAT_LIMIT", "WEIGHT_FLAT", "WEIGHT_CLASS", "PER_ITEM")),
										
					array(  	"name" 	=> __('FLAT - Parameters','wpShop'),
								"desc" 	=> __('Enter a flat-rate shipping fee using the format 0.00','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_flat_parameter",
								"type" 	=> "text",
								"std" 	=> "5.00"),

					array(  	"name" 	=> __('FLAT_LIMIT - Parameters','wpShop'),
								"desc" 	=> __('Enter a flat-rate shipping fee &amp; the amount limit for free shipping in the format 0.00|0.00.','wpShop')."<br/><br/>".__('Eg. 4.00|40.00 means that:','wpShop')."<br/>".__('Shipping &amp; Handling of 4.00 EUR (if currency is set to euros) is charged on all orders and is free on orders over 40.00 EUR (if currency is set to euros)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_flatlimit_parameter",
								"type" 	=> "text",
								"std" 	=> "4.00|40.00"),

					array(  	"name" 	=> __('Weight Meassurement Unit','wpShop'),
								"desc" 	=> __('Select your Weight Meassurement Unit','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_meassuring_unit",
								"type" 	=> "select",
								"std" 	=> "grams",
								"vals" 	=> array("grams", "pounds")),

					array(  	"name" 	=> __('WEIGHT_FLAT- Parameters','wpShop'),
								"desc" 	=> __('Enter the shipping fee per kg (for metric) / lb (for avoirdupois) using the format 0.00','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_weightflat_parameter",
								"type" 	=> "text",
								"std" 	=> "1.00"),

					array(  	"name" 	=> __('WEIGHT_CLASS - Parameters','wpShop'),
								"desc" 	=> __('SEPERATE the weight_classes from the amount using | as shown.','wpShop')."<br/>".__(' SEPERATE each weight class &amp; fee amount from the next with # as shown.','wpShop')."<br/><b>".__(' DO NOT LEAVE EMPTY SPACES!! ','wpShop')."</b><br/>".__('You can have as many weight classes as you want.','wpShop')."<br/><br/>".__('Eg.','wpShop')." 0-10|5#11-15|8#16-ul|15 ".__('means that:','wpShop')."<br/>".__('From 0-10 kg (for metric) / lb (for avoirdupois) the shipping fee is 5 EUR (if the currency is set to euros)','wpShop')."<br/><br/>".__('From 11-15 kg (for metric) / lb (for avoirdupois) the shipping fee is 8 EUR (if the currency is set to euros)','wpShop')."<br/><br/>".__('From 16-unlimited kg (for metric) / lb (for avoirdupois) the shipping fee is 15 EUR (if the currency is set to euros)','wpShop')."<br/><br/>".__('ul stands for: unlimited.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_weightclass_parameter",
								"type" 	=> "text",
								"std" 	=> "0-10|5#11-15|8#16-ul|15"),
										
					array(  	"name" 	=> __('PER_ITEM - Parameters','wpShop'),
								"desc" 	=> __('Enter the shipping fee per item in the format 0.00','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_peritem_parameter",
								"type" 	=> "text",
								"std" 	=> "1.00"),
								
					array(  	"name" 	=> __('Free Shipping Categories','wpShop'),
								"desc" 	=> __('Enter the category IDs whose products will have free shipping. Separate multiple IDs with a comma.','wpShop')."<br/><strong>".__('Note: The Shipping will be free when the shopping cart contains products only from the free shipping categories. If the shopping cart is mixed then the selected Shipping Calculation Option will apply','wpShop')."</strong>",
								"id" 	=> $CONFIG_WPS[shortname]."_free_shipping_categories",
								"type" 	=> "text",
								"std" 	=> ""),
								
				array(   	"type" => "close"),
			array(   	"type" => "close"),
								
			// International Shipping Settings					
			array ( 	"name" 	=> __('International Shipping Settings','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),	
										
					array(  	"name" 	=> __('Assign Country Zones','wpShop'),
								"desc" 	=> __('Give countries a zone number. Don\'t forget to hit the "Save" button at the end of the iFrame!','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_country_zones",
								"type" 	=> "iframe",
								"vals" 	=> "../wp-content/themes/".$CONFIG_WPS['themename']."/shop-country-zones.php",
								"std" 	=> ""),		
										
					array(  	"name" 	=> __('Zone 1','wpShop'),
								"desc" 	=> __('Zone 1 is the country your shop is based - identical with what you entered in the "Shop Country" setting under "Shop > General".','wpShop'),
								"id" 	=> "$zone1",
								"type" 	=> "pathinfo",
								"std" 	=> "0.00"),
										
					array(  	"name" 	=> __('Zone 2','wpShop'),
								"desc" 	=> __('Enter the additional shipping fee amount for an order send to this country zone.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_zone2_addition",
								"type" 	=> "text",
								"std" 	=> "2.00"),
										
					array(  	"name" 	=> __('Zone 3','wpShop'),
								"desc" 	=> __('Enter the additional shipping fee amount for an order send to this country zone.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_zone3_addition",
								"type" 	=> "text",
								"std" 	=> "3.00"),
										
					array(  	"name" 	=> __('Zone 4','wpShop'),
								"desc" 	=> __('Enter the additional shipping fee amount for an order send to this country zone.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_zone4_addition",
								"type" 	=> "text",
								"std" 	=> "4.00"),
										
					array(  	"name" 	=> __('Zone 5','wpShop'),
								"desc" 	=> __('Enter the additional shipping fee amount for an order send to this country zone.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_zone5_addition",
								"type" 	=> "text",
								"std" 	=> "5.00"),
										
					array(  	"name" 	=> __('Zone 6','wpShop'),
								"desc" 	=> __('Enter the additional shipping fee amount for an order send to this country zone.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_shipping_zone6_addition",
								"type" 	=> "text",
								"std" 	=> "6.00"),
						
				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),		
//###############################################################################################################
		//Tab 10 Emails			
		array (		"type" 	=> "fieldset_start",
					"class" =>"shop",
					"id" 	=>"sec_email_settings"),
							
			array ( 	"name" 	=> __('Order Confirmation Emails','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
				
					array(  	"name" 	=> __('Order Number Prefix','wpShop'),
								"desc" 	=> __('Order Confirmation Emails are send after each succesful order and are given a number starting from 1. Enter a prefix here if you want to.','wpShop')."<br/><b>".__('You may use numbers as well as letters and symbols. Please avoid empty spaces.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_order_no_prefix",
								"type" 	=> "text",
								"std" 	=> "1000"),
			
					array(  	"name" 	=> __('Email-Logo','wpShop'),
								"desc" 	=> __('You can have your own logo on the html emails send to your customers. Enter the name of your logo image file - must saved in the Parent theme &gt; images &gt; logo folder inside the parent theme.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_email_logo",
								"type" 	=> "text",
								"std" 	=> "email-logo.jpg"),		
						
					array(  	"name" 	=> __('Email-Header Txt-Mail','wpShop'),
								"desc" 	=> __('The shop will sent notification emails as text emails to you. Here you can change the header text of these emails.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_email_txt_header",
								"type" 	=> "textarea",
								"std" 	=> "The Clothes Shop"),
										
					array(  	"name" 	=> __('Email Delivery Type','wpShop'),
								"desc" 	=> __('By default this value is mime. Should there be problems with the email display, please select the "txt" option','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_email_delivery_type",
								"type" 	=> "select",
								"std" 	=> "mime",
								"vals" 	=> array("mime", "txt")),
								
					array(  	"name" 	=> __('Send a copy of the customer confirmation mail to merchant?','wpShop'),
								"desc" 	=> __('Select YES if you like to receive a dublicate of the confirmation email sent to the customer. Please note that the merchant already receives an email informing him that a new order had been placed! This email will be in addition.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_email_confirmation_dbl",
								"type" 	=> "select",
								"std" 	=> "mime",
								"vals" 	=> array("no", "yes")),

				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),	
//###############################################################################################################
//Tab 11 PDF			
		array (		"type" 	=> "fieldset_start",
					"class" =>"shop",
					"id" 	=>"sec_pdf_settings"),
							
			array ( 	"name" 	=> __('PDF / HTML Invoices &amp; Vouchers','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
				
					
					array(  	"name" 	=> __('PDF / HTML Invoice Prefix','wpShop'),
								"desc" 	=> __('PDF / HTML Invoices are generated after each succesful order for your customers to download Enter the Document prefix here.','wpShop')."<br/><b>".__('Please avoid empty spaces and do not end with an underscore or hyphen!','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_invoice_prefix",
								"type" 	=> "text",
								"std" 	=> "Invoice"),
				
					array(  	"name" 	=> __('PDF / HTML Invoice Number Prefix','wpShop'),
								"desc" 	=> __('PDF / HTML Invoices are generated after each succesful order for your customers to download and are given a number starting from 1. Enter a prefix here if you want to.','wpShop')."<br/><b>".__('You may use numbers as well as letters and symbols. Please avoid empty spaces.','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_invoice_no_prefix",
								"type" 	=> "text",
								"std" 	=> "20100"),
								
					array(  	"name" 	=> __('Display Invoice Number?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the Invoice Number on the generated PDF','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_PDF_invoiceNum_enable",
								"type" 	=> "checkbox",
								"std" 	=> "true"),
								
					array(  	"name" 	=> __('Invoice Number Label','wpShop'),
								"desc" 	=> __('Enter Invoice Label','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_PDF_invoiceLabel",
								"type" 	=> "text",
								"std" 	=> "Invoice-No.:"),
								
					array(  	"name" 	=> __('Invoice Number Label alignment','wpShop'),
								"desc" 	=> __('Select the text alignment','wpShop')."<br/><b>".__('Note: L stands for Left, C for Center and R for Right','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_PDF_invoiceLabel_align",
								"std" 	=> "L",
								"vals" 	=> array("L", "C", "R"),
								"type" 	=> "select"),
								
					array(  	"name" 	=> __('Display Order Number?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the Order Number on the generated PDF','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_PDF_orderNum_enable",
								"type" 	=> "checkbox",
								"std" 	=> "true"),
								
					array(  	"name" 	=> __('Order Number Label','wpShop'),
								"desc" 	=> __('Enter Order Label','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_PDF_orderLabel",
								"type" 	=> "text",
								"std" 	=> "Order-No.:"),
								
					array(  	"name" 	=> __('Order Number Label alignment','wpShop'),
								"desc" 	=> __('Select the text alignment','wpShop')."<br/><b>".__('Note: L stands for Left, C for Center and R for Right','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_PDF_orderLabel_align",
								"std" 	=> "L",
								"vals" 	=> array("L", "C", "R"),
								"type" 	=> "select"),
		
					array(  	"name" 	=> __('Display Order Tracking ID?','wpShop'),
								"desc" 	=> __('Check this setting if you want to display the Order Tracking ID on the generated PDF','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_PDF_trackID_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Order Tracking ID Label','wpShop'),
								"desc" 	=> __('Enter Order Tracking Label','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_PDF_trackLabel",
								"type" 	=> "text",
								"std" 	=> "Tracking-ID:"),
								
					array(  	"name" 	=> __('Order Tracking ID Label alignment','wpShop'),
								"desc" 	=> __('Select the text alignment','wpShop')."<br/><b>".__('Note: L stands for Left, C for Center and R for Right','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_PDF_trackLabel_align",
								"std" 	=> "L",
								"vals" 	=> array("L", "C", "R"),
								"type" 	=> "select"),
								
					array(  	"name" 	=> __('VAT-ID Label','wpShop'),
								"desc" 	=> __('Enter the fitting label for the VAT-ID below. In e.g. Germany this could be "Steuernummer" or "USt-ID-Nr."','wpShop')."<br/><b>".__('Note: In some countries like Germany, the Law requires this to appear on Business Invoices. It will display attached to your Shop\'s Name in the PDF Footer','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_vat_id_label",
								"type" 	=> "text",
								"std" 	=> ""),	
										
					array(  	"name" 	=> __('VAT-ID','wpShop'),
								"desc" 	=> __('Enter your VAT-ID.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_vat_id",
								"type" 	=> "text",
								"std" 	=> ""),
								
					array(  	"name" 	=> __('Display Delivery Address?','wpShop'),
								"desc" 	=> __('By default the PDF will show the customer\'s billing address only. Check this setting if you want the display the Delivery Address in addition.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_PDF_delAddr_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
					
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			// General			
			array ( 	"name" 	=> __('PDF Invoice Format, Margins and Table Column Widths','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
				
					array(  	"name" 	=> __('PDF Invoice Format','wpShop'),
								"desc" 	=> __('','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_invoiceFormat",
								"std" 	=> "International (A4)",
								"vals" 	=> array(__('International (A4)','wpShop')."|A4",__('American (Letter)','wpShop')."|Letter"),
								"type" 	=> "select2"),
					
					array(  	"name" 	=> __('Left Margin','wpShop'),
								"desc" 	=> __('Set the left margin in mm','wpShop')."<br/><b>".__('Note: For calculating the dimmensions here and for the settings bellow it may help if you remember the following sizes:','wpShop')."</b><br/><b>".__('International A4 format: 210 × 297 mm','wpShop')."</b><br/><b>".__('US Letter Format: 216 × 279 mm','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_leftMargin",
								"type" 	=> "text",
								"std" 	=> "10"),
								
					array(  	"name" 	=> __('Right Margin','wpShop'),
								"desc" 	=> __('Set the Right margin in mm','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_rightMargin",
								"type" 	=> "text",
								"std" 	=> "10"),
								
					array(  	"name" 	=> __('Top Margin','wpShop'),
								"desc" 	=> __('Set the top margin in mm','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_topMargin",
								"type" 	=> "text",
								"std" 	=> "10"),
								
					array(  	"name" 	=> __('Item No. Column Width','wpShop'),
								"desc" 	=> __('Set the Item No. Column Width in mm','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_colWidth1",
								"type" 	=> "text",
								"std" 	=> "20"),
								
					array(  	"name" 	=> __('Item Column Width','wpShop'),
								"desc" 	=> __('Set the Item Column Width in mm','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_colWidth2",
								"type" 	=> "text",
								"std" 	=> "115"),
								
					array(  	"name" 	=> __('Quantity Column Width','wpShop'),
								"desc" 	=> __('Set the Quantity Column Width in mm','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_colWidth3",
								"type" 	=> "text",
								"std" 	=> "15"),
								
					array(  	"name" 	=> __('Item Price Column Width','wpShop'),
								"desc" 	=> __('Set the Item Price Column Width in mm','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_colWidth4",
								"type" 	=> "text",
								"std" 	=> "20"),
								
					array(  	"name" 	=> __('Item Total Column Width','wpShop'),
								"desc" 	=> __('Set the Total Column Width in mm','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_colWidth5",
								"type" 	=> "text",
								"std" 	=> "20"),
					
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			
			// Header			
			array ( 	"name" 	=> __('PDF Invoice Header','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
					
					array(  	"name" 	=> __('PDF / HTML Invoice Logo','wpShop'),
								"desc" 	=> __('Customize the logo on the PDF / HTMl invoice. Enter the name of your image file - must be saved in the Parent theme &gt; images &gt; logo folder inside the parent theme.','wpShop')."<br/><b>".__('Supported are: jpegs, pngs, gifs, transparency. NOT Supported are: Interlacing and Alpha Channel','wpShop')."</b><br/><b>".__('When creating your image, remember that normally for viewing 72/96/150dpi is used, for printing 200-600dpi','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_logo",
								"type" 	=> "text",
								"std" 	=> "pdf-logo.jpg"),

					array(  	"name" 	=> __('PDF Logo- Image Width','wpShop'),
								"desc" 	=> __('Set the desired width of your image file in mm. The height is calculated automatically to respect the image proportions','wpShop')."<br/><b>".__('If you use the provided psd file to create your logo you get an image with 300dpi quality and you don\'t have to change the default dimmension set here','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_logoWidth",
								"type" 	=> "text",
								"std" 	=> "70"),// (200px / 300dpi) x 25.4 = width in mm
					
					array(  	"name" 	=> __('Display Only Logo','wpShop'),
								"desc" 	=> __('By default the PDF will print your Shop\'s Address as you have entered it under your General Settings. Check this setting if you only want to display the Logo in the PDF Header','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_header_addr_disable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Display only my Shop\'s Name','wpShop'),
								"desc" 	=> __('Check this setting if you want to display only the Shop\'s Name and not the entire Address on the generated PDF','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_shop_name_only",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Custom Header Text','wpShop'),
								"desc" 	=> __('If you need any other custom text to appear in the PDF Header enter it here.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_header_custom_text",
								"type" 	=> "text",
								"std" 	=> ""),
								
					array(  	"name" 	=> __('Set the Text Colour for the Address','wpShop'),
								"desc" 	=> __('Colours can be expressed in ','wpShop')."<a target='_blank' href='http://www.colorpicker.com/'>".__('RGB components or gray scale.','wpShop')."</a>",
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_header_txtColour",
								"type" 	=> "text",
								"std" 	=> "0,0,0"),
								
					array(  	"name" 	=> __('Set the Font Size for the Address','wpShop'),
								"desc" 	=> __('','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_header_fontSize",
								"type" 	=> "text",
								"std" 	=> "12"),
								
					array(  	"name" 	=> __('Border Around Address?','wpShop'),
								"desc" 	=> __('Check this setting if you want to have a around the Shop\'s Address on the generated PDF','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_header_addrBorder",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Border Width','wpShop'),
								"desc" 	=> __('Set the Border width in mm. The default is 0.2 (mm)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_header_addrBorderWidth",
								"type" 	=> "text",
								"std" 	=> "0.2"),
								
					array(  	"name" 	=> __('Background Fill behind Shop Address?','wpShop'),
								"desc" 	=> __('Check this setting if you want to have a background colour behind the Shop\'s Address on the generated PDF','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_header_bgdColour_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Set the Background Colour for the Address','wpShop'),
								"desc" 	=> __('Colours can be expressed in ','wpShop')."<a target='_blank' href='http://www.colorpicker.com/'>".__('RGB components or gray scale.','wpShop')."</a>",
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_header_bgdColour",
								"type" 	=> "text",
								"std" 	=> "255,255,255"),

				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			// Footer			
			array ( 	"name" 	=> __('PDF Invoice Footer','wpShop'),
						"type" 	=> "title"),
							
				array(    	"type" 	=> "open"),
					
					array(  	"name" 	=> __('Custom Footer Text','wpShop'),
								"desc" 	=> __('By default the PDF will display your Shop\'s Name (along with your Tax Label and ID if one is provided) centered at the bottom. If you need any other custom text to appear in the PDF Footer enter it here.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_footer_custom_text",
								"type" 	=> "text",
								"std" 	=> ""),
					
					array(  	"name" 	=> __('Set the Text Colour for the Footer','wpShop'),
								"desc" 	=> __('Colours can be expressed in ','wpShop')."<a target='_blank' href='http://www.colorpicker.com/'>".__('RGB components or gray scale.','wpShop')."</a>",
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_footer_txtColour",
								"type" 	=> "text",
								"std" 	=> "0,0,0"),
								
					array(  	"name" 	=> __('Set the Font Size for the Footer','wpShop'),
								"desc" 	=> __('','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_footer_fontSize",
								"type" 	=> "text",
								"std" 	=> "6"),
								
					array(  	"name" 	=> __('Border Around Footer?','wpShop'),
								"desc" 	=> __('Check this setting if you want to have a around the Shop\'s Address on the generated PDF','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_footer_Border",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Border Width','wpShop'),
								"desc" 	=> __('Set the Border width in mm. The default is 0.2 (mm)','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_footer_BorderWidth",
								"type" 	=> "text",
								"std" 	=> "0.2"),
								
					array(  	"name" 	=> __('Background Fill behind Footer?','wpShop'),
								"desc" 	=> __('Check this setting if you want to have a background colour behind the Shop\'s Address on the generated PDF','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_footer_bgdColour_enable",
								"type" 	=> "checkbox",
								"std" 	=> "false"),
								
					array(  	"name" 	=> __('Set the Background Colour for the Footer','wpShop'),
								"desc" 	=> __('Colours can be expressed in ','wpShop')."<a target='_blank' href='http://www.colorpicker.com/'>".__('RGB components or gray scale.','wpShop')."</a>",
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_footer_bgdColour",
								"type" 	=> "text",
								"std" 	=> "255,255,255"),
					
				array(   	"type" => "close"),
			array(   	"type" => "close"),
		
			//Generate PDF
			array ( 	"name" 	=> __('Generate PDF','wpShop'),
						"type" 	=> "title"),
						
				array(    	"type" 	=> "open"),
					
					array(    	"name" 	=> __('Your Customized PDF','wpShop'),
								"desc" 	=> "<a href='".get_option('siteurl')."/wp-content/themes/".get_option('template')."/design-your-pdf.php' target='_blank'>".__('Call test pdf page','wpShop')."</a><br/>".__('Want to see how you PDF now looks like? Use this link to generate a test PDF. Only remember to save first the settings you modified from above once, in order to see your changes!','wpShop')."<br/><strong>".__('How to use this setting:','wpShop')."</strong><br/>".__('1. Complete 1 test order (use Bank Transfer as it goes fast)','wpShop')."<br/>".__('2. Click the link you see above','wpShop')."<br/>".__('3. Follow the instructions you see on the page the link will take you.','wpShop'),
								"id" 	=> NULL,
								"std" 	=> NULL,
								"type" 	=> "text-link"),
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			// Vouchers			
			array ( 	"name" 	=> __('PDF Vouchers','wpShop'),
						"type" 	=> "title"),
						
				array(    	"type" 	=> "open"),
				
					array(  	"name" 	=> __('PDF Voucher Format','wpShop'),
								"desc" 	=> __('','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdfFormat",
								"std" 	=> "",
								"vals" 	=> array(__('International (A4)','wpShop')."|A4",__('American (Letter)','wpShop')."|Letter"),
								"type" 	=> "select2"),
										
					array(  	"name" 	=> __('PDF Voucher-Background Image','wpShop'),
								"desc" 	=> __('Enter the file name of the pdf voucher background image which you have uploaded in the "Vouchers" section.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_pdf_voucher_bg",
								"type" 	=> "text",
								"std" 	=> "sample_coupon_voucher_1.jpg"),
								
				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),		
	array (		"type" 	=> "section_end"),

//###############################################################################################################
//###############################################################################################################
/*** 
NADA Settings
***/
array ( 	"name" 	=> __('NADA','wpShop'),
			"type" 	=> "heading",
			"class" =>"nada"),
					
	array (		"type" 	=> "section_start",
				"class" =>"hasadmintabs hasadmintabs5"),					
//###############################################################################################################
		// Tab 1 
		array (		"type" 	=> "fieldset_start",
					"class" =>"nada",
					"id" 	=>"nada_settings"),

			array ( 	"name" 	=> __('NADA Database','wpShop'),
						"type" 	=> "title"),

				array (   	"type" 	=> "open"),
		
					array(    	"name" 	=> __('eValuation Company','wpShop'),
								"desc" 	=> __('Select the company for eValuation of Vechicles.','wpShop'),
								"id" 	=> "autos2day_tradein_company",
								"std" 	=> "nada",
								"vals" 	=> array(__('nada','wpShop')."|nada",__('kbb','wpShop')."|kbb"),
								"type" 	=> "select2"),							
												
					array(    	"name" 	=> __('Nada Database host','wpShop'),
								"desc" 	=> __('Enter the host id of Nada database','wpShop'),
								"id" 	=> "nada_db_host",
								"std" 	=> "localhost",
								"type" 	=> "text"),

			
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
		array (		"type" 	=> "fieldset_end"),		
//###############################################################################################################
		// Tab 2 
		array (		"type" 	=> "fieldset_start",
					"class" =>"nada",
					"id" 	=>"nada_settings"),

			array ( 	"name" 	=> __('NADA Database Credentials','wpShop'),
						"type" 	=> "title"),

				array (   	"type" 	=> "open"),
		

					array(    	"name" 	=> __('Nada Database User','wpShop'),
								"desc" 	=> __('Enter the user id of Nada database','wpShop'),
								"id" 	=> "nada_db_user",
								"std" 	=> "nada",
								"type" 	=> "text"),

					array(    	"name" 	=> __('Nada Database User Password','wpShop'),
								"desc" 	=> __('Enter the host user password of Nada database','wpShop'),
								"id" 	=> "nada_db_pwd",
								"std" 	=> "password",
								"type" 	=> "text"),

					array(    	"name" 	=> __('Nada Database ','wpShop'),
								"desc" 	=> __('Enter the name of Nada database','wpShop'),
								"id" 	=> "nada_db",
								"std" 	=> "nada_v5",
								"type" 	=> "text"),
			
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
		array (		"type" 	=> "fieldset_end"),				
array (		"type" 	=> "section_end"),	

//###############################################################################################################
//###############################################################################################################
/*** 
Email Settings
***/
array ( 	"name" 	=> __('EMAIL','wpShop'),
			"type" 	=> "heading",
			"class" =>"email"),
					
	array (		"type" 	=> "section_start",
				"class" =>"hasadmintabs hasadmintabs6"),					
//###############################################################################################################
		// Tab 1 
		array (		"type" 	=> "fieldset_start",
					"class" =>"nada",
					"id" 	=>"email_settings"),

			array ( 	"name" 	=> __('Email Settings','wpShop'),
						"type" 	=> "title"),

				array (   	"type" 	=> "open"),
		
					array(    	"name" 	=> __('Disclaimer Text','wpShop'),
								"desc" 	=> __('Enter the Disclaimer Text for emails.','wpShop'),
								"id" 	=> "email_disclaimer",
								"std" 	=> "This electronic message contains information generated by the Autos2day solely for the intended recipients. Any unauthorized interception of this message or the use or disclosure of the information it contains may violate the law and subject the violator to civil or criminal penalties. If you believe you have received this message in error, please notify the sender and delete the email immediately.",
								"type" 	=> "textarea"),							
			
					array(    	"name" 	=> __('Signature','wpShop'),
								"desc" 	=> __('Enter the Signature for emails.','wpShop'),
								"id" 	=> "email_signature",
								"std" 	=> "This electronic message contains information generated by the Autos2day solely for the intended recipients. Any unauthorized interception of this message or the use or disclosure of the information it contains may violate the law and subject the violator to civil or criminal penalties. If you believe you have received this message in error, please notify the sender and delete the email immediately.",
								"type" 	=> "textarea"),							

					array(    	"name" 	=> __('Registration CC email','wpShop'),
								"desc" 	=> __('Enter the "cc" ID for emails.','wpShop'),
								"id" 	=> "cc_admin_email",
								"std" 	=> "dealers@autos2day.com",
								"type" 	=> "text"),							

				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
		array (		"type" 	=> "fieldset_end"),		
		
array (		"type" 	=> "section_end"),	

//###############################################################################################################
//###############################################################################################################
/*** 
Google Settings
***/
array ( 	"name" 	=> __('Google / SEO','wpShop'),
			"type" 	=> "heading",
			"class" =>"google"),
					
	array (		"type" 	=> "section_start",
				"class" =>"hasadmintabs hasadmintabs3"),					
//###############################################################################################################
		// Tab 1 SEO
		array (		"type" 	=> "fieldset_start",
					"class" =>"google",
					"id" 	=>"sec_seo_settings"),

			array ( 	"name" 	=> __('SEO','wpShop'),
						"type" 	=> "title"),

				array (   	"type" 	=> "open"),
				
					array(  	"name" 	=> __('Meta Keywords for the Front Page','wpShop'),
								"desc" 	=> __('Set some Meta Keywords to describe your Site as a whole to be used when on the Frontpage.','wpShop')."<br/><b>".__('Make sure to seperate each Keyword with a comma like so: list,of,keywords','wpShop')."</b>",
								"id" 	=> $CONFIG_WPS['shortname']."_keywords",
								"type" 	=> "textarea",
								"std" 	=> ""),	
								
					array(  	"name" 	=> __('Meta Description for the Front Page','wpShop'),
								"desc" 	=> __('Enter a Meta Description to describe your Site as a whole to be used when on the Frontpage.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_description",
								"type" 	=> "textarea",
								"std" 	=> ""),
								
				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),	
//###############################################################################################################
		// Tab 2 Google Maps
		array (		"type" 	=> "fieldset_start",
					"class" =>"google",
					"id" 	=>"sec_googleMaps_settings"),

			array ( 	"name" 	=> __('Google Maps','wpShop'),
						"type" 	=> "title"),

				array (   	"type" 	=> "open"),
				
					array(  	"name" 	=> __('Google Maps Link','wpShop'),
								"desc" 	=> __('Enter the link for Google Maps here (should of course show location of your biz). Will only appear (on order confirmation page) if you give your customers the option to pick up their order from your shop.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_google_maps_link",
								"type" 	=> "textarea",
								"std" 	=> "http://www.google.com/maps?f=q&hl=de&geocode=&q=Platzl+9,80331+M%C3%BCnchen,+Germany&sll=37.0625,-95.677068&sspn=51.04407,78.75&ie=UTF8&ll=48.137683,11.57959&spn=0.678178,1.230469&z=10&iwloc=addr"),		
												
				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),	
//###############################################################################################################
		// Tab 3 Google Analytics
		array (		"type" 	=> "fieldset_start",
					"class" =>"google",
					"id" 	=>"sec_googleAnalytics_settings"),

			array ( 	"name" 	=> __('Google Analytics','wpShop'),
						"type" 	=> "title"),

				array (   	"type" 	=> "open"),
		
					array(    	"name" 	=> __('Active','wpShop'),
								"desc" 	=> __('Activate your Google analytics here. The code will appear in the footer.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_google_analytics",
								"std" 	=> "not_active",
								"vals" 	=> array(__('Active','wpShop')."|active",__('Not active','wpShop')."|not_active"),
								"type" 	=> "select2"),							
												
					array(    	"name" 	=> __('Analytics Profile ID','wpShop'),
								"desc" 	=> __('Enter here the id of your analytics profile','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_google_analytics_id",
								"std" 	=> "UA-xxxxxx-01",
								"type" 	=> "text"),
			
				array(   	"type" => "close"),
			array(   	"type" => "close"),
			
			array ( 	"name" 	=> __('Custom Tracking Code','wpShop'),
						"type" 	=> "title"),

				array (   	"type" 	=> "open"),
				
					array(  	"name" 	=> __('On Order Confirmation Page','wpShop'),
								"desc" 	=> __('If you want to track how many of your customers reach the confirmation page enter your tracking script here.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_custom_tracking",
								"type" 	=> "textarea",
								"std" 	=> ""),		
												
				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),		
//###############################################################################################################
		// Tab 4 Google Adsense
		array (		"type" 	=> "fieldset_start",
					"class" =>"google",
					"id" 	=>"sec_googleAdsense_settings"),

			array ( 	"name" 	=> __('Google Adsense','wpShop'),
						"type" 	=> "title"),

				array (   	"type" 	=> "open"),
			
					array(  	"name" 	=> __('Ad 1','wpShop'),
								"desc" 	=> __('Enter the code for your 1st Google ad here. You still need to place the ','wpShop')."<b>google_adsense(1);</b>".__(' marker in the template file where you like it to appear. Remember that it needs to be wrapped in php tags','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_google_adsense_1",
								"type" 	=> "textarea",
								"std" 	=> ""),		
										
					array(  	"name" 	=> __('Ad 2','wpShop'),
								"desc" 	=> __('Enter the code for your 2nd Google ad here. You still need to place the ','wpShop')."<b>google_adsense(2);</b>".__(' marker in the template file where you like it to appear. Remember that it needs to be wrapped in php tags','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_google_adsense_2",
								"type" 	=> "textarea",
								"std" 	=> ""),	
										
					array(  	"name" 	=> __('Ad 3','wpShop'),
								"desc" 	=> __('Enter the code for your 3rd Google ad here. You still need to place the ','wpShop')."<b>google_adsense(3);</b>".__(' marker in the template file where you like it to appear. Remember that it needs to be wrapped in php tags','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_google_adsense_3",
								"type" 	=> "textarea",
								"std" 	=> ""),	
								
				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),		
array (		"type" 	=> "section_end"),

//###############################################################################################################
//###############################################################################################################
/*** 
Support
***/
array ( 	"name" 	=> __('Support','wpShop'),
			"type" 	=> "heading",
			"class" =>"support"),
					
	array (		"type" 	=> "section_start",
				"class" =>"hasadmintabs hasadmintabs4"),					
//###############################################################################################################
		// Tab 1 support
		array (		"type" 	=> "fieldset_start",
					"class" =>"support",
					"id" 	=>"sec_support_settings"),

			array ( 	"name" 	=> __('Theme Support','wpShop'),
						"type" 	=> "title"),

				array (   	"type" 	=> "open"),
				
					array(    	"name" 	=> __('Support ID','wpShop'),
								"desc" 	=> __('Upon support request a support ID may be given to you. In this case you will enter the ID in the above field.','wpShop')."<br/>".__('Support emails must be send over our ','wpShop')."<a href='http://themeforest.net/user/srhnbr' target='_blank'>".__('Theme Forest profile ','wpShop')."</a><br/><strong>".__('Emails send differently will not be replied to.','wpShop')."</strong>",
								"id" 	=> $CONFIG_WPS['shortname']."_support_id",
								"std" 	=> "0",
								"type" 	=> "text"),	

					array(    	"name" 	=> __('Attribute Value Cleanup','wpShop'),
								"desc" 	=> "<a href='?page=functions.php&section=checks'>".__('Start this check now','wpShop')."</a><br/><strong>".__('Removes extra "pipes" (|) at the end of attribute values.','wpShop')."</strong>",
								"id" 	=> NULL,
								"std" 	=> NULL,
								"type" 	=> "text-link"),
								
					array(    	"name" 	=> __('Dashboard Widget','wpShop'),
								"desc" 	=> __('','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_dash_widget",
								"std" 	=> "<p>Need help? <a target='_blank' href='http://themeforest.net/user/srhnbr'>Contact the developer</a></p>",
								"type" 	=> "textarea"),
								
					array(    	"name" 	=> __('Time addition','wpShop'),
								"desc" 	=> __('Sometimes there are situations when your server is located in a different time zone than you and you may want to balance out difference in time between your web server time and your local time. Use this field for this and add the time addition in seconds.','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_time_addition",
								"std" 	=> "0",
								"type" 	=> "text"),
											
				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),		
	array (		"type" 	=> "section_end"),	

//###############################################################################################################
//###############################################################################################################
/*** 
Deals
***/
array ( 	"name" 	=> __('Deals','wpShop'),
			"type" 	=> "heading",
			"class" =>"deals"),
					
	array (		"type" 	=> "section_start",
				"class" =>"hasadmintabs"),					
//###############################################################################################################
		// Tab 1 support
		array (		"type" 	=> "fieldset_start",
					"class" =>"support",
					"id" 	=>"deal_settings"),

			array ( 	"name" 	=> __('Deal Settings','wpShop'),
						"type" 	=> "title"),

				array (   	"type" 	=> "open"),
				
					array(    	"name" 	=> __('Deal Charge Rate','wpShop'),
								"desc" 	=> __('Enter the amount that needs to be charged for approved deal','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_deal_amount",
								"std" 	=> "0",
								"type" 	=> "text"),	

					array(    	"name" 	=> __('Voucher Download button','wpShop'),
								"desc" 	=> __('Enter the text for Voucher download button','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_download_voucher",
								"std" 	=> "Download Voucher",
								"type" 	=> "text"),	

					// /wps_download_voucher

					array(    	"name" 	=> __('Expire Deals','wpShop'),
								"desc" 	=> __('Whether to expire the deals after deal-date?','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_expire_deals",
								"std" 	=> "false",
								"vals" 	=> array("false","true"),
								"type" 	=> "select"),

					array(    	"name" 	=> __('Go Live Date','wpShop'),
								"desc" 	=> __('Enter the Go Live Date for home page','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_go_live",
								"std" 	=> "2012-07-10",
								"type" 	=> "text"),

					array(    	"name" 	=> __('Send Deal Approve Emails','wpShop'),
								"desc" 	=> __('Whether to Send Deal Approval Emails?','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_approved_emails",
								"type" 	=> "checkbox",
								"std" 	=> "false"),

					array(    	"name" 	=> __('Send Deal Rejection Emails','wpShop'),
								"desc" 	=> __('Whether to Send Deal Rejection Emails?','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_rejection_emails",
								"type" 	=> "checkbox",
								"std" 	=> "false"),

					array(    	"name" 	=> __('Facebook App Id','wpShop'),
								"desc" 	=> __('Enter the facebook app id?','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_fb_app_id",
								"type" 	=> "text",
								"std" 	=> "100598603421654"),

					array(    	"name" 	=> __('No of Deals Per Category Per Page','wpShop'),
								"desc" 	=> __('Enter the no - default is 10?','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_num_of_deals_per_page",
								"type" 	=> "text",
								"std" 	=> "10"),

					array(    	"name" 	=> __('Sorting order of Deals`','wpShop'),
								"desc" 	=> __('Specify the sorting Order?','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_sorting_order",
								"std"	=>	"date_old_to_new",
								"vals" 	=> array("date_old_to_new","date_new_to_old", "price_low_to_high", "price_high_to_low", "random"),
								"type" 	=> "select"),

				array(    	"name" 	=> __('Promotion Source Options`','wpShop'),
								"desc" 	=> __('Specify the sources seperated by ","','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_promotion_sources",
								"std"	=>	"Newspaper,Radio,Other",
								"type" 	=> "text"),					
				array(    	"name" 	=> __('Current Promotion Text`','wpShop'),
								"desc" 	=> __('Specify the Current Promotion','wpShop'),
								"id" 	=> $CONFIG_WPS['shortname']."_promotion",
								"std"	=>	"FREE 100$ VISA CARD",
								"type" 	=> "text"),					
											
				array(   	"type" => "close"),
			array(   	"type" => "close"),
		array (		"type" 	=> "fieldset_end"),		
	array (		"type" 	=> "section_end"),	

);



function NWS_theme_admin(){

    global $CONFIG_WPS,$wpdb,$options,$useSection,$install_status,$OPTION;

	$section = str_replace('#',NULL,$_GET['section']); 	
	?>
	<?php switch($section){	

		case 'orders':				
			if($_GET[subsection] == 'dlinks'){			
				send_user_dlinks($_GET['token']);
			}
	
			if(isset($_POST['status_change'])){
				multi_change_order_level();	
			}
						
			$odata = classify_orders();
	
			$table_header = "
				<table class='widefat' >
					<thead>
						<tr>
							<th>".__('Order','wpShop')."</th>
							<th>".__('No.','wpShop')."</th>
							<th>".__('Date','wpShop')."</th>
							<th>".__('Billing','wpShop')."</th>
							<th>".__('Delivery','wpShop')."</th>
							<th>".__('Total Value','wpShop')."</th>
							<th>".__('Details','wpShop')."</th>
							<th>".__('Invoice','wpShop')."</th>
							<th>".__('Payment and Delivery','wpShop')."</th>";
													
							if($OPTION['wps_customNote_enable'] == TRUE) {
								$table_header .= "<th>".__('Custom Note','wpShop')."</th>";
							}
							
						$table_header .= "</tr>
					</thead>
					<tbody>
				";	
				
			$table_footer 	= "</tbody></table>";				
			$empty_message 	= "<h4>".__('No orders with this status.','wpShop')."</h4>";
			$date_format	= "j.m.Y - G:i:s";
									
			echo make_section_header('orders'); ?>
			<form class="nws_admin_options nws_manage_orders" action="themes.php?page=functions.php&section=orders" method="post">
				<div class="hasadmintabs hasadmintabs1">
					<?php if((count($odata[5])) > 0){ ?>
						<fieldset id="pending">
							<?php 
							echo "<h3>".__('Status 0: Payment Pending','wpShop')."</h3>";
							display_order_entries($odata,5,$date_format,$table_header,$table_footer,$empty_message); 
							?>
						</fieldset>
					<?php } ?>
					<fieldset id="new">
						<?php 
						echo "<h3>".__('Status 1: Newly Received','wpShop')."</h3>"; 
						display_order_entries($odata,1,$date_format,$table_header,$table_footer,$empty_message); 
						?>
					</fieldset>
					<fieldset id="process">
						<?php 
						echo "<h3>".__('Status 2: Orders in Process','wpShop')."</h3>"; 
						display_order_entries($odata,2,$date_format,$table_header,$table_footer,$empty_message); 
						?>
					</fieldset>
					<fieldset id="shipped">
						<?php 
						echo "<h3>".__('Status 3: Shipped Orders','wpShop')."</h3>"; 
						display_order_entries($odata,3,$date_format,$table_header,$table_footer,$empty_message); 
						?>
					</fieldset>
					<fieldset id="completed">
						<?php 
						echo "<h3>".__('Status 4: Completed Orders','wpShop')."</h3>"; 
						display_order_entries($odata,4,$date_format,$table_header,$table_footer,$empty_message); 
						?>
					</fieldset>
					
					<div class="tablenav">
						<label><?php _e('Bulk Actions:','wpShop'); ?></label> 
						<select name='status' size='1'>									
							<option value='4'><?php _e('Newly Received','wpShop'); ?></option>
							<option value='5'><?php _e('In Process','wpShop'); ?></option>
							<option value='6'><?php _e('Shipped','wpShop'); ?></option>
							<option value='7'><?php _e('Completed','wpShop'); ?></option>
							<option class="error" value='delete'><?php _e('Delete','wpShop'); ?></option>
						</select>
						<input type='submit' name='status_change' value='<?php _e('Apply','wpShop'); ?>' />
					</div>
					
				</div><!-- hasadmintabs -->
			</form>
			<?php echo make_section_footer();

		break;
		
		case 'inquiries':
		
			if(isset($_POST['status_change'])){		
				multi_change_inquiry_level();	
			}
						
			$odata =  classify_inquiries();
	
			$table_header = "
			<table border='1' class='widefat' >
				<thead>
					<tr>
						<th>".__('Order','wpShop')."</th>
						<th>".__('No.','wpShop')."</th>
						<th>".__('Date','wpShop')."</th>
						<th>".__('Who?','wpShop')."</th>
						<th>".__('Billing','wpShop')."</th>
						<th>".__('Delivery','wpShop')."</th>
						<th>".__('Total Value','wpShop')."</th>
						<th>".__('Details','wpShop')."</th>
						<th>".__('Preferred Payment and Delivery','wpShop')."</th>
						<th>".__('Custom Note','wpShop')."</th>
					</tr>
				</thead>
				<tbody>
			";	
				
			$table_footer 	= "</tbody></table>";				
			$empty_message 	= "<h4>".__('No inquiries with this status.','wpShop')."</h4>";
			$date_format	= "j.m.Y - G:i:s";
						
			echo make_section_header('inquiries'); ?>
			<form class="nws_admin_options nws_manage_inquiries" action="themes.php?page=functions.php&section=inquiries" method="post">
				<div class="hasadmintabs hasadmintabs1">
					
					<fieldset id="new">
						<?php 
						echo "<h3 class='new'>".__('Status 1: Newly Received','wpShop')."</h3>"; 
						display_inquiry_entries($odata,1,$date_format,$table_header,$table_footer,$empty_message); 
						?>
					</fieldset>
					
					<fieldset id="replied">
						<?php 
						echo "<h3>".__('Status 2: Already Replied To','wpShop')."</h3>"; 
						display_inquiry_entries($odata,2,$date_format,$table_header,$table_footer,$empty_message); 
						?>
					</fieldset>
					
					<div class="tablenav">
						<label><?php _e('Bulk Actions:','wpShop'); ?></label> 
						<select name='status' size='1'>
							<option value='4'><?php _e('Newly Received','wpShop'); ?></option>
							<option value='5'><?php _e('Replied To','wpShop'); ?></option>
							<option class="error" value='delete'><?php _e('Delete','wpShop'); ?></option>
						</select>
						<input type='submit' name='status_change' value='<?php _e('Apply','wpShop'); ?>' />
					</div>
					
				</div><!-- hasadmintabs -->
			</form>
			<?php echo make_section_footer();
		break;
		
		
		
		case 'inventory':
		
			if($_GET[update] == '1'){
				inventory_amount_update();
			}
			
			if($_GET['clean_inventory'] == '1'){
				clean_inventory();
			}
			
			// lets get our inventory in order / updated aso.
			if($_GET['enigma'] == '1'){
			
				# 1. Attributes-Check 						
				adapt_inventory2attributes();	// adds missing attr. cols to inventory table
				
				
				# 2. Article-Check / is article there at all
					// = means: are all the articles with all possible attr. combos saved?					
				inventory_article_check();	
			}
		
			echo make_section_header('inventory'); ?>
			
			<div class="tablenav">
				<div class="alignleft actions">
					<?php
						echo "
						<a id='nws_inv_return' class='button-secondary action' href='?page=functions.php&section=inventory&clean_inventory=1' target='_blank' title='".__('Returns Products from "abandoned" Carts.','wpShop')."'>".__('Return Stock','wpShop')."</a>
						<a id='nws_inv_refresh' class='button-secondary action' href='?page=functions.php&section=inventory&enigma=1' title='".__('Refresh if you have added a New Product and/or Attribute (Product Variation)','wpShop')."'>".__('Refresh List','wpShop')."</a>
						
						<form class='nws_search nws_inv_search' action='?page=functions.php&section=inventory' method='get'>
							<input type='hidden' name='page' value='functions.php' />
							<input type='hidden' name='section' value='inventory' />
							<input type='text' name='art_wanted' value='$_GET[art_wanted]' maxlength='255' />
							<input class='button-secondary action' type='submit' name='search_inv' value='Search' /><br/>
							<small>".__('Enter at least the first 3 digits of a Product ID_item','wpShop')."</small>
						</form>
						";
					?>	
				</div>
				<div class='tablenav-pages'>
					<?php NWS_inventory_pagination(20); ?>	
				</div>
			</div>
			
			<?php 
			// get all articles				
			echo "<div id='nws_inv_wrap'>";
			
				$res = inventory_main_query(pagination_limit_clause(20));

				while($row = mysql_fetch_assoc($res))
				{	

					$show_not1 = (strlen(get_custom_field2($row['post_id'],'item_file')) > 1 ? 1 : 0);
					$show_not2 = (strlen(get_custom_field2($row['post_id'],'buy_now')) > 1 ? 1 : 0);	
						
					if(($show_not1 == 0)&&($show_not2 == 0)){											

						$product_title 	= $row['post_title'];		
						$product_image	= inventory_product_image($row['post_id']);
							
						echo "
						<form class='nws_inv_prod' action='?page=functions.php&section=inventory&update=1' method='post' style='border: 1px solid gainsboro;'>
							<h4 class='nws_inv_prod_ID'>".__('Article No.','wpShop').": $row[meta_value]</h4> <input class='nws_inv_prod_update' type='submit' name='submit_this' value='".__('update','wpShop')."' />
							<div class='nws_inv_details'>
								<p class='nws_inv_prod_title'>$product_title";
								
									if(strlen($product_image) > 1){
										echo " | <a href='$product_image' title='$product_title' class='thickbox'><img src='images/media-button-image.gif' alt='".__('Product Image','wpShop')."' /></a>";
									}

								echo "</p>";								

								if(inventory_has_attributs($row[post_id]) != 0){	// attributes - yes/no

									if($row_head !== FALSE){ // the array is not empty
										echo "<table>";
										echo header_for_attributes($row[meta_value]);
										echo display_attributes_data($row[meta_value],inventory_order_clause());									
										echo "</table>";
									}
									else { echo __('Please refresh your inventory!','wpShop');}
									
								}
								else {
									$res2 = display_amount($row[meta_value]);
									echo "<label>".__('Amount: ','wpShop')."</label>";
									while($row2 = mysql_fetch_assoc($res2)){								
										echo "<input type='text' name='$row2[iid]' value='$row2[amount]' />";
									}
								}
							echo "</div>
						</form>
						";
					}
				}
			echo "</div>";
			echo make_section_footer();	
			
		break;
		

		case 'lkeys':
			$upload_result = NULL;
	
			if($_GET[action] == 'upload'){						
				$upload_result = save_lkeys();						
			}  
	
			echo make_section_header('lkeys');
			echo $upload_result;
					
			echo "	
			<form action='?page=functions.php&section=lkeys&action=upload' enctype='multipart/form-data' method='post'>
				<h3>".__('License Key Uploader','wpShop')."</h3>
				<fieldset>
					<table>
						<tr>
							<td>".__('Name of Download File','wpShop')."</td>
							<td><input name='name_file' type='text' maxlength='255'/></td>
						</tr>
						<tr>
						<tr>
							<td>".__('File with License Keys','wpShop')."</td>
							<td><input name='csvfile' type='file' /></td>
						</tr>
						<tr>
							<td colspan='2'><small>".__('[Please keep in mind: It has to be a .txt file - Size: not more than 100kB.]','wpShop')."</small></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type='submit' value='Submit' /></td>
						</tr>
						<tr>
							<td colspan='2'>&nbsp</td>
						</tr>
					</table>
				</fieldset>
			</form>
			";
				
			echo  make_section_footer();
	
		break;
		
		
		case 'vouchers':
			echo make_section_header('vouchers');
				
			// subactions 
			if(isset($_GET['action'])){
				global $OPTION;									
				$VOUCHER = load_what_is_needed('voucher');
			}
					
			switch($_GET['action']){
				case 'upload':
					echo make_voucher_tabs('upload');
					
					$upload_result 	= $VOUCHER->save();			
					echo "<h2>$upload_result</h2>";					
				break;
				
				case 'display':
					echo make_voucher_tabs('display');
					
					if($_GET['subaction'] == 'del'){
						$VOUCHER->delete($_GET[vid]);
						$url = "themes.php?page=functions.php&section=vouchers&action=display";
						echo "<meta http-equiv='refresh' content='0; URL=$url'>";
					}
					echo "<h3>".__('Single-Use Vouchers','wpShop')."</h3>"; ?>
					
					<div class="tablenav">
						<div class="alignleft actions">
							<?php
								echo "
								<form class='nws_search nws_voucher_search' action='?page=functions.php&section=vouchers' method='get'>
									<input type='hidden' name='page' value='functions.php' />
									<input type='hidden' name='section' value='vouchers' />
									<input type='hidden' name='action' value='display' />
									<input type='text' name='vouch_wanted' value='$_GET[vouch_wanted]' maxlength='255' />
									<input class='button-secondary action' type='submit' name='search_vouchers' value='Search' /><br/>
									<small>".__('Enter a Voucher Code','wpShop')."</small>
								</form>
								";
							?>	
						</div>
						<div class='tablenav-pages'>
							<?php NWS_voucher_pagination(20); ?>	
						</div>
					</div>
					
					<?php
					
					echo $VOUCHER->display(is_dbtable_there('vouchers'),20);	
					
				break;
					
				case 'bgImg':
					echo make_voucher_tabs('bgImg');
					
					echo "
					<form action='?page=functions.php&section=vouchers&action=bgImgUpload' enctype='multipart/form-data' name='voucher_bg_form' id='voucher_form' method='post'>
						<h3>".__('Single-Use Vouchers: Background Uploader','wpShop')."</h3>
						<small><b>".__('Before you upload anything make sure you have selected the correct PDF format from your Theme Options > Shop > PDF Options"','wpShop')."</b></small>
						<fieldset>
							<table>					
								<tr>
									<td>".__('Select an Image File:','wpShop')."</td>
									<td><input name='imgfile' type='file' /></td>
								</tr>
								<tr>
									<td colspan='2'><small>".__('After a succeful upload you will be given it\'s saved file name. Copy what you see and save it under your Theme Options > Shop > PDF Options"','wpShop')."</small></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td><input type='submit' value='Submit' /></td>
								</tr>
								<tr>
									<td colspan='2'>&nbsp</td>
								</tr>
							</table>
						</fieldset>
					</form>
					";
				break;
					
				case 'bgImgUpload':
					echo make_voucher_tabs('bgImg');
					
					echo "<h3>".__('Single-Use Vouchers: Background Uploader','wpShop')."</h3>";
					
					$img_path 	= "../wp-content/themes/".$CONFIG_WPS['themename']."/images/vouchers/";
					$res 		= $VOUCHER->upload_bg_img('imgfile',$img_path,20000000);
					echo $res[0] .'<input type="text" value="'.$res[1].'" readonly="readonly" size="50" /> '.__('was uploaded.','wpShop'); 
					echo "<p>".__('Please copy and save the above image file name under your Theme Options > Shop > PDF Options"','wpShop')."</p>";
				break;
					
				case 'reseller':
					echo make_voucher_tabs('reseller');
					
					if($_GET['subaction'] == 'del'){
						echo "
						<div class='confirm_delete' style='border: red 1px solid;'>
							<p>
								".__('Do you really want to delete this Reseller?','wpShop')." 
								<a href='?page=functions.php&section=vouchers&action=reseller&subaction=del&vid={$_GET[vid]}&confirmed=yes'>".__('Yes','wpShop')."</a> |
								<a href='?page=functions.php&section=vouchers&action=reseller'>".__('No','wpShop')."</a>
							</p>
						</div>";
					}
					if(($_GET['subaction'] == 'del') && ($_GET['confirmed'] == 'yes')){
						$VOUCHER->reseller_delete($_GET[vid]);
						$url = "themes.php?page=functions.php&section=vouchers&action=reseller";
						echo "<meta http-equiv='refresh' content='0; URL=$url'>";
					}
				
					if($_POST){		
						$VOUCHER->reseller_form_check();
																			
						if($VOUCHER->reseller()){		
							$url = "themes.php?page=functions.php&section=vouchers&action=reseller_notify&vc={$_POST[voucher_code]}";
							echo "<meta http-equiv='refresh' content='0; URL=$url'>";
						}
					}					
					else { 
					
						$label_1 = __('Voucher-Code:','wpShop');
						$label_2 = __('Percentage:','wpShop');
						$label_3 = __('Name of Reseller:','wpShop');
						$label_4 = __('Email of Reseller:','wpShop');
						$label_5 = __('Save and Notify','wpShop');
					
						echo "
						<h3>".__('Create Reseller (Multi-Use) Voucher-Codes','wpShop')."</h3>
						<form action='?page=functions.php&section=vouchers&action=reseller' method='post'>
							<table>
								<tr><td>$label_1</td><td><input type='text' name='voucher_code' maxlength='255' /></td></tr>
								<tr><td>$label_2</td><td><input type='text' name='voucher_amount' maxlength='2' /> %</td></tr>
								<tr><td>$label_3</td><td><input type='text' name='receiver' maxlength='255' /></td></tr>
								<tr><td>$label_4</td><td><input type='text' name='receiver_mail' maxlength='255' /></td></tr>
								<tr><td>&nbsp;</td><td><input type='submit' name='save_vcode' value='$label_5' /></td></tr>
							</table>
						</form>
						";

						echo "<h3>".__('Manage your Resellers','wpShop')."</h3>";
						
						$res = $VOUCHER->display_all_resellers();
						
						if(mysql_num_rows($res) == 0){
							_e('You have created No Resellers yet.','wpShop');
						}
						else { ?>
							<div class="tablenav">
								<div class="alignleft actions">
									<?php
										echo "
										<form class='nws_search nws_reseller_search' action='?page=functions.php&section=vouchers&action=reseller' method='get'>
											<input type='hidden' name='page' value='functions.php' />
											<input type='hidden' name='section' value='vouchers' />
											<input type='hidden' name='action' value='reseller' />
											<input type='text' name='resellers_wanted' value='$_GET[resell_wanted]' maxlength='255' />
											<input class='button-secondary action' type='submit' name='search_resellers' value='Search' /><br/>
											<small>".__('Enter a Voucher Code','wpShop')."</small>
										</form>
										";
									?>	
								</div>
								<div class='tablenav-pages'>
									<?php NWS_resellers_pagination(20); ?>	
								</div>
							</div>
							<?php echo $VOUCHER->display_resellers(20);						
						}
					}
				break;
					
				case 'reseller_notify':

					$data 	= $VOUCHER->reseller_data();
					$shop	= $OPTION['blogname'];
				
					echo "<a class='button-secondary' href='mailto:{$data[receiver_mail]}?subject=Your%20reseller%20Voucher-Code%20from%20{$shop}&body=
					".__('Hello ','wpShop')."{$data[receiver]}, ".__('your Reseller Voucher Code is: ','wpShop')."{$data[vcode]}'>".__('Send ','wpShop')."{$data[receiver]}".__(' an email','wpShop')."</a>";
					echo "<a class='button-secondary' href='".get_option('siteurl')."/wp-admin/admin.php?page=functions.php&section=vouchers&action=reseller'>".__('Return to Voucher Overview','wpShop')."</a>";
				
				break;
				
				default;
					echo make_voucher_tabs('upload'); ?>
		
					<script type="text/javascript">
						function add_amount_field(currency){	
							if (document.voucher_form.voucher_option.selectedIndex == 0) {		
								document.getElementById("label_amount_option").innerHTML = "<td>&nbsp;</td>";
							}			
							if (document.voucher_form.voucher_option.selectedIndex == 1) {		
								var label1;
								label1 = document.forms.voucher_form.elements.voucher_option.options[1].text;
								document.getElementById("label_amount_option").innerHTML = "<td>"+ label1 +"</td><td><input name='voucher_amount' type='text' />%</td>";
							}
							if (document.voucher_form.voucher_option.selectedIndex == 2) {
								var label2;
								label2 = document.forms.voucher_form.elements.voucher_option.options[2].text;
								document.getElementById("label_amount_option").innerHTML = "<td>"+ label2 +"</td><td><input name='voucher_amount' type='text' /> "+ currency +"</td>";
							}
							return true;
						}
					</script>
		
					<?php	
					$currency = '"'. $OPTION['wps_currency_code'] .'"';
					echo "	
					<form action='?page=functions.php&section=vouchers&action=upload' enctype='multipart/form-data' name='voucher_form' id='voucher_form' method='post'>
						<h3>".__('Single-Use Vouchers: Code Uploader','wpShop')."</h3>
						<fieldset>
							<table>
								<tr>
									<td colspan='2'><small>".__('Remember that a Fixed Amount Voucher can only be deducted if the Buyer\'s Shopping Basket Total is more that the Vousher\'s Value!','wpShop')."</small></td>
								</tr>
								<tr>
									<td>".__('Voucher Option','wpShop')."</td>
								 <td>
									<select name='voucher_option' id='voucher_option' onchange='return add_amount_field($currency)' size='1'>
										<option value='nc' selected='selected'>".__('Pls select','wpShop')."</option>
										<option value='P'>".__('Percentage','wpShop')."</option>
										<option value='A'>".__('Fixed amount','wpShop')."</option>
									</select>
								</tr>					
								<tr id='label_amount_option'></tr>
								
								<tr>
									<td>".__('Voucher Code Text File','wpShop')."</td>
									<td><input name='csvfile' type='file' /></td>
								</tr>
								<tr>
									<td colspan='2'><small>".__('[Please keep in mind: It has to be a .txt file - Size: not more than 100KB.]','wpShop')."</small></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td><input type='submit' value='Submit' /></td>
								</tr>
								<tr>
									<td colspan='2'>&nbsp</td>
								</tr>
							</table>
						</fieldset>
					</form>
					";
				break;	
			}
				
			echo  make_section_footer();
			
		break;		
		
		case 'members':
			echo make_section_header('members'); ?>
			<h3><?php _e('Registered Customers','wpShop')?></h3>
			<div class="tablenav">
				<div class="alignleft actions">
					<?php
						echo "
						<form class='nws_search nws_memb_search' action='?page=functions.php&section=members' method='get'>
							<input type='hidden' name='page' value='functions.php' />
							<input type='hidden' name='section' value='members' />
							<input type='text' name='memb_wanted' value='$_GET[memb_wanted]' maxlength='255' />
							<input class='button-secondary action' type='submit' name='search_memb' value='Search' /><br/>
							<small>".__('Enter a Last Name','wpShop')."</small>
						</form>
						";
					?>	
				</div>
				<div class='tablenav-pages'>
					<?php NWS_members_pagination(20); ?>	
				</div>
			</div>
			
			<?php switch($_GET['action']){
				case 'del':
				
					if($_GET['confirmed'] == 'yes'){
						member_delete($_GET[uid]);	
						$url = "themes.php?page=functions.php&section=members";
						echo "<meta http-equiv='refresh' content='0; URL=$url'>";
					}
					else{
						echo "
						<div class='warning confirm_delete'>
							<p>
								".__('Are you sure that you want to delete this member?','wpShop')." 
								<a href='?page=functions.php&section=members&action=del&uid={$_GET[vid]}&confirmed=yes'>".__('Yes','wpShop')."</a> |
								<a href='?page=functions.php&section=members'>".__('No','wpShop')."</a>
							</p>
						</div>";
					}			
				break;
			}
		
			echo display_members(20);
			echo make_section_footer();
		break;

		case 'statistics':
			provide_statistics('Statistics','orange','25px','black');	
			
			display_tax_data_backend();
		break;
				
		case 'checks':
			attributesDataChecker(1);
			echo "<div id='message' class='updates_saved'><p><strong>".__('Cleanup Successfully Completed','wpShop')."</p></div>
			<p><a class='button-secondary action' href='admin.php?page=functions.php'>".__('Return','wpShop')."</a></p>";
		break;
		
		default: ?>
			<div class="wrap">
				<?php if ($_REQUEST['saved']){
					echo '<div id="message" class="updates_saved"><p><strong>'.$CONFIG_WPS['themename'].' settings saved.</strong></p></div>';
				}
				
				if($install_status > 7){ 
					//if the theme is installed then create the main tabs 
					?>
					<ul class="tabs mainTabs"> 
						<?php 
						
						echo "<li><a class='active' href='#'>".__('Theme Options','wpShop')."</a></li>";
						//using the shopping cart?
						if($OPTION['wps_shoppingCartEngine_yes']) {
							if($OPTION['wps_shop_mode'] == 'Normal shop mode'){ 
								echo "<li><a href='?page=functions.php&section=orders'>".__('Manage Orders','wpShop')."</a></li>";
							}elseif($OPTION['wps_shop_mode'] == 'Inquiry email mode'){
								echo "<li><a href='?page=functions.php&section=inquiries'>".__('Manage Enquiries','wpShop')."</a></li>";
							}elseif($OPTION['wps_shop_mode'] == 'payloadz_mode'){
								echo "<li><a href='https://www.payloadz.com/' target=_blank>".__('PayLoadz','wpShop')."</a></li>";
							}else {}
						
							// tracking inventory?
							if($OPTION['wps_track_inventory']=='active'){
								echo "<li><a href='?page=functions.php&section=inventory'>".__('Manage Inventory','wpShop')."</a></li>";
							}
							//using License Keys?
							$l_mode = $OPTION['wps_l_mode'];
							if(($l_mode == 'GIVE_KEYS')&&($OPTION['wps_shop_mode'] != 'payloadz_mode')&&($OPTION['wps_shop_mode'] != 'Inquiry email mode')){ 
								echo "<li><a href='?page=functions.php&section=lkeys'>".__('Upload L-Keys','wpShop')."</a></li>";
							}
							// using vouchers?
							if ($OPTION['wps_voucherCodes_enable']) {
								echo "<li><a href='?page=functions.php&section=vouchers'>".__('Vouchers','wpShop')."</a></li>";
							}
						}
						//using a membership area?
						if($OPTION['wps_lrw_yes']) {
							echo "<li><a href='?page=functions.php&section=members'>".__('Members','wpShop')."</a></li>";
						}
						
						//using the shopping cart?
						if($OPTION['wps_shoppingCartEngine_yes']) {
							echo "<li><a href='?page=functions.php&section=statistics'>".__('Statistics','wpShop')."</a></li>";
						}
						
						?>
					</ul>
						
				<?php } else {
					// install status below 8 = we install
					
					include '../wp-content/themes/'.WPSHOP_THEME_NAME.'/lib/engine/install_actions.php';
					
					$FS_INSTALL 		= new nws_installation_wiz();
					
					$install_step_info 	= $install_status + 1;
					echo $FS_INSTALL->install_wizard_header($install_step_info);	
					
					$shopID 		= shop_cat($OPTION['wps_shop_slug']);
					$featuredID 	= featured_cat($OPTION['wps_featured_slug']);
					$install_fb 	= $FS_INSTALL->theme_install($install_status,$shopID,$featuredID);
					
					if($install_fb == 3){
						$install_status = 3;
					}
				}

				if($install_status == 8){ 			
				?>
				

					<form method="post" action="themes.php?page=functions.php" class="nws_admin_options nws_admin_settings">
						<?php foreach ($options as $value) {

							switch ( $value['type'] ) {

								case "open":?>
									<table width="100%" border="0" style="background-color:#f9f9f9; padding:10px;">
								<?php break;

								case "close":?>
									</table><br />
								<?php break;
								
								case "heading": ?>
									<h2 class="<?php echo $value['class']; ?>" style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo __($value['name'], 'wpShop'); ?></h2>
								<?php break;
								
								case "section_start": ?>
									<div class="<?php echo $value['class'] ?>">
								<?php break;

								case "section_end": ?>
									</div>
								<?php break;
								
								case "fieldset_start": ?>
									<fieldset class="<?php echo $value['class'] ?>" id="<?php echo $value['id'] ?>">
								<?php break;

								case "fieldset_end": ?>
									</fieldset>
								<?php break;

								case "title": ?>
									<table id="<?php echo $value['id']; ?>" width="100%" border="0" style="background-color:#ececec; padding:5px 10px;">
									<tr>
										<td colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo __($value['name'], 'wpShop'); ?></h3></td>
									</tr>
								<?php break;

								case 'text': ?>
									<tr>
										<td width="20%" rowspan="2" valign="middle"><strong><?php echo __($value['name'], 'wpShop'); ?></strong></td>
										<td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'] )); } else { echo stripslashes($value['std']); } ?>" /></td>
									</tr>

									<tr>
										<td><small><?php echo $value['desc']; ?></small></td>
									</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
								<?php break;
								
								case 'text-link': ?>
									<tr>
										<td width="20%" valign="middle"><strong><?php echo __($value['name'], 'wpShop'); ?></strong></td>
										<td width="80%"><small><?php echo $value['desc']; ?></small></td>
									</tr>
									<tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr>
									<tr><td colspan="2">&nbsp;</td></tr>
								<?php break;

								case 'text_invisible': ?>
									<tr>
										<td width="20%" rowspan="2" valign="middle"><strong><?php echo __($value['name'], 'wpShop'); ?></strong></td>
										<td width="80%">&nbsp;</td>
									</tr>

									<tr>
										<td><small><?php echo $value['desc']; ?></small></td>
									</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
								<?php break;

								case 'textarea': ?>
									<tr>
										<td width="20%" rowspan="2" valign="middle"><strong><?php echo __($value['name'], 'wpShop'); ?></strong></td>
										<td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if(get_settings( $value['id'] ) != "") { echo stripslashes(get_settings( $value['id'])); } else { echo stripslashes($value['std']); } ?></textarea></td>
									</tr>
									<tr>
										<td><small><?php echo $value['desc']; ?></small></td>
									</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
								<?php break;

								case 'select': ?>
									<tr>
										<td width="20%" rowspan="2" valign="middle"><strong><?php echo __($value['name'], 'wpShop'); ?></strong></td>
										<td width="80%"><select style="width:240px;" 
										name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
										<?php 
										
												$o 		= get_settings($value['id']);
												$len	= strlen($o);
										
											foreach ($value['vals'] as $option) {
											
											
												?><option<?php 	
												if($len > 0){
													if(get_settings( $value['id']) == $option) { 
														echo ' selected="selected"'; 
													} 			
												}
												else {
													if($option == $value['std']){
														echo ' selected="selected"'; 
													}
												}
												?>><?php echo $option ?></option><?php 
											} 			
											?></select></td>
									</tr>
									<tr>
										<td><small><?php echo $value['desc']; ?></small></td>
									</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
								<?php break;

								case 'select2': ?>
									<tr>
										<td width="20%" rowspan="2" valign="middle"><strong><?php echo __($value['name'], 'wpShop'); ?></strong></td>
										<td width="80%"><select style="width:240px;" 
										name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
										<?php
										
											$o 		= get_settings($value['id']);
											$len	= strlen($o);
										
											foreach ($value['vals'] as $option) {
														
												$parts = explode("|",$option);
												
												if($len > 0){	// a value was already chosen 
												
													if(get_settings($value['id']) == $parts[1]){
														$selected = 'selected="selected"';
													}
													else{
														$selected = NULL;
													}
												}
												else {  // a value was not previously chosen, we fall back on std
													if($parts[1] == $value['std']){
														$selected = 'selected="selected"';
													}
													else{
														$selected = NULL;
													}			
												}
																
												$op = "<option value='$parts[1]' $selected >$parts[0]</option>";
												echo $op;	
											} 			
											?>
											</select></td>
									</tr>
									<tr>
										<td><small><?php echo $value['desc']; ?></small></td>
									</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
								<?php break;

								case 'pathinfo': ?>
									<tr>
										<td width="20%" rowspan="2" valign="middle"><strong><?php echo __($value['name'], 'wpShop'); ?></strong></td>
										<td width="80%"><input readonly="readonly" style="width:400px;" name="<?php echo $value['id']; ?>" 
										id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" 
										value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
										</td>
									</tr>

									<tr>
										<td><small><?php echo $value['desc']; ?></small></td>
									</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
								<?php break;
								
								
								
								case 'pathinfo2': ?>
									<tr>
										<td width="20%" rowspan="2" valign="middle"><strong><?php echo __($value['name'], 'wpShop'); ?></strong></td>
										<td width="80%"><input readonly="readonly" style="width:700px;" name="<?php echo $value['id']; ?>" 
										id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" 
										value="<?php echo $value['vals'] ?>" />
										</td>
									</tr>
									<tr>
										<td><small><?php echo $value['desc']; ?></small></td>
									</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
								<?php break;
								
								
								
								case "iframe": ?>
									<tr>
									<td width="20%" rowspan="2" valign="middle"><strong><?php echo __($value['name'], 'wpShop'); ?></strong></td>
										<td id='the_zones' width="80%">
											<iframe src="<?php echo $value['vals'] ?>" width="90%" height="400" name="<?php echo $value['id'] ?>"></iframe>
											</td>       
									</tr>
									<tr>
										<td><small><?php echo $value['desc']; ?></small></td>
								   </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
								<?php break;

								case "checkbox": ?>
									<tr>
									<td width="20%" rowspan="2" valign="middle"><strong><?php echo __($value['name'], 'wpShop'); ?></strong></td>
										<td width="80%"><?php if(get_settings($value['id']) == 'true'){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
												<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
												</td>
									</tr>

									<tr>
										<td><small><?php echo $value['desc']; ?></small></td>
								   </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

								<?php break;

								case "multi-checkbox": ?>
									<tr>
									<td width="20%" rowspan="2" valign="middle"><strong><?php echo __($value['name'], 'wpShop'); ?></strong></td>
										<td width="80%">

											<?php			
											$table  = $wpdb->prefix . 'options';
											$qStr 	= "SELECT option_value FROM $table WHERE option_name = '$value[id]' LIMIT 0,1";
											$res 	= mysql_query($qStr);
											$row 	= mysql_fetch_assoc($res);			
											$payP	= explode("|",$row['option_value']);
									
											foreach($value['vals'] as $k => $v){	

												$data 		= explode("|",$v);
											
												if(in_array($data[1],$payP)){	
													$checked = "checked=\"checked\""; 
												}else{ 
													$checked = ""; 
												} 
											?>		
												<input type="checkbox" name="<?php echo $value['id'];?>|<?php echo $data[1];?>" id="<?php echo $value['id']; ?>|<?php echo $data[1];?>" value="true" <?php echo $checked; ?> /><?php echo "$data[0] <br/>";  
											} ?>
										</td>
									</tr>
									<tr>
										<td><small><?php echo $value['desc']; ?></small></td>
								   </tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px solid #DFDFDF;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>

								<?php break;								
							}
						} ?>

						<div id="themeOptionsSave">
							<p class="submit">
								<input name="save" type="submit" value="Save changes" />
								<input type="hidden" name="action" value="save" /><br/>
								<small><?php _e('The save button will save all theme options so there\'s no need to save each section separately.','wpShop') ?></small>
							</p>
						</div>
					</form>

				<?php } ?>
			</div><!-- wrap -->
		<?php 
		break;
	}
	
}

##################################################################################################################################
// 												DASHBOARD -WIDGETS
##################################################################################################################################

/**
 * Content of Dashboard-Widget
 */
function NWS_dashboard() {
	global $CONFIG_WPS,$OPTION; 
	//collect info
	if($OPTION['wps_shoppingCartEngine_yes']) {
	
		if($OPTION['wps_shop_mode'] == 'Normal shop mode'){ 
			$totalOrders 		= NWS_total_orders_there();
			$totalEarnings 		= NWS_total_earnings_there();
		} elseif($OPTION['wps_shop_mode'] == 'Inquiry email mode'){
			$totalEnquiries 	= NWS_total_enquiries_there(); 
		} else {}
		
		if($OPTION['wps_track_inventory'] == 'active'){
			$totalProds 		= NWS_total_prods_there();
		}
		
		if ($OPTION['wps_voucherCodes_enable']) {
			$totalVouchers 		= NWS_total_vouchers_there();
		}
		
		if($OPTION['wps_lrw_yes']) {
			$totalMembers 		= NWS_total_members_there();
			$activeWishlists	= NWS_activeWishlists_there();
		}
	} ?>
	
	<div class="clearfix">
		<?php 
		
		if($OPTION['wps_dash_widget'] !='') { echo $OPTION['wps_dash_widget'];}
		
		//using the shopping cart?
		if($OPTION['wps_shoppingCartEngine_yes']) {
			if($OPTION['wps_shop_mode'] == 'Normal shop mode'){
				echo "<p>
					<img class='new_orders_img' src='../wp-content/themes/".$CONFIG_WPS['themename']."/images/admin/lightbulb_48.png' border='0'/>";
				
					if($totalOrders['new'] == 1){
						$txt = __('New Order to be Processed','wpShop');
					}
					if($totalOrders['new'] > 1){
						$txt = __('New Orders to be Processed','wpShop');
					}
					if($totalOrders['new'] == 0){
						$txt = __('No New Orders!','wpShop');
					} 
					echo __('You have','wpShop')."<strong> ".$totalOrders['new']." </strong>".$txt;
					
				echo "</p>";
				echo "<p>".__('You can manage your orders from the','wpShop')." <a href='".get_option('siteurl') ."/wp-admin/themes.php?page=functions.php&section=orders'>".__('"Manage Orders"','wpShop')."</a> ".__('panel.','wpShop')."</p>";
				
			} elseif($OPTION['wps_shop_mode'] == 'Inquiry email mode'){
				echo "<p>
					<img class='new_orders_img' src='../wp-content/themes/".$CONFIG_WPS['themename']."/images/admin/lightbulb_48.png' border='0'/>";
				
					if($totalEnquiries['new'] == 1){
						$txt = __('New Enquiry to be Processed','wpShop');
					}
					if($totalEnquiries['new'] > 1){
						$txt = __('New Enquiries to be Processed','wpShop');
					}
					if($totalEnquiries['new'] == 0){
						$txt = __('No New Enquiries!','wpShop');
					} 
					echo __('You have','wpShop')."<strong> ".$totalEnquiries['new']." </strong>".$txt;
				echo "</p>";
				echo "<p>".__('You can manage your Enquiries from the','wpShop')." <a href='".get_option('siteurl') ."/wp-admin/themes.php?page=functions.php&section=inquiries'>".__('"Manage Enquiries"','wpShop')."</a> ".__('panel.','wpShop')."</p>";
			
			} ?>
			
			<div class="at_a_glance orders_at_a_glance clearfix">
				<?php if($OPTION['wps_shop_mode'] == 'Normal shop mode'){ ?>
					<h4><?php _e('Orders Overview','wpShop');?></h4>
				<?php } elseif($OPTION['wps_shop_mode'] == 'Inquiry email mode'){ ?>
					<h4><?php _e('Enquiries Overview','wpShop');?></h4>
				<?php } ?>
				
				<table class="widefat">
					<thead>
						<tr class="alternate">
						<?php if($OPTION['wps_shop_mode'] == 'Normal shop mode'){
							if($totalOrders['pending']){ ?>
							<th><?php _e('Pending Payments','wpShop');?></th>
							<?php } ?>
							<th><?php _e('New','wpShop');?></th>
							<th><?php _e('In Process','wpShop');?></th>
							<th><?php _e('Shipped','wpShop');?></th>
							<th><?php _e('Completed','wpShop');?></th>
							
						<?php } elseif($OPTION['wps_shop_mode'] == 'Inquiry email mode'){ ?>
							<th><?php _e('New','wpShop');?></th>
							<th><?php _e('Replied To','wpShop');?></th>
						<?php } ?>
							<th><?php _e('Total','wpShop');?></th>
						</tr>
					</thead>
					
					<tbody>
					   <tr>
					   <?php 
					   if($OPTION['wps_shop_mode'] == 'Normal shop mode'){
							if($totalOrders['pending']){ ?>
							<td><p><?php if ($totalOrders['pending']) { echo $totalOrders['pending']; } else { echo __('0','wpShop'); } ?></p></td>
							<?php } ?>
							<td><p><?php if ($totalOrders['new']) { echo $totalOrders['new']; } else { echo __('0','wpShop'); } ?></p></td>
							<td><p><?php if ($totalOrders['in_process']) { echo $totalOrders['in_process']; } else { echo __('0','wpShop'); } ?></p></td>
							<td><p><?php if ($totalOrders['shipped']) { echo $totalOrders['shipped']; } else { echo __('0','wpShop'); } ?></p></td>
							<td><p><?php if ($totalOrders['completed']) { echo $totalOrders['completed']; } else { echo __('0','wpShop'); } ?></p></td>
							<td><p><?php if ($totalOrders['all']) { echo $totalOrders['all']; } else { echo __('0','wpShop'); } ?></p></td>
						<?php } elseif($OPTION['wps_shop_mode'] == 'Inquiry email mode'){ ?>
							<td><p><?php if ($totalEnquiries['new']) { echo $totalEnquiries['new']; } else { echo __('0','wpShop'); } ?></p></td>
							<td><p><?php if ($totalEnquiries['replied']) { echo $totalEnquiries['replied']; } else { echo __('0','wpShop'); } ?></p></td>
							<td><p><?php if ($totalEnquiries['all']) { echo $totalEnquiries['all']; } else { echo __('0','wpShop'); } ?></p></td>
						<?php } ?>
						</tr>
					</tbody>
				</table>
				<?php if($OPTION['wps_shop_mode'] == 'Normal shop mode'){
					$link_txt = __('Manage Orders','wpShop');
					$link = get_option('siteurl').'/wp-admin/admin.php?page=functions.php&section=orders';
				} elseif($OPTION['wps_shop_mode'] == 'Inquiry email mode'){
					$link_txt = __('Manage Enquiries','wpShop');
					$link = get_option('siteurl').'/wp-admin/admin.php?page=functions.php&section=inquiries';
				} ?>
				<a class="button-secondary" href="<?php echo $link;?>"><?php echo $link_txt;?></a>
			</div><!-- at_a_glance-->
			
			<?php 
			// if using the Regular Shop Mode
			if($OPTION['wps_shop_mode'] == 'Normal shop mode'){ ?>
				<div class="at_a_glance sales_at_a_glance clearfix">
					<h4><?php _e('Earnings Overview','wpShop');?></h4>
					
					<table class="widefat">
						<thead>
							<tr class="alternate">
								<th><?php _e('Today','wpShop');?></th>
								<th><?php _e('This Week','wpShop');?></th>
								<th><?php _e('This Month','wpShop');?></th>
								<th><?php _e('This Year','wpShop');?></th>
								<th><?php _e('All Time','wpShop');?></th>
							</tr>
						</thead>
						
						<tbody>
						   <tr>
								<td><p><?php if ($totalEarnings['today']) { if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($totalEarnings['today']); if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; } if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } } else { echo __('No Sales yet Today','wpShop'); }?></p></td>
								<td><p><?php if ($totalEarnings['week']) { if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($totalEarnings['week']); if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; } if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } } else { echo __('No Sales yet this Week','wpShop'); }?></p></td>
								<td><p><?php if ($totalEarnings['month']) { if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($totalEarnings['month']); if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; } if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } } else { echo __('No Sales yet this Month','wpShop'); }?></p></td>
								<td><p><?php if ($totalEarnings['year']) { if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($totalEarnings['year']); if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; } if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } } else { echo __('No Sales yet this Year','wpShop'); }?></p></td>
								<td><p><?php if ($totalEarnings['all']) { if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price($totalEarnings['all']); if($OPTION['wps_currency_code_enable']) { echo " " . $OPTION['wps_currency_code']; } if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } } else { echo __('No Sales yet','wpShop'); }?></p></td>
						   </tr>
						</tbody>
					</table>
				</div><!-- at_a_glance-->
			<?php } 
			
			//if inventory tracking is on
			if($OPTION['wps_track_inventory'] == 'active'){ ?>
				<div class="at_a_glance inventory_at_a_glance clearfix">
					<h4><?php _e('Inventory Overview','wpShop');?></h4>
					
					<table class="widefat">
						<thead>
							<tr class="alternate">
								<th><?php _e('Product Variations','wpShop');?></th>
								<th><?php _e('Low in Stock','wpShop');?></th>
								<th><?php _e('Out of Stock','wpShop');?></th>
							</tr>
						</thead>
						
						<tbody>
						   <tr>
								<td><p><?php if ($totalProds['all']) { echo $totalProds['all']; } else { echo __('None Found','wpShop'); }?></p></td>
								<td><p><?php if ($totalProds['low']) { echo $totalProds['low']; } else { echo __('None Low in Stock','wpShop'); }?></p></td>
								<td><p><?php if ($totalProds['out']) { echo $totalProds['out']; } else { echo __('None Out of Stock','wpShop'); }?></p></td>
						   </tr>
						</tbody>
					</table>
					<?php
					$link_txt = __('Manage Inventory','wpShop');
					$link = get_option('siteurl').'/wp-admin/admin.php?page=functions.php&section=inventory';
					?>
					<a class="button-secondary" href="<?php echo $link;?>"><?php echo $link_txt;?></a>
				</div><!-- at_a_glance-->
			<?php }
			
			//if vouchers are used
			if ($OPTION['wps_voucherCodes_enable']) { ?>
				<div class="at_a_glance vouchers_at_a_glance clearfix">
					<h4><?php _e('Voucher Overview','wpShop');?></h4>
					
					<table class="widefat">
						<thead>
							<tr class="alternate">
								<th><?php _e('Total','wpShop');?></th>
								<th><?php _e('Single-Use','wpShop');?></th>
								<th><?php _e('Multi-Use','wpShop');?></th>
							</tr>
						</thead>
						
						<tbody>
						   <tr>
								<td><p><?php if ($totalVouchers['all']) { echo $totalVouchers['all']; } else { echo __('None Found','wpShop'); }?></p></td>
								<td>
									<p><?php if ($totalVouchers['single_use']) { echo $totalVouchers['single_use']; } else { echo __('None Found','wpShop'); }?></p>
									<p><?php _e('Of these Redeemed ','wpShop'); if ($totalVouchers['single_use'] && $totalVouchers['redeemed']) { echo $totalVouchers['redeemed']; } else { echo __('0','wpShop'); }?></p>
									<p><?php _e('Of these Unclaimed ','wpShop'); if ($totalVouchers['single_use'] && $totalVouchers['unclaimed']) { echo $totalVouchers['unclaimed']; } else { echo __('0','wpShop'); }?></p>
								</td>
								<td><p><?php if ($totalVouchers['multi_use']) { echo $totalVouchers['multi_use']; } else { echo __('None Found','wpShop'); }?></p></td>
						   </tr>
						</tbody>
					</table>
					<?php
					$link_txt = __('Manage Vouchers','wpShop');
					$link = get_option('siteurl').'/wp-admin/admin.php?page=functions.php&section=vouchers';
					?>
					<a class="button-secondary" href="<?php echo $link;?>"><?php echo $link_txt;?></a>
				</div><!-- at_a_glance-->
				
			<?php }
			// using the membership area?
			if($OPTION['wps_lrw_yes']) { ?>
				<div class="at_a_glance members_at_a_glance clearfix">
					<h4><?php _e('Members Overview (Registered Customers)','wpShop');?></h4>
					
					<table class="widefat">
						<thead>
							<tr class="alternate">
								<th><?php _e('Total Registered','wpShop');?></th>
								<th><?php _e('Active Wishlists','wpShop');?></th>
							</tr>
						</thead>
						
						<tbody>
						   <tr>
								<td><p><?php if ($totalMembers['all']) { echo $totalMembers['all']; } else { echo __('No Registered Members','wpShop'); }?></p></td>
								<td><p><?php if ($activeWishlists != '') { echo $activeWishlists; } else { echo __('None Active','wpShop'); }?></p></td>
							 </tr>
						</tbody>
					</table>
					<?php
					$link_txt = __('Manage Members','wpShop');
					$link = get_option('siteurl').'/wp-admin/admin.php?page=functions.php&section=members';
					?>
					<a class="button-secondary" href="<?php echo $link;?>"><?php echo $link_txt;?></a>
				</div><!-- at_a_glance-->
				
			<?php }
		} ?>
	</div>
<?php }
 
/**
 * add Dashboard Widget via function wp_add_dashboard_widget()
 */
function NWS_wp_dashboard_Init() {
	global $CONFIG_WPS;
	//only display for Admin
	if (current_user_can('level_10')) {
		wp_add_dashboard_widget( 'NWS_dashboard', __( 'Welcome to ' ,'wpShop').$CONFIG_WPS['themename'].__( ' Dashboard' ,'wpShop'), 'NWS_dashboard');
	}
}
 
/**
 * use hook, to integrate new widget
 */
add_action('wp_dashboard_setup', 'NWS_wp_dashboard_Init'); 

function NWS_hook_module($identifier,$module_data){

	global $options;

	//where in the $options array do we add the module data
	$counter 	= 1;
	$position 	= 0;
	
	foreach($options as $k => $v){
		if($k == $identifier){
			$position = $counter;
		}
		$counter++;
	}
	
	//now add module data into array
	if($position !== 0){
		array_splice($options,$position,1,$module_data);
	}
	else {
		echo 'No hook for ' . $identifier . ' found.';
	}

return $position;
}

NWS_hook_module('tax_module_data_follows',$tax_MODULE_DATA);
?>