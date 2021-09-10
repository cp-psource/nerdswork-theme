<?php

/**
 * Single Forum Content Part
 *
 */

?>

<div id="psforum-forums">

	<?php do_action( 'psf_template_before_single_forum' ); ?>

	<?php if ( post_password_required() ) : ?>
		<?php psf_get_template_part( 'form', 'protected' ); ?>
	<?php else : ?>

		<?php if ( psf_has_forums() ) : ?>
			<?php psf_get_template_part( 'loop', 'forums' ); ?>
		<?php endif; ?>

		<?php if ( ! psf_is_forum_category() && psf_has_topics() ) : ?>

			<?php //psf_get_template_part( 'pagination', 'topics'    ); ?>

			<?php psf_get_template_part( 'loop',       'topics'    ); ?>

			<?php psf_get_template_part( 'pagination', 'topics'    ); ?>

			<?php psf_get_template_part( 'form',       'topic'     ); ?>

		<?php elseif ( ! psf_is_forum_category() ) : ?>
			<?php psf_get_template_part( 'form',       'topic'     ); ?>
		<?php endif; ?>

	<?php endif; ?>

	<?php do_action( 'psf_template_after_single_forum' ); ?>

</div>
