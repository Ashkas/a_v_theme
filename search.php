<?php
/**
 * Search Template
 *
 * The search template is loaded when a visitor uses the search form to search for something
 * on the site.
 */

get_header(); // Loads the header.php template. 

//Global variables
$home_url = home_url();

?>

<section role="main" class="main" id="page">
	<div class="main_content">
		<header class="padding_block">
			<div class="margin_auto margin_bottom tab_5 desk_6 desk_large_8">
				<h1 class="page_title centre_text margin_bottom">Search results</h1>
				<h3 class="alt centre_text"><?php search_results_title(); ?></h3>
			</div> <!-- page_title_block margin_bottom tab_5 desk_6 desk_large_10 -->
			<div class="clearfix"></div>
		</header>
		
		<?php //get_sidebar();
		
		//$query = query_posts("$query_string . '&posts_per_page=6&orderby=DESC'"); 
		
		if ( have_posts()) : 
			echo '<div class="tab_5 desk_6 desk_large_8 margin_auto">';
				while (have_posts()) : the_post();
					get_template_part( 'loop-archive' ); // Loads the loop-archive.php template.
		 		endwhile;
		 		
		 		// Pagination
				search_nav();
	 		echo '</div>';
	 		
	 		echo '<div class="tab_5 desk_6 desk_large_8 margin_auto">';
		 		get_search_form(); // Loads the searchform.php template.
		 	echo '</div>';
		else :
			echo '<div class="margin_auto tab_5 desk_6 desk_large_10">';
				get_template_part( 'loop-error' ); // Loads the loop-error.php template.
				
	 		echo '</div>';
		endif; ?>
		<div class="clearfix"></div>
	</div>
</section>

<?php get_footer(); // Loads the footer.php template. ?>