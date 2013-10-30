<?php
##################################################################################################################################
// 	                                          common sense security precautions
##################################################################################################################################
//hide login errors
add_filter('login_errors',create_function('$a', "return null;"));

//hide wordpress version
add_filter( 'the_generator', create_function('$a', "return null;") );

##################################################################################################################################
/**  
 * SEO Optimization  
 */
##################################################################################################################################

/**  
 * SEO Optimization  
 *
 * Adds additional form fields on the "edit" category, tag, term forms
 */
function NWS_custom_cat_meta( $tag ) {

	//check for existing term title
	$cat_term_hTitle = get_option( 'term_hTitle' );
	
	$term_hTitle = '';
	if ( is_array( $cat_term_hTitle ) && array_key_exists( $tag->term_id, $cat_term_hTitle ) ) {
		$term_hTitle = $cat_term_hTitle[$tag->term_id];
		$term_hTitle = stripslashes($term_hTitle);	
	}
	
	//check for existing term keywords
	$cat_term_keywords = get_option( 'term_keywords' );
	
	$term_keywords = '';
	if ( is_array( $cat_term_keywords ) && array_key_exists( $tag->term_id, $cat_term_keywords ) ) {
		$term_keywords = $cat_term_keywords[$tag->term_id];
		$term_keywords = stripslashes($term_keywords);	
	}	
	
	//check for existing term keywords
	$cat_term_description = get_option( 'term_description' );
	
	$term_description = '';
	if ( is_array( $cat_term_description ) && array_key_exists( $tag->term_id, $cat_term_description ) ) {
		$term_description = $cat_term_description[$tag->term_id];
		$term_description = stripslashes($term_description);	
	}
?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="term_hTitle"><?php _e('SEO Header Title','wpShop') ?></label></th>
        <td>
        	<input type="text" name="term_hTitle" id="term_hTitle" size="40" style="width:95%;" value="<?php echo $term_hTitle; ?>"><br />
            <span class="description"><?php _e('For SEO Optimized Header Titles. Enter your Keywords using a "|" as separator','wpShop') ?></span>
        </td>
    </tr>
	
	<tr class="form-field">
        <th scope="row" valign="top"><label for="term_keywords"><?php _e('SEO Keywords','wpShop') ?></label></th>
        <td>
        	<textarea style="width: 97%;" cols="50" rows="5" id="term_keywords" name="term_keywords"><?php echo $term_keywords; ?></textarea><br />
            <span class="description"><?php _e('For SEO Optimized Meta Keywords. Enter your Keywords using a "," as separator','wpShop') ?></span>
        </td>
    </tr>
	
	<tr class="form-field">
        <th scope="row" valign="top"><label for="term_description"><?php _e('SEO Description','wpShop') ?></label></th>
        <td>
        	<textarea style="width: 97%;" cols="50" rows="5" id="term_description" name="term_description"><?php echo $term_description; ?></textarea><br />
            <span class="description"><?php _e('For SEO Optimized Meta Description.','wpShop') ?></span>
        </td>
    </tr>
<?php
}

/**  
 * SEO Optimization  
 *
 * Save data in options table
 */
function NWS_save_custom_cat_meta( $term_id ) {
	// term titles
	if ( isset( $_POST['term_hTitle'] ) ) {

		//load existing category term_hTitle
		$current_term_hTitle = get_option( 'term_hTitle' );

		//set term_hTitle to proper category ID in options array
		$current_term_hTitle[$term_id] = (string)($_POST['term_hTitle']);

		//save the option array
		update_option( 'term_hTitle', $current_term_hTitle );
	}
	
	//term keywords
	if ( isset( $_POST['term_keywords'] ) ) {

		//load existing category term_keywords
		$current_term_keywords = get_option( 'term_keywords' );

		//set term_keywords to proper category ID in options array
		$current_term_keywords[$term_id] = (string)($_POST['term_keywords']);

		//save the option array
		update_option( 'term_keywords', $current_term_keywords );
	}
	
	//term description
	if ( isset( $_POST['term_description'] ) ) {

		//load existing category term_description
		$current_term_description = get_option( 'term_description' );

		//set term_description to proper category ID in options array
		$current_term_description[$term_id] = (string)($_POST['term_description']);

		//save the option array
		update_option( 'term_description', $current_term_description );
	}
}

/**  
 * SEO Optimization  
 *
 * Delete data when category, tag, term is deleted
 */
function NWS_delete_custom_cat_meta( $term_id ) {
    
	// title
		//load existing category term_hTitle
		$current_term_hTitle = get_option('term_hTitle');

		//if there is a term_hTitle for a deleted category ID in options array		
		if ( $current_term_hTitle[$term_id] ) {
			//remove this reference
			unset( $current_term_hTitle[$term_id] );
		   
		   //has the category been deleted?, delete the option
			if ( empty( $current_term_hTitle ) ) {
				delete_option( 'term_hTitle' );
		   
		   //else update it 
			} else {
				update_option( 'term_hTitle', $current_term_hTitle );
			}
		}
	
	//keywords
		//load existing category term_keywords
		$current_term_keywords = get_option( 'term_keywords' );
	
		//if there is a term_keywords for a deleted category ID in options array		
		if ( $current_term_keywords[$term_id] ) {
			//remove this reference
			unset( $current_term_keywords[$term_id] );
		   
		   //has the category been deleted?, delete the option
			if ( empty( $current_term_keywords ) ) {
				delete_option( 'term_keywords' );
		   
		   //else update it 
			} else {
				update_option( 'term_keywords', $current_term_keywords);
			}
		}
	
	//description
		//load existing category term_description
		$current_term_description = get_option( 'term_description' );
	
		//if there is a term_description for a deleted category ID in options array		
		if ( $current_term_description[$term_id] ) {
			//remove this reference
			unset( $current_term_description[$term_id] );
		   
		   //has the category been deleted?, delete the option
			if ( empty( $current_term_description ) ) {
				delete_option( 'term_description' );
		   
		   //else update it 
			} else {
				update_option( 'term_description', $current_term_description);
			}
		}
}

/**  
 * SEO Optimization  
 *
 * Prepends the new columns to the columns array
 * @ return array
 */
function NWSseo_columns($cols) {
	$cols['seo-title'] 			= __('SEO Header Title','wpShop');
	$cols['seo-keywords'] 		= __('SEO Keywords','wpShop');
	$cols['seo-description'] 	= __('SEO Description','wpShop');
	return $cols;
}

/**  
 * SEO Optimization  
 *
 * Gets the value for each column
 * @ return string
 */
function NWSseo_entry_return_value($value, $column_name, $tag) {
	
	if ($column_name == 'seo-title') {
	
		//this is for the SEO Optimized category titles
		$current_term_hTitle = get_option( 'term_hTitle' );
		
		if ( is_array( $current_term_hTitle ) && array_key_exists( $tag, $current_term_hTitle ) ) {
			$value = $current_term_hTitle[$tag];
			$value = stripslashes($value);
		}
	}
	
	if ($column_name == 'seo-keywords') {
	
		//this is for the SEO Optimized category keywords
		$current_term_keywords = get_option( 'term_keywords' );
		
		if ( is_array( $current_term_keywords ) && array_key_exists( $tag, $current_term_keywords ) ) {
			$value = $current_term_keywords[$tag];
			$value = stripslashes($value);
		}
	}
	
	if ($column_name == 'seo-description') {
	
		//this is for the SEO Optimized category description
		$current_term_description = get_option( 'term_description' );
		
		if ( is_array( $current_term_description ) && array_key_exists( $tag, $current_term_description ) ) {
			$value = $current_term_description[$tag];
			$value = stripslashes($value);
		}
	}
	
	return $value;
}

/**  
 * SEO Optimization  
 *
 * The function we will hook on the "admin_init" hook below
 */
//add all admin actions in 1 call
function NWScustom_add() {
	//get all registered taxonomies
	$taxonomies = get_taxonomies();
	// filter categories, post tags and custom taxonomies and return those only
	foreach($taxonomies as $k =>$v) {
		if($v == 'nav_menu' || $v == 'link_category') {
			unset($taxonomies[$k]);
		}
	}
	
	//this returns all registered taxonomies
	foreach ( $taxonomies as $taxonomy ) {
		add_action($taxonomy . '_edit_form_fields', 'NWS_custom_cat_meta', $taxonomy);
		add_action("edited_$taxonomy", 'NWS_save_custom_cat_meta');
		add_action("delete_$taxonomy", 'NWS_delete_custom_cat_meta');
		add_action("manage_edit-${taxonomy}_columns", 'NWSseo_columns');			
		add_filter("manage_${taxonomy}_custom_column", 'NWSseo_entry_return_value', 10, 3);
	}
}

// add the hook
add_action('admin_init', 'NWScustom_add');


##################################################################################################################################
// 	                                              Loading JS the right way
##################################################################################################################################
add_action('get_header', 'NWS_queue_js');

function NWS_queue_js(){
	
	global $OPTION;
	
	$DEFAULT = show_default_view();

	if (!is_admin()){
		if(($_SERVER['HTTPS'] == 'on')||($_SERVER['HTTPS'] == '1') || ($_SERVER['SSL'] == '1')){
			$siteurl = NWS_bloginfo('template_directory');
			//jQuery Tools breaks with 1.5!
			// wp_enqueue_script( 'jquery-1.5.min',$siteurl.'/js/jquery-1.5.min.js', '1.5', true );
			// wp_enqueue_script( 'jquery-1.4.4.min',$siteurl.'/js/jquery-1.4.4.min.js', '1.4.4', true );
			wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js?ver=1.7.4"), false, '1.7.2');  
			wp_enqueue_script( 'jquery' );
			// https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js
		
			// do we want a customer area with a wishlist?			
			if($OPTION['wps_lrw_yes']) {
				wp_enqueue_script( 'check-email-ajax', $siteurl.'/js/check-email-ajax.js', array('jquery'), '1', true );
				wp_enqueue_script( 'check-user-ajax',$siteurl.'/js/check-user-ajax.js', array('jquery'), '1', true );
			}
			
			//display only on checkout
			if(!$DEFAULT){ 
				wp_enqueue_script( 'check-voucher-ajax', $siteurl.'/js/check-voucher-ajax.js', array('jquery'), '1', true );
				wp_enqueue_script( 'get_form_bAddress', $siteurl.'/js/get_form_bAddress.js', array('jquery'), '1', true );
				wp_enqueue_script( 'get_form_dAddress', $siteurl.'/js/get_form_dAddress.js', array('jquery'), '1', true ); 
			}
		
		} else {
			wp_deregister_script('jquery'); 
			//jQuery Tools breaks with 1.5!
			//wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"), false, '1.5'); 
			// wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js?ver=1.4.4"), false, '1.4.4');  
			wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js?ver=1.7.4"), false, '1.7.2');  
			
			wp_enqueue_script('jquery');
			
			if ( is_singular() AND comments_open() AND ($OPTION['thread_comments'] == 1)) {
			  wp_enqueue_script( 'comment-reply' );
			}
			
			// do we want the eCommerce engine?
			if($OPTION['wps_shoppingCartEngine_yes']) {
			
				//load only on product single page
				if (is_single()) {
					$WPS_prodImg_effect	= $OPTION['wps_prodImg_effect'];
					// are we using a Blog?
					$blog_Name 	= $OPTION['wps_blogCat'];
					
					if ($blog_Name != 'Select a Category') {
						
						$blog_ID 	= get_cat_ID( $blog_Name );
						// who's our ancestor, blog or shop?
						if (!(cat_is_ancestor_of( $blog_ID, (int)$category[0]->term_id )) || ($category[0]->term_id != $blog_ID)) {
							
							wp_enqueue_script( 'price', get_template_directory_uri().'/js/price.js', array('jquery'), '1', true );
							wp_enqueue_script( 'ajax_check_stock', get_template_directory_uri().'/js/ajax_check_stock.js', array('jquery'), '1', true );
							
						
						} else {}
						
					} else {
					
						wp_enqueue_script( 'price', get_template_directory_uri().'/js/price.js', array('jquery'), '1', true );
						wp_enqueue_script( 'ajax_check_stock', get_template_directory_uri().'/js/ajax_check_stock.js', array('jquery'), '1', true );
						
					}
				}
				//display only on checkout
				if(!$DEFAULT){ 
					wp_enqueue_script( 'check-voucher-ajax', get_template_directory_uri().'/js/check-voucher-ajax.js', array('jquery'), '1', true );
					wp_enqueue_script( 'get_form_bAddress', get_template_directory_uri().'/js/get_form_bAddress.js', array('jquery'), '1', true ); 
					wp_enqueue_script( 'get_form_dAddress', get_template_directory_uri().'/js/get_form_dAddress.js', array('jquery'), '1', true );
				}			
			}
			
			// do we want a customer area with a wishlist?			
			if($OPTION['wps_lrw_yes']) {
				wp_enqueue_script( 'check-email-ajax', get_template_directory_uri().'/js/check-email-ajax.js', array('jquery'), '1', true );
				wp_enqueue_script( 'check-user-ajax', get_template_directory_uri().'/js/check-user-ajax.js', array('jquery'), '1', true );
			}
		}
	}
}

##################################################################################################################################
// 	Some good functions from Theme Shaper (http://themeshaper.com/wordpress-themes-templates-tutorial/)
##################################################################################################################################
// Get the page number
function get_page_number() {
    if (get_query_var('paged')) {
        print ' | ' . __( 'Page ' , 'wpShop') . get_query_var('paged');
    }
} 

// For category lists on category archives: Returns other categories except the current one (redundant)
function cats_meow($glue) {
        $current_cat = single_cat_title( '', false );
        $separator = "\n";
        $cats = explode( $separator, get_the_category_list($separator) );
        foreach ( $cats as $i => $str ) {
                if ( strstr( $str, ">$current_cat<" ) ) {
                        unset($cats[$i]);
                        break;
                }
        }
        if ( empty($cats) )
                return false;

        return trim(join( $glue, $cats ));
}

// For tag lists on tag archives: Returns other tags except the current one (redundant)
function tag_ur_it($glue) {
	$current_tag = single_tag_title( '', '',  false );
	$separator = "\n";
	$tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
	foreach ( $tags as $i => $str ) {
		if ( strstr( $str, ">$current_tag<" ) ) {
			unset($tags[$i]);
			break;
		}
	}
	if ( empty($tags) )
		return false;
 
	return trim(join( $glue, $tags ));
}

//check to see if a particular custom page template is active
function is_pagetemplate_active($pagetemplate = '') {
	global $wpdb;
	$sql = "select meta_key from $wpdb->postmeta where meta_key like '_wp_page_template' and meta_value like '" . $pagetemplate . "'";

	$result = $wpdb->query($sql);

	if ($result) {
		return TRUE;
	} else {
		return FALSE;
	}
}

// Excerpt or Content Word Limit in WordPress: Redux
// src: http://bavotasan.com/tutorials/limiting-the-number-of-words-in-your-excerpt-or-content-in-wordpress/

function NWS_excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
 
function NWS_content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}
##################################################################################################################################
// 	                                             The Comments Template
##################################################################################################################################
//comments
function mytheme_comment($comment, $args, $depth) {

$noAvatarPath = get_bloginfo('stylesheet_directory').'/images/noAvatar.jpg';

   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" class="clearfix">
			<div class="who_when">
				<div class="comment-author vcard">
					<?php echo get_avatar($comment,$size='80',$default = $noAvatarPath ); ?>
					<?php printf(__('<cite class="fn">%s</cite>','wpShop'), get_comment_author_link()) ?>
				</div>
				<div class="comment-meta commentmetadata">
					<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
						<?php printf(__('%1$s at %2$s','wpShop'), get_comment_date(),  get_comment_time()) ?>
					</a>
				</div>
			</div>
			
			<div class="what">
				<?php if ($comment->comment_approved == '0') : ?>
					<em><?php _e('Your comment is awaiting moderation.', 'wpShop') ?></em>
					<br />
				<?php endif; ?>	
				<?php comment_text() ?>
				<div class="reply">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
			</div>
		</div>
<?php
}

function list_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment;
?>
        <li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }

add_filter('get_comments_number', 'comment_count', 0);
function comment_count( $count ) {
        if ( ! is_admin() ) {
                global $id;
                $get_comments= get_comments('post_id=' . $id);
				$comments_by_type = &separate_comments($get_comments);
                return count($comments_by_type['comment']);
        } else {
                return $count;
        }
}


//stop comment spam!
function check_referrer() {
    if (!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == “”) {
        wp_die( __('Please enable referrers in your browser, or, if you\'re a spammer, bugger off!','wpShop') );
    }
}

add_action('check_comment_flood', 'check_referrer');

##################################################################################################################################
// 												VARIOUS FUNCTIONS :-) 
##################################################################################################################################
// SN
/**
 * Returns the url path to the uploads folder
 * e.g. [baseurl] => http://example.com/wp-content/uploads 
 *
 */
function nws_uploads_url(){
	$uploads = wp_upload_dir();
	$output = $uploads['baseurl'];
	
return $output;
}

/**
 * Returns the path to the uploads folder
 * e.g. [basedir] => C:\path\to\wordpress\wp-content\uploads 
 *
 */
function nws_uploads_dir(){
	$uploads = wp_upload_dir();
	$output = $uploads['basedir'];
	
return $output;
}
//\ SN

//Add excerpt box to page editor: http://justintadlock.com/archives/2009/11/09/excerpts-and-taxonomies-for-pages-in-wordpress-2-9
add_action( 'admin_menu', 'NWS_page_excerpt_meta_box' );

function NWS_page_excerpt_meta_box() {
	add_meta_box( 'postexcerpt', __('Excerpt'), 'post_excerpt_meta_box', 'page', 'normal', 'core' );
}

// Enable support for post-thumbnails
if ( function_exists('add_theme_support') ) {
	add_theme_support('post-thumbnails');
}

function get_childtheme(){

	global $wpdb;
	
	$table = $wpdb->prefix . 'options';
	
	$qStr 		= "SELECT option_value FROM $table WHERE option_name = 'stylesheet' LIMIT 0,1";
	$res 		= mysql_query($qStr);	
	$row 		= mysql_fetch_assoc($res);
	$childTh	= $row['option_value'];	

return $childTh;
}

if(!is_admin()){
	//filter search results - exclude categories from being searched.
	function SearchFilter($query) {
		global $OPTION;
		if ($query->is_search) {
			//exclude all pages
			$query->set('post_type', 'post');
			
			$exclude = $OPTION['wps_search_excl'];
			$query->set('cat',$exclude);
		}
	return $query;
	}

	add_filter('pre_get_posts','SearchFilter');
}


//Short Post URLs source: http://dancameron.org/code/short-post-urls
add_action( 'generate_rewrite_rules', 'custom_rewrite_rules' );
function custom_rewrite_rules( $wp_rewrite ){
	$newRules = array();
	// Defualt http://siteurl.com/s/1 ( '1' being the post id )
	$newRules[ 's/([0-9]+)$' ] = 'index.php?p=' . $wp_rewrite->preg_index( 1 );
	// Another example below http://siteurl.com/1
	// $newRules[ '([0-9]+)$' ] = 'index.php?p=' . $wp_rewrite->preg_index( 1 );
	$wp_rewrite->rules = $newRules + $wp_rewrite->rules;
	
	return $wp_rewrite;
}

// hide "no categories"
function NWS_no_cats_hide($content) {
  if (!empty($content)) {
    $content = str_ireplace('<li>' .__( "No categories" ). '</li>', "", $content);
  }
  return $content;
}
add_filter('wp_list_categories','NWS_no_cats_hide');


// enable full HTML on tag and custom taxonomy descriptions
remove_filter( 'pre_term_description', 'wp_filter_kses' );
remove_filter( 'term_description', 'wp_kses_data' );

//custom fields of current post
function get_custom_field($key, $echo = FALSE) {
	global $post;
	
	$custom_field = get_post_meta($post->ID, $key, true);
	if($echo == FALSE){ 
		return $custom_field; 
	} else {
		echo $custom_field;
	}
}

//custom fields of any post 
function get_custom_field2($post_id, $key, $echo = FALSE) {
	global $post;
	
	$custom_field = get_post_meta($post_id, $key, true);
	if($echo == FALSE){ 
		return $custom_field; 
	} else {
		echo $custom_field;
	}
}

//check to see if any category has a single.php asigned to it and use that over the other
add_filter('single_template', create_function('$t', 'foreach( (array) get_the_category() as $cat ) { if ( file_exists(TEMPLATEPATH . "/single-{$cat->term_id}.php") ) return TEMPLATEPATH . "/single-{$cat->term_id}.php"; } return $t;' ));


//  give every  xyz  css class a different value 
function alternating_css_class($counter,$number,$css_class_string){

	if(($counter % $number) == 0){
		$the_div_class = $css_class_string;
	}
	else {
		$the_div_class = NULL;
	}
return $the_div_class; 
}

function insert_clearfix($counter,$number,$clearing_element){
	$counter++;
	
	if((($counter % $number) == 0)&&($number < $counter)){
		$clear_output = $clearing_element;
	}
	else {
		$clear_output = NULL;
	}
return $clear_output; 
}

// conditional if page belongs in the tree
function is_tree($pid) {    // $pid = The page we're looking for pages underneath
	global $post;       // We load this as we're outside of the post
	 
	if(is_page()&&($post->post_parent==$pid || is_page($pid) || $post->ancestors[0]==$pid || $post->ancestors[1]==$pid)) {
		return true; // Yes, it's in the tree
	}	
	else {
		return false;  // No, it's outside
	}
}


// get the category slug when given an ID
function get_cat_slug($cat_id) {
	$cat_id = (int) $cat_id;
	$category = &get_category($cat_id);
	return $category->slug;
}


// get the cat_ID of the parent category
function get_parent_cat_id()
{
		foreach (get_the_category() as $cat) {
		  $parent 		= get_category($cat->category_parent);  
		  $parent_ID	= $parent->cat_ID;
		}

return $parent_ID;
}

// Get the slug, name, term_id or allData of the Root Category. This will check parents, grandparents, etc.. All the way up!
function NWS_get_root_category($cat,$option='slug'){

	$result = NULL;
	
		$parentCatList 		= get_category_parents($cat,false,',');	
		$parentCatListArray = split(",",$parentCatList);
		$topParentName 		= $parentCatListArray[0];
		$topParentID 		= get_cat_ID( $topParentName );
		$topParent 			= get_category( $topParentID );
		$topParentSlug      = $topParent->slug;
		
		if($option == 'name'){
			$result = $topParentName;
		}elseif($option == 'term_id'){
			$result = $topParentID;
		}elseif($option == 'allData'){
			$result = $topParent;
		}else{
			$result = $topParentSlug;
		}
	
return $result;	
}


// find the top category parent when on a single post and return it's ID when found
function get_post_top_parent(){
		
		$this_category  = get_category(get_parent_cat_id());
		
		#var_dump($this_category);
		
		
		$parent_cat 	= $this_category->category_parent;	
		//when first level category  return it's ID
		if($parent_cat == NULL){
			$catsy 		= get_the_category();
			$parent_cat = $catsy[0]->cat_ID;
		}
return $parent_cat;
}

//http://www.devdevote.com/wordpress/functions/get_depth/
function get_depth($id = '', $depth = '', $i = 0) {
	global $wpdb;

	if($depth == '') {
		
		if(is_category()) {

			if($id == '') {
				global $cat;
				$id = $cat;
			}
			$depth = $wpdb->get_var("SELECT parent FROM $wpdb->term_taxonomy WHERE term_id = '".$id."'");
			return get_depth($id, $depth, $i);
		}
		elseif(is_single()) {
			if($id == '') {
				$category = get_the_category();
				$id = $category[0]->cat_ID;
			}
			$depth = $wpdb->get_var("SELECT parent FROM $wpdb->term_taxonomy WHERE term_id = '".$id."'");
			return get_depth($id, $depth, $i);
		}
	}
	elseif($depth == '0') {
		return $i;
	}
	elseif(is_single() || is_category()) {
		$depth = $wpdb->get_var("SELECT parent FROM $wpdb->term_taxonomy WHERE term_id = '".$depth."'");
		$i++;
		return get_depth($id, $depth, $i);
	}
}

// get any category id by it's slug
if (!function_exists('any_cat')) {
	function any_cat($cat = 'some-category'){
	
	global $wpdb;
	
	$query 				= " SELECT 
						    * 
						   FROM 
						    $wpdb->terms 
						   WHERE 
						    slug = '$cat' 
						   LIMIT 0 , 1";

	$result    			= mysql_query($query);
	$row    			= mysql_fetch_assoc($result);
	$id_any_cat  		= $row[term_id];

	return $id_any_cat;
	}
}

// get the e.g. shop cat id 
if(!function_exists('shop_cat')) {
	function shop_cat($cat = 'shop'){
	
	global $wpdb;
	
	$query 				= " SELECT 
						    * 
						   FROM 
						    $wpdb->terms 
						   WHERE 
						    slug = '$cat' 
						   LIMIT 0 , 1";

	$result    			= mysql_query($query);
	$row    			= mysql_fetch_assoc($result);
	$id_shop_cat  	= $row[term_id];

	return $id_shop_cat;
	}
}



// get the featured category id
if (!function_exists('featured_cat')) {
	function featured_cat($cat = 'gallery'){
	
	global $wpdb;
	
	$query 				= " SELECT 
						    * 
						   FROM 
						    $wpdb->terms 
						   WHERE 
						    slug = '$cat' 
						   LIMIT 0 , 1";

	$result    			= mysql_query($query);
	$row    			= mysql_fetch_assoc($result);
	$id_featured_cat  	= $row[term_id];

	return $id_featured_cat;
	}
}

// blog category related posts
function NWS_blogCat_related_posts($showposts){
	global $post;
	// prepare the query
	$categories 	= get_the_category($post->ID);
	$category_ids 	= array();
	foreach($categories as $individual_category){
		$category_ids[] = $individual_category->term_id;
	}
		
	$param		= array(
		'category__in' 		=> $category_ids,
		'post__not_in' 		=> array($post->ID),
		'posts_per_page'	=> $showposts, 		// SN 
		'caller_get_posts'	=> 1
	);
		
	// query	
	$my_catRelated_query = new wp_query($param); 		
		
	// run the loop 	
	if($my_catRelated_query->have_posts()) 
	{ 			
		$result 		= array();
		$result['status'] = TRUE;
		$result['html'] 	= NULL;
		
		while ($my_catRelated_query->have_posts()) 
		{ 	
			$my_catRelated_query->the_post(); 
			$permalink 		= get_permalink();
			$title_attr		= str_replace("%s",the_title_attribute('echo=0'), __('Permalink to %s', 'wpShop'));
			$title			= get_the_title();
			$result['html']	.= "<li><a href='$permalink' title='$title_attr'>$title</a></li> ";
		} wp_reset_query();
	}
	else {$result['status'] = FALSE;}
return $result;
}

// Tag related posts
function NWS_blogTag_related_posts($showposts,$option = 1){ 

	global $wpdb, $post;

	$tags = wp_get_post_tags($post->ID);
	
	if ($tags) {
		$tag_ids = array();
		foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;

		$args = array(
			'tag__in' 			=> $tag_ids,
			'post__not_in' 		=> array($post->ID),
			'posts_per_page'	=> $showposts, 		// SN 
			'caller_get_posts'	=> 1
		);
		
		// query	
		$my_tagRelated_query = new wp_query($args); 		
			
		// run the loop 	
		if($my_tagRelated_query->have_posts()) 
		{ 			
			$result 		= array();
			$result['status'] = TRUE;
			$result['html'] 	= NULL;
			
			while ($my_tagRelated_query->have_posts()) 
			{ 	
				$my_tagRelated_query->the_post(); 
				$permalink 		= get_permalink();
				$title_attr		= str_replace("%s",the_title_attribute('echo=0'), __('Permalink to %s', 'wpShop'));
				$title			= get_the_title();
				$result['html']	.= "<li><a href='$permalink' title='$title_attr'>$title</a></li> ";
			} wp_reset_query();
		}
		else {$result['status'] = FALSE;}
		
	return $result;
	}

}

// SN 
// category related posts
function NWS_cat_related_posts($showposts,$order_by,$order,$resizedImg_src='cache',$img_width=81){

	global $post,$OPTION;
	
	// prepare the query
	$categories 	= get_the_category($post->ID);
	$category_ids 	= array();
	foreach($categories as $individual_category){
			$category_ids[] = $individual_category->term_id;
	}
		
		$param		= array(
			'category__in' 		=> $category_ids,
			'post__not_in' 		=> array($post->ID),
			'posts_per_page'	=> $showposts, // SN 
			'orderby' 			=> $order_by,
			'order' 			=> $order,
			'caller_get_posts'	=> 1
		);
		
	// query	
	$my_catRelated_query = new wp_query($param); 		
		
	// run the loop 	
	if($my_catRelated_query->have_posts()) 
	{ 			
		$result 			= array();
		$result['status'] 	= TRUE;
		$result['html'] 	= NULL;
		
		$prod_title = $OPTION['wps_related_prod_title'];
		$prod_price = $OPTION['wps_related_prod_price'];
		$prod_btn 	= $OPTION['wps_related_prod_btn'];
		
		while ($my_catRelated_query->have_posts()) 
		{ 	
			$my_catRelated_query->the_post(); 
			
			// SN 
			$imgs_to_exclude 	= get_custom_field('imgs_to_exclude', FALSE);
			$output 			= my_attachment_images(0, 2, $imgs_to_exclude);
			//\ SN 
			$imgNum 		= count($output);
			
			//do we have 1 attached image?
			if($imgNum != 0){
				$imgURL		= array();
				// SN 
				foreach($output as $v){
					$img_src 	= $v;
					
					// do we want the WordPress Generated thumbs?
					if ($OPTION['wps_wp_thumb']) {
						//get the file type
						$img_file_type = strrchr($img_src, '.');
						//get the image name without the file type
						$parts = explode($img_file_type,$img_src);
						// get the thumbnail dimensions
						$width = get_option('thumbnail_size_w');
						$height = get_option('thumbnail_size_h');
						//put everything together
						$imgURL[] = $parts[0].'-'.$width.'x'.$height.$img_file_type;
					
					// no? then display the default proportionally resized thumbnails
					} else {
						$des_src 	= $OPTION['upload_path'] . '/' . $resizedImg_src;							
						$img_file 	= mkthumb($img_src,$des_src,$img_width,'width');    
						$imgURL[] 	= nws_uploads_url() . '/' . $resizedImg_src . '/' . $img_file;
					}
				}
				//\ SN
			// no attachments? pull image from custom field
			} elseif(strlen(get_custom_field('image_thumb', FALSE))>0) {
				// SN 
				$img_src 	= get_custom_field('image_thumb', FALSE);
				
				// do we want the WordPress Generated thumbs?
				if ($OPTION['wps_wp_thumb']) {
					//get the file type
					$img_file_type = strrchr($img_src  , '.');
					//get the image name without the file type
					$parts = explode($img_file_type,$img_src);
					// get the thumbnail dimensions
					$width = get_option('thumbnail_size_w');
					$height = get_option('thumbnail_size_h');
					//put everything together
					$imgURL = $parts[0].'-'.$width.'x'.$height.$img_file_type;
				
				} else {
					$des_src 	= $OPTION['upload_path'] . '/' . $resizedImg_src;	
					$img_file 	= mkthumb($img_src,$des_src,$img_width,'width');
					$imgURL 	= nws_uploads_url() . '/' . $resizedImg_src . '/' . $img_file;	
				}
				//\ SN
			}	
			
			// put output together
			
			$permalink 		= get_permalink();
			$title_attr2	= the_title_attribute('echo=0');
			$title_attr		= str_replace("%s",the_title_attribute('echo=0'), __('Permalink to %s', 'wpShop'));
			
			$contWrapWidth	= $OPTION['wps_wp_thumb'] ? get_option('thumbnail_size_w') : $img_width;
			
			$result['html'] .= " <div class='contentWrap related_prod_wrap' style='width:{$contWrapWidth}px'>";
				// for attached images
				if($imgNum != 0){
					if(($imgNum == 1) || ($OPTION['wps_hover_remove_option'])){ 
						$result['html']	.= "<a href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL[0]' alt='$title_attr2'/></a>"; 
					} else { 
						$result['html']	.= "
						<a href='$permalink' class='hover_link' rel='bookmark' title='$title_attr'><img src='$imgURL[0]' alt='$title_attr2'/></a>
						<a href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL[1]' alt='$title_attr2'/></a>
						"; 
					}

				// for  image from custom field
				} elseif(strlen(get_custom_field('image_thumb', FALSE))>0) { 
					$result['html']	.= "
						<a href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL' alt='$title_attr2'/></a>";
					
				} else { 									
					$err_message 	= __('Oops! No image found.','wpShop');									
					$result['html'] .= "<a href='$permalink' rel='bookmark' title='$title_attr'>$err_message</a>";
				}
				if($prod_title || $prod_price || $prod_btn){ 
					$result['html'] .= "<div class='teaser'>";
						if($prod_title){
							$result['html'] .= "<h5 class='related_prod_title'><a href='$permalink' title='$title_attr' rel='bookmark'>$title_attr2</a></h5>";
						}	
						if($prod_price && strlen(get_custom_field('price', FALSE))>0){
							$result['html'] .= "<p class='price_value'>";
								if(strlen(get_custom_field('new_price', FALSE))>0){
																	
									$result['html'] .= "<span class='was price'>";
										if($OPTION['wps_currency_symbol'] !='') { $result['html'] .= $OPTION['wps_currency_symbol'];} $result['html'] .= format_price(get_custom_field('old_price'));
									$result['html'] .= "</span>
									<span class='is price'>";
										if($attr_option == 2){$result['html'] .= __('From: ','wpShop');} 
											if($OPTION['wps_currency_symbol'] !='') { $result['html'] .= $OPTION['wps_currency_symbol'];} $result['html'] .= format_price(get_custom_field('new_price')); 
											if($OPTION['wps_currency_code_enable']) { $result['html'] .= " " . $OPTION['wps_currency_code']; }
											if($OPTION['wps_currency_symbol_alt'] !='') { $result['html'] .= " " . $OPTION['wps_currency_symbol_alt']; }
									$result['html'] .= "</span>";
																
								} elseif(strlen(get_custom_field('price', FALSE))>0){
																
									$result['html'] .= "<span class='price solo'>";if($attr_option == 2){$result['html'] .= __('From: ','wpShop');} 
										if($OPTION['wps_currency_symbol'] !='') { $result['html'] .= $OPTION['wps_currency_symbol'];} $result['html'] .= format_price(get_custom_field('price')); 
										if($OPTION['wps_currency_code_enable']) { $result['html'] .= " " . $OPTION['wps_currency_code']; }
										if($OPTION['wps_currency_symbol_alt'] !='') { $result['html'] .= " " . $OPTION['wps_currency_symbol_alt']; }
									$result['html'] .= "</span>";
								}	
							$result['html'] .= "</p>";
						}	
						if($OPTION['wps_shoppingCartEngine_yes'] && $prod_btn && strlen(get_custom_field('disable_cart', FALSE))==0){ 
							// shop mode
							$wps_shop_mode 	= $OPTION['wps_shop_mode'];
							
							if($wps_shop_mode =='Inquiry email mode'){
								$result['html'] .= "<span class='shopform_btn add_to_enquire_alt'><a href='$permalink'>" . sprintf(__ ('Add to %s!','wpShop'), $OPTION['wps_pgNavi_inquireOption']) . "</a></span>";
							} elseif ($wps_shop_mode=='Normal shop mode' && !is_it_affiliate()){
								$result['html'] .= "<span class='shopform_btn add_to_cart_alt'><a  href='$permalink'>" . sprintf(__ ('Add to %s!','wpShop'), $OPTION['wps_pgNavi_cartOption']) . "</a></span>";
							} elseif ($wps_shop_mode=='affiliate_mode' || is_it_affiliate()){
								$result['html'] .= "<span class='shopform_btn buy_now_alt'><a href='" . get_custom_field('buy_now') . "'"; if($OPTION['wps_affili_newTab']) { $result['html'] .= "title='" . __('Opens is new tab','wpShop') . "' target='_blank'"; } $result['html'] .= ">" . __('Buy Now','wpShop') . "</a></span>";
							} else {}
						
						} 
					$result['html'] .= "</div>";
				}
			$result['html'] .= "</div>";
		} wp_reset_query();
	}
	else {$result['status'] = FALSE;}


return $result;
}
//\ SN 	

// SN 
// Tag/Custom Term related posts
function NWS_tag_related_posts($showposts,$resizedImg_src='cache',$img_width=81,$taxTerm='post_tag'){ 
	global $post,$OPTION;

	// get tags of this current post	
	$tags = wp_get_post_terms($post->ID,$taxTerm);
	
	// if we have found tags
	if($tags){
		$tag_ids = array();
		// collect their IDs
		foreach($tags as $individual_tag) {
			$tag_ids[] = $individual_tag->term_id;
		}
		
		$args = array(
			'tax_query' => array(
				array(
					'taxonomy' 	=> $taxTerm,
					'field' 	=> 'id',
					'terms' 	=> $tag_ids,
					'operator' => 'IN'
				)
			),
			'post__not_in' 		=> array($post->ID),
			'showposts'			=> $showposts,
			'caller_get_posts'	=>1
		);

		//$related_posts = $wpdb->get_results($q);
		$related_posts_query = new wp_query($args);
		
		if( $related_posts_query->have_posts() ) {		
			$result 		= array();
			$result['status'] = TRUE;
			$result['html'] 	= NULL;
			
			$prod_title = $OPTION['wps_related_prod_title'];
			$prod_price = $OPTION['wps_related_prod_price'];
			$prod_btn 	= $OPTION['wps_related_prod_btn'];
		
			while ($related_posts_query->have_posts()) {
				$related_posts_query->the_post();
				
				//get post id
				$related_postid = get_the_ID();

				$title_attr2 	= get_the_title($related_postid);
				$title_attr		= str_replace("%s",strip_tags($title_attr2), __('Permalink to %s', 'wpShop'));
				// SN 
				$imgs_to_exclude 	= get_custom_field2($related_postid, 'imgs_to_exclude', FALSE);
				$output 			= my_attachment_images($related_postid, 2, $imgs_to_exclude);
				//\ SN 
				$imgNum 		= count($output);
				
				//do we have 1 attached image?
				if($imgNum != 0){
					$imgURL		= array();
					// SN 
					foreach($output as $v){
						$img_src 	= $v;
						
						// do we want the WordPress Generated thumbs?
						if ($OPTION['wps_wp_thumb']) {
							//get the file type
							$img_file_type = strrchr($img_src, '.');
							//get the image name without the file type
							$parts = explode($img_file_type,$img_src);
							// get the thumbnail dimensions
							$width = get_option('thumbnail_size_w');
							$height = get_option('thumbnail_size_h');
							//put everything together
							$imgURL[] = $parts[0].'-'.$width.'x'.$height.$img_file_type;
						
						// no? then display the default proportionally resized thumbnails
						} else {
							$des_src 	= $OPTION['upload_path'] . '/' . $resizedImg_src;							
							$img_file 	= mkthumb($img_src,$des_src,$img_width,'width');    
							$imgURL[] 	= nws_uploads_url() . '/' . $resizedImg_src . '/' . $img_file;
						}
					}
					//\ SN
				// no attachments? pull image from custom field
				} elseif(strlen(get_custom_field2($related_postid,'image_thumb', FALSE))>0) { 
					// SN 
					$img_src 	= get_custom_field2($related_postid,'image_thumb', FALSE);
					
					// do we want the WordPress Generated thumbs?
					if ($OPTION['wps_wp_thumb']) {
						//get the file type
						$img_file_type = strrchr($img_src  , '.');
						//get the image name without the file type
						$parts = explode($img_file_type,$img_src);
						// get the thumbnail dimensions
						$width = get_option('thumbnail_size_w');
						$height = get_option('thumbnail_size_h');
						//put everything together
						$imgURL = $parts[0].'-'.$width.'x'.$height.$img_file_type;
					
					} else {
						$des_src 	= $OPTION['upload_path'] . '/' . $resizedImg_src;	
						$img_file 	= mkthumb($img_src,$des_src,$img_width,'width');
						$imgURL 	= nws_uploads_url() . '/' . $resizedImg_src . '/' . $img_file;	
					}
					//\ SN
				}	
				
				// put output together
				$permalink 	= get_permalink($related_postid);
				$contWrapWidth	= $OPTION['wps_wp_thumb'] ? get_option('thumbnail_size_w') : $img_width;
				
				$result['html'] .= " <div class='contentWrap related_prod_wrap' style='width:{$contWrapWidth}px'>";
				
					// for attached images
					if($imgNum != 0){
						if(($imgNum == 1) || ($OPTION['wps_hover_remove_option'])){ 
							$result['html']	.= "<a href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL[0]' alt='$title_attr2'/></a>"; 
						} else { 
							$result['html']	.= "
							<a href='$permalink' class='hover_link' rel='bookmark' title='$title_attr'><img src='$imgURL[0]' alt='$title_attr2'/></a>
							<a href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL[1]' alt='$title_attr2'/></a>
							"; 
						}

					// for  image from custom field
					} elseif(strlen(get_custom_field2($related_postid,'image_thumb', FALSE))>0) {
						$result['html']	.= "
							<a href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL' alt='$title_attr2'/></a>";
						
					} else { 									
						$err_message 	= __('Oops! No image found.','wpShop');									
						$result['html'] .= "<a href='$permalink' rel='bookmark' title='$title_attr'>$err_message</a>";
					}
					if($prod_title || $prod_price || $prod_btn){ 
						$result['html'] .= "<div class='teaser'>";
							if($prod_title){
								$result['html'] .= "<h5 class='related_prod_title'><a href='$permalink' title='$title_attr' rel='bookmark'>$title_attr2</a></h5>";
							}	
							if($prod_price && strlen(get_custom_field2($related_postid,'price', FALSE))>0){
								$result['html'] .= "<p class='price_value'>";
									if(strlen(get_custom_field2($related_postid,'new_price', FALSE))>0){
																		
										$result['html'] .= "<span class='was price'>";
											if($OPTION['wps_currency_symbol'] !='') { $result['html'] .= $OPTION['wps_currency_symbol'];} $result['html'] .= format_price(get_custom_field2($related_postid,'old_price'));
										$result['html'] .= "</span>
										<span class='is price'>";
											if($attr_option == 2){$result['html'] .= __('From: ','wpShop');} 
												if($OPTION['wps_currency_symbol'] !='') { $result['html'] .= $OPTION['wps_currency_symbol'];} $result['html'] .= format_price(get_custom_field2($related_postid,'new_price')); 
												if($OPTION['wps_currency_code_enable']) { $result['html'] .= " " . $OPTION['wps_currency_code']; }
												if($OPTION['wps_currency_symbol_alt'] !='') { $result['html'] .= " " . $OPTION['wps_currency_symbol_alt']; }
										$result['html'] .= "</span>";
																	
									} elseif(strlen(get_custom_field2($related_postid,'price', FALSE))>0){
																	
										$result['html'] .= "<span class='price solo'>";if($attr_option == 2){$result['html'] .= __('From: ','wpShop');} 
											if($OPTION['wps_currency_symbol'] !='') { $result['html'] .= $OPTION['wps_currency_symbol'];} $result['html'] .= format_price(get_custom_field2($related_postid,'price')); 
											if($OPTION['wps_currency_code_enable']) { $result['html'] .= " " . $OPTION['wps_currency_code']; }
											if($OPTION['wps_currency_symbol_alt'] !='') { $result['html'] .= " " . $OPTION['wps_currency_symbol_alt']; }
										$result['html'] .= "</span>";
									}	
								$result['html'] .= "</p>";
							}	
							if($OPTION['wps_shoppingCartEngine_yes'] && $prod_btn && strlen(get_custom_field2($related_postid,'disable_cart', FALSE))==0){ 
								// shop mode
								$wps_shop_mode 	= $OPTION['wps_shop_mode'];
								
								if($wps_shop_mode =='Inquiry email mode'){
									$result['html'] .= "<span class='shopform_btn add_to_enquire_alt'><a href='$permalink'>" . sprintf(__ ('Add to %s!','wpShop'), $OPTION['wps_pgNavi_inquireOption']) . "</a></span>";
								} elseif ($wps_shop_mode=='Normal shop mode' && !is_it_affiliate()){
									$result['html'] .= "<span class='shopform_btn add_to_cart_alt'><a  href='$permalink'>" . sprintf(__ ('Add to %s!','wpShop'), $OPTION['wps_pgNavi_cartOption']) . "</a></span>";
								} elseif ($wps_shop_mode=='affiliate_mode' || is_it_affiliate()){
									$result['html'] .= "<span class='shopform_btn buy_now_alt'><a href='" . get_custom_field2($related_postid,'buy_now') . "'"; if($OPTION['wps_affili_newTab']) { $result['html'] .= "title='" . __('Opens is new tab','wpShop') . "' target='_blank'"; } $result['html'] .= ">" . __('Buy Now','wpShop') . "</a></span>";
								} else {}
							
							} 
						$result['html'] .= "</div>";
					}
				$result['html'] .= "</div>";
			} wp_reset_query();
		}else {$result['status'] = FALSE;}
	}
	
return $result;
}
//\ SN

// Shopping Cart Tag/Custom Term related posts
function NWS_cart_tag_related_posts($prodID,$showposts,$resizedImg_src='cache',$img_width=81,$taxTerm='post_tag'){ 
	global $OPTION;
		
	// get tags of this current post	
	$tags = wp_get_post_terms($prodID,$taxTerm);
	
	// if we have found tags
	if($tags){
		$tag_ids = array();
		// collect their IDs
		foreach($tags as $individual_tag) {
			$tag_ids[] = $individual_tag->term_id;
		}
		
		$args = array(
			'tax_query' => array(
				array(
					'taxonomy' 	=> $taxTerm,
					'field' 	=> 'id',
					'terms' 	=> $tag_ids,
					'operator' => 'IN'
				)
			),
			'post__not_in' 		=> array($prodID),
			'showposts'			=> $showposts,
			'caller_get_posts'	=>1
		);
		
		$related_posts_query = new wp_query($args);
		
		if( $related_posts_query->have_posts() ) {
			$result 			= array();
			$result['status'] 	= TRUE;
			$result['html']		= NULL;
			$result['IDs'] 		= NULL;
			
			while ($related_posts_query->have_posts()) {
				$related_posts_query->the_post();
				
				//get post id
				$related_postid = get_the_ID();
				
				//for the IDs output
				$r_postID[] 	= $related_postid;
				
				//for the html output
				$title_attr2 	= get_the_title($related_postid);
				$title_attr		= str_replace("%s",strip_tags($title_attr2), __('Permalink to %s', 'wpShop'));
				// SN 
				$imgs_to_exclude 	= get_custom_field2($related_postid, 'imgs_to_exclude', FALSE);
				$output 			= my_attachment_images($related_postid, 1, $imgs_to_exclude);
				//\ SN 
				$imgNum 			= count($output);
				
				//do we have 1 attached image?
				if($imgNum != 0){
					$imgURL		= array();
					// SN
					foreach($output as $v){
						$img_src 	= $v;
						
						// do we want the WordPress Generated thumbs?
						if ($OPTION['wps_wp_thumb']) {
							//get the file type
							$img_file_type = strrchr($img_src, '.');
							//get the image name without the file type
							$parts = explode($img_file_type,$img_src);
							// get the thumbnail dimensions
							$width = get_option('thumbnail_size_w');
							$height = get_option('thumbnail_size_h');
							//put everything together
							$imgURL[] = $parts[0].'-'.$width.'x'.$height.$img_file_type;
						
						// no? then display the default proportionally resized thumbnails
						} else {
							$des_src 	= $OPTION['upload_path'] . '/' . $resizedImg_src;							
							$img_file 	= mkthumb($img_src,$des_src,$img_width,'width');    
							$imgURL[] 	= nws_uploads_url() .'/' . $resizedImg_src . '/' . $img_file;	
						}
					}
					//\ SN
				// no attachments? pull image from custom field
				} elseif(strlen(get_custom_field2($related_postid,'image_thumb', FALSE))>0) { 
					//SN
					$img_src 	= get_custom_field2($related_postid,'image_thumb', FALSE);
					
					// do we want the WordPress Generated thumbs?
					if ($OPTION['wps_wp_thumb']) {
						//get the file type
						$img_file_type = strrchr($img_src  , '.');
						//get the image name without the file type
						$parts = explode($img_file_type,$img_src);
						// get the thumbnail dimensions
						$width = get_option('thumbnail_size_w');
						$height = get_option('thumbnail_size_h');
						//put everything together
						$imgURL = $parts[0].'-'.$width.'x'.$height.$img_file_type;
					
					} else {
						$des_src 	= $OPTION['upload_path'] . '/' . $resizedImg_src;	
						$img_file 	= mkthumb($img_src,$des_src,$img_width,'width');
						$imgURL 	= nws_uploads_url() .'/' . $resizedImg_src . '/' . $img_file;	
					}
					//\ SN
				}	
				
				// put output together
				$permalink 	= get_permalink($related_postid);
				
				// for attached images
				if($imgNum != 0){ 

					$result['html']	.= "
						<a href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL[0]' alt='$title_attr2'/></a>";	
						
				// for  image from custom field
				} elseif(strlen(get_custom_field2($related_postid,'image_thumb', FALSE))>0) { 
					$result['html']	.= "
						<a href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL' alt='$title_attr2'/></a>";
					
				} else { 									
					$err_message 	= __('Oops! No image found.','wpShop');									
					$result['html'] 	= "<a href='$permalink' rel='bookmark' title='$title_attr'>$err_message</a>";
				}
				
			} wp_reset_query();
			$result['IDs'] = $r_postID;
				
		}else {$result['status'] = FALSE;}
	}
	
return $result;
}
//\SN

// adjacent post image
function NWS_adjacentProd($adjacentPost,$resizedImg_src,$img_width=81){

	global $post,$OPTION;
	$adjacent_post = $adjacentPost;
	
	if(($adjacent_post!='') || ($adjacent_post!=NULL)) 
	{ 			
		$result 		= array();
		$result[status] = TRUE;
		$result[html] 	= NULL;
		
		#my_attachment_data($postid=0,$numberposts = -1,$post_mime_type = 'image',$orderby = 'menu_order ID',$order = 'ASC')
		//let's collect our attachments- we just need one so we declare the parameters
		$data		= my_attachment_data($adjacent_post->ID,1);
		//count them
		$num 		= count($data);
		
		//do we have 1 attached image?
		if($num != 0){
			for($i=0,$a=1;$i<$num;$i++,$a++){
				$img_src 	= $data[$i]['guid'];
				$des_src 	= $resizedImg_src;	
				$img_file 	= mkthumb($img_src,$des_src,$img_width,'width');    
				$imgURL[] 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;	
			} 
		// no attachments? pull image from custom field
		} elseif(strlen(get_custom_field2($adjacent_post->ID,'image_thumb', FALSE))>0) { 
			$img_src 	= get_custom_field2($adjacent_post->ID,'image_thumb', FALSE);
			$des_src 	= $resizedImg_src;							
			$img_file 	= mkthumb($img_src,$des_src,$img_width,'width');      
			$imgURL 	= get_option('siteurl').'/'.$des_src.'/'.$img_file;
		}	
		
		// put output together
		$permalink 		= get_permalink($adjacent_post->ID);
		$title_attr2	= $adjacent_post->post_title;
		$title_attr		= str_replace("%s",$adjacent_post->post_title, __('Permalink to %s', 'wpShop'));
		
		// for 1 attached image
		if($num != 0){ 
			$result[html]	.= "
				<a class='adjacentImg' href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL[0]' alt='$title_attr2'/></a>";
				
		// for image from custom field
		} elseif(strlen(get_custom_field2($adjacent_post->ID,'image_thumb', FALSE))>0) { 
			$result[html]	.= "
				<a class='adjacentImg' href='$permalink' rel='bookmark' title='$title_attr'><img src='$imgURL' alt='$title_attr2'/></a>";
		
		} else { 									
			$err_message 	= __('Oops! No Product Images were found.','wpShop');									
			$result[html] 	= "<a class='adjacentImg' href='$permalink' rel='bookmark' title='$title_attr'>$err_message</a>";
		}
	}
	else {$result[status] = FALSE;}


return $result;
}

// for the "Previous" and "Next" products on the single product page
#
# 
# was not sure how to use filters for this so... (if you know a better way to do this please advice: sarah@neuber-web-solutions.de)
#
//
function NWS_adjacent_post_link($format, $link, $in_same_cat = false, $excluded_categories = '', $previous = true) {
	
	global $OPTION;
	
	if ( $previous && is_attachment() )
	  $post = & get_post($GLOBALS['post']->post_parent);
	else
	  $post = get_adjacent_post($in_same_cat, $excluded_categories, $previous);

	if ( !$post )
	  return;

	$title = $post->post_title;

	if ( empty($post->post_title) )
	  $title = $previous ? __('Previous Post','wpShop') : __('Next Post','wpShop');

	$title = apply_filters('the_title', $title, $post);
	$date = mysql2date($OPTION['date_format'], $post->post_date);
	// for the ID
	$NWS_ID = $previous ? 'previousProd' : 'nextProd';
	//for the title
	$NWS_title = $previous ? __($OPTION['wps_prevProdLinkText'].' in this Category','wpShop') : __($OPTION['wps_nextProdLinkText'].' in this Category','wpShop');

	$string = '<a class="'.$NWS_ID.'" href="'.get_permalink($post).'" title="'.$NWS_title.'">';
	$link = str_replace('%title', $title, $link);
	$link = str_replace('%date', $date, $link);
	$link = $string . $link . '</a>';

	$format = str_replace('%link', $link, $format);

	$adjacent = $previous ? 'previous' : 'next';
	echo apply_filters( "{$adjacent}_post_link", $format, $link );
}

function NWS_previous_post_link($format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '') {
	NWS_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, true);
	
}

function NWS_next_post_link($format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = '') {
    NWS_adjacent_post_link($format, $link, $in_same_cat, $excluded_categories, false);
	
}



##################################################################################################################################
// 											IMAGES
##################################################################################################################################
function get_upload_img_url($img){

	$parts 		= explode("http://",$img);													
	$findme 	= array('.gif','.jpg','.jpeg','.png');
	$picSuffix	= NULL;
													
		foreach($findme as $v){
			$pos 	= strpos($parts[1], $v);
				if ($pos !== false) {
					$picSuffix = $v; 
			} 
		}
																				
		$parts2 = explode("$picSuffix",$parts[1]);
		$imgURL = 'http://'.$parts2[0].$picSuffix;

return $imgURL;
}

function get_upload_img_type($imgURL){

	$picinfo = getimagesize($imgURL);
				
	// what case is it 										
	if($picinfo[0] > $picinfo[1]){
		$picType = 'landscape';
	}
	elseif($picinfo[0] < $picinfo[1]){
		$picType = 'portrait';
	}
	elseif($picinfo[0] == $picinfo[1]){
		$picType = 'square';
	}
	else{}	


return $picType;
}

function mkthumb($img_src,$des_src,$img_dimension=120,$option='height'){

	//find out if /wp-content/uploads/ is contained in URL, if not its a remote URL
	$isRemote = (strstr($img_src,'/wp-content/uploads/') !== FALSE ? FALSE : TRUE);
	
	// however, nice if someone wants to add a remote img resource, but this will only work 
	//if allow_url_fopen is enabled (CURL not implemented)
	if($isRemote){
		if(ini_get('allow_url_fopen') != '1'){	//warning if fopen is not enabled
			echo "<strong style='color:red;'>";
			_e('You try to use a remote image but the ini-setting allow_url_fopen is disabled. Try to enable it or use a local picture.','wpShop');
			echo "</strong>";
		}
	}
		
	//find name of img_file + create thumb path
	$img_file_alone = substr(strrchr($img_src,"/"),1);	
	// append the dimension
	$img_file 		= substr($img_file_alone,0,strripos($img_file_alone,".")) . '_' . $img_dimension . strrchr($img_file_alone,".");
	// get the destination path	
	$des_src 		= ($des_src[0] == "/" ? substr($des_src,1) : $des_src);
	// look for the resized image file	
	$thumb_path		= substr(WP_CONTENT_DIR,0,-10) . $des_src . '/' . $img_file;	

	// file_exists chaches results, needs to be cleared first
	clearstatcache(); 
			
	// thumbnail creation - but only if not yet existing
	if(!file_exists($thumb_path)) 
	{	
	
		$absolute_img_src = $img_src;	//must be a thing from the past 
		
		// before getting getting sizes check of resource really exists
		switch($isRemote){

			case TRUE : 

				if(fopen($absolute_img_src,'r') !== FALSE){	
					if(getimagesize($absolute_img_src) === FALSE){
						$img_file = 'error';
					}
				}			
				else {$img_file = 'error';}
			break;
			
			case FALSE :
			
				clearstatcache();
	
				$absolute_img_src = WP_CONTENT_DIR.'/uploads/'.$img_file_alone;
			
				if(file_exists($absolute_img_src)){
					if(getimagesize($absolute_img_src) === FALSE){
						$img_file = 'error';
					}
				}		
				else {$img_file = 'error';}					
			break;
		}

		// find sizes + type
		if($img_file != 'error'){
						
		   list($src_width,$src_height,$src_typ) = getimagesize($absolute_img_src);

		   
			// give them new (thumb) sizes
			switch($option){
			
				case 'height':
				$ratio 				= ($src_height > $img_dimension ? $src_height / $img_dimension : 1);
				$new_image_width 	= round(($src_width / $ratio),0); 
				$new_image_height	= round(($src_height / $ratio),0); 
				break;
				
				case 'width':
				$ratio 				= ($src_width > $img_dimension ? $src_width / $img_dimension : 1);
				$new_image_height 	= round(($src_height / $ratio),0); 
				$new_image_width	= round(($src_width / $ratio),0); 			
				break;
			}
			
			// SN change2
			// In 99% of the cases, JPEG does not offer visual improvements when going over 90% quality, especially for web images, including thumbnails
				/* 				
				- if the width and height product is lower than 0.5 kilopixels, use 94%
				- if lower than 1 megapixel, use 90%
				- if higher than 1 megapixel, use 86% 
				 */			
			$whprod = $new_image_width * $new_image_height;
			if ($whprod  < 500000) {
				$img_quality = 94;
			}elseif ($whprod < 1000000){
				$img_quality = 90;
			}else{
				$img_quality = 86;
			}			
			//\ SN change2
			
			if($src_typ == 1)     // GIF
			{
				$image 		= imagecreatefromgif($absolute_img_src);
				$new_image 	= imagecreate($new_image_width, $new_image_height);
				imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_image_width,$new_image_height, $src_width, $src_height);
			  
				imagegif($new_image,$thumb_path); // SN change2
				imagedestroy($image);
				imagedestroy($new_image);
			}
			
			elseif($src_typ == 2) // JPG
			{
			
				$image 		= imagecreatefromjpeg($absolute_img_src);
				$new_image 	= imagecreatetruecolor($new_image_width, $new_image_height);
				imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_image_width,$new_image_height, $src_width, $src_height);
			  
				imagejpeg($new_image,$thumb_path, $img_quality); // SN change2
				imagedestroy($image);
				imagedestroy($new_image);
				
			}
			elseif($src_typ == 3) // PNG
			{
				
				$image 		= imagecreatefrompng($absolute_img_src);
				$new_image 	= imagecreatetruecolor($new_image_width, $new_image_height);
				imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_image_width,$new_image_height, $src_width, $src_height);
				
				imagepng($new_image,$thumb_path,6); // SN change2
				imagedestroy($image);
				imagedestroy($new_image);
			}
			else
			{
			  $img_file = 'error';
			}			
		}			
	} 
		
return $img_file;
}

function filter_img_from_descr($searchPattern,$postContent){

	// we remove the images from the content
	$szDescription = preg_replace($searchPattern, '' ,$postContent);

	// Apply filters for correct content display
	$szDescription = apply_filters('the_content', $szDescription);

	// Echo the Content
	#echo $szDescription;
return $szDescription;
}


function my_attachment_image($postid=0, $size='thumbnail', $attributes='',$option='echo'){

	if ($postid<1){ $postid = get_the_ID(); }
	
	if ($images = get_children(array(
		'post_parent' => $postid,
		'post_type' => 'attachment',
		'order' => 'ASC', 
		'orderby' => 'menu_order ID',
		'numberposts' => 1,
		'post_mime_type' => 'image',))){
		
		foreach($images as $image) {
		
			$output 			= array();
		
			$attachment 		= wp_get_attachment_image_src($image->ID, $size);
			
			//SSL active? Use https:// for the image path
			if(($_SERVER['HTTPS'] == 'on')||($_SERVER['HTTPS'] == '1') || ($_SERVER['SSL'] == '1')){
				$img_parts = explode('http',$attachment[0]);
				$attachment[0] = 'https'.$img_parts[1];
			}
			
			// get together the $output[css_class]
			$parts 				= explode("/wp-content/uploads/",$attachment[0]);	
			$relPath 			= WP_CONTENT_DIR .'/uploads/'.$parts[1];
			$output[css_class] 	= get_upload_img_type($relPath);

			if($option == 'echo'){
				echo "<img class='img_{$output[css_class]}' src='$attachment[0]'  $attributes />";
			}
			elseif($option == 'return'){
				
				$output[img_path] 	= $attachment[0];
				$output[attr] 		= $attributes;
			
			}
			else {}
		}
	}
return $output;
}


//best used in WordPress loop 
function my_attachment_images($postid=0,$numberposts = -1){

	if ($postid<1){ $postid = get_the_ID(); }
	
	$images = get_children(array(
		'post_parent' => $postid,
		'post_type' => 'attachment',
		'order' => 'ASC', 
		'orderby' => 'menu_order ID',
		'numberposts' => $numberposts,
		'post_mime_type' => 'image',
	));
	
	$output = array();
	if (!empty($images)){
		foreach($images as $image){	
			$output[] = $image->guid;
		}
	}
return $output;
}


function my_attachment_data($postid=0,$numberposts = -1,$post_mime_type = 'image',$orderby = 'menu_order ID',$order = 'ASC'){

	if ($postid<1){ $postid = get_the_ID(); }
	
	$data = get_children(array(
		'post_parent' 		=> $postid,
		'post_type' 		=> 'attachment',
		'order' 			=> $order, 
		'orderby' 			=> $orderby,
		'numberposts' 		=> $numberposts,
		'post_mime_type' 	=> $post_mime_type,
	));
	
	$output = array();
	
	$i = 0;
	
	if (!empty($data)){
	
		foreach($data as $v){	
		
			foreach($v as $a => $d){
				$output[$i][$a] = $d;
			}
		$i++;
		}
			
	}
		
return $output;
}
?>