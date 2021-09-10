<?php
/**
 * @package social-portal
 */
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}
/**
 * Layout related functions
 *
 */

/**
 * Get all available Theme layouts
 * 
 * @return array
 */
function cb_get_layouts() {
	
	$url = combuilder()->get_url() . '/lib/framework/customizer/assets/images/layouts/';
	
	$layouts = array(
		'layout-single-col' => array(
			'url'	=> $url . '1col.png',
			'label'	=> _x( 'Einzelne Spalte', 'Layout name in metabox', 'social-portal' ),
		),
		'layout-two-col-right-sidebar' => array(
			'url'	=> $url . '2cr.png',
			'label'	=> _x( 'Zweispaltig rechte Seitenleiste', 'Layout name in metabox', 'social-portal' ),
		),
		'layout-two-col-left-sidebar' => array(
			'url'	=> $url . '2cl.png',
			'label'	=> _x( 'Zweispaltig linke Seitenleiste', 'Layout name in metabox', 'social-portal' ),
		),

	);
	
	return $layouts;
}
/**
 * Get Possible layouts for page
 * Used in Page_Layout_Control
 * 
 * @return array
 */
function cb_get_page_layouts() {
	
	$url = combuilder()->get_url() . '/lib/framework/customizer/assets/images/layouts/';
	
	$layouts = array(
		'default' => array(
			'url'	=> $url . 'default.png',
			'label'	=> _x( 'Standard', 'Page layout name', 'social-portal' ),
		),
		'page-single-col' => array(
			'url'	=> $url . '1col.png',
			'label'	=> _x( 'Einzelne Spalte', 'Page layout name', 'social-portal' ),
		),
		'page-two-col-right-sidebar' => array(
			'url'	=> $url . '2cr.png',
			'label'	=> _x( 'Zweispaltig rechte Seitenleiste', 'Page layout name', 'social-portal' ),
		),
		'page-two-col-left-sidebar' => array(
			'url'	=> $url . '2cl.png',
			'label'	=> _x( 'Zweispaltig linke Seitenleiste', 'Page layout name', 'social-portal' ),
		),
	);
	
	return $layouts;
}
/**
 * Get the theme layout css class
 * 
 * @return string layout css class
 */
function  cb_get_theme_layout_class() {
	return cb_get_option( 'theme-layout', 'layout-two-col-right-sidebar' );
}

/**
 * Should we load the sidebar or not?
 * 
 * @return boolean 
 */
function cb_has_sidebar_enabled() {
	static $is_enabled; //we will short circuit the decision making when repeatedly called, to avoid extra computation

	if ( ! isset( $is_enabled ) ) {
		$is_enabled = true; //assume it to be visible by default
		$page_layout = cb_get_page_layout_class();
		$theme_layout = cb_get_theme_layout_class();

		//if page layout is set to single col, we should not load sidebar
		if ( $page_layout == 'page-single-col' ) {
			$is_enabled = false;
		} elseif ( $theme_layout == 'layout-single-col' && ( ! $page_layout || $page_layout == 'page-layout-default' ) ) {
			//if theme layout is single col and $page_layout is not set(using default)
			$is_enabled = false;
		}
	}

	return apply_filters( 'cb_has_sidebar_enabled', $is_enabled );
}

/**
 * Does current page have header enabled?
 *
 * @return boolean
 */
function cb_has_header_enabled() {
	$disabled = false;

	if ( is_singular() ) {
		$disabled = get_post_meta( get_queried_object_id(), '_cb_hide_header', true );
	}

	return apply_filters( 'cb_has_header_enabled',  ! $disabled );
}

/**
 * Does current page have footer enabled?
 *
 * @return boolean
 */
function cb_has_footer_enabled() {
	$disabled = false;

	if ( is_singular() ) {
		$disabled = get_post_meta( get_queried_object_id(), '_cb_hide_footer', true );
	}

	return apply_filters( 'cb_has_footer_enabled',  ! $disabled );
}
/**
 * Does current page have footer copyright enabled?
 *
 * @return boolean
 */
function cb_has_footer_copyright_enabled() {
	$disabled = false;

	if ( is_singular() ) {
		$disabled = get_post_meta( get_queried_object_id(), '_cb_hide_footer_copyright', true );
	}

	return apply_filters( 'cb_has_footer_copyright_enabled',  ! $disabled );
}

/**
 * Is left panel visible, Should we load it?
 *
 * @return bool
 */
function cb_has_panel_left_enabled() {

	$visibility = cb_get_panel_visibility( 'left' );
	$show = $visibility != 'never';
	return  apply_filters( 'cb_has_panel_left_enabled', $show, $visibility );
}

/**
 * Is right panel visible, should we load it?
 *
 * @return bool
 */
function cb_has_panel_right_enabled() {
	$visibility = cb_get_panel_visibility( 'right' );
	$show = $visibility != 'never';

	return  apply_filters( 'cb_has_panel_right_enabled', $show, $visibility );
}

/**
 * Get panel visibility
 *
 * @param string $panel panel name 'left'|'right'
 *
 * @return mixed|string
 */
function cb_get_panel_visibility( $panel ) {
	$visibility = '';
	$user_scope = '';

	// _cb_panel_left_visibility
	// _cb_panel_right_visibility.
	$visibility_key = "_cb_panel_{$panel}_visibility";

	//_cb_panel_left_user_scope
	//_cb_panel_right_user_scope
	$user_scope_key = "_cb_panel_{$panel}_user_scope";

	// IDE Help,
	// panel-left-user-scope
	// panel-right-user-scope
	$user_scope_option_name = "panel-{$panel}-user-scope";
	// panel-right-visibility
	// panel-left-visibility.
	$visibility_option_name = "panel-{$panel}-visibility";
	if ( is_singular() ) {
		$visibility = get_post_meta( get_queried_object_id(), $visibility_key, true );
		$user_scope = get_post_meta( get_queried_object_id(), $user_scope_key, true );
	}

	//If visibility is not specified use, default
	if ( ! $visibility ) {
		$visibility = cb_get_option( $visibility_option_name );
	}

	if ( ! $user_scope ) {
		$user_scope = cb_get_option( $user_scope_option_name );
	}

	// If the User scope is 'logged-in' & User is not logged in,
	// or the scope is 'logged-out' and user is logged in, reset visibility to none
	if ( ( $user_scope == 'logged-in' && ! is_user_logged_in() )  || ( $user_scope == 'logged-out' && is_user_logged_in() ) ) {
		// reset panel visibility
		$visibility = 'never'; // never show it
	}

	return apply_filters( 'cb_panel_visibility', $visibility, $user_scope, $panel );
}
/**
 * Get the meta key used for page layout
 * @return string
 */
function cb_get_page_layout_meta_key() {
	return '_cb_page_layout_type';
}

/**
 * Get Registered page layout css classes.
 * We will use it to generate class for the content div
 * 
 * @return array( layoutname=>cssclass name)
 */
function cb_get_registered_page_layout_classes() {

	return array(
		0								=> '', //default
		'page-single-col'				=> 'page-single-col', //single column page
		'page-two-col-right-sidebar'	=> 'page-two-col-right-sidebar',
		'page-two-col-left-sidebar'		=> 'page-two-col-left-sidebar'//left sidebar
	);
}

/**
 * Get the layout for single pages, It overrides the template layout
 * @param string $classes list of css classes
 * @return string list of classes
 */
function cb_get_page_layout_class( $classes = '' ) {

	$layout = '';
	//the order if ifs are based on most probable estimation of what users will be viewing
	//
	//for single post/page/post_type
	if ( cb_is_bp_active() && is_buddypress() ) {

		if ( bp_is_user() ) {//user profile layout
			$layout = cb_get_option( 'bp-member-profile-layout' );
		} elseif ( bp_is_group_create() ) {
			$layout = cb_get_option( 'bp-create-group-layout' );//is it group create?
		} elseif ( bp_is_group () ) {
			$layout = cb_get_option( 'bp-single-group-layout' );
		} elseif ( bp_is_activity_directory() ) {
			$layout = cb_get_activity_dir_page_layout();
		} elseif ( bp_is_members_directory() ) {
			$layout = cb_get_members_dir_page_layout();
		} elseif ( bp_is_groups_directory() ) {
			$layout = cb_get_groups_dir_page_layout();
		} elseif ( bp_is_register_page() ) {
			$layout = cb_get_signup_page_layout();
		} elseif ( bp_is_activation_page() ) {
			$layout = cb_get_activation_page_layout();
		} elseif ( bp_is_create_blog() ) {
			$layout = cb_get_option( 'bp-create-blog-layout' );;
		} elseif ( bp_is_blogs_directory() ) {
			$layout = cb_get_blogs_dir_page_layout();
		} elseif ( is_singular() ) {
			$layout = _cb_get_singular_layout();
		}

	} elseif ( cb_is_wc_active() && is_woocommerce() ) {
		$wc_layout = cb_get_option('wc-page-layout' );
		//shop
		if ( is_shop() ) {
			$layout = _cb_get_singular_layout( wc_get_page_id('shop' ) );
		} elseif ( is_product_taxonomy() ) {
			$layout = cb_get_option( 'product-category-page-layout' );//_cb_get_singular_layout( $page_id );
		} elseif ( is_product() ){
			$layout = _cb_get_singular_layout();
			//Single product page has a fallback layout
			if ( empty( $layout ) || $layout == 'default' ) {
				$layout = cb_get_option('product-page-layout');
			}
		} else {//all other wc pages like cart, my account, checkout, single product etc
			$layout = _cb_get_singular_layout();
		}
		//If any of the layout is set to default, they inherit the woocommerce global layout.
		if ( empty( $layout ) || $layout == 'default' ) {
			$layout = $wc_layout;
		}

	} elseif ( is_front_page() ) {
		$layout = cb_get_option( 'home-layout' );

		/*
		 * if ( get_option( 'show_on_front') == 'page' ) {
            $layout = _cb_get_singular_layout( get_option( 'page_on_front' ) );
        }*/

	} elseif ( is_singular() ) {
		$layout = _cb_get_singular_layout();
	} elseif ( is_archive() ) {
		$layout = cb_get_option( 'archive-layout' );
	} elseif ( is_search() ) {
		$layout = cb_get_option( 'search-layout' );
	} elseif ( is_404() ) {
		$layout = cb_get_option( '404-layout' );
	} 
	
	//reset default

	if ( $layout == 'default' || empty( $layout ) ) {
		$layout = 'page-layout-default';
	}

	//if ( $classes ) {
		$classes = $classes . ' ' . $layout;
	//}

	return apply_filters( 'cb_get_page_layout_class', $classes, $layout );
}
/**
 * Get layout for single post/post type page
 * @internal for internal use
 * @return string
 */
function _cb_get_singular_layout( $post_id = 0 ) {

	if ( ! $post_id ) {
		$post_id = get_queried_object_id();
	}

	$available_layouts = cb_get_registered_page_layout_classes();
	$key = cb_get_page_layout_meta_key();

	$layout_current = get_post_meta( $post_id, $key, true );

	if ( ! $layout_current ) {
		$layout_current = 0;//default
	}

	$layout = isset( $available_layouts[ $layout_current ] ) ? $available_layouts[ $layout_current ] : '';

	return $layout;
}

/**
 * Is the Page header enabled for current page
 * 
 * @return boolean
 */
function cb_is_singular_page_header_enabled() {
	$enabled = true;//by default , assume enabled
    $post_id = get_queried_object_id();

    //IS IT DISABLED FOR THIS POST?
    if ( get_post_meta( $post_id, '_cb_header_disabled', true ) || cb_is_using_page_builder( $post_id ) ) {
        $enabled = false;
    } elseif ( is_page() ) {
		
        if ( ! cb_get_option( 'page-show-header' )
            || is_page_template( 'templates/page-blank.php' )
            || is_page_template( 'templates/page-builder.php' )
	        || is_page_template( 'elementor_header_footer')
	        || is_page_template( 'elementor_canvas')
        ) {
            $enabled = false;
        }

    } elseif ( ! cb_is_post_type_page_header_enabled( get_post_type() ) ) {
        $enabled = false;
    }

    //Let users filter it and mass disable
   return  apply_filters( 'cb_is_singular_post_type_page_header_enabled', $enabled, get_queried_object() );
}

/**
 * Is page header enabled for the post type
 * @param $post_type
 *
 * @return mixed
 */
function cb_is_post_type_page_header_enabled( $post_type ) {
	return cb_get_option( $post_type . '-show-header' , cb_get_default( 'post-show-header' ) );
}
/**
 * Is the Page header block enabled for the archive page
 *
 * @return bool
 */
function cb_is_archive_page_header_enabled() {
	//assume to be disabled by default
	$enabled = false;

	if ( is_archive() && cb_get_option( 'archive-show-header' ) ) {
		$enabled = true;
	}

	return apply_filters( 'cb_is_archive_page_header_enabled', $enabled );
}

/**
 * Is Page Header enable for the current WooCommerce page?
 *
 * @return boolean
 */
function cb_is_wc_page_header_enabled() {
	//assume to be disabled by default
	$enabled = true;// by default assume enabled
	$enabled_default = cb_get_option( 'wc-show-header' );
	$is_product = false;

	if ( is_shop() ) {
		$enabled = get_post_meta( wc_get_page_id('shop' ), '_cb_header_disabled', true ) ? false : true;
	} elseif( is_product() ) {
		$is_product = true;
		$enabled = get_post_meta( get_queried_object_id(), '_cb_header_disabled', true ) ? false : true;
		if ( $enabled ) {
			//use post type preference
			$enabled = cb_get_option('product-show-header' ) ? true : false;
		}
	} elseif( is_product_taxonomy() ) {
		$enabled =  cb_get_option('product-category-show-header' ) ? true : false;

	}

	if ( $enabled && ! $is_product ) {
		$enabled = $enabled_default;
	}

	return apply_filters( 'cb_is_wc_page_header_enabled', $enabled );
}

/**
 * Get BuddyPress Members directory page Layout
 *
 * @return string
 */
function cb_get_members_dir_page_layout() {

	$layout = '';

	if ( is_customize_preview() ) {
		$layout = get_theme_mod( 'bp-members-directory-layout' );
	} elseif ( cb_is_bp_active() && bp_members_has_directory() ) {
		$layout = _cb_get_singular_layout( buddypress()->pages->members->id );
	}

	if ( empty( $layout ) ) {
		$layout = 'default';
	}

	return $layout;
}

/**
 * Get the groups directory page layout
 *
 * @return string
 */
function cb_get_groups_dir_page_layout() {

	$layout = '';

	if ( is_customize_preview() ) {
		$layout = get_theme_mod( 'bp-groups-directory-layout' );
	} elseif ( function_exists( 'bp_groups_has_directory' ) && bp_groups_has_directory() ) {
		$layout = _cb_get_singular_layout( buddypress()->pages->groups->id );
	}
	
	if ( empty( $layout ) ) {
		$layout = 'default';
	}

	return $layout;
}

/**
 * Get the blogs directory page layout
 *
 * @return string
 */
function cb_get_blogs_dir_page_layout() {
	$layout = '';
	if ( is_customize_preview() ) {
		$layout = get_theme_mod( 'bp-blogs-directory-layout' );
	} elseif ( function_exists( 'bp_blogs_has_directory' ) && bp_blogs_has_directory() ) {
		$layout = _cb_get_singular_layout( buddypress()->pages->blogs->id );
	}
	
	if ( empty( $layout ) ) {
		$layout = 'default';
	}

	return $layout;
}

function cb_get_activity_dir_page_layout() {

	$layout = '';
	if ( is_customize_preview() ) {
		$layout = get_theme_mod( 'bp-activity-directory-layout' );
	} elseif ( function_exists( 'bp_activity_has_directory' ) && bp_activity_has_directory() ) {
		$layout = _cb_get_singular_layout( buddypress()->pages->activity->id );
	}
	
	if ( empty( $layout ) ) {
		$layout = 'default';
	}

	return $layout;
}

/**
 * Get Signup page layout
 * @return string
 */
function cb_get_signup_page_layout() {

    $layout = '';
    if ( is_customize_preview() ) {
        $layout = get_theme_mod( 'bp-signup-page-layout' );
    } elseif ( function_exists( 'bp_has_custom_signup_page' ) && bp_has_custom_signup_page() ) {
        $layout = _cb_get_singular_layout( buddypress()->pages->register->id );
    }

    if ( empty( $layout ) ) {
        $layout = 'default';
    }

    return $layout;
}

/**
 * Get BuddyPress Activation page template
 *
 * @return string
 */
function cb_get_activation_page_layout() {

    $layout = '';
    if ( is_customize_preview() ) {
        $layout = get_theme_mod( 'bp-activation-page-layout' );
    } elseif ( function_exists( 'bp_has_custom_activation_page' ) && bp_has_custom_activation_page() ) {
        $layout = _cb_get_singular_layout( buddypress()->pages->activate->id );
    }

    if ( empty( $layout ) ) {
        $layout = 'default';
    }

    return $layout;
}

/**
 * Get the Page template for the given post
 *
 * @param null $post_id
 * @return bool|mixed|string
 */
function cb_get_page_template_slug( $post_id = null ) {
    $post = get_post( $post_id );
    if ( ! $post ) {
        return false;
    }

    $template = get_post_meta( $post->ID, '_wp_page_template', true );

    if ( ! $template || 'default' == $template ) {
        return '';
    }

    return $template;
}

/**
 * Check which header rows are enabled
 * //There are three sections, top, main, bottom
 * @param string $section_name
 *
 * @return bool
 */
function cb_is_header_section_enabled( $section_name = 'main' ) {
			
	if ( $section_name == 'main' ) {
		return true;
	}
	
	$current_layout = get_theme_mod( 'header-layout', cb_get_default( 'header-layout' ) );
	//headers having top row
	$top = array( 'header-layout-2', 'header-layout-3', 'header-layout-4', 'header-layout-7', 'header-layout-8', 'header-layout-9', 'header-layout-10' );
	//headers having bottom row
	$bottom = array( 'header-layout-5', 'header-layout-6', 'header-layout-7', 'header-layout-8', 'header-layout-9', 'header-layout-10');
	
	if ( $section_name == 'top' && in_array( $current_layout, $top ) ) {
		return true;
	} elseif ( $section_name == 'bottom' && in_array( $current_layout, $bottom ) ) {
		return true;
	}
	
	return false;
}

/**
 * Is header bottom row active/enabled?
 *
 * @return bool
 */
function cb_is_header_bottom_row_enabled() {
	return cb_is_header_section_enabled( 'bottom' );
}

/**
 * Is the header top row active?
 *
 * @return bool
 */
function cb_is_header_top_row_enabled() {
	return cb_is_header_section_enabled( 'top' );
}

function cb_is_header_account_menu_visible() {
	return cb_get_option( 'header-show-account-menu' );
}

/**
 * Does current header supports search layout?
 */
function cb_is_header_search_available() {
	$layouts = array(
		'header-layout-3',
		'header-layout-4',
		'header-layout-5',
		'header-layout-6',
		'header-layout-7',
		'header-layout-8',
		'header-layout-9',
		'header-layout-10',
		);//these layout support
	$current_layout = get_theme_mod( 'header-layout', cb_get_default( 'header-layout' ) );

	if ( in_array( $current_layout, $layouts ) ) {
		return true;
	}

	return false;
}

/**
 * Is the search box visible in header?
 */
function cb_is_header_search_visible () {
	return cb_is_header_search_available() && cb_get_option( 'header-show-search' , 1 );
}
function cb_is_sites_menu_available() {
	if ( is_multisite() && cb_is_header_account_menu_visible () ) {
		return true;
	}
	return false;
}

function cb_is_sites_menu_visible() {
	$cap = cb_get_option( 'sites-link-capability' );
	return cb_is_sites_menu_available() && $cap && current_user_can( $cap );
}
/**
 * Whether to show the page header or not?
 *
 * @return boolean true to show false to hide
 */
function cb_show_page_header() {

	$show = true;
	if ( cb_is_wc_active() && ! cb_is_wc_page_header_enabled() ) {
		$show = false;
	} elseif ( is_singular() && ! cb_is_singular_page_header_enabled() ) {
		// check for single post type screen(singe post, page, custom post type etc
		$show = false;
	} elseif ( is_archive() && ! cb_is_archive_page_header_enabled() ) {
		$show = false;
	} elseif ( is_front_page() || ( cb_is_bp_active() && is_buddypress() && ( bp_is_single_item() || bp_is_user() ) ) ) {
		$show = false;
	}

	return apply_filters( 'cb_show_page_header', $show );
}
