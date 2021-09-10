<?php
/**
 * BuddyPress User Activation Page
 */
?>
<div id="buddypress">

	<?php

	/**
	 * Fires before the display of the member activation page.
	 *
	 */
	do_action( 'bp_before_activation_page' );
	?>

	<div class="page" id="activate-page">

		<?php

		/**
		 * Fires before the display of the member activation page content.
		 *
		 */
		do_action( 'bp_before_activate_content' );
		?>

		<?php if ( bp_account_was_activated() ) : ?>

			<?php if ( isset( $_GET['e'] ) ) : ?>
				<p><?php _e( 'Dein Konto wurde erfolgreich aktiviert! Deine Kontodaten wurden Dir in einer separaten E-Mail zugesandt.', 'social-portal' ); ?></p>
			<?php else : ?>
				<p><?php printf( __( 'Dein Konto wurde erfolgreich aktiviert! Du kannst Dich jetzt mit dem Benutzernamen und Passwort, die Du bei der Anmeldung angegeben hast <a href="%s">anmelden</a>.', 'social-portal' ), wp_login_url( bp_get_root_domain() ) ); ?></p>
			<?php endif; ?>

		<?php else : ?>

			<p><?php _e( 'Please provide a valid activation key.', 'social-portal' ); ?></p>

			<form action="" method="get" class="standard-form" id="activation-form">

				<label for="key"><?php _e( 'Aktivierungsschlüssel:', 'social-portal' ); ?></label>
                <input type="text" name="key" id="key" value="<?php echo esc_attr( bp_get_current_activation_key() ); ?>" />

                <p class="submit">
					<input type="submit" name="submit" value="<?php esc_attr_e( 'Aktivieren', 'social-portal' ); ?>"/>
				</p>

			</form>

		<?php endif; ?>

		<?php

		/**
		 * Fires after the display of the member activation page content.
		 *
		 */
		do_action( 'bp_after_activate_content' );
		?>

	</div><!-- .page -->

	<?php

	/**
	 * Fires after the display of the member activation page.
	 *
	 */
	do_action( 'bp_after_activation_page' );
	?>

</div><!-- #buddypress -->
