<?php
/**
 * Attachment Template
 *
 * This is the default attachment template.  It is used when visiting the singular view of a post attachment 
 * page (images, videos, audio, etc.).
 *
 */

get_header(); // Loads the header.php template. ?>

	<article role="main" class="main" id="page">
		<div class="main_content">

			<?php if ( have_posts() ) :
			
				while ( have_posts() ) : the_post(); ?>

					<header class="padding_block">
						<div class="margin_auto margin_bottom tab_5 desk_6 desk_large_10">
							<h1 class="page_title centre_text margin_bottom"><?php the_title(); ?></h1>
						</div> <!-- page_title_block margin_bottom tab_5 desk_6 desk_large_10 -->
						<?php get_sidebar(); ?>
						<div class="clearfix"></div>
					</header>

					<div class="entry-content">
						<?php if ( wp_attachment_is_image( get_the_ID() ) ) : ?>

							<figure class="inline_image">
							<?php echo wp_get_attachment_image( get_the_ID(), 'full', false, array( 'class' => 'aligncenter' ) ); ?>
							</figure>

						<?php else : ?>

							<p class="download">
								<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php the_title_attribute(); ?>" rel="enclosure" type="<?php echo get_post_mime_type(); ?>"><?php printf( __( 'Download &quot;%1$s&quot;', '' ), the_title( '<span class="fn">', '</span>', false) ); ?></a>
							</p><!-- .download -->

						<?php endif; ?>

						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', '' ) ); ?>
					</div><!-- .entry-content -->
						
				<?php endwhile;
			endif; wp_reset_postdata(); ?>
		</div><!-- .main_content -->
	</article>

<?php get_footer(); // Loads the footer.php template. ?>