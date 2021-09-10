<?php
/**
 * Sync the Activity directory layout from customizer to the directory page
 *
 * @param string $layout
 * @return string layout type
 */
function cb_update_activity_dir_page_layout( $layout = '' ) {

	if ( function_exists( 'bp_activity_has_directory' ) && bp_activity_has_directory() ) {

		$post_id =  buddypress()->pages->activity->id ;
		$meta_key = cb_get_page_layout_meta_key();

		if ( empty( $layout ) || $layout == 'default' ) {
			delete_post_meta( $post_id, $meta_key );
		} else {
			update_post_meta( $post_id, $meta_key, $layout );
		}
	}

	return $layout;

}

add_filter( 'pre_set_theme_mod_bp-activity-directory-layout', 'cb_update_activity_dir_page_layout' );

/**
 * Sync the Activation page layout from customizer to the page
 *
 * @param string $layout
 * @return string layout type
 */
function cb_update_bp_signup_page_layout( $layout = '' ) {

	if ( function_exists( 'bp_has_custom_signup_page' ) && bp_has_custom_signup_page() ) {

		$post_id =  buddypress()->pages->register->id ;
		$meta_key = cb_get_page_layout_meta_key();

		if ( empty( $layout ) || $layout == 'default' ) {
			delete_post_meta( $post_id, $meta_key );
		} else {
			update_post_meta( $post_id, $meta_key, $layout );
		}
	}

	return $layout;

}
add_filter( 'pre_set_theme_mod_bp-signup-page-layout', 'cb_update_bp_signup_page_layout' );

/**
 * Sync the Activation page layout from customizer to the page
 *
 * @param string $layout
 * @return string layout type
 */
function cb_update_bp_activation_page_layout( $layout = '' ) {

	if ( function_exists( 'bp_has_custom_activation_page' ) && bp_has_custom_activation_page() ) {

		$post_id =  buddypress()->pages->activate->id ;
		$meta_key = cb_get_page_layout_meta_key();

		if ( empty( $layout ) || $layout == 'default' ) {
			delete_post_meta( $post_id, $meta_key );
		} else {
			update_post_meta( $post_id, $meta_key, $layout );
		}
	}

	return $layout;

}
add_filter( 'pre_set_theme_mod_bp-activation-page-layout', 'cb_update_bp_activation_page_layout' );

/**
 * Sync the groups directory layout from customizer to the directory page
 *
 * @param string $layout
 * @return string
 */
function cb_update_groups_dir_page_layout( $layout = '' ) {

	if ( function_exists( 'bp_groups_has_directory' ) && bp_groups_has_directory() ) {

		$post_id =  buddypress()->pages->groups->id ;
		$meta_key = cb_get_page_layout_meta_key();

		if ( empty( $layout ) || $layout == 'default' ) {
			delete_post_meta( $post_id, $meta_key );
		} else {
			update_post_meta( $post_id, $meta_key, $layout );
		}
	}

	return $layout;

}

add_filter( 'pre_set_theme_mod_bp-groups-directory-layout', 'cb_update_groups_dir_page_layout' );
/**
 * Sync the members directory layout from customizer to the directory page
 *
 * @param string $layout
 * @return  string
 */
function cb_update_members_dir_page_layout( $layout = '' ) {

	if ( cb_is_bp_active() && bp_members_has_directory() ) {

		$post_id =  buddypress()->pages->members->id ;
		$meta_key = cb_get_page_layout_meta_key();

		if ( empty( $layout ) || $layout == 'default' ) {
			delete_post_meta( $post_id, $meta_key );
		} else {
			update_post_meta( $post_id, $meta_key, $layout );
		}
	}

	return $layout;
}

add_filter( 'pre_set_theme_mod_bp-members-directory-layout', 'cb_update_members_dir_page_layout' );

/**
 * Sync the blogs directory layout from customizer to the directory page
 *
 * @param string $layout
 * @return string
 */
function cb_update_blogs_dir_page_layout( $layout = '' ) {

	if ( function_exists( 'bp_blogs_has_directory' ) && bp_blogs_has_directory() ) {

		$post_id =  buddypress()->pages->blogs->id ;
		$meta_key = cb_get_page_layout_meta_key();

		if ( empty( $layout ) || $layout == 'default' ) {
			delete_post_meta( $post_id, $meta_key );
		} else {
			update_post_meta( $post_id, $meta_key, $layout );
		}
	}

	return $layout;

}

add_filter( 'pre_set_theme_mod_bp-blogs-directory-layout', 'cb_update_blogs_dir_page_layout' );

