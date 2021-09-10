<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}
/**
 * All customizer settings
 *
 * @param type $setting
 *
 * @return type
 */
function cb_get_setting_choices( $setting ) {

	if ( is_object( $setting ) ) {
		$setting = $setting->id;
	}

	$choices = array( 0 );

	switch ( $setting ) {

		case 'main-nav-selected-item-font-weight' :

			$choices = array(
				'normal' => __( 'Normal', 'social-portal' ),
				'bold'   => __( 'Fett', 'social-portal' ),
			);
			break;

		case 'font-style-body' :
			$choices = array(
				'normal' => __( 'Normal', 'social-portal' ),
				'italic' => __( 'Italic', 'social-portal' ),
			);
			break;

		case 'text-transform-body' :

			$choices = array(
				'none'      => __( 'Keine', 'social-portal' ),
				'uppercase' => __( 'Großbuchstaben', 'social-portal' ),
				'lowercase' => __( 'Kleinbuchstaben', 'social-portal' ),
			);
			break;
		case 'link-underline-body' :
			$choices = array(
				'always' => __( 'Immer', 'social-portal' ),
				'hover'  => __( 'Beim Hover/Fokus', 'social-portal' ),
				'never'  => __( 'Niemals', 'social-portal' ),
			);
			break;
		//BG Choices
		case 'background_repeat' :
		case 'header-background-repeat' :
		case 'header-top-background-repeat' :
		case 'header-main-background-repeat' :
		case 'header-bottom-background-repeat' :
		case 'main-nav-background-repeat' :
		case 'main-background-repeat' :
		case 'footer-background-repeat' :
		case 'footer-top-background-repeat' :
		case 'site-copyright-background-repeat' :
		case 'login-background-repeat' :

			$choices = array(
				'no-repeat' => __( 'Keine Wiederholung', 'social-portal' ),
				'repeat'    => __( 'Kacheln', 'social-portal' ),
				'repeat-x'  => __( 'Horizontal kacheln', 'social-portal' ),
				'repeat-y'  => __( 'Vertikal kacheln', 'social-portal' )
			);
			break;
		case 'background_position_x' :
		case 'header-background-position' :
		case 'header-top-background-position' :
		case 'header-main-background-position' :
		case 'header-bottom-background-position' :
		case 'main-nav-background-position' :
		case 'main-background-position' :
		case 'footer-background-position' :
		case 'footer-top-background-position' :
		case 'site-copyright-background-position' :
		case 'login-background-position' :

			$choices = array(
				'top-left'     => __( 'Oben links', 'social-portal' ),
				'top'          => __( 'Oben', 'social-portal' ),
				'top-right'    => __( 'Oben rechts', 'social-portal' ),
				'left'         => __( 'Links', 'social-portal' ),
				'center'       => __( 'Zentriert', 'social-portal' ),
				'right'        => __( 'Rechts', 'social-portal' ),
				'bottom-left'  => __( 'Unten links', 'social-portal' ),
				'bottom'       => __( 'Unten', 'social-portal' ),
				'bottom-right' => __( 'Unten rechts', 'social-portal' ),
			);
			break;
		case 'background_attachment':
		case 'header-background-attachment':
		case 'header-top-background-attachment':
		case 'header-main-background-attachment':
		case 'header-bottom-background-attachment':
		case 'main-nav-background-attachment':
		case 'main-background-attachment':
		case 'footer-background-attachment':
		case 'footer-top-background-attachment':
		case 'site-copyright-background-attachment':
		case 'login-background-attachment':
			$choices = array(
				'scroll' => __( 'Scrollen', 'social-portal' ),
				'fixed'  => __( 'Fixiert', 'social-portal' ),
			);
			break;
		case 'background_size' :
		case 'header-background-size' :
		case 'header-top-background-size' :
		case 'header-main-background-size' :
		case 'header-bottom-background-size' :
		case 'main-nav-background-size' :
		case 'main-background-size' :
		case 'footer-background-size' :
		case 'footer-top-background-size' :
		case 'site-copyright-background-size' :
		case 'login-background-size' :
			$choices = array(
				'auto'    => __( 'Automatisch', 'social-portal' ),
				'cover'   => __( 'Cover', 'social-portal' ),
				'contain' => __( 'Contain', 'social-portal' )
			);
			break;


		case 'footer-widget-areas' :
			$choices = array(
				0 => __( 'Keine', 'social-portal' ),
				1 => __( 'Eine', 'social-portal' ),
				2 => __( 'Zwei', 'social-portal' ),
				3 => __( 'Drei', 'social-portal' ),
				4 => __( 'Vier', 'social-portal' )
			);
			break;

		case 'bp-item-list-display-type':
			$choices = array(
				'masonry'     => __( 'Flexible Gridboxen', 'social-portal' ),
				'equalheight' => __( 'Spalten gleicher Höhe', 'social-portal' ),
				'standard'    => __( 'Regelmäßige Liste', 'social-portal' ),
			);

			break;

		case 'archive-posts-display-type':
		case 'home-posts-display-type':
		case 'search-posts-display-type':
			$choices = array(
				'masonry'  => __( 'Flexible Gridboxen', 'social-portal' ),
				'standard' => __( 'Standardliste', 'social-portal' ),
			);

			break;

		case 'layout-style':
			$choices = array(
				'boxed' => __( 'Festes Layout', 'social-portal' ),
				'fluid' => __( 'Flexibles Layout', 'social-portal' ),
			);

			break;
		case 'theme-layout':
			$choices = cb_get_layouts();

			break;

		case 'home-layout':
		case 'archive-layout':
		case 'search-layout':
		case '404-layout':
		case 'bp-member-profile-layout':
		case 'bp-activity-directory-layout':
		case 'bp-members-directory-layout':
		case 'bp-groups-directory-layout':
		case 'bp-create-group-layout':
		case 'bp-single-group-layout':
		case 'bp-blogs-directory-layout':
		case 'bp-create-blog-layout':
		// WooCommerce
		case 'shop-page-layout':
		case 'product-page-layout':
		case 'product-category-page-layout':
		case 'wc-page-layout':
			$choices = cb_get_page_layouts();
			break;

		case 'panel-left-visibility':
		case 'panel-right-visibility':

			$choices = array(
				'always' => __( 'Immer', 'social-portal' ),
				'mobile' => __( 'Nur kleiner Bildschirm', 'social-portal' ),
				'never'  => __( 'Niemals', 'social-portal' ),

			);
			break;

		case 'main-nav-alignment':

			$choices = array(
				'left'   => __( 'Links', 'social-portal' ),
				'center' => __( 'Zentriert', 'social-portal' ),
				'right'  => __( 'Rechts', 'social-portal' ),
			);

			break;

		case 'panel-left-user-scope':
		case 'panel-right-user-scope':

			$choices = array(
				'all'        => __( 'Jeder', 'social-portal' ),
				'logged-in'  => __( 'Eingeloggt', 'social-portal' ),
				'logged-out' => __( 'Ausgeloggt', 'social-portal' ),
			);

			break;
	}

	/**
	 * Filter the setting choices.
	 *
	 * @since 1.0.0
	 *
	 * @param array $choices The choices for the setting.
	 * @param string $setting The setting name.
	 */
	return apply_filters( 'cb_setting_choices', $choices, $setting );
}

function cb_sanitize_setting_choice( $value, $setting ) {

	if ( is_object( $setting ) ) {
		if ( $setting->type == 'option' ) {
			$setting = cb_get_option_name_from_setting( $setting->id );
		} else {
			$setting = $setting->id;
		}
	}

	$choices         = cb_get_setting_choices( $setting );
	$allowed_choices = array_keys( $choices );

	if ( ! in_array( $value, $allowed_choices ) ) {
		$value = $value;//default is empty//todo change
	}

	return apply_filters( 'cb_sanitized_setting_choice', $value, $setting );
}

function cb_sanitize_float( $value ) {
	return floatval( $value );
}

function cb_sanitize_int( $value ) {
	return absint( $value );
}

function cb_sanitize_text( $string ) {
	global $allowedtags;

	$expandedtags = $allowedtags;

	// span
	$expandedtags['span'] = array();

	// Enable id, class, and style attributes for each tag
	foreach ( $expandedtags as $tag => $attributes ) {
		$expandedtags[ $tag ]['id']    = true;
		$expandedtags[ $tag ]['class'] = true;
		$expandedtags[ $tag ]['style'] = true;
	}

	// br (doesn't need attributes)
	$expandedtags['br'] = array();

	/**
	 * Customize the tags and attributes that are allows during text sanitization.
	 *
	 * @since 1.0.0
	 *
	 * @param array $expandedtags The list of allowed tags and attributes.
	 * @param string $string The text string being sanitized.
	 */
	$expandedtags = apply_filters( 'cb_sanitize_text_allowed_tags', $expandedtags, $string );

	return wp_kses( $string, $expandedtags );
}

/**
 * Extract key from the setting option
 * It will return 'key' from a string of the format somename[key]
 *
 * @param $setting
 *
 * @return string
 */
function cb_get_option_name_from_setting( $setting ) {
	//social-portal
	//get the key
	//strip of social-portal[$key] to get $key
	//return substr( $setting, 18 , -1);//most efficient but will have issues in child theme

	//alternate strategy
	$settings = explode( '[', $setting );
	if ( count( $settings ) > 1 ) {
		//affirmatively found the [
		$setting = substr( $settings[1], 0, - 1 );
	}

	return $setting;
}


/**
 * Customizer callback for sanitizing js
 * Does not do anything special at the moment
 *
 * @param $value
 * @param $setting
 *
 * @return mixed
 */
function cb_sanitize_setting_custom_js( $value, $setting ) {
	return $value;
}

/**
 * Customizer callback for sanitizing custom css
 *
 * @param $value
 * @param $setting
 *
 * @return mixed
 */
function cb_sanitize_setting_custom_css( $value, $setting ) {
	$output = $value;//wp_filter_nohtml_kses(), we can not use escape here as escape will escape the quote

	return $output;
}

/**
 * Is it valid RGBA color?
 *
 * @param $string
 *
 * @return bool
 */
function cb_is_valid_rgba( $string ) {

	return strpos( $string, 'rgba' ) !== false;

	/**
	 * Credit https://gist.github.com/anjan011/3dc4dcb6611465dd384e
	 */
	return preg_match( '/\A^rgba\(([0]*[0-9]{1,2}|[1][0-9]{2}|[2][0-4][0-9]|[2][5][0-5])\s*,\s*([0]*[0-9]{1,2}|[1][0-9]{2}|[2][0-4][0-9]|[2][5][0-5])\s*,\s*([0]*[0-9]{1,2}|[1][0-9]{2}|[2][0-4][0-9]|[2][5][0-5])\s*,\s*([0-9]*\.?[0-9]+)\)$\z/im', $string ) > 0;

}

/**
 * Sanitize RGBA colors
 *
 * @param $color
 *
 * @return string
 */
function cb_sanitize_rgba( $color ) {

	if ( cb_is_valid_rgba( $color ) ) {
		return $color;
	} else {
		return cb_hex_to_rgba( $color );
	}
}

function cb_hex_to_rgba( $color, $opacity = 1 ) {

	$default = 'rgba(0,0,0,0)'; //transparent

	if ( empty( $color ) ) {
		return $default;
	}

	$color = ltrim( $color, '#' );

	$colors = str_split( $color );

	$length = count( $colors );

	if ( $length != 3 && $length != 6 ) {
		return $default;
	}

	if ( $length == 6 ) {
		$hex = array( $colors[0] . $colors[1], $colors[2] . $colors[3], $colors[4] . $colors[5] );
	} elseif ( $length == 3 ) {
		$hex = array( $colors[0] . $colors[0], $colors[1] . $colors[1], $colors[2] . $colors[2] );
	}

	//Convert to dec
	$rgb = array_map( 'hexdec', $hex );

	$rgba = 'rgba(' . implode( ',', $rgb ) . ',' . $opacity . ')';

	return $rgba;
}

function cb_sanitize_capability( $value, $setting ) {
	//for now, just return true for non empty
	//in future, we may add proper check
	if ( ! empty( $value ) ) {
		return $value;
	}

	return 'manage_options';//atleast admin capability
}