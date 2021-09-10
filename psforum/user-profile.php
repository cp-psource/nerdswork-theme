<?php

/**
 * User Profile
 *
 */

?>

	<?php do_action( 'psf_template_before_user_profile' ); ?>

	<div id="psf-user-profile" class="psf-user-profile">
		<h2 class="entry-title"><?php _e( 'Profil', 'social-portal' ); ?></h2>
		<div class="psf-user-section">

			<?php if ( psf_get_displayed_user_field( 'description' ) ) : ?>

				<p class="psf-user-description"><?php psf_displayed_user_field( 'description' ); ?></p>

			<?php endif; ?>

			<p class="psf-user-forum-role"><?php  printf( __( 'Forum Rolle: %s',      'social-portal' ), psf_get_user_display_role()    ); ?></p>
			<p class="psf-user-topic-count"><?php printf( __( 'Gestartete Themen: %s',  'social-portal' ), psf_get_user_topic_count_raw() ); ?></p>
			<p class="psf-user-reply-count"><?php printf( __( 'Erstellte Antworten: %s', 'social-portal' ), psf_get_user_reply_count_raw() ); ?></p>
		</div>
	</div><!-- #psf-author-topics-started -->

	<?php do_action( 'psf_template_after_user_profile' ); ?>
