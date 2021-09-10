<?php

/**
 * User Registration Form
 *
 */

?>

<form method="post" action="<?php psf_wp_login_action( array( 'context' => 'login_post' ) ); ?>" class="psf-login-form">
	<fieldset class="psf-form">
		<legend><?php _e( 'Create an Account', 'social-portal' ); ?></legend>

		<div class="psf-template-notice">
			<p><?php _e( 'Your username must be unique, and cannot be changed later.', 'social-portal' ) ?></p>
			<p><?php _e( 'We use your email address to email you a secure password and verify your account.', 'social-portal' ) ?></p>

		</div>

		<div class="psf-username">
			<label for="user_login"><?php _e( 'Username', 'social-portal' ); ?>: </label>
			<input type="text" name="user_login" value="<?php psf_sanitize_val( 'user_login' ); ?>" size="20" id="user_login" tabindex="<?php psf_tab_index(); ?>" />
		</div>

		<div class="psf-email">
			<label for="user_email"><?php _e( 'Email', 'social-portal' ); ?>: </label>
			<input type="text" name="user_email" value="<?php psf_sanitize_val( 'user_email' ); ?>" size="20" id="user_email" tabindex="<?php psf_tab_index(); ?>" />
		</div>

		<?php do_action( 'register_form' ); ?>

		<div class="psf-submit-wrapper">

			<button type="submit" tabindex="<?php psf_tab_index(); ?>" name="user-submit" class="submit user-submit"><?php _e( 'Register', 'social-portal' ); ?></button>

			<?php psf_user_register_fields(); ?>

		</div>
	</fieldset>
</form>
