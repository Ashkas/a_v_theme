<?php
/**
 * Template Name: Blog Page
 *
 * A custom page template for displaying the site's news, call for papers and scholarships. Is based off an archive.
 *
*/

get_header(); // Loads the header.php template.

// Global variables
$expire = 60 * 60 * 168; // 168 hours
$group = 'blog';
?>

<section role="main" class="main" id="page">
	<div class="main_content">

		<?php
		
		if ( have_posts() ) : while ( have_posts() ) : the_post();
			get_template_part( 'loop-title' ); // Loads the loop-title.php template.
		endwhile; endif;
		
		// Pagination
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
		// this prevents duplication
		$do_not_duplicate = array();
		
		/* Get all sticky posts */
		$sticky = get_option( 'sticky_posts' );
		$args = array(
			'posts_per_page' => 1,
			'post_type' => 'post',
			'post_status' => 'publish',	
			'order' => 'DESC',
			'post__not_in' => $do_not_duplicate,
			'post__in' => $sticky,			
		);
		
		$key = 'blog-articles-sticky';
		
		$query = wp_cache_get( $key, $group );
		
		if ( $query == '' ) {
		    $query = get_posts( $args );
			wp_cache_set( $key, $query, $group, $expire );
		}
		
		if($query):
			foreach( $query as $post ) : setup_postdata($post);
			$do_not_duplicate[] = $post->ID;
			
				get_template_part( 'loop-archive' ); // Loads the loop-home-posts.php template.
				
			endforeach;								
		endif; 
		wp_reset_postdata();
		
		/* Get the non-sticky posts */
		$args = array(
			'posts_per_page' => 6,
			'post_type' => 'post',
			'post_status' => 'publish',	
			'paged' => $paged,
			'order' => 'DESC',
			'ignore_sticky_posts' => 1,
			'post__not_in' => $do_not_duplicate,
			
		);
		
		$key = 'blog-articles-'.$paged;
		
		$query = wp_cache_get( $key, $group );
		
		if ( $query == '' ) {
		    $query = get_posts( $args );
			wp_cache_set( $key, $query, $group, $expire );
		}
										
		if($query):
			foreach( $query as $post ) : setup_postdata($post);
			$do_not_duplicate[] = $post->ID;
			
				//get_template_part( 'loop-archive' ); // Loads the loop-home-posts.php template.
				
			endforeach;
		else :
			echo '<div class="padding_block"><small>Sorry there are currently no new articles</small></div>';
		endif; 
		wp_reset_postdata();
		edit_post_link('Edit this entry.', '<p>', '</p>'); 
		?>
	</div> <!-- main_content -->
</section> <!-- role="main" -->

<?php get_footer(); // Loads the footer.php template. ?>