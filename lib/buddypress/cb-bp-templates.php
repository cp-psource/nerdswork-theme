<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 *
 * BuddyPress Notification drop down menu
 *
 */
function cb_notification_menu() {

	if ( ! bp_is_active( 'notifications' ) ) {
		return; //make sure that notifications component is active
	}

	$count = bp_notifications_get_unread_notification_count( bp_loggedin_user_id() );
	$alert_class = (int) $count > 0 ? 'count-pending-alert' : 'count-pending-alert count-no-alert';
	?>
	<li>
		<a href="<?php echo bp_loggedin_user_domain(); ?><?php echo bp_get_notifications_slug(); ?>/"
		   title="<?php _ex( 'Benachrichtigungen', 'Header notification menu', 'social-portal' ); ?>">
			<i class="fa fa-bell"></i><span class="<?php echo $alert_class ?>"><?php echo $count; ?></span>
		</a>
		<div class="header-nav-dropdown-links">
			<?php cb_notification_menu_links(); ?>
		</div>
	</li>
	<?php
}

/**
 * My Account drop down menu
 *
 */
function cb_account_menu() {
	?>
	<li>
		<a href="<?php echo bp_loggedin_user_domain(); ?>"
		   title="<?php _ex( 'Mein Account', 'Header account menu', 'social-portal' ); ?>">
			<span class="header-username"><?php bp_loggedin_user_fullname(); ?></span><?php bp_loggedin_user_avatar( array(
				'width'  => 25,
				'height' => 25
			) ); ?>
		</a>
		<div class="header-nav-dropdown-links">
			<?php cb_user_account_menu(); ?>
			<?php //add Logout button ?>
			<ul class="logout-container">
				<li>
					<a class="logout" href="<?php echo wp_logout_url( wp_guess_url() ); ?>" title="<?php _e( 'Ausloggen', 'social-portal' ); ?>"><?php _e( 'Ausloggen', 'social-portal' ); ?></i></a>
				</li>
			</ul>

		</div>
	</li>
	<?php
}

/**
 * Members Loop action buttons
 *
 */
function cb_member_action_buttons() {

	ob_start();
	//let the buttons generate
	do_action( 'bp_directory_members_actions' );

	$buttons = ob_get_clean();

	cb_generate_action_button( $buttons, array( 'context' => 'members-list' ) );
	/*<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
	//		        title="<?php _ex( 'Actions', 'member header action buttons dropdown label', 'social-portal' ); ?>">
				<i class="fa fa-gear"></i>
		</button>
	*/

}


if ( ! function_exists( 'cb_generate_action_button') ) :
function cb_generate_action_button( $buttons, $args ) {
	$buttons = trim( $buttons );

	//$default = array( 'context'=> '', 'label'=> '' );
	//$args = wp_parse_args( $args, $default );?>

	<?php if ( ! empty( $buttons ) ): ?>
		<div class="btn-group dropup">

			<a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?php _e( 'Aktionen', 'social-portal' );?>">
				<i class="fa fa-gear"></i>
			</a>

			<div class="dropdown-menu text-left">
				<?php echo $buttons; ?>
			</div>

		</div>

	<?php endif; ?>
	<?php
}
endif;
/**
 * Single User profile Action buttons
 *
 */
function cb_displayed_member_action_buttons() {

	ob_start();
	//let the buttons generate
	do_action( 'bp_member_header_actions' );

	$buttons = ob_get_clean();
	cb_generate_action_button( $buttons, array( 'context' => 'member-header' ) );
}

function cb_friendship_action_buttons() {

	ob_start();?>
	<div class="generic-button generic-friendship-accept">
		<a class="accept" href="<?php bp_friend_accept_request_link(); ?>"><?php _e( 'Annehmen', 'social-portal' ); ?></a>
	</div>
	<div class="generic-button generic-friendship-reject">
		<a class="reject" href="<?php bp_friend_reject_request_link(); ?>"><?php _e( 'Ablehnen', 'social-portal' ); ?></a>
	</div>
<?php
	//let the buttons generate
	do_action( 'bp_friend_requests_item_action' );

	$buttons = ob_get_clean();
	cb_generate_action_button( $buttons, array( 'context' => 'friends-request' ) );
}


/**
 * Get Members not found message
 *
 * @return mixed|void
 */
function cb_get_members_notfound_message() {

	$message = __( "Es wurden leider keine Mitglieder gefunden.", 'social-portal' );

	if ( bp_is_active( 'friends' ) && bp_is_friends_component() ) {
		if ( bp_is_user_friend_requests() ) {
			$message = __( "Du hast keine ausstehende Anfrage.", 'social-portal' );
		}  elseif ( cb_is_user_friend_pending() ) {
			$message = __( "Du hast keine wartende ausstehende Anfrage.", 'social-portal' );
		} else {
			$message = __( "Entschuldigung, du hast noch keine Freunde.", 'social-portal' );
		}
	}

	return apply_filters( 'cb_members_notfound_message', $message );
}
/**
 * User Message Bulk action Dropdown Enhancement
 */
function cb_add_message_select_all_option() {

	echo "<option value='all'>" . __( 'Alle auswählen/abwählen', 'social-portal' ) . "</option>";
}
add_action( 'bp_messages_bulk_management_dropdown', 'cb_add_message_select_all_option' );


/**
 * Message Pagination text
 * @global type $messages_template
 */
function cb_messages_pagination_count() {
	global $messages_template;

	$start_num = intval( ( $messages_template->pag_page - 1 ) * $messages_template->pag_num ) + 1;
	$from_num  = bp_core_number_format( $start_num );
	$to_num    = bp_core_number_format( ( $start_num + ( $messages_template->pag_num - 1 ) > $messages_template->total_thread_count ) ? $messages_template->total_thread_count : $start_num + ( $messages_template->pag_num - 1 ) );
	$total     = bp_core_number_format( $messages_template->total_thread_count );
	$message   = sprintf( '<strong>%1$s - %2$s</strong> von <strong>%3$s</strong>', $from_num, $to_num, $total );

	echo $message;
}

/**
 * For future
 */
function cb_message_actions() {
	?>
	<a href="#" class="m-action-trash" data-action="trash"><i class="fa fa-trash"></i></a>
	<a href="#" class="m-action-star" data-action="star"><i class="fa fa-star"></i></a>
	<a href="#" class="m-action-refresh" data-action="star"><i class="fa fa-refresh"></i></a>
	<a href="#" class="m-action-refresh" data-action="star"><i class="fa fa-archive"></i></a>
	<?php
}

/**
 * Groups Directory buttons
 */
function cb_group_action_buttons() {
	ob_start();
	/**
	 * Fires inside the action section of an individual group listing item.
	 * It generates buttons
	 */
	do_action( 'bp_directory_groups_actions' );

	$buttons = ob_get_clean();

	cb_generate_action_button( $buttons, array( 'context' => 'groups-list' ) );
}
/**
 * Single User profile Action buttons
 *
 */
function cb_displayed_group_action_buttons() {

	ob_start();
	//let the buttons generate
	/**
	 * Fires in the group header actions section.
	 *
	 */
	do_action( 'bp_group_header_actions' );


	$buttons = ob_get_clean();
	cb_generate_action_button( $buttons, array( 'context' => 'group-header' ) );
}

/**
 * Action buttons for Single Group -> Members page
 */
function cb_group_member_action_buttons() {

	ob_start();
	?>
	<?php if ( bp_get_group_member_is_banned() ) : ?>
		<div class="generic-button generic-group-member-unban">
			<a href="<?php bp_group_member_unban_link(); ?>" class="confirm member-unban" title="<?php esc_attr_e( 'Sperre des Mitglieds aufheben', 'social-portal' ); ?>"><?php _e( 'Verbot entfernen', 'social-portal' ); ?></a>
		   </div>
	<?php else : ?>
		<div class="generic-button generic-group-member-ban">
			<a href="<?php bp_group_member_ban_link(); ?>" class="confirm member-ban" title="<?php esc_attr_e( 'Dieses Mitglied kicken und sperren', 'social-portal' ); ?>"><?php _e( 'Kick &amp; Verbot', 'social-portal' ); ?></a>
		</div>
		<div class="generic-button generic-group-member-promote-to-mod">
			<a href="<?php bp_group_member_promote_mod_link(); ?>" class="confirm member-promote-to-mod" title="<?php esc_attr_e( 'Zum Mod befördern', 'social-portal' ); ?>"><?php _e( 'Zum Mod befördern', 'social-portal' ); ?></a>
		</div>
		<div class="generic-button generic-group-member-promote-to-admin">
			<a href="<?php bp_group_member_promote_admin_link(); ?>" class="confirm member-promote-to-admin" title="<?php esc_attr_e( 'Zum Administrator befördern', 'social-portal' ); ?>"><?php _e( 'Zum Administrator befördern', 'social-portal' ); ?></a>
		</div>
	<?php endif; ?>
	<div class="generic-button generic-group-member-remove-from-group">
		<a href="<?php bp_group_member_remove_link(); ?>" class="confirm member-remove-from-group" title="<?php esc_attr_e( 'Dieses Mitglied entfernen', 'social-portal' ); ?>"><?php _e( 'Aus der Gruppe entfernen', 'social-portal' ); ?></a>
	</div>
	<?php
	/**
	 * Fires inside the display of a member admin item in group management area.
	 *
	 *
	 */
	do_action( 'bp_group_manage_members_admin_item' );
	?>
	<?php
	$buttons = ob_get_clean();
	cb_generate_action_button( $buttons, array( 'context' => 'group-manage-members-list' ) );
}

/**
 * Actions buttons specific to Groups Moderators on Group Member page
 */
function cb_group_mod_action_buttons() {

	ob_start();
	?>
	<div class="generic-button generic-group-member-promote-to-admin">
		<a href="<?php bp_group_member_promote_admin_link( array( 'user_id' => bp_get_member_user_id() ) ); ?>" class="confirm mod-promote-to-admin" title="<?php esc_attr_e( 'Zum Administrator befördern', 'social-portal' ); ?>">
			<?php _e( 'Zum Administrator befördern', 'social-portal' ); ?>
		</a>
	</div>
	<div class="generic-button generic-group-mod-demote-to-member">
		<a class="confirm mod-demote-to-member" href="<?php bp_group_member_demote_link( bp_get_member_user_id() ); ?>">
			<?php _e( 'Auf Mitglied zurückstufen', 'social-portal' ); ?>
		</a>
	</div>
	<?php
	do_action( 'bp_group_manage_members_admin_actions', 'mods-list' );

	$buttons = ob_get_clean();
	cb_generate_action_button( $buttons, array( 'context' => 'group-manage-mods-list' ) );
}

/**
 * Action buttons specific to Group Admins on single group page
 */
function cb_group_admin_action_buttons() {

	ob_start();
	 if ( count( bp_group_admin_ids( false, 'array' ) ) > 1 ) : ?>
		 <div class="generic-button eneric-group-mod-demote-to-member">
			<a class="confirm admin-demote-to-member" href="<?php bp_group_member_demote_link(); ?>"><?php _e( 'Auf Mitglied zurückstufen', 'social-portal' ); ?></a>
		</div>
	<?php endif; ?>
	<?php
	/**
	 * Fires inside the action section of a member admin item in group management area.
	 *
	 *
	 * @param $section which list contains this item.
	 */
	do_action( 'bp_group_manage_members_admin_actions', 'admins-list' ); ?>
	<?php
	$buttons = ob_get_clean();
	cb_generate_action_button( $buttons, array( 'context' => 'group-manage-admins-list' ) );
}

/**
 * Get the username in group invite loop
 *
 * @global type $invites_template
 * @return type
 */
function cb_get_group_invite_user_name() {
	global $invites_template;
	$user_id = intval( $invites_template->invite->user->id );

	return bp_core_get_user_displayname( $user_id );
}

/**
 * Get the user url in group invite loop
 *
 * @global type $invites_template
 * @return type
 */
function cb_get_group_invite_user_domain() {
	global $invites_template;
	$user_id = intval( $invites_template->invite->user->id );

	return bp_core_get_user_domain( $user_id );
}

/**
 * Get Group Avatar Middle size
 * @global type $invites_template
 * @return type
 */
function cb_get_group_invite_user_avatar_mid() {
	global $invites_template;
	$args = array(
		'item_id' => $invites_template->invite->user->id,
		'alt'     => sprintf( __( 'Profilfoto von %s', 'social-portal' ), $invites_template->invite->user->fullname )
	);

	$args = array_merge( $args, cb_get_bp_list_avatar_args( 'group-invite' ) );

	$avatar = bp_core_fetch_avatar( $args );
	//$invites_template->invite->user->avatar_mid = $avatar;
	/**
	 * Filters the group invite user avatar.
	 *
	 * @param string $value Group invite user avatar.
	 */
	return apply_filters( 'bp_get_group_invite_user_avatar', $avatar );
}

/**
 * Output the group member avatar while in the groups members loop.
 *
 * @since 1.0.0
 *
 * @param array|string $args {@see bp_core_fetch_avatar()}
 */
function cb_group_member_avatar( $args = '' ) {
	echo cb_get_group_member_avatar( $args );
}

/**
 * @todo revisit
 * Return the group member avatar while in the groups members loop.
 *
 * @since 1.0.0
 *
 * @param array|string $args {@see bp_core_fetch_avatar()}
 *
 * @return string
 */
function cb_get_group_member_avatar( $args = '' ) {
	global $members_template;

	$r = bp_parse_args( $args, array(
		'item_id' => $members_template->member->user_id,
		'type'    => isset( $args['type'] ) ? $args['type'] : 'full',
		'email'   => $members_template->member->user_email,
		'alt'     => sprintf( __( 'Profilbild von %s', 'social-portal' ), $members_template->member->display_name )
	) );

	/**
	 * Filters the group member avatar while in the groups members loop.
	 *
	 * @since 1.0.0
	 *
	 * @param string $value HTML markup for group member avatar.
	 * @param array $r Parsed args used for the avatar query.
	 */
	return apply_filters( 'bp_get_group_member_avatar', bp_core_fetch_avatar( $r ), $r );
}

/**
 * Blogs Directory buttons
 */
function cb_blog_action_buttons() {
	ob_start();
	/**
	 * Fires inside the action section of an individual blog listing item.
	 * It generates buttons
	 */
	do_action( 'bp_directory_blogs_actions' );

	$buttons = ob_get_clean();

	cb_generate_action_button( $buttons, array( 'context' => 'blogs-list' ) );
}

/**
 * Single Group->Invite list buttons
 */
function cb_group_invite_action_buttons() {
	ob_start();?>
	<div class="generic-button generic-invite-action-button">
		<a class="remove" href="<?php bp_group_invite_user_remove_invite_url(); ?>" id="<?php bp_group_invite_item_id(); ?>"><?php _e( 'Einladung entfernen', 'social-portal' ); ?></a>
	</div>
<?php

	/**
	 * Fires inside the action section of an individual blog listing item.
	 * It generates buttons
	 */
	do_action( 'bp_group_send_invites_item_action' );

	$buttons = ob_get_clean();

	cb_generate_action_button( $buttons, array( 'context' => 'members-group-invite' ) );
}

function cb_group_invitations_action_buttons() {
	ob_start();?>

	<a class="button accept" href="<?php bp_group_accept_invite_link(); ?>"><?php _e( 'Annehmen', 'social-portal' ); ?></a>
	<a class="button reject confirm" href="<?php bp_group_reject_invite_link(); ?>"><?php _e( 'Ablehnen', 'social-portal' ); ?></a>

	<?php

	/**
	 * Fires inside the member group item action markup.
	 */
	do_action( 'bp_group_invites_item_action' );

	$buttons = ob_get_clean();

	cb_generate_action_button( $buttons, array( 'context' => 'groups-invitation-list' ) );
}

