<?php

/**
 * Archive Topic Content Part
 *
 */

?>

<div id="psforum-forums">
	<?php do_action( 'psf_template_before_topics_index' ); ?>

	<?php if ( psf_has_topics() ) : ?>
		<?php //psf_get_template_part( 'pagination', 'topics'    ); ?>
		<?php psf_get_template_part( 'loop',       'topics'    ); ?>

		<?php psf_get_template_part( 'pagination', 'topics'    ); ?>
	<?php else : ?>
		<?php psf_get_template_part( 'feedback',   'no-topics' ); ?>
	<?php endif; ?>

	<?php do_action( 'psf_template_after_topics_index' ); ?>

</div>
