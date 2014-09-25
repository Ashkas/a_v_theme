<?php
/**
 * Primary Menu Template
 *
 * Displays the Primary Menu if it has active menu items.
 *
 */

if ( has_nav_menu( 'primary' ) ) : ?>

<!-- Begin Menu -->
    <nav id="menu">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container_class' => 'nav_primary', 'menu_id' => '', 'link_before'     => '<span>', 'link_after' => '</span>', 'menu-item' => 'menu-primary-items', 'fallback_cb' => '','depth' => 2, ) ); ?>

	</nav>

<?php endif; ?>