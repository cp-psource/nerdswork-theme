<?php

/**
 * Single View Content Part
 *
 */

?>

<div id="psforum-forums">


	<?php psf_set_query_name( psf_get_view_rewrite_id() ); ?>

	<?php if ( psf_view_query() ) : ?>

		<?php psf_get_template_part( 'loop',       'topics'    ); ?>

		<?php psf_get_template_part( 'pagination', 'topics'    ); ?>

	<?php else : ?>

		<?php psf_get_template_part( 'feedback',   'no-topics' ); ?>

	<?php endif; ?>

	<?php psf_reset_query_name(); ?>

</div>
