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
				
				//Work out what level page this is
				$parent = $post->post_parent;
				
				if($parent):
					$grandparent_get = get_post($parent);
					$has_grandparent = $grandparent_get->post_parent;
					
					if(has_children()):
						$middle = true;
					endif;	
				endif;
				
				if($has_grandparent):
					$children = get_field('show_children', $parent);
					$show_children_title = get_field('show_children_title', $parent);
					$post_id = $parent;
				elseif(!($has_grandparent || $middle) && $parent):
					$children = get_field('show_children', $parent);
					$show_children_title = get_field('show_children_title', $parent);
					$post_id = $parent;
				elseif($middle == true):
					$children = get_field('show_children');
					$show_children_title = get_field('show_children_title');
					$post_id = $post->ID;
				else:
					$children = get_field('show_children');
					$show_children_title = get_field('show_children_title');
					$post_id = $post->ID;
				endif;
				
				// If children with images
				if( $children == 'true_image' ): ?>
					<section class="large_block">
						<?php if($show_children_title): echo '<header class="padding_block block"><h1 class="alt">'.$show_children_title.'</h1></header>'; endif; ?>
						<div class="grid">
							<?php $args = array(
								'child_of' => $post_id,
								'post_type' => 'page',
								'post_status' => 'publish',
								'meta_query' => array(
									array(
							            'key' => '_thumbnail_id',
							        ) // Force just stories with featured image
								),
							);
								
							$query = null;
										
							$key = 'related-pages-'.$post->ID;
																
							$query = wp_cache_get( $key, $group );
										
							if ( $query == '' ) {
							    $query = get_pages( $args );
								wp_cache_set( $key, $query, $group, $expire );
							}
															
							if($query):
								$counter = 1;
								$two_row_col_gutter = 'tab_col_gutter desk_col_gutter';
								$four_row_col_gutter = 'desk_large_col_gutter';
								
								foreach( $query as $post ) : setup_postdata($post);
									
									//For 2 items per row
									/*
if(!($counter % 2 == 0)):
										$two_row_col_gutter = 'tab_col_gutter';
									else:
										$two_row_col_gutter = '';
									endif;
									
									//For 4 items per row
									if(!($counter % 4 == 0)):
										$four_row_col_gutter = 'desk_col_gutter desk_large_col_gutter';
									else:
										$four_row_col_gutter = '';
									endif;
*/
									
									$do_not_duplicate[] = $post->ID;
									
									$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');  ?>
									
									<article class="grid_item content_styles <?php //echo $two_row_col_gutter.' '.$four_row_col_gutter; ?>" role="article">
										<a href="<?php the_permalink(); ?>" title="Continue reading about <?php the_title(); ?>">
											<?php if (!($thumbnail == NULL)) {?>
												<figure>
													<img src="<?php echo $thumbnail[0]; ?>" alt="<?php the_title(); ?>"/>
												</figure>
											<?php } ?>
											<div class="padding_block">
												<header>
													<h1 class="alt_2"> <?php the_title(); ?> </h1>
												</header>
											</div> <!-- padding_block -->
										</a>
									</article>
									
									<?php 
									/*
if((!($counter == 1)) && ($counter % 2 == 0)): echo '<div class="tab_clearfix"></div>'; endif;
									if((!($counter == 1)) && ($counter % 4 == 0)): echo '<div class="desk_clearfix"></div>'; endif;
*/
									$counter++;
									if($counter == 5): break; endif;
								endforeach;
								echo '<div class="clearfix"></div>';
							endif; //end query
							wp_reset_postdata();  ?>
						</div>
					</section>
				<?php 
				elseif( $children == 'true_button' ): ?>
					<aside class="large_block">
						<?php if($show_children_title): echo '<h2 class="padding_block block">'.$show_children_title.'</h2>'; endif; ?>
						<!-- <div class="grid"> -->
							<?php $args = array(
								'child_of' => $post_id,
								'parent' => $post_id,
								'sort_column' => 'menu_order',
								'hierarchical' => 0,
								'post_type' => 'page',
								'post_status' => 'publish',
							);
								
							$query = null;
										
							$key = 'related-pages-buttons-'.$post->ID;
																
							$query = wp_cache_get( $key, $group );
										
							if ( $query == '' ) {
							    $query = get_pages( $args );
								wp_cache_set( $key, $query, $group, $expire );
							}
															
							if($query):
								$counter = 0;
								foreach( $query as $post ) : setup_postdata($post);
									
									
									$do_not_duplicate[] = $post->ID;
									
									// If the row is uneven add an open div
							    	if (!($counter % 4)): echo '<div class="grid margin_bottom">'; endif;?>
									
										<div class="grid_item content_styles" role="article">
											<div class="padding_block">
												<header>
													<h1 class="alt_2">
														<a href="<?php the_permalink(); ?>" title="Find out about <?php the_title(); ?>" class="full_button">
															<?php the_title(); ?>
														</a>
													</h1>
												</header>
											</div> <!-- padding_block -->
										</div>
									
									<?php 
									
									 if (!(($counter+1)%4) || $counter+1 == count($query)): echo '</div>'; endif;
									if($counter == 3): break; endif;
									$counter++;
								endforeach;
								echo '<div class="clearfix"></div>';
							endif; //end query
							wp_reset_postdata();  ?>
						<!-- </div> -->
					</aside>
				<?php endif; // end if( in_array( 'true', $children ) )
			endwhile; endif; ?>
		</div>
	</article>
<?php get_footer(); // Loads the footer.php template. ?>