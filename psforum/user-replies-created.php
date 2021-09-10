<?php

/**
 * User Replies Created
 *
 */

?>

	<?php do_action( 'psf_template_before_user_replies' ); ?>

	<div id="psf-user-replies-created" class="psf-user-replies-created">
		<h2 class="entry-title"><?php _e( 'Forum Replies Created', 'social-portal' ); ?></h2>
		<div class="psf-user-section">

			<?php if ( psf_get_user_replies_created() ) : ?>

				<?php psf_get_template_part( 'loop',       'replies' ); ?>

				<?php psf_get_template_part( 'pagination', 'replies' ); ?>

			<?php else : ?>

				<p><?php psf_is_user_home() ? _e( 'You have not replied to any topics.', 'social-portal' ) : _e( 'This user has not replied to any topics.', 'social-portal' ); ?></p>

			<?php endif; ?>

		</div>
	</div><!-- #psf-user-replies-created -->

	<?php do_action( 'psf_template_after_user_replies' ); ?>
