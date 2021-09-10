<?php
/**
 * Get the registration group to be visible on the registration page
 *
 * @return type
 */
function cb_get_registration_groups() {
	return apply_filters( 'cb_get_registration_groups', 1 );// return an array or comma separated group ids
}

/**
 * Show Members header
 * @return mixed|void
 */
function cb_show_members_header() {
	return apply_filters( 'cb_show_members_header', true );
}

/**
 * Show Main Horizontal User Menu
 * @return mixed|void
 */
function cb_show_members_horizontal_main_nav() {
	return apply_filters( 'cb_show_members_horizontal_main_nav', true );
}

function cb_group_status_icon( $group = false ) {

	$classes = 'fa ';

	if ( bp_get_group_status( $group ) == 'public' ) {
		$classes .= 'fa-unlock-alt';
	} else {
		$classes .= 'fa-lock';
	}

	$title = bp_get_group_type( $group );

	echo "<span class='bp-group-status' title ='" . esc_attr( $title ) . "'><i class='{$classes}'></i></span>";
}

function cb_group_member_count( $group = false ) {

	global $groups_template;

	if ( ! $group ) {
		$group = isset( $groups_template->group ) ? $groups_template->group : false;
	}
	//$groups_template->group->

	if ( isset( $group->total_member_count ) ) {
		$count = (int) $group->total_member_count;
	} else {
		$count = 0;
	}

	$count_string = sprintf( _n( '%s Mitglied', '%s Mitglieder', $count, 'social-portal' ), bp_core_number_format( $count ) );

	$count_html = "<span class='item-meta-count bp-group-member-count' title='" . esc_attr( $count_string ) . "'>{$count}</span>";
	echo $count_html;
}

/**
 * Get the args controlling the dimensions of list avatars
 *
 * Controls the height/width/type args
 */
function cb_get_bp_list_avatar_args( $context = false ) {

	$size = cb_get_option( 'bp-item-list-avatar-size' );

	if ( $size > BP_AVATAR_THUMB_WIDTH ) {
		$type = 'full';
	} else {
		$type = 'thumb';
	}

	return array( 'type' => $type, 'height' => $size, 'width' => $size );
}

/**
 * Is BuddyPress Groups Active?
 *
 * @staticvar type $is_active
 * @return boolean
 */
function cb_is_bp_groups_active() {

	static $is_active;

	if ( isset( $is_active ) ) {
		return $is_active;
	}

	if ( cb_is_bp_active() && bp_is_active( 'groups' ) ) {
		$is_active = true;
	} else {
		$is_active = false;
	}

	return $is_active;
}

/**
 * Is BuddyPress Activity Active?
 *
 * @staticvar type $is_active
 * @return boolean
 */
function cb_is_bp_activity_active() {

	static $is_active;

	if ( isset( $is_active ) ) {
		return $is_active;
	}

	if ( cb_is_bp_active() && bp_is_active( 'activity' ) ) {
		$is_active = true;
	} else {
		$is_active = false;
	}

	return $is_active;
}

/**
 * Is BuddyPress Blogs Active?
 *
 * @staticvar boolean $is_active
 * @return boolean
 */
function cb_is_bp_blogs_active() {

	static $is_active;

	if ( isset( $is_active ) ) {
		return $is_active;
	}

	if ( cb_is_bp_active() && bp_is_active( 'blogs' ) ) {
		$is_active = true;
	} else {
		$is_active = false;
	}

	return $is_active;
}

/**
 * Get the user id based on given context
 *
 * @param string $context
 *
 * @return int
 */
function cb_bp_shortcode_get_context_user_id( $context = 'logged' ) {

	if ( $context == 'logged' ) {
		return bp_loggedin_user_id();
	} elseif( $context == 'displayed' ) {
		return bp_displayed_user_id();
	}
}

/**
 * Get the type parameter for avatar fetching based on the needed image size
 *
 * @param $size
 *
 * @return string
 */

function cb_get_avatar_image_type( $size ) {
	if ( $size > BP_AVATAR_THUMB_WIDTH ) {
		$type = 'full';
	} else {
		$type = 'thumb';
	}

	return $type;
}

/**
 * Get Item display Type
 *
 * @return string
 */
function cb_bp_get_item_display_type() {
	return apply_filters( 'cb_bp_item_display_type', cb_get_option( 'bp-item-list-display-type', 'masonry' ) );
}

/**
 * Get item list class
 *
 * @param string $classes
 *
 * @return mixed
 */
function cb_bp_get_item_list_class( $classes = '' ) {
	return apply_filters( 'cb_bp_item_list_class', $classes . ' item-list-' . cb_bp_get_item_display_type() );
}
/**
 * Helper method to set the members per page for the current context
 *
 * @param $per_page
 */
function cb_bp_set_members_per_page( $per_page = 0 ) {

	if ( ! $per_page ) {
		$per_page = cb_get_option( 'bp-members-per-page' );
	}

	combuilder()->members_per_page = $per_page;
}

/**
 * Helper to setup no. of members per row for the current context
 *
 * @param $per_row
 */
function cb_bp_set_members_per_row( $per_row = 0 ) {

	if ( ! $per_row ) {
		$per_row = cb_get_option( 'bp-members-per-row' );
	}

	combuilder()->members_per_row = $per_row;
}

/**
 *
 * Get the no. of members per page to list
 *
 * @param null $context
 *
 * @return mixed|null
 */
function cb_bp_get_members_per_page( $context = null ) {

	$per_page = combuilder()->members_per_page;

	if ( empty( $per_page ) ) {
		$per_page = cb_get_option( 'bp-members-per-page' );
		combuilder()->members_per_page = $per_page;//store for next time, ok
	}

	return $per_page;
}

/**
 * Get members per row setting
 *
 * @param null $context
 *
 * @return mixed|null
 */
function cb_bp_get_members_per_row( $context = null ) {

	$per_row = combuilder()->members_per_row;

	if ( empty( $per_row ) ) {
		$per_row = cb_get_option( 'bp-members-per-row' );
		combuilder()->members_per_row = $per_row;//store for next time, ok
	}

	return $per_row;
}

/**
 * Helper method to set the groups per page for the current context
 *
 * @param $per_page
 */
function cb_bp_set_groups_per_page( $per_page = 0 ) {

	if ( ! $per_page ) {
		$per_page = cb_get_option( 'bp-groups-per-page' );
	}

	combuilder()->groups_per_page = $per_page;
}

/**
 * Helper to setup no. of groups per row for the current context
 *
 * @param $per_row
 */
function cb_bp_set_groups_per_row( $per_row = 0 ) {

	if ( ! $per_row ) {
		$per_row = cb_get_option( 'bp-groups-per-row' );
	}

	combuilder()->groups_per_row = $per_row;
}

/**
 *
 * Get the no. of groups per page to list
 *
 * @param null $context
 *
 * @return mixed|null
 */
function cb_bp_get_groups_per_page( $context = null ) {

	$per_page = combuilder()->groups_per_page;

	if ( empty( $per_page ) ) {
		$per_page = cb_get_option( 'bp-groups-per-page' );
		combuilder()->groups_per_page = $per_page;
	}

	return $per_page;
}

/**
 * Get groups per row setting
 *
 * @param null $context
 *
 * @return mixed|null
 */
function cb_bp_get_groups_per_row( $context = null ) {

	$per_row = combuilder()->groups_per_row;

	if ( empty( $per_row ) ) {
		$per_row = cb_get_option( 'bp-groups-per-row' );
		combuilder()->groups_per_row = $per_row;
	}

	return $per_row;
}
// New

/**
 * Helper method to set the groups per page for the current context
 *
 * @param $per_page
 */
function cb_bp_set_blogs_per_page( $per_page = 0 ) {

	if ( ! $per_page ) {
		$per_page = cb_get_option( 'bp-blogs-per-page' );
	}

	combuilder()->blogs_per_page = $per_page;
}

/**
 * Helper to setup no. of groups per row for the current context
 *
 * @param $per_row
 */
function cb_bp_set_blogs_per_row( $per_row = 0 ) {

	if ( ! $per_row ) {
		$per_row = cb_get_option( 'bp-blogs-per-row' );
	}

	combuilder()->blogs_per_row = $per_row;
}

/**
 *
 * Get the no. of groups per page to list
 *
 * @param null $context
 *
 * @return mixed|null
 */
function cb_bp_get_blogs_per_page( $context = null ) {

	$per_page = combuilder()->blogs_per_page;

	if ( empty( $per_page ) ) {
		$per_page = cb_get_option( 'bp-blogs-per-page' );
		combuilder()->blogs_per_page = $per_page;
	}

	return $per_page;
}

/**
 * Get groups per row setting
 *
 * @param null $context
 *
 * @return mixed|null
 */
function cb_bp_get_blogs_per_row( $context = null ) {

	$per_row = combuilder()->blogs_per_row;

	if ( empty( $per_row ) ) {
		$per_row = cb_get_option( 'bp-blogs-per-row' );
		combuilder()->blogs_per_row = $per_row;
	}

	return $per_row;
}


/**
 * Setup grids for various user lists
 */
function cb_bp_users_grid_setup() {


	if ( bp_is_user() ) {//friends/follower etc
		cb_bp_set_members_per_row( cb_get_option( 'bp-member-friends-per-row' ) );
		cb_bp_set_members_per_page( cb_get_option( 'bp-member-friends-per-page' ) );

	} elseif ( bp_is_group() || bp_is_group_create() ) {
		//admin,members list
		cb_bp_set_members_per_row( cb_get_option( 'bp-group-members-per-row' ) );
		cb_bp_set_members_per_page( cb_get_option( 'bp-group-members-per-page' ) );
	}
}

/**
 * reset grid on single members sub pages, see cb-bp-hooks.php
 */
function cb_bp_users_grid_reset() {

	if ( bp_is_user() || bp_is_group() ) {
		//reset all grids to default
		cb_bp_set_members_per_row( 0 );
		cb_bp_set_members_per_page( 0 );
	}
}

/**
 * Setup grids for various groups list on profile
 */
function cb_bp_groups_grid_setup() {

	if ( bp_is_user() ) {
		//groups list
		cb_bp_set_groups_per_row( cb_get_option( 'bp-member-groups-per-row' ) );
		cb_bp_set_groups_per_page( cb_get_option( 'bp-member-groups-per-page' ) );
	}
}

/**
 * reset grid for groups loop
 */
function cb_bp_groups_grid_reset() {

	if ( bp_is_user() ) {
		//groups list
		cb_bp_set_groups_per_row( 0 );
		cb_bp_set_groups_per_page( 0 );
	}
}
/**
 * Setup grids for various blogs list on profile
 */
function cb_bp_blogs_grid_setup() {

	if ( bp_is_user() ) {
		//groups list
		cb_bp_set_blogs_per_row( cb_get_option( 'bp-member-blogs-per-row' ) );
		cb_bp_set_blogs_per_page( cb_get_option( 'bp-member-blogs-per-page' ) );
	}
}

/**
 * reset grid for blogs loop
 */
function cb_bp_blogs_grid_reset() {

	if ( bp_is_user() ) {
		//groups list
		cb_bp_set_blogs_per_row( 0 );
		cb_bp_set_blogs_per_page( 0 );
	}
}