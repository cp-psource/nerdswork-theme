<?php
/**
 * Is it the Pending Friendship Screen?
 *
 * @return bool
 */
function cb_is_user_friend_pending() {

	if ( bp_is_friends_component() && bp_is_current_action( 'pending' ) ) {
		return true;
	}

	return false;
}

/**
 * Is it declined Friendship screen?
 *
 * @return bool
 */
function cb_is_user_friend_declined() {

	if ( bp_is_friends_component() && bp_is_current_action( 'declined' ) ) {
		return true;
	}

	return false;
}

/**
 * Was this friendship accepted by the given/logged in user?
 *
 * @param object $friendship
 * @return boolean
 */
function cb_is_friendship_accepted_user( $friendship, $user_id = null  ) {

	if ( ! $user_id ) {
		$user_id = bp_loggedin_user_id();
	}

	if ( $friendship->friend_user_id == $user_id ) {
		return true;
	}

	return false;
}

/**
 * Get all pending requests for the user
 * It includes sent by me and received by me
 *
 * @global wpdb $wpdb
 * @param int $user_id
 * @return array of user ids
 */
function cb_get_pending_request_user_ids( $user_id ) {

	$bp = buddypress();

	$friend_requests = wp_cache_get( 'bp-pending-friendship-' . $user_id, 'bp' );

	if ( false === $friend_requests ) {
		global $wpdb;

		$query =  $wpdb->prepare( "SELECT friend_user_id FROM {$bp->friends->table_name} WHERE initiator_user_id = %d AND  is_limited = 0 and is_confirmed = 0 ", $user_id );
		$friend_requests = $wpdb->get_col( $query );

		wp_cache_set( 'bp-pending-friendship-' . $user_id, $friend_requests, 'bp' );
	}

	return $friend_requests;
}

function cb_get_friendship_id( $user_id, $friend_id ) {
	global $wpdb;
	$bp = buddypress();
	return $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$bp->friends->table_name} WHERE ( initiator_user_id = %d AND friend_user_id = %d ) OR ( initiator_user_id = %d AND friend_user_id = %d ) ", $user_id, $friend_id, $friend_id, $user_id ) );
}

function cb_get_friendship( $user_id, $friend_id  ){

	$friendship_id = cb_get_friendship_id( $user_id, $friend_id );

	$friendship = new BP_Friends_Friendship( $friendship_id );

	return $friendship;
}

/**
 * Get the date when these users became friends
 *
 * @param $friend_id
 *
 * @return string
 */
function cb_get_friendship_date( $user_id, $friend_id ){

	$friendship = cb_get_friendship( $user_id, $friend_id );

	return date_i18n( 'F j, Y', strtotime( $friendship->date_created ) );
}
