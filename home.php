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
		<?php $slides = get_field('home_slides', 'option'); 
			
		if($slides):?>
			<div class="flexslider home_slider loading double_single_block margin_auto">
				<ul class="slides">
					<?php while ( has_sub_field('home_slides', 'option' )) :
						$text = get_sub_field('slide_text');
						$image_id = get_sub_field('image');
						$image = wp_get_attachment_image_src($image_id, 'large-24x1');
						$action_text = 	get_sub_field('action_text');		
						$action_link = get_sub_field('link'); 		
						
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
					endwhile; wp_reset_postdata();?>
	             </ul>
			</div>
		<?php endif; ?>
		<div class="main">
			<div class="main_content">
				<div class="padding_block double_single_block">
					<?php 
					
					if( have_rows('home_action_buttons', 'options') ):
						
					 	echo '<div class="grid_buttons_alt">';
					 	
						 	// loop through the rows of data
						    while ( have_rows('home_action_buttons', 'options') ) : the_row();
						    	
						    	$the_title = get_sub_field('text');
						    	$get_permalink = get_sub_field('link');
						    	$icons = get_sub_field('icons');
						    						    	
						    	if( strpos( $icons, 'star' ) !== false ) {
							    	$icon = '<span class="icon-star"></span>';
						    	}
						    	
						    	if( strpos( $icons, 'pencil' ) !== false ) {
							    	$icon = '<span class="icon-pencil"></span>';
						    	}
						    	
						    	if( strpos( $icons, 'info' ) !== false ) {
							    	$icon = '<span class="icon-info"></span>';
						    	}
						    	
						    	if( strpos( $icons, 'help' ) !== false ) {
							    	$icon = '<span class="icon-help"></span>';
						    	}
						    	
						    	if( strpos( $icons, 'bolt' ) !== false ) {
							    	$icon = '<span class="icon-bolt"></span>';
							    	
						    	}
						    	
						    	if( strpos( $icons, 'pictures' ) !== false ) {
							    	$icon = '<span class="icon-pictures"></span>';
							    	
						    	}
						    	if( strpos( $icons, 'video' ) !== false ) {
							    	$icon = '<span class="icon-video"></span>';
							    	
						    	}
						    	 ?>
						    	
						    	<a href="<?php echo $get_permalink; ?>" title="Find out about <?php echo $the_title; ?>" class="grid_item services">		
									<h3><?php echo $icon.' '.$the_title; ?></h3>
								</a>
								
							    <?php unset($icon, $icons);
							    
							endwhile;
						echo '</div>';
					endif; ?>
				</div> <!-- double_single_block -->
				
				<div class="content_styles">
					<section class="desk_6 desk_large_8 margin_auto module single_block">
						<header class="padding_block double_single_block">
							<h1 class="centre_text"><a href="<?php echo $home_url; ?>/blog" title="Articles by Skattle" class="alt">Latest Articles</a></h1>
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