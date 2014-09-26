<?php
/**
 * Single Template
 *
 * This is the default single template. 
*/

get_header(); // Loads the header.php template. 

//Global variables
$home_url = home_url();
$do_not_duplicate = array();
$category = get_the_category();
$tags = get_the_tags($single_post_id);
$expire = 60 * 60 * 168; // 168 hours

//Check the image size to ensure it is large.
// Update this number from 2160 if the image size for large-16x9 changes in functions.php.
$width_check = 2160;
$featured_attachment_id = get_post_thumbnail_id($post->ID);
$featured_image = wp_get_attachment_image_src($featured_attachment_id, 'large-16x9'); 

if($featured_image) :
	list($width, $height) = getimagesize($featured_image[0]);
	if ($width_check == $width) {
	    $featured_image = wp_get_attachment_image_src($featured_attachment_id, 'large-16x9');
	} else {
		$featured_image = false;
	}
endif; 

// ACF variables
if(function_exists('get_field')) {
	$gallery = get_field('image_gallery');
}

if ( have_posts() ) : while ( have_posts() ) : the_post(); $do_not_duplicate[] = $post->ID; ?>

	<article role="article"  id="container" class="container intro-effect-fadeout">
		<?php if($featured_image == true || $gallery) : 
			$content = 'content';
		?>
			<header class="single_article_header">
				<div class="padding_block">
					<div class="page_title_block margin_bottom tab_5 desk_6 desk_large_10">
						<div class="large_padding_sides">
							<h1 class="page_title margin_bottom"><?php the_title(); ?></h1>
							<?php if(is_singular('post')): ?>
							
								<h3 class="alt inline_block"><?php echo custom_category($post->ID, $taxonomy); ?> /</h3>
								<?php $author_id = get_the_author_meta('user_level');
								if ( $author_id >= 2) : ?> 
									<h3 class="alt inline_block" role="author">&nbsp; by <?php echo get_the_author_link(); ?> /</h3>
								<?php endif; ?>
								
								<time pubdate datetime="<?php the_time('c'); ?>" class="inline_block">
									<?php $pfx_date = get_the_date('F j, Y'); echo $pfx_date;?>
								</time>
								<small class="inline_block large_float_right"><?php echo read_time(); ?> </small>
								<div class="clearfix"></div>
								
							<?php endif; ?>
						</div> <!-- large_padding_sides -->
					</div> <!-- page_title_block margin_bottom tab_5 desk_6 desk_large_10 -->
				</div> <!-- padding_block -->
				
				<div class="scroll_box" id="scroll_box">
					<span class="centre_text">Scroll down<br></span>
					<span class="icon-arrow-down"></span>
				</div>
				
				<?php if ($gallery) {
					$counter = 0;?>
					<div class="bg_img">
						<div class="flexslider-container">
							<div class="flexslider single_slider loading">
								<ul class="slides">
									<?php foreach($gallery as $image) :?>
										<li>
											<img src="<?php echo $image['sizes']['large-16x9']; ?>" alt="<?php echo $image['alt']; ?>" alt="<?php echo $image['title']; ?>" class="feature_image" />
										</li>
									<?php $counter++;
										if ($counter == 2): break; endif; // will show 3 slides from the gallery then stop 
									endforeach; ?>
								</ul>
							</div>
						</div>
					</div> <!-- single_slider -->
					<div class="clearfix"></div>
				<?php }
				
				else { ?>
					<figure class="bg_img">
						<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $the_title; ?>" title="<?php echo $the_title; ?>" class="feature_image"/>
					</figure>
				<?php } ?>
				
			</header>
		<?php else: ?>
			<div class="main" id="page">
				<div class="main_content">
					
					<header class="padding_block">
						<div class="margin_auto margin_bottom tab_5 desk_6 desk_large_10 content">
							<h1 class="page_title margin_bottom"><?php the_title(); ?></h1>
							<?php if(is_singular('post')): ?>
							
								<h3 class="alt inline_block"><?php echo custom_category($post->ID, $taxonomy); ?> /</h3>
								<?php $author_id = get_the_author_meta('user_level');
								if ( $author_id >= 2) : ?> 
									<h3 class="alt inline_block" role="author">&nbsp; by <?php echo get_the_author_link(); ?> /</h3>
								<?php endif; ?>
								
								<time pubdate datetime="<?php the_time('c'); ?>" class="inline_block">
									<?php $pfx_date = get_the_date('F j, Y'); echo $pfx_date;?>
								</time>
								<small class="inline_block large_float_right"><?php echo read_time(); ?> </small>
								<div class="clearfix"></div>
								
							<?php endif;
							
							get_template_part('loop-social-box'); ?>
							
						</div> <!-- page_title_block margin_bottom tab_5 desk_6 desk_large_10 -->
					</header>
		<?php endif; ?>
		
		<div class="main" id="page">
			<div class="main_content <?php echo $content; ?>">
				
				<?php if($featured_image == true) :?>
					
					<div class="tab_5 desk_6 desk_large_8 margin_auto block">
						<div class="padding_block">
							<?php get_template_part( 'loop-social-box' ); ?>
						</div>
					</div>
					
				<?php endif; 
			
				get_template_part( 'loop-page' ); // Loads the loop-page.php template. ?>
				
				<div class="clearfix"></div>
				<div class="padding_block block">
					<div class="tab_5 desk_6 desk_large_8 margin_auto border_bottom border_top">
						<?php if ($tags || $gallery) : 
							$counter = 0;
						?>
							<div class="grid">
								<div class="grid_item">
									<!-- Go to your Addthis.com Dashboard to update any options -->
									<div class="addthis_sharing_toolbox"></div>
									
									<?php if ($gallery):
										foreach($gallery as $image) : 
											if ($counter== 0 ):?>
												<a href="<?php echo $image['sizes']['large-16x9']; ?>" title="<?php echo $the_title; ?>" class="fresco" data-fresco-group="single-group" data-fresco-caption="<?php echo $image['caption']; ?>" data-fresco-group-options="ui:'inside'"><br><h3 class="alt">View all images</h3></a>
											<?php else: ?>
												<a href="<?php echo $image['sizes']['large-16x9']; ?>" title="<?php echo $the_title; ?>" class="fresco" data-fresco-group="single-group" data-fresco-caption="<?php echo $image['caption']; ?>" data-fresco-group-options="ui:'inside'"></a>
											<?php endif;
											$counter++;
										endforeach; 
									endif;?>
								</div>
								
								<div class="grid_item">
									<aside class="meta_info">
										<h2 class="alt">Tags</h2>
										<p>
											<?php $separator2 = ', ';
											  foreach($tags as $tag) {
											  	$output2 .= '<a href="'.get_tag_link($tag->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $tag->name ) ) . '">'.$tag->name.'</a>'.$separator2;
											  }
											  echo trim($output2, $separator2);
											  ?>
										</p>
									</aside>
								</div> <!-- grid_item -->
							</div> <!-- grid -->
						<?php elseif (!$tags || $gallery) : 
							$counter = 0;
						?>
							<div class="grid">
								<div class="grid_item">
									<!-- Go to your Addthis.com Dashboard to update any options -->
									<div class="addthis_sharing_toolbox"></div>
								</div>
								
								<div class="grid_item">
									<?php foreach($gallery as $image) : 
										if ($counter== 0 ):?>
											<a href="<?php echo $image['sizes']['large-16x9']; ?>" title="<?php echo $the_title; ?>" class="fresco" data-fresco-group="single-group" data-fresco-caption="<?php echo $image['caption']; ?>" data-fresco-group-options="ui:'inside'"><h2>View all images</h2></a>
										<?php else: ?>
											<a href="<?php echo $image['sizes']['large-16x9']; ?>" title="<?php echo $the_title; ?>" class="fresco" data-fresco-group="single-group" data-fresco-caption="<?php echo $image['caption']; ?>" data-fresco-group-options="ui:'inside'"></a>
										<?php endif;
										$counter++;
									endforeach; ?>
								</div> <!-- grid_item -->
							</div> <!-- grid -->
						<?php else: ?>
							<div class="grid_item">
								<!-- Go to your Addthis.com Dashboard to update any options -->
								<div class="addthis_sharing_toolbox"></div>
							</div>
						<?php endif; ?>
						
					</div>
				</div>
				
				<?php // If comments are open or we have at least one comment, load up the comment template.
				
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				} ?>
					
				<div class="clearfix"></div>
			</div> <!-- main_content -->
		</div> <!-- main -->
	</article>
	
<?php endwhile; endif; ?>
	<div class="main" id="page">
	<div class="main_content large_block" id="content">
		<section class="large_block">
			<header class="padding_block block">
				<h1 class="alt">More articles in <?php echo custom_category($post->ID, $taxonomy); ?></h1>
			</header>
			<?php $args = array(
				'posts_per_page' => 4,
				'post_type' => 'post',
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'post_parent' => 0,
				'cat' => $category[0]->term_id,
				'post__not_in' => array_merge($do_not_duplicate),
				'meta_query' => array(
					array(
			            'key' => '_thumbnail_id',
			        ) // Force just stories with featured image
				),
			);
				
			$query = null;
						
			$key = 'single-latest-'.$category[0]->term_id;
												
			$query = wp_cache_get( $key, $group );
						
			if ( $query == '' ) {
			    $query = get_posts( $args );
				wp_cache_set( $key, $query, $group, $expire );
			}
											
			if($query):
				$counter = 1;
				$two_row_col_gutter = 'tab_col_gutter desk_col_gutter';
				$four_row_col_gutter = 'desk_large_col_gutter';
				
				foreach( $query as $post ) : setup_postdata($post);
					
					//For 2 items per row
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
					
					$do_not_duplicate[] = $post->ID;
					
					$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium-16x9');  ?>
					
					<article class="tab_3 desk_2 desk_large_3 content_styles block <?php echo $two_row_col_gutter.' '.$four_row_col_gutter; ?>" role="article">
						<?php if (!($thumbnail == NULL)) {?>
							<figure>
								<img src="<?php echo $thumbnail[0]; ?>" alt="<?php the_title(); ?>"/>
							</figure>
						<?php } ?>
						<div class="padding_block">
							<header>
								<h3 class="category_title"><?php echo custom_category($post->ID, $taxonomy); ?></h3>
								<h1 class="alt_2">
									<a href="<?php the_permalink(); ?>" title="Continue reading about <?php the_title(); ?>">
										<?php the_title(); ?>
									</a>
								</h1>
							</header>
						</div> <!-- padding_block -->
					</article>
					
					<?php if((!($counter == 1)) && ($counter % 2 == 0)): echo '<div class="tab_clearfix"></div>'; endif;
					if((!($counter == 1)) && ($counter % 4 == 0)): echo '<div class="desk_clearfix"></div>'; endif;
					$counter++;
				endforeach;
				echo '<div class="clearfix"></div>';
			else :
				echo '<div class="padding_block"><small>Sorry there are currently no new articles posted in '.custom_category_name($post->ID, $taxonomy).'.</small></div>';
			endif; 
			wp_reset_postdata();  ?>
		</section>
		
		<section>
			<header class="padding_block block">
				<h1 class="alt">Latest articles</h1>
			</header>
			<?php $args = array(
				'posts_per_page' => 12,
				'post_type' => 'post',
				'post_status' => 'publish',
				'ignore_sticky_posts' => 1,
				'post_parent' => 0,
				///'order' => 'ASC',
				'paged' => $page,
				'post__not_in' => array_merge($do_not_duplicate),
				'meta_query' => array(
					array(
			            'key' => '_thumbnail_id',
			        ) // Force just stories with featured image
				),
			);
				
			$query = null;
						
			$key = 'single-latest';
												
			$query = get_transient( $key );
								
			if ( $query == '' ) {
			    $query = new WP_query( $args );
				set_transient( $key, $query, $expire );
			}
											
			if($query):
				$counter = 1;
				$three_row_col_gutter = 'tab_col_gutter desk_col_gutter';
				$four_row_col_gutter = 'desk_large_col_gutter';
				
				while ($query->have_posts()) : $query->the_post();
					
					//For 3 items per row
					if(!($counter % 3 == 0)):
						$three_row_col_gutter = 'tab_col_gutter';
					else:
						$three_row_col_gutter = '';
					endif;
					
					//For 4 items per row
					if(!($counter % 4 == 0)):
						$four_row_col_gutter = 'desk_col_gutter desk_large_col_gutter';
					else:
						$four_row_col_gutter = '';
					endif;
					
					$do_not_duplicate[] = $post->ID;
					
					$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium-16x9');  ?>
					
					<article class="tab_2 desk_2 desk_large_3 content_styles block <?php echo $three_row_col_gutter.' '.$four_row_col_gutter; ?>" role="article">
						<?php if (!($thumbnail == NULL)) {?>
							<figure>
								<img src="<?php echo $thumbnail[0]; ?>" alt="<?php the_title(); ?>"/>
							</figure>
						<?php } ?>
						<div class="padding_block">
							<header>
								<h3 class="category_title"><?php echo custom_category($post->ID, $taxonomy); ?></h3>
								<h1 class="alt_2">
									<a href="<?php the_permalink(); ?>" title="Continue reading about <?php the_title(); ?>">
										<?php the_title(); ?>
									</a>
								</h1>
							</header>
						</div> <!-- padding_block -->
					</article>
					
					<?php if((!($counter == 1)) && ($counter % 3 == 0)): echo '<div class="tab_clearfix"></div>'; endif;
					if((!($counter == 1)) && ($counter % 4 == 0)): echo '<div class="desk_clearfix"></div>'; endif;
					$counter++;
				endwhile;
				echo '<div class="clearfix"></div>';
			else :
				echo '<div class="padding_block"><small>Sorry there are currently no new articles</small></div>';
			endif; 
			wp_reset_query();  ?>
			<a id="inifiniteLoader"></a>
		</section>
	</div> <!-- main_content -->
</div> <!-- main -->

<?php get_footer(); // Loads the footer.php template. ?>