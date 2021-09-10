<div id="message" class="info">

	<?php if ( bp_is_current_action( 'unread' ) ) : ?>

		<?php if ( bp_is_my_profile() ) : ?>
			<p><?php _e( 'Du hast keine ungelesenen Benachrichtigungen.', 'social-portal' ); ?></p>
		<?php else : ?>
			<p><?php _e( 'Dieses Mitglied hat keine ungelesenen Benachrichtigungen.', 'social-portal' ); ?></p>
		<?php endif; ?>
			
	<?php else : ?>

		<?php if ( bp_is_my_profile() ) : ?>
			<p><?php _e( 'Du hast keine Benachrichtigungen.', 'social-portal' ); ?></p>
		<?php else : ?>
			<p><?php _e( 'Dieses Mitglied hat keine Benachrichtigungen.', 'social-portal' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

</div>
