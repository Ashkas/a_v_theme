<?php
/**
 * Header Template
 *
 */
 
// Global variables
$home_url = home_url();
$template_directory = get_bloginfo( 'template_directory' );
$site_title = get_bloginfo();
$is_home = is_home();

// ACF variables
if(function_exists('get_field')) {
	$social = get_field('social_media', 'option');
}
?>

<!doctype html>  

<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"> <!--<![endif]-->
<head <?php language_attributes(); ?>>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="HandheldFriendly" content="true">
	
	<link rel="shortcut icon" href="<?php echo $template_directory; ?>/favicon.ico">
	
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	
	<title>
		<?php 
		global $page, $paged;
		
		wp_title( '' );
	
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'a_v_theme' ), max( $paged, $page ) );	?>
	</title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); // wp_head ?>
	
	<!--[if !IE]> -->
		<style>
	    	
			/* =============================================================================
			Page load for Typekit - fades in elements while javascript is read from Type Kit
			========================================================================== */
			
			h1, h2, h3, h4,  p, li, time, code, small, dl, figcaption, span, .site_header img, blockquote, img, .main_content, nav, address {
			    opacity: 0;
			    visibility: hidden; /* Old IE */
			}
			
			.wf-loading .main_content {
				opacity: 1;
			    visibility: visible; /* Old IE */
				background: 
					url(data:image/gif;base64,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) center 50px no-repeat;
			}
			
			.wf-active h1, .wf-active h2, .wf-active h3, .wf-active h4, .wf-active p, .wf-active li, .wf-active time,
			.wf-active pre, .wf-active small, .wf-active dl, .wf-active figcaption, .wf-active span, .wf-active .site_header img, p.sass_error, .wf-active img, .wf-active blockquote, .wf-active .main_content, .wf-active nav, .wf-active address {
			    opacity: 1;
			    visibility: visible; /* Old IE */
			    -webkit-transition: opacity 0.24s ease-in-out;
			       -moz-transition: opacity 0.24s ease-in-out;
			            transition: opacity 0.24s ease-in-out;
			}
			
			.wf-active {
				background: none;
			}
			
		</style>
	<!-- <![endif]-->

</head>

<body <?php body_class(); ?> id="top">

	<!-- Full layout wrapper for the off canvas menu -->
	<div class="offcanvas_over">
	
		<!-- Wrap for off-canvas menu -->
		<div class="wrap" id="wrap">
			<header role="banner" id="top" class="site_header">
				<div class="header_top large_device" id="showTop">
					<div class="large_inline_block header_top_content">
						<?php
							if($social):
								echo '<div class="large_device_inline">'.$social.'</div>';
							endif;
						?>
					</div>
				</div>
				<div class="header_content">
					<nav id="nav_anchor_container" class="mob_1 mob_col_gutter tab_2 tab_col_gutter">
						
						<ul id="nav_anchors" class="nav_anchors">
							<li><a id="sidebarButton" href="#menu" class="block menu-link"><span class="landscape_and_up">MENU</span> <span aria-hidden="true" class="icon-list"></span></a></li> 
						</ul>
					</nav>
					
					<div class="mob_2 mob_col_gutter tab_2 tab_col_gutter desk_2 desk_large_3 desk_col_gutter banner">
						<a href="<?php echo $home_url; ?>" title="Return to home">
							<figure>
								<!--[if lte IE 8]><img src="<?php echo $template_directory; ?>/library/images/logo_web_hori.png" alt="<?php echo $site_title; ?>"/><![endif]-->	
								<img src="<?php echo $template_directory; ?>/library/images/logo_web_hori.svg" alt="<?php echo $site_title; ?>"/>
							</figure>
							<h1 class="banner_title">
								<?php echo $site_title; ?>
							</h1>
						</a>
					</div> <!-- desk_4 desk_large_6  -->
					
					<div class="mob_1 tab_2 header_search desk_6 desk_large_9" id="showTop">
						<span class="icon-search" id="search_toggle"><span class="landscape_and_up seach_label_text">SEARCH</span></span>
						<!-- Desktop Menu -->
						<nav id="nav" class="nav reveal desktop_device">
						    <div class="navbar_inner">
						    	<?php get_template_part( 'menu', 'primary' ); // Loads the menu-primary.php template. ?>
						    </div>
					  	</nav>

					</div>
					<div class="clearfix"></div>
					
					<div class="sb-search" id="sb-search">
						<form method="get" class="search_form" action="<?php echo trailingslashit( home_url() ); ?>">
							<input class="sb-search-input" id="search" type="search" name="s" value="<?php echo sanitize_text_field($_GET['q']); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
							<input class="sb-search-submit" name="submit" type="submit" value="<?php esc_attr_e( 'Search', 'a_v_theme' ); ?>" />
						</form><!-- .search_form -->
					</div>
					
					<div class="clearfix"></div>
					<!--
<?php if($is_home): ?>
						<span class="small_device">
							<h1 class="banner_title">
								<span class="red">J</span>apan Camera Hunter
							</h1>
						</span>
					<?php endif;?>
-->
					
					<?php //dynamic_sidebar('header-widget'); ?>
					
				</div> <!-- header_content -->
			</header><!-- #header -->
			
			<?php get_template_part( 'menu', 'primary-oc' ); // Loads the menu-primary-oc.php template. ?>
				
			<noscript>
				<p>You can see this message as you have JavaScript turned off. While the basic website will work, key functions and some of the usability will not. The Typography of the website also requires Javascript for best optimsation. It is recommended you turn on JavaScript.</p>
			</noscript>	