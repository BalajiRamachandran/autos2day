<?php
##################################################################################################################################
// 												Register Widget Areas
##################################################################################################################################

// Register widgetized areas - upto 29!
function theme_widgets_init() {
	
	global $OPTION;

// index page 5 col 1
	register_sidebar( array (
		'name' 			=> 'Frontpage Left1(5 col)',
		'id' 			=> 'frontpage_5left1_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
// index page 5 col 2
	register_sidebar( array (
		'name' 			=> 'Frontpage Left2(5 col)',
		'id' 			=> 'frontpage_5left2_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
// index page 5 col 3
	register_sidebar( array (
		'name' 			=> 'Frontpage middle(5 col)',
		'id' 			=> 'frontpage_5middle_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
// index page 5 col 4
	register_sidebar( array (
		'name' 			=> 'Frontpage Right1(5 col)',
		'id' 			=> 'frontpage_5right1_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
// index page 5 col 5
	register_sidebar( array (
		'name' 			=> 'Frontpage Right2(5 col)',
		'id' 			=> 'frontpage_5right2_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
// index page 3 col left
	register_sidebar( array (
		'name' 			=> 'Frontpage Left(3 col)',
		'id' 			=> 'frontpage_3left_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
// index page 3 col middle
	register_sidebar( array (
		'name' 			=> 'Frontpage Middle(3 col)',
		'id' 			=> 'frontpage_3middle_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
// index page 3 col right
	register_sidebar( array (
		'name' 			=> 'Frontpage Right(3 col)',
		'id' 			=> 'frontpage_3right_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
// index page 2 col left
	register_sidebar( array (
		'name' 			=> 'Frontpage Left(2 col)',
		'id' 			=> 'frontpage_2left_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
// index page 2 col right
	register_sidebar( array (
		'name' 			=> 'Frontpage Right(2 col)',
		'id' 			=> 'frontpage_2right_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
// index page single
	register_sidebar( array (
		'name' 			=> 'Frontpage Single(1 col)',
		'id' 			=> 'frontpage_single_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
// page
	register_sidebar( array (
		'name' 			=> 'Page',
		'id' 			=> 'page_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));

if($OPTION['wps_aboutPg']!='Select a Page') {	
// about page
	register_sidebar( array (
		'name' 			=> 'About Page',
		'id' 			=> 'about_page_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}

if($OPTION['wps_contactPg']!='Select a Page') {		
// contact page
	register_sidebar( array (
		'name' 			=> 'Contact Page',
		'id' 			=> 'contact_page_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}
if($OPTION['wps_lrw_yes']) {

	if($OPTION['wps_pgNavi_regOption']!='Select a Page' && is_pagetemplate_active('accountRegister.php')) {	
		// account register
		register_sidebar( array (
			'name' 			=> 'Account Register Page',
			'id' 			=> 'account_reg_widget_area',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h2 class="widget-title">',
			'after_title' 	=> '</h2>',
		));
	}

	if($OPTION['wps_pgNavi_logOption']!='Select a Page' && is_pagetemplate_active('accountLogin.php')) {
	
		// account sign in
		register_sidebar( array (
			'name' 			=> 'Account Login Page',
			'id' 			=> 'account_log_widget_area',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h2 class="widget-title">',
			'after_title' 	=> '</h2>',
		));
	}

	if($OPTION['wps_customerAreaPg']!='Select a Page' && is_pagetemplate_active('accountCustomerArea.php')) {
		// customer area
		register_sidebar( array (
			'name' 			=> 'Customer Membership Area',
			'id' 			=> 'customer_area_widget_area',
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
			'after_widget' 	=> '</div></div>',
			'before_title' 	=> '<h2 class="widget-title">',
			'after_title' 	=> '</h2>',
		));
	}
}

if($OPTION['wps_customerServicePg']!='Select a Page' && is_pagetemplate_active('customerService.php')) {		
// main customer service
	register_sidebar( array (
		'name' 			=> 'Customer Service Main Page',
		'id' 			=> 'main_customer_service_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s csw main_csw"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
// sub customer service
	register_sidebar( array (
		'name' 			=> 'Customer Service SubPage',
		'id' 			=> 'sub_customer_service_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}

if($OPTION['wps_pgNavi_searchOption']!='Select a Page' && is_pagetemplate_active('mySearch.php')) {	
// search
	register_sidebar( array (
		'name' 			=> 'My Search Page',
		'id' 			=> 'search_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}
// page 404
	register_sidebar( array (
		'name' 			=> 'Page 404',
		'id' 			=> 'page404_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
// specific categories
if($OPTION['wps_mainCat1']!='') {
	register_sidebar( array (
		'name' 			=> 'Category ('.$OPTION['wps_mainCat1'].')',
		'id' 			=> $OPTION['wps_mainCat1'].'_category_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}	
// specific categories
if($OPTION['wps_mainCat2']!='') {
	register_sidebar( array (
		'name' 			=> 'Category ('.$OPTION['wps_mainCat2'].')',
		'id' 			=> $OPTION['wps_mainCat2'].'_category_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}	
// specific categories
if($OPTION['wps_mainCat3']!='') {
	register_sidebar( array (
		'name' 			=> 'Category ('.$OPTION['wps_mainCat3'].')',
		'id' 			=> $OPTION['wps_mainCat3'].'_category_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}	
// specific categories
if($OPTION['wps_mainCat4']!='') {
	register_sidebar( array (
		'name' 			=> 'Category ('.$OPTION['wps_mainCat4'].')',
		'id' 			=> $OPTION['wps_mainCat4'].'_category_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}	
// specific categories
if($OPTION['wps_mainCat5']!='') {
	register_sidebar( array (
		'name' 			=> 'Category ('.$OPTION['wps_mainCat5'].')',
		'id' 			=> $OPTION['wps_mainCat5'].'_category_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}

// specific categories - Blog
if ($OPTION['wps_blogCat']!= 'Select a Category') {
	register_sidebar( array (
		'name' 			=> 'Blog',
		'id' 			=> 'blog_category_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
	// Blog single
	register_sidebar( array (
		'name' 			=> 'Single Blog pages',
		'id' 			=> 'single_blog_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}
	
// category
	register_sidebar( array (
		'name' 			=> 'Category pages',
		'id' 			=> 'category_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
// tags
	register_sidebar( array (
		'name' 			=> 'Tag & Custom Taxonomy pages',
		'id' 			=> 'tag_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	
// archive
	register_sidebar( array (
		'name' 			=> 'Archive pages',
		'id' 			=> 'archive_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widgetPadding clearfix">',
		'after_widget' 	=> '</div></div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
	

//have we activated the large footer option?
if ($OPTION['wps_footer_option'] =='large_footer') {	
// footer left
	register_sidebar( array (
		'name' 			=> 'Footer Left(3 col)',
		'id' 			=> 'footer_left_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));	
	
// footer middle
	register_sidebar( array (
		'name' 			=> 'Footer Middle(3 col)',
		'id' 			=> 'footer_middle_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));	
	
// footer right
	register_sidebar( array (
		'name' 			=> 'Footer Right(3 col)',
		'id' 			=> 'footer_right_widget_area',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h3 class="widget-title">',
		'after_title' 	=> '</h3>',
	));
}	
} // end theme_widgets_init

add_action( 'init', 'theme_widgets_init' );

// Check for static widgets in widget-ready areas
function is_sidebar_active( $index ){
  global $wp_registered_sidebars;

  $widgetcolums = wp_get_sidebars_widgets();
                 
	if ($widgetcolums[$index]){ 
		return true;
	} else {
        return false;
	}
} // end is_sidebar_active

##################################################################################################################################
// 												WIDGETS (23 custom ones!)
##################################################################################################################################

class CategoryRssListWidget extends WP_Widget {

	function CategoryRssListWidget() {
		$widget_ops 	= array('classname' => 'widget_category_rss', 'description' => __( 'Display a category rss list', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-category-rss-list');
		$this->WP_Widget('nws-category-rss-list', __('NWS Category Rss List', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		extract($args);
		$title 		= apply_filters('widget_title', $instance['title'] );
		$orderby 	= $instance['orderby'];
		$order 		= $instance['order'];
		$include 	= $instance['include'];
		$exclude 	= $instance['exclude'];
		$feed_image = $instance['feed_image'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Make the Category RSS List widget
		$catRssArg 	= array(
			'include'    	=> $include,
			'exclude'		=> $exclude,
			'title_li'		=> '', 
			'orderby'       => $orderby,
			'order'         => $order,
			'hide_empty'    => 0,
			'depth'			=> 1,
			'feed_image'	=> $feed_image,
			'feed'			=> 'XML Feed',
			'optioncount'	=> 1,
			'children'		=> 0
		); ?>
		<ul class="catRssFeed">
			<?php wp_list_categories($catRssArg); ?>
		</ul>
		<?php
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 		= strip_tags($new_instance['title']);
		$instance['orderby'] 	= $new_instance['orderby'];
		$instance['order'] 		= $new_instance['order'];
		$instance['include'] 	= $new_instance['include'];
		$instance['exclude'] 	= $new_instance['exclude'];
		$instance['feed_image'] = $new_instance['feed_image'];
		return $instance;
	}
	
	function form($instance){
		//Set up some default widget settings.
		$defaults = array( 'title' => __('Subscribe', 'wpShop'), 'orderby' => 'name', 'order' => 'ASC', 'include' => '', 'exclude' => '', 'feed_image' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'include' ); ?>"><?php _e('Include:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'include' ); ?>" name="<?php echo $this->get_field_name( 'include' ); ?>" value="<?php echo $instance['include']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><?php _e('Exclude:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" value="<?php echo $instance['exclude']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'feed_image' ); ?>"><?php _e('Feed Image(full path):', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'feed_image' ); ?>" name="<?php echo $this->get_field_name( 'feed_image' ); ?>" value="<?php echo $instance['feed_image']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('Order By:', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" class="widefat" style="width:97%;">
				<option value="ID" <?php selected('ID', $instance["orderby"]); ?>><?php _e('ID', 'wpShop'); ?></option>
				<option value="name" <?php selected('name', $instance["orderby"]); ?>><?php _e('name', 'wpShop'); ?></option>
				<option value="slug" <?php selected('slug', $instance["orderby"]); ?>><?php _e('slug', 'wpShop'); ?></option>
				<option value="count" <?php selected('count', $instance["orderby"]); ?>><?php _e('count', 'wpShop'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Order:', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" style="width:97%;">
				<option value="ASC" <?php selected('ASC', $instance["order"]); ?>><?php _e('ASC', 'wpShop'); ?></option>
				<option value="DESC" <?php selected('DESC', $instance["order"]); ?>><?php _e('DESC', 'wpShop'); ?></option>
			</select>
		</p>
		
		
	<?php }
}

//store categories widget
class StoreCategoriesWidget extends WP_Widget {

	function StoreCategoriesWidget() {
		$widget_ops 	= array('classname' => 'widget_categories', 'description' => __( 'Display your Store Categories- for use on Pages.', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-store-categories');
		$this->WP_Widget('nws-store-categories', __('NWS Store Categories', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		extract($args);
		$title 		= apply_filters('widget_title', $instance['title'] );
		$orderby 	= $instance['orderby'];
		$order 		= $instance['order'];
		$include 	= $instance['include'];
		$exclude 	= $instance['exclude'];
		
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		$titleLi	='';
		$catMenuArg 	= array(
			'exclude'    	=> $exclude,
			'include'    	=> $include,
			'title_li'		=> $titleLi, 
			'orderby'       => $orderby,
			'order'         => $order,
			'depth'			=>1,
			'hide_empty'	=>0,
			
		); ?>
		
		<ul>
			<?php wp_list_categories($catMenuArg);?>
		</ul>
		
		<?php
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 		= strip_tags($new_instance['title']);
		$instance['include'] 	= $new_instance['include'];
		$instance['exclude'] 	= $new_instance['exclude'];
		$instance['orderby'] 	= $new_instance['orderby'];
		$instance['order'] 		= $new_instance['order'];
		
		return $instance;
	}
	
	function form($instance){
		//Set up some default widget settings. 
		$defaults = array( 'title' => '', 'include' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'include' ); ?>"><?php _e('Include:', 'wpShop'); ?></label><br/>
			<small><?php _e('You can only use either include or exclude, not both!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'include' ); ?>" name="<?php echo $this->get_field_name( 'include' ); ?>" value="<?php echo $instance['include']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'exclude' ); ?>"><?php _e('Exclude:', 'wpShop'); ?></label><br/>
			<small><?php _e('You can only use either include or exclude, not both!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'exclude' ); ?>" name="<?php echo $this->get_field_name( 'exclude' ); ?>" value="<?php echo $instance['exclude']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Order:', 'wpShop'); ?></label><br/>
			<small><?php _e('Your options are: ASC or DESC. Case Sensitive!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" value="<?php echo $instance['order']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('Order By:', 'wpShop'); ?></label><br/>
			<small><?php _e('Your options are: name, ID, slug, count. Case Sensitive!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>" value="<?php echo $instance['orderby']; ?>" style="width:97%;" />
		</p>
		
	<?php }
}

//pages widget
class PagesListWidget extends WP_Widget {

	function PagesListWidget() {
		$widget_ops 	= array('classname' => 'widget_pages_list', 'description' => __( 'Display a pages list', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-pages-list');
		$this->WP_Widget('nws-pages-list', __('NWS Pages List', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		extract($args);
		$title 		= apply_filters('widget_title', $instance['title'] );
		$orderby 	= $instance['orderby'];
		$order 		= $instance['order'];
		$include 	= $instance['include'];
		
		
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Make the Category RSS List widget
		$pagesArg 	= array(
			'include'    	=> $include,
			'title_li'		=> '', 
			'orderby'       => 'menu_order',
			'order'         => 'asc',
			'depth'			=> 1,
			
		); ?>
		<ul class="pagesList">
			<?php wp_list_pages($pagesArg); ?>
		</ul>
		<?php
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 		= strip_tags($new_instance['title']);
		$instance['include'] 	= $new_instance['include'];
		
		return $instance;
	}
	
	function form($instance){
		//Set up some default widget settings. 
		$defaults = array( 'title' => '', 'include' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'include' ); ?>"><?php _e('Include:', 'wpShop'); ?></label><br/>
			<small><?php _e('Enter the Page IDs you want to include. Comma separate multiple page ids.', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'include' ); ?>" name="<?php echo $this->get_field_name( 'include' ); ?>" value="<?php echo $instance['include']; ?>" style="width:97%;" />
		</p>
		
	<?php }
}

// the Gift Cards Widget
class GiftCardsWidget extends WP_Widget {

	function GiftCardsWidget() {
		$widget_ops 	= array('classname' => 'widget_promotions widget_gift_cards', 'description' => __( 'For Gift Cards or Certificates.', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-gift-cards');
		$this->WP_Widget('nws-gift-cards', __('NWS Gift Cards & Certificates', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		extract($args);
		$title 		= apply_filters('widget_title', $instance['title'] );
		$btnID 		= $instance['btnID'];
		$btnImg 	= $instance['btnImg'];
		$altText 	= $instance['altText'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		?>
		
		<div class="widget_promotions_imgWrap widget_promotions_alt"><a href="<?php echo $btnID;?>"><img src="<?php echo $btnImg;?>" alt="<?php echo $altText;?>"/></a></div>
	
	<?php
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 		= strip_tags($new_instance['title']);
		$instance['btnID'] 		= $new_instance['btnID'];
		$instance['btnImg'] 	= $new_instance['btnImg'];
		$instance['altText'] 	= $new_instance['altText'];
		return $instance;
	}
	
	function form($instance){
		// Set up some default widget settings.
		$defaults = array( 'title' => __('', 'wpShop'), 'btnID' => '', 'btnImg' => '');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title (Optional):', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'btnID' ); ?>"><?php _e('Link to):', 'wpShop'); ?></label><br/>
			<small><?php _e('The path to the category you created with your Gift Certificate Products', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'btnID' ); ?>" name="<?php echo $this->get_field_name( 'btnID' ); ?>" value="<?php echo $instance['btnID']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'btnImg' ); ?>"><?php _e('Image File Path:', 'wpShop'); ?></label><br/>
			<small><?php _e('The path to wherever you saved your image.', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'btnImg' ); ?>" name="<?php echo $this->get_field_name( 'btnImg' ); ?>" value="<?php echo $instance['btnImg']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'altText' ); ?>"><?php _e('Image ALT Text:', 'wpShop'); ?></label><br/>
			<small><?php _e('This will be used for the image\s ALT attribute', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'altText' ); ?>" name="<?php echo $this->get_field_name( 'altText' ); ?>" value="<?php echo $instance['altText']; ?>" style="width:97%;" />
		</p>
	<?php }
}

// the Email Subscriptions Widget
class EmailSubscriptionsWidget extends WP_Widget {

	function EmailSubscriptionsWidget() {
		$widget_ops 	= array('classname' => 'widget_promotions widget_email_subscriptions', 'description' => __( 'For Feedburner Email Subsciptions', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-email-subscriptions');
		$this->WP_Widget('nws-email-subscriptions', __('NWS Email Subscriptions', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		extract($args);
		$title 			= apply_filters('widget_title', $instance['title'] );
		$subsc_message 	= $instance['subsc_message'];
		$label_text 	= $instance['label_text'];
		$feedburnerID 	= $instance['feedburnerID'];
		$lang 			= $instance['lang'];
		$btnText 		= $instance['btnText'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		?>
		<div class="subscriptions">
			<p><?php echo $subsc_message;?></p>
			<form class="clearfix" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feedburnerID;?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
				<p><?php echo $label_text;?></p>
				<input class="input_text" type="text" name="email"/>
				<input type="hidden" value="<?php echo $feedburnerID;?>" name="uri"/>
				<input type="hidden" name="loc" value="<?php echo $lang;?>"/>
				<div class="shopform_btn subscribe_btn">								
					<input class="input_image" type="image"  name="subscribeButton" value='<?php echo $btnText;?>' src="<?php bloginfo('stylesheet_directory'); ?>/images/sign_me_up.png" />
				</div>
			</form>
		</div>
		<?php
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['subsc_message'] 	= strip_tags($new_instance['subsc_message']);
		$instance['label_text'] 	= strip_tags($new_instance['label_text']);
		$instance['feedburnerID'] 	= $new_instance['feedburnerID'];
		$instance['lang'] 			= $new_instance['lang'];
		$instance['btnText'] 		= strip_tags($new_instance['btnText']);
		return $instance;
	}
	
	function form($instance){
		// Set up some default widget settings. 
		$defaults = array( 'title' => __('Subscribe', 'wpShop'), 'subsc_message' => __('Be the first to know about Sales, Special Offers and New Arrivals', 'wpShop'), 'label_text' => __('Enter your email', 'wpShop'), 'feedburnerID' => 'snDesign', 'lang' => 'en_US', 'btnText' => __('Sign me up!', 'wpShop'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'subsc_message' ); ?>"><?php _e('Message below Title', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'subsc_message' ); ?>" name="<?php echo $this->get_field_name( 'subsc_message' ); ?>" value="<?php echo $instance['subsc_message']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'label_text' ); ?>"><?php _e('Text above input field:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'label_text' ); ?>" name="<?php echo $this->get_field_name( 'label_text' ); ?>" value="<?php echo $instance['label_text']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'feedburnerID' ); ?>"><?php _e('Your Feedburner ID:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'feedburnerID' ); ?>" name="<?php echo $this->get_field_name( 'feedburnerID' ); ?>" value="<?php echo $instance['feedburnerID']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'lang' ); ?>"><?php _e('Your Language Selection:', 'wpShop'); ?></label><br/>
			<small><?php _e('When you set up your email subscriptions with Feedburner, they give you the option to select the language in which the popup information will appear in. See the help file for more details.', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'lang' ); ?>" name="<?php echo $this->get_field_name( 'lang' ); ?>" value="<?php echo $instance['lang']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'btnText' ); ?>"><?php _e('The Button Text:', 'wpShop'); ?></label>
			<small><?php _e('Please note that the button is really an image however defining the text here is good for accessibility and usability purposes.', 'wpShop'); ?></small>
			
			<input id="<?php echo $this->get_field_id( 'btnText' ); ?>" name="<?php echo $this->get_field_name( 'btnText' ); ?>" value="<?php echo $instance['btnText']; ?>" style="width:97%;" />
		</p>
	<?php }
}

// the Promotions Widget
class PromotionsWidget extends WP_Widget {

	function PromotionsWidget() {
		$widget_ops 	= array('classname' => 'widget_promotions widget_promotions1Link', 'description' => __( 'For 1 link Promotions (Specials/New Arrivals/Clearance/Sales)', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-promotions');
		$this->WP_Widget('nws-promotions', __('NWS Promotions', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		extract($args);
		$title 			= apply_filters('widget_title', $instance['title'] );
		$link 			= $instance['link'];
		$linkText 		= $instance['linkText'];
		$img 			= $instance['img'];
		$hover_effect 	= isset( $instance['hover_effect'] ) ? $instance['hover_effect'] : FALSE;
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		if ( $hover_effect ) { ?>
			<div class="widget_promotions_imgWrap widget_promotions_alt"><a href="<?php echo $link;?>"><img src="<?php echo $img;?>" alt="<?php echo $linkText;?>"/></a></div>
		<?php } else { ?>
			<div class="widget_promotions_imgWrap"><a href="<?php echo $link;?>"><img src="<?php echo $img;?>" alt="<?php echo $linkText;?>"/></a></div>
		<?php }
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['link'] 			= $new_instance['link'];
		$instance['linkText'] 		= $new_instance['linkText'];
		$instance['img'] 			= $new_instance['img'];
		$instance['hover_effect'] 	= $new_instance['hover_effect'];
		
		return $instance;
	}
	
	function form($instance){
		// Set up some default widget settings. 
		$defaults = array( 'title' => __('', 'wpShop'), 'link' => '', 'linkText' => '', 'img' => '', 'hover_effect' => FALSE,);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e('Link to:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo $instance['link']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'linkText' ); ?>"><?php _e('Link Text:', 'wpShop'); ?></label><br/>
			<small><?php _e('This will be used for the image\s ALT attribute', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'linkText' ); ?>" name="<?php echo $this->get_field_name( 'linkText' ); ?>" value="<?php echo $instance['linkText']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'img' ); ?>"><?php _e('Image File Path:', 'wpShop'); ?></label><br/>
			<small><?php _e('The path to wherever you saved your image.', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'img' ); ?>" name="<?php echo $this->get_field_name( 'img' ); ?>" value="<?php echo $instance['img']; ?>" style="width:97%;" />
		</p>
		<!-- Hover effect? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['hover_effect'], true ); ?> id="<?php echo $this->get_field_id( 'hover_effect' ); ?>" name="<?php echo $this->get_field_name( 'hover_effect' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'hover_effect' ); ?>"><?php _e('Image Rollover on hover?', 'wpShop'); ?></label>
			<small><?php _e('This will require that you use Image Sprites', 'wpShop'); ?></small>
		</p>
	<?php }
}

// the Promotions 2 Links Widget
class Promotions2LinksWidget extends WP_Widget {

	function Promotions2LinksWidget() {
		$widget_ops 	= array('classname' => 'widget_promotions widget_promotions2Links', 'description' => __( 'For 2 link Promotions (Specials/New Arrivals/Clearance/Sales)', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-2link-promotions');
		$this->WP_Widget('nws-2link-promotions', __('NWS 2Link Promotions', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		extract($args);
		$title 		= apply_filters('widget_title', $instance['title'] );
		$offer 		= $instance['offer'];
		$link1 		= $instance['link1'];
		$linkText1 	= $instance['linkText1'];
		$link2 		= $instance['link2'];
		$linkText2 	= $instance['linkText2'];
		$img 		= $instance['img'];
		
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		?>	
			<div class="widget_promotions_imgWrap">
				<img src="<?php echo $img;?>" alt="<?php echo $offer;?>"/>
				<a class="link1" href="<?php echo $link1;?>"><img src="<?php echo $img;?>" alt="<?php echo $linkText1;?>"/></a>
				<a class="link2" href="<?php echo $link2;?>"><img src="<?php echo $img;?>" alt="<?php echo $linkText2;?>"/></a>
			</div>
		<?php
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['offer'] 			= strip_tags($new_instance['offer']);
		$instance['link1'] 			= $new_instance['link1'];
		$instance['linkText1'] 		= strip_tags($new_instance['linkText1']);
		$instance['link2'] 			= $new_instance['link2'];
		$instance['linkText2'] 		= strip_tags($new_instance['linkText2']);
		$instance['img'] 			= $new_instance['img'];
		
		return $instance;
	}
	
	function form($instance){
		// Set up some default widget settings. 
		$defaults = array( 'title' => __('', 'wpShop'), 'offer' => '', 'link1' => '', 'link2' => '', 'linkText1' => '','linkText2' => '', 'img' => '');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'offer' ); ?>"><?php _e('Offer:', 'wpShop'); ?></label><br/>
			<small><?php _e('This will be used for the image\s ALT attribute', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'offer' ); ?>" name="<?php echo $this->get_field_name( 'offer' ); ?>" value="<?php echo $instance['offer']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link1' ); ?>"><?php _e('First Link to:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'link1' ); ?>" name="<?php echo $this->get_field_name( 'link1' ); ?>" value="<?php echo $instance['link1']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'linkText1' ); ?>"><?php _e('First Link Text:', 'wpShop'); ?></label><br/>
			<small><?php _e('This will be used for the link image\s ALT attribute', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'linkText1' ); ?>" name="<?php echo $this->get_field_name( 'linkText1' ); ?>" value="<?php echo $instance['linkText1']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link2' ); ?>"><?php _e('Second Link to:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'link2' ); ?>" name="<?php echo $this->get_field_name( 'link2' ); ?>" value="<?php echo $instance['link2']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'linkText2' ); ?>"><?php _e('Second Link Text:', 'wpShop'); ?></label><br/>
			<small><?php _e('This will be used for the link image\s ALT attribute', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'linkText2' ); ?>" name="<?php echo $this->get_field_name( 'linkText2' ); ?>" value="<?php echo $instance['linkText2']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'img' ); ?>"><?php _e('Image File Path:', 'wpShop'); ?></label><br/>
			<small><?php _e('The path to wherever you saved your image sprite.', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'img' ); ?>" name="<?php echo $this->get_field_name( 'img' ); ?>" value="<?php echo $instance['img']; ?>" style="width:97%;" />
		</p>
	<?php }
}

// the Promotions 3 Links Widget
class Promotions3LinksWidget extends WP_Widget {

	function Promotions3LinksWidget() {
		$widget_ops 	= array('classname' => 'widget_promotions widget_promotions3Links', 'description' => __( 'For 3 link Promotions (Specials/New Arrivals/Clearance/Sales)', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-3link-promotions');
		$this->WP_Widget('nws-3link-promotions', __('NWS 3Link Promotions', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		extract($args);
		$title 		= apply_filters('widget_title', $instance['title'] );
		$offer 		= $instance['offer'];
		$link1 		= $instance['link1'];
		$linkText1 	= $instance['linkText1'];
		$link2 		= $instance['link2'];
		$linkText2 	= $instance['linkText2'];
		$link3 		= $instance['link3'];
		$linkText3 	= $instance['linkText3'];
		$img 		= $instance['img'];
		
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		?>	
			<div class="widget_promotions_imgWrap">
				<img src="<?php echo $img;?>" alt="<?php echo $offer;?>"/>
				<a class="link1" href="<?php echo $link1;?>"><img src="<?php echo $img;?>" alt="<?php echo $linkText1;?>"/></a>
				<a class="link2" href="<?php echo $link2;?>"><img src="<?php echo $img;?>" alt="<?php echo $linkText2;?>"/></a>
				<a class="link3" href="<?php echo $link3;?>"><img src="<?php echo $img;?>" alt="<?php echo $linkText3;?>"/></a>
			</div>
		<?php
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['offer'] 			= strip_tags($new_instance['offer']);
		$instance['link1'] 			= $new_instance['link1'];
		$instance['linkText1'] 		= strip_tags($new_instance['linkText1']);
		$instance['link2'] 			= $new_instance['link2'];
		$instance['linkText2'] 		= strip_tags($new_instance['linkText2']);
		$instance['link3'] 			= $new_instance['link3'];
		$instance['linkText3'] 		= strip_tags($new_instance['linkText3']);
		$instance['img'] 			= $new_instance['img'];
		
		return $instance;
	}
	
	function form($instance){
		// Set up some default widget settings. 
		$defaults = array( 'title' => __('', 'wpShop'), 'offer' => '', 'link1' => '', 'link2' => '', 'linkText1' => '','linkText2' => '', 'img' => '');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'offer' ); ?>"><?php _e('Offer:', 'wpShop'); ?></label><br/>
			<small><?php _e('This will be used for the image\s ALT attribute', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'offer' ); ?>" name="<?php echo $this->get_field_name( 'offer' ); ?>" value="<?php echo $instance['offer']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link1' ); ?>"><?php _e('First Link to:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'link1' ); ?>" name="<?php echo $this->get_field_name( 'link1' ); ?>" value="<?php echo $instance['link1']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'linkText1' ); ?>"><?php _e('First Link Text:', 'wpShop'); ?></label><br/>
			<small><?php _e('This will be used for the link image\s ALT attribute', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'linkText1' ); ?>" name="<?php echo $this->get_field_name( 'linkText1' ); ?>" value="<?php echo $instance['linkText1']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link2' ); ?>"><?php _e('Second Link to:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'link2' ); ?>" name="<?php echo $this->get_field_name( 'link2' ); ?>" value="<?php echo $instance['link2']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'linkText2' ); ?>"><?php _e('Second Link Text:', 'wpShop'); ?></label><br/>
			<small><?php _e('This will be used for the link image\s ALT attribute', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'linkText2' ); ?>" name="<?php echo $this->get_field_name( 'linkText2' ); ?>" value="<?php echo $instance['linkText2']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link3' ); ?>"><?php _e('Third Link to:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'link3' ); ?>" name="<?php echo $this->get_field_name( 'link3' ); ?>" value="<?php echo $instance['link3']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'linkText3' ); ?>"><?php _e('Third Link Text:', 'wpShop'); ?></label><br/>
			<small><?php _e('This will be used for the link image\s ALT attribute', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'linkText3' ); ?>" name="<?php echo $this->get_field_name( 'linkText3' ); ?>" value="<?php echo $instance['linkText3']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'img' ); ?>"><?php _e('Image File Path:', 'wpShop'); ?></label><br/>
			<small><?php _e('The path to wherever you saved your image sprite.', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'img' ); ?>" name="<?php echo $this->get_field_name( 'img' ); ?>" value="<?php echo $instance['img']; ?>" style="width:97%;" />
		</p>
	<?php }
}

// the Alternative Contact Widget
class ContactWidget extends WP_Widget {

	function ContactWidget() {
		$widget_ops 	= array('classname' => 'widget-alternative-contact-info', 'description' => __( 'For Contact Address and Phone Number', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-alternative-contact-info');
		$this->WP_Widget('nws-alternative-contact-info', __('NWS Alternative Contact Info', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		extract($args);
		$title 			= apply_filters('widget_title', $instance['title'] );
		$telTitle 		= $instance['telTitle'];
		$telNum 		= $instance['telNum'];
		$AddressTitle 	= $instance['AddressTitle'];
		$AddressDetails = $instance['AddressDetails'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		?>
		<ul class="contactAddress clearfix ">
			<li>
				<span><?php echo $telTitle;?></span>
				<p><?php echo $telNum;?></p>
			</li>
							
			<li>
				<span><?php echo $AddressTitle;?></span>
				<p>
					<?php echo $AddressDetails;?>
				</p>
			</li>
		</ul>
	
		<?php
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		$instance['telTitle'] 			= strip_tags($new_instance['telTitle']);
		$instance['telNum'] 			= strip_tags($new_instance['telNum']);
		$instance['AddressTitle'] 		= strip_tags($new_instance['AddressTitle']);
		$instance['AddressDetails'] 	= $new_instance['AddressDetails'];
		return $instance;
	}
	
	function form($instance){
		// Set up some default widget settings.
		$defaults = array( 'title' => __('Alternative Ways of Contacting Us', 'wpShop'), 'telTitle' => 'Telephone', 'telNum' => '555 555 5555', 'AddressTitle' => 'Address', 'AddressDetails' => '');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'telTitle' ); ?>"><?php _e('Telephone Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'telTitle' ); ?>" name="<?php echo $this->get_field_name( 'telTitle' ); ?>" value="<?php echo $instance['telTitle']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'telNum' ); ?>"><?php _e('Telephone Number:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'telNum' ); ?>" name="<?php echo $this->get_field_name( 'telNum' ); ?>" value="<?php echo $instance['telNum']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'AddressTitle' ); ?>"><?php _e('Address Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'AddressTitle' ); ?>" name="<?php echo $this->get_field_name( 'AddressTitle' ); ?>" value="<?php echo $instance['AddressTitle']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'AddressDetails' ); ?>"><?php _e('Address Details:', 'wpShop'); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'AddressDetails' ); ?>" name="<?php echo $this->get_field_name( 'AddressDetails' ); ?>" value="<?php echo $instance['AddressDetails']; ?>" style="width:97%;"rows="10" cols="50"><?php echo $instance['AddressDetails']; ?></textarea>
		</p>
		
	<?php }
}

// Shop by All Purpose Widget
class ShopByAllPurposeWidget extends WP_Widget {

	function ShopByAllPurposeWidget() {
		$widget_ops 	= array('classname' => 'shop_by_widget widget-shop-by-all-purpose', 'description' => __( 'A "Shop by" all-purpose widget.', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-shop-by-all-purpose');
		$this->WP_Widget('nws-shop-by-all-purpose', __('NWS Shop by All Purpose', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
	
		global $OPTION;
	
		extract($args);
		$title 				= apply_filters('widget_title', $instance['title'] );
		$cat_slug 			= $instance['cat_slug'];
		$cat_IDs 			= $instance['cat_IDs'];
		$current_cat 		= isset( $instance['current_cat'] ) ? $instance['current_cat'] : FALSE;
		$current_maincat 	= isset( $instance['current_maincat'] ) ? $instance['current_maincat'] : FALSE;
		$show_images 		= isset( $instance['show_images'] ) ? $instance['show_images'] : FALSE;
		$thumb_width 		= $instance['thumb_width'];
		$num_img_in_row 	= $instance['num_img_in_row'];
		$img_file_type 		= $instance['img_file_type'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		if ($cat_slug!='') {
			query_posts('category_name='.$cat_slug.'&showposts=-1');
		} elseif($cat_IDs!='') {
			query_posts('cat='.$cat_IDs.'&showposts=-1');
		} elseif (($current_cat) && (is_category())) {
			$cat = get_category( get_query_var( 'cat' ), false );
			query_posts('cat='.$cat->cat_ID.'&showposts=-1');
		}elseif (($current_maincat) && (is_category())) {
			$cat 		= get_category( get_query_var( 'cat' ), false );
			$topParent 	= NWS_get_root_category($cat,'allData');
			query_posts('cat='.$topParent->cat_ID.'&showposts=-1');
		}
		if (have_posts()) : while (have_posts()) : the_post();
			$posttags = get_the_tags();
			
			if($posttags !== FALSE) {	
				foreach($posttags as $tag) {
					$all_tags_arr[] 	= $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
					$all_tagslugs_arr[] = $tag->slug;
					$all_tagids_arr[] 	= $tag->term_id;
				}
			}
		endwhile; endif; 
		
		
		
		if(!empty($all_tags_arr)){
			
			$tags_arr 		= array_unique($all_tags_arr); //REMOVES DUPLICATES
			$tagslugs_arr 	= array_unique($all_tagslugs_arr); //REMOVES DUPLICATES
			$tagids_arr 	= array_unique($all_tagids_arr); //REMOVES DUPLICATES
			
			//sort asc
			sort($tags_arr);
			sort($tagslugs_arr);
			sort($tagids_arr);
			
			if ( $show_images ) { 
			?>
				<div class="img_wrap">
					<?php
					$counter = $num_img_in_row;
					$a = 1;
					foreach ($tags_arr as $k => $tag) {
						$term_obj = get_term_by('name',$tags_arr[$k], __('post_tag', 'wpShop'));
							
						$img_src 		= get_option('siteurl').'/'. $OPTION['upload_path'] .'/'. $term_obj->slug .'.'. $img_file_type;
						$des_src 		= $OPTION['upload_path'].'/cache';	
						$img_file 		= mkthumb($img_src,$des_src,$thumb_width,'width');    
						$imgURL 		= get_option('siteurl').'/'.$des_src.'/'.$img_file;
						$the_a_class 	= alternating_css_class($counter,$num_img_in_row,'first');
						$cur_class 		= (($tag == $queried_obj->name) ? 'current_term': '');
						
						echo '<a class="'.$the_a_class.' '.$cur_class.'" href="'.get_term_link($term_obj,__('post_tag','wpShop')).'" title="'.$term_obj->name .'"><img src="'.$imgURL .'" alt="'.$term_obj->slug .'" /></a>';
						
						$a++;
						$counter++;
					} ?>
				</div>
			<?php  } else { ?>
				<div>
					<select name="tag-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option value="#"><?php _e('Please Select...','wpShop'); ?></option>
							<?php foreach ($tags_arr as $k => $tag) {
								$term_obj = get_term_by('name',$tags_arr[$k], __('post_tag', 'wpShop'));
								
								echo '<option value="'.get_term_link($term_obj,__('post_tag','wpShop')).'">'.$term_obj->name .'</option>';
								
							} ?>
					</select>
				</div>
			<?php }
		} 
	
		
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		$instance['cat_slug'] 			= strip_tags($new_instance['cat_slug']);
		$instance['cat_IDs'] 			= $new_instance['cat_IDs'];
		$instance['current_cat'] 		= $new_instance['current_cat'];
		$instance['current_maincat'] 	= $new_instance['current_maincat'];
		$instance['show_images'] 		= $new_instance['show_images'];
		$instance['thumb_width'] 		= strip_tags($new_instance['thumb_width']);
		$instance['num_img_in_row'] 	= $new_instance['num_img_in_row'];
		$instance['img_file_type'] 		= $new_instance['img_file_type'];
		return $instance;
	}
	
	function form($instance){
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('', 'wpShop'), 'cat_slug' => '', 'cat_IDs' => '', 'current_cat' => FALSE, 'current_maincat' => FALSE, 'show_images' => FALSE, 'thumb_width' => '80', 'num_img_in_row' => '3');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_slug' ); ?>"><?php _e('Category Name or Slug:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from one category enter it\'s name or slug here. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" value="<?php echo $instance['cat_slug']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_IDs' ); ?>"><?php _e('Category IDs:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from several categories enter their IDs seperated by comma eg. 1,3,4. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_IDs' ); ?>" name="<?php echo $this->get_field_name( 'cat_IDs' ); ?>" value="<?php echo $instance['cat_IDs']; ?>" style="width:97%;" />
		</p>
		
		<!-- query current cat || current main cat? Checkbox -->
		<p style="background:#F1F1F1;">
			<strong><?php _e('For use on Product Category Pages Only', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_cat'], true ); ?> id="<?php echo $this->get_field_id( 'current_cat' ); ?>" name="<?php echo $this->get_field_name( 'current_cat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_cat' ); ?>"><?php _e('Query Current Category', 'wpShop'); ?></label><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_maincat'], true ); ?> id="<?php echo $this->get_field_id( 'current_maincat' ); ?>" name="<?php echo $this->get_field_name( 'current_maincat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_maincat' ); ?>"><?php _e('Query Current Main (top level) Category', 'wpShop'); ?></label><br/>
			<small><?php _e('Check the appropriate box (not both!) if you like to query Product tags/terms from the current category or the current main (top level) category being viewed. This will only work if you have activated this widget on category pages! If you are using the widget on other pages please use one of the options above.', 'wpShop'); ?></small>
		</p>
		
		<p style="color:red;"><?php _e('By default the widget will collect all tags/terms specific to the category you have specified above and display them in a select drop down. Check the option below is you want to display a row of images instead. This requires that you create tag/term specific images for each!', 'wpShop'); ?></p>
		
		<!-- Show Images? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['show_images'], true ); ?> id="<?php echo $this->get_field_id( 'show_images' ); ?>" name="<?php echo $this->get_field_name( 'show_images' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_images' ); ?>"><?php _e('Display images', 'wpShop'); ?></label>
		</p>
		
		<small><?php _e('The fields below apply only if you have checked "Display Images" from above.', 'wpShop'); ?></small>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>"><?php _e('Thumb Width:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>"><?php _e('Number of images per row:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>" name="<?php echo $this->get_field_name( 'num_img_in_row' ); ?>" value="<?php echo $instance['num_img_in_row']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_file_type' ); ?>"><?php _e('Image File Type', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'img_file_type' ); ?>" name="<?php echo $this->get_field_name( 'img_file_type' ); ?>" class="widefat" style="width:97%;">
				<option value="jpg" <?php selected('jpg', $instance["img_file_type"]); ?>><?php _e('jpg', 'wpShop'); ?></option>
				<option value="png" <?php selected('png', $instance["img_file_type"]); ?>><?php _e('png', 'wpShop'); ?></option>
				<option value="gif" <?php selected('gif', $instance["img_file_type"]); ?>><?php _e('gif', 'wpShop'); ?></option>
			</select>
		</p>
		
		
	<?php }
}

// Shop by Outfit Widget
class ShopByOutfitWidget extends WP_Widget {

	function ShopByOutfitWidget() {
		$widget_ops 	= array('classname' => 'shop_by_widget widget-shop-by-outfit', 'description' => __( 'For the "Shop by Outfit" custom Taxonomy', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-shop-by-outfit');
		$this->WP_Widget('nws-shop-by-outfit', __('NWS Shop by Outfit', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
	
		global $OPTION;
		
		extract($args);
		$title 				= apply_filters('widget_title', $instance['title'] );
		$cat_slug 			= $instance['cat_slug'];
		$current_cat 		= isset( $instance['current_cat'] ) ? $instance['current_cat'] : FALSE;
		$current_maincat 	= isset( $instance['current_maincat'] ) ? $instance['current_maincat'] : FALSE;
		$show_images 		= isset( $instance['show_images'] ) ? $instance['show_images'] : FALSE;
		$show_images 		= isset( $instance['show_images'] ) ? $instance['show_images'] : FALSE;
		$thumb_width 		= $instance['thumb_width'];
		$num_img_in_row 	= $instance['num_img_in_row'];
		$img_file_type 		= $instance['img_file_type'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		//check to see if the taxonomy exists first
		$taxonomy_exist = taxonomy_exists(__('outfit','wpShop'));
		if($taxonomy_exist) {
		
			if ($cat_slug!='') {
				query_posts('category_name='.$cat_slug.'&showposts=-1');
			} elseif($cat_IDs!='') {
				query_posts('cat='.$cat_IDs.'&showposts=-1');
			} elseif (($current_cat) && (is_category())) {
				$cat = get_category( get_query_var( 'cat' ), false );
				query_posts('cat='.$cat->cat_ID.'&showposts=-1');
			}elseif (($current_maincat) && (is_category())) {
				$cat 		= get_category( get_query_var( 'cat' ), false );
				$topParent 	= NWS_get_root_category($cat,'allData');
				query_posts('cat='.$topParent->cat_ID.'&showposts=-1');
			}
			if (have_posts()) : while (have_posts()) : the_post();
				$posttags = get_the_outfit();
				if($posttags !== FALSE) {					
					foreach($posttags as $tag) {
						$all_tags_arr[] 	= $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
						$all_tagslugs_arr[] = $tag->slug;
					}
				}
			endwhile; endif; 
			
			if(!empty($all_tags_arr)){
			
				$tags_arr 		= array_unique($all_tags_arr); //REMOVES DUPLICATES
				$tagslugs_arr 	= array_unique($all_tagslugs_arr); //REMOVES DUPLICATES
				
				//sort asc
				sort($tags_arr);
				sort($tagslugs_arr);
				
				if ( $show_images ) { ?>
					<div class="img_wrap">
						<?php
						$counter = $num_img_in_row;
						$a = 1;
						foreach ($tags_arr as $k => $tag) {
							$term_obj = get_term_by('name',$tags_arr[$k], __('outfit', 'wpShop'));
							
							$img_src 		= get_option('siteurl').'/'. $OPTION['upload_path'] .'/'. $term_obj->slug .'.'. $img_file_type;
							$des_src 		= $OPTION['upload_path'].'/cache';	
							$img_file 		= mkthumb($img_src,$des_src,$thumb_width,'width');    
							$imgURL 		= get_option('siteurl').'/'.$des_src.'/'.$img_file;
							$the_a_class 	= alternating_css_class($counter,$num_img_in_row,'first');
							
							echo '<a class="'.$the_a_class.' '.$cur_class.'" href="'.get_term_link($term_obj,__('outfit','wpShop')).'" title="'.$term_obj->name .'"><img src="'.$imgURL .'" alt="'.$term_obj->slug .'" /></a>';
							
							$a++;
							$counter++;
						} ?>
					</div>
				<?php 
				} else { ?>
					<div>
						<select name="tag-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
							<option value="#"><?php _e('Please Select...','wpShop'); ?></option>
								<?php foreach ($tags_arr as $k => $tag) {
									$term_obj = get_term_by('name',$tags_arr[$k], __('outfit', 'wpShop'));
									
									echo '<option value="'.get_term_link($term_obj,__('outfit','wpShop')).'">'.$term_obj->name .'</option>';
									
								} ?>
						</select>
					</div>
				<?php }
			} 
	
		} else {
			echo "<p class='error'>".__('The widget you have activated needs that the "outfit" custom taxonomy is active! Please activate it from your Theme Options > Design > General settings','wpShop')."</p>";
		}
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		$instance['cat_slug'] 			= strip_tags($new_instance['cat_slug']);
		$instance['cat_IDs'] 			= $new_instance['cat_IDs'];
		$instance['current_cat'] 		= $new_instance['current_cat'];
		$instance['current_maincat'] 	= $new_instance['current_maincat'];
		$instance['show_images'] 		= $new_instance['show_images'];
		$instance['thumb_width'] 		= strip_tags($new_instance['thumb_width']);
		$instance['num_img_in_row'] 	= $new_instance['num_img_in_row'];
		$instance['img_file_type'] 		= $new_instance['img_file_type'];
		return $instance;
	}
	
	function form($instance){
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('', 'wpShop'), 'cat_slug' => '', 'cat_IDs' => '', 'current_cat' => FALSE, 'current_maincat' => FALSE, 'show_images' => FALSE, 'thumb_width' => '80', 'num_img_in_row' => '3');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_slug' ); ?>"><?php _e('Category Name or Slug:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from one category enter it\'s name or slug here. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" value="<?php echo $instance['cat_slug']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_IDs' ); ?>"><?php _e('Category IDs:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from several categories enter their IDs seperated by comma eg. 1,3,4. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_IDs' ); ?>" name="<?php echo $this->get_field_name( 'cat_IDs' ); ?>" value="<?php echo $instance['cat_IDs']; ?>" style="width:97%;" />
		</p>
		
		<!-- query current cat || current main cat? Checkbox -->
		<p style="background:#F1F1F1;">
			<strong><?php _e('For use on Product Category Pages Only', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_cat'], true ); ?> id="<?php echo $this->get_field_id( 'current_cat' ); ?>" name="<?php echo $this->get_field_name( 'current_cat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_cat' ); ?>"><?php _e('Query Current Category', 'wpShop'); ?></label><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_maincat'], true ); ?> id="<?php echo $this->get_field_id( 'current_maincat' ); ?>" name="<?php echo $this->get_field_name( 'current_maincat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_maincat' ); ?>"><?php _e('Query Current Main (top level) Category', 'wpShop'); ?></label><br/>
			<small><?php _e('Check the appropriate box (not both!) if you like to query Product tags/terms from the current category or the current main (top level) category being viewed. This will only work if you have activated this widget on category pages! If you are using the widget on other pages please use one of the options above.', 'wpShop'); ?></small>
		</p>
		
		<p style="color:red;"><?php _e('By default the widget will collect all tags/terms specific to the category you have specified above and display them in a select drop down. Check the option below is you want to display a row of images instead. This requires that you create tag/term specific images for each!', 'wpShop'); ?></p>
		
		<!-- Show Images? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['show_images'], true ); ?> id="<?php echo $this->get_field_id( 'show_images' ); ?>" name="<?php echo $this->get_field_name( 'show_images' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_images' ); ?>"><?php _e('Display images', 'wpShop'); ?></label>
		</p>
		
		<small><?php _e('The fields below apply only if you have checked "Display Images" from above.', 'wpShop'); ?></small>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>"><?php _e('Thumb Width:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>"><?php _e('Number of images per row:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>" name="<?php echo $this->get_field_name( 'num_img_in_row' ); ?>" value="<?php echo $instance['num_img_in_row']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_file_type' ); ?>"><?php _e('Image File Type', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'img_file_type' ); ?>" name="<?php echo $this->get_field_name( 'img_file_type' ); ?>" class="widefat" style="width:97%;">
				<option value="jpg" <?php selected('jpg', $instance["img_file_type"]); ?>><?php _e('jpg', 'wpShop'); ?></option>
				<option value="png" <?php selected('png', $instance["img_file_type"]); ?>><?php _e('png', 'wpShop'); ?></option>
				<option value="gif" <?php selected('gif', $instance["img_file_type"]); ?>><?php _e('gif', 'wpShop'); ?></option>
			</select>
		</p>
		
		
	<?php }
}

// Shop by Fit Widget
class ShopByFitWidget extends WP_Widget {

	function ShopByFitWidget() {
		$widget_ops 	= array('classname' => 'shop_by_widget widget-shop-by-fit', 'description' => __( 'For the "Shop by Fit" custom Taxonomy', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-shop-by-fit');
		$this->WP_Widget('nws-shop-by-fit', __('NWS Shop by Fit', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
	
		global $OPTION;
	
		extract($args);
		$title 				= apply_filters('widget_title', $instance['title'] );
		$cat_slug 			= $instance['cat_slug'];
		$cat_IDs 			= $instance['cat_IDs'];
		$current_cat 		= isset( $instance['current_cat'] ) ? $instance['current_cat'] : FALSE;
		$current_maincat 	= isset( $instance['current_maincat'] ) ? $instance['current_maincat'] : FALSE;
		$show_images 		= isset( $instance['show_images'] ) ? $instance['show_images'] : FALSE;
		$thumb_width 		= $instance['thumb_width'];
		$num_img_in_row 	= $instance['num_img_in_row'];
		$img_file_type 		= $instance['img_file_type'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		//check to see if the taxonomy exists first
		$taxonomy_exist = taxonomy_exists(__('fit','wpShop'));
		if($taxonomy_exist) {
		if ($cat_slug!='') {
			query_posts('category_name='.$cat_slug.'&showposts=-1');
		} elseif($cat_IDs!='') {
			query_posts('cat='.$cat_IDs.'&showposts=-1');
		} elseif (($current_cat) && (is_category())) {
			$cat = get_category( get_query_var( 'cat' ), false );
			query_posts('cat='.$cat->cat_ID.'&showposts=-1');
		}elseif (($current_maincat) && (is_category())) {
			$cat 		= get_category( get_query_var( 'cat' ), false );
			$topParent 	= NWS_get_root_category($cat,'allData');
			query_posts('cat='.$topParent->cat_ID.'&showposts=-1');
		}
		if (have_posts()) : while (have_posts()) : the_post();
			$posttags = get_the_fit();
			if($posttags !== FALSE) {						
				foreach($posttags as $tag) {
					$all_tags_arr[] 	= $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
					$all_tagslugs_arr[] = $tag->slug;
				}
			}
		endwhile; endif; 
		
		if(!empty($all_tags_arr)){
			
			$tags_arr 		= array_unique($all_tags_arr); //REMOVES DUPLICATES
			$tagslugs_arr 	= array_unique($all_tagslugs_arr); //REMOVES DUPLICATES
			
			//sort asc
			sort($tags_arr);
			sort($tagslugs_arr);
			
			if ( $show_images ) { ?>
				<div class="img_wrap">
					<?php
					$counter = $num_img_in_row;
					$a = 1;
					foreach ($tags_arr as $k => $tag) {
						$term_obj = get_term_by('name',$tags_arr[$k], __('fit', 'wpShop')); 
						
						$img_src 		= get_option('siteurl').'/'. $OPTION['upload_path'] .'/'. $term_obj->slug .'.'. $img_file_type;
						$des_src 		= $OPTION['upload_path'].'/cache';	
						$img_file 		= mkthumb($img_src,$des_src,$thumb_width,'width');    
						$imgURL 		= get_option('siteurl').'/'.$des_src.'/'.$img_file;
						$the_a_class 	= alternating_css_class($counter,$num_img_in_row,'first');
						
						echo '<a class="'.$the_a_class.' '.$cur_class.'" href="'.get_term_link($term_obj,__('fit','wpShop')).'" title="'.$term_obj->name .'"><img src="'.$imgURL .'" alt="'.$term_obj->slug .'" /></a>';
						
						$a++;
						$counter++;
					} ?>
				</div>
			<?php 
			} else { ?>
				<div>
					<select name="tag-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option value="#"><?php _e('Please Select...','wpShop'); ?></option>
							<?php foreach ($tags_arr as $k => $tag) {
								$term_obj = get_term_by('name',$tags_arr[$k], __('fit', 'wpShop'));
								
								echo '<option value="'.get_term_link($term_obj,__('fit','wpShop')).'">'.$term_obj->name .'</option>';
								
							} ?>
					</select>
				</div>
			<?php }
		} 
		} else {
			echo "<p class='error'>".__('The widget you have activated needs that the "fit" custom taxonomy is active! Please activate it from your Theme Options > Design > General settings','wpShop')."</p>";
		}
		
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		$instance['cat_slug'] 			= strip_tags($new_instance['cat_slug']);
		$instance['cat_IDs'] 			= $new_instance['cat_IDs'];
		$instance['current_cat'] 		= $new_instance['current_cat'];
		$instance['current_maincat'] 	= $new_instance['current_maincat'];
		$instance['show_images'] 		= $new_instance['show_images'];
		$instance['thumb_width'] 		= strip_tags($new_instance['thumb_width']);
		$instance['num_img_in_row'] 	= $new_instance['num_img_in_row'];
		$instance['img_file_type'] 		= $new_instance['img_file_type'];
		return $instance;
	}
	
	function form($instance){
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('', 'wpShop'), 'cat_slug' => '', 'cat_IDs' => '', 'current_cat' => FALSE, 'current_maincat' => FALSE, 'show_images' => FALSE, 'thumb_width' => '80', 'num_img_in_row' => '3');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_slug' ); ?>"><?php _e('Category Name or Slug:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from one category enter it\'s name or slug here. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" value="<?php echo $instance['cat_slug']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_IDs' ); ?>"><?php _e('Category IDs:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from several categories enter their IDs seperated by comma eg. 1,3,4. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_IDs' ); ?>" name="<?php echo $this->get_field_name( 'cat_IDs' ); ?>" value="<?php echo $instance['cat_IDs']; ?>" style="width:97%;" />
		</p>
		
		<!-- query current cat || current main cat? Checkbox -->
		<p style="background:#F1F1F1;">
			<strong><?php _e('For use on Product Category Pages Only', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_cat'], true ); ?> id="<?php echo $this->get_field_id( 'current_cat' ); ?>" name="<?php echo $this->get_field_name( 'current_cat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_cat' ); ?>"><?php _e('Query Current Category', 'wpShop'); ?></label><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_maincat'], true ); ?> id="<?php echo $this->get_field_id( 'current_maincat' ); ?>" name="<?php echo $this->get_field_name( 'current_maincat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_maincat' ); ?>"><?php _e('Query Current Main (top level) Category', 'wpShop'); ?></label><br/>
			<small><?php _e('Check the appropriate box (not both!) if you like to query Product tags/terms from the current category or the current main (top level) category being viewed. This will only work if you have activated this widget on category pages! If you are using the widget on other pages please use one of the options above.', 'wpShop'); ?></small>
		</p>
		
		<p style="color:red;"><?php _e('By default the widget will collect all tags/terms specific to the category you have specified above and display them in a select drop down. Check the option below is you want to display a row of images instead. This requires that you create tag/term specific images for each!', 'wpShop'); ?></p>
		
		<!-- Show Images? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['show_images'], true ); ?> id="<?php echo $this->get_field_id( 'show_images' ); ?>" name="<?php echo $this->get_field_name( 'show_images' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_images' ); ?>"><?php _e('Display images', 'wpShop'); ?></label>
		</p>
		
		<small><?php _e('The fields below apply only if you have checked "Display Images" from above.', 'wpShop'); ?></small>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>"><?php _e('Thumb Width:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>"><?php _e('Number of images per row:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>" name="<?php echo $this->get_field_name( 'num_img_in_row' ); ?>" value="<?php echo $instance['num_img_in_row']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_file_type' ); ?>"><?php _e('Image File Type', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'img_file_type' ); ?>" name="<?php echo $this->get_field_name( 'img_file_type' ); ?>" class="widefat" style="width:97%;">
				<option value="jpg" <?php selected('jpg', $instance["img_file_type"]); ?>><?php _e('jpg', 'wpShop'); ?></option>
				<option value="png" <?php selected('png', $instance["img_file_type"]); ?>><?php _e('png', 'wpShop'); ?></option>
				<option value="gif" <?php selected('gif', $instance["img_file_type"]); ?>><?php _e('gif', 'wpShop'); ?></option>
			</select>
		</p>
		
		
	<?php }
}

// Shop by Size Widget
class ShopBySizeWidget extends WP_Widget {

	function ShopBySizeWidget() {
		$widget_ops 	= array('classname' => 'shop_by_widget widget-shop-by-size', 'description' => __( 'For the "Shop by Size" custom Taxonomy', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-shop-by-size');
		$this->WP_Widget('nws-shop-by-size', __('NWS Shop by Size', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
	
		global $OPTION;
	
		extract($args);
		$title 				= apply_filters('widget_title', $instance['title'] );
		$cat_slug 			= $instance['cat_slug'];
		$cat_IDs 			= $instance['cat_IDs'];
		$current_cat 		= isset( $instance['current_cat'] ) ? $instance['current_cat'] : FALSE;
		$current_maincat 	= isset( $instance['current_maincat'] ) ? $instance['current_maincat'] : FALSE;
		$show_images 		= isset( $instance['show_images'] ) ? $instance['show_images'] : FALSE;
		$thumb_width 		= $instance['thumb_width'];
		$num_img_in_row 	= $instance['num_img_in_row'];
		$img_file_type 		= $instance['img_file_type'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		//check to see if the taxonomy exists first
		$taxonomy_exist = taxonomy_exists(__('size','wpShop'));
		if($taxonomy_exist) {
		if ($cat_slug!='') {
			query_posts('category_name='.$cat_slug.'&showposts=-1');
		} elseif($cat_IDs!='') {
			query_posts('cat='.$cat_IDs.'&showposts=-1');
		} elseif (($current_cat) && (is_category())) {
			$cat = get_category( get_query_var( 'cat' ), false );
			query_posts('cat='.$cat->cat_ID.'&showposts=-1');
		}elseif (($current_maincat) && (is_category())) {
			$cat 		= get_category( get_query_var( 'cat' ), false );
			$topParent 	= NWS_get_root_category($cat,'allData');
			query_posts('cat='.$topParent->cat_ID.'&showposts=-1');
		}
		if (have_posts()) : while (have_posts()) : the_post();
			$posttags = get_the_size();
			
			
			
			if($posttags !== FALSE) {					
				foreach($posttags as $tag) {
					$all_tags_arr[] 	= $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
					$all_tagslugs_arr[] = $tag->slug;
				}
			}
		endwhile; endif;
		
		
		
		if(!empty($all_tags_arr)){
		
			$tags_arr 		= array_unique($all_tags_arr); //REMOVES DUPLICATES
			$tagslugs_arr 	= array_unique($all_tagslugs_arr); //REMOVES DUPLICATES
			
			//sort asc
			sort($tags_arr);
			sort($tagslugs_arr);
			
			if ( $show_images ) { ?>
				<div class="img_wrap">
					<?php
					$counter = $num_img_in_row;
					$a = 1;
					foreach ($tags_arr as $k => $tag) {
						$term_obj = get_term_by('name',$tags_arr[$k], __('size', 'wpShop'));
						
						$img_src 		= get_option('siteurl').'/'. $OPTION['upload_path'] .'/'. $term_obj->slug .'.'. $img_file_type;
						$des_src 		= $OPTION['upload_path'].'/cache';	
						$img_file 		= mkthumb($img_src,$des_src,$thumb_width,'width');    
						$imgURL 		= get_option('siteurl').'/'.$des_src.'/'.$img_file;
						$the_a_class 	= alternating_css_class($counter,$num_img_in_row,'first');
						
						echo '<a class="'.$the_a_class.' '.$cur_class.'" href="'.get_term_link($term_obj,__('size','wpShop')).'" title="'.$term_obj->name .'"><img src="'.$imgURL .'" alt="'.$term_obj->slug .'" /></a>';
						
						$a++;
						$counter++;
					} ?>
				</div>
			<?php 
			} else { ?>
				<div>
					<select name="tag-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option value="#"><?php _e('Please Select...','wpShop'); ?></option>
							<?php foreach ($tags_arr as $k => $tag) {
								$term_obj = get_term_by('name',$tags_arr[$k], __('size', 'wpShop'));
								
								echo '<option value="'.get_term_link($term_obj,__('size','wpShop')).'">'.$term_obj->name .'</option>';
								
							} ?>
					</select>
				</div>
			<?php }
		} 
		} else {
			echo "<p class='error'>".__('The widget you have activated needs that the "size" custom taxonomy is active! Please activate it from your Theme Options > Design > General settings','wpShop')."</p>";
		}
	
		
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		$instance['cat_slug'] 			= strip_tags($new_instance['cat_slug']);
		$instance['cat_IDs'] 			= $new_instance['cat_IDs'];
		$instance['current_cat'] 		= $new_instance['current_cat'];
		$instance['current_maincat'] 	= $new_instance['current_maincat'];
		$instance['show_images'] 		= $new_instance['show_images'];
		$instance['thumb_width'] 		= strip_tags($new_instance['thumb_width']);
		$instance['num_img_in_row'] 	= $new_instance['num_img_in_row'];
		$instance['img_file_type'] 		= $new_instance['img_file_type'];
		return $instance;
	}
	
	function form($instance){
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('', 'wpShop'), 'cat_slug' => '', 'cat_IDs' => '', 'current_cat' => FALSE, 'current_maincat' => FALSE, 'show_images' => FALSE, 'thumb_width' => '80', 'num_img_in_row' => '3');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_slug' ); ?>"><?php _e('Category Name or Slug:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from one category enter it\'s name or slug here. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" value="<?php echo $instance['cat_slug']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_IDs' ); ?>"><?php _e('Category IDs:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from several categories enter their IDs seperated by comma eg. 1,3,4. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_IDs' ); ?>" name="<?php echo $this->get_field_name( 'cat_IDs' ); ?>" value="<?php echo $instance['cat_IDs']; ?>" style="width:97%;" />
		</p>
		
		<!-- query current cat || current main cat? Checkbox -->
		<p style="background:#F1F1F1;">
			<strong><?php _e('For use on Product Category Pages Only', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_cat'], true ); ?> id="<?php echo $this->get_field_id( 'current_cat' ); ?>" name="<?php echo $this->get_field_name( 'current_cat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_cat' ); ?>"><?php _e('Query Current Category', 'wpShop'); ?></label><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_maincat'], true ); ?> id="<?php echo $this->get_field_id( 'current_maincat' ); ?>" name="<?php echo $this->get_field_name( 'current_maincat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_maincat' ); ?>"><?php _e('Query Current Main (top level) Category', 'wpShop'); ?></label><br/>
			<small><?php _e('Check the appropriate box (not both!) if you like to query Product tags/terms from the current category or the current main (top level) category being viewed. This will only work if you have activated this widget on category pages! If you are using the widget on other pages please use one of the options above.', 'wpShop'); ?></small>
		</p>
		
		<p style="color:red;"><?php _e('By default the widget will collect all tags/terms specific to the category you have specified above and display them in a select drop down. Check the option below is you want to display a row of images instead. This requires that you create tag/term specific images for each!', 'wpShop'); ?></p>
		
		<!-- Show Images? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['show_images'], true ); ?> id="<?php echo $this->get_field_id( 'show_images' ); ?>" name="<?php echo $this->get_field_name( 'show_images' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_images' ); ?>"><?php _e('Display images', 'wpShop'); ?></label>
		</p>
		
		<small><?php _e('The fields below apply only if you have checked "Display Images" from above.', 'wpShop'); ?></small>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>"><?php _e('Thumb Width:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>"><?php _e('Number of images per row:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>" name="<?php echo $this->get_field_name( 'num_img_in_row' ); ?>" value="<?php echo $instance['num_img_in_row']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_file_type' ); ?>"><?php _e('Image File Type', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'img_file_type' ); ?>" name="<?php echo $this->get_field_name( 'img_file_type' ); ?>" class="widefat" style="width:97%;">
				<option value="jpg" <?php selected('jpg', $instance["img_file_type"]); ?>><?php _e('jpg', 'wpShop'); ?></option>
				<option value="png" <?php selected('png', $instance["img_file_type"]); ?>><?php _e('png', 'wpShop'); ?></option>
				<option value="gif" <?php selected('gif', $instance["img_file_type"]); ?>><?php _e('gif', 'wpShop'); ?></option>
			</select>
		</p>
		
		
	<?php }
}

// Shop by Colour Widget
class ShopByColourWidget extends WP_Widget {

	function ShopByColourWidget() {
		$widget_ops 	= array('classname' => 'shop_by_widget widget-shop-by-colour', 'description' => __( 'For the "Shop by Colour" custom Taxonomy', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-shop-by-colour');
		$this->WP_Widget('nws-shop-by-colour', __('NWS Shop by Colour', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		
		global $OPTION;
	
		extract($args);
		$title 				= apply_filters('widget_title', $instance['title'] );
		$cat_slug 			= $instance['cat_slug'];
		$cat_IDs 			= $instance['cat_IDs'];
		$current_cat 		= isset( $instance['current_cat'] ) ? $instance['current_cat'] : FALSE;
		$current_maincat 	= isset( $instance['current_maincat'] ) ? $instance['current_maincat'] : FALSE;
		$show_images 		= isset( $instance['show_images'] ) ? $instance['show_images'] : FALSE;
		$thumb_width 		= $instance['thumb_width'];
		$num_img_in_row 	= $instance['num_img_in_row'];
		$img_file_type 		= $instance['img_file_type'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		//check to see if the taxonomy exists first
		$taxonomy_exist = taxonomy_exists(__('colour','wpShop'));
		if($taxonomy_exist) {
		if ($cat_slug!='') {
			query_posts('category_name='.$cat_slug.'&showposts=-1');
		} elseif($cat_IDs!='') {
			query_posts('cat='.$cat_IDs.'&showposts=-1');
		} elseif (($current_cat) && (is_category())) {
			$cat = get_category( get_query_var( 'cat' ), false );
			query_posts('cat='.$cat->cat_ID.'&showposts=-1');
		}elseif (($current_maincat) && (is_category())) {
			$cat 		= get_category( get_query_var( 'cat' ), false );
			$topParent 	= NWS_get_root_category($cat,'allData');
			query_posts('cat='.$topParent->cat_ID.'&showposts=-1');
		}
		if (have_posts()) : while (have_posts()) : the_post();
			$posttags = get_the_colour();
			if($posttags !== FALSE) {					
				foreach($posttags as $tag) {
					$all_tags_arr[] 	= $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
					$all_tagslugs_arr[] = $tag->slug;
				}
			}
		endwhile; endif; 
		
		if(!empty($all_tags_arr)){
			
			$tags_arr 		= array_unique($all_tags_arr); //REMOVES DUPLICATES
			$tagslugs_arr 	= array_unique($all_tagslugs_arr); //REMOVES DUPLICATES
			
			//sort asc
			sort($tags_arr);
			sort($tagslugs_arr);

			if ( $show_images ) { ?>
				<div class="img_wrap">
					<?php
					$counter = $num_img_in_row;
					$a = 1;
					foreach ($tags_arr as $k => $tag) {
						$term_obj = get_term_by('name',$tags_arr[$k], __('colour', 'wpShop'));
						
						$img_src 		= get_option('siteurl').'/'. $OPTION['upload_path'] .'/'. $term_obj->slug .'.'. $img_file_type;
						$des_src 		= $OPTION['upload_path'].'/cache';	
						$img_file 		= mkthumb($img_src,$des_src,$thumb_width,'width');    
						$imgURL 		= get_option('siteurl').'/'.$des_src.'/'.$img_file;
						$the_a_class 	= alternating_css_class($counter,$num_img_in_row,'first');
						
						echo '<a class="'.$the_a_class.' '.$cur_class.'" href="'.get_term_link($term_obj,__('colour','wpShop')).'" title="'.$term_obj->name .'"><img src="'.$imgURL .'" alt="'.$term_obj->slug .'" /></a>';
						
						$a++;
						$counter++;
					} ?>
				</div>
			<?php
			} else { ?>
				<div>
					<select name="tag-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option value="#"><?php _e('Please Select...','wpShop'); ?></option>
							<?php foreach ($tags_arr as $k => $tag) {
								$term_obj = get_term_by('name',$tags_arr[$k], __('colour', 'wpShop'));
								
								echo '<option value="'.get_term_link($term_obj,__('colour','wpShop')).'">'.$term_obj->name .'</option>';
								
							} ?>
					</select>
				</div>
			<?php }
		} 
		} else {
			echo "<p class='error'>".__('The widget you have activated needs that the "colour" custom taxonomy is active! Please activate it from your Theme Options > Design > General settings','wpShop')."</p>";
		}
	
		
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		$instance['cat_slug'] 			= strip_tags($new_instance['cat_slug']);
		$instance['cat_IDs'] 			= $new_instance['cat_IDs'];
		$instance['current_cat'] 		= $new_instance['current_cat'];
		$instance['current_maincat'] 	= $new_instance['current_maincat'];
		$instance['show_images'] 		= $new_instance['show_images'];
		$instance['thumb_width'] 		= strip_tags($new_instance['thumb_width']);
		$instance['num_img_in_row'] 	= $new_instance['num_img_in_row'];
		$instance['img_file_type'] 		= $new_instance['img_file_type'];
		return $instance;
	}
	
	function form($instance){
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('', 'wpShop'), 'cat_slug' => '', 'cat_IDs' => '', 'current_cat' => FALSE, 'current_maincat' => FALSE, 'show_images' => FALSE, 'thumb_width' => '80', 'num_img_in_row' => '3');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_slug' ); ?>"><?php _e('Category Name or Slug:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from one category enter it\'s name or slug here. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" value="<?php echo $instance['cat_slug']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_IDs' ); ?>"><?php _e('Category IDs:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from several categories enter their IDs seperated by comma eg. 1,3,4. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_IDs' ); ?>" name="<?php echo $this->get_field_name( 'cat_IDs' ); ?>" value="<?php echo $instance['cat_IDs']; ?>" style="width:97%;" />
		</p>
		
		<!-- query current cat || current main cat? Checkbox -->
		<p style="background:#F1F1F1;">
			<strong><?php _e('For use on Product Category Pages Only', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_cat'], true ); ?> id="<?php echo $this->get_field_id( 'current_cat' ); ?>" name="<?php echo $this->get_field_name( 'current_cat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_cat' ); ?>"><?php _e('Query Current Category', 'wpShop'); ?></label><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_maincat'], true ); ?> id="<?php echo $this->get_field_id( 'current_maincat' ); ?>" name="<?php echo $this->get_field_name( 'current_maincat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_maincat' ); ?>"><?php _e('Query Current Main (top level) Category', 'wpShop'); ?></label><br/>
			<small><?php _e('Check the appropriate box (not both!) if you like to query Product tags/terms from the current category or the current main (top level) category being viewed. This will only work if you have activated this widget on category pages! If you are using the widget on other pages please use one of the options above.', 'wpShop'); ?></small>
		</p>
		
		<p style="color:red;"><?php _e('By default the widget will collect all tags/terms specific to the category you have specified above and display them in a select drop down. Check the option below is you want to display a row of images instead. This requires that you create tag/term specific images for each!', 'wpShop'); ?></p>
		
		<!-- Show Images? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['show_images'], true ); ?> id="<?php echo $this->get_field_id( 'show_images' ); ?>" name="<?php echo $this->get_field_name( 'show_images' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_images' ); ?>"><?php _e('Display images', 'wpShop'); ?></label>
		</p>
		
		<small><?php _e('The fields below apply only if you have checked "Display Images" from above.', 'wpShop'); ?></small>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>"><?php _e('Thumb Width:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>"><?php _e('Number of images per row:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>" name="<?php echo $this->get_field_name( 'num_img_in_row' ); ?>" value="<?php echo $instance['num_img_in_row']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_file_type' ); ?>"><?php _e('Image File Type', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'img_file_type' ); ?>" name="<?php echo $this->get_field_name( 'img_file_type' ); ?>" class="widefat" style="width:97%;">
				<option value="jpg" <?php selected('jpg', $instance["img_file_type"]); ?>><?php _e('jpg', 'wpShop'); ?></option>
				<option value="png" <?php selected('png', $instance["img_file_type"]); ?>><?php _e('png', 'wpShop'); ?></option>
				<option value="gif" <?php selected('gif', $instance["img_file_type"]); ?>><?php _e('gif', 'wpShop'); ?></option>
			</select>
		</p>
		
		
	<?php }
}

// Shop by Brand Widget
class ShopByBrandWidget extends WP_Widget {

	function ShopByBrandWidget() {
		$widget_ops 	= array('classname' => 'shop_by_widget widget-shop-by-brand', 'description' => __( 'For "Shop by Brand" custom Taxonomy', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-shop-by-brand');
		$this->WP_Widget('nws-shop-by-brand', __('NWS Shop by Brand', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		
		global $OPTION;
	
		extract($args);
		$title 				= apply_filters('widget_title', $instance['title'] );
		$cat_slug 			= $instance['cat_slug'];
		$cat_IDs 			= $instance['cat_IDs'];
		$current_cat 		= isset( $instance['current_cat'] ) ? $instance['current_cat'] : FALSE;
		$current_maincat 	= isset( $instance['current_maincat'] ) ? $instance['current_maincat'] : FALSE;
		$show_images 		= isset( $instance['show_images'] ) ? $instance['show_images'] : FALSE;
		$thumb_width 		= $instance['thumb_width'];
		$num_img_in_row 	= $instance['num_img_in_row'];
		$img_file_type 		= $instance['img_file_type'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		//check to see if the taxonomy exists first
		$taxonomy_exist = taxonomy_exists(__('brand','wpShop'));
		if($taxonomy_exist) {
		if ($cat_slug!='') {
			query_posts('category_name='.$cat_slug.'&showposts=-1');
		} elseif($cat_IDs!='') {
			query_posts('cat='.$cat_IDs.'&showposts=-1');
		} elseif (($current_cat) && (is_category())) {
			$cat = get_category( get_query_var( 'cat' ), false );
			query_posts('cat='.$cat->cat_ID.'&showposts=-1');
		}elseif (($current_maincat) && (is_category())) {
			$cat 		= get_category( get_query_var( 'cat' ), false );
			$topParent 	= NWS_get_root_category($cat,'allData');
			query_posts('cat='.$topParent->cat_ID.'&showposts=-1');
		}
		
		if (have_posts()) : while (have_posts()) : the_post();
			$posttags = get_the_brand();
			if($posttags !== FALSE) {						
				foreach($posttags as $tag) {
					$all_tags_arr[] 	= $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
					$all_tagslugs_arr[] = $tag->slug;
				}
			}
		endwhile; endif; 
		
		if(!empty($all_tags_arr)){
			
			$tags_arr 		= array_unique($all_tags_arr); //REMOVES DUPLICATES
			$tagslugs_arr 	= array_unique($all_tagslugs_arr); //REMOVES DUPLICATES
			
			//sort asc
			sort($tags_arr);
			sort($tagslugs_arr);
			
			if ( $show_images ) { ?>
				<div class="img_wrap">
					<?php
					$counter = $num_img_in_row;
					$a = 1;
					foreach ($tags_arr as $k => $tag) {
						$term_obj = get_term_by('name',$tags_arr[$k], __('brand', 'wpShop'));
						
						$img_src 		= get_option('siteurl').'/'. $OPTION['upload_path'] .'/'. $term_obj->slug .'.'. $img_file_type;
						$des_src 		= $OPTION['upload_path'].'/cache';	
						$img_file 		= mkthumb($img_src,$des_src,$thumb_width,'width');    
						$imgURL 		= get_option('siteurl').'/'.$des_src.'/'.$img_file;
						$the_a_class 	= alternating_css_class($counter,$num_img_in_row,'first');
						
						echo '<a class="'.$the_a_class.' '.$cur_class.'" href="'.get_term_link($term_obj,__('brand','wpShop')).'" title="'.$term_obj->name .'"><img src="'.$imgURL .'" alt="'.$term_obj->slug .'" /></a>';
						
						$a++;
						$counter++;
					} ?>
				</div>
			<?php
			} else { ?>
				<div>
					<select name="tag-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option value="#"><?php _e('Please Select...','wpShop'); ?></option>
							<?php foreach ($tags_arr as $k => $tag) {
								$term_obj = get_term_by('name',$tags_arr[$k], __('brand', 'wpShop'));
								
								echo '<option value="'.get_term_link($term_obj,__('brand','wpShop')).'">'.$term_obj->name .'</option>';
								
							} ?>
					</select>
				</div>
			<?php }
		} 
		} else {
			echo "<p class='error'>".__('The widget you have activated needs that the "brand" custom taxonomy is active! Please activate it from your Theme Options > Design > General settings','wpShop')."</p>";
		}
	
		
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		$instance['cat_slug'] 			= strip_tags($new_instance['cat_slug']);
		$instance['cat_IDs'] 			= $new_instance['cat_IDs'];
		$instance['current_cat'] 		= $new_instance['current_cat'];
		$instance['current_maincat'] 	= $new_instance['current_maincat'];
		$instance['show_images'] 		= $new_instance['show_images'];
		$instance['thumb_width'] 		= strip_tags($new_instance['thumb_width']);
		$instance['num_img_in_row'] 	= $new_instance['num_img_in_row'];
		$instance['img_file_type'] 		= $new_instance['img_file_type'];
		return $instance;
	}
	
	function form($instance){
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('', 'wpShop'), 'cat_slug' => '', 'cat_IDs' => '', 'current_cat' => FALSE, 'current_maincat' => FALSE, 'show_images' => FALSE, 'thumb_width' => '80', 'num_img_in_row' => '3');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_slug' ); ?>"><?php _e('Category Name or Slug:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from one category enter it\'s name or slug here. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" value="<?php echo $instance['cat_slug']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_IDs' ); ?>"><?php _e('Category IDs:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from several categories enter their IDs seperated by comma eg. 1,3,4. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_IDs' ); ?>" name="<?php echo $this->get_field_name( 'cat_IDs' ); ?>" value="<?php echo $instance['cat_IDs']; ?>" style="width:97%;" />
		</p>
		
		<!-- query current cat || current main cat? Checkbox -->
		<p style="background:#F1F1F1;">
			<strong><?php _e('For use on Product Category Pages Only', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_cat'], true ); ?> id="<?php echo $this->get_field_id( 'current_cat' ); ?>" name="<?php echo $this->get_field_name( 'current_cat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_cat' ); ?>"><?php _e('Query Current Category', 'wpShop'); ?></label><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_maincat'], true ); ?> id="<?php echo $this->get_field_id( 'current_maincat' ); ?>" name="<?php echo $this->get_field_name( 'current_maincat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_maincat' ); ?>"><?php _e('Query Current Main (top level) Category', 'wpShop'); ?></label><br/>
			<small><?php _e('Check the appropriate box (not both!) if you like to query Product tags/terms from the current category or the current main (top level) category being viewed. This will only work if you have activated this widget on category pages! If you are using the widget on other pages please use one of the options above.', 'wpShop'); ?></small>
		</p>
		
		<p style="color:red;"><?php _e('By default the widget will collect all tags/terms specific to the category you have specified above and display them in a select drop down. Check the option below is you want to display a row of images instead. This requires that you create tag/term specific images for each!', 'wpShop'); ?></p>
		
		<!-- Show Images? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['show_images'], true ); ?> id="<?php echo $this->get_field_id( 'show_images' ); ?>" name="<?php echo $this->get_field_name( 'show_images' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_images' ); ?>"><?php _e('Display images', 'wpShop'); ?></label>
		</p>
		
		<small><?php _e('The fields below apply only if you have checked "Display Images" from above.', 'wpShop'); ?></small>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>"><?php _e('Thumb Width:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>"><?php _e('Number of images per row:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>" name="<?php echo $this->get_field_name( 'num_img_in_row' ); ?>" value="<?php echo $instance['num_img_in_row']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_file_type' ); ?>"><?php _e('Image File Type', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'img_file_type' ); ?>" name="<?php echo $this->get_field_name( 'img_file_type' ); ?>" class="widefat" style="width:97%;">
				<option value="jpg" <?php selected('jpg', $instance["img_file_type"]); ?>><?php _e('jpg', 'wpShop'); ?></option>
				<option value="png" <?php selected('png', $instance["img_file_type"]); ?>><?php _e('png', 'wpShop'); ?></option>
				<option value="gif" <?php selected('gif', $instance["img_file_type"]); ?>><?php _e('gif', 'wpShop'); ?></option>
			</select>
		</p>
		
		
	<?php }
}

// Shop by Selection Widget
class ShopBySelectionWidget extends WP_Widget {

	function ShopBySelectionWidget() {
		$widget_ops 	= array('classname' => 'shop_by_widget widget-shop-by-selection', 'description' => __( 'For "Shop by Selection" custom Taxonomy', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-shop-by-selection');
		$this->WP_Widget('nws-shop-by-selection', __('NWS Shop by Selection', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
	
		global $OPTION;
	
		extract($args);
		$title 				= apply_filters('widget_title', $instance['title'] );
		$cat_slug 			= $instance['cat_slug'];
		$cat_IDs 			= $instance['cat_IDs'];
		$current_cat 		= isset( $instance['current_cat'] ) ? $instance['current_cat'] : FALSE;
		$current_maincat 	= isset( $instance['current_maincat'] ) ? $instance['current_maincat'] : FALSE;
		$show_images 		= isset( $instance['show_images'] ) ? $instance['show_images'] : FALSE;
		$thumb_width 		= $instance['thumb_width'];
		$num_img_in_row 	= $instance['num_img_in_row'];
		$img_file_type 		= $instance['img_file_type'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		//check to see if the taxonomy exists first
		$taxonomy_exist = taxonomy_exists(__('selection','wpShop'));
		if($taxonomy_exist) {
		if ($cat_slug!='') {
			query_posts('category_name='.$cat_slug.'&showposts=-1');
		} elseif($cat_IDs!='') {
			query_posts('cat='.$cat_IDs.'&showposts=-1');
		} elseif (($current_cat) && (is_category())) {
			$cat = get_category( get_query_var( 'cat' ), false );
			query_posts('cat='.$cat->cat_ID.'&showposts=-1');
		}elseif (($current_maincat) && (is_category())) {
			$cat 		= get_category( get_query_var( 'cat' ), false );
			$topParent 	= NWS_get_root_category($cat,'allData');
			query_posts('cat='.$topParent->cat_ID.'&showposts=-1');
		}
		if (have_posts()) : while (have_posts()) : the_post();
			$posttags = get_the_selection();
			if($posttags !== FALSE) {						
				foreach($posttags as $tag) {
					$all_tags_arr[] 	= $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
					$all_tagslugs_arr[] = $tag->slug;
				}
			}
		endwhile; endif; 
		
		if(!empty($all_tags_arr)){
			
			$tags_arr 		= array_unique($all_tags_arr); //REMOVES DUPLICATES
			$tagslugs_arr 	= array_unique($all_tagslugs_arr); //REMOVES DUPLICATES
			
			//sort asc
			sort($tags_arr);
			sort($tagslugs_arr);
			
			if ( $show_images ) { ?>
				<div class="img_wrap">
					<?php
					$counter = $num_img_in_row;
					$a = 1;
					foreach ($tags_arr as $k => $tag) {
						$term_obj = get_term_by('name',$tags_arr[$k], __('selection', 'wpShop'));
						
						$img_src 		= get_option('siteurl').'/'. $OPTION['upload_path'] .'/'. $term_obj->slug .'.'. $img_file_type;
						$des_src 		= $OPTION['upload_path'].'/cache';	
						$img_file 		= mkthumb($img_src,$des_src,$thumb_width,'width');    
						$imgURL 		= get_option('siteurl').'/'.$des_src.'/'.$img_file;
						$the_a_class 	= alternating_css_class($counter,$num_img_in_row,'first');
						
						echo '<a class="'.$the_a_class.' '.$cur_class.'" href="'.get_term_link($term_obj,__('selection','wpShop')).'" title="'.$term_obj->name .'"><img src="'.$imgURL .'" alt="'.$term_obj->slug .'" /></a>';
						
						$a++;
						$counter++;
					} ?>
				</div>
			<?php 
			} else { ?>
				<div>
					<select name="tag-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option value="#"><?php _e('Please Select...','wpShop'); ?></option>
							<?php foreach ($tags_arr as $k => $tag) {
								$term_obj = get_term_by('name',$tags_arr[$k], __('selection', 'wpShop'));
								
								echo '<option value="'.get_term_link($term_obj,__('selection','wpShop')).'">'.$term_obj->name .'</option>';
								
							} ?>
					</select>
				</div>
			<?php }
		} 
		} else {
			echo "<p class='error'>".__('The widget you have activated needs that the "selection" custom taxonomy is active! Please activate it from your Theme Options > Design > General settings','wpShop')."</p>";
		}
		
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		$instance['cat_slug'] 			= strip_tags($new_instance['cat_slug']);
		$instance['cat_IDs'] 			= $new_instance['cat_IDs'];
		$instance['current_cat'] 		= $new_instance['current_cat'];
		$instance['current_maincat'] 	= $new_instance['current_maincat'];
		$instance['show_images'] 		= $new_instance['show_images'];
		$instance['thumb_width'] 		= strip_tags($new_instance['thumb_width']);
		$instance['num_img_in_row'] 	= $new_instance['num_img_in_row'];
		$instance['img_file_type'] 		= $new_instance['img_file_type'];
		return $instance;
	}
	
	function form($instance){
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('', 'wpShop'), 'cat_slug' => '', 'cat_IDs' => '', 'current_cat' => FALSE, 'current_maincat' => FALSE, 'show_images' => FALSE, 'thumb_width' => '80', 'num_img_in_row' => '3');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_slug' ); ?>"><?php _e('Category Name or Slug:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from one category enter it\'s name or slug here. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" value="<?php echo $instance['cat_slug']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_IDs' ); ?>"><?php _e('Category IDs:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from several categories enter their IDs seperated by comma eg. 1,3,4. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_IDs' ); ?>" name="<?php echo $this->get_field_name( 'cat_IDs' ); ?>" value="<?php echo $instance['cat_IDs']; ?>" style="width:97%;" />
		</p>
		
		<!-- query current cat || current main cat? Checkbox -->
		<p style="background:#F1F1F1;">
			<strong><?php _e('For use on Product Category Pages Only', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_cat'], true ); ?> id="<?php echo $this->get_field_id( 'current_cat' ); ?>" name="<?php echo $this->get_field_name( 'current_cat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_cat' ); ?>"><?php _e('Query Current Category', 'wpShop'); ?></label><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_maincat'], true ); ?> id="<?php echo $this->get_field_id( 'current_maincat' ); ?>" name="<?php echo $this->get_field_name( 'current_maincat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_maincat' ); ?>"><?php _e('Query Current Main (top level) Category', 'wpShop'); ?></label><br/>
			<small><?php _e('Check the appropriate box (not both!) if you like to query Product tags/terms from the current category or the current main (top level) category being viewed. This will only work if you have activated this widget on category pages! If you are using the widget on other pages please use one of the options above.', 'wpShop'); ?></small>
		</p>
		
		<p style="color:red;"><?php _e('By default the widget will collect all tags/terms specific to the category you have specified above and display them in a select drop down. Check the option below is you want to display a row of images instead. This requires that you create tag/term specific images for each!', 'wpShop'); ?></p>
		
		<!-- Show Images? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['show_images'], true ); ?> id="<?php echo $this->get_field_id( 'show_images' ); ?>" name="<?php echo $this->get_field_name( 'show_images' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_images' ); ?>"><?php _e('Display images', 'wpShop'); ?></label>
		</p>
		
		<small><?php _e('The fields below apply only if you have checked "Display Images" from above.', 'wpShop'); ?></small>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>"><?php _e('Thumb Width:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>"><?php _e('Number of images per row:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>" name="<?php echo $this->get_field_name( 'num_img_in_row' ); ?>" value="<?php echo $instance['num_img_in_row']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_file_type' ); ?>"><?php _e('Image File Type', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'img_file_type' ); ?>" name="<?php echo $this->get_field_name( 'img_file_type' ); ?>" class="widefat" style="width:97%;">
				<option value="jpg" <?php selected('jpg', $instance["img_file_type"]); ?>><?php _e('jpg', 'wpShop'); ?></option>
				<option value="png" <?php selected('png', $instance["img_file_type"]); ?>><?php _e('png', 'wpShop'); ?></option>
				<option value="gif" <?php selected('gif', $instance["img_file_type"]); ?>><?php _e('gif', 'wpShop'); ?></option>
			</select>
		</p>
		
		
	<?php }
}

// Shop by Style Widget
class ShopByStyleWidget extends WP_Widget {

	function ShopByStyleWidget() {
		$widget_ops 	= array('classname' => 'shop_by_widget widget-shop-by-style', 'description' => __( 'For "Shop by Style" custom Taxonomy', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-shop-by-style');
		$this->WP_Widget('nws-shop-by-style', __('NWS Shop by Style', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
	
		global $OPTION;
		
		extract($args);
		$title 				= apply_filters('widget_title', $instance['title'] );
		$cat_slug 			= $instance['cat_slug'];
		$cat_IDs 			= $instance['cat_IDs'];
		$current_cat 		= isset( $instance['current_cat'] ) ? $instance['current_cat'] : FALSE;
		$current_maincat 	= isset( $instance['current_maincat'] ) ? $instance['current_maincat'] : FALSE;
		$show_images 		= isset( $instance['show_images'] ) ? $instance['show_images'] : FALSE;
		$thumb_width 		= $instance['thumb_width'];
		$num_img_in_row 	= $instance['num_img_in_row'];
		$img_file_type 		= $instance['img_file_type'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		//check to see if the taxonomy exists first
		$taxonomy_exist = taxonomy_exists(__('style','wpShop'));
		if($taxonomy_exist) {
		if ($cat_slug!='') {
			query_posts('category_name='.$cat_slug.'&showposts=-1');
		} elseif($cat_IDs!='') {
			query_posts('cat='.$cat_IDs.'&showposts=-1');
		} elseif (($current_cat) && (is_category())) {
			$cat = get_category( get_query_var( 'cat' ), false );
			query_posts('cat='.$cat->cat_ID.'&showposts=-1');
		}elseif (($current_maincat) && (is_category())) {
			$cat 		= get_category( get_query_var( 'cat' ), false );
			$topParent 	= NWS_get_root_category($cat,'allData');
			query_posts('cat='.$topParent->cat_ID.'&showposts=-1');
		}
		if (have_posts()) : while (have_posts()) : the_post();
			$posttags = get_the_style();
			if($posttags !== FALSE) {					
				foreach($posttags as $tag) {
					$all_tags_arr[] 	= $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
					$all_tagslugs_arr[] = $tag->slug;
				}
			}
		endwhile; endif; 
		
		if(!empty($all_tags_arr)){
			
			$tags_arr 		= array_unique($all_tags_arr); //REMOVES DUPLICATES
			$tagslugs_arr 	= array_unique($all_tagslugs_arr); //REMOVES DUPLICATES
			
			//sort asc
			sort($tags_arr);
			sort($tagslugs_arr);
			
			if ( $show_images ) { ?>
				<div class="img_wrap">
					<?php
					$counter = $num_img_in_row;
					$a = 1;
					foreach ($tags_arr as $k => $tag) {
						$term_obj = get_term_by('name',$tags_arr[$k], __('style', 'wpShop'));
						
						$img_src 		= get_option('siteurl').'/'. $OPTION['upload_path'] .'/'. $term_obj->slug .'.'. $img_file_type;
						$des_src 		= $OPTION['upload_path'].'/cache';	
						$img_file 		= mkthumb($img_src,$des_src,$thumb_width,'width');    
						$imgURL 		= get_option('siteurl').'/'.$des_src.'/'.$img_file;
						$the_a_class 	= alternating_css_class($counter,$num_img_in_row,'first');
						
						echo '<a class="'.$the_a_class.' '.$cur_class.'" href="'.get_term_link($term_obj,__('style','wpShop')).'" title="'.$term_obj->name .'"><img src="'.$imgURL .'" alt="'.$term_obj->slug .'" /></a>';
						
						$a++;
						$counter++;
					} ?>
				</div>
			<?php 
			} else { ?>
				<div>
					<select name="tag-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option value="#"><?php _e('Please Select...','wpShop'); ?></option>
							<?php foreach ($tags_arr as $k => $tag) {
								$term_obj = get_term_by('name',$tags_arr[$k], __('style', 'wpShop'));
								
								echo '<option value="'.get_term_link($term_obj,__('style','wpShop')).'">'.$term_obj->name .'</option>';
								
							} ?>
					</select>
				</div>
			<?php }
		} 
	
		} else {
			echo "<p class='error'>".__('The widget you have activated needs that the "style" custom taxonomy is active! Please activate it from your Theme Options > Design > General settings','wpShop')."</p>";
		}
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		$instance['cat_slug'] 			= strip_tags($new_instance['cat_slug']);
		$instance['cat_IDs'] 			= $new_instance['cat_IDs'];
		$instance['current_cat'] 		= $new_instance['current_cat'];
		$instance['current_maincat'] 	= $new_instance['current_maincat'];
		$instance['show_images'] 		= $new_instance['show_images'];
		$instance['thumb_width'] 		= strip_tags($new_instance['thumb_width']);
		$instance['num_img_in_row'] 	= $new_instance['num_img_in_row'];
		$instance['img_file_type'] 		= $new_instance['img_file_type'];
		return $instance;
	}
	
	function form($instance){
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('', 'wpShop'), 'cat_slug' => '', 'cat_IDs' => '', 'current_cat' => FALSE, 'current_maincat' => FALSE, 'show_images' => FALSE, 'thumb_width' => '80', 'num_img_in_row' => '3');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_slug' ); ?>"><?php _e('Category Name or Slug:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from one category enter it\'s name or slug here. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" value="<?php echo $instance['cat_slug']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_IDs' ); ?>"><?php _e('Category IDs:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from several categories enter their IDs seperated by comma eg. 1,3,4. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_IDs' ); ?>" name="<?php echo $this->get_field_name( 'cat_IDs' ); ?>" value="<?php echo $instance['cat_IDs']; ?>" style="width:97%;" />
		</p>
		
		<!-- query current cat || current main cat? Checkbox -->
		<p style="background:#F1F1F1;">
			<strong><?php _e('For use on Product Category Pages Only', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_cat'], true ); ?> id="<?php echo $this->get_field_id( 'current_cat' ); ?>" name="<?php echo $this->get_field_name( 'current_cat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_cat' ); ?>"><?php _e('Query Current Category', 'wpShop'); ?></label><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_maincat'], true ); ?> id="<?php echo $this->get_field_id( 'current_maincat' ); ?>" name="<?php echo $this->get_field_name( 'current_maincat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_maincat' ); ?>"><?php _e('Query Current Main (top level) Category', 'wpShop'); ?></label><br/>
			<small><?php _e('Check the appropriate box (not both!) if you like to query Product tags/terms from the current category or the current main (top level) category being viewed. This will only work if you have activated this widget on category pages! If you are using the widget on other pages please use one of the options above.', 'wpShop'); ?></small>
		</p>
		
		<p style="color:red;"><?php _e('By default the widget will collect all tags/terms specific to the category you have specified above and display them in a select drop down. Check the option below is you want to display a row of images instead. This requires that you create tag/term specific images for each!', 'wpShop'); ?></p>
		
		<!-- Show Images? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['show_images'], true ); ?> id="<?php echo $this->get_field_id( 'show_images' ); ?>" name="<?php echo $this->get_field_name( 'show_images' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_images' ); ?>"><?php _e('Display images', 'wpShop'); ?></label>
		</p>
		
		<small><?php _e('The fields below apply only if you have checked "Display Images" from above.', 'wpShop'); ?></small>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>"><?php _e('Thumb Width:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>"><?php _e('Number of images per row:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>" name="<?php echo $this->get_field_name( 'num_img_in_row' ); ?>" value="<?php echo $instance['num_img_in_row']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_file_type' ); ?>"><?php _e('Image File Type', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'img_file_type' ); ?>" name="<?php echo $this->get_field_name( 'img_file_type' ); ?>" class="widefat" style="width:97%;">
				<option value="jpg" <?php selected('jpg', $instance["img_file_type"]); ?>><?php _e('jpg', 'wpShop'); ?></option>
				<option value="png" <?php selected('png', $instance["img_file_type"]); ?>><?php _e('png', 'wpShop'); ?></option>
				<option value="gif" <?php selected('gif', $instance["img_file_type"]); ?>><?php _e('gif', 'wpShop'); ?></option>
			</select>
		</p>
		
		
	<?php }
}

// Shop by Price Widget
class ShopByPriceWidget extends WP_Widget {

	function ShopByPriceWidget() {
		$widget_ops 	= array('classname' => 'shop_by_widget widget-shop-by-price', 'description' => __( 'For "Shop by Price" custom Taxonomy', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-shop-by-price');
		$this->WP_Widget('nws-shop-by-price', __('NWS Shop by Price', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
	
		global $OPTION;
	
		extract($args);
		$title 				= apply_filters('widget_title', $instance['title'] );
		$cat_slug 			= $instance['cat_slug'];
		$cat_IDs 			= $instance['cat_IDs'];
		$current_cat 		= isset( $instance['current_cat'] ) ? $instance['current_cat'] : FALSE;
		$current_maincat 	= isset( $instance['current_maincat'] ) ? $instance['current_maincat'] : FALSE;
		$show_images 		= isset( $instance['show_images'] ) ? $instance['show_images'] : FALSE;
		$thumb_width 		= $instance['thumb_width'];
		$num_img_in_row 	= $instance['num_img_in_row'];
		$img_file_type 		= $instance['img_file_type'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		//check to see if the taxonomy exists first
		$taxonomy_exist = taxonomy_exists(__('price','wpShop'));
		if($taxonomy_exist) {
		if ($cat_slug!='') {
			query_posts('category_name='.$cat_slug.'&showposts=-1');
		} elseif($cat_IDs!='') {
			query_posts('cat='.$cat_IDs.'&showposts=-1');
		} elseif (($current_cat) && (is_category())) {
			$cat = get_category( get_query_var( 'cat' ), false );
			query_posts('cat='.$cat->cat_ID.'&showposts=-1');
		}elseif (($current_maincat) && (is_category())) {
			$cat 		= get_category( get_query_var( 'cat' ), false );
			$topParent 	= NWS_get_root_category($cat,'allData');
			query_posts('cat='.$topParent->cat_ID.'&showposts=-1');
		}
		if (have_posts()) : while (have_posts()) : the_post();
			$posttags = get_the_price();
			if($posttags !== FALSE) {					
				foreach($posttags as $tag) {
					$all_tags_arr[] 	= $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
					$all_tagslugs_arr[] = $tag->slug;
				}
			}
		endwhile; endif; 
		
		if(!empty($all_tags_arr)){
			
			$tags_arr 		= array_unique($all_tags_arr); //REMOVES DUPLICATES
			$tagslugs_arr 	= array_unique($all_tagslugs_arr); //REMOVES DUPLICATES
			
			//sort asc
			sort($tags_arr);
			sort($tagslugs_arr);
			
			if ( $show_images ) { ?>
				<div class="img_wrap">
					<?php
					$counter = $num_img_in_row;
					$a = 1;
					foreach ($tags_arr as $k => $tag) {
						$term_obj = get_term_by('name',$tags_arr[$k], __('price', 'wpShop'));
						
						$img_src 		= get_option('siteurl').'/'. $OPTION['upload_path'] .'/'. $term_obj->slug .'.'. $img_file_type;
						$des_src 		= $OPTION['upload_path'].'/cache';	
						$img_file 		= mkthumb($img_src,$des_src,$thumb_width,'width');    
						$imgURL 		= get_option('siteurl').'/'.$des_src.'/'.$img_file;
						$the_a_class 	= alternating_css_class($counter,$num_img_in_row,'first');
						
						echo '<a class="'.$the_a_class.' '.$cur_class.'" href="'.get_term_link($term_obj,__('price','wpShop')).'" title="'.$term_obj->name .'"><img src="'.$imgURL .'" alt="'.$term_obj->slug .'" /></a>';
						
						$a++;
						$counter++;
					} ?>
				</div>
			<?php 
			} else { ?>
				<div>
					<select name="tag-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option value="#"><?php _e('Please Select...','wpShop'); ?></option>
							<?php foreach ($tags_arr as $k => $tag) {
								$term_obj = get_term_by('name',$tags_arr[$k], __('price', 'wpShop'));
								
								echo '<option value="'.get_term_link($term_obj,__('price','wpShop')).'">'.$term_obj->name .'</option>';
								
							} ?>
					</select>
				</div>
			<?php }
		} 
		} else {
			echo "<p class='error'>".__('The widget you have activated needs that the "price" custom taxonomy is active! Please activate it from your Theme Options > Design > General settings','wpShop')."</p>";
		}
		
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		$instance['cat_slug'] 			= strip_tags($new_instance['cat_slug']);
		$instance['cat_IDs'] 			= $new_instance['cat_IDs'];
		$instance['current_cat'] 		= $new_instance['current_cat'];
		$instance['current_maincat'] 	= $new_instance['current_maincat'];
		$instance['show_images'] 		= $new_instance['show_images'];
		$instance['thumb_width'] 		= strip_tags($new_instance['thumb_width']);
		$instance['num_img_in_row'] 	= $new_instance['num_img_in_row'];
		$instance['img_file_type'] 		= $new_instance['img_file_type'];
		return $instance;
	}
	
	function form($instance){
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('', 'wpShop'), 'cat_slug' => '', 'cat_IDs' => '', 'current_cat' => FALSE, 'current_maincat' => FALSE, 'show_images' => FALSE, 'thumb_width' => '80', 'num_img_in_row' => '3');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_slug' ); ?>"><?php _e('Category Name or Slug:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from one category enter it\'s name or slug here. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" value="<?php echo $instance['cat_slug']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_IDs' ); ?>"><?php _e('Category IDs:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query Product tags/terms from several categories enter their IDs seperated by comma eg. 1,3,4. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_IDs' ); ?>" name="<?php echo $this->get_field_name( 'cat_IDs' ); ?>" value="<?php echo $instance['cat_IDs']; ?>" style="width:97%;" />
		</p>
		
		<!-- query current cat || current main cat? Checkbox -->
		<p style="background:#F1F1F1;">
			<strong><?php _e('For use on Product Category Pages Only', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_cat'], true ); ?> id="<?php echo $this->get_field_id( 'current_cat' ); ?>" name="<?php echo $this->get_field_name( 'current_cat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_cat' ); ?>"><?php _e('Query Current Category', 'wpShop'); ?></label><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_maincat'], true ); ?> id="<?php echo $this->get_field_id( 'current_maincat' ); ?>" name="<?php echo $this->get_field_name( 'current_maincat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_maincat' ); ?>"><?php _e('Query Current Main (top level) Category', 'wpShop'); ?></label><br/>
			<small><?php _e('Check the appropriate box (not both!) if you like to query Product tags/terms from the current category or the current main (top level) category being viewed. This will only work if you have activated this widget on category pages! If you are using the widget on other pages please use one of the options above.', 'wpShop'); ?></small>
		</p>
		
		<p style="color:red;"><?php _e('By default the widget will collect all tags/terms specific to the category you have specified above and display them in a select drop down. Check the option below is you want to display a row of images instead. This requires that you create tag/term specific images for each!', 'wpShop'); ?></p>
		
		<!-- Show Images? Checkbox -->
		<p>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['show_images'], true ); ?> id="<?php echo $this->get_field_id( 'show_images' ); ?>" name="<?php echo $this->get_field_name( 'show_images' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'show_images' ); ?>"><?php _e('Display images', 'wpShop'); ?></label>
		</p>
		
		<small><?php _e('The fields below apply only if you have checked "Display Images" from above.', 'wpShop'); ?></small>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>"><?php _e('Thumb Width:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>"><?php _e('Number of images per row:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>" name="<?php echo $this->get_field_name( 'num_img_in_row' ); ?>" value="<?php echo $instance['num_img_in_row']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_file_type' ); ?>"><?php _e('Image File Type', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'img_file_type' ); ?>" name="<?php echo $this->get_field_name( 'img_file_type' ); ?>" class="widefat" style="width:97%;">
				<option value="jpg" <?php selected('jpg', $instance["img_file_type"]); ?>><?php _e('jpg', 'wpShop'); ?></option>
				<option value="png" <?php selected('png', $instance["img_file_type"]); ?>><?php _e('png', 'wpShop'); ?></option>
				<option value="gif" <?php selected('gif', $instance["img_file_type"]); ?>><?php _e('gif', 'wpShop'); ?></option>
			</select>
		</p>
		
		
	<?php }
}

// the FAQs Widget
class FAQs extends WP_Widget {

	function FAQs() {
		$widget_ops 	= array('classname' => 'widget_faq', 'description' => __( 'For Commonly Asked Questions', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-faqs');
		$this->WP_Widget('nws-faqs', __('NWS FAQs', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		extract($args);
		$title 		= apply_filters('widget_title', $instance['title'] );
		$q1 		= $instance['q1'];
		$link1 		= $instance['link1'];
		$q2 		= $instance['q2'];
		$link2 		= $instance['link2'];
		$q3 		= $instance['q3'];
		$link3 		= $instance['link3'];
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		?>
	
		<ul>
			<li><a href="<?php echo $link1;?>"><?php echo $q1;?></a></li>
			<li><a href="<?php echo $link2;?>"><?php echo $q2;?></a></li>
			<li><a href="<?php echo $link3;?>"><?php echo $q3;?></a></li>
		</ul>
			
		
		<?php
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 		= strip_tags($new_instance['title']);
		$instance['q1'] 		= strip_tags($new_instance['q1']);
		$instance['link1'] 		= $new_instance['link1'];
		$instance['q2'] 		= strip_tags($new_instance['q2']);
		$instance['link2'] 		= $new_instance['link2'];
		$instance['q3'] 		= strip_tags($new_instance['q3']);
		$instance['link3'] 		= $new_instance['link3'];
		return $instance;
	}
	
	function form($instance){
		// Set up some default widget settings.
		$defaults = array( 'title' => __('', 'wpShop'), 'q1' => '', 'link1' => '', 'q2' => '', 'link2' => '', 'q3' => '', 'link3' => '');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'q1' ); ?>"><?php _e('Question 1:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'q1' ); ?>" name="<?php echo $this->get_field_name( 'q1' ); ?>" value="<?php echo $instance['q1']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link1' ); ?>"><?php _e('Links to (full path):', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'link1' ); ?>" name="<?php echo $this->get_field_name( 'link1' ); ?>" value="<?php echo $instance['link1']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'q2' ); ?>"><?php _e('Question 2:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'q2' ); ?>" name="<?php echo $this->get_field_name( 'q2' ); ?>" value="<?php echo $instance['q2']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link2' ); ?>"><?php _e('Links to (full path):', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'link2' ); ?>" name="<?php echo $this->get_field_name( 'link2' ); ?>" value="<?php echo $instance['link2']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'q3' ); ?>"><?php _e('Question 3:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'q3' ); ?>" name="<?php echo $this->get_field_name( 'q3' ); ?>" value="<?php echo $instance['q3']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link3' ); ?>"><?php _e('Links to (full path):', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'link3' ); ?>" name="<?php echo $this->get_field_name( 'link3' ); ?>" value="<?php echo $instance['link3']; ?>" style="width:97%;" />
		</p>
	<?php }
}

// most recent Prods in current category Widget
class RecentProds extends WP_Widget {

	function RecentProds() {
		$widget_ops 	= array('classname' => 'widget_recentProds', 'description' => __( 'Display Recent Products', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-recent-products');
		$this->WP_Widget('nws-recent-products', __('NWS Recent Products', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		global $OPTION;
		
		extract($args);
		$title 				= apply_filters('widget_title', $instance['title'] );
		
		$cat_slug 			= $instance['cat_slug'];
		$cat_IDs 			= $instance['cat_IDs'];
		$current_cat 		= isset( $instance['current_cat'] ) ? $instance['current_cat'] : FALSE;
		$current_maincat 	= isset( $instance['current_maincat'] ) ? $instance['current_maincat'] : FALSE;
		
		$display 			= $instance['display'];
		$showposts 			= $instance['showposts'];
		$img_size 			= $instance['img_size'];
		$num_img_in_row 	= $instance['num_img_in_row'];
		
		$wp_thumb 			= isset( $instance['wp_thumb'] ) ? $instance['wp_thumb'] : FALSE;
		$scroll 			= isset( $instance['scroll'] ) ? $instance['scroll'] : FALSE;
		
		$prod_title 	= isset( $instance['prod_title'] ) ? $instance['prod_title'] : FALSE;
		$prod_price 	= isset( $instance['prod_price'] ) ? $instance['prod_price'] : FALSE;
		$prod_btn 		= isset( $instance['prod_btn'] ) ? $instance['prod_btn'] : FALSE;
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		// prepare the query
		
		if ($cat_slug!='') {
			$param		= array(
				'category_name' 	=> $cat_slug,
				'showposts'			=> $showposts, 
				'caller_get_posts'	=> 1
			);
		} elseif($cat_IDs!='') {
			$param		= array(
				'cat' 				=> $cat_IDs,
				'showposts'			=> $showposts, 
				'caller_get_posts'	=> 1
			);
		} elseif (($current_cat) && (is_category())) {
			$cat = get_category( get_query_var( 'cat' ), false );
			$param		= array(
				'cat' 				=> $cat->term_id,
				'showposts'			=> $showposts, 
				'caller_get_posts'	=> 1
			);
		}elseif (($current_maincat) && (is_category())) {
			$cat 		= get_category( get_query_var( 'cat' ), false );
			$topParent 	= NWS_get_root_category($cat,'allData');
			$param		= array(
				'cat' 				=> $topParent->term_id,
				'showposts'			=> $showposts, 
				'caller_get_posts'	=> 1
			);
		}
		
		// query	
		$my_catRecent_query = new wp_query($param);
		
		// do we have posts?	
		if($my_catRecent_query->have_posts()) 
		{ 
		// some html before the loop
		
			if ($scroll && $display == 'Images') { ?>
			<div class="widget_content_wrap prods_scrollable_wrap">
			<a class="prev browse left"></a>
			<div class="prods_scrollable">
		<?php } 
		
		
			if ( $display == 'Images' ) { ?>
				<ul <?php echo ($scroll ? '': 'class="widget_content_wrap clearfix"');?>>
			<?php }
			
			if ( $display == 'List' ) { 
				echo "<ul>";
			}
			if ( $display == 'Drop Down' ) { ?>
				<div>
					<select name="prod-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
						<option value="#"><?php _e('Please Select...','wpShop'); ?></option>
			<?php }
			
			// set counter
			$counter = $num_img_in_row;
			$a = 1;	
			// run the loop 			
			while ($my_catRecent_query->have_posts()) 
			{ 	
				$my_catRecent_query->the_post(); 
				
				//get post id
				$postid = get_the_ID();
				
				// do we want images?
				if ( $display == 'Images' ) { 
					
					$output 		= my_attachment_images(0,1);
					$imgNum 		= count($output);
					if($imgNum != 0){
						$imgURL		= array();
						foreach($output as $v){
						
							$img_src 	= $v;
							
							// do we want the WordPress Generated thumbs?
							if ($wp_thumb) {
								//get the file type
								$img_file_type = strrchr($img_src, '.');
								//get the image name without the file type
								$parts = explode($img_file_type,$img_src);
								// get the thumbnail dimmensions
								$width = get_option('thumbnail_size_w');
								$height = get_option('thumbnail_size_h');
								//put everything together
								$imgURL[] = $parts[0].'-'.$width.'x'.$height.$img_file_type;
							
							// no? then display the default proportionally resized thumbnails
							} else {
								$des_src 	= $OPTION['upload_path'].'/cache';							
								$img_file 	= mkthumb($img_src,$des_src,$img_size,'width');    
								$imgURL[] 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;	
							}
							
						}
					}	
				
					// put output together
					if($imgNum != 0){ 

						$permalink 		= get_permalink();
						$title_attr2	= the_title_attribute('echo=0');
						$title_attr		= str_replace("%s",the_title_attribute('echo=0'), __('Permalink to %s', 'wpShop'));
						$the_a_class 	= alternating_css_class($counter,$num_img_in_row,'first');
						
						echo "<li class='recent_prod_wrap $the_a_class' style='width:{$img_size}px'>
							<a href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL[0]' alt='$title_attr2'/></a>"; 
							
							if($prod_title || $prod_price || $prod_btn){ ?>
								<div class="teaser">
									<?php if($prod_title){ ?>
										<h5 class="prod-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'wpShop'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h5>
									<?php }	
									if($prod_price && strlen(get_custom_field('price', FALSE))>0){ ?>
										<p class="price_value">
											<?php if(strlen(get_custom_field2($postid,'new_price', FALSE))>0){ ?>
																				
													<span class="was price">
														<?php if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(get_custom_field2($postid,'price'));?></span>
													<span class="is price">
														<?php if($attr_option == 2){_e('From: ','wpShop');} 
															if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(get_custom_field2($postid,'new_price')); 
															if($OPTION['wps_currency_code_enable']) { echo ' '. $OPTION['wps_currency_code']; }
															if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } ?>
													</span>
																			
											<?php } elseif(strlen(get_custom_field2($postid,'price', FALSE))>0){ ?>
																			
													<span class="price solo"><?php if($attr_option == 2){_e('From: ','wpShop');} 
														if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(get_custom_field2($postid,'price')); 
														if($OPTION['wps_currency_code_enable']) { echo ' '. $OPTION['wps_currency_code']; }
														if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } ?></span>
																			
											<?php }	?>
										</p><!-- price_value -->
									<?php }	
									if($OPTION['wps_shoppingCartEngine_yes'] && $prod_btn && strlen(get_custom_field2($postid, 'disable_cart', FALSE))==0){ 
										// shop mode
										$wps_shop_mode 	= $OPTION['wps_shop_mode'];
										
										if($wps_shop_mode =='Inquiry email mode'){ ?>
											<span class="shopform_btn add_to_enquire_alt"><a href="<?php the_permalink(); ?>"><?php printf(__ ('Add to %s!','wpShop'), $OPTION['wps_pgNavi_inquireOption'])?></a></span>
										<?php } elseif ($wps_shop_mode=='Normal shop mode' && !is_it_affiliate()){ ?>
											<span class="shopform_btn add_to_cart_alt"><a  href="<?php the_permalink(); ?>"><?php printf(__ ('Add to %s!','wpShop'), $OPTION['wps_pgNavi_cartOption'])?></a></span>
										<?php } elseif ($wps_shop_mode=='affiliate_mode' || is_it_affiliate()){ ?>
											<span class="shopform_btn buy_now_alt"><a href="<?php get_custom_field('buy_now', TRUE); ?>" <?php if($OPTION['wps_affili_newTab']) { ?> title="<?php _e('Opens is new tab','wpShop'); ?>" target="_blank"<?php } ?>><?php _e('Buy Now','wpShop'); ?></a></span>
										<?php } else {}
									
									} ?>
								</div>
							<?php }
						echo "</li>";						
						
						$a++;
						$counter++;
						
					// no attachments? pull image from custom field
					} elseif(strlen(get_custom_field2($postid,'image_thumb', FALSE))>0) {  
						$permalink 		= get_permalink();
						$title_attr2	= the_title_attribute('echo=0');
						$title_attr		= str_replace("%s",the_title_attribute('echo=0'), __('Permalink to %s', 'wpShop'));
						
						// resize the image.
						$img_src 		= get_custom_field2($postid,'image_thumb', FALSE);
						$des_src 		= $OPTION['upload_path'].'/cache';								
						$img_file 		= mkthumb($img_src,$des_src,$img_size,'width');    
						$imgURL 		= get_option('siteurl').'/'.$des_src.'/'.$img_file;	
						
						
						// do we want the WordPress Generated thumbs?
						if ($wp_thumb) {
							//get the file type
							$img_file_type = strrchr($img_src  , '.');
							//get the image name without the file type
							$parts = explode($img_file_type,$img_src);
							// get the thumbnail dimmensions
							$width = get_option('thumbnail_size_w');
							$height = get_option('thumbnail_size_h');
							//put everything together
							$imgURL = $parts[0].'-'.$width.'x'.$height.$img_file_type;
						}
						
						$the_a_class 	= alternating_css_class($counter,$num_img_in_row,'first');
						
						echo "<li class='recent_prod_wrap $the_a_class' style='width:{$img_size}px'>
							<a href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL' alt='$title_attr2'/></a>"; 
							
							if($prod_title || $prod_price || $prod_btn){ ?>
								<div class="teaser">
									<?php if($prod_title){ ?>
										<h5 class="prod-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'wpShop'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h5>
									<?php }	
									if($prod_price && strlen(get_custom_field('price', FALSE))>0){ ?>
										<p class="price_value">
											<?php if(strlen(get_custom_field2($postid,'new_price', FALSE))>0){ ?>
																				
													<span class="was price">
														<?php if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(get_custom_field2($postid,'price'));?></span>
													<span class="is price">
														<?php if($attr_option == 2){_e('From: ','wpShop');} 
															if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(get_custom_field2($postid,'new_price')); 
															if($OPTION['wps_currency_code_enable']) { echo ' '. $OPTION['wps_currency_code']; }
															if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } ?>
													</span>
																			
											<?php } elseif(strlen(get_custom_field2($postid,'price', FALSE))>0){ ?>
																			
													<span class="price solo"><?php if($attr_option == 2){_e('From: ','wpShop');} 
														if($OPTION['wps_currency_symbol'] !='') { echo $OPTION['wps_currency_symbol'];} echo format_price(get_custom_field2($postid,'price')); 
														if($OPTION['wps_currency_code_enable']) { echo ' '. $OPTION['wps_currency_code']; }
														if($OPTION['wps_currency_symbol_alt'] !='') { echo " " . $OPTION['wps_currency_symbol_alt']; } ?></span>
																			
											<?php }	?>
										</p><!-- price_value -->
									<?php }	
									if($OPTION['wps_shoppingCartEngine_yes'] && $prod_btn && strlen(get_custom_field2($postid, 'disable_cart', FALSE))==0){ 
										// shop mode
										$wps_shop_mode 	= $OPTION['wps_shop_mode'];
										
										if($wps_shop_mode =='Inquiry email mode'){ ?>
											<span class="shopform_btn add_to_enquire_alt"><a href="<?php the_permalink(); ?>"><?php printf(__ ('Add to %s!','wpShop'), $OPTION['wps_pgNavi_inquireOption'])?></a></span>
										<?php } elseif ($wps_shop_mode=='Normal shop mode' && !is_it_affiliate()){ ?>
											<span class="shopform_btn add_to_cart_alt"><a  href="<?php the_permalink(); ?>"><?php printf(__ ('Add to %s!','wpShop'), $OPTION['wps_pgNavi_cartOption'])?></a></span>
										<?php } elseif ($wps_shop_mode=='affiliate_mode' || is_it_affiliate()){ ?>
											<span class="shopform_btn buy_now_alt"><a href="<?php get_custom_field('buy_now', TRUE); ?>" <?php if($OPTION['wps_affili_newTab']) { ?> title="<?php _e('Opens is new tab','wpShop'); ?>" target="_blank"<?php } ?>><?php _e('Buy Now','wpShop'); ?></a></span>
										<?php } else {}
									
									} ?>
								</div>
							<?php }
						echo "</li>";
						
						$a++;
						$counter++;
						 
					// no images altogether? Let them know!
					} else {
						
						$err_message 	= __('Oops! No Product Images were found.','wpShop');									
						echo "<p class='error'>$err_message</p>";
					}
				
				// otherwise put together a list
				} elseif ( $display == 'List' ) {
					$permalink 		= get_permalink();
					$title_attr		= str_replace("%s",the_title_attribute('echo=0'), __('Permalink to %s', 'wpShop'));
					$title			= get_the_title();
					echo "<li><a href='{$permalink}' title='{$title_attr}'>{$title}</a></li>";
				
				// otherwise we put together a drop down
				} else {
					$permalink 		= get_permalink();
					$title			= get_the_title();
					echo "<option value='{$permalink}'>{$title}</option>";
				}
				
			} wp_reset_query();
			
			if ( $display == 'Images' ) { 
				echo "</ul'>";
			}
			
			if ( $display == 'List' ) { 
				echo "</ul>";
			}
			if ( $display == 'Drop Down' ) { 
				echo "</select></div>";
			}
			
			if ($scroll && $display == 'Images') { ?>
				</div><!--scrollable-->
				<a class="next browse right"></a>
				</div><!--prods_scrollable_wrap-->
			<?php }
			
		} else {
			$err_message 	= __('There\'s no Recent Products yet in this Category','wpShop');									
			echo "<p class='error'>$err_message</p>";
		}
		 
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 				= strip_tags($new_instance['title']);
		
		$instance['cat_slug'] 			= strip_tags($new_instance['cat_slug']);
		$instance['cat_IDs'] 			= $new_instance['cat_IDs'];
		$instance['current_cat'] 		= $new_instance['current_cat'];
		$instance['current_maincat'] 	= $new_instance['current_maincat'];
		
		$instance['display'] 			= $new_instance['display'];
		$instance['showposts'] 			= $new_instance['showposts'];
		$instance['img_size'] 			= strip_tags($new_instance['img_size']);
		$instance['num_img_in_row'] 	= $new_instance['num_img_in_row'];
		
		$instance['wp_thumb'] 			= $new_instance['wp_thumb'];
		$instance['scroll'] 			= $new_instance['scroll'];
		
		$instance['prod_title'] 		= $new_instance['prod_title'];
		$instance['prod_price'] 		= $new_instance['prod_price'];
		$instance['prod_btn'] 			= $new_instance['prod_btn'];
		return $instance;
	}
	
	function form($instance){
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('', 'wpShop'), 'cat_slug' => '', 'cat_IDs' => '', 'current_cat' => FALSE, 'current_maincat' => FALSE, 'show_images' => FALSE, 'img_size' => '180', 'showposts' => '5', 'num_img_in_row' => '5','prod_title' => FALSE, 'prod_price' => FALSE, 'prod_btn' => FALSE);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_slug' ); ?>"><?php _e('Category Name or Slug:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query recent Products from one category enter it\'s name or slug here. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_slug' ); ?>" name="<?php echo $this->get_field_name( 'cat_slug' ); ?>" value="<?php echo $instance['cat_slug']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat_IDs' ); ?>"><?php _e('Category IDs:', 'wpShop'); ?></label><br/>
			<small><?php _e('If you like to query recent Products from several categories enter their IDs seperated by comma eg. 1,3,4. Otherwise leave empty!', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'cat_IDs' ); ?>" name="<?php echo $this->get_field_name( 'cat_IDs' ); ?>" value="<?php echo $instance['cat_IDs']; ?>" style="width:97%;" />
		</p>
		
		<!-- query current cat || current main cat? Checkbox -->
		<p style="background:#F1F1F1;">
			<strong><?php _e('For use on Product Category Pages Only', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_cat'], true ); ?> id="<?php echo $this->get_field_id( 'current_cat' ); ?>" name="<?php echo $this->get_field_name( 'current_cat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_cat' ); ?>"><?php _e('Query Current Category', 'wpShop'); ?></label><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['current_maincat'], true ); ?> id="<?php echo $this->get_field_id( 'current_maincat' ); ?>" name="<?php echo $this->get_field_name( 'current_maincat' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'current_maincat' ); ?>"><?php _e('Query Current Main (top level) Category', 'wpShop'); ?></label><br/>
			<small><?php _e('Check the appropriate box (not both!) if you like to query recent Products from the current category or the current main (top level) category being viewed. This will only work if you have activated this widget on category pages! If you are using the widget on other pages please use one of the options above.', 'wpShop'); ?></small>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'showposts' ); ?>"><?php _e('Number of Recent Products', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'showposts' ); ?>" name="<?php echo $this->get_field_name( 'showposts' ); ?>" value="<?php echo $instance['showposts']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'display' ); ?>"><?php _e('Display as:', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat" style="width:97%;">
				<option value="List" <?php selected('List', $instance["display"]); ?>><?php _e('List', 'wpShop'); ?></option>
				<option value="Images" <?php selected('Images', $instance["display"]); ?>><?php _e('Images', 'wpShop'); ?></option>
				<option value="Drop Down" <?php selected('Drop Down', $instance["display"]); ?>><?php _e('Drop Down', 'wpShop'); ?></option>
			</select>
		</p>
		
		<small><?php _e('The fields below apply only if you have selected "Images" from above.', 'wpShop'); ?></small>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'img_size' ); ?>"><?php _e('Thumb Width:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'img_size' ); ?>" name="<?php echo $this->get_field_name( 'img_size' ); ?>" value="<?php echo $instance['img_size']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>"><?php _e('Number of images per row:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'v' ); ?>" name="<?php echo $this->get_field_name( 'num_img_in_row' ); ?>" value="<?php echo $instance['num_img_in_row']; ?>" style="width:97%;" />
		</p>
		<p>
			<strong><?php _e('Optional', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['wp_thumb'], true ); ?> id="<?php echo $this->get_field_id( 'wp_thumb' ); ?>" name="<?php echo $this->get_field_name( 'wp_thumb' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'wp_thumb' ); ?>"><?php _e('Use WordPress generated image thumbs?', 'wpShop'); ?></label><br/>
		</p>
		<p>
			<strong><?php _e('Optional', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['scroll'], true ); ?> id="<?php echo $this->get_field_id( 'scroll' ); ?>" name="<?php echo $this->get_field_name( 'scroll' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'scroll' ); ?>"><?php _e('Make scrollable', 'wpShop'); ?></label><br/>
			<small><?php _e('Will only work is you have selected "Display as: Images" further up!', 'wpShop'); ?></small>
		
		</p>
		
		<p style="background:#F1F1F1;">
			<strong><?php _e('Optional', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['prod_title'], true ); ?> id="<?php echo $this->get_field_id( 'prod_title' ); ?>" name="<?php echo $this->get_field_name( 'prod_title' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'prod_title' ); ?>"><?php _e('Display Product Title', 'wpShop'); ?></label><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['prod_price'], true ); ?> id="<?php echo $this->get_field_id( 'prod_price' ); ?>" name="<?php echo $this->get_field_name( 'prod_price' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'prod_price' ); ?>"><?php _e('Display Product Price', 'wpShop'); ?></label><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['prod_btn'], true ); ?> id="<?php echo $this->get_field_id( 'prod_btn' ); ?>" name="<?php echo $this->get_field_name( 'prod_btn' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'prod_btn' ); ?>"><?php _e('Display "Add to Cart" button', 'wpShop'); ?></label><br/>
		</p>
	<?php }
}

class RecentBlogPosts extends WP_Widget {

	function RecentBlogPosts() {
		$widget_ops 	= array('classname' => 'latest_from_blog_widget', 'description' => __( 'For Recent Blog Posts', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-recent-blog-posts');
		$this->WP_Widget('nws-recent-blog-posts', __('NWS Recent Blog Posts', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		global $OPTION;
		
		extract($args);
		$title 		= apply_filters('widget_title', $instance['title'] );
		$showposts 	= $instance['showposts'];
		$wordLimit 	= $instance['wordLimit'];
		$post_tw 	= $instance['post_tw'];
		$post_th 	= $instance['post_th'];
		$order		= $instance['order'];
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		// prepare the query
		//get blog ID
		$blog_ID 	= get_cat_ID($OPTION['wps_blogCat']);
		$param		= array(
			'cat' 				=> $blog_ID,
			'showposts'			=> $showposts,
			'order'				=> $order,			
			'caller_get_posts'	=> 1
		);
		?>
		
		<div class="widget_content_wrap">
			<?php	
			// query	
			$my_recBlogPosts_query = new wp_query($param);
		
			// do we have posts?	
			if($my_recBlogPosts_query->have_posts()) 
			{ 
				// run the loop 			
				while ($my_recBlogPosts_query->have_posts()) 
				{ 	
					$my_recBlogPosts_query->the_post();
				?>
					<div <?php post_class('blog_post clearfix'); ?> id="post-<?php the_ID(); ?>">
						<h5><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'wpShop'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h5>
						<?php 
						//do we have a post thumbnail uploaded?
						if((function_exists('has_post_thumbnail')) && (has_post_thumbnail()) ) { 
							$altText 	= the_title_attribute('echo=0');
						?>
							<a class="thumb_img alignright" href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf( __('Permalink to %s', 'wpShop'), the_title_attribute('echo=0') ); ?>">
								<?php the_post_thumbnail(array($post_tw, $post_th), array('class' => '', 'alt' => $altText)); ?>
							</a> 
						
						<?php	
						//no? then do we have an image attached?
						} else {
							$output = my_attachment_image(0, 'thumbnail', 'alt="' . $post->post_title . '"','return');
							if (strlen($output['img_path'])>0) {  ?>
																				
								<a class="thumb_img alignright" href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf( __('Permalink to %s', 'wpShop'), the_title_attribute('echo=0') ); ?>">
									<?php my_attachment_image(0, 'thumbnail', 'alt="' . $post->post_title . '"'); ?>
								</a> 
							<?php } 
						} ?>
						
						<div class="teaser">
							<!--<p><?php //DEPRECATED!! the_content_rss('', TRUE, '', $wordLimit);?></p>-->
							<p><?php echo NWS_excerpt($wordLimit); ?></p>
								
							<p class="read_more">
								<a href="<?php the_permalink(); ?>"><?php _e('read more','wpShop'); ?></a>
							</p>
						</div><!-- teaser -->
					</div><!-- post -->
			
				<?php
				} wp_reset_query();
			} else {
				$err_message 	= __('There\'s no Recent Posts yet in the Blog','wpShop');									
				echo "<p class='error'>$err_message</p>";
			} ?>
		</div><!--widget_content_wrap-->
		<?php
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 		= strip_tags($new_instance['title']);
		$instance['showposts'] 	= $new_instance['showposts'];
		$instance['wordLimit'] 	= $new_instance['wordLimit'];
		$instance['post_tw'] 	= $new_instance['post_tw'];
		$instance['post_th'] 	= $new_instance['post_th'];
		$instance['order'] 		= $new_instance['order'];
		return $instance;
	}
	
	function form($instance){
		
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('', 'wpShop'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'showposts' ); ?>"><?php _e('Number of Recent Products', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'showposts' ); ?>" name="<?php echo $this->get_field_name( 'showposts' ); ?>" value="<?php echo $instance['showposts']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'wordLimit' ); ?>"><?php _e('Teaser Word limit', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'wordLimit' ); ?>" name="<?php echo $this->get_field_name( 'wordLimit' ); ?>" value="<?php echo $instance['wordLimit']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'post_tw' ); ?>"><?php _e('Post Thumbnail Width', 'wpShop'); ?></label>
			<small><?php _e('If your posts use the Post Thumbnail feature, control the width here', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'post_tw' ); ?>" name="<?php echo $this->get_field_name( 'post_tw' ); ?>" value="<?php echo $instance['post_tw']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_th' ); ?>"><?php _e('Post Thumbnail Height', 'wpShop'); ?></label>
			<small><?php _e('If your posts use the Post Thumbnail feature, control the height here', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'post_th' ); ?>" name="<?php echo $this->get_field_name( 'post_th' ); ?>" value="<?php echo $instance['post_th']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Order:', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" style="width:97%;">
				<option value="ASC" <?php selected('ASC', $instance["order"]); ?>><?php _e('ASC', 'wpShop'); ?></option>
				<option value="DESC" <?php selected('DESC', $instance["order"]); ?>><?php _e('DESC', 'wpShop'); ?></option>
			</select>
		</p>
		
	<?php }
}
//TrackOrder
class TrackOrder extends WP_Widget {

	function TrackOrder() {
		$widget_ops 	= array('classname' => 'widget_trackOrder', 'description' => __( 'Allow your Customers to Track their Order', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-track-order');
		$this->WP_Widget('nws-track-order', __('NWS Track Order', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
		global $OPTION;
		
		extract($args);
		$title 		= apply_filters('widget_title', $instance['title'] );
		
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		?>
		
		<form method="post" id="trackingform" class="clearfix" action="<?php echo get_option('home'); ?>/index.php?checkOrderStatus=1">
			<label for="tid"><?php _e('Enter your Tracking ID: ','wpShop'); ?><img alt="" src="<?php bloginfo('stylesheet_directory'); ?>/images/questionmark.png" title="<?php _e('You can find the Tracking ID of your last Online Order in your Order Confirmation Email.','wpShop'); ?>" /></label><br/>
			<input type="text" value="" name="tid" id="t" class="text" />
			<input type="submit" id="tracksubmit" value="<?php _e('Find my Order','wpShop'); ?>" class="formbutton" />
		</form>
		
		<?php
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] 		= strip_tags($new_instance['title']);
		return $instance;
	}
	
	function form($instance){
		
		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Track your Order', 'wpShop'));
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		
	<?php }
}

// the ShopByCat Widget
class ShopByCat extends WP_Widget {

	function ShopByCat() {
		$widget_ops 	= array('classname' => 'shop_by_widget widget_shopbyTax widget_shopbyCat', 'description' => __( 'Display Store Categories as image thumbnails', 'wpShop') );
		$control_ops 	= array('width' => 300, 'height' => 300, 'id_base' => 'nws-shopby-categories');
		$this->WP_Widget('nws-shopby-categories', __('NWS ShopBy Categories', 'wpShop'), $widget_ops, $control_ops);
    }
	
	function widget($args, $instance){
	
		global $OPTION;
		
		extract($args);
		$title 			= apply_filters('widget_title', $instance['title'] );
		$imgPath 		= $instance['imgPath'];
		$img_file_type 	= $instance['img_file_type'];
		$thumb_width 	= $instance['thumb_width'];
		$num_img_in_row = $instance['num_img_in_row'];
		$order 			= $instance['order'];
		$catTitle 		= isset( $instance['catTitle'] ) ? $instance['catTitle'] : FALSE;
		
		# Before the widget
		echo $before_widget;

		# The title
		if ( $title )
		echo $before_title . $title . $after_title;

		# Output
		?>
	
		<div class="clearfix widget_content_wrap">
			<?php
			// are we using a Blog?
			$blog_Name 	= $OPTION['wps_blogCat'];
			if ($blog_Name != 'Select a Category') {
				$blog_ID 	= get_cat_ID( $blog_Name );
				//collect the main categories & exclude the Blog
				$mainCategories = get_terms('category', 'orderby='.$orderBy.'&order='.$order.'&parent=0&hide_empty=0&exclude='.$blog_ID);
			} else {
			//collect the main categories
			$mainCategories = get_terms('category', 'orderby='.$orderBy.'&order='.$order.'&parent=0&hide_empty=0');
			}
			
			$counter = $num_img_in_row;
			$a = 1;
			foreach ($mainCategories as $mainCategory) {
				//get the taxonomy object
				$tax_obj = get_taxonomy($taxonomy);
				
				$img_src 		= $imgPath.$mainCategory->slug.'.'.$img_file_type;
				$des_src 		= $OPTION['upload_path'].'/cache';	
				$img_file 		= mkthumb($img_src,$des_src,$thumb_width,'width');    
				$imgURL 		= get_option('siteurl').'/'.$des_src.'/'.$img_file;
				$the_a_class 	= alternating_css_class($counter,$num_img_in_row,'first');
				$the_div_class 	= 'c_box c_box'.$num_img_in_row.' '. $the_a_class;
				
				//echo '<a class="'.$the_a_class.'" href="'.get_category_link($mainCategory->term_id).'"><img src="'.$imgURL .'" alt="'.$mainCategory->name.'" /></a>';
				?>
					<div class="<?php echo $the_div_class; ?>">
						<div class="contentWrap">
							<?php if ($img_file != 'error') {?>
								<a class="<?php echo $the_a_class;?>" href="<?php echo get_category_link($mainCategory->term_id);?>">
									<img src="<?php echo $imgURL; ?>" alt="<?php echo $mainCategory->name; ?>" />
								</a>
							<?php  } else { ?>
								<p class="error">
									<?php _e('Oops! No Category Specific Image was found. Please create one, save it after the category slug and upload it inside your "uploads" folder. Make sure also that the folder\'s permissions are set to 777!','wpShop'); ?><br/>
								</p>
							<?php } ?>	
						</div><!-- contentWrap  -->
						
						<?php  if($catTitle) { ?>
							<h5 class="single_cat_title"><?php echo $mainCategory->name; ?></h5> 
						<?php  } ?>
						
					</div><!-- c_box  -->
				<?php
				$a++;
				$counter++;
			}
			
			?>
		</div><!-- widget_content_wrap -->
			
		
		<?php
		# After the widget
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance){
		$instance 					= $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['imgPath'] 		= $new_instance['imgPath'];
		$instance['img_file_type'] 	= $new_instance['img_file_type'];
		$instance['thumb_width'] 	= strip_tags($new_instance['thumb_width']);
		$instance['num_img_in_row'] = $new_instance['num_img_in_row'];
		$instance['order'] 			= $new_instance['order'];
		$instance['catTitle'] 		= $new_instance['catTitle'];
		return $instance;
	}
	
	function form($instance){
		// Set up some default widget settings.
		$defaults = array( 'title' => __('Shop by', 'wpShop'), 'imgPath' => 'http://www.your-site/wp-content/uploads/', 'thumb_width' => '112', 'num_img_in_row' => '3', 'order' => 'ASC','catTitle' => FALSE,);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'imgPath' ); ?>"><?php _e('Image File Path:', 'wpShop'); ?></label><br/>
			<small><?php _e('The folder path to wherever you saved your image. Remember to end with a /', 'wpShop'); ?></small>
			<input id="<?php echo $this->get_field_id( 'imgPath' ); ?>" name="<?php echo $this->get_field_name( 'imgPath' ); ?>" value="<?php echo $instance['imgPath']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'img_file_type' ); ?>"><?php _e('Image File Type', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'img_file_type' ); ?>" name="<?php echo $this->get_field_name( 'img_file_type' ); ?>" class="widefat" style="width:97%;">
				<option value="jpg" <?php selected('jpg', $instance["img_file_type"]); ?>><?php _e('jpg', 'wpShop'); ?></option>
				<option value="png" <?php selected('png', $instance["img_file_type"]); ?>><?php _e('png', 'wpShop'); ?></option>
				<option value="gif" <?php selected('gif', $instance["img_file_type"]); ?>><?php _e('gif', 'wpShop'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'thumb_width' ); ?>"><?php _e('Resize Thumb to this Width:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'thumb_width' ); ?>" name="<?php echo $this->get_field_name( 'thumb_width' ); ?>" value="<?php echo $instance['thumb_width']; ?>" style="width:97%;" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>"><?php _e('Number of images per row:', 'wpShop'); ?></label>
			<input id="<?php echo $this->get_field_id( 'num_img_in_row' ); ?>" name="<?php echo $this->get_field_name( 'num_img_in_row' ); ?>" value="<?php echo $instance['num_img_in_row']; ?>" style="width:97%;" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e('Order:', 'wpShop'); ?></label>
			<select id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>" class="widefat" style="width:97%;">
				<option value="ASC" <?php selected('ASC', $instance["order"]); ?>><?php _e('ASC', 'wpShop'); ?></option>
				<option value="DESC" <?php selected('DESC', $instance["order"]); ?>><?php _e('DESC', 'wpShop'); ?></option>
				<option value="Random" <?php selected('Random', $instance["order"]); ?>><?php _e('Random', 'wpShop'); ?></option>
			</select>
		</p>
		
		<p style="background:#F1F1F1;">
			<strong><?php _e('Optional', 'wpShop'); ?></strong><br/>
			<input class="checkbox" type="checkbox" <?php checked( (bool) $instance['catTitle'], true ); ?> id="<?php echo $this->get_field_id( 'catTitle' ); ?>" name="<?php echo $this->get_field_name( 'catTitle' ); ?>" /> 
			<label for="<?php echo $this->get_field_id( 'catTitle' ); ?>"><?php _e('Display Category Title', 'wpShop'); ?></label>
		</p>
	<?php }
}


function TheFurnitureStoreWidgets() {
	register_widget('CategoryRssListWidget');
	register_widget('StoreCategoriesWidget');
	register_widget('PagesListWidget');
	//register_widget('GiftCardsWidget');
	register_widget('EmailSubscriptionsWidget');
	register_widget('PromotionsWidget');
	register_widget('Promotions2LinksWidget');
	register_widget('Promotions3LinksWidget');
	register_widget('ContactWidget');
	register_widget('ShopByAllPurposeWidget');
	register_widget('ShopByOutfitWidget');
	register_widget('ShopByFitWidget');
	register_widget('ShopBySizeWidget');
	register_widget('ShopByColourWidget');
	register_widget('ShopByBrandWidget');
	register_widget('ShopBySelectionWidget');
	register_widget('ShopByStyleWidget');
	register_widget('ShopByPriceWidget');
	register_widget('FAQs');
	register_widget('RecentProds');
	register_widget('RecentBlogPosts');
	register_widget('TrackOrder');
	register_widget('ShopByCat');
}
add_action('widgets_init', 'TheFurnitureStoreWidgets');

load_theme_textdomain('wpShop', get_template_directory().'/languages/');
?>