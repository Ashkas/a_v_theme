<?php
/**
 * Primary Off Canvas Menu Template
 *
 * Displays the Primary Menu if it has active menu items.
 *
 */

if ( has_nav_menu( 'primary-oc' ) ) : 

// ACF variable
$social = get_field('social_media', 'option');?>

	<nav id="menu" class="menu-link oc" role="navigation" style="display: none;">
    	<?php wp_nav_menu( array( 'theme_location' => 'primary-oc', 'container' => 'false',  'menu_class' => 'oc_menu', 'depth' => 1) );
    	
    	if($social):
			echo '<div class="inline_block">'.$social.'</div>';
		endif; ?>
	</nav>

<?php endif; ?>