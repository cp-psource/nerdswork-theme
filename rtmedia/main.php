<?php
//Thanks for the bad code, RT Media

global $rt_ajax_request;
$rt_ajax_request = false;

// check if it is an ajax request

$_rt_ajax_request = rtm_get_server_var( 'HTTP_X_REQUESTED_WITH', 'FILTER_SANITIZE_STRING' );
if ( 'xmlhttprequest' === strtolower( $_rt_ajax_request ) ) {
	$rt_ajax_request = true;
}

if ( $rt_ajax_request ) {
	rtmedia_load_template();
}
