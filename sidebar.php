<?php 

	//Reusable variables
	$home_url = home_url();
	$page = get_queried_object();
	$page_id = $page->ID;
	$page_parent = $page->post_parent;	
	
	if(is_category() || is_archive() || is_tag()):
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
			'after'           => ' | ',
			'link_before'     => '',
			'link_after'      => '',
			'items_wrap'      => '%3$s',
			'depth'           => 1					
		);
		
		/* Put the nav menu into a variable to check whether it is set or not */
		$nav_menu = wp_nav_menu($nav_args);
		// Only display hot tags if $nav_menu is not empty
		if(!(empty($nav_menu))) { ?>
			<nav class="tab_5 desk_6 desk_large_8 margin_auto centre_text small_border_top">
				<ul class="double_single_block menu inline_list">
					<?php 
					// Remove last |
					$nav_menu = preg_replace('/\|[^|]*$/', '', $nav_menu);
					
					echo $nav_menu; ?>
				</ul> 
			</nav> 
		<?php }
	endif;
	
	if(is_page()):				
		$current = $post->ID;
		$parent = $post->post_parent;
		$grandparent_get = get_post($parent);
		$grandchild = $grandparent_get->post_parent;
		$has_children = has_children($post->ID);
		
		if($parent) {
			
			if(!$grandchild && $parent):
				$child_of_value = ( $post->post_parent ? $post->post_parent : $post->ID );
				// Depth of 2 if parent page, else depth of 1
				$depth_value = ( $post->post_parent ? 2 : 1 );
				
				$walker = new Short_Name_Walker();
				$wp_list_pages = wp_list_pages( array(
				    // Only pages that are children of the current page
				    'child_of' => $post->post_parent,
				    'depth' => 1,
				    'title_li' => '',
				    'walker' => $walker,
				    'echo' => 0,
				) );
				
				// Remove last |
				$wp_list_pages = preg_replace('/\|[^|]*$/', '', $wp_list_pages);
				//echo '2';
			elseif($grandchild):
				$child_of_value = ( $post->post_parent ? $post->post_parent : $post->ID );
				// Depth of 2 if parent page, else depth of 1
				$depth_value = ( $post->post_parent ? 2 : 1 );
				
				$walker = new Short_Name_Walker();
				$wp_list_pages = wp_list_pages( array(
				    // Only pages that are children of the current page
				    'child_of' => $grandchild,
				    'depth' => 1,
				    'title_li' => '',
				    'walker' => $walker,
				    'echo' => 0
				) );
				
				// Remove last |
				$wp_list_pages = preg_replace('/\|[^|]*$/', '', $wp_list_pages);
				//echo '3';
			else:
				
				$walker = new Short_Name_Walker();
				$wp_list_pages = wp_list_pages( array(
				    // Only pages that are children of the current page
				    'child_of' => $post->ID,
				    'depth' => 1,
				    'title_li' => '',
				    'walker' => $walker,
				    'echo' => 0,
				) );
				
				// Remove last |
				$wp_list_pages = preg_replace('/\|[^|]*$/', '', $wp_list_pages);
				//echo '4';
			endif;
		} else {
			$walker = new Short_Name_Walker();
			$wp_list_pages = wp_list_pages( array(
			    // Only pages that are children of the current page
			    'child_of' => $post->ID,
			    'depth' => 1,
			    'title_li' => '',
			    'walker' => $walker,
			    'echo' => 0,
			) );
			
			// Remove last |
			$wp_list_pages = preg_replace('/\|[^|]*$/', '', $wp_list_pages);
			//echo '5'; 
		}
		
		if($wp_list_pages): ?>
			<nav class="tab_5 desk_6 desk_large_8 margin_auto centre_text small_border_top">
				<ul class="double_single_block menu inline_list">
					<?php echo $wp_list_pages; ?>
				</ul>
			</nav>	
		<?php endif;
	endif;
?>