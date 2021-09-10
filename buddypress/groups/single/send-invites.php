<?php
/**
 * BuddyPress - Groups Send Invites
 *
 */

/**
 * Fires before the send invites content.
 *
 */
do_action( 'bp_before_group_send_invites_content' ); ?>

<?php
/* Does the user have friends that could be invited to the group? */
if ( bp_get_new_group_invite_friend_list() ) : ?>

	<?php /* 'send-invite-form' is important for AJAX support */ ?>
	<form action="<?php bp_group_send_invite_form_action(); ?>" method="post" id="send-invite-form" class="standard-form">

		<div class="invite">
			<?php bp_get_template_part( 'groups/single/invites-loop' ); ?>
		</div>

		<div class="submit">
			<input type="submit" name="submit" id="submit" value="<?php esc_attr_e( 'Sende Einladungen', 'social-portal' ); ?>" />
		</div>

		<?php wp_nonce_field( 'groups_send_invites', '_wpnonce_send_invites' ); ?>

		<?php /* This is important, don't forget it */ ?>
		<input type="hidden" name="group_id" id="group_id" value="<?php bp_group_id(); ?>" />

	</form><!-- #send-invite-form -->

<?php
/* No eligible friends? Maybe the user doesn't have any friends yet. */
elseif ( 0 == bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>

	<div id="message" class="info">
		<p class="notice"><?php _e( 'Gruppeneinladungen können nur an Freunde weitergegeben werden.', 'social-portal' ); ?></p>
		<p class="message-body"><?php _e( "Sobald Du einige Freundschaften geschlossen hast, kannst Du diese Mitglieder zu dieser Gruppe einladen.", 'social-portal' ); ?></p>
	</div>

<?php
/* The user does have friends, but none are eligible to be invited to this group. */
else : ?>

	<div id="message" class="info">
		<p class="notice"><?php _e( 'Alle deine Freunde gehören bereits zu dieser Gruppe.', 'social-portal' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the send invites content.
 *
 */
do_action( 'bp_after_group_send_invites_content' );