<?php
/**
 * @package social-portal
 */
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit( 0 );
}

/***
 * General hooks for controlling behaviour/display customizations in WordPress
 *
 */

/***
 * TOC
 *
 * 1. Hide Admin bar
 * 2. Show Home in Main Menu?
 * 3. Filter Single Page template to use custom page template
 * 4. Feed Redirection
 * 5. Maximus Accent Color
 * 6. Excerpt Length( 40 words default)
 * 7. Read More title filter
 * 8. Javascript Detection
 * 9. Sidebar Login Redirection setup
 * 10. Enable Shortcodes in text widget
 */
/**
 * Hide admin_bar if it is disabled in customizer
 */
if ( cb_get_option( 'hide-admin-bar' ) ) {
   // show_admin_bar( false );
	add_filter( 'show_admin_bar', '__return_false' );
}

/**
 * Get our wp_nav_menu() fallback, cb_main_nav(), to show a home link.
 *
 * @param array $args Default values for wp_page_menu()
 * @see wp_page_menu()
 * @return array
 */
function cb_show_home_in_menu( $args ) {

	if ( cb_get_option( 'show-home-in-menu' ) ) {
		$args['show_home'] = true;
	}

    return $args;
}

add_filter( 'wp_page_menu_args', 'cb_show_home_in_menu' );

//Filter Single Post Template and force it to use Our Press builder template
//we could also use template_include filter
/**
 * Filter Single page template for the posts and other post types
 *  We could have also used 'template_include' instead to filter
 *
 * @param $template
 * @return string
 */
function cb_filter_single_template( $template ) {

    $object = get_queried_object();

    $page_template = cb_get_page_template_slug( $object );

    if ( empty( $page_template ) ) {
        return $template;
    }

    $templates = array();

    if ( $page_template && 0 === validate_file( $page_template ) ) {
        $templates[] = $page_template;
    }

    if ( ! empty( $object->post_type ) ) {
        $templates[] = "single-{$object->post_type}-{$object->post_name}.php";
        $templates[] = "single-{$object->post_type}.php";
    }

    $templates[] = "single.php";

    $template = locate_template( $templates );
    return $template;
}

add_filter(  'single_template', 'cb_filter_single_template' );

/**
 * Redirect Feed to the given custom feed url
 */
function cb_feed_redirect() {
	
	if ( ! is_feed() ) {
		return ;
	}
	
	$feed_url = cb_get_option( 'custom-rss' );
	
	if ( empty( $feed_url ) ) {
		return ;
	}
	
	if ( is_feed() && ! preg_match('/feedburner|feedvalidator/i', $_SERVER['HTTP_USER_AGENT'] ) ) {
		wp_redirect( $feed_url, 302 );
		exit( 0 );
	}
	
}

add_action( 'template_redirect', 'cb_feed_redirect' );

/**
 * Filter the Accent color for the page Builder based on our current color selection
 * @param $color_hex
 * @return mixed
 * @todo update with current color scheme ascent color
 *
 */
function cb_filter_maximus_pb_accent_color( $color_hex ) {

    return $color_hex;
}

add_filter( 'maximus_builder_accent_color', 'cb_filter_maximus_pb_accent_color' );

/**
 * Set the post excerpt length to 40 words.
 *
 */
function cb_set_default_excerpt_length( $length ) {
	return 40;
}

add_filter( 'excerpt_length', 'cb_set_default_excerpt_length' );

/**
 * Return "Continue Reading" link for excerpts
 */
function cb_filter_continue_reading_label() {
	return '';
}

add_filter( 'excerpt_more', 'cb_filter_continue_reading_label' );

//add_filter( 'use_default_gallery_style', '__return_false' );

//it will remove 'no-js' class from html element and add 'js-enabled' class
function cb_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js-enabled')})(document.documentElement);</script>\n";
}

add_action( 'wp_head', 'cb_javascript_detection', 0 );

/**
 * Where to redirect on login
 */
function cb_sidebar_login_redirect_to() {
	$redirect_to = ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
	$redirect_to = apply_filters( 'bp_no_access_redirect', $redirect_to );
	?>
	<input type="hidden" name="redirect_to" value="<?php echo esc_url( $redirect_to ); ?>" />
	<?php
}

add_action( 'bp_sidebar_login_form', 'cb_sidebar_login_redirect_to' );


if ( cb_get_option( 'enable-text-widget-shortcode' ) ) {
	add_filter( 'widget_text', 'do_shortcode' );
}
