<?php do_action( 'bp_before_member_settings_template' ); ?>

<form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/capabilities/'; ?>" name="account-capabilities-form" id="account-capabilities-form" class="standard-form form-stacked" method="post">

	<?php

	/**
	 * Fires before the display of the submit button for user capabilities saving.
	 *
	 */
	do_action( 'bp_members_capabilities_account_before_submit' );
	?>

	<label>
		<input type="checkbox" name="user-spammer" id="user-spammer" value="1" <?php checked( bp_is_user_spammer( bp_displayed_user_id() ) ); ?> />
		 <?php _e( 'Dieser Benutzer ist ein Spammer.', 'social-portal' ); ?>
	</label>

	<div class="submit">
		<input type="submit" value="<?php esc_attr_e( 'Speichern', 'social-portal' ); ?>" id="capabilities-submit" name="capabilities-submit" />
	</div>

	<?php

	/**
	 * Fires after the display of the submit button for user capabilities saving.
	 *
	 */
	do_action( 'bp_members_capabilities_account_after_submit' );
	?>

	<?php wp_nonce_field( 'capabilities' ); ?>

</form>

<?php do_action( 'bp_after_member_settings_template' ); ?>
