<?php
/**
 * Page Template
 *
*/

get_header(); // Loads the header.php template.

//Global Variables
$group = 'page'; ?>
	<article role="main" class="main" id="page">
		<div class="main_content">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); global $post; ?>
				<header class="padding_block">
					<div class="margin_auto margin_bottom tab_5 desk_6 desk_large_10">
						<h1 class="page_title centre_text margin_bottom"><?php the_title(); ?></h1>
					</div> <!-- page_title_block margin_bottom tab_5 desk_6 desk_large_10 -->
					<?php get_sidebar(); ?>
					<div class="clearfix"></div>
				</header>
				<?php get_template_part( 'loop-page' ); // Loads the loop-page.php template.
				
			endwhile; endif; ?>
		</div>
	</article>
<?php get_footer(); // Loads the footer.php template. ?>