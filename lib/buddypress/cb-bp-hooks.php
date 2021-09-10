<?php

/***
 * This file contains following enhancements to BuddyPress
 *
 *  1. Inject the Proper Header image on Blog/Groups create page
 *  2. Add close button into the BuddyPress generated Notice
 *  3. Force BuddyPress to use WordPress page titles
 *  4. Activity Loop args filter
 *  5. Members Loop args filters
 *  6. Groups Loop args filter
 *  7. Blogs Loop filter
 *  8. Add Friends search form on User profile Friends pages
 *  9. Add Groups search from on User Profile->groups Page
 *  10. Filter the placeholder for members search form to say friends on friends page
 *  11. Filter the activity classes to add the arrow class
 *  12. Filter BuddyPress excerpt length
 *  13. BuddyPress Profile Search plugin compatibility
 *  14. WordPress seo plugin fixes fro BuddyPress
 *  15. Remove the Profile Visibility( Xprofile Field Privacy) Settings Page and Adminbar menu
 *  16. Cache BuddyPress Directory pages to avoid extra queries
 * 17. Filter bradcrumb to show/hide on single user/group
 * 18. BuddyPress Global search, fix template
 * 19. Set/Reset the grid cols, per page for the User profile lists
 * 20. If Recent visitors is active, move to header contents area.
 */
/**
 * Inject the background image of the Blogs/groups directory for Blog Create and group Create page
 *
 * @param string $url
 *
 * @return mixed|string $url
 */

function cb_bp_filter_header_bg_image( $url = '' ) {

	$page_id = 0;

	if ( bp_is_active( 'blogs' ) && bp_is_create_blog() ) {
		$page_ids = bp_core_get_directory_page_ids();
		$page_id  = isset( $page_ids['blogs'] ) ? $page_ids['blogs'] : 0;
	} elseif ( bp_is_active( 'groups' ) && bp_is_group_create() ) {
		$page_ids = bp_core_get_directory_page_ids();
		$page_id  = isset( $page_ids['groups'] ) ? $page_ids['groups'] : 0;
	}

	if ( $page_id ) {
		$new_url = get_post_meta( $page_id, 'cb-header-image', true );

		if ( $new_url ) {
			$url = $new_url;
		}
	}

	return $url;
}

add_filter( 'cb_custom_header_image_url', 'cb_bp_filter_header_bg_image' );

/**
 * Filter the BuddyPress notice to add close button
 *
 * @param $message
 *
 * @return string
 */
function cb_inject_close_button_in_notice( $message ) {
	return $message . '<i class="fa fa-times-circle-o cb-close-notice" aria-hidden="true"></i>';
}

add_filter( 'bp_core_render_message_content', 'cb_inject_close_button_in_notice', 5, 2 );

//Ask BuddyPress to use WordPress page titles
//Change the Heading
function cb_fix_bp_page_heading() {

	if ( ! is_singular() || ! bp_is_theme_compat_active() ) {
		return;
	}

	global $wp_query, $post;

	$post_id      = get_queried_object_id();
	$current_post = get_post( $post_id );
	// Set the $post global.
	$post->post_title = $current_post->post_title;
	// Copy the new post global into the main $wp_query.
	$wp_query->post  = $post;
	$wp_query->posts = array( $post );
}

add_action( 'bp_template_include_reset_dummy_post_data', 'cb_fix_bp_page_heading', 100 );

//Update the Browser page title too
function cb_fix_bp_page_title( $bp_title_parts ) {

	if ( bp_is_directory() || bp_is_register_page() || bp_is_activation_page() ) {
		// No current component (when does this happen?).
		$bp_title_parts = array( get_the_title( get_queried_object_id() ) );
	}

	return $bp_title_parts;
}

add_filter( 'bp_get_title_parts', 'cb_fix_bp_page_title' );

/**
 * Filter Activity loop args
 * Change the number of activity items shown per page
 *
 * @param array $args
 *
 * @return array
 */
function cb_modify_activity_loop_args( $args ) {

	//Let us not filter args in admin
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return $args;
	}

	$args['per_page'] = cb_get_option( 'bp-activities-per-page' );

	return $args;
}

add_filter( 'bp_after_has_activities_parse_args', 'cb_modify_activity_loop_args' );

//5
/**
 * Filter Members Loop args
 * Change Members per page count
 *
 * @param array $args
 *
 * @return array
 */
function cb_modify_members_loop_args( $args ) {

	//Let us not filter args in admin
	if ( is_admin() && ! defined( 'DOING_AJAX' ) || isset( $args['context'] ) ) {
		return $args;
	}

	//filter member type
	if ( ! empty( $args['scope'] ) && substr( $args['scope'], 0, 4 ) == 'type' ) {
		//$member_type = isset( $args['member_type'] ) ? $args['member_type'] : ;
		$args['member_type'] = str_replace( 'type', '', $args['scope'] );
		$args['scope'] = false;//unset
	}

	$args['per_page'] = cb_bp_get_members_per_page();//default 24

	return $args;
}

add_filter( 'bp_after_has_members_parse_args', 'cb_modify_members_loop_args' );
//6
/**
 * Modify Groups loop args
 * Changes the groups per page count
 *
 * @param array $args
 *
 * @return array
 */
function cb_modify_groups_loop_args( $args ) {
	//Let us not filter args in admin
	if ( is_admin() && ! defined( 'DOING_AJAX' ) || isset( $args['context'] ) ) {
		return $args;
	}

	//filter group type
	if ( ! empty( $args['scope'] ) && substr( $args['scope'], 0, 4 ) == 'type' ) {
		$args['group_type'] = str_replace( 'type', '', $args['scope'] );
		$args['scope'] = false;//unset
	}

	$args['per_page'] = cb_bp_get_groups_per_page();

	return $args;
}

add_filter( 'bp_after_has_groups_parse_args', 'cb_modify_groups_loop_args' );


function cb_modify_blogs_loop_args( $args ) {
	//Let us not filter args in admin
	if ( is_admin() && ! defined( 'DOING_AJAX' ) || isset( $args['context'] ) ) {
		return $args;
	}

	$args['per_page'] = cb_bp_get_blogs_per_page();// cb_get_option( 'bp-blogs-per-page' );

	return $args;
}

add_filter( 'bp_after_has_blogs_parse_args', 'cb_modify_blogs_loop_args' );

/**
 * Show search form on User Profile -> Friends/Requests page
 *
 */
function cb_add_friends_search_box() {
	?>
	<div id="members-dir-search" class="dir-search" role="search">
		<?php bp_directory_members_search_form(); ?>
	</div><!-- #members-dir-search -->
	<?php
}

add_action( 'bp_before_member_friends_content', 'cb_add_friends_search_box' );

//add_action( 'bp_before_member_followers_content', 'cb_add_friends_search_box' );
//add_action( 'bp_before_member_following_content', 'cb_add_friends_search_box' );

add_action( 'bp_before_member_friend_requests_content', 'cb_add_friends_search_box' );

/**
 * Show search form on User Profile -> Groups page
 */
function cb_add_groups_search_box() {
	?>

	<div id="groups-dir-search" class="dir-search" role="search">
		<?php bp_directory_groups_search_form(); ?>
	</div><!-- #groups-dir-search -->
	<?php
}

add_action( 'bp_before_member_groups_content', 'cb_add_groups_search_box' );


/**
 * Filter search placeholder text to say search Friend requests
 *
 * @param string $default_text
 * @param string $component
 *
 * @return string
 */
function cb_filter_search_placeholder_string( $default_text, $component ) {

	if ( bp_is_directory() ) {
		return $default_text;
	} elseif ( $component != 'members' ) {
		return $default_text;
	}

	//if we are here, it is members component and not directory

	if ( bp_is_active( 'friends' ) && bp_is_friends_component() ) {
		if ( bp_is_current_action( 'requests' ) ) {
			$default_text = __( 'Suchanfragen', 'social-portal' );
		} elseif ( bp_is_current_action( 'pending' ) ) {
			$default_text = __( 'Suche ausstehend', 'social-portal' );
		} else {
			$default_text = __( 'Freunde suchen', 'social-portal' );
		}
	}

	return $default_text;
}

add_filter( 'bp_get_search_default_text', 'cb_filter_search_placeholder_string', 10, 2 );

/**
 * Add Arrow to activity
 *
 * @param string $class
 *
 * @return string
 */
function cb_add_arrow_to_activity( $class ) {

	if ( cb_get_option( 'bp-activity-item-arrow' ) ) {
		$class .= ' arrow-left';
	}

	return $class;
}

add_filter( 'bp_get_activity_css_class', 'cb_add_arrow_to_activity' );

/**
 * Filter BuddyPress excerpt length based on our setting
 *
 * @param int $length
 *
 * @return int|mixed
 */
function cb_filter_bp_excerpt_length( $length = 225 ) {
	//default case
	if ( $length == 225 ) {
		$length = cb_get_option( 'bp-excerpt-length' );
	}

	return $length;
}

add_filter( 'bp_excerpt_length', 'cb_filter_bp_excerpt_length' );


/**
 * WordPress seo title fix for BuddyPress
 */
function cb_disable_wp_seo_title_filter() {

	if ( class_exists( 'WPSEO_Frontend' ) && is_buddypress() ) {
		$instance = WPSEO_Frontend::get_instance();

		if ( has_filter( 'wp_title', array( $instance, 'title' ) ) ) {
			remove_filter( 'wp_title', array( $instance, 'title' ), 15, 3 );
		}

		if ( has_filter( 'pre_get_document_title', array( $instance, 'title' ) ) ) {
			remove_filter( 'pre_get_document_title', array( $instance, 'title' ), 15 );
		}
	}
}

add_action( 'bp_template_redirect', 'cb_disable_wp_seo_title_filter' );

function bpdev_bp_items_metadesc( $desc ) {
	// if it is not buddypress page or buddypress directory pages let the plugin do its work

	if ( ! is_buddypress() || bp_is_directory() ) {
		return $desc;
	}
	//we do not cover directory as directory meta can be customized from pages->Edit screen

	//now, let us check if we are on members page

	if ( bp_is_user() ) {

		//what should me the description, I am going to put it like Profile & Recent activities of [user_dsplay_name] on the site [sitename]
		//if you are creative, you can use some xprofile field and xprofile_get_field_data to make it better
		$desc = sprintf( 'Profil von %s und letzte Aktivitäten auf %s ', bp_get_displayed_user_fullname(), get_bloginfo( 'name' ) );

		//here we can do it based on each of the component or action using bp_si_current_component(;'component name') && bp_is_current_action('action_name')

		//here I am showing an example for BuddyBlog component
		//on buddyblog single post
		if ( function_exists( 'buddyblog_is_single_post' ) && buddyblog_is_single_post() ) {
			$post_id = 0;

			if ( buddyblog_use_slug_in_permalink() ) {
				$slug    = bp_action_variable( 0 );
				$post_id = buddyblog_get_post_id_from_slug( $slug );
			} else {
				$post_id = intval( bp_action_variable( 0 ) );
			}

			if ( $post_id ) {
				$desc = WPSEO_Meta::get_value( 'metadesc', $post_id );
			}

		}

		//I have another strategy that I will propose at the end of this post to make it super easy

	} elseif ( bp_is_active( 'groups' ) && bp_is_group() ) {//for single group
		//let us use group description
		$post_id = false;
		//by default, use group description
		$group = groups_get_current_group();
		$desc  = $group->description;
		//are we looking for forum?

		if ( bp_is_current_action( 'forum' ) && function_exists( 'psforum' ) ) {

			$forum_ids = psf_get_group_forum_ids();//we will get an array of ids

			if ( $forum_ids ) {
				$post_id = array_pop( $forum_ids );
			}

			//check if we are at single topic
			if ( bp_is_action_variable( 'topic', 0 ) && bp_action_variable( 1 ) ) {
				//we are on single topic, get topic id
				//get the topic as post
				$topics = get_posts( array(
					'name'      => bp_action_variable( 1 ),
					'post_type' => psf_get_topic_post_type(),
					'per_page'  => 1
				) );
				//get the id
				if ( ! empty( $topics ) ) {
					$post_id = $topics[0]->ID;
				}
			}
		} //end of forum post finding
		//if the post id is given
		if ( $post_id ) {
			$desc = WPSEO_Meta::get_value( 'metadesc', $post_id );
		}
		//check if the forum is active and get the current post id /meta
	}

	return $desc;
}

//generate meta description
add_filter( 'wpseo_metadesc', 'bpdev_bp_items_metadesc' );

/**
 * BuddyPress Docs
 * Template should be loaded from our
 * //nah, see the docs folder for overrides
 *
 */
//add_filter( 'bp_docs_locate_template', 'cb_bp_docs_filetr_template_path', 10, 2 );

function cb_activity_add_button_class( $class ) {
	return $class . ' has-meta-button';
}
//add_filter( 'bp_get_activity_css_class', 'cb_activity_add_button_class' );

/**
 * User Profile->settings->Profile Visibility
 * Remove it as it is meaningless to have the same things at 2 places
 * Edit Profile is better suited for the privacy
 *
 */
//Remove Profile Visibility from the Settings Menu
function cb_remove_profile_visibility_settings_nav() {
	bp_core_remove_subnav_item( 'settings', 'profile' );
}
add_action( 'bp_settings_setup_nav', 'cb_remove_profile_visibility_settings_nav' , 12 );
//remove Profile Visibility from adminbar
function cb_remove_profile_visibility_nav_from_adminbar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_node( 'my-account-settings-profile' );
}
add_action( 'bp_settings_setup_admin_bar', 'cb_remove_profile_visibility_nav_from_adminbar' );

//Remove "Public/View" from other user's profile

function cb_bp_update_member_type_members_count() {
	static $did;
	if ( ! is_null( $did ) ) {
		return ;//no need to update mutiple times
	}

    $member_types = buddypress()->members->types;
	$mt_terms = array_keys( $member_types );

	if ( empty( $mt_terms ) ) {
		return ;
	}

	//we have got list of active terms

	$terms = get_terms( array(
		'taxonomy'   => bp_get_member_type_tax_name(),
		'hide_empty' => false,
		'slug'       => $mt_terms,
	) );

	if ( is_wp_error( $terms ) ) {
		return ;
	}

	//key by slug
	foreach ( $terms as $term ) {
		$terms[ $term->slug ] = $term;
	}

	foreach ( $member_types as $member_type => &$member_type_object ) {

		if ( isset( $terms[$member_type ] ) ) {
			$member_type_object->count = $terms[$member_type]->count;
		} else {
			$member_type_object->count = 0;
		}
	}

	$did = true;
}
add_action( 'bp_before_directory_members_tabs', 'cb_bp_update_member_type_members_count' );
//add_action( 'bp_register_taxonomies', 'cb_bp_update_member_type_members_count', 11 );
/**
 * Update the count for each of group type
 */
function cb_bp_update_group_type_groups_count() {
	static $did;
	if ( ! is_null( $did ) ) {
		return ;//no need to update mutiple times
	}

	$group_types = $types = buddypress()->groups->types;;

	$gt_terms = array_keys( $group_types );

	if ( empty( $gt_terms ) ) {
		return ;
	}

	//we have got list of active terms

	$terms = get_terms( array(
		'taxonomy'   => 'bp_group_type',
		'hide_empty' => false,
		'slug'       => $gt_terms,
	) );


	if ( is_wp_error( $terms ) ) {
		return ;
	}

	//key by slug
	foreach ( $terms as $term ) {
		$terms[ $term->slug ] = $term;
	}

	foreach ( $group_types as $group_type => &$group_type_object ) {

		if ( isset( $terms[$group_type ] ) ) {
			$group_type_object->count = $terms[$group_type]->count;
		} else {
			$group_type_object->count = 0;
		}
	}

	$did = true;
}
add_action( 'bp_before_directory_groups_tabs', 'cb_bp_update_group_type_groups_count' );
//add_action( 'bp_register_taxonomies', 'cb_bp_update_group_type_groups_count', 11 );

//keep store count of member types in the object
/**
 * Cache BuddyPress Directory pages early to avoid extra queries
 */
function cb_bp_cache_directory_pages() {
	$page_ids = bp_get_option( 'bp-pages' );
	_prime_post_caches( $page_ids, false, true );
}
add_action( 'init', 'cb_bp_cache_directory_pages', 1 );

/**
 * Filter Breadcrumb to show/hide on profile/groups
 *
 * @param $is_enabled
 *
 * @return bool
 */
function cb_bp_breadcrum_enabled_filter( $is_enabled ) {

	if ( bp_is_user() && ! cb_get_option( 'bp-member-show-breadcrumb' ) ) {
		$is_enabled = false;
	} elseif( bp_is_group() && ! cb_get_option( 'bp-group-show-breadcrumb' ) ) {
		$is_enabled = false;
	}

	return $is_enabled;
}
add_filter( 'cb_breadcrumb_enabled', 'cb_bp_breadcrum_enabled_filter' );


function cb_check_remove_global_search_filters() {

	if ( ! function_exists( 'buddyboss_global_search_search_page_content' ) ) {
		return ;
	}

	if ( has_filter( 'the_content', 'buddyboss_global_search_search_page_content' ) ) {
		remove_filter( 'the_content', 'buddyboss_global_search_search_page_content', 9 );
	}

	if ( has_filter( 'template_include', 'buddyboss_global_search_result_page_dummy_post_load' ) ) {
		remove_filter( 'template_include', 'buddyboss_global_search_result_page_dummy_post_load', 999 ); //don't leave any crap.
	}

	if ( has_filter( 'template_include', 'buddyboss_global_search_override_wp_native_results' ) ) {
		remove_filter( 'template_include', 'buddyboss_global_search_override_wp_native_results', 999 ); //don't leave any crap.
	}

	//if we are here, bbGlobal search is active
	//template_include
	add_filter( 'search_template', 'cb_bb_global_search_page_template' );

}
add_action( 'init', 'cb_check_remove_global_search_filters' );

function cb_bb_global_search_page_template( $template ) {
	$new_template = locate_template( 'buddypress-global-search/search.php', false );
	//if there is a page template for bb global search, let us use that
	if ( $new_template ) {
		$template = $new_template;
	}

	return $template;
}

function cb_bp_filter_bb_global_search_results_clss( $class  ) {
	return $class .' row';
}
add_filter(  'bboss_global_search_class_search_list', 'cb_bp_filter_bb_global_search_results_clss' );

function cb_bp_filter_bb_search_results_group_start_html( $html, $type  ) {
	$results_class = ' row ';
	if ( $type == 'posts' ) {
		$results_class .= cb_get_posts_list_class();
	}

	$search_items = buddyboos_global_search_items();
	$label = isset( $search_items[$type] ) ? $search_items[$type] : $type;
	$start_html = "<div class='results-group results-group-{$type} ". apply_filters( 'bboss_global_search_class_search_wrap', 'bboss-results-wrap', $label ) ."'>"
	              .	"<h2 class='results-group-title'><span>" . apply_filters( 'bboss_global_search_label_search_type', $label ) . "</span></h2>"
	              .	"<ul id='{$type}-stream' class='item-list {$type}-list {$results_class}". apply_filters( 'bboss_global_search_class_search_list', 'bboss-results-list ' . $label , $label ) ."'>";

return $start_html;
}
add_filter(  'bboss_global_search_results_group_start_html', 'cb_bp_filter_bb_search_results_group_start_html', 10, 2 );

//19
//On all User profile Page
//setup the grid cols, items per page
add_action( 'bp_before_members_loop', 'cb_bp_users_grid_setup' );

//group members page
add_action( 'bp_before_group_body', 'cb_bp_users_grid_setup' );
add_action( 'bp_after_group_body', 'cb_bp_users_grid_reset' );

//invite anyone
add_action( 'bp_before_group_send_invites_content', 'cb_bp_users_grid_setup' );
//group members list
add_action( 'bp_before_group_members_list', 'cb_bp_users_grid_setup' );
//group invites list
add_action( 'bp_before_group_send_invites_list', 'cb_bp_users_grid_setup' );

//groups loop
add_action( 'bp_before_groups_loop', 'cb_bp_groups_grid_setup' );
add_action( 'bp_before_blogs_loop', 'cb_bp_blogs_grid_setup' );



//add_action( 'bp_before_group_manage_members_admin', 'cb_bp_users_grid_setup' );
//add_action( 'bp_after_group_manage_members_admin', 'cb_bp_users_grid_reset' );

//reset to default group grid
add_action( 'bp_after_members_loop', 'cb_bp_users_grid_reset' );
add_action( 'bp_after_groups_loop', 'cb_bp_groups_grid_reset' );
add_action( 'bp_after_blogs_loop', 'cb_bp_blogs_grid_reset' );
// 20. Recent Visitors plugin:- Move the recent visitors from after_header to header meta
if ( function_exists( 'visitors_show_my_recent_visitor' ) ) {
	remove_action( 'bp_after_member_header', 'visitors_show_my_recent_visitor' );
	add_action( 'bp_profile_header_meta', 'visitors_show_my_recent_visitor' );
}
