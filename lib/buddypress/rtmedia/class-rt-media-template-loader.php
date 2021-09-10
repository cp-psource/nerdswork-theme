<?php
/**
 * @package social-portal
 * @author Brajesh Singh
 * @copyright WMS N@W.com
 *
 */
//This class cleans up the RTMedia mess and provide proper sane templating
/**
 * Class CB_RTMedia_Template_Loader
 */
class CB_RTMedia_Template_Loader {

	private $routes = array();

	public function __construct() {
		//$this->setup();
		$this->load_rt_template();
	}

	public function setup() {
		//add_action( 'template_redirect', array( $this, 'disable_rt_template' ), 100 );
		add_action( 'bp_screens', array( $this, 'load_rt_template' ), 3 );
	}

	public function disable_rt_template() {
		global $rtmedia_interaction;

		if ( ! isset( $rtmedia_interaction ) ) {
			return false;
		}

		if ( ! isset( $rtmedia_interaction->routes ) ) {
			return false;
		}

		$route = isset( $rtmedia_interaction->routes[ RTMEDIA_MEDIA_SLUG ] ) ? $rtmedia_interaction->routes[ RTMEDIA_MEDIA_SLUG ] : null;
		if ( ! $route ) {
			return;
		}

		//for some reason, has_filter always returns false here?
		//if ( has_filter( 'template_include' , array( $route, 'template_include' ) ) ) {

		//}
		if ( is_callable( array( $route, 'template_include' ) ) ) {
			remove_filter( 'template_include', array( $route, 'template_include' ), 0, 1 );
		}
	}

	public function load_rt_template() {


		if ( $this->is_ajax() ) {

			//set up the query variables
			//$this->set_query_vars();

			rtmedia_load_template();
			exit( 0 );

		} elseif ( bp_is_user() && bp_is_current_component( 'media' ) ) {
			//$this->query();
			add_action( 'bp_template_content', array( $this, 'user_contents' ) );
			bp_core_load_template( 'members/single/plugins' );

		} elseif ( bp_is_group() && bp_is_current_action( RTMEDIA_MEDIA_SLUG ) ) {
			//$this->query();
			add_action( 'bp_template_content', array( $this, 'group_contents' ) );
			bp_core_load_template( 'members/single/plugins' );

		} elseif ( bp_is_current_component( RTMEDIA_MEDIA_SLUG ) ) {
			//add_action( 'bp_template_content', 'cb_load_rt_user_contents');
			//bp_core_load_template('members/single/plugins');
		}

	}

	public function query() {

		if ( empty( $this->routes ) ) {
			return;
		}
		foreach ( $this->routes as $route ) {
			if ( is_callable( array( $route, 'rt_theme_compat_reset_post' ) ) ) {
				$route->rt_theme_compat_reset_post();
			}
		}
	}

	public function load_dir_contents() {

	}

	public function user_contents() {
		get_template_part( 'rtmedia/rt-user' );
	}

	public function group_contents() {
		get_template_part( 'rtmedia/rt-group' );
	}

	public function is_ajax() {
		global $rt_ajax_request;
		$rt_ajax_request = false;

		$_rt_ajax_request = rtm_get_server_var( 'HTTP_X_REQUESTED_WITH', 'FILTER_SANITIZE_STRING' );
		if ( 'xmlhttprequest' === strtolower( $_rt_ajax_request ) ) {
			$rt_ajax_request = true;
		}

		return $rt_ajax_request;
	}
}

function cb_filter_rt_media_pages( $template ) {
	if ( bp_is_user() && is_rtmedia_page() ) {
		new CB_RTMedia_Template_Loader();

		return bp_locate_template( 'members/single/index.php' );
	} elseif ( bp_is_group() && is_rtmedia_page() ) {
		new CB_RTMedia_Template_Loader();

		return bp_locate_template( 'groups/single/index.php' );
	}

	return $template;
}

add_filter( 'template_include', 'cb_filter_rt_media_pages' );
