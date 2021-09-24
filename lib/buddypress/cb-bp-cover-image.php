<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Implement BuddyPress 2.4+ cover image feature
 */
class CB_Cover_Image_Helper {

	public function __construct() {
		$this->setup();
	}

	/**
	 * Setup hooks
	 */
	private function setup() {
		//for profile
		//add_filter( 'bp_before_xprofile_cover_image_settings_parse_args', array( $this,	'cover_settings_profile' ), 10, 1 );
		add_filter( 'bp_before_members_cover_image_settings_parse_args', array( $this,	'cover_settings_profile' ), 10, 1 );
		//for groups
		add_filter( 'bp_before_groups_cover_image_settings_parse_args', array( $this, 'cover_settings_group' ), 10, 1 );
	}

	public function cover_settings_profile( $settings = array() ) {
		$dimensions         = cb_get_page_header_dimensions();
		$settings['width']  = $dimensions['width'];
		$settings['height'] = $dimensions['height'];

		$cover = cb_get_option( 'bp-user-cover-image' );

		if ( $cover ) {
			$settings['default_cover'] = $cover;
		}
		//$settings['default_cover'] = '';
		$settings['callback']     = array( $this, 'generate_css' );
		$settings['theme_handle'] = 'bp-parent-css';

		return $settings;
	}

	public function cover_settings_group( $settings = array() ) {
		$dimensions         = cb_get_page_header_dimensions();
		$settings['width']  = $dimensions['width'];
		$settings['height'] = $dimensions['height'];

		$cover = cb_get_option( 'bp-group-cover-image' );

		if ( $cover ) {
			$settings['default_cover'] = $cover;
		}

		$settings['callback']     = array( $this, 'generate_css' );
		$settings['theme_handle'] = 'bp-parent-css';

		return $settings;
	}

	public static function generate_css( $params = array() ) {

		if ( empty( $params ) || empty( $params['cover_image'] ) ) {
			return;
		}

		return 'body.buddypress.is-user-profile div#item-header,div#item-header {
				height:' . $params['height'] . 'px;
				background-image: url(' . $params['cover_image'] . ');
				background-size: cover;
				background-position: center center;
				}';
	}
}

new CB_Cover_Image_Helper();
