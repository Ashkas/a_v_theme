<?php
/**
 * Tag Template
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
						Tag: <?php  echo $term->name; ?>
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
			'tag' => $term->slug,
		);
		
		$query = null;
		
		$query = new WP_query($args);
		 
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
		else :
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