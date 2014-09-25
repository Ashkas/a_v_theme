<?php
/**
 * Loop Page Template
 *
*/

// Global Variables
$the_title = get_the_title();

// ACF variables
$dates = get_field('dates');
$date_box = get_field('date_box');
$date_note = get_field('date_note');
$price_box = get_field('price_box');
$contact = get_field('contact_action_box');
$downloads = get_field('downloads');

if (is_page('Contact us')): 
	$address = get_field('address');
	$postal = get_field('postal_address');
	$location_map = get_field('location_map');
	$phone = get_field('phone_number', 'option');
?>
	<div class="margin_auto tab_5 desk_6 desk_large_8 single_block">
		<div class="grid padding_block">
		
			<span><a href="#contact_form" class="scroll button margin_auto single_block small_device"><span class="icon-mail"></span> Contact form</a></span>
			<script type="text/javascript">
					$('.scroll').click(function(event){
					     event.preventDefault();
				         //calculate destination place
				         var dest=0;
				         if($(this.hash).offset().top > $(document).height()-$(window).height()){
				              dest=$(document).height()-$(window).height();
				         }else{
				              dest=$(this.hash).offset().top;
				         }
				         //go to destination
				         $('html,body').animate({scrollTop:dest}, 2000,'swing');
				     });
			</script>
			
			<div class="grid_item">

				<h2>Details</h2>
				
				<div class="mobile_grid">
					<?php if($address): ?>
						<div class="mobile_grid_item">
							<h3 class="alt">Address</h3>
							<address><?php echo $address; ?></address>
						</div>
					<?php endif;
						
					if($postal): ?>
						<div class="mobile_grid_item">
							<h3 class="alt">Postal Address</h3>
							<address><?php echo $postal; ?></address>
						</div>
					<?php endif;?>
				</div> <!-- mobile_grid -->
				
				<?php if($phone): ?>
					<div class="mobile_grid_item">
						<h3 class="alt">Phone</h3>
						<p><a href="tel:<?php echo $phone; ?>" class="small_device" title="Phone number for Skattle"><span class="icon-phone"></span> <?php echo $phone; ?></a><span class="large_device"><span class="icon-phone"></span> <?php echo $phone; ?></span></p>
					</div>
				<?php endif; ?>
				
			</div> <!-- grid_item -->
			
			<div class="grid_item">
				<?php if($location_map):
										
					$lat = $location_map['lat'];
					$long = $location_map['lng'];
					$map_address = $location_map['address']; ?>
					
					<h2>Location Map</h2>
					<a href="https://www.google.com/maps/preview#!q=<?php echo $map_address; ?>" title="Find out where Skattle is on Google Maps" target="_blank" class="google_map_link"><img src="http://maps.googleapis.com/maps/api/staticmap?zoom=15&size=600x400&maptype=roadmap
	&markers=color:red%7Clabel:%7C<?php echo $lat; ?>,<?php echo $long; ?>&sensor=false"></a>
		
				<?php endif; ?>
			</div> <!-- grid_item -->
		</div>
	</div>
	<div class="clearfix"></div>
	
	<div class="tab_5 desk_6 desk_large_8 margin_auto single_block">
		<div class="padding_block content_styles">
			<h2 id="contact_form">Contact form</h2>
			<?php echo do_shortcode('[contact-form-7 id="7" title="Contact"]');
				
			if( current_user_can( 'edit_posts' ) ) { ?>
				<p class="edit"><?php edit_post_link('EDIT'); ?></p>
			<?php } ?>
		</div>
	</div> <!-- tab_5 desk_6 desk_large_10 margin_auto single_block -->
<?php else:
	if(is_singular('page')):
		$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large-16x9'); 
	endif;?>
	<div class="tab_5 desk_6 desk_large_8 margin_auto single_block">
		<?php if($featured_image): ?>
			<figure class="double_single_block">
				<img src="<?php echo $featured_image[0]; ?>" alt="<?php echo $the_title; ?>" title="<?php echo $the_title; ?>" class="feature_image"/>
			</figure>
		<?php endif; ?>
		<div class="double_single_block padding_block content_styles">
			<?php the_content();			
			
			if( current_user_can( 'edit_posts' ) ) { ?>
				<p class="edit"><?php edit_post_link('EDIT'); ?></p>
			<?php } ?>
		</div>
	</div> <!-- tab_5 desk_6 desk_large_10 margin_auto single_block -->
	<div class="clearfix"></div>
	
	<?php if($downloads): ?>
		<div class="padding_block">
			<aside class="tab_5 desk_6 desk_large_10 margin_auto single_block border_top downloads">
				<h2>Downloads</h2>
				<div class="grid">
					<?php while( have_rows('downloads') ): the_row(); 
						 //Variables
						$download_title = get_sub_field('title');
						$download_size = get_sub_field('size');
						$download_file = get_sub_field('file'); ?>
						<div class="grid_item">
							<h3 class="alt"><a href="<?php echo $download_file; ?>" title="Download <?php echo $download_title; ?>"><span class="icon-install"></span><?php echo $download_title; if($download_size): echo ' ('.$download_size.')'; endif; ?> </h3>
						</div>
					<?php endwhile; ?>
				</div>
			</aside>
		</div>
	<?php endif; ?>
	
	<?php if($date_box || $price_box || $date_note): ?>
		<div class="padding_block single_block">
			<div class="tab_5 desk_6 desk_large_10 margin_auto double_single_block border_bottom border_top page_bottom_box">
				<aside class="grid">
					<?php if($date_box || $date_note || in_array( 'true', $contact)): ?>
						<div class="grid_item_alt">
						
							<?php if(in_array( 'true', $contact)):
								echo '<a href="'.home_url().'/contact-us" class="big_button single_block"><span class="button_text">Enquire now</span></a>';
							endif;
							
							if(get_field('date_title')): ?><h2><?php echo get_field('date_title'); ?></h2><?php endif; 
								
							if($date_note): ?>
								<div class="single_block">
									<p><?php echo $date_note ?></p>
								</div>
							<?php endif; // date_note
							
							if($date_box): ?>
								<div class="mobile_single_block">
									
									<?php while( have_rows('date_box') ): the_row(); 
										// vars
										$month = get_sub_field('month-year');
										$day = get_sub_field('days'); ?>
																	
										<h3><?php echo $month; ?></h3>
										<p><?php echo $day; ?></p>
										
									<?php endwhile; ?>
								</div>
							<?php endif; // date_box ?>
						</div> <!-- grid_item -->
					<?php endif; 
					
					if($price_box):	?>
						<div class="grid_item_alt">	
							<h2>Price</h2>
							<?php while( have_rows('price_box') ): the_row(); 
								// vars
								$price = get_sub_field('price');
								$description = get_sub_field('description'); ?>
								
								<div class="small_block">
									<p><?php echo $description; ?></p>		
									<?php if($price): ?>				
										<span class="alt_button"><?php echo $price; ?></span>
									<?php endif; ?>
								</div>
								
							<?php endwhile; ?>
						</div> <!-- grid_item -->
					<?php endif; ?>
				</aside>
			</div>
		</div>
	<?php endif; ?>
	
<?php endif; ?>