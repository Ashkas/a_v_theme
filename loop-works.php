<?php
/**
 * Loop Works Template
 *
*/
?>
<article class="content_styles" role="article">
	<div class="padding_block">
		<div class="tab_4 desk_6 desk_large_8 margin_auto large_block">
			<header>
				<h1 class="page_title"><?php the_title(); ?></h1>
			</header>
		</div> <!-- tab_4 desk_6 desk_large_8 margin_auto block -->
	</div> <!-- padding_block -->
	
	<div class="tab_4 desk_6 desk_large_8 margin_auto block">
		<div class="padding_block">
			<div class="block">
				<?php the_content(); ?>
			</div>
		</div>
	</div> <!-- tab_4 desk_6 desk_large_8 margin_auto block -->
	
	<?php 
	
	$responsive_works = get_field('responsive_works');
	$non_responsive_works = get_field('non_responsive_works');
	
	// Responsive Sites
	if ($responsive_works) { ?>
		<div class="tab_4 desk_6 desk_large_8 margin_auto block">
			<div class="padding_block">
				<div class="block">
					<h2>Responsive Websites</h2>
				</div>
			</div>
		</div> <!-- tab_4 desk_6 desk_large_8 margin_auto block -->
		<div class="large_block">
			<div class="padding_block">
				<?php foreach($responsive_works as $work) :
					$image_id = $work['image'];
					$thumbnail = wp_get_attachment_image_src($image_id, 'medium-16x9');
					$caption = get_post_thumbnail_caption_relationship($image_id);
					?>
					
					<div class="mob_2 tab_2 desk_2 desk_large_3 responsive_grid_gutter block">
						<a href="<?php echo $work['url'];?>" alt="<?php echo $work['title'];?>" target="_blank" class="grid_link">
							<figure class="tint">
								<div class="image_text">
									<?php if ($work['title']) { ?>
										<figcaption class="overlay">
											<?php echo $work['title']; ?>	
											<span class="overlay"><?php echo $caption ?></span>
										</figcaption>
									<?php } ?>
								</div>
									<img src="<?php echo $thumbnail[0]; ?>" alt="<?php echo $work['title'];?>"/>
							</figure>
						</a>
					</div>
				<?php endforeach;?>
				<div class="clearfix"></div>
			</div> <!-- padding_block -->
		</div>	 <!-- large_block -->
	<?php } /* responsive_works */
		
	// Non-Responsive Sites
	if ($non_responsive_works) { ?>
			
			<div class="tab_4 desk_6 desk_large_8 margin_auto block">
			<div class="padding_block">
				<div class="block">
					<h2>Fixed-width Websites</h2>
				</div>
			</div>
		</div> <!-- tab_4 desk_6 desk_large_8 margin_auto block -->
		
		<div class="large_block">
			<div class="padding_block">
				<?php foreach($non_responsive_works as $work) :
					$image_id = $work['image'];
					$thumbnail = wp_get_attachment_image_src($image_id, 'medium-16x9');
					$caption = get_post_thumbnail_caption_relationship($image_id);
					?>
					
					<div class="mob_2 tab_2 desk_2 desk_large_3 responsive_grid_gutter block">
						<a href="<?php echo $work['url'];?>" alt="<?php echo $work['title'];?>" target="_blank" class="grid_link">
							<figure class="tint">
								<div class="image_text">
									<?php if ($work['title']) { ?>
										<figcaption class="overlay">
											<?php echo $work['title']; ?>	
											<span class="overlay"><?php echo $caption ?></span>
										</figcaption>
									<?php } ?>
								</div>
									<img src="<?php echo $thumbnail[0]; ?>" alt="<?php echo $work['title'];?>"/>
							</figure>
						</a>
					</div>
				<?php endforeach;?>
				<div class="clearfix"></div>
			</div> <!-- padding_block -->
		</div>	 <!-- large_block -->
	<?php } /* non_responsive_works */?>
</article>