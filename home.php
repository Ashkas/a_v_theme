<?php
/**
 * Home Template
 *
*/

get_header(); // Loads the header.php template.

// Reusable variables
$home_url = home_url();
$expire = 60 * 60 * 168; // 168 hours
$group = 'home'; ?>

	<section role="main" id="page">
		<?php 
		
		if(function_exists('get_field')) {
			$slides = get_field('home_slides', 'option'); 
		}
			
		if($slides):?>
			<div class="flexslider home_slider loading large_block margin_auto">
				<ul class="slides">
					<?php if(function_exists('has_sub_field')) :
						while ( has_sub_field('home_slides', 'option' )) :
							if(function_exists('get_sub_field')) {
								$text = get_sub_field('slide_text');
								$image_id = get_sub_field('image');
								$image = wp_get_attachment_image_src($image_id, 'large-24x1');
								$action_text = 	get_sub_field('action_text');		
								$action_link = get_sub_field('link'); 		
							}
							if($image) : ?>
								<li>
									<article>
										<figure class="slide_image">
											<img src="<?php echo $image[0]; ?>" alt="<?php echo $title; ?>"/>
										</figure>
										<div class="slide_text_box large_device">
											<div class="slide_text">
												<?php if($text): ?>
													<p><?php echo $text; ?></p>
												<?php endif; ?>
											</div>
										</div>
										<?php if($action_text && $action_link): ?>
											<a href="<?php echo $action_link; ?>" title="<?php echo $action_text; ?>" class="centre_float button">
												<?php echo $action_text; ?>
											</a>
										<?php endif; ?>
									</article>
								</li>
							<?php endif;
						endwhile; 
					endif;
					wp_reset_postdata();?>
	             </ul>
			</div>
		<?php endif; ?>
		<div class="main">
			<div class="main_content">
				
				<div class="content">
					<section class="desk_6 desk_large_8 margin_auto module block">
						<header class="padding_block large_block">
							<h1 class="centre_text"><a href="<?php echo $home_url; ?>/blog" title="Latest Articles" class="alt">Latest Articles</a></h1>
						</header>
						<div class="large_outline_right">
							<?php 
							// this prevents duplication
							$do_not_duplicate = array();
							
							/* Get all sticky posts */
							$sticky = get_option( 'sticky_posts' );
							$args = array(
								'posts_per_page' => 1,
								'post_type' => 'post',
								'post_status' => 'publish',	
								'order' => 'DESC',
								'ignore_sticky_posts' => 1,
								'post__not_in' => $do_not_duplicate,
								'post__in' => $sticky,
								'caller_get_posts' => 1
								
							);
							
							$key = 'home-articles-sticky';
							
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
								'posts_per_page' => 3,
								'post_type' => 'post',
								'post_status' => 'publish',	
								'order' => 'DESC',
								'ignore_sticky_posts' => 1,
								'post__not_in' => $do_not_duplicate,
								
							);
							
							$key = 'home-articles-non-sticky';
							
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
							else :
								echo '<div class="padding_block"><small>Sorry there are currently no new articles</small></div>';
							endif; 
							wp_reset_postdata(); ?>
							<div class="clearfix"></div>
						</div>
					</section> <!-- tab_3 desk_4 desk_large_6 large_col_gutter -->
					
					<div class="clearfix"></div>
				</div> <!-- content_styles -->
				
			</div> <!-- main_content -->
		</div> <!-- main -->
	</section> 

<?php get_footer(); // Loads the footer.php template. ?>