<?php do_action( 'bp_before_member_settings_template' ); ?>

<div id="message" class="info">

	<?php if ( bp_is_my_profile() ) : ?>
		<p><?php _e( 'Durch das Löschen Deines Kontos werden alle von Dir erstellten Inhalte gelöscht. Es wird vollständig unwiederbringlich sein.', 'social-portal' ); ?></p>
	<?php else : ?>
		<p><?php _e( 'Durch Löschen dieses Kontos werden alle von ihm erstellten Inhalte gelöscht. Es wird vollständig unwiederbringlich sein.', 'social-portal' ); ?></p>
	<?php endif; ?>

</div>

<form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/delete-account'; ?>" name="account-delete-form" id="account-delete-form" class="standard-form form-stacked" method="post">

	<?php

	/**
	 * Fires before the display of the submit button for user delete account submitting.
	 *
	 */
	do_action( 'bp_members_delete_account_before_submit' );
	?>

	<label>
		<input type="checkbox" name="delete-account-understand" id="delete-account-understand" value="1" onclick="if(this.checked) { document.getElementById('delete-account-button').disabled = ''; } else { document.getElementById('delete-account-button').disabled = 'disabled'; }" />
		<?php _e( 'Ich verstehe die Konsequenzen.', 'social-portal' ); ?>
	</label>

	<div class="submit">
		<input type="submit" disabled="disabled" value="<?php esc_attr_e( 'Konto löschen', 'social-portal' ); ?>" id="delete-account-button" name="delete-account-button" />
	</div>

	<?php

	/**
	 * Fires after the display of the submit button for user delete account submitting.
	 *
	 */
	do_action( 'bp_members_delete_account_after_submit' );
	?>

	<?php wp_nonce_field( 'delete-account' ); ?>

</form>

<?php do_action( 'bp_after_member_settings_template' ); ?>