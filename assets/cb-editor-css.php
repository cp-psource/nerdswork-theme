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
 */

//	Layout

// We don't need to worry about page layout as adding css class will take care of them
//	see the filter applied on body_class for details



$content_width = cb_get_option( 'content-width' );
$has_sidebars = cb_has_sidebar_enabled();
if(  $has_sidebars ) {
	$content_width = (1250 * $content_width)/100;
} else {
	$content_width = 1250;
}

//we do not allow float value here, only integers allowed
$content_width = absint( $content_width );
//main column
$builder->add( array(
	'selectors'		=> array( 'body' ),
	'declarations'	=> array(
		'width'	=> $content_width . 'px',
	),
	'media'=> 'screen and (min-width: 992px)'
) );

//--------------------------------------------------------------------
//2. Typography
//--------------------------------------------------------------------

//Base font size, family, line height etc
cb_css_add_font_style( $builder, 'base', 'body', false);

//Headers h1-h6 typography
for ( $i = 1; $i <= 6; $i++ ) {

	$element = 'h' . $i;//h1-h6
	cb_css_add_font_style( $builder,  $element, $element,false );
}

$rules = array();


$list = array();

$primary_text_color = cb_get_option( 'text-color' );
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
$default_link_color = cb_get_option( 'link-color' );

if ( $default_link_color ) {
	$builder->add( array(
		'selectors'		=> array('a'),
		'declarations'	=> array( 'color' => $default_link_color )
	) );
}

$default_link_hover_color = cb_get_option( 'link-hover-color' );

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

cb_css_add_button_style( $builder, 'button', $btn_selector, $btn_hover_selector, false );


cb_css_add_common_style( $builder, 'main', '#container' , false );


//Display css
do_action( 'cb_css' );
// Echo the rules
$css = cb_get_css_builder()->build();
header( 'Content-type: text/css' );
echo $css;
exit(0);