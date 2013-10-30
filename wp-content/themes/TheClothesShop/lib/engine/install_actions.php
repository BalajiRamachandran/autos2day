<?php
// SN 
class nws_installation_wiz {
	
	/**
	 * Updates the default "Uncategorized" to something more useable and inserts  new categories
	 * uses wp_update_term() and wp_insert_term()
	 *
	 * @return TRUE on success FALSE on failure
	 */
	function insert_categories(){
		// update "Uncategorized" to "Men"
		$men = wp_update_term( 1, 'category', array(
			'name' 			=> 'Men',
			'slug' 			=> 'men',
			'description' 	=> 'An optional category description. You can enable it from your theme settings.'
			));
		
		// create new categories
		// we want to insert the category once so we check if term_exists returns FALSE first!
		
		// 1st level
			if (term_exists($women, 'category', 0) == FALSE) {
				$women = wp_insert_term('Women','category',array(
				'description'	=> 'An optional category description. You can enable it from your theme settings.',
				'slug' 			=> 'women',
				'parent'		=> 0
				));
			}
			if (term_exists($bedding, 'category', 0) == FALSE) {
				$bedding = wp_insert_term('Bedding','category',array(
				'description'	=> 'An optional category description. You can enable it from your theme settings.',
				'slug' 			=> 'bedding',
				'parent'		=> 0
				));
			}
				

		// 2nd level
			// child cats of women
			$women = get_term_by( 'name', 'Women', 'category', ARRAY_A);
			
			if (term_exists($tops, 'category', 0) == FALSE) {
				$tops = wp_insert_term('Tops','category',array(
				'description'	=> 'An optional category description. You can enable it from your theme settings.',
				'slug' 			=> 'tops',
				'parent'		=> $women['term_id']
				));
			}
			
			if (term_exists($bottoms, 'category', 0) == FALSE) {
				$bottoms = wp_insert_term('Bottoms','category',array(
				'description'	=> 'An optional category description. You can enable it from your theme settings.',
				'slug' 			=> 'bottoms',
				'parent'		=> $women['term_id']
				));	
			}
			
			if (term_exists($footwear, 'category', 0) == FALSE) {
				$footwear = wp_insert_term('Footwear','category',array(
				'description'	=> 'An optional category description. You can enable it from your theme settings.',
				'slug' 			=> 'footwear',
				'parent'		=> $women['term_id']
				));	
			}
			
		// 3rd level
			// child cat of tops (grandchild of women)
			$tops = get_term_by( 'name', 'Tops', 'category', ARRAY_A);
			if (term_exists($shirts, 'category', 0) == FALSE) {
				$shirts = wp_insert_term('Shirts','category',array(
				'description'	=> 'An optional category description. You can enable it from your theme settings.',
				'slug' 			=> 'shirts',
				'parent'		=> $tops['term_id']
				));
			}
			
			if (term_exists($tees, 'category', 0) == FALSE) {
				$tees = wp_insert_term('Tees','category',array(
				'description'	=> 'An optional category description. You can enable it from your theme settings.',
				'slug' 			=> 'tees',
				'parent'		=> $tops['term_id']
				));
			}
		
		// are the terms inserted?
		if((int)get_terms( 'category', 'fields=count&hide_empty=0') > 1) {
			return TRUE;
		}else {
			return FALSE;
		} 	
	}
	
	/**
	 * Deletes default "Hello World" and "Sample Page"
	 * uses wp_delete_post()
	 *
	 */
	function delete_default_content(){
	// delete "Hello World"
		$hello_world = 1;
		$default_post = get_post($hello_world, ARRAY_A ); 
		//if($default_post['post_title'] == __('Hello World!','wpShop')) {
			wp_delete_post(1, TRUE);
		//}
		
	// delete "Sample Page"
		$sample_page = 2;
		$default_page = get_post($sample_page, ARRAY_A ); 
		//if($default_page['post_title'] == __('Sample Page','wpShop')) {
			wp_delete_post(2, TRUE);
		//}
	}
	
	/**
	 * Helper function: Prepares the post content to be inserted
	 * 
	 * @return array
	 */
	function post_content() {
		global $user_ID;
	
	// variables for use below
		$men 			= get_term_by( 'name', 'Men', 'category', ARRAY_A);
		$bedding 			= get_term_by( 'name', 'Bedding', 'category', ARRAY_A);
		$women 		= get_term_by( 'name', 'Women', 'category', ARRAY_A);
			$tops 		= get_term_by( 'name', 'Tops', 'category', ARRAY_A);
				$shirts = get_term_by( 'name', 'Shirts', 'category', ARRAY_A);
				$tees = get_term_by( 'name', 'Tees', 'category', ARRAY_A);
			$bottoms 		= get_term_by( 'name', 'Bottoms', 'category', ARRAY_A);
			$footwear = get_term_by( 'name', 'Footwear', 'category', ARRAY_A);
		
	// prepare the posts
		$new_posts = array();
		
	// product posts	
		$new_posts[] = array(
			'post_title' 		=> 'Physical Product with Price Affecting Select Options',
			'post_content' 		=> 'Hover over the product image for a larger version. Hover over the thumbnails below for more images. The script used is called <a href="http://www.magictoolbox.com/?ac=2WA2V3J">Magic Zoom</a>. 
You are not restricted to this particular effect. You can choose between 4 different effects including jQzoom and Lightbox as well as no effects at all! 

Remember that you have full control over the image sizes from the theme settings.',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'post',
			'post_category' 	=> array($shirts['term_id']),
			'tax_input' 		=> array( 
				__('outfit', 'wpShop') 	=> array('Work Outfit 1'), 
				__('fit', 'wpShop') 	=> array('Trim'),
				__('size', 'wpShop') 	=> array('Regular'),
				__('colour', 'wpShop') 	=> array('Blue'),
			),
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Physical Product with Price Affecting Select Options for men',
			'post_content' 		=> 'Hover over the product image for a larger version. Hover over the thumbnails below for more images. The script used is called <a href="http://www.magictoolbox.com/?ac=2WA2V3J">Magic Zoom</a>. 
You are not restricted to this particular effect. You can choose between 4 different effects including jQzoom and Lightbox as well as no effects at all! 

Remember that you have full control over the image sizes from the theme settings.',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'post',
			'post_category' 	=> array($men['term_id']),
			'tax_input' 		=> array( 
				__('outfit', 'wpShop') 	=> array('A Work Outfit'), 
				__('fit', 'wpShop') 	=> array('Mens Traditional'),
				__('size', 'wpShop') 	=> array('Mens Regular'),
				__('colour', 'wpShop') 	=> array('Mens Blue'),
			),
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Physical Product with Select Options',
			'post_content' 		=> 'Hover over the product image for a larger version. Hover over the thumbnails below for more images. The script used is called <a href="http://www.magictoolbox.com/?ac=2WA2V3J">Magic Zoom</a>. 
You are not restricted to this particular effect. You can choose between 4 different effects including jQzoom and Lightbox as well as no effects at all! 

Remember that you have full control over the image sizes from the theme settings.',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'post',
			'post_category' 	=> array($shirts['term_id']),
			'tax_input' 		=> array( 
				__('outfit', 'wpShop') 	=> array('Work Outfit 2'), 
				__('fit', 'wpShop') 	=> array('Traditional'),
				__('size', 'wpShop') 	=> array('Tall'),
				__('colour', 'wpShop') 	=> array('Red'),
			),
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Physical Product with Select Options for men',
			'post_content' 		=> 'Hover over the product image for a larger version. Hover over the thumbnails below for more images. The script used is called <a href="http://www.magictoolbox.com/?ac=2WA2V3J">Magic Zoom</a>. 
You are not restricted to this particular effect. You can choose between 4 different effects including jQzoom and Lightbox as well as no effects at all! 

Remember that you have full control over the image sizes from the theme settings.',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'post',
			'post_category' 	=> array($men['term_id']),
			'tax_input' 		=> array( 
				__('outfit', 'wpShop') 	=> array('Another Work Outfit'), 
				__('fit', 'wpShop') 	=> array('Mens Traditional'),
				__('size', 'wpShop') 	=> array('Mens Tall'),
				__('colour', 'wpShop') 	=> array('Mens Red'),
			),
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Basic Product',
			'post_content' 		=> 'This is an example of a product with one image attachment. Hover over the product image for a larger version. The script used is called <a href="http://www.magictoolbox.com/?ac=2WA2V3J">Magic Zoom</a>. 
You are not restricted to this particular effect. You can choose between 4 different effects including jQzoom and Lightbox as well as no effects at all! 

Remember that you have full control over the image sizes from the theme settings.',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'post',
			'post_category' 	=> array($tees['term_id']),
			'tax_input' 		=> array( 
				__('outfit', 'wpShop') 	=> array('Weekend Outfit 2'), 
				__('fit', 'wpShop') 	=> array('Loose'),
				__('size', 'wpShop') 	=> array('Petite'),
				__('colour', 'wpShop') 	=> array('Pink'),
			),
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Basic Product for men',
			'post_content' 		=> 'This is an example of a product with one image attachment. Hover over the product image for a larger version. The script used is called <a href="http://www.magictoolbox.com/?ac=2WA2V3J">Magic Zoom</a>. 
You are not restricted to this particular effect. You can choose between 4 different effects including jQzoom and Lightbox as well as no effects at all! 

Remember that you have full control over the image sizes from the theme settings.',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'post',
			'post_category' 	=> array($men['term_id']),
			'tax_input' 		=> array( 
				__('outfit', 'wpShop') 	=> array('A Weekend Outfit'), 
				__('fit', 'wpShop') 	=> array('Mens Loose'),
				__('size', 'wpShop') 	=> array('Mens Tall'),
			),
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Affiliate Product',
			'post_content' 		=> 'This is an example of an "affiliate product". Your visitors can purchase it from a third-party site with which you are an affiliate. 
				
It is also a product with no attached images. The image you see is "pulled" from a custom field. Hover over the product image for a larger version. 
The script used is called <a href="http://www.magictoolbox.com/?ac=2WA2V3J">Magic Zoom</a>. 
You are not restricted to this particular effect. You can choose between 4 different effects including jQzoom and Lightbox as well as no effects at all! 

Remember that you have full control over the image sizes from the theme settings.',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'post',
			'post_category' 	=> array($bottoms['term_id']),
			'tax_input' 		=> array( 
				__('outfit', 'wpShop') 	=> array('Weekend Outfit 1'), 
				__('fit', 'wpShop') 	=> array('Loose'),
				__('size', 'wpShop') 	=> array('Regular'),
				__('colour', 'wpShop') 	=> array('Blue', 'Pink', 'Red'),
			),
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Affiliate Product for men',
			'post_content' 		=> 'This is an example of an "affiliate product". Your visitors can purchase it from a third-party site with which you are an affiliate. 
				
It is also a product with no attached images. The image you see is "pulled" from a custom field. Hover over the product image for a larger version. 
The script used is called <a href="http://www.magictoolbox.com/?ac=2WA2V3J">Magic Zoom</a>. 
You are not restricted to this particular effect. You can choose between 4 different effects including jQzoom and Lightbox as well as no effects at all! 

Remember that you have full control over the image sizes from the theme settings.',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'post',
			'post_category' 	=> array($men['term_id']),
			'tax_input' 		=> array( 
				__('outfit', 'wpShop') 	=> array('Another Weekend Outfit'), 
				__('fit', 'wpShop') 	=> array('Mens Loose'),
				__('size', 'wpShop') 	=> array('Mens Regular'),
			),
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Digital Product',
			'post_content' 		=> 'The theme supports digital products as well!',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'post',
			'post_category' 	=> array($footwear['term_id']),
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Digital Product for men',
			'post_content' 		=> 'The theme supports digital products as well!',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'post',
			'post_category' 	=> array($men['term_id']),
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'A Video Product',
			'post_content' 		=> 'You can easily embed a video preview to your products using the theme\'s custom video shortcodes. No plugins needed. 
You can embed self-hosted videos /audio or use one of the supported sites which include: Vimeo, YouTube, Google Video, Blip TV, Veoh, Viddler, Revver.(More upon request)

You can optionally select to display product images along with the video. These will appear in their own tab as you see here.
[vimeo id="5315673" width="355" height="200"]',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'post',
			'post_category' 	=> array($footwear['term_id']),
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'A Video Product for men',
			'post_content' 		=> 'You can easily embed a video preview to your products using the theme\'s custom video shortcodes. No plugins needed. 
You can embed self-hosted videos /audio or use one of the supported sites which include: Vimeo, YouTube, Google Video, Blip TV, Veoh, Viddler, Revver.(More upon request)

You can optionally select to display product images along with the video. These will appear in their own tab as you see here.
[vimeo id="5315673" width="355" height="200"]',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'post',
			'post_category' 	=> array($men['term_id']),
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
	// Pages
		$new_posts[] = array(
			'post_title' 		=> 'About',
			'post_content' 		=> '<h4>A Highly Flexible eCommerce theme!</h4>
Designed especially for online shops "The Clothes Shop" features a <strong>plugin free*</strong>, <strong>localized</strong> ecommerce system, a membership area, creating and saving a wishlist, 
an informative customer service area, unique "Shop by..." widgets, lots of independent widget ready areas and sooo much more!

<small>*refering to the shopping cart functionality and membership area</small>',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'page',
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Contact',
			'post_content' 		=> '<a href="http://faq4you.sarah-neuber.de/read.php?ident=5f8096ed896942da6bf4b7c795dae711">No contact form?</a>',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'page',
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Customer Service',
			'post_content' 		=> '',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'page',
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
			$new_posts[] = array(
				'post_title' 		=> 'Common Questions',
				'post_content' 		=> '',
				'post_status' 		=> 'publish',
				'post_author' 		=> $user_ID,
				'post_type' 		=> 'page',
				'comment_status' 	=> 'closed',
				'ping_status' 		=> 'closed'			
			);
			
				$new_posts[] = array(
					'post_title' 		=> 'FAQs',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
		
			$new_posts[] = array(
				'post_title' 		=> 'Order Status &amp; History',
				'post_content' 		=> '',
				'post_status' 		=> 'publish',
				'post_author' 		=> $user_ID,
				'post_type' 		=> 'page',
				'comment_status' 	=> 'closed',
				'ping_status' 		=> 'closed'			
			);
				$new_posts[] = array(
					'post_title' 		=> 'Track Your Order',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
				
			$new_posts[] = array(
				'post_title' 		=> 'Services &amp; Policies',
				'post_content' 		=> '',
				'post_status' 		=> 'publish',
				'post_author' 		=> $user_ID,
				'post_type' 		=> 'page',
				'comment_status' 	=> 'closed',
				'ping_status' 		=> 'closed'			
			);
				$new_posts[] = array(
					'post_title' 		=> 'Gift Boxing',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
				$new_posts[] = array(
					'post_title' 		=> 'Gift Cards &amp; Certificates',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
				$new_posts[] = array(
					'post_title' 		=> 'Privacy',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
				$new_posts[] = array(
					'post_title' 		=> 'Request a Catalog',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
				$new_posts[] = array(
					'post_title' 		=> 'Terms &amp; Conditions',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
			$new_posts[] = array(
				'post_title' 		=> 'Shipping &amp; Returns',
				'post_content' 		=> '',
				'post_status' 		=> 'publish',
				'post_author' 		=> $user_ID,
				'post_type' 		=> 'page',
				'comment_status' 	=> 'closed',
				'ping_status' 		=> 'closed'			
			);
				$new_posts[] = array(
					'post_title' 		=> 'Returns &amp; Exchanges',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
				$new_posts[] = array(
					'post_title' 		=> 'Shipping &amp; Handling',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
			$new_posts[] = array(
				'post_title' 		=> 'Size Charts',
				'post_content' 		=> '',
				'post_status' 		=> 'publish',
				'post_author' 		=> $user_ID,
				'post_type' 		=> 'page',
				'comment_status' 	=> 'closed',
				'ping_status' 		=> 'closed'			
			);
				$new_posts[] = array(
					'post_title' 		=> 'Some Type of Chart',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
			$new_posts[] = array(
				'post_title' 		=> 'Using the Website',
				'post_content' 		=> '',
				'post_status' 		=> 'publish',
				'post_author' 		=> $user_ID,
				'post_type' 		=> 'page',
				'comment_status' 	=> 'closed',
				'ping_status' 		=> 'closed'			
			);
				$new_posts[] = array(
					'post_title' 		=> 'Finding your products',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
				$new_posts[] = array(
					'post_title' 		=> 'How to Order Online',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
				$new_posts[] = array(
					'post_title' 		=> 'Making Changes or Canseling your Order',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
				$new_posts[] = array(
					'post_title' 		=> 'Sitemap',
					'post_content' 		=> '',
					'post_status' 		=> 'publish',
					'post_author' 		=> $user_ID,
					'post_type' 		=> 'page',
					'comment_status' 	=> 'closed',
					'ping_status' 		=> 'closed'			
				);
		
		$new_posts[] = array(
			'post_title' 		=> 'Search',
			'post_content' 		=> '',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'page',
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Register',
			'post_content' 		=> '',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'page',
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Login',
			'post_content' 		=> '',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'page',
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'Recover Password',
			'post_content' 		=> '',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'page',
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
		$new_posts[] = array(
			'post_title' 		=> 'My Account',
			'post_content' 		=> '',
			'post_status' 		=> 'publish',
			'post_author' 		=> $user_ID,
			'post_type' 		=> 'page',
			'comment_status' 	=> 'closed',
			'ping_status' 		=> 'closed'			
		);
		
	return $new_posts;
	}
	
	/**
	 * Helper function: Checks if postmeta exist in in postmeta table
	 *
	 * @return TRUE/FALSE feedback
	 */
	function postmeta_inserted(){
					
		global $wpdb;
		
		$table 	= $wpdb->prefix . 'postmeta';
		$qStr 	= "SELECT * FROM $table WHERE meta_key = 'ID_item'";
		$res 	= nws_db_query($qStr);
		$num 	= mysql_num_rows($res);
		
		if($num > 1){
			$result = TRUE;
		}else {
			$result = FALSE;
		}
					
	return $result;
	}
	
	/**
	 * Inserts post content, meta, attachments and in the case of pages also the page template
	 *
	 * @return array providing TRUE/FALSE feedback
	 */
	function insert_posts(){
		global $user_ID;
		
		$feedback = array();
		
	// delete default content
		$this->delete_default_content();
				
	// save the taxonomies we need in the options table so that they can be created
		// only if the taxonomies exist can we assign tax_input!
		$this->add_base_taxonomy_options();
		
	// bring in the post content
		$new_posts = $this->post_content();
		
		foreach($new_posts as $new_post) {
		
		// insert posts and pages
			$post_obj = get_page_by_title($new_post['post_title'], ARRAY_A, $new_post['post_type'] );
			
			// we want to insert each post once!
			if(empty($post_obj)) {
				$post_id = wp_insert_post($new_post);
			}
			
			if(!empty($post_obj)) {
			
			// bring in the post meta and attachments
				// needed for setting page parent on pages further down.
				$customer_service 		= get_page_by_title('Customer Service', ARRAY_A, 'page');
				$common_questions 		= get_page_by_title('Common Questions', ARRAY_A, 'page');
				$order_status_history 	= get_page_by_title('Order Status &amp; History', ARRAY_A, 'page');
				$services_policies 		= get_page_by_title('Services &amp; Policies', ARRAY_A, 'page');
				$shipping_returns 		= get_page_by_title('Shipping &amp; Returns', ARRAY_A, 'page');
				$size_charts 			= get_page_by_title('Size Charts', ARRAY_A, 'page');
				$using_website 			= get_page_by_title('Using the Website', ARRAY_A, 'page');
				
			// prepare custom fields & attachments
				// product posts
				if($post_obj['post_title'] == 'Physical Product with Price Affecting Select Options') {
					// check if the terms saved. If not we'll need to make sure they do!
					$outfit_terms 	= wp_get_post_terms( $post_obj['ID'], 'outfit');
					$fit_terms 		= wp_get_post_terms( $post_obj['ID'], 'fit');
					$size_terms 	= wp_get_post_terms( $post_obj['ID'], 'size');
					$colour_terms 	= wp_get_post_terms( $post_obj['ID'], 'colour');
					
					if(empty($outfit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Work Outfit 1', 'outfit', TRUE );
					}
					
					if(empty($fit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Trim', 'fit', TRUE );
					}
					
					if(empty($size_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Regular', 'size', TRUE );
					}
					
					if(empty($colour_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Blue', 'colour', TRUE );
					}

					$post_meta = array(
						'ID_item' 				=> 'Item-w1',
						'price' 				=> '50.00',
						'item_remarks' 			=> 'Special Price!',
						'add_attributes' 		=> '2',
						'item_attr_Colour' 		=> 'White-0.02|Blank-0.03',
						'item_attr_Size' 		=> 'small-0.00|medium-0.01|large-0.02',
						'seo_title'             => 'Physical Product with Price Affecting Select Options',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Physical Product with Price Affecting Select Options" page',
						'tell-a-friend' 		=> '1'
					);
					
					$post_attachments = array(
						'main_prod_img_one.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_one.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_one',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '1'
						),
						'main_prod_img_two.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_two.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_two',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '2'
						),
						'main_prod_img_three.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_three.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_three',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '3'
						)
					);
					
				}
				elseif($post_obj['post_title'] == 'Physical Product with Price Affecting Select Options for men') {
					// check if the terms saved. If not we'll need to make sure they do!
					$outfit_terms 	= wp_get_post_terms( $post_obj['ID'], 'outfit');
					$fit_terms 		= wp_get_post_terms( $post_obj['ID'], 'fit');
					$size_terms 	= wp_get_post_terms( $post_obj['ID'], 'size');
					$colour_terms 	= wp_get_post_terms( $post_obj['ID'], 'colour');
					
					if(empty($outfit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'A Work Outfit', 'outfit', TRUE );
					}
					
					if(empty($fit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Mens Traditional', 'fit', TRUE );
					}
					
					if(empty($size_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Mens Regular', 'size', TRUE );
					}
					
					if(empty($colour_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Mens Blue', 'colour', TRUE );
					}

					$post_meta = array(
						'ID_item' 				=> 'Item-m1',
						'price' 				=> '50.00',
						'image_thumb' 			=> nws_uploads_url() . '/main_prod_img.png',
						'item_remarks' 			=> 'Special Price!',
						'add_attributes' 		=> '2',
						'item_attr_Colour' 		=> 'White-0.02|Blank-0.03',
						'item_attr_Size' 		=> 'small-0.00|medium-0.01|large-0.02',
						'seo_title'             => 'Physical Product with Price Affecting Select Options for men',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Physical Product with Price Affecting Select Options for men" page',
						'tell-a-friend' 		=> '1'
					);
				}
				elseif($post_obj['post_title'] == 'Physical Product with Select Options') {
					// check if the terms saved. If not we'll need to make sure they do!
					$outfit_terms 	= wp_get_post_terms( $post_obj['ID'], 'outfit');
					$fit_terms 		= wp_get_post_terms( $post_obj['ID'], 'fit');
					$size_terms 	= wp_get_post_terms( $post_obj['ID'], 'size');
					$colour_terms 	= wp_get_post_terms( $post_obj['ID'], 'colour');
					
					if(empty($outfit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Work Outfit 2', 'outfit', TRUE );
					}
					
					if(empty($fit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Traditional', 'fit', TRUE );
					}
					
					if(empty($size_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Tall', 'size', TRUE );
					}
					
					if(empty($colour_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Red', 'colour', TRUE );
					}
					
					$post_meta = array(
						'ID_item' 				=> 'Item-w2',
						'price' 				=> '50.00',
						'new_price' 			=> '20.00',
						'item_remarks' 			=> 'Sale',
						'add_attributes' 		=> '1',
						'item_attr_Colour' 		=> 'pink|white|black',
						'item_attr_Size' 		=> '6|8|10|12|14|16|18',
						'item_pers_multi_1'		=> 'Special Instructions',
						'item_pers_single_1'	=> 'Personalize the Signature - max.12 Characters',
						'seo_title'             => 'Physical Product with Select Options',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Physical Product with Select Options" page',
						'tell-a-friend' 		=> '1'
					);
					
					$post_attachments = array(
						'main_prod_img_one1.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_one1.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_one1',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '1'
						),
						'main_prod_img_two1.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_two1.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_two1',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '2'
						),
						'main_prod_img_three1.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_three1.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_three1',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '3'
						)
					);
					
				}
				elseif($post_obj['post_title'] == 'Physical Product with Select Options for men') {
					// check if the terms saved. If not we'll need to make sure they do!
					$outfit_terms 	= wp_get_post_terms( $post_obj['ID'], 'outfit');
					$fit_terms 		= wp_get_post_terms( $post_obj['ID'], 'fit');
					$size_terms 	= wp_get_post_terms( $post_obj['ID'], 'size');
					$colour_terms 	= wp_get_post_terms( $post_obj['ID'], 'colour');
					
					if(empty($outfit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Another Work Outfit', 'outfit', TRUE );
					}
					
					if(empty($fit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Mens Traditional', 'fit', TRUE );
					}
					
					if(empty($size_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Mens Tall', 'size', TRUE );
					}
					
					if(empty($colour_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Mens Red', 'colour', TRUE );
					}
					
					$post_meta = array(
						'ID_item' 				=> 'Item-m2',
						'price' 				=> '50.00',
						'new_price' 			=> '20.00',
						'item_remarks' 			=> 'Sale',
						'add_attributes' 		=> '1',
						'item_attr_Colour' 		=> 'grey|white|black',
						'item_attr_Size' 		=> '6|8|10|12|14|16|18',
						'item_pers_multi_1'		=> 'Special Instructions',
						'item_pers_single_1'	=> 'Personalize the Signature - max.12 Characters',
						'seo_title'             => 'Physical Product with Select Options for men',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Physical Product with Select Options for men" page',
						'tell-a-friend' 		=> '1'
					);
					
					$post_attachments = array(
						'mens_main_prod_img_one1.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/mens_main_prod_img_one1.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'mens_main_prod_img_one1',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '1'
						),
						'mens_main_prod_img_two1.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/mens_main_prod_img_two1.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'mens_main_prod_img_two1',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '2'
						),
						'mens_main_prod_img_three1.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/mens_main_prod_img_three1.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'mens_main_prod_img_three1',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '3'
						)
					);
					
				}
				elseif($post_obj['post_title'] == 'Basic Product') {
					// check if the terms saved. If not we'll need to make sure they do!
					$outfit_terms 	= wp_get_post_terms( $post_obj['ID'], 'outfit');
					$fit_terms 		= wp_get_post_terms( $post_obj['ID'], 'fit');
					$size_terms 	= wp_get_post_terms( $post_obj['ID'], 'size');
					$colour_terms 	= wp_get_post_terms( $post_obj['ID'], 'colour');
					
					if(empty($outfit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Weekend Outfit 2', 'outfit', TRUE );
					}
					
					if(empty($fit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Loose', 'fit', TRUE );
					}
					
					if(empty($size_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Petite', 'size', TRUE );
					}
					
					if(empty($colour_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Pink', 'colour', TRUE );
					}
								
					$post_meta = array(
						'ID_item' 				=> 'Item-w3',
						'price' 				=> '60.00',
						'item_remarks' 			=> 'With one Image!',
						'seo_title'             => 'Basic Product',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Basic Product" page',
						'tell-a-friend' 		=> '1'
					);
					
					$post_attachments = array(
						'main_prod_img_one2.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_one2.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_one2',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit'
						)
					);
					
				}
				elseif($post_obj['post_title'] == 'Basic Product for men') {
					// check if the terms saved. If not we'll need to make sure they do!
					$outfit_terms 	= wp_get_post_terms( $post_obj['ID'], 'outfit');
					$fit_terms 		= wp_get_post_terms( $post_obj['ID'], 'fit');
					$size_terms 	= wp_get_post_terms( $post_obj['ID'], 'size');
					
					if(empty($outfit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'A Weekend Outfit', 'outfit', TRUE );
					}
					
					if(empty($fit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Mens Loose', 'fit', TRUE );
					}
					
					if(empty($size_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Mens Tall', 'size', TRUE );
					}
					
					$post_meta = array(
						'ID_item' 				=> 'Item-m3',
						'price' 				=> '60.00',
						'item_remarks' 			=> 'With one Image!',
						'seo_title'             => 'Basic Product for men',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Basic Product for men" page',
						'tell-a-friend' 		=> '1'
					);
					
					$post_attachments = array(
						'mens_main_prod_img_one2.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/mens_main_prod_img_one2.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'mens_main_prod_img_one2',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit'
						)
					);
					
				}
				elseif($post_obj['post_title'] == 'Affiliate Product') {
					// check if the terms saved. If not we'll need to make sure they do!
					$outfit_terms 	= wp_get_post_terms( $post_obj['ID'], 'outfit');
					$fit_terms 		= wp_get_post_terms( $post_obj['ID'], 'fit');
					$size_terms 	= wp_get_post_terms( $post_obj['ID'], 'size');
					$colour_terms 	= wp_get_post_terms( $post_obj['ID'], 'colour');
					
					if(empty($outfit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Weekend Outfit 1', 'outfit', TRUE );
					}
					
					if(empty($fit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Loose', 'fit', TRUE );
					}
					
					if(empty($size_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Regular', 'size', TRUE );
					}
					
					if(empty($colour_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Blue, Pink, Red', 'colour', TRUE );
					}
					
					$post_meta = array(
						'ID_item' 				=> 'Item-w4',
						'price' 				=> '10.00',
						'item_remarks' 			=> 'Affiliate Product',
						'buy_now' 				=> 'http://www.sarah-neuber.de',
						'image_thumb' 			=> nws_uploads_url() . '/main_prod_img.png',
						'seo_title'             => 'Affiliate Product',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Affiliate Product" page',
						'tell-a-friend' 		=> '1'
					);
				
				}
				elseif($post_obj['post_title'] == 'Affiliate Product for men') {
					// check if the terms saved. If not we'll need to make sure they do!
					$outfit_terms 	= wp_get_post_terms( $post_obj['ID'], 'outfit');
					$fit_terms 		= wp_get_post_terms( $post_obj['ID'], 'fit');
					$size_terms 	= wp_get_post_terms( $post_obj['ID'], 'size');
					
					if(empty($outfit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Another Weekend Outfit', 'outfit', TRUE );
					}
					
					if(empty($fit_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Mens Loose', 'fit', TRUE );
					}
					
					if(empty($size_terms)){
						wp_set_post_terms( $post_obj['ID'], 'Mens Regular', 'size', TRUE );
					}
					
					$post_meta = array(
						'ID_item' 				=> 'Item-m4',
						'price' 				=> '10.00',
						'item_remarks' 			=> 'Affiliate Product',
						'buy_now' 				=> 'http://www.sarah-neuber.de',
						'image_thumb' 			=> nws_uploads_url() . '/main_prod_img.png',
						'seo_title'             => 'Affiliate Product for men',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Affiliate Product for men" page',
						'tell-a-friend' 		=> '1'
					);
				
				}
				elseif($post_obj['post_title'] == 'Digital Product') {
					$post_meta = array(
						'ID_item' 				=> 'Item-w5',
						'price' 				=> '0.01',
						'item_remarks' 			=> 'Digital Product',
						'item_file' 			=> 'sample.pdf',
						'seo_title'             => 'Digital Product',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Digital Product" page',
						'tell-a-friend' 		=> '1'
					);
					
					$post_attachments = array(
						'main_prod_img_one3.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_one3.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_one3',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '1'
						),
						'main_prod_img_two2.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_two2.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_two2',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '2'
						),
						'main_prod_img_three2.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_three2.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_three2',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '3'
						),
						'main_prod_img_four.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_four.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_four',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '4'
						),
						'main_prod_img_five.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_five.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_five',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '5'
						)
					);
				
				}
				elseif($post_obj['post_title'] == 'Digital Product for men') {
					$post_meta = array(
						'ID_item' 				=> 'Item-m5',
						'price' 				=> '0.01',
						'item_remarks' 			=> 'Digital Product',
						'item_file' 			=> 'sample.pdf',
						'seo_title'             => 'Digital Product for men',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Digital Product for men" page',
						'tell-a-friend' 		=> '1'
					);
					
					$post_attachments = array(
						'mens_main_prod_img_one3.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/mens_main_prod_img_one3.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'mens_main_prod_img_one3',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '1'
						),
						'mens_main_prod_img_two2.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/mens_main_prod_img_two2.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'mens_main_prod_img_two2',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '2'
						),
						'mens_main_prod_img_three2.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/mens_main_prod_img_three2.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'mens_main_prod_img_three2',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '3'
						),
						'mens_main_prod_img_four.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/mens_main_prod_img_four.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'mens_main_prod_img_four',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '4'
						)
					);
				
				}
				elseif($post_obj['post_title'] == 'A Video Product') {
					$post_meta = array(
						'ID_item' 				=> 'Item-w6',
						'price' 				=> '10.00',
						'item_remarks' 			=> 'With a video!',
						'item_file' 			=> 'sample.zip',
						'seo_title'             => 'A Video Product',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "A Video Product" page',
						'tell-a-friend' 		=> '1'
					);
					
					$post_attachments = array(
						'main_prod_img_one4.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_one4.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_one4',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '1'
						),
						'main_prod_img_two3.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_two3.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_two3',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '2'
						),
						'main_prod_img_three3.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/main_prod_img_three3.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'main_prod_img_three3',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '3'
						)
					);
				}
				
				elseif($post_obj['post_title'] == 'A Video Product for men') {
					$post_meta = array(
						'ID_item' 				=> 'Item-m6',
						'price' 				=> '10.00',
						'item_remarks' 			=> 'With a video!',
						'item_file' 			=> 'sample.zip',
						'seo_title'             => 'A Video Product for men',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "A Video Product for men" page',
						'tell-a-friend' 		=> '1'
					);
					
					$post_attachments = array(
						'mens_main_prod_img_one4.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/mens_main_prod_img_one4.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'mens_main_prod_img_one4',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '1'
						),
						'mens_main_prod_img_two3.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/mens_main_prod_img_two3.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'mens_main_prod_img_two3',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '2'
						),
						'mens_main_prod_img_three3.png' 	=> array(
							'guid' 				=> nws_uploads_url() . '/mens_main_prod_img_three3.png',
							'post_mime_type' 	=> 'image/png',
							'post_title' 		=> 'mens_main_prod_img_three3',
							'post_content' 		=> '',
							'post_status' 		=> 'inherit',
							'menu_order'		=> '3'
						)
					);
				}
				
				// Pages
				elseif($post_obj['post_title'] == 'About') {
					$custom_template = 'default';
					
					$post_meta = array(
						'seo_title'             => 'About',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "About" page'
					);
					
				}elseif($post_obj['post_title'] == 'Contact') {
					$custom_template = 'default';
					
					$post_meta = array(
						'seo_title'             => 'Contact',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Contact" page'
					);
					
				}elseif($post_obj['post_title'] == 'Customer Service') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Customer Service',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Customer Service" page'
					);
					
				}elseif($post_obj['post_title'] == 'Common Questions') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Common Questions',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Common Questions" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Common Questions', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $customer_service['ID'];
					wp_update_post($update_post);
				
				}elseif($post_obj['post_title'] == 'FAQs') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'FAQs',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "FAQs" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('FAQs', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $common_questions['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Order Status &amp; History') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Order Status &amp; History',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Order Status &amp; History" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Order Status &amp; History', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $customer_service['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Track Your Order') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Track Your Order',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Track Your Order" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Track Your Order', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $order_status_history['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Services &amp; Policies') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Services &amp; Policies',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Services &amp; Policies" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Services &amp; Policies', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $customer_service['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Gift Boxing') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Gift Boxing',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Gift Boxing" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Gift Boxing', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $services_policies['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Gift Cards &amp; Certificates') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Gift Cards &amp; Certificates',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Gift Cards &amp; Certificates" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Gift Cards &amp; Certificates', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $services_policies['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Privacy') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Privacy',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Privacy" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Privacy', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $services_policies['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Request a Catalog') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Request a Catalog',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Request a Catalog" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Request a Catalog', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $services_policies['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Terms &amp; Conditions') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Terms &amp; Conditions',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Terms &amp; Conditions" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Terms &amp; Conditions', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $services_policies['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Shipping &amp; Returns') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Shipping &amp; Returns',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Shipping &amp; Returns" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Shipping &amp; Returns', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $customer_service['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Returns &amp; Exchanges') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Returns &amp; Exchanges',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Returns &amp; Exchanges" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Returns &amp; Exchanges', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $shipping_returns['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Shipping &amp; Handling') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Shipping &amp; Handling',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Shipping &amp; Handling" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Shipping &amp; Handling', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $shipping_returns['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Size Charts') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Size Charts',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Size Charts" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Size Charts', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $customer_service['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Some Type of Chart') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Some Type of Chart',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Some Type of Chart" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Some Type of Chart', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $size_charts['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Using the Website') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Using the Website',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Using the Website" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Using the Website', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $customer_service['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Finding your products') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Finding your products',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Finding your products" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Finding your products', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $using_website['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'How to Order Online') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'How to Order Online',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "How to Order Online" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('How to Order Online', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $using_website['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Making Changes or Canseling your Order') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Making Changes or Canseling your Order',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Making Changes or Canseling your Order" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Making Changes or Canseling your Order', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $using_website['ID'];
					wp_update_post($update_post);
					
				}elseif($post_obj['post_title'] == 'Sitemap') {
					$custom_template = 'customerService.php';
					
					$post_meta = array(
						'seo_title'             => 'Sitemap',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Sitemap" page'
					);
					
					$update_post 				= array();
					$page_obj 					= get_page_by_title('Sitemap', ARRAY_A, 'page');
					$update_post['ID'] 			= $page_obj['ID'];
					$update_post['post_parent'] = $using_website['ID'];
					wp_update_post($update_post);
				
				}elseif($post_obj['post_title'] == 'Search') {
					$custom_template = 'mySearch.php';
					
					$post_meta = array(
						'seo_title'             => 'Search',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Search" page'
					);

				}elseif($post_obj['post_title'] == 'Register') {
					$custom_template = 'accountRegister.php';
					
					$post_meta = array(
						'seo_title'             => 'Register',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Register" page'
					);
					
				}elseif($post_obj['post_title'] == 'Login') {
					$custom_template = 'accountLogin.php';
					
					$post_meta = array(
						'seo_title'             => 'Login',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Login" page'
					);
					
				}elseif($post_obj['post_title'] == 'Recover Password') {
					$custom_template = 'lost_password.php';
					
					$post_meta = array(
						'seo_title'             => 'Recover Password',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "Recover Password" page'
					);
					
				}elseif($post_obj['post_title'] == 'My Account') {
					$custom_template = 'accountCustomerArea.php';
					
					$post_meta = array(
						'seo_title'             => 'My Account',
						'seo_keywords'          => 'keyword one, keyword two',
						'seo_description'       => 'Some SEO friendly description for the "My Account" page'
					);
					
				}
				
			// insert post meta
				foreach ($post_meta as $meta_key => $meta_value) {
					add_post_meta($post_obj['ID'], $meta_key, $meta_value, TRUE);
				}
				
			// insert attachments
				foreach ($post_attachments as $filename => $attachment) {
					$img_obj = get_page_by_title($attachment['post_title'], ARRAY_A, 'attachment' );
					
					// we want to insert attachments once!
					if(empty($img_obj)) {
						$filename 	= nws_uploads_dir() . '/' . $filename;
						$attach_id 	= wp_insert_attachment( $attachment, $filename, $post_obj['ID']);
						
						// we must first include the image.php file
						// for the function wp_generate_attachment_metadata() to work
						require_once(ABSPATH . 'wp-admin/includes/image.php');
						$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );

						wp_update_attachment_metadata( $attach_id, $attach_data );
					}
				}
			// insert custom template
				if($post_obj['post_type'] == 'page'){
					add_post_meta($post_obj['ID'], '_wp_page_template', $custom_template, true);
				}
			}
		}

	// were the product and blog posts inserted?
		$prod_args = array( 'posts_per_page' => -1, 'post_type'=> 'post', 'author' => $user_ID );
		$products = get_posts($prod_args);
		if(!empty($products)) {
			$feedback['products'] = TRUE;
		}else {
			$feedback['products'] = FALSE;
		}

	// were custom fields inserted?
		$postmeta_inserted = $this->postmeta_inserted();
		if($postmeta_inserted) {
			$feedback['postmeta'] = TRUE;
		}else {
			$feedback['postmeta'] = FALSE;
		}	
			
	// where attachments inserted?
		$attach_args = array( 'posts_per_page' => -1, 'post_type'=> 'attachment', 'author' => $user_ID );
		$attachments = get_posts($attach_args);
		if(!empty($attachments)) {
			$feedback['attachments'] = TRUE;
		}else {
			$feedback['attachments'] = FALSE;
		}
		
	// were the pages inserted?
		$page_args = array( 'posts_per_page' => -1, 'post_type'=> 'page', 'author' => $user_ID );
		$pages 		= get_posts($page_args);
		if(!empty($pages)) {
			$feedback['pages'] = TRUE;
		}else {
			$feedback['pages'] = FALSE;
		}
		
	return $feedback;
	}
	
	/**
	 * Helper function: updates taxonomy settings in options table
	 *
	 */
	function add_base_taxonomy_options(){

	$taxonomy_options 								= array();

	$taxonomy_options['wps_shopByOutfit_option'] 	= 'true';
	$taxonomy_options['wps_shopByFit_option'] 		= 'true';
	$taxonomy_options['wps_shopBySize_option'] 		= 'true';
	$taxonomy_options['wps_shopByColour_option'] 	= 'true';

		foreach($taxonomy_options as $k => $v){
			update_option($k,$v);
		}
	}
	
	/**
	 * Helper function: updates some WordPress settings in options table
	 * 
	 */
	function add_base_settings_options(){

	$settings_options 											= array();

	$settings_options['uploads_use_yearmonth_folders'] 			= '0';
	$settings_options['upload_path'] 							= 'wp-content/uploads';
	$settings_options['permalink_structure'] 					= '/%category%/%postname%';
	$settings_options['thumbnail_size_w'] 						= '181';
	$settings_options['thumbnail_size_h'] 						= '181';
	$settings_options['medium_size_w'] 							= '300';
	$settings_options['medium_size_h'] 							= '9999';
	$settings_options['large_size_w'] 							= '690';
	$settings_options['large_size_h'] 							= '9999';

		foreach($settings_options as $k => $v){
			update_option($k,$v);
		}
	}

	/**
	 * Helper function: updates all theme settings in options table
	 * 
	 */
	function add_base_theme_options(){
		$about 				= get_page_by_title('About', ARRAY_A, 'page');
		$contact 			= get_page_by_title('Contact', ARRAY_A, 'page');
		$customer_service 	= get_page_by_title('Customer Service', ARRAY_A, 'page');
		$search 			= get_page_by_title('Search', ARRAY_A, 'page');
		$register 			= get_page_by_title('Register', ARRAY_A, 'page');
		$login 				= get_page_by_title('Login', ARRAY_A, 'page');
		$recover_password 	= get_page_by_title('Recover Password', ARRAY_A, 'page');
		$my_account 		= get_page_by_title('My Account', ARRAY_A, 'page');
		$size_chart 		= get_page_by_title('Size Charts', ARRAY_A, 'page');
		
		// array with the option names and default values!
		$option_name_info = array(
			'wps_shoppingCartEngine_yes' 	=> 'true', 
			'wps_lrw_yes' 					=> 'true',
			
			'wps_sidebar_option' 			=> 'alignRight',
			'wps_footer_option'				=> 'small_footer',
			'wps_customerServicePg'     	=> 'Customer Service',
			'wps_aboutPg'     				=> 'About',
			'wps_contactPg'     			=> 'Contact',
			'wps_featuredType'     			=> 'featured_cats',
			'wps_catimg_file_type'     		=> 'jpg',
			'wps_mainCat_orderbyOption' 	=> 'ID',
			'wps_mainCat_orderOption' 		=> 'ASC',
			'wps_mainCat1' 					=> 'men',
			'wps_mainCat3' 					=> 'bedding',
			'wps_mainCat2' 					=> 'women',
			'wps_customerAreaPg'			=> 'My Account',
			'wps_pgNavi_logOption'			=> 'Login',
			'wps_pgNavi_regOption'			=> 'Register',
			'wps_passLostPg'				=> 'Recover Password',
			'wps_wishListLink_option'		=> 'My Wishlist',
			'wps_pgNavi_cartOption'			=> 'Shopping Basket',
			'wps_shopping_icon'				=> 'shopping_icon.png',
			'wps_br_yes'					=> 'true',
			'wps_totalItemValue_enable'		=> 'true',
			'wps_pgNavi_homeOption'			=> 'Home',
			'wps_pgNavi_inclLeftOption'		=> $about['ID'] . ',' . $contact['ID'] . ',' . $customer_service['ID'],
			'wps_lrscLinks_option'			=> '',
			'wps_pgNavi_inclRightOption'	=> '',
			'wps_logoL'						=> '',
			'wps_pgNavi_exclOption'			=> $search['ID'] . ',' . $register['ID'] . ',' . $login['ID'] . ',' . $recover_password['ID'] . ',' . $my_account['ID'],
			'wps_pgNavi_sortOption'			=> 'menu_order',
			'wps_hybrid_menu_enable'		=> 'false',
			'wps_catNavi_inclOption'		=> '',
			'wps_catNavi_exclOption'		=> '',
			'wps_catNavi_orderbyOption'		=> 'ID',
			'wps_catNavi_orderOption'		=> 'ASC',
			'wps_catSubNav_rows'			=> '2',
			'wps_catSubNav_orderbyOption'	=> 'ID',
			'wps_catSubNav_orderOption'		=> 'ASC',
			'wps_pgNavi_searchOption'		=> 'Search',
			'wps_search_teaser_option'		=> 'false',
			'wps_search_link_enable'		=> 'true',
			'wps_search_title'				=> 'Looking for something specific?',
			'wps_search_text'				=> '',
			'wps_shopByOutfit_option'		=> 'true',
			'wps_shopByFit_option'			=> 'true',
			'wps_shopBySize_option'			=> 'true',
			'wps_shopByColour_option'		=> 'true',
			'wps_shopByBrand_option'		=> 'false',
			'wps_shopBySelection_option'	=> 'false',
			'wps_shopByStyle_option'		=> 'false',
			'wps_shopByPrice_option'		=> 'false',
			'wps_catDescr_enable'			=> 'true',
			'wps_catimg_file_type'			=> 'jpg',
			'wps_catCol_option'				=> 'catCol3_ws',
			'wps_secondaryCat_orderbyOption'=> 'ID',
			'wps_secondaryCat_orderOption'	=> 'ASC',
			'wps_tertiaryCat_orderbyOption'	=> 'ID',
			'wps_tertiaryCat_orderOption'	=> 'ASC',
			'wps_catDisplay_option'			=> 'text_title',
			'wps_tagimg_file_type'			=> 'png',
			'wps_termDescr_enable'			=> 'true',
			'wps_prodCol_option'			=> 'prodCol3_ws',
			'wps_tagCol_option'				=> 'tagCol3_ws',
			'wps_prods_orderbyOption'		=> 'ID',
			'wps_prods_orderOption'			=> 'ASC',
			'wps_showpostsOverwrite_Option'	=> 'showpostsOverwrite_yes',
			'wps_hover_remove_option'		=> 'false',
			'wps_wp_thumb'					=> 'false',
			'wps_teaser_enable_option'		=> 'true',
			'wps_teaser2_enable_option'		=> 'false',
			'wps_prod_title'				=> 'true',
			'wps_prod_price'				=> 'true',
			'wps_prod_btn'					=> 'false',
			'wps_backLink_enable'			=> 'true',
			'wps_prodNav_enable'			=> 'true',
			'wps_linksBottom_enable'		=> 'true',
			'wps_prevProdLinkText'			=> 'Previous Product',
			'wps_nextProdLinkText'			=> 'Next Product',
			'wps_prodImg_effect'			=> 'mz_effect',
			'wps_imgThumbs_enable'			=> 'true',
			'wps_imagesTab_enable'			=> 'true',
			'wps_videoTabText'				=> 'Video',
			'wps_imagesTabText'				=> 'Images',
			'wps_flowplayer_enable'			=> 'false',
			'wps_prod_ID'					=> 'true',
			'wps_prodVariations_orderBy'	=> 'meta_key',
			'wps_prodVariations_order'		=> 'ASC',
			'wps_prodPersonalization_orderBy'=> 'meta_key',
			'wps_prodPersonalization_order'	=> 'ASC',
			'wps_relatedProds_enable'		=> 'true',
			'wps_tagRelatedProds_enable'	=> 'true',
			'wps_catRelatedProds_enable'	=> 'true',
			'wps_relatedOpen_tab'			=> 'tag_related_tab',
			'wps_tag_relatedProds'			=> 'Complete the Outfit',
			'wps_tag_relatedProds_num'		=> '4',
			'wps_term_relatedProds'			=> 'outfit_related',
			'wps_cat_relatedProds'			=> 'You may also like',
			'wps_cat_relatedProds_num'		=> '4',
			'wps_cat_relatedProds_orderby'	=> 'rand',
			'wps_cat_relatedProds_order'	=> 'ASC',
			'wps_emailFriend_enable'		=> 'true',
			'wps_email_a_friend_title'		=> 'Email a Friend About this Item',
			'wps_email_a_friend_text'		=> '',
			'wps_print_enable'				=> 'true',
			'wps_share_enable'				=> 'true',
			'wps_share_title'				=> 'Bookmark & Share',
			'wps_share_text'				=> '',
			'wps_subscribe_enable'			=> 'true',
			'wps_feedburner_rsslink'		=> 'http://feeds2.feedburner.com/snDesign',
			'wps_feedburner_emaillink'		=> 'http://feedburner.google.com/fb/a/mailverify?uri=snDesign&loc=en_US',
			'wps_twitter'					=> 'srhnbr',
			'wps_subscribe_title'			=> 'Stay Informed',
			'wps_subscribe_text'			=> '',
			'wps_prodCol1_img_size'				=> '400',
			'wps_prodCol2n_img_size'			=> '355',
			'wps_prodCol3_img_size'				=> '290',
			'wps_prodCol3n_img_size'			=> '225',
			'wps_prodCol3w_img_size'			=> '181',
			'wps_prodCol4_img_size'				=> '127',
			'wps_prodCol5_img_size'				=> '160',
			'wps_singleProdMain1_img_size'		=> '355',
			'wps_singleProdMainMulti_img_size'	=> '290',
			'wps_singleProd_t_img_size'			=> '50',
			'wps_ProdRelated_img_size'			=> '81',
			'wps_shipping_details_enable'		=> 'true',
			'wps_shippingInfo_linkTxt'			=> 'Shipping &amp; Handling',
			'wps_shipping_details'				=> 'Here you may include some useful information for your customers regarding your Shipping &amp; Handling Fees, Returns Policy whether you ship Internationaly or not etc. Let them know that these charges will be calculated on Step 3 (Order Review).',
			'wps_sizeChart_enable' 				=> 'true',
			'wps_sizeChart_link' 				=> 'Size Chart',
			'wps_sizeChart2_link' 				=> get_page_link($size_chart['ID']),
			'wps_cartRelatedProds_enable'		=> 'true',
			'wps_term_cart_relatedProds'		=> 'outfit_related',
			'wps_checkout_showtel'				=> 'true',
			'wps_customNote_enable'				=> 'true',
			'wps_customNote_label'				=> 'Custom Note',
			'wps_customNote_remark'				=> 'This area can be used to send an optional message to the Shop Merchant or for a personal note to be delivered along with the order eg. when an order is a gift to someone.',
			'wps_terms_conditions'				=> 'Our terms &amp; conditions are...',
			'wps_login_duration'				=> '86400',
			'wps_logoutLink_option'				=> 'true',
			'wps_wishlistIntroText'				=> 'For some "intro" text on the "Wishlist" page.',
			'wps_extrainfo_header'				=> '',
			'wps_extrainfo_instruct'			=> '',
			'wps_extra_formfields'				=> '',
			'wps_extra_formfieldsCol'			=> '1',
			'wps_shop_mode'						=> 'Normal shop mode',
			'wps_enforce_ssl'					=> 'false',
			'wps_tax_info_enable'				=> 'false',
			'wps_track_inventory'				=> 'not_active',
			'wps_voucherCodes_enable'			=> 'false',
			'wps_affili_newTab'					=> 'false',
			'wps_shop_name'						=> 'The Clothes Shop',
			'wps_shop_street'					=> 'Some Street 1',
			'wps_shop_province'					=> 'Some State',
			'wps_shop_zip'						=> '11111',
			'wps_shop_town'						=> 'Some Town',
			'wps_shop_country'					=> 'GB',
			'wps_shop_email'					=> get_option('admin_email'),
			'wps_currency_code'					=> 'GBP',
			'wps_currency_code_enable'			=> 'true',
			'wps_currency_symbol'				=> '&pound;',
			'wps_currency_symbol_alt'			=> '',
			'wps_price_format'					=> '4',
			'wps_tax_abbr'						=> 'VAT',
			'wps_tax_percentage'				=> '20',
			'wps_delivery_options'				=> 'pickup',
			'wps_delivery_op_preselected'		=> 'pickup',
			'wps_payment_options'				=> 'transfer',
			'wps_payment_op_preselected'		=> 'transfer',
			'wps_wp_callback_url'				=> get_option('siteurl').'/wpay.php?pst='.md5(LOGGED_IN_KEY.'-'.NONCE_KEY),
			'wps_confirm_url'					=> get_option('home') . '/?confirm=1',
			'wps_ipn_url'						=> get_option('siteurl') . '/wp-content/themes/'. $CONFIG_WPS['themename'] .'/ipn.php?pst='.md5(LOGGED_IN_KEY.'-'.NONCE_KEY),	
			'wps_soldout_notice'				=> 'SOLD OUT',
			'wps_inventory_cleaning_method'		=> 'internal',
			'wps_inventory_cleaning_interval'	=> '14400',
			'wps_stock_warn_threshold'			=> '2',
			'wps_stock_warn_email'				=> get_option('admin_email'),
			'wps_pdfFormat'						=> 'A4',
			'wps_pdf_voucher_bg'				=> 'sample_coupon_voucher_1.jpg',
			'wps_bt_label'						=> 'Bank Transfer',
			'wps_banktransfer_bankname'			=> 'Some Bank',
			'wps_banktransfer_routing_enable'	=> 'true',
			'wps_banktransfer_routing_text'		=> 'Routing Number',
			'wps_banktransfer_bankno'			=> '1234',
			'wps_banktransfer_accountno'		=> '123456789 ',
			'wps_banktransfer_account_owner'	=> 'The Clothes Shop',
			'wps_banktransfer_iban'				=> 'AB12 1234 5678',
			'wps_banktransfer_bic'				=> 'ZYAB1',
			'wps_online_banking_url'			=> 'www.bankofengland.co.uk',
			'wps_shipping_method'				=> 'FLAT',
			'wps_shipping_flat_parameter'		=> '9.95',
			'wps_pickup_label'					=> 'Pick up (collect from Shop - no shipping fee applied!)',
			'wps_email_logo'					=> 'email-logo.jpg',
			'wps_email_txt_header'				=> 'The Clothes Shop',
			'wps_email_delivery_type'			=> 'mime',
			'wps_email_confirmation_dbl'		=> 'false',
			'wps_pdf_logo'						=> 'pdf-logo.jpg',
			'wps_order_no_prefix'				=> '1000',
			'wps_invoice_prefix'				=> 'Invoice',
			'wps_invoice_no_prefix'				=> '20110',
			'wps_PDF_invoiceNum_enable'			=> 'true',
			'wps_PDF_invoiceLabel'				=> 'Invoice-No.:',
			'wps_PDF_invoiceLabel_align'		=> 'R',
			'wps_PDF_orderNum_enable'			=> 'true',
			'wps_PDF_orderLabel'				=> 'Order-No.:',
			'wps_PDF_orderLabel_align'			=> 'R',
			'wps_PDF_trackID_enable'			=> 'true',
			'wps_PDF_trackLabel'				=> 'Tracking-No.:',
			'wps_PDF_orderLabel_align'			=> 'R',
			'wps_PDF_delAddr_enable'			=> 'false',
			'wps_pdf_logoWidth'					=> '70',
			'wps_pdf_header_addr_disable'		=> 'false',
			'wps_pdf_shop_name_only'			=> 'true',
			'wps_pdf_header_custom_text'		=> '',
			'wps_pdf_header_txtColour'			=> '0,0,0',
			'wps_pdf_header_fontSize'			=> '12',
			'wps_pdf_header_addrBorder'			=> 'false',
			'wps_pdf_header_bgdColour_enable'	=> 'false',
			'wps_vat_id_label'					=> '',
			'wps_vat_id'						=> '',
			'wps_pdf_footer_custom_text'		=> 'Some Custom Footer Text',
			'wps_pdf_footer_txtColour'			=> '0,0,0',
			'wps_pdf_footer_fontSize'			=> '6',
			'wps_pdf_footer_Border'				=> 'true',
			'wps_pdf_footer_bgdColour_enable'	=> 'false',
			'wps_pdf_invoiceFormat'				=> 'A4',
			'wps_pdf_leftMargin'				=> '10',
			'wps_pdf_rightMargin'				=> '10',
			'wps_pdf_topMargin'					=> '10',
			'wps_pdf_colWidth1'					=> '20',
			'wps_pdf_colWidth2'					=> '115',
			'wps_pdf_colWidth3'					=> '15',
			'wps_pdf_colWidth4'					=> '20',
			'wps_pdf_colWidth5'					=> '20'
		);

		//update options!		
		foreach($option_name_info as $option_name => $option_value) {
			update_option($option_name, $option_value);
		}
	}

	 
	 /**
	 * Helper function: presets widgets according to registered sidebar
	 * and updates the "sidebars_widgets" option
	 */
	function preset_widgets(){
		$preset_widgets = array (
			'frontpage_5left1_widget_area' 			=> array(),
			'frontpage_5left2_widget_area' 			=> array(),
			'frontpage_5middle_widget_area' 		=> array(),
			'frontpage_5middle_widget_area' 		=> array(),
			'frontpage_5right1_widget_area'			=> array(),
			'frontpage_5right2_widget_area'			=> array(),
			'frontpage_3left_widget_area'  			=> array('nws-promotions-3'),
			'frontpage_3middle_widget_area'  		=> array('nws-3link-promotions-3'),
			'frontpage_3right_widget_area'  		=> array('nws-2link-promotions-3'),
			'contact_page_widget_area'  			=> array('nws-alternative-contact-info-2'),
			'account_log_widget_area'  				=> array('text-9'),
			'customer_area_widget_area'  			=> array('text-10'),
			'main_customer_service_widget_area'  	=> array('text-4'),
			'sub_customer_service_widget_area'  	=> array('text-5'),		
			'search_widget_area'  					=> array('text-6'),
			'men_category_widget_area'  			=> array('nws-shop-by-outfit-4', 'nws-shop-by-fit-2', 'nws-shop-by-size-2'),
			'women_category_widget_area'  			=> array('nws-shop-by-outfit-3', 'nws-shop-by-fit-3', 'nws-shop-by-colour-3'),
			'bedding_category_widget_area'  		=> array('text-12'),
			'tag_widget_area'  						=> array('text-7'),			
			'archive_widget_area'  					=> array('text-8')
		);
		
		update_option( 'sidebars_widgets', $preset_widgets );
		
	}
	
	/**
	 * Helper function: updates widget settings
	 * uses update_widget_settings()
	 */
	function set_widget_settings(){
		$the_widgets = array();
						
		$the_widgets[] = array(
			"widget" 	=> "nws-promotions",
			"widget_id" => 3,
			"settings" 	=> array(
				'title' 		=> '',
				'link' 			=> '#',
				'linkText' 		=> 'Gift Cards',
				'hover_effect' 	=> 'on',
				'img' 			=> get_stylesheet_directory_uri() . '/images/promotions/gift_cards.png'
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "nws-3link-promotions",
			"widget_id" => 3,
			"settings" 	=> array(
				'title' 		=> '',
				'offer' 		=> 'Winter Sale',
				'link1' 		=> '#',
				'linkText1' 	=> 'Link1',
				'link2' 		=> '#',
				'linkText2' 	=> 'Link2',
				'link3' 		=> '#',
				'linkText3' 	=> 'Link3',
				'img' 			=> get_stylesheet_directory_uri() . '/images/promotions/sales3Links.png'
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "nws-2link-promotions",
			"widget_id" => 3,
			"settings" 	=> array(
				'title' 		=> '',
				'offer' 		=> 'Fall Sale',
				'link1' 		=> '#',
				'linkText1' 	=> 'Link1',
				'link2' 		=> '#',
				'linkText2' 	=> 'Link2',
				'img' 			=> get_stylesheet_directory_uri() . '/images/promotions/sales2Links.png'
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "nws-alternative-contact-info",
			"widget_id" => 2,
			"settings" 	=> array(
				'title' 	=> 'Alternative Ways of Contacting Us',
				'telTitle' => 'Telephone',
				'telNum' 	=> '',
				'AddressTitle' 	=> 'Address',
				'AddressDetails' 	=> 'Some1 Address

Some Street 8,

99427 Some State,

Some Country'
			)
		);
		

		$the_widgets[] = array(
			"widget" 	=> "text",
			"widget_id" => 4,
			"settings" 	=> array(
				'title' 	=> '',
				'text' 		=> 'A Widget Ready Section just for the Main Customer Service page. Will quietly collapse if not in use.',
				'filter' 	=> 1,
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "text",
			"widget_id" => 5,
			"settings" 	=> array(
				'title' 	=> 'Some Widget Title',
				'text' 		=> 'This is an independent widget ready area for the Customer Service Subpages. It will not appear if not in use and the main content area will extend to fill the available space',
				'filter' 	=> 1,
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "text",
			"widget_id" => 6,
			"settings" 	=> array(
				'title' 	=> 'Some Widget Title',
				'text' 		=> 'A Widget ready area just for the Search page',
				'filter' 	=> 1,
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "text",
			"widget_id" => 7,
			"settings" 	=> array(
				'text' 		=> 'This is a widget ready section just for the "Shop by..." taxonomy pages',
				'filter' 	=> 1,
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "text",
			"widget_id" => 8,
			"settings" 	=> array(
				'text' 		=> 'A widget ready sidebar for the Archive pages',
				'filter' 	=> 1,
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "text",
			"widget_id" => 9,
			"settings" 	=> array(
				'title' 	=> "",
				'text' 		=> 'This is a widget ready area just for the account login page. If will only appear if widgets are active.',
				'filter' 	=> 1,
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "text",
			"widget_id" => 10,
			"settings" 	=> array(
				'title' 	=> 'Customer Account Area',
				'text' 		=> 'This is a widget ready area for the customer account section',
				'filter' 	=> 1,
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "text",
			"widget_id" => 12,
			"settings" 	=> array(
				'title' 	=> 'Some Widget Title',
				'text' 		=> 'Widgets for this category go here.',
				'filter' 	=> 1,
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "nws-shop-by-outfit",
			"widget_id" => 3,
			"settings" 	=> array(
				'title' 			=> 'Shop by Outfit',
				'cat_slug' 			=> 'women',
				'show_images' 		=> 'on',
				'thumb_width' 		=> '80',
				'num_img_in_row' 	=> '3',
				'img_file_type' 	=> 'png',
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "nws-shop-by-outfit",
			"widget_id" => 4,
			"settings" 	=> array(
				'title' 			=> 'Shop by Outfit',
				'cat_slug' 			=> 'men',
				'show_images' 		=> 'on',
				'thumb_width' 		=> '80',
				'num_img_in_row' 	=> '3',
				'img_file_type' 	=> 'png',
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "nws-shop-by-fit",
			"widget_id" => 3,
			"settings" 	=> array(
				'title' 			=> 'Shop by fit',
				'cat_slug' 			=> 'women',
				'show_images' 		=> 'on',
				'thumb_width' 		=> '80',
				'num_img_in_row' 	=> '3',
				'img_file_type' 	=> 'png',
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "nws-shop-by-fit",
			"widget_id" => 4,
			"settings" 	=> array(
				'title' 			=> 'Shop by fit',
				'cat_slug' 			=> 'men',
				'show_images' 		=> 'on',
				'thumb_width' 		=> '80',
				'num_img_in_row' 	=> '3',
				'img_file_type' 	=> 'png',
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "nws-shop-by-size",
			"widget_id" => 2,
			"settings" 	=> array(
				'title' 			=> 'Shop by Size',
				'cat_slug' 			=> 'men',
				'show_images' 		=> 'on',
				'thumb_width' 		=> '80',
				'num_img_in_row' 	=> '3',
				'img_file_type' 	=> 'png',
			)
		);
		
		$the_widgets[] = array(
			"widget" 	=> "nws-shop-by-colour",
			"widget_id" => 4,
			"settings" 	=> array(
				'title' 			=> 'Shop by Colour',
				'cat_slug' 			=> 'women',
				'show_images' 		=> 'on',
				'thumb_width' 		=> '80',
				'num_img_in_row' 	=> '3',
				'img_file_type' 	=> 'png',
			)
		);
		
		foreach ($the_widgets as $the_widget) {
			//update_widget_settings($widget, $widget_id, $settings);
			$this->update_widget_settings($the_widget['widget'], $the_widget['widget_id'], $the_widget['settings']);
		}
	}
	
	/**
	 * Helper function: updates widget settings
	 * src: http://wordpress.stackexchange.com/questions/6699/changing-widget-options-via-the-functions-php-when-there-are-no-hooks
	 * 
	 * @param $widget (string) the widget name
	 * @param $widget_id (int) the widget id of the specific occurance of the widget whose settings we want to update
	 * (this can be obtained simply in the html from the <div id=""> tag of the specific widget)
	 * @param $settings (array) the widget settings to update
	 *
	 */
	function update_widget_settings($widget, $widget_id, $settings) {
		// retrieve the options for all occurrences of the named widget
		$options = get_option('widget_' . $widget);
		// this now contains the options of the specific occurrence of the widget
		$sub_options = $options[$widget_id];
		
		/* if(is_array($sub_options)) {
		// compare the current settings with those we provided and intersect
		$new_sub_options = array_intersect_key($settings, $sub_options);
		} else {
			$new_sub_options = $settings;
		} */
		
		$new_sub_options = $settings;
		
		// pass the changes back to the multi-widget array
		$options[$widget_id] = $new_sub_options;
		
		// write the altered widget options back into the wp_options table
		update_option('widget_' . $widget, $options); 
	}
	
	/**
	 * Helper function: creates the wizard header
	 *
	 * @param $install_step_info (int) the step we are on
	 *
	 * @return echos the header text
	 */
	function install_wizard_header($install_step_info){

		global $CONFIG_WPS;

		$wp_version = get_bloginfo('version');
		
		if(substr($wp_version,0,3) == '2.8'){
			$filler = "<br/><br/>";
		}
		else {
			$filler = NULL;
		}

	
	if($install_step_info > 3){
		$install_step_info = NULL;
	}
	
	$output = "<h2>" . WPSHOP_THEME_NAME . __(' Installation wizard Steps 1 2 3','wpShop')."</h2>
				<p class='instWizStep'>$install_step_info</p>
			";

	return $output;
	}
	
	/**
	 * The insttalation wizard
	 *
	 * @param $install_status (int) the step we are on
	 *
	 * @return the install_status
	 */
	function theme_install($install_status){
		global $OPTION;
		
		switch($install_status){
		
			case 0:
			$this->add_base_settings_options();
			
			echo "
				<h3 class='instWizSubheading'>".__('Please check your directory and file permissions','wpShop')."</h3>
				<p>".__('The following folders and files must be made writable while the theme is being set up, so please change their permissions to 777.','wpShop')."<br/>".__('Once done, click on the "Check permissions again" link bellow.','wpShop')."</p>
			";
			$writablePaths 		= array();
			$writablePaths[0]	= '../wp-content/uploads/#../wp-content/uploads/#DIR';
			$writablePaths[1]	= '../wp-content/uploads/cache/#../wp-content/uploads/cache/#DIR';
			$writablePaths[2]	= '../wp-content/themes/'.WPSHOP_THEME_NAME.'/dl/#..wp-content/themes/'.WPSHOP_THEME_NAME.'/dl/#DIR';
			$writablePaths[3]	= '../wp-content/themes/'.WPSHOP_THEME_NAME.'/images/vouchers/#..wp-content/themes/'.WPSHOP_THEME_NAME.'/images/vouchers/#DIR';
			$writablePaths[4]	= '../wp-content/themes/'.WPSHOP_THEME_NAME.'/pdf/bills/#..wp-content/themes/'.WPSHOP_THEME_NAME.'/pdf/bills/#DIR';
			$writablePaths[5]	= '../wp-content/themes/'.WPSHOP_THEME_NAME.'/pdf/tests/#..wp-content/themes/'.WPSHOP_THEME_NAME.'/pdf/tests/#DIR';
			
			$wpNum 		= count($writablePaths);
			$realNum	= 0;
			
			$icon			= array();
			$icon['DIR']	= "<img src='../wp-content/themes/".WPSHOP_THEME_NAME."/images/admin/folder_28.png' alt='Directory' />";
			$icon['FILE']	= "<img src='../wp-content/themes/".WPSHOP_THEME_NAME."/images/admin/paper_28.png' alt='File' />";

			
			foreach($writablePaths as $v){
			
				$data	= explode("#",$v);
			
				if((is_writable($data[0])) === TRUE){
					echo $icon["$data[2]"] ."<b>$data[1]</b> - <span class='writable' style='color: green;'>".__('Ok, writable!','wpShop')."</span>"; 
					$realNum++;
				}
				else {
					echo $icon["$data[2]"] ."<b>$data[1]</b> - <span class='not_writable' style='color: red;'>".__('Not writable!','wpShop')."</span>"; 
				}
				echo "<br/>";
			}
			
			echo "<br><a href='?page=functions.php'>".__('Check permissions again','wpShop')."</a>";
			echo "<br/><br/>"; 
			
			if($wpNum == $realNum){
				echo "
				<form action='?page=functions.php' method='post'>
					<input type='hidden' name='step' value='1'/>
					<input type='submit' name='install-step' value='".__('OK - Continue with Step 2','wpShop')."'/>
				</form>
				";
			}
			break;

			case 1:
				// set error to 0 (needed for the conditional further down)
				$error = 0;
				echo "<h3 class='instWizSubheading'>".__('Save example content.','wpShop')."</h3>";
				echo "<ol>";
					// categories
					echo "<li><h4>" . __('Categories','wpShop') . "</h4>";
						$insert_categories = $this->insert_categories();	
						// provide feedback		
						if($insert_categories == TRUE) {
							echo "<p class='indent success'>" . __('Categories successfuly created!','wpShop') . "</p>";
						} else {
							echo "<p class='indent error'>" . __('Failed to create categories!','wpShop') . "</p>";
						}
					echo "</li>";
				
					// posts (Products & Blog posts)
					echo "<li><h4>" . __('Pages, product and blog posts','wpShop') . "</h4>";
				
						$insert_posts = $this->insert_posts();	
						
						if($insert_posts['pages'] == TRUE) {
							echo "<p class='indent success'>" . __('Pages successfuly created!','wpShop') . "</p>";
						} else {
							echo "<p class='indent error'>" . __('Failed to create pages!','wpShop') . "</p>";
						}
						
						if($insert_posts['products'] == TRUE) {
							echo "<p class='indent success'>" . __('Product and Blog posts successfuly created!','wpShop') . "</p>";
						} else {
							echo "<p class='indent error'>" . __('Failed to create product posts!','wpShop') . "</p>";
						}
						
						//post meta as next
						if($insert_posts['postmeta'] == TRUE) {
							echo "<p class='indent success'>" . __('Post eCommerce and SEO meta successfuly added!','wpShop') . "</p>";
						} else {
							$error++;
							$ajax_loader_url 	= get_template_directory_uri() . '/images/ajax-loader-16.gif';
							echo "<p class='indent error'>" . __('Attempting to save post eCommerce and SEO meta. Please wait for the page to refresh... ','wpShop') . "<img src='$ajax_loader_url' onload='refresh_installation_page();' /></p>";
						}
						
						if($insert_posts['attachments'] == TRUE) {
							echo "<p class='indent success'>" . __('Image attachments successfuly added!','wpShop') . "</p>";
						} else {
							$ajax_loader_url 	= get_template_directory_uri() . '/images/ajax-loader-16.gif';
							echo "<p class='indent error'>" . __('Attaching images. Please wait for the page to refresh...','wpShop') . "<img src='$ajax_loader_url' onload='refresh_installation_page();' /></p>";
							echo "<meta http-equiv='refresh' content='0'>";				
						}
						
					echo "</li>";
					
					// theme options
					echo "<li><h4>" . __('Theme Options','wpShop') . "</h4>";
				
						$this->add_base_theme_options();
						
						if(isset($OPTION['wps_pdf_footer_Border'])){
							echo "<p class='indent success'>" . __('Theme Options successfuly saved!','wpShop') . "</p>";
						} else {
							$error++;
							$ajax_loader_url 	= get_template_directory_uri() . '/images/ajax-loader-16.gif';
							echo "<p class='indent error'>" . __('Saving the Theme Options. Please wait for the page to refresh... ','wpShop') . "<img src='$ajax_loader_url' onload='refresh_installation_page();' /></p>";
							echo "<meta http-equiv='refresh' content='0'>";
						}
					echo "</li>";
					
					// widgets
					echo "<li><h4>" . __('Widgets','wpShop') . "</h4>";
						
						// preset widgets
						$this->preset_widgets();
						// set their settings
						$this->set_widget_settings();
						
						// check if the last widget in our set_widget_settings() is set
						$last_widget = get_option('widget_nws-shop-by-colour');
						
						if($last_widget[4]['title'] == 'Shop by Colour') {
							echo "<p class='indent success'>" . __('Default widgets successfuly activated!','wpShop') . "</p>";
						} else {
							echo "<p class='indent error'>" . __('Failed to activate default widgets!','wpShop') . "</p>";
						}
					echo "</li>";
				echo "</ol>

				<h4>".__('You may now proceed to the last step of the installation','wpShop')."</h4>
				<form action='?page=functions.php' method='post'>
					<input type='hidden' name='step' value='2'/>
					<input type='submit' name='install-step' value='".__('OK - Continue with Step 3','wpShop')."'/>
				</form>";

			break;
			
			case 2:
							
				//windows or linux - this is here the question...
				if(DIRECTORY_SEPARATOR != "/"){
					$WINDOWS = TRUE;
				}
				
				if($WINDOWS){
						echo "<h3>".__('Your WordPress runs on a Windows operating system.','wpShop')."</h3>";
						echo "<p>".__('On a Linux Server we would normally ask you to change the writing permissons of the following directories to chmod 755.','wpShop');
						echo "<br/>";
						echo __('Try to perfom an equivalent action on your windows server.','wpShop');
						echo "</p>";
				}
				else{
						echo "
						<h3 class='instWizSubheading'>".__('Checking folder permissions one last time!','wpShop')."</h3>
						<p>".__('The following folders must be non-writable - i.e. the chmod should NOT be on 777','wpShop')."<br/>".__('Once done, click on the "Check permissions again" link below.','wpShop')."</p>";
				}
				
				
				
				$writablePaths 		= array();
				$writablePaths[0]	= '../wp-content/#..wp-content/#DIR';
				$writablePaths[1]	= '../wp-content/themes/'.WPSHOP_THEME_NAME.'/#..wp-content/themes/'.WPSHOP_THEME_NAME.'/#DIR';
				
				$wpNum 		= count($writablePaths);
				$realNum	= 0;
				
				foreach($writablePaths as $v){
				
					$data	= explode("#",$v);
					$icon			= array();
					$icon['DIR']	= "<img src='../wp-content/themes/".WPSHOP_THEME_NAME."/images/admin/folder_28.png' alt='Directory' />";
					$icon['FILE']	= "<img src='../wp-content/themes/".WPSHOP_THEME_NAME."/images/admin/paper_28.png' alt='File' />";
				
				
					if($WINDOWS){
						$ccmod = "0777";
							
						if($ccmod != "0777"){
							echo $icon["$data[2]"] ."<b>$data[1]</b> - <span class='writable' style='color: green;'>".__('Still writable!','wpShop')."</span>"; 
							$realNum++;
						}
					}
					else {	
						$ccmod = substr(decoct(fileperms($data[0])),1); // lets get the current chmod
							
						if($ccmod != "0777"){
							echo $icon["$data[2]"] ."<b>$data[1]</b> - <span class='not_writable' style='color: green;'>".__('Ok, not writable!','wpShop')." (chmod: $ccmod)</span>"; 
							$realNum++;
						}
						else {
							echo $icon["$data[2]"] ."<b>$data[1]</b> - <span class='writable' style='color: red;'>".__('Not ok, still writable!','wpShop')." (chmod: $ccmod)</span>"; 
						}
					}
						
					echo "<br/>";
					
				}
				if(!$WINDOWS){
					echo "<br/><a href='?page=theme-setup'>".__('Check permissions again','wpShop')."</a>";
				}
				
					echo "<br/><br/>"; 	

			if($wpNum == $realNum){
				echo "
				<form action='?page=functions.php' method='post'>
					<input type='hidden' name='step' value='4'/>
					<input type='submit' name='install-step' value='".__('Conclude installation','wpShop')."'/>
				</form>
				";
			}		
			break;
				
			case 4:
			
				echo "
				<br/>
				<br/>
				<br/>
				<h3 class='instWizSubheading'>".__('All\'s done!','wpShop')."</h3>
				<p>" . __('Please continue with configuring your Theme Options using the ','wpShop') 
				. "<a href='http://www.sarah-neuber.de/article-category/the-jewelry-shop-doc'>" . __('provided documentation','wpShop') . "</a>" . __(' as a guide.','wpShop') . "</p>
				<br/>";
				
				echo "
				<form action='?page=functions.php' method='post'>
					<input type='hidden' name='step' value='8'/>
					<input type='submit' name='install-step' value='".__('Exit Installation Wizard','wpShop')."'/>
				</form>
				";
			
			break;
			
		}

	return $install_status;
	}
}
//\ SN change3
?>