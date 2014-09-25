<?php
/**
 * Loop Social Box Template
 *
*/

	?>

<div class="social_box">
	<!-- Go to your Addthis.com Dashboard to update any options -->
	<div class="float_left">
		<div class="addthis_sharing_toolbox"></div>
	</div>
	<?php $num_comments = get_comments_number(); // get_comments_number returns only a numeric value
	if ( comments_open() ) {
		echo '<div class="float_right">';
		
			if ( $num_comments == 0 ) {
				$comments = __('0 <span class="large_device_inline">Comments</span>');
			} elseif ( $num_comments > 1 ) {
				$comments = $num_comments . __(' <span class="large_device_inline">Comments</span>');
			} else {
				$comments = __('1 <span class="large_device_inline">Comments</span>');
			}
			$write_comments = '<a href="' . get_comments_link() .'" class="comment_box"><span class="icon-comment"></span> '. $comments.'</a>';
			
			echo $write_comments;
			
		echo '</div>'; ?>
		<script type="text/javascript">
			jQuery(function() {
			  $('a[href*=#]:not([href=#])').click(function() {
			    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			      var target = jQuery(this.hash);
			      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			      if (target.length) {
			        jQuery('html,body').animate({
			          scrollTop: target.offset().top
			        }, 1000);
			        return false;
			      }
			    }
			  });
			});
		</script>
	<?php } ?>
	<div class="clearfix"></div>
</div> <!-- social_box -->
<div class="clearfix"></div>