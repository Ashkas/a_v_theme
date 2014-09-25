<?
		
// Some juicy extra helpers for the admin. Delete out any feature you do not want 


// In this file each customisation is labeled. Just delete anything you do not want.


// REMOVE THE WORDPRESS UPDATE NOTIFICATION FOR ALL USERS EXCEPT ADMIN

global $user_login;
get_currentuserinfo();
if ($user_login !== "admin") { // change admin to the username that gets the updates
   add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
   add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
}

// remove junk from head

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

/**
 * Add default posts and comments RSS feed links to head
 */
add_theme_support( 'automatic-feed-links' );

// enable threaded comments
    
// MAKE CUSTOM POST TYPES SEARCHABLE

function searchAll( $query ) {
    if ( $query->is_search ) { $query->set( 'post_type', array( 'site','plugin', 'theme','person' )); }
    return $query;
}
add_filter( 'the_search_query', 'searchAll' );
    
//Remove plugin update for inactive plugins

     
function update_active_plugins($value = '') {
    /*
    The $value array passed in contains the list of plugins with time
    marks when the last time the groups was checked for version match
    The $value->reponse node contains an array of the items that are
    out of date. This response node is use by the 'Plugins' menu
    for example to indicate there are updates. Also on the actual
    plugins listing to provide the yellow box below a given plugin
    to indicate action is needed by the user.
    */
    if ((isset($value->response)) && (count($value->response))) {
 
        // Get the list cut current active plugins
        $active_plugins = get_option('active_plugins');    
        if ($active_plugins) {
 
            //  Here we start to compare the $value->response
            //  items checking each against the active plugins list.
            foreach($value->response as $plugin_idx => $plugin_item) {
 
                // If the response item is not an active plugin then remove it.
                // This will prevent WordPress from indicating the plugin needs update actions.
                if (!in_array($plugin_idx, $active_plugins))
                    unset($value->response[$plugin_idx]);
            }
        }
        else {
             // If no active plugins then ignore the inactive out of date ones.
            foreach($value->response as $plugin_idx => $plugin_item) {
                unset($value->response);
            }          
        }
    }  
    return $value;
}
add_filter('transient_update_plugins', 'update_active_plugins');    // Hook for 2.8.+   

//remove pings to self

function no_self_ping( &$links ) {
    $home = get_option( 'home' );
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, $home ) )
            unset($links[$l]);
}
add_action( 'pre_ping', 'no_self_ping' );

// shortcode in widgets

if ( !is_admin() ){
    add_filter('widget_text', 'do_shortcode', 11);
}

// CUSTOM ADMIN MENU LINK FOR ALL SETTINGS
   /*
function all_settings_link() {
    add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
   }
   add_action('admin_menu', 'all_settings_link');
*/


// CUSTOM ADMIN LOGIN HEADER LOGO
   /*
function my_custom_login_logo() {
    echo '<style type="text/css"> h1 a { background-image:url('.get_bloginfo('template_directory').'/images/your-logo-image.png) !important; } </style>';
   }
   add_action('login_head', 'my_custom_login_logo');
*/


// ADD CUSTOM POST TYPES TO THE 'RIGHT NOW' DASHBOARD WIDGET
function wph_right_now_content_table_end() {

	$args = array(
	'public' => true ,
	'_builtin' => false
	);
	$output = 'object';
	$operator = 'and';

	$post_types = get_post_types( $args , $output , $operator );
	foreach( $post_types as $post_type ) {
		$num_posts = wp_count_posts( $post_type->name );
		$num = number_format_i18n( $num_posts->publish );
		$text = _n( $post_type->labels->singular_name, $post_type->labels->name , intval( $num_posts->publish ) );
		if ( current_user_can( 'edit_posts' ) ) {
		$num = "<a href='edit.php?post_type=$post_type->name'>$num</a>";
		$text = "<a href='edit.php?post_type=$post_type->name'>$text</a>";
		}
		echo '<tr><td class="first b b-' . $post_type->name . '">' . $num . '</td>';
		echo '<td class="t ' . $post_type->name . '">' . $text . '</td></tr>';
	}
	
	$taxonomies = get_taxonomies( $args , $output , $operator ); 
	foreach( $taxonomies as $taxonomy ) {
		$num_terms  = wp_count_terms( $taxonomy->name );
		$num = number_format_i18n( $num_terms );
		$text = _n( $taxonomy->labels->singular_name, $taxonomy->labels->name , intval( $num_terms ));
		if ( current_user_can( 'manage_categories' ) ) {
		$num = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$num</a>";
		$text = "<a href='edit-tags.php?taxonomy=$taxonomy->name'>$text</a>";
		}
		echo '<tr><td class="first b b-' . $taxonomy->name . '">' . $num . '</td>';
		echo '<td class="t ' . $taxonomy->name . '">' . $text . '</td></tr>';
	}
}
add_action( 'right_now_content_table_end' , 'wph_right_now_content_table_end' );

/* Customising the dashboard */

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {
	global $wp_meta_boxes;
	
	//Remove a bunch of items
	
	//Plugins - Popular, New and Recently updated Wordpress Plugins
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	//Wordpress Development Blog Feed
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	//Other Wordpress News Feed
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	//Incoming Links
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	//Plugins - Popular, New and Recently updated Wordpress Plugins
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
}

// slice crazy long div outputs
function category_id_class($classes) {
    global $post;
    foreach((get_the_category($post->ID)) as $category)
        $classes[] = $category->category_nicename;
        return array_slice($classes, 0,5);
}
add_filter('post_class', 'category_id_class');


// REMOVE script version from CSS and JS for security http://diywpblog.com/wordpress-optimization-remove-query-strings-from-static-resources/
function _remove_script_version( $src ){
    $parts = explode( '?', $src );
    return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

// LIMIT POST REVISION to just 5, to help lessen DB bloat
define( 'WP_POST_REVISIONS', 5);


?>