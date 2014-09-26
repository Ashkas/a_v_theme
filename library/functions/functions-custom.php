<?php

////////////* PAGINATION *//////////////

// This is for the news/blog area
function content_nav($pages, $range = 5) { 
     $showitems = ($range * 2)+1; 
     global $paged;
     if(empty($paged)) $paged = 1;
     if($pages == '')
/*
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
*/
         if(!$pages)
         {
             $pages = 1;
         }
/*      }   */
 
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span class=\"pages\">";
         if($paged > 1) echo "<div class='pagination_arrows previous'><a href='".get_pagenum_link($paged - 1)."' title='Newer'><span class='icon-arrow-left'></span></a></div>";
		 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages) echo "<div class='pagination_arrows next'><a href=\"".get_pagenum_link($paged + 1)."\" title='Older'><span class='icon-arrow-right'></span></a></div>";  
         echo "</span><div class='clearfix'></div></div>\n";
     }
}

function search_nav() {
	
	global $wp_query;
	
	if ( $wp_query->max_num_pages > 1 ) : ?>
		<div class="padding_block">
			<nav class="single_block pagination" role="navigation">
				<div class="nav-previous float_left"><?php previous_posts_link( __( '<span class="icon-arrow-left" title="previous"></span> <span class="nav_text">Previous</span>', $wp_query->max_num_pages ) ); ?></div>
				<div class="nav-next float_right"><?php next_posts_link( __( '<span class="nav_text">Next</span> <span class="icon-arrow-right" title="next"></span>', $wp_query->max_num_pages ) ); ?></div>
				<div class="clearfix"></div>
			</nav> <!-- #<?php echo $html_id; ?> .navigation -->
		</div>
	<?php endif;
}


// ACF Functions

/* Change the ACF options page name to Global */

if(function_exists('acf_add_options_page')) { 
	acf_add_options_page();
	acf_add_options_sub_page('Homepage');
	acf_add_options_sub_page('General');
	acf_add_options_sub_page('Footer');
}


// Shortcode for ACF video

function video_embed_func(){
	global $post;
	$video = '<div class="embed_container">'.get_field( 'video_embed', $post->ID ).'</div>';
	return $video;
}
add_shortcode( 'video_embed', 'video_embed_func' );

 
// From - http://css-tricks.com/snippets/wordpress/year-shortcode/
function year_shortcode() {
	$year = date('Y');
	return $year;
}
add_shortcode('year', 'year_shortcode');

// Check whether a page is a descendent of another

function is_child($pid) {
	// $pid = The ID of the ancestor page
	global $post; // load details about this page
	$anc = get_post_ancestors( $post->ID );
	
	// don't run in admin back-end
	if(!is_admin) {
		foreach($anc as $ancestor) {
			if(is_page() && $ancestor == $pid) {
				return true;
			}
		}
	}
	return false; // we're elsewhere
};

/****** Security and Sanitization *****/

// http://css-tricks.com/snippets/php/sanitize-database-inputs/

// Step 1
function cleanInput($input) {
 
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );
 
    $output = preg_replace($search, '', $input);
    return $output;
  }

// Step 2
function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleanInput($input);
        $output = mysql_real_escape_string($input);
    }
    return $output;
}

// post reading time function from - http://bentatlow.com/blog/wordpress-reading-time-function/
function read_time() {
		$content = get_post_field( 'post_content', $post->ID );
		$word_count = str_word_count( strip_tags( $content ) );
		$words_per_minute = 250;
		$read_time = round ( ( $word_count + ( $words_per_minute / 2 ) ) / $words_per_minute );
		if ( $word_count < $words_per_minute ) {
		echo $read_time, ' min read';
	}
	else {
		echo $read_time, ' min read';
	}
}

// Get just the bottom level category, by adding array 1, we're excluding the uncategorized category
function custom_category( $id, $taxonomy, $exclude = array()) {
	
	// if no taxonomy then it is a default category
	if(!isset($taxonomy)) {
		$taxonomy = 'category';
	}
	
	// get terms
	$terms = get_the_terms($id, $taxonomy);
	
	// check input
	if ( empty($terms) || is_wp_error($terms) || !is_array($terms) ) return;
	
	// exclude things uncategorized 
	foreach ($terms as $key=>$term) {
		if (in_array($key, $exclude)) {		// key in term_array is also term_id..
			unset($terms[$key]);
			//break;
		}
	}
	
	foreach ($terms as $key=>$term) {
		$parent_term = $term;			// gets last parent (should we get only the first one?)
		if ($term->parent != 0) {		// if there is a child, find it
			$child_term = $term;		// get the child term...
			
			// default category name
			$child_name = $term->name;
			
			$parent_term = get_term_by('id', $term->parent, $taxonomy);		// ... and the parent term
			$parent_name = $parent_term->name;
			break;
			
		}elseif ($term->parent = 1) { //if there is no parent/child relationship, just do the parent_term
		
			$single_term = $term;		// get the child term...
			$single_name = $single_term->name;
		}
	}

	// show the sub-category term first if it is set
		if (isset($child_term)) {
			// remove categories from the URL and replace with category
			$link = get_term_link($child_term, $taxonomy);
			
			echo '<a href="'.$link.'" rel="tag" class="category_link alt_2" title="See all stories from '.$child_name.'">'.$child_name.'</a>';
		}
	// if no sub-category is connected, just show the single parent category
		if (isset($single_name) && !isset($parent_name)) {
			$link = get_term_link($parent_term, $taxonomy);
			
			echo '<a href="'.$link.'" rel="tag" class="category_link alt_2" title="See all stories from '.$single_name.'">'.$single_name.'</a>';
		}
}

// check if page has children - https://gist.github.com/lukaszklis/1247306
function has_children() {
	global $post;
	$children = get_pages('child_of=' . $post->ID);
	if( count( $children ) != 0 ) { return true; } // Has Children
    else { return false; } // No children
}


// Convert wp_list_pages to a get so it can use cache
// http://www.thinkplexx.com/blog/change-wp_list_pages-function-in-wordpress-so-that-it-returns-the-data
function wp_get_pages($args = '') {
	if ( is_array($args) )
		$r =  &$args;
	else
		parse_str($args, $r);

	$defaults = array('depth' => 0, 'show_date' => '', 'date_format' => get_option('date_format'),
		'child_of' => 0, 'exclude' => "", 'title_li' => __('Pages'), 'echo' => 1, 'authors' => '', 'sort_column' => 'menu_order, post_title');
	$r = array_merge($defaults, $r);

	$output = '';
	$current_page = 0;

	// sanitize, mostly to keep spaces out
	$r['exclude'] = preg_replace('[^0-9,]', '', $r['exclude']);

	// Allow plugins to filter an array of excluded pages
	$r['exclude'] = implode(',', apply_filters('wp_list_pages_excludes', explode(',', $r['exclude'])));

	// Query pages.
	$pages = get_pages($r);

	return $pages;
}

// Set up walkers for wp_list_pages, so I can show the short_name custom field if it exists http://www.456bereastreet.com/archive/201101/cleaner_html_from_the_wordpress_wp_list_pages_function/
class Short_Name_Walker extends Walker_Page {
    function start_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul>\n";
    }
    function start_el(&$output, $page, $depth, $args, $current_page) {
        //Get the short_title if it is there
        if(get_field('short_title', $page->ID)) : 
			$title = get_field('short_title', $page->ID); 
		else: 
			$title = $page->post_title;
		endif;
        
        if ( $depth )
            $indent = str_repeat("\t", $depth);
        else
            $indent = '';
        extract($args, EXTR_SKIP);
        $class_attr = '';
        if ( !empty($current_page) ) {
            $_current_page = get_page( $current_page );
            if ( (isset($_current_page->ancestors) && in_array($page->ID, (array) $_current_page->ancestors)) || ( $page->ID == $current_page ) || ( $_current_page && $page->ID == $_current_page->post_parent ) ) {
                $class_attr = 'sel';
            }
        } elseif ( (is_single() || is_archive()) && ($page->ID == get_option('page_for_posts')) ) {
            $class_attr = 'sel';
        }
        if ( $class_attr != '' ) {
            $class_attr = ' class="' . $class_attr . '"';
            $link_before .= '<strong>';
            $link_after = '</strong>' . $link_after;
        }
        $output .= $indent . '<li' . $class_attr . '><a href="' . get_page_link($page->ID) . '"' . $class_attr . '>' . $link_before . apply_filters( 'the_title', $title, $page->ID ) . $link_after . '</a> |</li>';

        if ( !empty($show_date) ) {
            if ( 'modified' == $show_date )
                $time = $page->post_modified;
            else
                $time = $page->post_date;
            $output .= " " . mysql2date($date_format, $time);
        }
    }
}

////////////* SEARCH *//////////////
function search_results_title() {
	if( is_search() ) {
 
		global $wp_query;
 
		if( $wp_query->post_count == 1 ) {
			$result_title .= 'Search Results for &ldquo;<span class="red">' . wp_specialchars($wp_query->query_vars['s'], 1) . '</span>&rdquo; - 1 result';
		} else {
			$result_title .= 'Search Results for &ldquo;<span class="red">' . wp_specialchars($wp_query->query_vars['s'], 1) . '</span>&rdquo; - ' . $wp_query->found_posts . ' results';
		}
 
		
 
		echo $result_title;
 
	}
} 

////////////* IMAGES *//////////////

// Filter image insertion of images via the editor into content, by adding HTML5 tags and adding the fresco link
function html5_insert_image($html, $id, $caption, $title, $align, $url, $size) {

	$full = wp_get_attachment_image_src( $id, 'full', false, false );
	$thumbnail = wp_get_attachment_image_src( $id, 'thumbnail', false, false );
	
	$image_meta = wp_get_attachment($id);
	
	// Remove quote marks
	$quote_array = array('”', '“', '"');
	$replace_array = array("'", "'", "'");
	//$caption = $image_meta['caption'];
	$alt = $image_meta['alt'];
	$caption_clean = str_replace($quote_array, $replace_array, $caption);
	$image_url = wp_get_attachment_image_src( $id, $size, false, false );
	
	if($size == 'large-16x9' || $size == 'large-24x1') :
		$figcaption_class = 'tab_4 desk_b_6 desk_a_8 margin_auto';
		$figcaption_padding_open = '<div class="padding_block">';
		$figcaption_padding_close = '</div>';
		$double_single_block = 'double_single_block';
	endif;
	
	$custom_insert = "<figure id='post-$id media-$id' class='align_$align inline_image $size $double_single_block'>";
	$custom_insert .= '<a class="fresco" data-fresco-group="single-group" data-fresco-group-options="ui:\'inside\'" data-fresco-caption="'.$caption_clean.$credit.'" href="'.$full[0].'">';
	$custom_insert .= "<img src='$image_url[0]' alt='$alt' class='size-".$size."' />";
	if ($caption_clean || $credit) {
		$custom_insert .= "</a><figcaption class='".$figcaption_class."'>".$figcaption_padding_open.$caption_clean.$figcaption_padding_close."</figcaption>";
	} else {
		$custom_insert .= "</a>";
	}
	$custom_insert .= "</figure>";
	return str_replace('<br>', "", $custom_insert); // <br> inserted by WP
}
add_filter( 'image_send_to_editor', 'html5_insert_image', 10, 9 );

////////////* Post specific functions *//////////////

/* Function to change the_excerpt - https://graphpaperpress.com/blog/tip-how-to-change-the-default-wordpress-excerpt/ */
function my_excerpt($text) {
	return str_replace('[...]', '...', $text);
}

add_filter('the_excerpt', 'my_excerpt'); 

// Add a class to just the first paragraph
function first_paragraph($content){
	if(is_single()):
		return preg_replace('/<p([^>]+)?>/', '<p$1 class="alt">', $content, 1);
	else:
		return $content;
	endif;
}
add_filter('the_content', 'first_paragraph');

//// Inserting articles/pages
// refer - http://www.maketecheasier.com/insert-ads-in-between-content-in-wordpress/

//Insert related articles after third (it says 2 below, but that doesn't include intro paragraph) paragraph of single post content.
add_filter('the_content', 'add_incontent_related_articles_pages');
function add_incontent_related_articles_pages($content) {	
	if(is_single()){
		global $post;
		
		// Insert related articles
		$articles = get_field('related_articles', $post->ID);
		if( $articles ): 
			foreach( $articles as $article ): // variable must NOT be called $post (IMPORTANT)
			    $article_list .= '<li><a href="'.get_permalink( $article ).'">'.get_the_title($article).'</a></li>';
			endforeach;
		endif;
		
		// Insert related page/service
		$pages = get_field('related_pages', $post->ID);
		if( $pages ): 
			foreach( $pages as $page ): // variable must NOT be called $post (IMPORTANT)
				if(get_field('short_title', $page)):
					$the_title = get_field('short_title', $page);
				else:
					$the_title = get_the_title($page);
				endif;
			    $page_button .= '<a href="'.get_permalink( $page ).'" class="button big_button"><span class="button_text">'.$the_title.'</span></a>';
			endforeach;
		endif;
		
		$content_block = explode('<p>',$content);
		// articles
		if(!empty($content_block[2]) && $articles) {	
			$content_block[2] .= '<aside class="inline_meta inline_meta_right">
				<h2 class="alt">Related articles</h2>
				<ul>'.$article_list.'</ul>
			</aside>';
		}
		// pages
		if(!empty($content_block[8]) && $pages) {	
			$content_block[8] .= '<div class="inline_meta_2"><h2 class="alt">Related Services</h2>'.$page_button.'</div>';
		}
		
		for($i=1;$i<count($content_block);$i++) {
			$content_block[$i] = '<p>'.$content_block[$i];
		}
		$content = implode('',$content_block);
	} //end is_single
	
	if(is_page()){
		global $post;
				
		$contact = get_field('contact_action_box', $post->ID);
		$date_box = get_field('date_box');
		$price_box = get_field('price_box');
		
		
		if(in_array( 'true', $contact) && !($date_box || $price_box)):
			$page_button = '<a href="'.home_url().'/contact" class="big_button"><span class="button_text">Get in Contact</span></a>';
		
			$content_block = explode('<p>',$content);
			$content_count = count($content_block);
			$content_count_3rd_last = $content_count-3;
			$content_count_5th_last = $content_count-5;
			
			$count_content_block = count($content_block);
					
			// contact
			if(!empty($content_block[$content_count_3rd_last])) {	
				$content_block[$content_count_3rd_last] .= '<div class="inline_meta_right">'.$page_button.'</div>';
			} else {
				$content_block[$content_count_5th_last] .= '<div>'.$page_button.'</div>';
			}
			
			for($i=1;$i<$content_count;$i++) {
				$content_block[$i] = '<p>'.$content_block[$i];
			}
			$content = implode('',$content_block);
		
		endif;
	}
	return $content;	
}


// Filter images in the content to pull them out of the main div so they bleed full width
function filter_images($content) {
	$html = new simple_html_dom();
	$html->load($content);
	
	// Look for the large-16x9
	foreach($html->find('figure[class=large-16x9], figure[class=large-24x1') as $find_img):
		//$find_img->innertext = 'double_single_block';
		$find_img->outertext = '</div></div></div>' . $find_img->outertext . '<div class="main_content"><div class="tab_4 desk_b_6 desk_a_8 margin_auto single_block"><div class="padding_block content_styles">'; 
				
	endforeach;
	
	$content = $html->save();
	
	return $content;
}
add_filter('the_content', 'filter_images');


// Filter images in the content to pull them out of the main div so they bleed full width
function filter_blockquote($content){
	$search = '/<blockquote>(.*?)<\/blockquote>/';
	
	//This is for large size image
	$replace = '</div></div><blockquote class="tab_6 desk_b_7 desk_a_10 margin_auto"><div class="padding_block">$1</div></blockquote><div class="tab_5 desk_b_6 desk_a_8 margin_auto single_block"><div class="padding_block">';
	
    return preg_replace($search, $replace, $content);
}
add_filter('the_content', 'filter_blockquote');

////////////* Comment function for styling the specific comments *//////////////

function advanced_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<dt <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<div class="avatar mob_1 tab_1 desk_b_1 desk_a_1 col_gutter">
			<?php echo get_avatar($comment,$size='64',$default='<path_to_url>' ); ?>
		</div>
		<div class="comment_meta">
			<span class="comment_author"><a href="<?php the_author_meta( 'user_url'); ?>"><?php printf(__('%s'), get_comment_author_link()) ?></a></span>
			<small><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?> / <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?><?php edit_comment_link(__('(Edit)'),'  ','') ?></small>
		</div>
		<div class="clearfix"></div>
	</dt>
	<dd>
		<?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.'); ?></em>
		<?php endif; 
		
		comment_text(); ?>
	</dd>
<?php }

// Get just the bottom level category, by adding array 1, we're excluding the uncategorized category
function custom_category_name( $id, $taxonomy, $exclude = array(1)) {
	
	// if no taxonomy then it is a default category
	if(!isset($taxonomy)) {
		$taxonomy = 'category';
	}
	
	// get terms
	$terms = get_the_terms($id, $taxonomy);
	
	// check input
	if ( empty($terms) || is_wp_error($terms) || !is_array($terms) ) return;
	
	// exclude things uncategorized 
	foreach ($terms as $key=>$term) {
		if (in_array($key, $exclude)) {		// key in term_array is also term_id..
			unset($terms[$key]);
			//break;
		}
	}
	
	foreach ($terms as $key=>$term) {
		$parent_term = $term;			// gets last parent (should we get only the first one?)
		if ($term->parent != 0) {		// if there is a child, find it
			$child_term = $term;		// get the child term...
			
			if (get_field('singular_name', $taxonomy . '_'. $term->term_id)) {
				//Get the name of category set by ACF
				$child_name = get_field('singular_name', $taxonomy . '_'. $term->term_id); 
			} else {
				//if the acf field is not set, default back to the category name
				$child_name = $term->name;
			}
			
			$parent_term = get_term_by('id', $term->parent, $taxonomy);		// ... and the parent term
			if (get_field('singular_name', $taxonomy . '_'. $term->term_id)) {
				//Get the name of category set by ACF
				$parent_name = get_field('singular_name', $taxonomy . '_'. $parent_term->term_id); 
			} else {
				//if the acf field is not set, default back to the category name
				$parent_name = $parent_term->name;
			}
			
			break;
			
		}elseif ($term->parent = 1) { //if there is no parent/child relationship, just do the parent_term
		
			$single_term = $term;		// get the child term...
			$single_name = get_field('singular_name', $taxonomy . '_'. $parent_term->term_id); //Get the name of category set by ACF
			// If nothing is set in the ACF field, defaut back to the default back to the default category name
			if (empty($single_name)) {
				$single_name = $parent_term->name;
			}
		}
	}

	// show the sub-category term first if it is set
		if (isset($child_term)) {
			return $child_name;
		}
	// if no sub-category is connected, just show the single parent category
		if (isset($single_name) && !isset($parent_name)) {
			return $single_name;
		}
}

function wp_infinitepaginate(){
	$loopFile        = $_POST['loop_file'];
	$paged           = $_POST['page_no'];
	$posts_per_page  = get_option('posts_per_page');
	
	$do_not_duplicate = array();
	
	# Load the posts
	$args = array(
		'paged' => $paged, 
		'post_status' => 'publish',
		'posts_per_page' => 12,
		'post_type' => 'post',
		'ignore_sticky_posts' => 1,
		'post__not_in' => $do_not_duplicate
	);
	
	$query = null;
					
	$key = 'single-ajax-'.$paged;
										
	//$query = get_transient( $key );
						
	if ( $query == '' ) {
	    $query = new WP_query( $args );
		set_transient( $key, $query, $expire = 60 * 60 * 168 );
	}
										
	if($query):
		$counter = 1;
		$three_row_col_gutter = 'tab_col_gutter desk_b_col_gutter';
		$four_row_col_gutter = 'desk_a_col_gutter';
		
		while ($query->have_posts()) : $query->the_post();
			
			//For 3 items per row
			if(!($counter % 3 == 0)):
				$three_row_col_gutter = 'tab_col_gutter';
			else:
				$three_row_col_gutter = '';
			endif;
			
			//For 4 items per row
			if(!($counter % 4 == 0)):
				$four_row_col_gutter = 'desk_b_col_gutter desk_a_col_gutter';
			else:
				$four_row_col_gutter = '';
			endif;
			
			$do_not_duplicate[] = $post->ID;
			
			$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium-24x1');  ?>
			
			<article class="tab_2 desk_b_2 desk_a_3 content_styles single_block <?php echo $three_row_col_gutter.' '.$four_row_col_gutter; ?>" role="article">
				<?php if (!($thumbnail == NULL)) {?>
					<figure>
						<img src="<?php echo $thumbnail[0]; ?>" alt="<?php the_title(); ?>"/>
					</figure>
				<?php } ?>
				<div class="padding_block">
					<header>
						<h3 class="category_title"><?php echo custom_category($post->ID, $taxonomy); ?></h3>
						<h1 class="alt_2">
							<a href="<?php the_permalink(); ?>" title="Continue reading about <?php the_title(); ?>">
								<?php the_title(); ?>
							</a>
						</h1>
					</header>
				</div> <!-- padding_block -->
			</article>
			
			<?php if((!($counter == 1)) && ($counter % 3 == 0)): echo '<div class="tab_clearfix"></div>'; endif;
			if((!($counter == 1)) && ($counter % 4 == 0)): echo '<div class="desk_clearfix"></div>'; endif;
			$counter++;
		endwhile;
		echo '<div class="clearfix"></div>';
	else :
		echo '<small>Sorry there are currently no new articles</small>';
	endif; 
	wp_reset_query();
	
	exit;
}

add_action('wp_ajax_infinite_scroll', 'wp_infinitepaginate');           // for logged in user
add_action('wp_ajax_nopriv_infinite_scroll', 'wp_infinitepaginate');    // if user not logged in ?>