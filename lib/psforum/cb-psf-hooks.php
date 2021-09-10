<?php
/**
 * is_PSForum inadvertantly returns true for all BuddyPress Profil pages
 * The code below fixes that behaviour
 *
 * @param $retval
 *
 * @return bool
 */
function cb_psf_fix_profile_page_availability( $retval ) {

	if ( function_exists( 'bp_is_user' ) && bp_is_user()&& ! bp_is_current_component( 'forums' ) ) {
		$retval = false;
	}

	return $retval;
}
add_filter( 'is_psforum', 'cb_psf_fix_profile_page_availability' );

add_filter( 'cb_breadcrumb_enabled', 'cb_bp_enable_breadcrumb' );
function cb_bp_enable_breadcrumb( $is_enabled ) {

	$is_bp_section = cb_is_bp_active() && bp_is_current_component( 'forums' );
	if ( is_psforum() && ! $is_bp_section ) {
		$is_enabled = 1;
	}

	return $is_enabled;
}
function cb_show_forum_details_in_header() {
	//single forum
	psf_single_forum_description();
	psf_forum_subscription_link();
	//single topic
	psf_single_topic_description();
	if ( psf_is_topic_tag() ) {
		psf_topic_tag_description();
	}

}

function cb_psf_breadcrumb_args_filter( $args ) {

	$args['sep'] = '<span class="sep psf-sep">/</span>';
	return $args;
}
add_filter( 'psf_after_get_breadcrumb_parse_args', 'cb_psf_breadcrumb_args_filter' );


function cb_psf_single_forum_description_args_filter( $args ) {

	$args['before'] = '<div class="psf-template-notice info psf-forum-info"><p class="psf-forum-description">';
	$args['after'] = '</p></div>';

	return $args;
}
add_filter( 'psf_after_get_single_forum_description_parse_args', 'cb_psf_single_forum_description_args_filter' );

function cb_psf_topic_voice_count() {
	$count = psf_get_topic_voice_count();

	$text = $count .'<span class="psf-voice-count-text psf-count-text"> ' . _n( 'voice', 'voices', $count,  'social-portal' ) .'</span>';
	echo $text;
}
function cb_psf_topic_reply_count() {
	$count = psf_get_topic_reply_count();

	$text = $count .'<span class="psf-count-text psf-reply-count-text"> ' . _n( 'reply', 'replies', $count,  'social-portal' ) .'</span>';
	echo $text;
}

function cb_psf_topic_post_count() {
	$count = psf_get_topic_post_count();

	$text = $count .'<span class="psf-count-text psf-post-count-text"> ' . _n( 'post', 'posts', $count,  'social-portal' ) .'</span>';
	echo $text;
}

function cb_psf_forum_topic_count() {
	$count = psf_get_forum_topic_count();

	$text = $count .'<span class="psf-count-text psf-forum-topic-count-text"> ' . _n( 'topic', 'topics', $count,  'social-portal' ) .'</span>';
	echo $text;
}

function cb_psf_forum_post_count() {
	$count = psf_get_forum_post_count();

	$text = $count .'<span class="psf-count-text psf-post-count-text"> ' . _n( 'post', 'posts', $count,  'social-portal' ) .'</span>';
	echo $text;
}

function cb_psf_forum_reply_count() {
	$count = psf_get_forum_reply_count();
	$text = $count .'<span class="psf-count-text psf-forum-reply-count-text"> ' . _n( 'reply', 'replies', $count,  'social-portal' ) .'</span>';
	echo $text;
}
