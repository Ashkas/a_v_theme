<?php

// Prepare scripts and styles
function load_a_v_scripts() {
	
	global $wp_styles;
	
	// reusable Variables
	$template_directory = get_template_directory_uri();
		
	// CSS
	
	wp_enqueue_style('a_v_template', $template_directory . '/style.css', false, '1.0', 'all');
	
	wp_enqueue_style('a_v_style', $template_directory . '/library/css/style.css', false, '1.0', 'all');
	
	wp_enqueue_style('a_v_style_ie8_lower', $template_directory . '/library/css/style-ie.css', false, '1.0', 'all');
	$wp_styles->add_data( 'a_v_style_ie8_lower', 'conditional', 'lt IE 8' );
	
	// HEADER scripts
		// CDN hosted JS
		/* pull jquery from g CDN. If it's not available, grab the local copy. Code from wp.tutsplus.com*/
		
		wp_deregister_script('jquery');
		
		$jquery = 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'; // the URL to check against  
		$test_jquery = @fopen($jquery,'r'); // test parameters  
		if( $jquery !== false ) { // test if the URL exists  
		
	        wp_register_script('a_v_jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',false, '1.9.1', false); // register the external file  
	        wp_enqueue_script('a_v_jquery'); // enqueue the external file   
	        
		} else {  
		
	        wp_enqueue_script('a_v_jquery', get_template_directory_uri() . '/library/js/jquery-1.9.1.min.js', false, '1.9.1', false);
		}  
		
		
		$modernizr = 'http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js'; // the URL to check against  
		$test_modernizr = @fopen($modernizr,'r'); // test parameters  
		if( $test_modernizr !== false ) { // test if the URL exists  
		
	        wp_enqueue_script('ashkas_modernizer', "http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js", array('jquery'), false, '2.7.1', true);	  
	        
		} else {  
		
	        wp_enqueue_script('a_v_modernizr', get_template_directory_uri() . '/library/js/modernizr.min.js', false, '2.6.2', true);	 
		}  
		
	// FOOTER scripts
	
		$flexslider = 'http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js'; // the URL to check against  
		$test_flexslider = @fopen($flexslider,'r'); // test parameters  
		if( $test_flexslider !== false ) { // test if the URL exists  
		
	        wp_enqueue_script('a_v_flexslider', "http://cdnjs.cloudflare.com/ajax/libs/flexslider/2.1/jquery.flexslider-min.js", array('jquery'),false, '2.2', true);	  
	        
		} else {  
		
	        wp_enqueue_script('a_v_flexslider', get_template_directory_uri() . '/library/js/jquery.flexslider-min.js', array('jquery'),false, '2.1', true);// load flexslider in footer 
	        			
		}  
		
		wp_enqueue_script('a_v_fresco', $template_directory . '/library/js/fresco.js', array('jquery'), '1.1.2', true);
		wp_enqueue_script('a_v_offcanvas', $template_directory . '/library/js/offcanvas.js', array('jquery'), '1.0', true);
}

add_action('wp_enqueue_scripts', 'load_a_v_scripts', 1);		// Script-loading hook last param "1" ... priority. affects js loading order http://codex.wordpress.org/Function_Reference/add_action 


/**
 * Creates custom settings for the WordPress comment form.
 *
 * @since 1.0
 */
function modular_a_comment_form_args( $args ) {
	$args['label_submit'] = __( 'Post Comment' ); // Use the default WP translation.
	return $args;
}

// Include the PHP html parser library. Is used to look for images in the content and replace them
// http://htmlparsing.com/php.html
require_once('library/functions/simple_html_dom.php');

////////////* Images *//////////////

// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
add_theme_support('post-thumbnails');

/* Function for allowing positioning of cropped images */
include (TEMPLATEPATH . '/library/functions/image_crop_position.php'); 

/* Control compression of files uploaded, set JPG compression to 60% */

add_filter( 'jpeg_quality', 'jpeg_full_quality' );
function jpeg_full_quality( $quality ) { return 45; }

/* Register new image sizes - using a different hook based off filter above, allows positioning of cropping */
bt_add_image_size( 'large-16x9', 2160, 1215, array( 'center', 'top' ) );
bt_add_image_size( 'large-24x1', 2160, 898, array( 'center', 'top' ) );
bt_add_image_size( 'medium-16x9', 1080, 607, array( 'center', 'top' ) );

// set the quality to maximum
add_filter('jpeg_quality', function($arg){return 100;});

add_action('added_post_meta', 'ad_update_jpeg_quality', 10, 4);

function ad_update_jpeg_quality($meta_id, $attach_id, $meta_key, $attach_meta) {

    if ($meta_key == '_wp_attachment_metadata') {

        $post = get_post($attach_id);

        if ($post->post_mime_type == 'image/jpeg' && is_array($attach_meta['sizes'])) {

            $pathinfo = pathinfo($attach_meta['file']);
            $uploads = wp_upload_dir();
            $dir = $uploads['basedir'] . '/' . $pathinfo['dirname'];

            foreach ($attach_meta['sizes'] as $size => $value) {

                $image = $dir . '/' . $value['file'];
                $resource = imagecreatefromjpeg($image);

                if ($size == 'large' || $size == 'medium' || $size == 'thumbnail') {
                    // set the jpeg quality for 'spalsh' size
                    imagejpeg($resource, $image, 65);
                } else {
                    // set the jpeg quality for the 'splash1' size
                    imagejpeg($resource, $image, 30);
                } 

                // or you can skip a paticular image size
                // and set the quality for the rest:
                // if ($size == 'splash') continue;

                imagedestroy($resource);
            }
        }
    }
}

// Add the custom sezes to the image insertion choices in "Add Media"
add_filter( 'image_size_names_choose', 'custom_image_sizes_choose' );
function custom_image_sizes_choose( $sizes ) {
	
	unset( $sizes['full'] );
	
	$custom_sizes = array(
		'large-24x1' => 'Large 2.4:1',
		'large-16x9' => 'Large 16:9',
		'medium-16x9' => 'Medium 16:9',
	);
	return array_merge( $sizes, $custom_sizes );
}

/**
* Filter out hard-coded width, height attributes on all images in WordPress.
* https://gist.github.com/4557917
*
* This version applies the function as a filter to the_content rather than send_to_editor.
* Changes made by filtering send_to_editor will be lost if you update the image or associated post
* and you will slowly lose your grip on sanity if you don't know to keep an eye out for it.
* the_content applies to the content of a post after it is retrieved from the database and is "theme-safe".
* (i.e., Your changes will not be stored permanently or impact the HTML output in other themes.)
*
* Also, the regex has been updated to catch both double and single quotes, since the output of
* get_avatar is inconsistent with other WP image functions and uses single quotes for attributes.
* [insert hate-stare here]
*
*/
function mytheme_remove_img_dimensions($html) {
$html = preg_replace('/(width|height)=["\']\d*["\']\s?/', "", $html);
return $html;
}
add_filter('post_thumbnail_html', 'mytheme_remove_img_dimensions', 10);
add_filter('the_content', 'mytheme_remove_img_dimensions', 10);
add_filter('get_avatar','mytheme_remove_img_dimensions', 10);


/* Function to get image meta - http://wordpress.org/ideas/topic/functions-to-get-an-attachments-caption-title-alt-description */
function wp_get_attachment( $attachment_id ) {

	$attachment = get_post( $attachment_id );
	return array(
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID ),
		'src' => $attachment->guid,
		'title' => $attachment->post_title
	);
}

/* Get the caption from relationship field image */
function get_post_thumbnail_caption_relationship($image_id) {

  $thumbnail_image = get_posts(array('p' => $image_id, 'post_type' => 'attachment'));

  if ($thumbnail_image && isset($thumbnail_image[0])) {
    return $thumbnail_image[0]->post_content;
  }
}

////////////* Sidebars *//////////////

// Register SIdebar
register_sidebar(array(
	'name' => __( 'Header Widget' ),
	'id' => 'header-widget',
	'description' => __( 'Widgets in this area will appear in the header.' ),
	'before_widget' => '<span id="%1$s" class="widget %2$s">',
	'after_widget'  => '</span>',
	'before_title' => '',
	'after_title' => ''
));

register_sidebar(array(
	'name' => __( 'Sidebar Widget' ),
	'id' => 'sidebar-widget',
	'description' => __( 'Widgets in this area will appear in the sidebar.' ),
	'before_widget' => '<span id="%1$s" class="widget %2$s">',
	'after_widget'  => '</span>',
	'before_title' => '',
	'after_title' => ''
));

////////////* Cache *//////////////

require_once( trailingslashit( TEMPLATEPATH ) . 'library/functions/functions-cache.php' );

////////////* Menu Functions *//////////////

register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'a_v' ),
) );

register_nav_menus( array(
	'primary-oc' => __( 'Primary Off Canvas Menu', 'a_v' ),
) );

register_nav_menus( array(
	'footer_menu_1' => __( 'Additional Menu 1', 'a_v' ),
) );

register_nav_menus( array(
	'footer_menu_2' => __( 'Additional Menu 2', 'a_v' ),
) );

register_nav_menus( array(
	'footer_menu_3' => __( 'Additional Menu 3', 'a_v' ),
) );

register_nav_menus( array(
	'footer_menu_4' => __( 'Additional Menu 4', 'a_v' ),
) );

require_once( trailingslashit( TEMPLATEPATH ) . 'library/functions/functions-menu.php' );

////////////* Custom Functions *//////////////

require_once( trailingslashit( TEMPLATEPATH ) . 'library/functions/functions-custom.php' );

// LIMIT POST REVISION to just 3, to help lessen DB bloat
define( 'WP_POST_REVISIONS', 3);

////////////* SITEMAP *//////////////

// Very simple this, grab the built-in WP sitemap ability and give it a shortcode. Make a page and use [sitemap]

require_once( trailingslashit( TEMPLATEPATH ) . 'library/functions/functions-sitemap.php' );

////////////* EXTRAS *//////////////

// Include function customisation extras. In this file each customisation is labeled. Just delete anything you do not want.

require_once( trailingslashit( TEMPLATEPATH ) . 'library/functions/functions-extras.php' );

?>