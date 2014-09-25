<?php
/**
 * Loop Archive Loop Module Template
 *
*/
$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), 'medium-24x1'); 
?>
<article class="tab_2 desk_3 desk_large_3 content_styles single_block" role="article">
	<?php if (!($thumbnail == NULL)) {?>
		<figure>
			<img src="<?php echo $thumbnail[0]; ?>" alt="<?php the_title(); ?>"/>
		</figure>
	<?php } ?>
	<div class="padding_block">
		<header>
			<h3 class="category_title"><?php echo custom_category($post->ID, $taxonomy); ?></h3>
			<h1 class="alt">
				<a href="<?php the_permalink(); ?>" title="Continue reading about <?php the_title(); ?>">
					<?php the_title(); ?>
				</a>
			</h1>
			<time pubdate datetime="<?php the_time('c'); ?>" class="float_left">
				<?php $pfx_date = get_the_date('F j, Y'); echo '- '.$pfx_date;?>
			</time>
			<small class="float_right"><?php echo read_time(); ?> </small>
			<div class="clearfix"></div>
		</header>
	</div> <!-- padding_block -->
</article>