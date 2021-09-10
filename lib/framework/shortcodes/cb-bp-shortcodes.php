<?php
/**
 * BuddyPress Shortcodes list
 *
 * 1. Members List - bp-members-list
 * 2. Groups List - bp-groups-list
 * 3. Blogs List - bp-blogs-list
 * 4. Members Count - bp-members-count
 * 5. Groups Count - bp-groups-count
 * 6. Blogs Count - bp-blogs-count
 */

add_shortcode( 'bp-members-list', 'cb_bp_shortcode_members_list' );
/**
 * List Members
 * All the parameters from bp_has_members are allowed
 * Also extra parameters like
 * display - string list|links|
 */
function cb_bp_shortcode_members_list( $atts, $content = null ) {

	$defaults = array(
		'type'     => 'active',
		'page'     => 1,
		'per_page' => 20,
		'col'      => 2,//applies to grid layout only
		//'max'                 => false,

		//'page_arg'            => 'upage',  // See https://buddypress.trac.wordpress.org/ticket/3679.

		'include' => false,
		// Pass a user_id or a list (comma-separated or array) of user_ids to only show these users.
		'exclude' => false,
		// Pass a user_id or a list (comma-separated or array) of user_ids to exclude these users.

		'user_id'             => '',
		// Pass a user_id to only show friends of this user.
		'member_type'         => '',
		'member_type__in'     => '',
		'member_type__not_in' => '',
		'search_terms'        => '',

		'meta_key'   => false,
		// Only return users with this usermeta.
		'meta_value' => false,
		// Only return users where the usermeta value matches. Requires meta_key.

		'populate_extras' => 1,
		// Fetch usermeta? Friend count, last active etc.
		'avatar_size'     => 32,
		'display'         => 'list',
		//links//extended
	);


	$atts = shortcode_atts( $defaults, $atts );

	$atts['context'] = 'shortcode';

	$display     = $atts['display'];
	$avatar_size = $atts['avatar_size'];

	$per_row = absint( $atts['col'] );
	$type = cb_get_avatar_image_type( $avatar_size );

	unset( $atts['display'] );
	unset( $atts['avatar_size'] );
	unset( $atts['col'] );

	if ( ! bp_has_members( $atts ) ) {
		//should we show error?
		return $content;
	}

	$end_el = '';
	$beg_el = '';

	if ( $display == 'list' ) {
		$beg_el = '<li>';
		$end_el = '</li>';
	}
	$html = '';
	if ( $display == 'list' || $display == 'links' ) {
		while ( bp_members() ) : bp_the_member();
			$html .= $beg_el . '<a href="' . bp_get_member_permalink() . '">' . bp_get_member_avatar( array(
					'height' => $avatar_size,
					'width'  => $avatar_size,
					'type'  => $type,
				) ) . '</a>' . $end_el;
		endwhile;

		if ( $display == 'list' ) {
			$html = '<ul class="bp-sc-items-list bp-sc-members-list bp-members-list">' . $html . '</ul>';
		} else {
			$html = '<div class="bp-sc-items-list bp-sc-members-list bp-members-list">' . $html . '</div>';
		}

		return $html;
	}

	if ( $display == 'extended' ) {
		cb_bp_set_members_per_row( $per_row );
		ob_start();
		bp_get_template_part( 'members/members-list' );

		$content = ob_get_clean();
		cb_bp_set_members_per_row( 0 );//reset
	}

	return $content;
}

add_shortcode( 'bp-groups-list', 'cb_bp_shortcode_groups_list' );
/**
 * Group List shortcode
 *
 * @param array|string $atts {
 *     Array of parameters. All items are optional.
 *
 * @type string $type Shorthand for certain orderby/order combinations. 'newest', 'active',
 *                                            'popular', 'alphabetical', 'random'. When present, will override
 *                                            orderby and order params. Default: null.
 * @type string $order Sort order. 'ASC' or 'DESC'. Default: 'DESC'.
 * @type string $orderby Property to sort by. 'date_created', 'last_activity',
 *                                            'total_member_count', 'name', 'random'. Default: 'last_activity'.
 * @type int $page Page offset of results to return. Default: 1 (first page of results).
 * @type int $per_page Number of items to return per page of results. Default: 20.
 * @type int $max Does NOT affect query. May change the reported number of total groups
 *                                            found, but not the actual number of found groups. Default: false.
 * @type bool $show_hidden Whether to include hidden groups in results. Default: false.
 * @type string $page_arg Query argument used for pagination. Default: 'grpage'.
 * @type int $user_id If provided, results will be limited to groups of which the specified
 *                                            user is a member. Default: value of bp_displayed_user_id().
 * @type string $slug If provided, only the group with the matching slug will be returned.
 *                                            Default: false.
 * @type string $search_terms If provided, only groups whose names or descriptions match the search
 *                                            terms will be returned. Default: value of `$_REQUEST['groups_search']` or
 *                                            `$_REQUEST['s']`, if present. Otherwise false.
 * @type array|string $group_type Array or comma-separated list of group types to limit results to.
 * @type array|string $group_type__in Array or comma-separated list of group types to limit results to.
 * @type array|string $group_type__not_in Array or comma-separated list of group types that will be
 *                                            excluded from results.
 * @type array $meta_query An array of meta_query conditions.
 *                                            See {@link WP_Meta_Query::queries} for description.
 * @type array|string $include Array or comma-separated list of group IDs. Results will be limited
 *                                            to groups within the list. Default: false.
 * @type array|string $exclude Array or comma-separated list of group IDs. Results will exclude
 *                                            the listed groups. Default: false.
 * @type array|string $parent_id Array or comma-separated list of group IDs. Results will include only
 *                                            child groups of the listed groups. Default: null.
 * @type string $display possible values 'list', 'links', 'extended'
 * }
 * @return bool True if there are groups to display that match the params
 */

function cb_bp_shortcode_groups_list( $atts, $content = null ) {

	if ( ! bp_is_active( 'groups' ) ) {
		return '';
	}

	$defaults = array(
		'type'               => 'active',
		'order'              => 'DESC',
		'orderby'            => 'last_activity',
		'page'               => 1,
		'per_page'           => 20,
		'col'                => 2,
		'max'                => false,
		'show_hidden'        => false,
		'page_arg'           => 'grpage',
		'user_id'            => false,
		'slug'               => '',
		'search_terms'       => '',
		'group_type'         => '',
		'group_type__in'     => '',
		'group_type__not_in' => '',
		'meta_query'         => false,
		'include'            => false,
		'exclude'            => false,
		'parent_id'          => null,
		'avatar_size'        => 32,
		'display'            => 'list', //links//extended
	);

	$atts = shortcode_atts( $defaults, $atts );

	//prefetch admins
	$atts['update_admin_cache'] = is_user_logged_in();

	$display     = $atts['display'];
	$avatar_size = $atts['avatar_size'];
	$type = cb_get_avatar_image_type( $avatar_size );
	$per_row = absint( $atts['col'] );

	unset( $atts['display'] );
	unset( $atts['avatar_size'] );
	unset( $atts['col'] );

	$atts['context'] = 'shortcode';

	if ( ! bp_has_groups( $atts ) ) {
		//should we show error?
		return $content;
	}

	$end_el = '';
	$beg_el = '';

	if ( $display == 'list' ) {
		$beg_el = '<li>';
		$end_el = '</li>';
	}
	$html = '';
	if ( $display == 'list' || $display == 'links' ) {
		while ( bp_groups() ) : bp_the_group();
			$html .= $beg_el . '<a href="' . bp_get_group_permalink() . '">' . bp_get_group_avatar( array(
					'height' => $avatar_size,
					'width'  => $avatar_size,
					'type'   => $type,
				) ) . '</a>' . $end_el;
		endwhile;

		if ( $display == 'list' ) {
			$html = '<ul class="bp-sc-items-list bp-sc-groups-list bp-groups-list">' . $html . '</ul>';
		} else {
			$html = '<div class="bp-sc-items-list bp-sc-groups-list bp-groups-list">' . $html . '</div>';
		}

		return $html;
	}

	if ( $display == 'extended' ) {
		cb_bp_set_groups_per_row( $per_row );
		//cb_bp_set_groups_per_page( $per_page );
		ob_start();
		bp_get_template_part( 'groups/groups-list' );

		$content = ob_get_clean();
		cb_bp_set_groups_per_row( 0 );
	}

	return $content;
}


add_shortcode( 'bp-blogs-list', 'cb_bp_shortcode_blogs_list' );
/**
 * Blogs List shortcode
 *
 * @param array|string $atts {
 *
 * @type int $page Which page of results to fetch. Using page=1 without
 *                                      per_page will result in no pagination. Default: 1.
 * @type int|bool $per_page Number of results per page. Default: 20.
 * @type string $page_arg The string used as a query parameter in
 *                                      pagination links. Default: 'bpage'.
 * @type int|bool $max Maximum number of results to return.
 *                                      Default: false (unlimited).
 * @type string $type The order in which results should be fetched.
 *                                      'active', 'alphabetical', 'newest', or 'random'.
 * @type array $include_blog_ids Array of blog IDs to limit results to.
 * @type string $sort 'ASC' or 'DESC'. Default: 'DESC'.
 * @type string $search_terms Limit results by a search term. Default: the value of `$_REQUEST['s']` or
 *                                      `$_REQUEST['sites_search']`, if present.
 * @type int $user_id The ID of the user whose blogs should be retrieved.
 *                                      When viewing a user profile page, 'user_id' defaults to the
 *                                      ID of the displayed user. Otherwise the default is false.
 *
 * @type string $display how to display.possible values 'list', 'links', 'extended'
 * }
 * @return bool True if there are groups to display that match the params
 */

function cb_bp_shortcode_blogs_list( $atts, $content = null ) {

	if ( ! bp_is_active( 'blogs' ) ) {
		return '';
	}

	$defaults = array(
		'type'             => 'active',
		'page_arg'         => 'bpage', // See https://buddypress.trac.wordpress.org/ticket/3679.
		'page'             => 1,
		'per_page'         => 20,
		'max'              => false,
		'user_id'          => false, // Pass a user_id to limit to only blogs this user is a member of.
		'include_blog_ids' => false,
		'search_terms'     => '',
		'avatar_size'      => 32,
		'display'          => 'list', //links//extended
	);

	$atts = shortcode_atts( $defaults, $atts );

	//prefetch admins
	$atts['update_admin_cache'] = is_user_logged_in();

	$display     = $atts['display'];
	$avatar_size = $atts['avatar_size'];
	$type = cb_get_avatar_image_type( $avatar_size );

	unset( $atts['display'] );
	unset( $atts['avatar_size'] );

	$atts['context'] = 'shortcode';

	if ( ! bp_has_blogs( $atts ) ) {
		//should we show error?
		return $content;
	}

	$end_el = '';
	$beg_el = '';

	if ( $display == 'list' ) {
		$beg_el = '<li>';
		$end_el = '</li>';
	}
	$html = '';
	if ( $display == 'list' || $display == 'links' ) {
		while ( bp_blogs() ) : bp_the_blog();
			$html .= $beg_el . '<a href="' . bp_get_blog_permalink() . '">' . bp_get_blog_avatar( array(
					'height' => $avatar_size,
					'width'  => $avatar_size,
					'type'   => $type,
				) ) . '</a>' . $end_el;
		endwhile;

		if ( $display == 'list' ) {
			$html = '<ul class="bp-sc-items-list bp-sc-blogs-list bp-blogs-list">' . $html . '</ul>';
		} else {
			$html = '<div class="bp-sc-items-list bp-sc-blogs-list bp-blogs-list">' . $html . '</div>';
		}

		return $html;
	}

	if ( $display == 'extended' ) {
		ob_start();
		bp_get_template_part( 'blogs/blogs-list' );

		$content = ob_get_clean();
	}

	return $content;
}

add_shortcode( 'bp-members-count', 'cb_bp_shortcode_members_count' );

function cb_bp_shortcode_members_count( $atts, $content = null ) {

	$defaults = array(
		'type'  => 'active', //'all'- all members where they logged to the site or not
		//'active' --members who have logged to the site atleast once
		//'friends' - No. of friends of the current logged in user,
		'user'  => 'logged', //displayed, only valid when type='friends',
		'class' => '',
	);

	$atts = shortcode_atts( $defaults, $atts );

	$type = $atts['type'];

	$user_id = 0;

	if ( $type == 'friends' && ! ( $user_id = cb_bp_shortcode_get_context_user_id( $atts['user'] ) ) ) {
		return;
	}


	$count = 0;

	switch ( $type ) {
		case 'all':
			$count = bp_get_total_site_member_count();
			break;

		case 'active':
		default:
			$count = bp_core_get_active_member_count();
			break;
		case 'friends':
			$count = bp_get_total_friend_count( $user_id );
			break;
	}

	$class = $atts['class'];

	return "<span class='site-item-count site-members-count site-members-{$type}-count {$class}'>{$count}</span>";
}

add_shortcode( 'bp-groups-count', 'cb_bp_shortcode_groups_count' );

function cb_bp_shortcode_groups_count( $atts, $content = null ) {
	//groups component must be active
	if ( ! bp_is_active( 'groups' ) ) {
		return '';
	}

	$defaults = array(
		'type'  => 'all', //'all'- all groups
		//'user' --total number of groups of the logged in user

		'user'  => 'logged', //displayed,
		'class' => '', //css classes
	);

	$atts = shortcode_atts( $defaults, $atts );

	$type = $atts['type'];

	$user_id = 0;
	//finding user groups?
	if ( $type == 'user' && ! ( $user_id = cb_bp_shortcode_get_context_user_id( $atts['user'] ) ) ) {
		return;
	}

	$count = 0;

	switch ( $type ) {
		case 'all':
		default:
			$count = bp_get_total_group_count();
			break;

		case 'user':
			$count = bp_get_total_group_count_for_user( $user_id );
			break;
	}

	$class = $atts['class'];

	return "<span class='site-item-count site-groups-count site-groups-{$type}-count {$class}'>{$count}</span>";
}


add_shortcode( 'bp-blogs-count', 'cb_bp_shortcode_blogs_count' );

function cb_bp_shortcode_blogs_count( $atts, $content = null ) {
	//blogs component must be active
	if ( ! bp_is_active( 'blogs' ) ) {
		return '';
	}

	$defaults = array(
		'type'  => 'all', //'all'- all groups
		//'user' --total number of groups of the logged in user
		'user'  => 'logged', //displayed,
		'class' => '', //css classes
	);

	$atts = shortcode_atts( $defaults, $atts );

	$type = $atts['type'];

	$user_id = 0;
	//user blogs?
	if ( $type == 'user' && ! ( $user_id = cb_bp_shortcode_get_context_user_id( $atts['user'] ) ) ) {
		return;
	}

	$count = 0;

	switch ( $type ) {
		case 'all':
		default:
			$count = get_blog_count();
			break;

		case 'user':
			$count = bp_get_total_blog_count_for_user( $user_id );
			break;
	}

	$class = $atts['class'];

	return "<span class='site-item-count site-blogs-count site-blogs-{$type}-count {$class}'>{$count}</span>";
}


