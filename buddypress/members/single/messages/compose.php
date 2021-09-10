<form action="<?php bp_messages_form_action('compose' ); ?>" method="post" id="send_message_form" class="standard-form form-stacked" enctype="multipart/form-data">

	<?php

	/**
	 * Fires before the display of message compose content.
	 *
	 */
	do_action( 'bp_before_messages_compose_content' );
	?>

	<label for="send-to-input"><?php _e("Senden an (Benutzername oder Name des Freundes)", 'social-portal' ); ?></label>
	<ul class="first acfb-holder">
		<li>
			<?php bp_message_get_recipient_tabs(); ?>
			<input type="text" name="send-to-input" class="send-to-input" id="send-to-input" />
		</li>
	</ul>

	<?php if ( bp_current_user_can( 'bp_moderate' ) ) : ?>
	<label><input type="checkbox" id="send-notice" name="send-notice" value="1" /> <?php _e( "Dies ist ein Hinweis für alle Benutzer.", 'social-portal' ); ?></label>
	<?php endif; ?>

	<label for="subject"><?php _e( 'Betreff', 'social-portal' ); ?></label>
	<input type="text" name="subject" id="subject" value="<?php bp_messages_subject_value(); ?>" />

	<label for="content"><?php _e( 'Nachricht', 'social-portal' ); ?></label>
	<textarea name="content" id="message_content" rows="5" cols="40"><?php bp_messages_content_value(); ?></textarea>

	<input type="hidden" name="send_to_usernames" id="send-to-usernames" value="<?php bp_message_get_recipient_usernames(); ?>" class="<?php bp_message_get_recipient_usernames(); ?>" />

	<?php

	/**
	 * Fires after the display of message compose content.
	 *
	 */
	do_action( 'bp_after_messages_compose_content' );
	?>

	<div class="submit">
		<input type="submit" value="<?php esc_attr_e( "Nachricht senden", 'social-portal' ); ?>" name="send" id="send" />
	</div>

	<?php wp_nonce_field( 'messages_send_message' ); ?>
</form>

<script type="text/javascript">
	document.getElementById("send-to-input").focus();
</script>