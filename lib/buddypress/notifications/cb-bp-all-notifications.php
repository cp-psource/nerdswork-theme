<?php
class CB_BP_Notifications_Extender {

	public function __construct() {
		$this->setup();
	}

	public function setup() {

		add_action( 'bp_notifications_setup_nav', array( $this, 'setup_nav' ) );
		add_filter( 'bp_after_has_notifications_parse_args', array( $this, 'filter' ) );//filter notifications loop arguements
	}

	public function setup_nav() {
		$user_url = '';
		// Determine user to use
		if ( bp_is_user() ) {
			$user_url = bp_displayed_user_domain();
		} elseif( is_user_logged_in() ) {
			$user_url = bp_loggedin_user_domain();
		}

		if ( empty( $user_url ) ) {
			return ;
		}

		$slug = bp_get_notifications_slug();
		$access       = bp_core_can_edit_settings();
		$notifications_link = trailingslashit( $user_url . $slug );


		// Add the subnav items to the friends nav item
		$sub_nav = array(
			'name'            => _x( 'Alle', 'Friends screen sub nav', 'social-portal' ),
			'slug'            => 'all',
			'parent_url'      => $notifications_link,
			'parent_slug'     => $slug,
			'screen_function' => array( $this, 'screen_all_notifications' ),
			'position'        => 30,
			'item_css_id'     => 'notifications-all-notification',
			'user_has_access' => $access
		);

		bp_core_new_subnav_item ( $sub_nav );

	}

	public function setup_admin_bar() {

	}

	public function screen_all_notifications() {
		bp_core_load_template( apply_filters( 'friends_template_my_requests', 'members/single/home' ) );
	}

	public function filter( $args ) {

		if ( bp_is_notifications_component() && bp_is_current_action( 'all' ) ) {
			$args['is_new'] = 'both';
		}

		return $args;
	}
}

new CB_BP_Notifications_Extender();