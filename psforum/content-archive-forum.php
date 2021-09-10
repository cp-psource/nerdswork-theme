<?php

/**
 *
 *	/forums screen
 *
 * Archive Forum Content Part
 *
 */

?>
<div id="psforum-forums">

	<?php do_action( 'psf_template_before_forums_index' ); ?>

	<?php if ( psf_has_forums() ) : ?>
		<?php psf_get_template_part( 'loop',     'forums'    ); ?>
	<?php else : ?>
		<?php psf_get_template_part( 'feedback', 'no-forums' ); ?>
	<?php endif; ?>

	<?php do_action( 'psf_template_after_forums_index' ); ?>

</div>
