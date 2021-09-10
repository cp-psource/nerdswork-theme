<?php

/**
 * Helper class for adding the trail items to breadcrumb trail
 *
 * Class CB_BP_Breadcrumb
 */
class CB_BP_Breadcrumb {

	public function __construct() {

	}

	/**
	 * Add BuddyPress User/group specific trail items
	 *
	 * @param array $trail
	 *
	 * @return array
	 */
	public function add_trail_items( $trail ) {

		if ( bp_is_user() ) {
			return $this->add_user_trail_items( $trail );
		} elseif ( bp_is_group() ) {
			return $this->add_group_trails( $trail );
		}

		return $trail;
	}

	/**
	 * Add BuddyPress User specific trail item depending on the current page
	 *
	 * @param $trail
	 *
	 * @return array
	 */
	public function add_user_trail_items( $trail ) {

		unset( $trail['trail_end'] );

		$bp = buddypress();

		//current action
		$action             = bp_current_action() ;
		$component          = bp_current_component();
		$action_variables   = bp_action_variables();

		$displayed_user_id = bp_displayed_user_id();

		//add Members Page as Link
		$trail[] = '<a href="' . get_permalink( $bp->pages->members->id ) . '">' . get_the_title( $bp->pages->members->id ) . '</a>';

		//if we are here, we are most probably on a component screen of user
		$trail[] = bp_core_get_userlink( $displayed_user_id );

		//get details of current main nav(component)
		$nav_details  = $this->get_user_component_details( $component );
		//let us keep the name of current nav menu as end point
		$trail_end = $nav_details['name'];

		//are we doing some action for the component
		if ( ! empty( $action ) ) {
			//yes, then let us link to the parent component on user
			$trail[] = '<a href="'. $nav_details['link'] . '">' . $nav_details['name'] . '</a>';
			$subnav_details = $this->get_user_action_details( $component, $action );
			//let us keep that sub nav action name as the end point
			$trail_end = $subnav_details['name'];
		}

		if ( ! empty( $action_variables ) ) {
			//is some action_variable set
			//if yes, let us append the parent action link to the breadcrumb
			$trail[] = '<a href="' . $subnav_details['link'] . '">' . $subnav_details['name'] . '</a>';
			$trail_end = array_pop( $action_variables );

			foreach ( $action_variables as $action_name ) {
				$trail[] = ucwords( str_replace( '-', ' ', $action_name ) );
			}

			$trail_end = ucwords( str_replace( '-', ' ', $trail_end ) );
		}

		if ( ! empty( $trail_end ) ) {
			$trail['trail_end'] = $trail_end;
		}

		return $trail;
	}

	/**
	 *
	 * Add group specific trail items
	 *
	 * @param $trail
	 *
	 * @return array
	 */
	public function add_group_trails( $trail ) {
		$bp = buddypress();

		//let us append the group directory page as link
		$trail[] = '<a href="' . get_permalink( $bp->pages->groups->id ) . '">' . get_the_title( $bp->pages->groups->id ) . '</a>';

		//get the current group details
		$group              = groups_get_current_group();
		$action             = bp_current_action();
		$action_variables   = bp_action_variables();
		$trail_end          = '';

		//if no action is set, we are on group home page
		if ( empty( $action ) ) {
			$trail['trail_end'] = bp_get_group_name( $group );
		} else {
			//we are on any of group internal page

			$trail[]= '<a href="'. bp_get_group_permalink( $group )."'>". bp_get_group_name( $group ) . '</a>';
			$subnav_details = $this->get_group_action_details( $group->slug, $action );

			$trail_end = $subnav_details['name'];

			if ( ! empty( $action_variables ) ) {
				$trail[] = '<a href="' . $subnav_details['link'] . '">' . $subnav_details['name'] . '</a>';
				$trail_end = array_pop( $action_variables );

				foreach ( $action_variables as $action_name ) {
					$trail[] = ucwords( str_replace( '-', ' ', $action_name ) );
				}

				$trail_end = ucwords( str_replace( '-', ' ', $trail_end ) );
			}
		}

		if ( ! empty( $trail_end ) ) {
			$trail['trail_end'] = $trail_end;
		}

		return $trail;
	}

	/**
	 * Get an array containing the details of current action(sub nav ietm details
	 *
	 * @param $component
	 * @param $action
	 *
	 * @return array (
	 *  'name' => '',
	 *  'link'  => '',
	 *  'slug'  => ''
	 * )
	 */
	public function get_user_action_details( $component, $action ) {

		$items = $this->get_user_subnav_items( $component );

		foreach (  $items as $item ) {
			if ( $item['slug'] == $action ) {
				return $item;
			}
		}

		return array();

	}

	/**
	 * Get the array containing component nav details
	 * @param $component
	 *
	 * @return array
	 */
	private function get_user_component_details( $component ) {

		$nav_items = $this->get_user_nav_items();

		foreach ( $nav_items as $nav_item ) {
			if ( $nav_item['slug'] == $component ) {
				return $nav_item;
			}
		}

		return array();
	}

	private function get_user_nav_items() {

		if ( class_exists('BP_Core_Nav') ) {
			$nav_items = buddypress()->members->nav->get_primary();
		} else {
			$nav_items = buddypress()->bp_options_nav;
		}

		return $nav_items;
	}

	private function get_user_subnav_items( $component ) {

		if ( class_exists('BP_Core_Nav') ) {
			$nav_items = buddypress()->members->nav->get_secondary( array( 'parent_slug' => $component ) );
		} else {
			$nav_items = buddypress()->bp_options_nav;
		}

		return $nav_items;
	}

	/**
	 * Get an array containing current group, current action details
	 *
	 * @param $group_slug
	 * @param $action
	 *
	 * @return array
	 */
	public function get_group_action_details( $group_slug, $action ) {

		$nav_items = $this->get_group_nav_items( $group_slug );

		foreach ( $nav_items as $nav_item ) {
			if ( $nav_item['slug'] == $action ) {
				return $nav_item;
			}
		}

		return array();
	}

	/**
	 * Get nav items array for the current group
	 *
	 * @param string $group_slug
	 *
	 * @return array
	 */
	private function get_group_nav_items( $group_slug = '' ) {

		if ( class_exists('BP_Core_Nav') ) {
			$nav_items = buddypress()->groups->nav->get_secondary( array( 'parent_slug' => $group_slug ) );
		} else {
			$nav_items = buddypress()->bp_options_nav;
		}

		return $nav_items;
	}

}

//WMS N@W Theme Nav Trails Helper
//Add BuddyPress specific trails to Breadcrumb Trail plugin
function cb_add_bp_trail_items( $trail, $args ) {

	$trail_bp = new CB_BP_Breadcrumb();
	return $trail_bp->add_trail_items( $trail );
}
add_filter( 'breadcrumb_trail_items', 'cb_add_bp_trail_items', 10, 2 );