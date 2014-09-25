<?php
/**
 * Footer Template
 *
 */
 
$home_url = home_url();
?>
		 
<footer role="contentinfo" class="site_footer"> 
	<div class="footer_top">
		<div class="footer_content">
			<?php
				$social = get_field('social_media', 'option');
				
				if($social):
					echo $social;
				endif;
			?>
			<small class="desktop_device_inline newsletter"><a href="http://skattle.org.au/about/newsletter/" title="Join SKATTLE's newsletter">Newsletter</a></small>
			<div class="clearfix"></div>
		</div> <!-- footer_content -->
	</div> <!-- footer_top -->
	        
	<div class="footer_content">
		
		<nav class="mob_2 tab_3 desk_2 desk_large_3 mob_col_gutter desk_col_gutter single_block"> 
			<h2 class="alt"><a href="<?php echo $home_url; ?>/counselling" title="Skattle Counselling Services" class="alt">Counselling</a></h2>  
			<?php
			$nav_args = array(
				'theme_location'  => 'footer_menu_1',
				'menu'            => '', 
				'container'       => false, 
				'container_class' => 'footer_nav', 
				'container_id'    => '',
				'menu_class'      => 'menu', 
				'menu_id'         => '',
				'echo'            => false,
				'fallback_cb'     => 'wp_page_menu',
				'before'          => '',
				'after'           => '',
				'link_before'     => '',
				'link_after'      => '',
				'items_wrap'      => '%3$s',
				'depth'           => 1					
			);
			
			/* Put the nav menu into a variable to check whether it is set or not */
			$nav_menu = wp_nav_menu($nav_args);
			// Only display hot tags if $nav_menu is not empty
			if(!(empty($nav_menu))) { ?>
				<ul class="menu">
					<?php echo $nav_menu; ?>
				</ul>  
			<?php } ?> 
		</nav>
		
		<nav class="mob_2 tab_3 desk_2 desk_large_3 desk_col_gutter single_block">     
			<h2 class="alt"><a href="<?php echo $home_url; ?>/professional-development" title="Skattle Training Servers" class="alt">Professionals</a></h2>   
			<?php
			$nav_args = array(
				'theme_location'  => 'footer_menu_2',
				'menu'            => '', 
				'container'       => false, 
				'container_class' => 'footer_nav', 
				'container_id'    => '',
				'menu_class'      => 'menu', 
				'menu_id'         => '',
				'echo'            => false,
				'fallback_cb'     => 'wp_page_menu',
				'before'          => '',
				'after'           => '',
				'link_before'     => '',
				'link_after'      => '',
				'items_wrap'      => '%3$s',
				'depth'           => 1					
			);
			
			/* Put the nav menu into a variable to check whether it is set or not */
			$nav_menu = wp_nav_menu($nav_args);
			// Only display hot tags if $nav_menu is not empty
			if(!(empty($nav_menu))) { ?>
				<ul class="menu">
					<?php echo $nav_menu; ?>
				</ul>  
			<?php } ?> 
		</nav>
		
		<div class="mobile_clearfix"></div>
		
		<nav class="mob_2 tab_3 desk_2 desk_large_3 mob_col_gutter desk_col_gutter single_block">    
			<h2 class="alt"><a href="<?php echo $home_url; ?>/category/blog" title="Skattle Blog" class="alt">Blog</a></h2>   
			<?php
			$nav_args = array(
				'theme_location'  => 'footer_menu_3',
				'menu'            => '', 
				'container'       => false, 
				'container_class' => 'footer_nav', 
				'container_id'    => '',
				'menu_class'      => 'menu', 
				'menu_id'         => '',
				'echo'            => false,
				'fallback_cb'     => 'wp_page_menu',
				'before'          => '',
				'after'           => '',
				'link_before'     => '',
				'link_after'      => '',
				'items_wrap'      => '%3$s',
				'depth'           => 1					
			);
			
			/* Put the nav menu into a variable to check whether it is set or not */
			$nav_menu = wp_nav_menu($nav_args);
			// Only display hot tags if $nav_menu is not empty
			if(!(empty($nav_menu))) { ?>
				<ul class="menu">
					<?php echo $nav_menu; ?>
				</ul>  
			<?php } ?> 
		</nav>
		
		<nav class="mob_2 tab_3 desk_2 desk_large_3 single_block">     
			<h2 class="alt"><a href="<?php echo $home_url; ?>/about" title="About Skattle" class="alt">About</a></h2>    
			<?php
			$nav_args = array(
				'theme_location'  => 'footer_menu_4',
				'menu'            => '', 
				'container'       => false, 
				'container_class' => 'footer_nav', 
				'container_id'    => '',
				'menu_class'      => 'menu', 
				'menu_id'         => '',
				'echo'            => false,
				'fallback_cb'     => 'wp_page_menu',
				'before'          => '',
				'after'           => '',
				'link_before'     => '',
				'link_after'      => '',
				'items_wrap'      => '%3$s',
				'depth'           => 1					
			);
			
			/* Put the nav menu into a variable to check whether it is set or not */
			$nav_menu = wp_nav_menu($nav_args);
			// Only display hot tags if $nav_menu is not empty
			if(!(empty($nav_menu))) { ?>
				<ul class="menu">
					<?php echo $nav_menu; ?>
				</ul>  
			<?php } ?> 
		</nav>
		
		<div class="mobile_clearfix"></div>
		<div class="clearfix"></div>
	</div> <!-- footer_content -->
	
	<?php //ALlow for shortcodes in the footer site info ACF field
	$site_info = get_field('site_info', 'option');
	
	if ($site_info) : ?>
		<div class="footer_bottom">
			<aside class="footer_content">
				<?php //$footer_info = apply_filters('the_content', $site_info);
				
				echo preg_replace('/<img[^>]+./','', $site_info); ?>
			</div>
		</div>
	<?php endif; ?>
	
</footer> <!-- End Footer-->

<?php wp_footer(); // wp_footer ?>

</body>
</html>

<?php if(is_home() || is_single()): ?>
	<script type="text/javascript">
		jQuery(window).load(function() {
			jQuery('.home_slider').flexslider({		
				animation: "slide",              //String: Select your animation type, "fade" or "slide"
				start: function(slider) {
					slider.removeClass('loading');
				},
				smoothHeight: false,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
				slideshow: true,                //Boolean: Animate slider automatically
				directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
				controlNav: false, 
				animationSpeed: 800,
				slideshowSpeed: 8000,
				pauseOnHover: true,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
				pauseOnAction: true, 
				animationLoop: true,
				prevText: "",           //String: Set the text for the "previous" directionNav item
				nextText: "" ,
			});		
		});
	</script>
<?php endif;

if(is_home() || is_single()): ?>
	<script type="text/javascript">
		jQuery(window).load(function() {
			jQuery('.single_slider').flexslider({		
				animation: "slide",              //String: Select your animation type, "fade" or "slide"
				start: function(slider) {
					slider.removeClass('loading');
				},
				smoothHeight: false,            //{NEW} Boolean: Allow height of the slider to animate smoothly in horizontal mode
				slideshow: true,                //Boolean: Animate slider automatically
				directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
				controlNav: false, 
				animationSpeed: 600,
				slideshowSpeed: 6000,
				pauseOnHover: true,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
				pauseOnAction: true, 
				animationLoop: true,
				prevText: "",           //String: Set the text for the "previous" directionNav item
				nextText: "" ,
			});		
		});
	</script>
<?php endif; ?>


<!-- Header search -->
<script>
	var menuTop = document.getElementById( 'sb-search' ),
		showTop = document.getElementById( 'search_toggle' ),
		body = document.body;

	showTop.onclick = function() {
		classie.toggle( this, 'active' );
		classie.toggle( menuTop, 'sb-search-open' );
		disableOther( 'search_toggle' );
	};

	function disableOther( button ) {
		if( button !== 'search_toggle' ) {
			classie.toggle( showTop, 'disabled' );
		}
	}
</script>

<!-- AddThis Pro BEGIN -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-538ead70480d9eda"></script>
<!-- AddThis Pro END -->

<?php if(is_singular('post')): 
	global $post;
?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  var count = 2;
		  $(window).scroll(function(){
		          if  ($(window).scrollTop() == $(document).height() - $(window).height()){
		             if (count <= 4){
		             	loadArticle(count);
			             count++;
			         } /*
else {
						$('#content').append('Some text').show();
						return false;
			         }
*/
		          }
		  });
		
		  function loadArticle(pageNumber){   
	          $('a#inifiniteLoader').show('fast');
	          $.ajax({
	              url: "<?php bloginfo('wpurl') ?>/wp-admin/admin-ajax.php",
	              type:'POST',
	              data: "action=infinite_scroll&page_no="+ pageNumber + '&loop_file=loop',
	              success: function(html){
	                  $('a#inifiniteLoader').hide('2000');
	                  $("#content").append(html);    // This will be the div where our content will be loaded
	              }
	          });
		      return false;
		  }
		  
		  /*
function showArchive() {
			  
		  }
*/
		
		});
  </script>
  
	  <?php //include script for single header animation if there is a featured image
	  $featured_attachment_id = get_post_thumbnail_id($post->ID);
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
	
  if($featured_image): ?>
	  <script>
		    if ( jQuery(window).width() > 760) { 
				(function() {
				
					// detect if IE : from http://stackoverflow.com/a/16657946		
					var ie = (function(){
						var undef,rv = -1; // Return value assumes failure.
						var ua = window.navigator.userAgent;
						var msie = ua.indexOf('MSIE ');
						var trident = ua.indexOf('Trident/');
				
						if (msie > 0) {
							// IE 10 or older => return version number
							rv = parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
						} else if (trident > 0) {
							// IE 11 (or newer) => return version number
							var rvNum = ua.indexOf('rv:');
							rv = parseInt(ua.substring(rvNum + 3, ua.indexOf('.', rvNum)), 10);
						}
				
						return ((rv > -1) ? rv : undef);
					}());
				
				
					// disable/enable scroll (mousewheel and keys) from http://stackoverflow.com/a/4770179					
					// left: 37, up: 38, right: 39, down: 40,
					// spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
					var keys = [32, 37, 38, 39, 40], wheelIter = 0;
				
					function preventDefault(e) {
						e = e || window.event;
						if (e.preventDefault)
						e.preventDefault();
						e.returnValue = false;  
					}
				
					function keydown(e) {
						for (var i = keys.length; i--;) {
							if (e.keyCode === keys[i]) {
								preventDefault(e);
								return;
							}
						}
					}
				
					function touchmove(e) {
						preventDefault(e);
					}
				
					function wheel(e) {
						// for IE 
						//if( ie ) {
							//preventDefault(e);
						//}
					}
				
					function disable_scroll() {
						window.onmousewheel = document.onmousewheel = wheel;
						document.onkeydown = keydown;
						document.body.ontouchmove = touchmove;
					}
				
					function enable_scroll() {
						window.onmousewheel = document.onmousewheel = document.onkeydown = document.body.ontouchmove = null;  
					}
				
					var docElem = window.document.documentElement,
						scrollVal,
						isRevealed, 
						noscroll, 
						isAnimating,
						container = document.getElementById( 'container' ),
						scroll_box = document.getElementById( 'scroll_box' ),
						trigger = container.querySelector( 'button.trigger' );
				
					function scrollY() {
						return window.pageYOffset || docElem.scrollTop;
					}
					
					function scrollPage() {
						scrollVal = scrollY();
						
						if( noscroll && !ie ) {
							if( scrollVal < 0 ) return false;
							// keep it that way
							window.scrollTo( 0, 0 );
						}
				
						if( classie.has( container, 'notrans' ) ) {
							classie.remove( container, 'notrans' );
							return false;
						}
						
						if( classie.has( scroll_box, 'notrans' ) ) {
							classie.remove( scroll_box, 'notrans' );
							return false;
						}
				
						if( isAnimating ) {
							return false;
						}
						
						if( scrollVal <= 0 && isRevealed ) {
							toggle(0);
						}
						else if( scrollVal > 0 && !isRevealed ){
							toggle(1);
						}
					}
				
					function toggle( reveal ) {
						isAnimating = true;
						
						if( reveal ) {
							classie.add( container, 'modify' );
							classie.add( scroll_box, 'modify' );
						}
						else {
							noscroll = true;
							disable_scroll();
							classie.remove( container, 'modify' );
							classie.remove( scroll_box, 'modify' );
						}
				
						// simulating the end of the transition:
						setTimeout( function() {
							isRevealed = !isRevealed;
							isAnimating = false;
							if( reveal ) {
								noscroll = false;
								enable_scroll();
							}
						}, 600 );
					}
				
					// refreshing the page...
					var pageScroll = scrollY();
					noscroll = pageScroll === 0;
					
					disable_scroll();
					
					if( pageScroll ) {
						isRevealed = true;
						classie.add( container, 'notrans' );
						classie.add( container, 'modify' );
						classie.add( scroll_box, 'notrans' );
						classie.add( scroll_box, 'modify' );
					}
					
					window.addEventListener( 'scroll', scrollPage );
					trigger.addEventListener( 'click', function() { toggle( 'reveal' ); } );
				})();
			}
		</script>
	<?php endif; // if has featured image

endif; // is_single
	
if(is_page()):
	// Script to show/hide fields in contact form depending on selections ?>
	<script>
		jQuery(document).ready(function($) {
			//Hide the field initially
	        jQuery("#pro-dev-services").hide();
	        jQuery("#counselling-services").hide();
			
			// If Pro Dev
			jQuery("input[value='Professional Development']").change(function(e){
				if($(this).val() == 'Professional Development') {
				    jQuery("#pro-dev-services").show();
				    jQuery("#counselling-services").hide();
				}
			});
			
			// If Counselling
	        jQuery("input[value='Counselling']").change(function(e){
				if($(this).val() == 'Counselling') {
					jQuery("#counselling-services").show();
				    jQuery("#pro-dev-services").hide();				    
				}
			});
			
			// if General
			jQuery("input[value='General enquiry']").change(function(e){
				if($(this).val() == 'General enquiry') {
				    jQuery("#pro-dev-services").hide();
				    jQuery("#counselling-services").hide();
				}
			});
		});
	</script>
<?php endif; //Contact us ?>

<!-- Typekit -->
<script type="text/javascript" src="//use.typekit.net/moe3esx.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>

<!-- Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-33447908-1', 'auto');
  ga('send', 'pageview');

</script>