<?php
/**
 * 404 Template
 *
 * The 404 template is used when a reader visits an invalid URL on your site. By default, the template will 
 * display a generic message.
 *
 */

@header( 'HTTP/1.1 404 Not found', true, 404 );

get_header(); // Loads the header.php template. ?>

	<section role="main" class="main" id="page">
		<div class="main_content">
			<div class="tab_4 desk_6 desk_large_8 margin_auto double_single_block double_margin_top">
				<div class="padding_block">
				<header>
					<h1 class="page_title">Page not found</h1>
				</header>
				</div> <!-- padding_block -->
			</div> <!-- tab_4 desk_6 desk_large_8 margin_auto single_block -->
			
			<div class="tab_4 desk_6 desk_large_8 margin_auto single_block">
				<div class="padding_block">
					<p class="double_single_block"><?php _e( "Sorry the page you're looking for does not seem to exist. Please check the address or use the search form below", "a_v" ); ?></p>
				

					<?php get_search_form(); // Loads the searchform.php template. ?>
				</div> <!-- padding_block -->
			</div> <!-- tab_4 desk_6 desk_large_8 margin_auto -->
		</div> <!-- main_content -->
	</section>

<?php get_footer(); // Loads the footer.php template. ?>