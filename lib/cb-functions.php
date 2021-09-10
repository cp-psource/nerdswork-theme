<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Get the current version of the theme
 *
 * @return string version number
 */
function cb_get_version() {
	return '1.1.6';
}

/**
 * Get the prefix for min version
 *
 * @return string
 */
function cb_get_min_suffix() {
	return '';//unless we provide minified versions in future
}

/**
 * Get the current settings for given option or the default setting if it was not changed in customizer
 *
 * Use it to fetch all community builder options
 *
 * @param string $option
 * @param mixed $default
 *
 * @return mixed
 */
function cb_get_option( $option, $default = false ) {

	if ( ! $default ) {
		$default = cb_get_default( $option );
	}

	return get_theme_mod( $option, $default );
}

/**
 * Return the value for the default setting for given key
 *
 * @since  1.0.0.
 *
 * @param  string $option The key of the option to return.
 *
 * @return mixed                Default value if found; false if not found.
 */
function cb_get_default( $option ) {

	$defaults = cb_get_default_options();
	$default  = isset( $defaults[ $option ] ) ? $defaults[ $option ] : false;

	return apply_filters( 'cb_get_default', $default, $option );
}

/**
 * Get the modified value without caring whether we are inside the customize previewer or outside
 *
 * @param $option
 * @param bool $default
 *
 * @return bool|string false if not modified else modified value
 */
function cb_get_modified_value( $option, $default = false ) {
	$modified = get_theme_mod( $option, $default );

	if ( is_customize_preview() ) {
		$old_default = cb_get_default( $option );

		if ( $modified == $old_default ) { //do not use === will case issues with array comparision
			return false;//nothing has changed, no need to generate anything
		}
	}

	return $modified;
}

/**
 * Is the current Post/Page using page builder?
 *
 * @param int $post_id
 *
 * @return boolean
 */
function cb_is_using_page_builder( $post_id = 0 ) {

	$using = false;

	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	if ( ! $post_id ) {
		$using = false;
	} elseif ( function_exists( 'maximus_pb_is_pagebuilder_used' ) ) {
		$using = maximus_pb_is_pagebuilder_used( $post_id );
	}

	return apply_filters( 'cb_using_page_builder', $using, $post_id );
}

/**
 * Is BuddyPress Active?
 *
 * @staticvar boolean $is_active
 *
 * @return boolean
 */
function cb_is_bp_active() {

	static $is_active;

	if ( isset( $is_active ) ) {
		return $is_active;
	}

	if ( function_exists( 'buddypress' ) ) {
		$is_active = true;
	} else {
		$is_active = false;
	}

	return $is_active;
}
/**
 * Is PSForum Active?
 *
 * @staticvar boolean $is_active
 *
 * @return boolean
 */
function cb_is_psf_active() {

	static $is_active;

	if ( isset( $is_active ) ) {
		return $is_active;
	}

	if ( function_exists( 'psforum' ) ) {
		$is_active = true;
	} else {
		$is_active = false;
	}

	return $is_active;
}

/**
 * Is WooCommerce Active?
 *
 * @staticvar boolean $is_active
 *
 * @return boolean
 */
function cb_is_wc_active() {

	static $is_active;

	if ( isset( $is_active ) ) {
		return $is_active;
	}

	if ( class_exists( 'WooCommerce' ) ) {
		$is_active = true;
	} else {
		$is_active = false;
	}

	return $is_active;
}

/**
 * Is PSeCommerce Active?
 *
 * @staticvar boolean $is_active
 *
 * @return boolean
 */
function cb_is_psecommerce_active() {

	static $is_active;

	if ( isset( $is_active ) ) {
		return $is_active;
	}

	if ( class_exists( 'PSeCommerce' ) ) {
		$is_active = true;
	} else {
		$is_active = false;
	}

	return $is_active;
}

/**
 * Is Woothemes Sensei plugin Active?
 *
 * @staticvar boolean $is_active
 *
 * @return boolean
 */
function cb_is_sensei_active() {

	static $is_active;

	if ( isset( $is_active ) ) {
		return $is_active;
	}

	if ( class_exists( 'Sensei_Main' ) ) {
		$is_active = true;
	} else {
		$is_active = false;
	}

	return $is_active;
}


/**
 * Load font awesome css?
 *
 * @return boolean
 */
function cb_load_fa() {
	return apply_filters( 'cb_load_fa', cb_get_option( 'load-fa', 1 ) );
}

/**
 * Load font awesome from Bootstrap cdn?
 *
 * @return boolean
 */
function cb_load_fa_from_cdn() {
	return apply_filters( 'cb_load_fa_from_cdn', cb_get_option( 'load-fa-cdn', 0 ) );
}

/**
 * Should we load Google fonts?
 *
 * @return boolean
 */
function cb_load_google_fonts() {
	return apply_filters( 'cb_load_google_fonts', cb_get_option( 'load-google-font', 1 ) );
}

/**
 * Get Page Header image dimensions
 *
 * @return array
 */
function cb_get_page_header_dimensions() {

	return apply_filters( 'cb_page_header_dimensions', array(
		'width'  => 2000,
		'height' => 250
	) );
}

/**
 * Get the class applied based on current active footer widgetized area
 *
 * @return array
 */
function cb_get_footer_widget_wrapper_class() {

	$sidebars = array(
		'footer-1',
		'footer-2',
		'footer-3',
		'footer-4'
	);

	$count = 0;

	foreach ( $sidebars as $sidebar ) {

		if ( is_active_sidebar( $sidebar ) ) {
			$count ++;
		}
	}

	//widget-cols-1, widget-cols-2,3,4
	return 'widget-cols-' . $count;
}

/**
 * Check if anyone of the footer widget area is enabled?
 *
 * @return bool
 */
function cb_has_footer_widget_area_enabled() {

	$sidebars = array(
		'footer-1',
		'footer-2',
		'footer-3',
		'footer-4'
	);

	foreach ( $sidebars as $sidebar ) {
		if ( is_active_sidebar( $sidebar ) ) {
			return true; //yes, we found one
		}
	}

	//if we are here, none of the footer widget area is enabled
	return false;
}

/**
 * The big array of global default options.
 *
 * @return array    The default values for all theme options.
 */
function cb_get_default_options() {
	$defaults = array(

		/**
		 * Layout
		 */

		// Global Layout
		'theme-layout'                          => 'layout-two-col-right-sidebar',//layout-two-col-left-sidebar|layout-single-col
		'layout-style'                          => 'boxed', //'fluid'
		'theme-fluid-width'                     => '90%',
		'content-width'                         => 65, //0-100% of the container

		'panel-left-user-scope'                 => 'all', //'all'=>Everyone, 'logged-in', 'logged-out'
		'panel-left-visibility'                 => 'always', //mobile, never

		'panel-right-user-scope'                => 'all', //'all'=>Everyone, 'logged-in', 'logged-out'
		'panel-right-visibility'                => 'always', //mobile. never
		'hide-admin-bar'                        => 0,

		'home-layout'                           => 'default', //Use theme-layout
		'search-layout'                         => 'default',
		'404-layout'                            => 'default',
		'archive-layout'                        => 'default',

		// Header
		'header-layout'                         => 'header-layout-default',//current header layout header-layout-default-{1-10}
		'header-show-social'                    => 0,//show social links in header
		'header-social-icon-font-size'          => 22,// px icon font for social links
		'header-show-search'                    => 1,
		'header-show-notification-menu'         => 1,
		'header-show-account-menu'              => 1,
		'dashboard-link-capability'             => 'manage_options',
		'sites-link-capability'                 => 'manage_options',
		'header-show-login-links'               => 1,

		// Footer
		'footer-widget-areas'                   => 3,
		'footer-text'                           => 'Powered by <a href="http://wordpress.org">WordPress</a> & <a href="https://n3rds.work/">WMS N@W Theme</a> Theme',
		'footer-show-social'                    => 1, // Footer Icons
		'footer-social-icon-font-size'          => 22, //px

		// Social Profiles
		'social-facebook'                       => '#',
		'social-twitter'                        => '#',
		'social-google-plus'                    => '#',
		'social-linkedin'                       => '#',
		'social-instagram'                      => '',
		'social-flickr'                         => '',
		'social-youtube'                        => '',
		'social-vimeo'                          => '',
		'social-pinterest'                      => '',
		// Email
		'social-email'                          => '',
		// RSS
		'hide-rss'                              => 0,
		'custom-rss'                            => '',

		/**
		 * Typography
		 */

		'base-font-settings'                    => array(
			'font-family' => 'sans-serif',//Sans serif Stack
			'variant'     => 'normal',
			'font-size'   => 16,
			'line-height' => (float) 1.33,
			// 'color'    => '#333333',
		),

		'base-mid-font-settings'                => array(
			'font-size'   => 14,
			'line-height' => (float) 1.33,
		),

		'base-small-font-settings'              => array(
			'font-size'   => 12,
			'line-height' => (float) 1.33,
		),

		// Global/Default

		'h1-font-settings'                      => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 28,
			'line-height' => (float) 1.1,
		),

		'h2-font-settings'                      => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 24,
			'line-height' => (float) 1.1,
		),

		'h3-font-settings'                      => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 22,
			'line-height' => (float) 1.1,
		),

		'h4-font-settings'                      => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 18,
			'line-height' => (float) 1.1,
		),

		'h5-font-settings'                      => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 16,
			'line-height' => (float) 1.1,
		),
		'h6-font-settings'                      => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 14,
			'line-height' => (float) 1.1,
		),

		//site title
		'site-title-font-settings'              => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 28,
		),

		'main-nav-font-settings'                => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 16,
		),

		'sub-nav-font-settings'                 => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 16,
		),

		'page-header-title-font-settings'       => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 32,
			'line-height' => (float) 1.33,

		),
		'page-header-content-font-settings'     => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 16,
			'line-height' => (float) 1.33,

		),

		'widget-title-font-settings'            => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 22,
			'line-height' => (float) 1.1,

		),
		'widget-font-settings'                  => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 16,
			'line-height' => (float) 1.33,
		),

		'footer-font-settings'                  => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 14,
			'line-height' => (float) 1.33,
		),
		'footer-widget-title-font-settings'     => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 16,
			'line-height' => (float) 1.1,
		),
		'footer-widget-font-settings'           => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 14,
			'line-height' => (float) 1.33,
		),

		//header
		'header-font-settings'                  => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 16,
			'line-height' => (float) 1.33,
		),


		// Google Web Fonts
		'font-subset'                           => 'latin',

		/**
		 * Colors/font
		 */

		'theme-style'                           => 'default', // Color Scheme
		//'primary-color'                         => '#3070d1',
		//'secondary-color'                       => '#eaecee',
		'text-color'                            => '#333',

		// Links
		'link-color'                            => '#666',
		'link-hover-color'                      => '#444',

		//global buttons
		'button-background-color'               => '#fff',
		'button-text-color'                     => '#666',
		'button-hover-background-color'         => '',
		'button-hover-text-color'               => '',

		//site title

		'site-title-link-color'                 => '#666',
		'site-title-link-hover-color'           => '#666',

		// Background
		// Site
		'background_image'                      => '',
		'background_repeat'                     => 'repeat',
		'background_position_x'                 => 'left',
		'background_attachment'                 => 'scroll',
		'background_size'                       => 'auto',
		'background-color'                      => '#fff',

		// Site Header

		'header-background-image'               => '',
		'header-background-repeat'              => 'no-repeat',
		'header-background-position'            => 'center',
		'header-background-attachment'          => 'scroll',
		'header-background-size'                => 'cover',

		'header-background-color'               => 'rgba(0,0,0,0)',
		'header-text-color'                     => '#333',//inherit
		'header-link-color'                     => '#666',//inherit
		'header-link-hover-color'               => '#444',//inherit

		'header-border'                         => array(
			'border-edge'  => 'none',
			'border-style' => 'solid',
			'border-width' => 0,
			'border-color' => '#333',
		),

		//toggle
		'panel-left-toggle-color'               => '#666',
		'panel-right-toggle-color'              => '#666',
		//Login/register button in header
		'header-buttons-background-color'       => '#fff',
		'header-buttons-text-color'             => '#333',//inherit
		'header-buttons-hover-background-color' => '#fff',
		'header-buttons-hover-text-color'       => '#444',//inherit


		//header top
		'header-top-background-color'           => '#005580',
		'header-top-text-color'                 => '#fff',
		'header-top-link-color'                 => '#666',
		'header-top-link-hover-color'           => '#444',

		'header-top-border' => array(
			'border-edge'  => 'border-bottom',
			'border-style' => 'solid',
			'border-width' => 0,
			'border-color' => '#fff',
		),
		//header main
		'header-main-background-color'          => 'rgba(255,255,255,1)',
		'header-main-text-color'                => '#171717',
		'header-main-link-color'                => '#171717',
		'header-main-link-hover-color'          => '#171717',

		'header-main-border'                    => array(
			'border-edge'  => 'none',
			'border-style' => 'solid',
			'border-width' => 0,
			'border-color' => '#fff',
		),
		//header bottom
		'header-bottom-background-color'        => 'rgba(0,0,0,0)',
		'header-bottom-text-color'              => '#333',
		'header-bottom-link-color'              => '#666',
		'header-bottom-link-hover-color'        => '#444',
		'header-bottom-border'                  => array(
			'border-edge'  => 'none',
			'border-style' => 'solid',
			'border-width' => 0,
			'border-color' => '#dfdfdf',
		),

		// Main Nav
		// Menu Items


		'main-nav-background-image'             => '',
		'main-nav-background-repeat'            => 'no-repeat',
		'main-nav-background-position'          => 'center',
		'main-nav-background-attachment'        => 'scroll',
		'main-nav-background-size'              => 'cover',

		'main-nav-background-color'             => 'rgba(0,0,0,0)',
		'main-nav-alignment'                    => 'left',
		'main-nav-link-color'                   => '#666',
		'main-nav-link-hover-color'             => '#444',
		'main-nav-link-background-color'        => 'rgba(0,0,0,0)',
		'main-nav-link-hover-background-color'  => 'rgba(0,0,0,0)',
		'main-nav-link-border'                  => array(
			'border-edge'  => 'border-bottom',
			'border-style' => 'solid',
			'border-width' => 1,
			'border-color' => '#444',
		),

		'main-nav-link-hover-border'                  => array(
			'border-edge'  => 'border-bottom',
			'border-style' => 'solid',
			'border-width' => 1,
			'border-color' => '#444',
		),
		// Current Item
		'main-nav-selected-item-color'          => '#333',
		'main-nav-selected-item-font-weight'    => 'normal',


		// Sub-Menu Items

		'sub-nav-link-background-color'         => '#373737',
		'sub-nav-link-hover-background-color'   => '#373737',
		'sub-nav-link-color'                    => '#666',
		'sub-nav-link-hover-color'              => '#444',
		'sub-nav-link-border'                  => array(
			'border-edge'  => 'border-bottom',
			'border-style' => 'solid',
			'border-width' => 1,
			'border-color' => '#444',
		),

		'sub-nav-link-hover-border'                  => array(
			'border-edge'  => 'border-bottom',
			'border-style' => 'solid',
			'border-width' => 1,
			'border-color' => '#444',
		),
		//Page Header

		'page-header-mask-color'                => 'rgba( 1, 1, 1, .2 )',
		'page-header-background-color'          => '#f7f7f7',
		//rgba( 0, 0, 0, 0 )',
		'page-header-title-text-color'          => '#666',
		'page-header-content-text-color'        => '#666',

		// Main column
		'main-background-image'                 => '',
		'main-background-repeat'                => 'repeat',
		'main-background-position'              => 'left',
		'main-background-attachment'            => 'scroll',
		'main-background-size'                  => 'auto',
		'main-background-color'                 => 'rgba(0,0,0,0)',
		//sidebar
		'sidebar-background-color'              => 'rgba(0,0,0,0)',
		'sidebar-text-color'                    => '#333',
		'sidebar-link-color'                    => '#666',
		'sidebar-link-hover-color'              => '#444',

		// Sidebar Widget Title

		'widget-title-text-color'               => '#888',
		'widget-title-link-color'               => '#888',
		'widget-title-link-hover-color'         => '#666',

		'widget-background-color'               => 'rgba(0,0,0,0)',
		'widget-text-color'                     => '#333',
		'widget-link-color'                     => '#666',
		'widget-link-hover-color'               => '#444',

		// Footer

		'footer-background-image'               => '',
		'footer-background-repeat'              => 'no-repeat',
		'footer-background-position'            => 'center',
		'footer-background-attachment'          => 'scroll',
		'footer-background-size'                => 'cover',
		'footer-background-color'               => 'rgba(0,0,0,0)',

		'footer-text-color'                     => '#333',
		'footer-link-color'                     => '#666',
		'footer-link-hover-color'               => '#444',

		// Footer Top
		'footer-top-background-image'           => '',
		'footer-top-background-repeat'          => 'no-repeat',
		'footer-top-background-position'        => 'center',
		'footer-top-background-attachment'      => 'scroll',
		'footer-top-background-size'            => 'cover',
		'footer-top-background-color'           => 'rgba(0,0,0,0)',

		'footer-top-text-color'                 => '#333',
		'footer-top-link-color'                 => '#666',
		'footer-top-link-hover-color'           => '#444',


		//Site copyright
		'site-copyright-background-color'       => 'rgba(0,0,0,0)',

		'site-copyright-text-color'             => '#888',
		'site-copyright-link-color'             => '#666',
		'site-copyright-hover-color'            => '#444',

		//== Login Page
		'login-page-mask-color'                => 'rgba( 0, 0, 0, 0 )',
		'login-background-image'                => '',
		'login-background-repeat'               => 'no-repeat',
		'login-background-position'             => 'center',
		'login-background-attachment'           => 'scroll',
		'login-background-size'                 => 'cover',
		//colors
		'login-background-color'                => '#F8F8F8',
		'login-text-color'                      => '#666',
		'login-link-color'                      => '#666',
		'login-link-hover-color'                => '#444',


		'login-font-settings'                   => array(
			'font-family' => 'Open Sans',
			'variant'     => 300,
			'font-size'   => 16,
		),

		//Login Box
		'login-box-background-color'            => 'rgba(0,0,0,0)', //transparent
		'login-box-border'                      => array(
			'border-edge'  => 'border',
			'border-style' => 'solid',
			'border-width' => 0,
			'border-color' => '#eee',
		),

		'login-logo-link-color'                 => '#444',
		'login-logo-link-hover-color'           => '#00a0d2',

		'login-logo-font-settings'              => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 32,
		),

		'login-input-background-color'          => '#fff',
		'login-input-text-color'                => '#666',
		'login-input-border'                    => array(
			'border-edge'  => 'border',
			'border-width' => 1,
			'border-style' => 'solid',
			'border-color' => '#e2e2e2'
		),
		'login-input-focus-background-color'    => '#fff',
		'login-input-focus-text-color'          => '#666',
		'login-input-focus-border'              => array(
			'border-edge'  => 'border',
			'border-width' => 1,
			'border-style' => 'solid',
			'border-color' => '#c9c9c9'
		),
		'login-input-placeholder-color'         => '#333',

		'login-submit-button-background-color'  => '#00C2C7',
		'login-submit-button-text-color'        => '#fff',
		'login-submit-button-hover-text-color'  => '#f1f1f1',

		'login-submit-button-hover-background-color' => '#00C2C7',

		//Blogs section
        'featured-image-fit-container'          => 1,//fit the featured image to container using img liquid?
        'page-show-header'                      => 1,
        'page-show-title'                       => 0,
        'page-show-featured-image'              => 0,

		'post-show-header'                      => 1,
		'post-show-title'                       => 0,
		'post-show-featured-image'              => 0,

		'post-header'                           => 'Von [author-posts-link] | [post-date] | [post-categories] | [post-comment-link]',
		//[author-posts-link] wrote on [post-date] in [post-categories]',
		'post-footer'                           => '[author-posts-link] veröffentlicht am [post-date] in [post-tags]',

		'post-show-article-header'              => 1,
		'post-show-article-footer'              => 0,
		'archive-show-featured-image'           => 1,

		// Labels
		'label-read-more'                       => __( 'weiterlesen', 'social-portal' ),

		//Archive
		'archive-show-header'                   => 1,
		'archive-show-article-header'           => 1,
		'archive-show-article-footer'           => 0,
		'archive-post-header'                   => 'Von [author-posts-link] | [post-date] | [post-categories] | [post-comment-link]',
		//[author-posts-link] wrote on [post-date] in [post-categories]',
		'archive-post-footer'                   => '[author-posts-link]  veröffentlicht am [post-date] in [post-tags]',
		'archive-posts-display-type'            => 'standard', //standard|masonry|
		'archive-posts-per-row'                 => 2,
		'home-posts-display-type'               => 'masonry',//standard|masonry|
		'home-posts-per-row'                    => 2,
		'search-posts-display-type'              => 'masonry',//standard|masonry|
		'search-posts-per-row'                  => 2,

		// WooCommerce pages(shop panel)
		'wc-page-layout'                        => 'page-single-col',
		'wc-show-header'                        => 1,
		'wc-show-title'                         => 1,
		'product-page-layout'                   => 'default',
		'product-show-header'                   => 1,
		'product-show-title'                    => 1,
		'product-category-page-layout'          => 'default',
		'product-category-show-header'          => 1,
		'product-category-show-title'           => 0,



		//BuddyPress settings
		'bp-use-wp-page-title'                  => 1,
		'bp-excerpt-length'                     => 140,
		'bp-item-list-use-gradient'             => 1, //use gradient in the item header in loops?
		'bp-item-list-display-type'             => 'masonry', //masonry layout for items?
		'bp-item-list-avatar-size'              => 150, //avatar size in the lists like directory, friend lists etc

		'bp-single-item-title-font-settings'    => array(
			'font-family' => 'inherit',
			'variant'     => 'normal',
			'font-size'   => 28,
		),
		'bp-single-item-title-link-color'       => '#666',
		'bp-single-item-title-link-hover-color' => '#444',
		'bp-dropdown-toggle-background-color'   => '#333',
		'bp-dropdown-toggle-text-color'         => '#fdfdfd',
		'bp-dropdown-toggle-hover-background-color'   => '#333',
		'bp-dropdown-toggle-hover-text-color'   => '#fdfdfd',


		'bp-activities-per-page'                => 20,
		'bp-activity-item-arrow'                => 1, //use arrow
		'bp-activity-enable-autoload'           => 1,

		'bp-members-directory-layout'           => 'default',
		'bp-members-per-page'                   => 24,
		'bp-members-per-row'                    => 3,
		'bp-member-profile-layout'              => 'default',
		'bp-member-show-breadcrumb'             => 1,
		'bp-enable-extra-profile-links'         => 1,
		'bp-member-friends-per-page'                   => 24,
		'bp-member-friends-per-row'                    => 2,
		'bp-member-groups-per-page'                   => 24,
		'bp-member-groups-per-row'                    => 2,

		'bp-member-blogs-per-page'                   => 24,
		'bp-member-blogs-per-row'                    => 2,


		'bp-groups-directory-layout'            => 'default',
		'bp-groups-per-page'                    => 24,
		'bp-groups-per-row'                     => 3,
		'bp-groups-max-desc-words'              => 30,//Not used
		'bp-group-show-breadcrumb'              => 1,
		'bp-enable-extra-group-links'           => 1,
		'bp-group-members-per-row'              => 2,
		'bp-group-members-per-page'             => 24,

		'bp-single-group-layout'                => 'default',

		'bp-blogs-directory-layout'             => 'default',
		'bp-blogs-per-page'                     => 24,
		'bp-blogs-per-row'                      => 3,
		'bp-blogs-max-desc-words'               => 30,//not used

		'bp-signup-page-layout'                 => 'default',
		'bp-activation-page-layout'             => 'default',

		'panel-right-login-title'               => '',
		//advance
		'enable-text-widget-shortcode'          => 1,
		'enable-editor-style'                   => 1,
		'enable-textarea-autogrow'              => 1,
		'disable-main-menu-dropdown-icon'       => 0,
		'enable-selectbox-styling'              => 1,
		'selectbox-excluded-selector'           => '.sa-field-content select, .adverts-options select, .adverts-form select, .chosen_select, .select2-hidden-accessible, .geodir-search select, .tribe-community-event-info select',
		'show-home-in-menu'                     => 0,
		'load-fa'                               => 1,
		'load-fa-cdn'                           => 0,
		'load-google-font'                      => 1,

	);

	$theme_styles = combuilder()->get_theme_style();

	if ( $theme_styles ) {

		//should we first try to get it from cache instead?
		//Let us do some performance test and then we can say for sure

		$settings = $theme_styles->get_settings();
		$defaults = wp_parse_args( $settings, $defaults );
	}

	/**
	 * Filter the default values for the settings.
	 *
	 * @param array $defaults The list of default settings.
	 */
	return apply_filters( 'cb_setting_defaults', $defaults );
}

/**
 * Get all available color palettes & descriptive colors
 * The Colors Here are only for the representational use in the theme customizer and have no effects on settings
 * The $key is important and decides the color scheme
 *
 * @return array
 */
function cb_get_theme_color_palettes() {

	$palettes = array();

	$schemes = combuilder()->get_theme_styles();

	foreach ( $schemes as $scheme ) {
		$palettes[ $scheme->get_id() ] = array(
			'id'     => $scheme->get_id(),
			'label'  => $scheme->get_label(),
			'colors' => $scheme->get_palette(),
		);
	}

	return apply_filters( 'cb_theme_color_palettes', $palettes );
}
