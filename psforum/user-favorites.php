<?php

/**
 * User Favorites
 *
 */

?>

	<?php do_action( 'psf_template_before_user_favorites' ); ?>

	<div id="psf-user-favorites" class="psf-user-favorites">
		<h2 class="entry-title"><?php _e( 'Lieblingsforenthemen', 'social-portal' ); ?></h2>
		<div class="psf-user-section">

			<?php if ( psf_get_user_favorites() ) : ?>

				<?php psf_get_template_part( 'loop',       'topics' ); ?>

				<?php psf_get_template_part( 'pagination', 'topics' ); ?>

			<?php else : ?>
			<div class="psf-template-notice info psf-no-favorite">
				<p><?php psf_is_user_home() ? _e( 'Du hadt derzeit keine Lieblingsthemen.', 'social-portal' ) : _e( 'Dieser Benutzer hat keine Lieblingsthemen.', 'social-portal' ); ?></p>
			</div>	
			<?php endif; ?>

		</div>
	</div><!-- #psf-user-favorites -->

	<?php do_action( 'psf_template_after_user_favorites' ); ?>
