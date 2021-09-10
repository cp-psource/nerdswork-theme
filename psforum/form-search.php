<?php

/**
 * Search 
 *
 */

?>

<form role="search" method="get" id="psf-search-form" action="<?php psf_search_url(); ?>">
	<div>
		<label class="screen-reader-text hidden" for="psf_search"><?php _e( 'Suchen nach:', 'social-portal' ); ?></label>
		<input type="hidden" name="action" value="psf-search-request" />
		<input tabindex="<?php psf_tab_index(); ?>" type="text" value="<?php echo esc_attr( psf_get_search_terms() ); ?>" name="psf_search" id="psf_search" />
		<input tabindex="<?php psf_tab_index(); ?>" class="button" type="submit" id="psf_search_submit" value="<?php esc_attr_e( 'Suchen', 'social-portal' ); ?>" />
	</div>
</form>
