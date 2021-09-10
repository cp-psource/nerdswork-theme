<?php

/**
 * Search Content Part
 *
 */

?>

<div id="psforum-forums">

	<?php psf_set_query_name( psf_get_search_rewrite_id() ); ?>

	<?php do_action( 'psf_template_before_search' ); ?>

	<?php if ( psf_has_search_results() ) : ?>
		 <?php psf_get_template_part( 'loop',       'search' ); ?>

		 <?php psf_get_template_part( 'pagination', 'search' ); ?>
	<?php elseif ( psf_get_search_terms() ) : ?>
		 <?php psf_get_template_part( 'feedback',   'no-search' ); ?>
	<?php else : ?>
		<?php psf_get_template_part( 'form', 'search' ); ?>
	<?php endif; ?>

	<?php do_action( 'psf_template_after_search_results' ); ?>

</div>

