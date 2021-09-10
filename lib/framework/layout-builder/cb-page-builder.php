<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

//for Site Header
$selected_header_layout = cb_get_option( 'header-layout' );

switch( $selected_header_layout ) {
	
		
	case 'header-layout-2':
		$callback = 'cb_header_layout_2';
		break;
	
	case 'header-layout-3':
		$callback = 'cb_header_layout_3';
		break;
	
	case 'header-layout-4':
		$callback = 'cb_header_layout_4';
		break;
	
	case 'header-layout-5':
		$callback = 'cb_header_layout_5';
		break;
	
	case 'header-layout-6':
		$callback = 'cb_header_layout_6';
		break;
	
	case 'header-layout-7':
		$callback = 'cb_header_layout_7';
		break;
	

	case 'header-layout-8':
		$callback = 'cb_header_layout_8';
		break;
	
	case 'header-layout-9':
		$callback = 'cb_header_layout_9';
		break;

	case 'header-layout-10':
		$callback = 'cb_header_layout_10';
		break;
	
	case 'header-layout-default':
	default:
		$callback = 'cb_header_layout_default';
		break;
	
}
//Main Theme Header
$header_callback = apply_filters( 'cb_header_render_callback', $callback );
//should we check for is callable?
if ( is_callable( $header_callback ) ) {
	call_user_func( $header_callback );
} else {
	//should we notify???
	//no, If it is not callable, someone did it intentionally
}

//Page Headers?
add_action( 'cb_before_container', 'cb_load_page_header' );
//Load the template notice template_notices just inside container

add_action( 'cb_before_container_contents', 'cb_load_site_feedback_message' );
add_action( 'cb_before_container', 'cb_load_breadcrumbs' );
//Breadcrumb?
//We don't play with what is inside the container, let the template files handle it
//This builder only deals with layout, so we are concentrating on that part only
//inject social links to footer

add_action( 'cb_after_theme_credits', 'cb_footer_social_links' );
