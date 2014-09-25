<?php
/**
 * Archive Template
 *
 * The archive template is the default template used for archives pages without a more specific template. 
 *
 */

get_header(); // Loads the header.php template.

// Pagination
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

global $wp_query;
$term = $wp_query->queried_object;?>

<section role="main" class="main" id="page">
	<div class="main_content">
		
		<div class="padding_block">
			<div class="tab_4 desk_6 desk_large_8 margin_auto double_single_block double_margin_top">
				<header>
					<h1 class="page_title centre_text single_block">
						<?php
							if ( is_day() ) :
								printf( __( 'Daily Archives: %s', 'a_v' ), get_the_date() );
	
							elseif ( is_month() ) :
								printf( __( 'Monthly Archives: %s', 'a_v' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'a_v' ) ) );
	
							elseif ( is_year() ) :
								printf( __( 'Yearly Archives: %s', 'a_v' ), get_the_date( _x( 'Y', 'yearly archives date format', 'a_v' ) ) );
	
							else :
								echo $term->name;
							endif;
						?>
					</h1>
				</header>
			</div> <!-- tab_4 desk_6 desk_large_8 margin_auto single_block -->
		</div> <!-- padding_block -->
		
		<?php
		
		get_sidebar();
		
		// this prevents duplication
		$do_not_duplicate = array();
		
		$args = array(
			'posts_per_page' => 5,
			'paged' => $paged,
			'category_name' => $term->slug,
		);
		
		$query = null;
		
		$query = new WP_query($args);
		
		// this prevents duplication
		$do_not_duplicate = array();
		
		/* Get all sticky posts */
		$sticky = get_option( 'sticky_posts' );
		$args = array(
			'posts_per_page' => 1,
			'post_type' => 'post',
			'post_status' => 'publish',	
			'order' => 'DESC',
			'category_name' => $term->slug,
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
			echo '<div class="tab_5 desk_6 desk_large_8 margin_auto">';
				foreach( $query as $post ) : setup_postdata($post);
				$do_not_duplicate[] = $post->ID;
				
					get_template_part( 'loop-archive' ); // Loads the loop-home-posts.php template.
					
				endforeach;		
			echo '</div>';						
		endif; 
		wp_reset_postdata();
		
		/* Get the non-sticky posts */
		$args = array(
			'posts_per_page' => 6,
			'post_type' => 'post',
			'post_status' => 'publish',	
			'paged' => $paged,
			'category_name' => $term->slug,
			'order' => 'DESC',
			'ignore_sticky_posts' => 1,
			'post__not_in' => $do_not_duplicate,
			
		);
		
		$key = 'articles-'.$term->term_id.'-'.$paged;
		
		$query = get_transient( $key );
		
		if ( $query == '' ) {
		    $query = new WP_query($args);
			set_transient( $key, $query, $expire ); 
		}
		 
		if ( $query->have_posts()) : 
			echo '<div class="tab_5 desk_6 desk_large_8 margin_auto">';
				while ($query->have_posts()) : $query->the_post();
					get_template_part( 'loop-archive' ); // Loads the loop-archive.php template.
		 		endwhile;
		 		
		 		// Pagination
				if (function_exists("content_nav")) {
					echo '<div class="padding_block">';
						content_nav($query->max_num_pages);
					echo '</div>';
				}
	 		echo '</div>';
		elseif(!$query || !$sticky) :
			echo '<div class="margin_auto tab_5 desk_6 desk_large_10">';
				get_template_part( 'loop-error' ); // Loads the loop-error.php template.
				
	 		echo '</div>';
		endif; 
		
		wp_reset_query();
		
		include("sidebar_2.php");
		
		?>
		<div class="clearfix"></div>
	</div> <!-- main_content -->
</section> <!-- role="main" -->

<?php get_footer(); // Loads the footer.php template. ?>