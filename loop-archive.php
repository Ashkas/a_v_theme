<?php
/**
 * Loop Archive Loop Module Template
 *
*/
$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium-16x9'); 
?>
	<article class="content_styles single_block archive_block" role="article">
		<?php if (!($thumbnail == NULL)) {?>
			<figure>
				<img src="<?php echo $thumbnail[0]; ?>" alt="<?php the_title(); ?>"/>
			</figure>
		<?php } ?>
		<div class="padding_block">
			<header>
				<h3 class="category_title"><?php echo custom_category($post->ID, $taxonomy); ?></h3>
				<h1 class="alt">
					<?php if(is_sticky()) : ?>
						<span class="sticky_icon">
							<span class="icon-bolt"></span>
						</span>
						<span class="sticky_title">
							<a href="<?php the_permalink(); ?>" title="Continue reading about <?php the_title(); ?>">
								<?php the_title(); ?>
							</a>
						</span>
					<?php else: ?>
						<a href="<?php the_permalink(); ?>" title="Continue reading about <?php the_title(); ?>">
							<?php the_title(); ?>
						</a>
					<?php endif; ?>
				</h1>
				<div class="small_block">
					<time pubdate datetime="<?php the_time('c'); ?>" class="float_left">
						<?php $pfx_date = get_the_date('F j, Y'); echo '- '.$pfx_date;?>
					</time>
					<?php if(!is_search()): ?>
						<small class="float_right alt"><?php echo read_time(); ?> </small>
					<?php endif; ?>
					<div class="clearfix"></div>
				</div>
			</header>
			<?php the_excerpt(); ?>
		</div> <!-- padding_block -->
	</article>