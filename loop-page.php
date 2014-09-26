<?php
/**
 * Loop Page Template
 *
*/

// Global Variables
$the_title = get_the_title();

if(is_singular('page')):
	$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large-16x9'); 
endif;?>
<div class="tab_5 desk_6 desk_large_8 margin_auto block">
	<?php if($featured_image): ?>
		<figure class="large_block">
			<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $the_title; ?>" title="<?php echo $the_title; ?>" class="feature_image"/>
		</figure>
	<?php endif; ?>
	<div class="large_block padding_block content_styles">
		<?php the_content();			
		
		if( current_user_can( 'edit_posts' ) ) { ?>
			<p class="edit"><?php edit_post_link('EDIT'); ?></p>
		<?php } ?>
	</div>
</div> <!-- tab_5 desk_6 desk_large_10 margin_auto block -->
<div class="clearfix"></div>
	
