<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}


/**
 * This class loads all the core files of WMS N@W Theme and sets up different hooks
 *
 * Loading of BuddyPress dependent files are delegated to buddypress/cb-bp-loader.php
 *
 * We are using singleton here to allow child themes remove an action/filter easily if they desire so
 *
 */
class CB_Core_Loader {

	private static $instance = null;
	/**
	 * Absolute url to template directory
	 *
	 * @var string
	 */
	private $url = '';
	/**
	 * Absolute path to Template Directory
	 *
	 * @var string
	 */
	private $path = '';


	private function __construct() {

		$this->path = combuilder()->get_path();
		$this->url  = combuilder()->get_url();

		//Load required files on after_setup_theme
		add_action( 'after_setup_theme', array( $this, 'load' ), 0 );

		//Setup theme features
		add_action( 'after_setup_theme', array( $this, 'setup' ) );

		//setup widgetized area
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );

		//set $content_width dynamically
		add_action( 'template_redirect', array( $this, 'set_content_width' ) );

		//Setup current layout( Header/some other sections )
		//We use template redirect as it is the last action before the layout starts rendering
		add_action( 'template_redirect', array( $this, 'setup_layout' ), 1000 );

		//filter body_class
		add_filter( 'body_class', array( $this, 'add_body_classes' ) );

		//Load assets
		add_action( 'wp_enqueue_scripts', array( $this, 'load_js' ), 9 );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_css' ), 9 );

		//Add customizer generated css
		add_action( 'wp_head', array( $this, 'generate_css' ) );

		// for editor style
		add_action( 'wp_ajax_cb_generate_editor_css', array( $this, 'generate_editor_css' ) );
		//add_action( 'wp_ajax_nopriv_cb_generate_editor_css', array( $this, 'generate_editor_css' ) );
	}

	/**
	 * Get singleton instance
	 *
	 * @return CB_Core_Loader
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Load required files
	 *
	 */

	public function load() {

		$files = array(

			'lib/framework/theme-styles/class-theme-style.php',//ThemeStyle class
			'lib/framework/cb-layout-functions.php',//page layout helper
			'lib/framework/cb-nav-walker.php',//panel nav walker
			'lib/framework/cb-font-functions.php',//core font functions
			'lib/framework/cb-template-tags.php', //template tags

			//customizer loader/setup helper
			'lib/framework/customizer/customizer-helper.php',

			//Layout Block/Builder
			'lib/framework/layout-builder/cb-site-header-elements.php',
			'lib/framework/layout-builder/cb-page-header-elements.php',
			'lib/framework/layout-builder/cb-page-elements.php',
			'lib/framework/layout-builder/cb-comments-template.php',
			//css builder, we need it all the time
			'lib/framework/css-helper/cb-css-builder.php',
			'lib/framework/css-helper/cb-css-generator-functions.php',

			//shortcodes
			'lib/framework/shortcodes/cb-post-meta.php',
			//various hooks
			'lib/framework/cb-hooks.php',
			'lib/framework/cb-adminbar-menu-scrapper.php',
		);
		//if BuddyPress is active,
		// Load BuddyPress helper for the theme
		if ( cb_is_bp_active() ) {
			$files[] = 'lib/buddypress/cb-bp-loader.php';
		}

		//If woocommerce is active, Load wc helper
		if ( cb_is_wc_active() ) {
			$files[] = 'lib/wc/cb-woocommerce.php';
		}

		if ( cb_is_psecommerce_active() ) {
			$files[] = 'lib/psecommerce/cb-psecommerce.php';
		}

		//If Sensei is active, Load wc helper
		if ( cb_is_sensei_active() ) {
			$files[] = 'lib/sensei/cb-sensei.php';
		}

		if ( cb_is_psf_active() ) {
			$files[] = 'lib/psforum/cb-psf-hooks.php';
		}

		//Load Geo Directory compatibility code
		if ( function_exists( 'geodir_error_log' ) ) {
			$files[] ='lib/compat/cb-geo-dir-compatibility.php';
		}

		//if we are inside admin, load admin
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			$files[] = 'admin/cb-admin.php';
		}

		global $pagenow;

		if ( $pagenow == 'wp-login.php' ) {
			$files[] = 'lib/framework/cb-custom-login-style.php';
		}

		$path = $this->path;

		foreach ( $files as $file ) {
			require_once $path . '/' . $file;
		}
		/**
		 * Use this hook to load your files in the child theme if you want them to be loaded after the libraries
		 */
		do_action( 'cb_core_loaded' );
	}

	/**
	 * Setup our theme feature
	 *
	 * @global int $content_width
	 */
	public function setup() {
		//this global $content_width is used by WordPress for limiting the embed widths
		global $content_width;

		//Load theme text-domain
		load_theme_textdomain( 'social-portal', $this->path . '/languages' );

		// This theme comes with all the BuddyPress goodies
		// No need to add theme support for BuddyPress, Let the theme compat kick in
		//add_theme_support( 'buddypress' );


		// Declare WooCommerce support.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// This theme uses post thumbnails
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
		//register image sizes
		$this->register_image_sizes();

		/**
		 * Set the content width based on the theme's design and stylesheet.
		 *
		 * Used to set the width of images and content. Should be equal to the width the theme
		 * is designed for, generally via the style.css stylesheet.
		 */
		if ( ! isset( $content_width ) ) {
			$content_width = cb_get_option( 'content-width' );

			if ( empty( $content_width ) ) {
				$content_width = 520;
			} else {
				// $content width is in percentage, multiply byy max_width/100 -padding to get the actual.
				$content_width = absint( absint( $content_width ) * 12.5 - 40 );
			}
		}

		//we do not want adminbar to echo its own css(the top/padding thing )
		add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

		//Do we advertise support for rss
		if ( ! cb_get_option( 'hide-rss' ) ) {
			// Add default posts and comments RSS feed links to head
			add_theme_support( 'automatic-feed-links' );
		}

		// Let WordPress handle title
		add_theme_support( 'title-tag' );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically font, colors, and column width.
		 */
		if ( cb_get_option( 'enable-editor-style' ) ) {

			add_editor_style( array(
				'assets/css/editor-style.css',
				cb_get_selected_google_fonts_uri(),
				add_query_arg( array(
					'action'   => 'cb_generate_editor_css',
					'_wpnonce' => wp_create_nonce( 'cb_generate_editor_css' )
				), admin_url( 'admin-ajax.php' ) )
			) );
		}

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'widgets',
		) );

		 // Add Logo support

		$defaults = array(
			'height'      => 60,
			'width'       => 250,
			'flex-height' => true,
			'flex-width'  => true,
			'header-text' => array( 'logo-text', 'site-title', 'site-description' ),
		);
		add_theme_support( 'custom-logo', $defaults );

		//add support for custom header/bg
		$this->add_header_bg_support();

		//Register nav menu
		$this->register_nav_menu();

		//setup done, child theme can do their own setup here
		do_action( 'cb_after_setup_theme' );
	}

	/**
	 * Register image sizes
	 *
	 */
	private function register_image_sizes() {

		$sizes = $this->get_image_sizes();

		set_post_thumbnail_size( $sizes['thumbnail']['width'], $sizes['thumbnail']['height'], $sizes['thumbnail']['crop'] );
		//already set the thumbnail, now register other image sizes
		unset( $sizes['thumbnail'] );

		foreach ( $sizes as $thumb_key => $thumb_info ) {
			add_image_size( $thumb_key, $thumb_info['width'], $thumb_info['height'], $thumb_info['crop'] );
		}
	}

	/**
	 * Register Nav Menu
	 */
	public function register_nav_menu() {

		//This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary'          => __( 'Hauptnavigation', 'social-portal' ),
			//top main nav
			'panel-left-menu'  => __( 'Menü linkes Panel (auf kleinem Bildschirm sichtbar)', 'social-portal' ),
			//Left Panel
			'panel-right-menu' => __( 'Menü rechtes Panel (auf kleinem Bildschirm sichtbar)', 'social-portal' ),
			//Right Panel
		) );
	}

	/**
	 * Register Widget Areas
	 */
	public function register_widgets() {

		// Area 1, located in the sidebar. Empty by default.
		register_sidebar( array(
			'name'          => __( 'Seitenleiste', 'social-portal' ),
			'id'            => 'sidebar',
			'description'   => __( 'Der Widget-Bereich der Seitenleiste', 'social-portal' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>'
		) );

		// Left panel widget area
		//appears below the left panel menu
		register_sidebar( array(
			'name'          => __( 'Widget-Bereich linkes Panel', 'social-portal' ),
			'id'            => 'panel-left-sidebar',
			'description'   => __( 'Erscheint im linken Panel unter dem Menü', 'social-portal' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>'
		) );

		// Right panel widget area
		// appears in the right panel below menu.
		register_sidebar( array(
			'name'          => __( 'Widget-Bereich rechtes Panel', 'social-portal' ),
			'id'            => 'panel-right-sidebar',
			'description'   => __( 'Erscheint im rechten Panel unter dem Menü', 'social-portal' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>'
		) );

		//Footer
		// Area 1, located in the footer. Empty by default.
		$footer_widget_areas = cb_get_option( 'footer-widget-areas' );

		$translated_labels = array(
			1 => __( 'Erster', 'social-portal' ),
			2 => __( 'Zweiter', 'social-portal' ),
			3 => __( 'Dritter', 'social-portal' ),
			4 => __( 'Viertel', 'social-portal' ),

		);

		for ( $i = 1; $i <= $footer_widget_areas; $i ++ ) {
			register_sidebar( array(
				'name'          => sprintf( __( ' %s Fußzeilen-Widget-Bereich', 'social-portal' ), $translated_labels[ $i ] ),
				'id'            => 'footer-' . $i,
				'description'   => sprintf( __( 'Der %s-Fußzeilen-Widget-Bereich', 'social-portal' ), strtolower( $translated_labels[ $i ] ) ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widgettitle">',
				'after_title'   => '</h5>',
			) );
		}
	}

	/**
	 * Add header, Background support
	 */
	public function add_header_bg_support() {

		$dim = cb_get_page_header_dimensions();
		//header
		$args = array(
			//'default-image'      => $this->url . 'assets/images/default-image.jpg',
			'default-text-color' => '000',
			'width'              => $dim['width'],
			'height'             => $dim['height'],
			'flex-width'         => true,
			'flex-height'        => true,
		);

		add_theme_support( 'custom-header', $args );

		//bg
		$bg_defaults = array(
			'default-image'      => '',
			'default-repeat'     => 'repeat',
			'default-position-x' => 'left',
			'default-attachment' => 'scroll',
			'default-color'      => '#eaeaea',
			//'wp-head-callback'       => '_custom_background_cb',
			//'admin-head-callback'    => '',
			//'admin-preview-callback' => '',
		);
		add_theme_support( 'custom-background', $bg_defaults );
	}

	public function remove_hooks() {

	}

	/**
	 * Load Javascript files required by the theme
	 */
	public function load_js() {

		$template_url = $this->url;
		//Load vendors js file that contains all dependency
		wp_register_script( 'cb-vendors-js', $template_url . '/assets/vendors/vendors.js', array( 'jquery' ), true );

		//main theme js
		wp_register_script( 'cb-theme-js', $template_url . '/assets/js/theme.js', array(
			'jquery',
			'cb-vendors-js',
			'jquery-masonry',

		), true );

		// wp_enqueue_script( 'cb-vendors-js' );

		//load theme js
		wp_enqueue_script( 'cb-theme-js' );
		$data = array(
			'bp_item_list_display_type'       => cb_get_option( 'bp-item-list-display-type', 'masonry' ),
			'bp_activity_enable_autoload'     => (boolean) cb_get_option( 'bp-activity-enable-autoload' ),
			'featured_image_fit_container'    => (boolean) cb_get_option( 'featured-image-fit-container' ),
			'enable_textarea_autogrow'        => (boolean) cb_get_option( 'enable-textarea-autogrow' ),
			'enable_selectbox_styling'        => (boolean) cb_get_option( 'enable-selectbox-styling' ),
			'selectbox_excluded_selector'     => cb_get_option( 'selectbox-excluded-selector' ),
			'disable_main_menu_dropdown_icon' => cb_get_option( 'disable-main-menu-dropdown-icon' )

		);
		wp_localize_script( 'cb-theme-js', 'SocialPortal', $data );

		// Maybe enqueue comment reply JS
		if ( is_singular() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		//buddypress.js is loaded by buddypress-functions.php
	}

	/**
	 * Load CSS
	 */
	public function load_css() {

		$template_url = $this->url;
		$version      = cb_get_version();

		//register default css(structural)
		wp_register_style( 'cb-default-css', $template_url . '/assets/css/default.css', array(), $version );
		//get current theme style
		$theme_style = combuilder()->get_theme_style();
		if ( $theme_style && $theme_style->has_stylesheet() ) {
			wp_register_style( 'cb-theme-style-css', $theme_style->get_stylesheet(), array(), $version );
		}

		//register woocommerce styles
		$this->register_wc_styles();

		$fa_url = '';
		//Load font awesome?
		if ( cb_load_fa() ) {
			//load from CDN?
			if ( cb_load_fa_from_cdn() ) {
				$fa_url = '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css';
			} else {
				$fa_url = $template_url . '/assets/vendors/font-awesome/css/font-awesome.css';
			}

			wp_register_style( 'font-awesome', $fa_url, array(), $version );
		}

		if ( cb_load_fa() ) {
			wp_enqueue_style( 'font-awesome' );
		}

		//load all google fonts selected by the site admin
		$font_uri = cb_get_selected_google_fonts_uri();

		if ( $font_uri && cb_load_google_fonts() ) {
			wp_enqueue_style( 'cb-google-font', $font_uri );
		}

		wp_enqueue_style( 'cb-default-css' );
		wp_enqueue_style( 'cb-theme-style-css' );


		if ( cb_is_wc_active() ) {
			$this->enable_wc_styles();

		}

		// load custom.css file from child theme
		// Disabling in version 1.1.0, Let us leave it to the child theme?
		/*if ( is_child_theme() && is_readable( get_stylesheet_directory() . '/assets/css/custom.css' ) ) {
			wp_enqueue_style( get_stylesheet(), get_stylesheet_directory_uri() . '/assets/css/custom.css', array( 'cb-default-css' ), $version );
		}*/

	}


	private function register_wc_styles() {

		$styles = $this->get_wc_styles();

		foreach ( $styles as $handle => $style ) {
			wp_register_style( $handle, $style['src'], $style['deps'], $style['version'], $style['media'] );
		}
	}

	private function enable_wc_styles() {

		$styles = $this->get_wc_styles();
		$handles = array_keys( $styles );

		foreach ( $handles as $handle ) {
			wp_enqueue_style( $handle );
		}
	}


	private function get_wc_styles() {

		$version = cb_get_version();

		$styles = apply_filters( 'cb_wc_enqueue_styles', array(
			'cb-wc-layout' => array(
				'src'     => $this->url . '/assets/css/woocommerce/woocommerce-layout.css',
				'deps'    => '',
				'version' => $version,
				'media'   => 'all'
			),
			'cb-wc-smallscreen' => array(
				'src'     => $this->url . '/assets/css/woocommerce/woocommerce-smallscreen.css',
				'deps'    => 'cb-wc-layout',
				'version' => $version,
				'media'   => 'only screen and (max-width: ' . apply_filters( 'cb_style_smallscreen_breakpoint', $breakpoint = '768px' ) . ')'
			),
			'cb-wc-general' => array(
				'src'     => $this->url . '/assets/css/woocommerce/woocommerce.css',
				'deps'    => '',
				'version' => $version,
				'media'   => 'all'
			),
		) );

		return $styles;
	}
	/**
	 *
	 * Generate css for customized features
	 *
	 */
	public function generate_css() {
		require_once $this->path . '/assets/cb-css.php';
	}

	public function generate_editor_css() {
		$nonce = isset( $_REQUEST['_wpnonce'] ) ? $_REQUEST['_wpnonce'] : '';

		if ( ! wp_verify_nonce( $nonce, 'cb_generate_editor_css' ) ) {
			die();
		}

		require_once $this->path . '/assets/cb-editor-css.php';
	}

	/**
	 * Dynamically set $content_width for the embeds depending on the current layout
	 *
	 * @global float $content_width
	 */
	public function set_content_width() {

		if ( is_attachment() || ! cb_has_sidebar_enabled() ) {
			global $content_width;
			$content_width = 1250;
		}
	}

	/**
	 * Some of our layout blocks are generated dynamically, it reorganizes these block
	 */
	public function setup_layout() {

		require_once $this->path . '/lib/framework/layout-builder/cb-site-header-generator.php';
		require_once $this->path . '/lib/framework/layout-builder/cb-page-builder.php';

		do_action( 'cb_setup_layout' );
	}

	/**
	 * add Body Class
	 *
	 * @param string $classes
	 *
	 * @return string
	 */
	public function add_body_classes( $classes ) {

		// is mobile
		if ( wp_is_mobile() ) {
			$classes[] = 'is-mobile';
		}

		if ( ! is_user_logged_in() ) {
			$classes[] = 'not-logged-in';
		}
		if ( cb_get_option( 'featured-image-fit-container' ) ) {
		    $classes[] = 'featured-image-fit-container';
        }

		//append header layout class
		$classes[] = cb_get_option( 'header-layout' );

		//get_background_image
		return $classes;

	}

	/**
	 * Get image sizes
	 *
	 * A multidimensional array, child theme can filter it
	 *
	 * @return array
	 */
	private function get_image_sizes() {

		$sizes = array(
			//main post thumbnail size
			'thumbnail' => array(
				'width'  => 525,
				'height' => 180,
				'crop'   => true,//set false for resize
			),

			'featured-mid' => array(
				'width'  => 782,
				'height' => 180,
				'crop'   => true,//set false for resize
			),

			'featured-large' => array(
				'width'  => 1220,//single col pages
				'height' => 180,
				'crop'   => true,//set false for resize
			),

			/*'tab-thumb' => array(
				'width'  => 50,
				'height' => 50,
				'crop'   => true,//set false for resize
			),

			'thumbnail-mid' => array(
				'width'  => 360,
				'height' => 180,
				'crop'   => true,//set false for resize
			),*/
		);

		return apply_filters( 'cb_image_sizes', $sizes );
	}
}

//initialize
CB_Core_Loader::get_instance();
