<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Add a div that will be used to mask the login page background image, colors
 */
function cb_login_add_mask_div() {
	echo "<div id='login-page-mask'></div>";
}
add_action( 'login_header',  'cb_login_add_mask_div' );

/**
 * WMS N@W Theme WordPress Login page Customization
 */

/**
 * Filter the login header link ( Logo link )
 *
 * @return string
 */
function cb_filter_login_headerurl( $url ) {
	return get_home_url();
}
add_filter( 'login_headerurl', 'cb_filter_login_headerurl' );

/**
 * Filter the title attribute of the logo link
 *
 * @param $title
 *
 * @return string
 */
function cb_filter_login_headertitle( $title ) {
	return get_bloginfo( 'name' ) . ' | ' . get_bloginfo( 'description' );
}
add_filter( 'login_headertitle', 'cb_filter_login_headertitle' );

/**
 * Load default Login customization css file from community Builder
 * It is used to reset various elements css
 */
function cb_load_login_style() {
	wp_enqueue_style( 'cb-login-style', combuilder()->get_url() . '/assets/css/login.css' );
}
add_action( 'login_enqueue_scripts', 'cb_load_login_style' );

/**
 * Finally, Inject the customized css generated from the customizer screen
 */
function cb_generate_login_style_css() {

	$builder = cb_get_css_builder();

	//page font style
	cb_css_add_font_style( $builder, 'login', 'body.login', false );

	//Page background/text
	cb_css_add_common_style( $builder, 'login', 'body.login', false );

	//for label, Use body text color
	$text_color = cb_get_option( 'login-text-color' );

	$builder->add( array(
		'selectors'		=> array( '#login label' ),
		'declarations'	=> array(
			'color'	=> $text_color
		)
	) );

	$builder->add( array(
		'selectors'		=> array( '.login .message, .login #login_error' ),
		'declarations'	=> array(
			'color'	=> '#333', //until we provide the option to customize the background/color of notice
		)
	) );

	$mask_color = cb_get_option( 'login-page-mask-color' );

	$builder->add( array(
		'selectors'		=> array( '#login-page-mask' ),
		'declarations'	=> array(
			'background'	=> $mask_color
		)
	) );

	//Link Color
	//.login #nav a,
	//.login #backtoblog a
	cb_css_add_link_style( $builder, 'login', '.login #nav a, .login #backtoblog a, div#login p a', '.login #nav a:hover, .login #backtoblog a:hover, div#login p a:hover' , false );

	//Login Box background
	$builder->add( array(
		'selectors'		=> array( '#login' ),
		'declarations'	=> array(
			'background-color'	=> cb_get_option( 'login-box-background-color' )
		)
	) );

	//Login Box border
	cb_css_add_border_style( $builder, 'login-box', '#login', false );

	//Site Name:-
	cb_css_add_font_style( $builder, 'login-logo', '.login h1 a',  false );
	//site name link
	cb_css_add_link_style( $builder, 'login-logo', '.login h1 a', '.login h1 a:hover', false );

	$logo = get_theme_mod( 'login-logo' );
	//logo
	if ( ! empty( $logo ) ) {
		$rules = array(
			'background-image' =>"url({$logo})",
			'background-size'	=> 'auto auto',
			'width'				=> '320px',
			'height'			=> 'auto',
			'text-indent'       => '-9999px',
		);

		$builder->add( array(
			'selectors'		=> array( '.login h1 a'),
			'declarations'	=> $rules
		) );
	}

	//Input text
	$builder->add( array(
		'selectors'     => array( '.login form .input, .login input[type="text"]' ),
		'declarations'  => array(
			'background-color'  => cb_get_option( 'login-input-background-color' ),
			'color'             => cb_get_option( 'login-input-text-color' )
		)
	) );

	//input border style
	cb_css_add_border_style( $builder, 'login-input', '.login form .input, .login input[type="text"]', false );

	//Input focus
	$focus_selectors = '.login form .input:focus, .login input[type="text"]:focus, .login form .input:active, .login input[type="text"]:active';
	$builder->add( array(
		'selectors'     => array( $focus_selectors ),
		'declarations'  => array(
			'background-color'  => cb_get_option( 'login-input-focus-background-color' ),
			'color'             => cb_get_option( 'login-input-focus-text-color' )
		)
	) );

	//focus border style
	cb_css_add_border_style( $builder, 'login-input-focus', $focus_selectors, false );

	//placeholder color
	$placeholder_color = cb_get_option( 'login-input-placeholder-color' );

	$placeholder_selectors = array( '*::-webkit-input-placeholder', '*:-moz-placeholder', '*::-moz-placeholder', '*:-ms-input-placeholder' );
	//Each placeholder selector needs to be a different rule
	foreach ( $placeholder_selectors as $placeholder_selector ) {
		$builder->add( array(
			'selectors'     => array( $placeholder_selector ),
		'declarations'  => array(
			'color'     => $placeholder_color,
			'font-size' => '14px'
		)
	) );
	}
	//Button colors
	cb_css_add_button_style( $builder, 'login-submit-button', '#wp-submit.button-primary', '#wp-submit.button-primary:focus, #wp-submit.button-primary:active, #wp-submit.button-primary:hover', false );

	// Print CSS
	$css = cb_get_css_builder()->build();
	
	if ( ! empty( $css ) ) {
		echo "\n<!-- Begin WMS N@W Theme Custom Login CSS -->\n<style type=\"text/css\" id=\"cb-theme-custom-css\">\n";
		echo $css;
		echo "\n</style>\n<!-- End WMS N@W Theme Custom CSS -->\n";
	}
}
add_action( 'login_head', 'cb_generate_login_style_css');

//Load google fonts if needed
function cb_enqueue_login_fonts() {
	$gf_uri = cb_get_login_page_selected_google_fonts_uri();
	if ( ! empty( $gf_uri ) ) {
		wp_enqueue_style( 'cb-google-font', $gf_uri );
	}
}
add_action( 'login_enqueue_scripts', 'cb_enqueue_login_fonts' );


/**
 * Make labels text as the placeholder of the input box
 */
function cb_login_footer_js() {
	?>
	<script type="text/javascript">

		cb_move_loginpage_labels_as_placeholder();

		function cb_move_loginpage_labels_as_placeholder() {

			if ( typeof document.querySelectorAll == 'undefined' ) {
				return ;
			}

			var labels = document.querySelectorAll('body.login form label');

			for ( var i = 0; i < labels.length; i++) {
				var label = labels[i];
				var text = label.textContent.trim();

				var child_nodes = Array.prototype.slice.call( label.children );

				for (var c = 0; c < child_nodes.length; c++) {
					var child = child_nodes[c];

					if (child.nodeName == 'BR') {
						label.removeChild( child );//remove line breaks
					} else if ( child.nodeName == 'INPUT' && child.type !== 'radio' && child.type != 'checkbox' ) {
						child.setAttribute( 'placeholder', text ); //it is either text|email|password
						label.childNodes[0].nodeValue = '';
					} else {

					}
				}
			}
		}

	</script>
	<?php
}
add_action( 'login_footer', 'cb_login_footer_js' );