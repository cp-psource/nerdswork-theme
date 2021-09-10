<?php
/**
 * Generate the css for customized fatures
 * It is loaded by , all the variables are local to that function only
 * 
 */
/**
 * Get the singleton instance of layout builder
 */
$builder = cb_get_css_builder();
/**
 * 1. General
 * 
 * 2. Layout
 * 
 * 3. Typography
 * 
 * 4. Color
 * 5. BG
 * 
 * 6. Widget & sidebar
 */

//	Layout

// We don't need to worry about page layout as adding css class will take care of them
//	see the filter applied on body_class for details

//Site Theme Layout
$theme_style = cb_get_modified_value( 'layout-style' );

//We only add custom css for fluid layout, the fixed layout is handled by default
if ( $theme_style == 'fluid' ) {
	
	$builder->add( array(
		'selectors'		=> array( '.inner '),
		'declarations'	=> array(
			'max-width' => cb_get_default( 'theme-fluid-width' ), //in case of fluid width, we use 90% of the screen width
		),
		'media'=> 'screen and (min-width: 992px)',
	) );
}
//Layout width
$content_width = cb_get_modified_value( 'content-width' );
$has_sidebars = cb_has_sidebar_enabled();

if ( ! empty( $content_width ) && $has_sidebars ) {
	//we do not allow float value here, only integers allowed
	$content_width = absint( $content_width );
	//main column
	$builder->add( array(
		'selectors'		=> array( '#content' ),
		'declarations'	=> array(
			'width'	=> $content_width . '%',
		),
		'media'=> 'screen and (min-width: 992px)'
	) );
	//sidebar
	$builder->add( array(
		'selectors'		=> array( '#sidebar' ),
		'declarations'	=> array(
			'width'	=> ( 100 - $content_width ) . '%',
		),
		'media'=> 'screen and (min-width: 992px)'
	) );
}
//is left panel enabled all time?
$left_panel_enable =  cb_get_panel_visibility( 'left' );

if (  $left_panel_enable != 'always' ) {
	$media = null;
	if ( $left_panel_enable == 'mobile' ) {
		$media = 'screen and (min-width: 992px)';
	}

	$builder->add( array(
		'selectors'		=> array( '#panel-left-toggle' ),
		'declarations'	=> array(
			'display'	=> 'none',
		),
		'media'         => $media
	) );
	//
}
//right panel
$right_panel_enable = cb_get_panel_visibility( 'right' );
if ( $right_panel_enable != 'always' ) {
	$media = null;
	if ( $right_panel_enable == 'mobile' ) {
		$media = 'screen and (min-width: 992px)';
	}

	$builder->add( array(
		'selectors'		=> array( '#panel-right-toggle' ),
		'declarations'	=> array(
			'display'	=> 'none',
		),
		'media'         => $media,
	) );
}

//--------------------------------------------------------------------
//2. Typography
//--------------------------------------------------------------------

//Base font size, family, line height etc
cb_css_add_font_style( $builder, 'base', 'body' );

//Headers h1-h6 typography
for ( $i = 1; $i <= 6; $i++ ) {
	
	$element = 'h' . $i;//h1-h6
	cb_css_add_font_style( $builder,  $element, $element );
}
//CSS for site title
cb_css_add_font_style( $builder,  'site-title', '.logo-text' );

//Main Menu
cb_css_add_font_style( $builder,  'main-nav', '#nav' );
cb_css_add_font_style( $builder,  'sub-nav', '#nav li li' );

$main_nav_selected_color = cb_get_modified_value( 'main-nav-selected-item-color' );
$main_nav_selected_font_weight = cb_get_modified_value( 'main-nav-selected-item-font-weight' );

$rules = array();

if ( $main_nav_selected_color ) {
	$rules['color'] = $main_nav_selected_color;
}

if ( $main_nav_selected_font_weight ) {
	$rules['font-weight'] = $main_nav_selected_font_weight;
}

//current menu item hilight
if ( ! empty( $rules ) ) {
	
	$builder->add( array(
		'selectors'		=> array( '#nav .current-menu-item > a','#nav .current-menu-parent > a' ),
		'declarations'	=> $rules,
	) );
	unset( $rules );
}

//Page header fonts
cb_css_add_font_style( $builder,  'page-header-title',  '.page-header .page-header-title' );
cb_css_add_font_style( $builder,  'page-header-content',  '.page-header-meta' );
//page header mask
$page_header_mask_color = cb_get_modified_value( 'page-header-mask-color', '' );
if ( $page_header_mask_color ) {
	$builder->add( array(
		'selectors'    => array( '.page-header-mask-enabled .page-header-mask, .has-cover-image .page-header-mask, .bp-user .page-header-mask' ),
		'declarations' => array( 'background' => $page_header_mask_color ),
	) );
}
//page header text colors
$page_header_title_text_color = cb_get_modified_value( 'page-header-title-text-color', '' );
if ( $page_header_title_text_color ) {
	$builder->add( array(
		'selectors'    => array( '.page-header .page-header-title' ),
		'declarations' => array( 'color' => $page_header_title_text_color ),
	) );
}

$page_header_content_text_color = cb_get_modified_value( 'page-header-content-text-color' );
if ( $page_header_content_text_color ) {
	$builder->add( array(
		'selectors'		=> array( '.page-header-meta' ),
		'declarations'	=> array( 'color' => $page_header_content_text_color ),
	) );
}

//Sidebar
//cb_css_add_font_style( $builder,  'sidebar',  '#sidebar' );
//for sidebar widgets

cb_css_add_font_style( $builder,  'widget-title',  '.widgettitle' );
cb_css_add_font_style( $builder,  'widget',  '.widget' );

//footer
cb_css_add_font_style( $builder,  'footer',  '#footer' );

cb_css_add_font_style( $builder,  'footer-widget-title',  '#footer .widgettitle' );
cb_css_add_font_style( $builder,  'footer-widget',  '#footer .widget' );


//3.Styling

//Special cases, Site Background & Page header
//Generate css for custom background

//Site Page Header
if ( cb_show_page_header() )  {
    $header_image = cb_get_header_image();
	$bg_color = cb_get_modified_value( 'page-header-background-color' );

	$rules = array();

	if ( ! empty( $header_image ) ) {
		$rules['background-image'] = "url({$header_image})";

	}

	if ( ! empty( $bg_color ) ) {
		$rules['background-color'] = $bg_color;
	}

    if ( $rules ) {

        $builder->add( array(
            'selectors'		=> array( '.page-header' ),
            'declarations'	=> $rules,
        ) );
	//reset rules
	 unset( $rules );
    }
}
//header title text
//header desc text


//Site Background
$background_image = set_url_scheme( get_background_image() );
$list = array();

if ( $background_image ) {
	//we have a background image set

	$list['background-image'] = "url({$background_image})";

	$repeat = cb_get_modified_value( 'background_repeat');
	if ( $repeat ) {
		$list['background-repeat'] = $repeat;
	}

	$position = cb_get_modified_value( 'background_position_x');
	if ( $position ) {
		$list['background-position'] = $position ." center";
	
	}

	$attachment = cb_get_modified_value( 'background_attachment');
	if (  $attachment ) {
		$list['background-attachment'] = $attachment;
	
	}
}
$bg_color = cb_get_modified_value( 'background-color');
if (  $bg_color ) {
	$list['background-color'] = $bg_color ;
}

$primary_text_color = cb_get_modified_value( 'text-color' );
if ( $primary_text_color ) {
	$list['color'] = $primary_text_color;
}
if ( ! empty( $list )) {
	$builder->add( array(
		'selectors'		=> array("body"),
		'declarations'	=> $list
	) );
}
unset( $list );

//Basic
//Links color
$default_link_color = cb_get_modified_value( 'link-color' );

if ( $default_link_color ) {
	$builder->add( array(
		'selectors'		=> array('a'),
		'declarations'	=> array( 'color' => $default_link_color )
	) );
}

$default_link_hover_color = cb_get_modified_value( 'link-hover-color' );

if ( $default_link_hover_color ) {
	$builder->add( array(
		'selectors'		=> array('a:hover, a:focus'),
		'declarations'	=> array( 'color' => $default_link_hover_color )
	) );
}
//Buttons global
//buttons bg
 $btn_selector = '.button, input[type="submit"], .btn, .bp-login-widget-register-link a, button, .btn-secondary, .activity-item a.button, .ac-reply-content input[type="submit"], a.comment-reply-link, .sow-more-text a';
$btn_hover_selector = '.button:hover, input[type="submit"]:hover, .btn:hover, .bp-login-widget-register-link a:hover, button:hover, .btn-secondary:hover, .activity-item a.button:hover, a.comment-reply-link:hover, .sow-more-text a:hover, .button:focus, input[type="submit"]:focus, .btn:focus, .bp-login-widget-register-link a:focus, button:focus, .btn-secondary:focus, .activity-item a.button:focus, a.comment-reply-link:focus, .sow-more-text a:focus';

cb_css_add_button_style( $builder, 'button', $btn_selector, $btn_hover_selector );

//Logo
cb_css_add_link_style( $builder, 'site-title', '.logo-text a' );

cb_css_add_common_style( $builder, 'header', '#header'  );
cb_css_add_link_style( $builder,  'header', '#header a' );
cb_css_add_border_style( $builder, 'header', '#header' );
//Header panel toggles

$toggle_left_color = cb_get_modified_value( 'panel-left-toggle-color' );
if ( $toggle_left_color ) {
	$builder->add( array(
		'selectors'		=> array( '#panel-left-toggle'),
		'declarations'	=> array(
			'color' =>  $toggle_left_color,
		)
	) );
}

$toggle_right_color = cb_get_modified_value( 'panel-right-toggle-color' );
if ( $toggle_left_color ) {
	$builder->add( array(
		'selectors'		=> array( '#panel-right-toggle'),
		'declarations'	=> array(
			'color' =>  $toggle_right_color,
		)
	) );
}

//header buttons
cb_css_add_button_style( $builder, 'header-buttons', 'header-links a.btn', 'header-links a.btn:hover' );



//header top row
cb_css_add_common_style( $builder, 'header-top', '#header-top-row' );
//header top row link
cb_css_add_link_style( $builder, 'header-top', '#header-top-row a' );
cb_css_add_border_style( $builder, 'header-top', '#header-top-row' );
//header main row
cb_css_add_common_style( $builder, 'header-main', '#header-main-row' );
//header main row link
cb_css_add_link_style( $builder, 'header-main', '#header-main-row a' );
cb_css_add_border_style( $builder, 'header-main', '#header-main-row' );
//header bottom row
cb_css_add_common_style( $builder, 'header-bottom', '#header-bottom-row' );
cb_css_add_border_style( $builder, 'header-bottom', '#header-bottom-row' );
//header bottom row link
cb_css_add_link_style( $builder, 'header-bottom', '#header-bottom-row a' );

cb_css_add_common_style( $builder, 'main-nav', '#nav' );
cb_css_add_link_style( $builder, 'main-nav', '#nav li a' );
cb_css_add_background_hover_style( $builder, 'main-nav-link', '#nav > ul > li > a', '#nav > ul > li > a:hover' );
cb_css_add_border_style( $builder, 'main-nav-link', '#nav > ul > li > a' );
cb_css_add_border_style( $builder, 'main-nav-link-hover', '#nav > ul > li > a:hover' );

cb_css_add_common_style( $builder, 'sub-nav-link', '#nav li li' );
cb_css_add_background_hover_style( $builder, 'sub-nav-link', '#nav li li a', '#nav li li a:hover' );
cb_css_add_border_style( $builder, 'sub-nav-link', '#nav li li a' );
cb_css_add_border_style( $builder, 'sub-nav-link-hover', '#nav li li a:hover' );

cb_css_add_common_style( $builder, 'main', '#container' );
//cb_css_add_link_style( $builder, 'main', '#container a' );

cb_css_add_common_style( $builder, 'sidebar', '#sidebar' );
cb_css_add_link_style( $builder, 'sidebar', '#sidebar a' );

cb_css_add_common_style( $builder, 'widget-title', '.widgettitle' );
cb_css_add_link_style( $builder, 'widget-title', '.widgettitle a' );
cb_css_add_common_style( $builder, 'widget', '.widget' );
cb_css_add_link_style( $builder, 'widget', '.widget a' );

cb_css_add_common_style( $builder, 'footer', '#footer' );
cb_css_add_link_style( $builder, 'footer', '#footer a' );

cb_css_add_common_style( $builder, 'footer-top', '#footer-top' );
cb_css_add_link_style( $builder, 'footer-top', '#footer-top a' );

cb_css_add_common_style( $builder, 'site-copyright', '#site-copyright' );
cb_css_add_link_style( $builder, 'site-copyright', '#site-copyright a' );

//BuddyPress

cb_css_add_font_style( $builder, 'bp-single-item-title', 'div#item-header h2' );
cb_css_add_link_style( $builder, 'bp-single-item-title', 'div#item-header h2 a' );

//BP Action Cog toggle

cb_css_add_button_style( $builder, 'bp-dropdown-toggle', '.dropdown-toggle', '.dropdown-toggle:hover' );

//social icons
//header
$font_size = cb_get_modified_value( 'header-social-icon-font-size' );
//header social icon font size
if ( $font_size ) {
	
	$builder->add( array(
		'selectors'		=> array( '#header ul.social-links .fa'),
		'declarations'	=> array(
			'font-size' => $font_size . 'px',
		)
	) );
}
//Footer  Social Icons
$font_size = cb_get_modified_value( 'footer-social-icon-font-size' );

if ( $font_size ) {
	
	$builder->add( array(
		'selectors'		=> array( '#footer ul.social-links .fa'),
		'declarations'	=> array(
			'font-size' => $font_size . 'px',
		)
	) );
}

//Display css
cb_css_display_customizations();