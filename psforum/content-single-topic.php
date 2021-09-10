<?php

/**
 * Single Topic Content Part
 *
 */

?>

<div id="psforum-forums">
	<?php do_action( 'psf_template_before_single_topic' ); ?>

	<?php if ( post_password_required() ) : ?>
		<?php psf_get_template_part( 'form', 'protected' ); ?>
	<?php else : ?>

		<?php psf_topic_tag_list(); ?>

		<?php if ( psf_show_lead_topic() ) : ?>
			<?php psf_get_template_part( 'content', 'single-topic-lead' ); ?>
		<?php endif; ?>

		<?php if ( psf_has_replies() ) : ?>

			<?php psf_get_template_part( 'loop',       'replies' ); ?>

			<?php psf_get_template_part( 'pagination', 'replies' ); ?>

		<?php endif; ?>
		<?php psf_get_template_part( 'form', 'reply' ); ?>
	<?php endif; ?>

	<?php do_action( 'psf_template_after_single_topic' ); ?>

</div>
