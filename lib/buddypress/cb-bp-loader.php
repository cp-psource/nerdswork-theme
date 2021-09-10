<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Loads BuddyPress Specific functionality code
 *
 */
class CB_BP_Helper {

	private static $instance = null;

	private $dir = '';
	private $url = '';

	private function __construct() {

		$this->dir = combuilder()->get_path();
		$this->url = combuilder()->get_url();
		$this->init();
	}

	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function init() {

		$this->load();
		//load the functions after theme setup
		//add_action( 'bp_after_setup_theme', array( $this, 'load' ), 11 );
		//add_action( 'bp_after_setup_theme', array( $this, 'load' ), 11 );
		add_action( 'cb_after_setup_theme', array( $this, 'setup' ), 11 );

		//add_action( 'bp_enqueue_scripts', array( $this, 'load_css' ) );
		//add_action( 'bp_enqueue_scripts', array( $this, 'load_css' ) );
		//add extra menus to profile and groups
		//should we do it at the top level instead?
		add_action( 'bp_member_options_nav', array( $this, 'add_profile_menu' ) );
		add_action( 'bp_group_options_nav', array( $this, 'add_group_menu' ) );

		//disable gravatar 
		add_filter( 'bp_core_fetch_avatar_no_grav', '__return_true' );

		add_filter( 'bp_core_avatar_gravatar_default', array( $this, 'set_default_avatar' ) );
		add_filter( 'bp_core_avatar_gravatar_default_thumb', array( $this, 'set_default_avatar_thumb' ) );
		//for group default avatar
		add_filter( 'bp_core_default_avatar_group', array( $this, 'set_group_avatar' ), 10, 2 );

		//add_filter( 'bp_setup_globals',  array( $this, 'setup_avatar_default' ), 7 );

		add_filter( 'body_class', array( $this, 'filter_body_class' ), 10, 2 );

	}

	/**
	 * Load BuddyPress Functions
	 */
	private function load() {

		$path = $this->dir;

		$files = array(
			'lib/buddypress/cb-bp-templates.php',
			'lib/buddypress/cb-bp-cover-image.php',
			'lib/buddypress/cb-bp-functions.php',
			'lib/buddypress/cb-bp-hooks.php',
			'lib/framework/shortcodes/cb-bp-shortcodes.php',
		);

		if ( bp_is_active( 'friends' ) ) {
			$files[] = 'lib/buddypress/friends/cb-bp-friends-functions.php';
			$files[] = 'lib/buddypress/friends/cb-bp-friendship-requested.php';
		}

		if ( bp_is_active( 'groups' ) ) {
			$files[] = 'lib/buddypress/cb-bp-group-info.php';
		}

		//if ( bp_is_active( 'notifications' ) ) {
		//	$files[] = 'lib/buddypress/notifications/cb-bp-all-notifications.php';
		//} //BuddyPress lacks infrastructure for this all notifications, will get in phase-2

		if ( function_exists( 'breadcrumb_trail' ) ) {
			$files[] = 'lib/buddypress/cb-bp-breadcrumb.php';
		}

		if ( function_exists( 'rtmedia' ) ) {
			$files[] = 'lib/buddypress/rtmedia/class-rt-media-template-loader.php';
		}
		foreach ( $files as $file ) {
			require_once $path . '/' . $file;
		}

		add_action( 'cb_bp_loaded', array( $this, 'setup' ), 9 );
	}

	public function setup() {

		$menus = array();

		if ( cb_get_option( 'bp-enable-extra-profile-links' ) ) {
			$menus['extra-profile-menu'] = __( 'Zusätzliche Profil-Links', 'social-portal' );
		}

		if ( cb_get_option( 'bp-enable-extra-group-links' ) && bp_is_active( 'groups' ) ) {
			$menus['extra-group-menu'] = __( 'Zusätzliche Gruppenlinks', 'social-portal' ); //use it to add any page/post/url to the grup pages
		}

		//register menus
		if ( ! empty( $menus ) ) {
			register_nav_menus( $menus );
		}
	}

	public function load_css() {
		//$template_directory = $this->template_url;
	}

	public function load_js() {
		//$template_directory = $this->template_url;
	}

	/**
	 * Set default fallback avatar(user photo)
	 *
	 * @param string $avatar
	 *
	 * @return string
	 */
	public function set_default_avatar( $avatar ) {

		$member_avatar = cb_get_option( 'bp-user-avatar-image' );

		if ( empty( $member_avatar ) ) {
			$member_avatar = $this->url . '/assets/images/avatars/user-default-avatar.png';
		}

		return $member_avatar;
	}

	/**
	 * Set default fallback avatar
	 *
	 * @param type $avatar
	 *
	 * @return string
	 */
	public function set_default_avatar_thumb( $avatar ) {
		//In future, we may allow thumbs
		$member_avatar = cb_get_option( 'bp-user-avatar-image' );

		if ( empty( $member_avatar ) ) {
			$member_avatar = $this->url . '/assets/images/avatars/user-default-avatar-thumb.png';
		}

		return $member_avatar;
	}

	/**
	 * Set the default fallback photo for groups
	 *
	 * @param string $avatar
	 * @param array $params
	 *
	 * @return string
	 */
	public function set_group_avatar( $avatar, $params ) {

		//Based on $params we may decide to use a thumb/full but let us not worry about that right now
		$group_avatar = cb_get_option( 'bp-group-avatar-image' );

		if ( empty( $group_avatar ) ) {
			$group_avatar = $this->url . '/assets/images/avatars/group-default-avatar.png';
		}

		return $group_avatar;
	}

	/**
	 * Can be used for setting up default avatar but it ain't very nice
	 * So we have it disabled, Instead see the methods
	 * @see self::set_default_avatar()
	 * @see self::set_default_avatar_thumb()
	 * @see self::set_group_avatar()
	 */
	public function setup_avatar_default() {

		$member_avatar = cb_get_option( 'bp-user-avatar-image' );

		if ( $member_avatar && ! defined( 'BP_AVATAR_DEFAULT' ) ) {
			define( 'BP_AVATAR_DEFAULT', $member_avatar );
		}
	}

	/**
	 * Add extra links to User profile
	 */
	public function add_profile_menu() {

		if ( cb_get_option( 'bp-enable-extra-profile-links' ) && has_nav_menu( 'extra-profile-menu' ) ) {
			wp_nav_menu( array(
				'container'      => false,
				'theme_location' => 'extra-profile-menu',
				'items_wrap'     => '%3$s'
			) );
		}
	}

	/**
	 * Add Extra Links to Single Group
	 */
	public function add_group_menu() {

		if ( cb_get_option( 'bp-enable-extra-group-links' ) && has_nav_menu( 'extra-group-menu' ) ) {
			//Note: If you are wondering why %3s, checkout wp_nav_menu
			//that will allow us to put the links without anything else
			wp_nav_menu( array(
				'container'      => false,
				'theme_location' => 'extra-group-menu',
				'items_wrap'     => '%3$s'
			) );
		}
	}

	/**
	 * Filter Body class to add some helper classes
	 *
	 * @param array $classes
	 * @param string $class
	 *
	 * @return string
	 */
	public function filter_body_class( $classes = array(), $class = '' ) {

		if ( bp_is_user() ) {
			if (  bp_is_my_profile() ) {
				$classes[] = 'bp-user-self';
			} else {
				$classes[] = 'bp-user-other';
			}
		}

		if ( bp_is_user() && function_exists( 'bp_attachments_get_user_has_cover_image' ) && bp_attachments_get_user_has_cover_image( bp_displayed_user_id() ) ) {
			$classes[] = 'has-cover-image';
		} elseif ( bp_is_group() && function_exists( 'bp_attachments_get_group_has_cover_image' ) && bp_attachments_get_group_has_cover_image( bp_get_current_group_id() ) ) {
			$classes[] = 'has-cover-image';
		}

		return $classes;
	}
}

//
CB_BP_Helper::get_instance();
