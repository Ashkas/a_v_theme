<?php
/**
 * Loop Title Template
 *
*/

//Reusable variables


// ACF Variables
$gallery = get_field('image_gallery');
$video = get_field('video_embed');

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
endif; 	?>

</div> <!-- main_content -->
</div> <!-- main -->

<header class="single_article_header">
	<div class="padding_block">
		<div class="page_title_block margin_bottom tab_5 desk_6 desk_large_10">
			<div class="large_padding_sides">
				<h1 class="page_title margin_bottom"><?php the_title(); ?></h1>
				<?php if(is_singular('post')): ?>
					<h3 class="alt inline_block"><?php echo custom_category($post->ID, $taxonomy); ?> /</h3>
					<?php $author_id = get_the_author_meta('user_level');
					if ( $author_id == 10) : ?> 
						<h3 class="alt inline_block" role="author">by <?php echo get_the_author_link(); ?> /</h3>
					<?php endif; ?>
					
					<time pubdate datetime="<?php the_time('c'); ?>" class="inline_block">
						<?php $pfx_date = get_the_date('F j, Y'); echo $pfx_date;?>
					</time>
					<small class="inline_block large_float_right"><?php echo read_time(); ?> </small>
				<?php endif; ?>
			</div> <!-- large_padding_sides -->
		</div> <!-- page_title_block margin_bottom tab_5 desk_6 desk_large_10 -->
	</div> <!-- padding_block -->
	
	
	
	
	<?php if($video) { ?>
		<div class="embed_container double_single_block bg_img">
			<?php echo $video; ?>
		</div>
	<?php }
	
	elseif ($gallery) {
		$counter = 0;?>
		<div class="single_slider double_single_block  bg_img">
			<div class="flexslider-container">
				<div class="flexslider archive_slider loading">
					<ul class="slides">
						<?php foreach($gallery as $image) :?>
							<li>
								<img src="<?php echo $image['sizes']['large-16x9']; ?>" alt="<?php echo $image['alt']; ?>" alt="<?php echo $image['title']; ?>" class="feature_image" />
							</li>
						<?php $counter++;
							if ($counter == 3): break; endif; // will show 4 slides from the gallery then stop 
						endforeach; ?>
					</ul>
				</div>
			</div>
		</div> <!-- single_slider -->
		<div class="clearfix"></div>
	<?php }
	
	elseif($featured_image == true)  {?>
		<figure class="bg_img">
			<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $the_title; ?>" title="<?php echo $the_title; ?>" class="feature_image"/>
		</figure>
	<?php } ?>
</header>

<div class="main" id="page">
	<div class="main_content">