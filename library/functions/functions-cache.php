<?php
/* Transient Cache */

/* clear transient cache for post on update */
function a_v_clear_transients_post() {
	if($_POST[post_type] == 'post') {
	// home page
	//wp_cache_delete('home-articles-sticky', 'home');
	//wp_cache_delete('home-articles-non-sticky', 'home');
	
	//Blog
	//wp_cache_delete('blog-articles-sticky', 'blog');
	//wp_cache_delete('blog-articles-', 'blog');

	}
}
add_action('save_post','a_v_clear_transients_post');


// Default archive cache deletion
function delete_taxonomy_archive_cache() {

	global $post;
	
	$twenty = 20;
	
	$taxonomies_attached = get_object_taxonomies( $post );
	foreach($taxonomies_attached as $taxonomy_attached):
		$terms = get_the_terms($post->ID, $taxonomy_attached);
		foreach($terms as $term) :
			
			//taxonomies
			delete_transient('articles-'.$term->term_id);
			
			// paginated cache
			for ($cache_counter = 1 ; $cache_counter < $twenty; $cache_counter++){ 
				//default taxonomy
				delete_transient('articles-'.$term->term_id.'-'.$cache_counter);
			}
			
		endforeach;
	endforeach;
	
	$key = 'author-'.$post->post_author;
	
	// Affect all post types - home
	delete_transient($key);
}
add_action( 'save_post', 'delete_taxonomy_archive_cache' );


/* clear transient cache for page on update */
function a_v_clear_page_caches() {
	if($_POST[post_type] == 'page') {
		
		$key = 'related-pages-'.$post->ID;
	
		wp_cache_delete($key, 'page');
	
	}
}
add_action('save_post','a_v_clear_page_caches');

?>