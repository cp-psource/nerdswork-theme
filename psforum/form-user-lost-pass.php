<?php

/**
 * User Lost Password Form
 *
 */

?>

<form method="post" action="<?php psf_wp_login_action( array( 'action' => 'lostpassword', 'context' => 'login_post' ) ); ?>" class="psf-login-form">
	<fieldset class="psf-form">
		<legend><?php _e( 'Lost Password', 'social-portal' ); ?></legend>

		<div class="psf-username">
			<p>
				<label for="user_login" class="hide"><?php _e( 'Username or Email', 'social-portal' ); ?>: </label>
				<input type="text" name="user_login" value="" size="20" id="user_login" tabindex="<?php psf_tab_index(); ?>" />
			</p>
		</div>

		<?php do_action( 'login_form', 'resetpass' ); ?>

		<div class="psf-submit-wrapper">

			<button type="submit" tabindex="<?php psf_tab_index(); ?>" name="user-submit" class="submit user-submit"><?php _e( 'Reset My Password', 'social-portal' ); ?></button>

			<?php psf_user_lost_pass_fields(); ?>

		</div>
	</fieldset>
</form>
