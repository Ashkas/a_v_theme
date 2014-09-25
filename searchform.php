<?php
/**
 * Search Form Template
 *
 * The search form template displays the search form.
 *
 */
?>
<div class="search">

	<form method="get" class="search-form" action="<?php echo trailingslashit( home_url() ); ?>">
	<div>
		<input class="search-text" type="search" name="s" value="<?php echo sanitize_text_field($_GET['q']); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
		<br clear="all"/><br>
		<input class="search-submit button" name="submit" type="submit" value="<?php esc_attr_e( 'Search', 'anzam' ); ?>" />
		<br clear="all"/><br>
	</div>
	</form><!-- .search-form -->

</div><!-- .search -->