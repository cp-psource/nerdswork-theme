<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * @credits
 * Originally based on Make theme api
 */
/**
 * Compile font options from different sources.
 *
 * @since  1.0.0.
 *
 * @return array    All available fonts.
 */
function cb_get_all_fonts() {

    if ( ! function_exists( 'cb_get_google_fonts' ) ) {
        require_once combuilder()->get_path() . '/lib/framework/customizer/google-fonts.php';
    }

   // $heading1       = array( 1 => array( 'label' => sprintf( '--- %s ---', __( 'Standard Fonts', 'social-portal' ) ) ) );
    $standard_fonts = cb_get_standard_fonts();

    foreach ( $standard_fonts as $key1 => $font ) {
        $standard_fonts[ $key1 ]['variants'] = array(
            'normal',
            'italic',
            'regular',
        );
    }
    $standard_fonts = array_values( $standard_fonts );

    $google_fonts   = cb_get_google_fonts();

    foreach ( $google_fonts as $key => $google_font ) {
        $google_fonts[ $key ]['id'] = $key;
    }

    $google_fonts = array_values( $google_fonts );

    return apply_filters( 'cb_all_fonts', array_merge( $standard_fonts, $google_fonts ) );
}

/**
 * Return an array of standard websafe fonts.
 *
 * @since  1.0.0.
 *
 * @return array    Standard websafe fonts.
 */
function cb_get_standard_fonts() {

    return apply_filters( 'cb_get_standard_fonts', array(
        'serif' => array(
            'label'         => __( 'Serif', 'social-portal' ),
            'id'            => 'serif',
            'stack'         => 'Georgia,Times,"Times New Roman",serif',
            'isStandard'    => true,
        ),
        'sans-serif' => array(
            'label'         => __( 'Sans Serif', 'social-portal' ),
            'id'            => 'sans-serif',
            'stack'         => '"Helvetica Neue",Helvetica,Arial,sans-serif',
            'isStandard'    => true
        ),
        'monospace' => array(
            'label'         => __( 'Monospaced', 'social-portal' ),
            'id'            => 'monospace',
            'stack'         => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace',
            'isStandard'    => true
        ),
        'inherit' => array(
            'label'         => __( 'Inherit', 'social-portal' ),
            'id'            => 'inherit',
            'stack'         => 'inherit',
            'isStandard'    => true
        ),
    ) );
}

/**
 * Get all keys that are related to fonts in the setting
 * @return array
 */
function cb_get_font_mods_keys() {
    $property = 'font-settings';

    $all_keys = array_keys( cb_get_default_options() );

    $font_keys = array();

    foreach ( $all_keys as $key ) {
       if ( stripos($key, $property ) !== false ) {
          $font_keys[] = $key;
       }
    }

    $login_font_keys = cb_get_login_page_font_keys();
	//array diff login fonts from all other fonts
	$font_keys = array_diff( $font_keys, $login_font_keys );

    return $font_keys;
}
/**
 * Return all the settings option keys for the specified font property.
 * Used to get all the setting keys that define font selection (Used mainly for getting all options which contains font family details,
 * to initialize it for Selectize)
 * @since  1.0.0
 *
 * @param  string    $property    The font property to search for.
 * @return array                  Array of matching font option keys.
 */
function cb_get_font_property_option_keys( $property ) {

	$all_keys = array_keys( cb_get_default_options() );

	$font_keys = array();
	foreach ( $all_keys as $key ) {
		if ( preg_match( '/^' . $property . '-/', $key ) || preg_match( '/^font-' . $property . '-/', $key ) ) {
			$font_keys[] = $key;
		}
	}

	return $font_keys;
}


/**
 * Packages the font choices into value/label pairs for use with the customizer.
 *
 * @since  1.0.0.
 *
 * @return array    The fonts in value/label pairs.
 */
function cb_get_all_font_choices() {
	$fonts   = cb_get_all_fonts();
	$choices = array();

	// Repackage the fonts into value/label pairs
	foreach ( $fonts as $key => $font ) {
		$choices[ $key ] = $font['label'];
	}

	return apply_filters( 'cb_all_font_choices', $choices );
}

/**
 * Get all preferred fonts (based on defaults/updated)
 *
 * @param string $property
 * @return array
 */
function cb_get_selected_fonts( $property = 'font-settings' ) {
	
	$all_keys = array_keys( cb_get_default_options() );

	$font_keys = array();
	foreach ( $all_keys as $key ) {
		if ( preg_match( '/^' . $property . '-/', $key ) || preg_match( '/^font-' . $property . '-/', $key ) ) {
			$font_keys[ $key ] = cb_get_option( $key );
		}
	}

	return $font_keys;
}
/**
 * Sanitize a font choice.
 *
 * @since  1.0.0.
 *
 * @param  string    $value    The font choice.
 * @return string              The sanitized font choice.
 */
function cb_sanitize_font_choice( $value ) {

	if ( ! is_string( $value ) ) {
		// The array key is not a string, so the chosen option is not a real choice
		return '';
	} elseif ( array_key_exists( $value, cb_get_all_font_choices() ) ) {
		return $value;
	} else {
		return '';
	}

	return apply_filters( 'cb_sanitize_font_choice', $return );
}

/**
 * Retrieve the list of available Google font subsets.
 *
 * @since  1.0.0.
 *
 * @return array    The available subsets.
 */
function cb_get_google_font_subsets() {
    /**
     * Filter the list of supported Google Font subsets.
     *
     * @since 1.0.0.
     *
     * @param array    $subsets    The list of subsets.
     */
    return apply_filters( 'cb_get_google_font_subsets', array(
        'all'              => __( 'All', 'social-portal' ),
        'arabic'       => __( 'Arabic', 'social-portal' ),
        'cyrillic'     => __( 'Cyrillic', 'social-portal' ),
        'cyrillic-ext' => __( 'Cyrillic Extended', 'social-portal' ),
        'devanagari'   => __( 'Devanagari', 'social-portal' ),
        'greek'        => __( 'Greek', 'social-portal' ),
        'greek-ext'    => __( 'Greek Extended', 'social-portal' ),
        'hebrew'       => __( 'Hebrew', 'social-portal' ),
        'khmer'        => __( 'Khmer', 'social-portal' ),
        'latin'        => __( 'Latin', 'social-portal' ),
        'latin-ext'    => __( 'Latin Extended', 'social-portal' ),
        'tamil'        => __( 'Tamil', 'social-portal' ),
        'telugu'       => __( 'Telugu', 'social-portal' ),
        'thai'         => __( 'Thai', 'social-portal' ),
        'vietnamese'   => __( 'Vietnamese', 'social-portal' ),
    ) );
}

/**
 * Based on the keys, get the gogole font URI for loading fonts
 * @param $font_keys
 *
 * @return string
 */
function cb_get_google_fonts_uri( $font_keys ) {

	$fonts = array();
	$subsets = array();

	//Step1: Build a proper list of the form
	//	array( 'font-family' =>  $font_family_name, 'subsets'      => array( 'sub1', 'sub2', 'sub 3' ) ),
	//	array( 'font-family' =>  $font_family_name2, 'subsets'      => array( 'sub1', 'sub2', 'sub 3' ) ),

	foreach ( $font_keys as $key ) {

		$selected_font = cb_get_option( $key );
		$font_family = isset( $selected_font['font-family'] ) ? $selected_font['font-family'] : false;

		if ( empty( $font_family ) ) {
			continue;
		}

		$variant = isset( $selected_font['variant'] ) ? $selected_font['variant']: '';

		//Push the subsets to the list if needed
		if ( isset( $selected_font['subsets'] ) ) {
			foreach( $selected_font['subsets'] as $subset ) {
				if ( ! in_array( $subset, $subsets ) ) {
					$subsets[] = $subset;
				}
			}
		}

		//Not in our list, add it
		if ( ! isset( $fonts[ $font_family ] ) ) {
			$variant = explode( ',', $variant );
			$fonts[ $font_family ] = array(
				'font-family' => $font_family,
				'variant'     => $variant,
			);
		} else {
			//already in our list, let us update
			//we only need to update if variant is available and not already selected
			if ( empty( $variant ) || in_array( $variant, $fonts[ $font_family ]['variant'] ) ) {
				continue;
			}

			array_push( $fonts[ $font_family ]['variant'], $variant );
		}
	}

	//load google font if not already loaded
	require_once combuilder()->get_path() . '/lib/framework/customizer/google-fonts.php';

	$subsets       = array_unique( $subsets );

	//allowed google fonts
	$allowed_fonts = cb_get_google_fonts();
	//found families
	$families        = array();
	// Validate each font and convert to URL format
	foreach ( $fonts as $font ) {
		$font_family = trim( $font['font-family'] );
		$variant = join( ',', $font['variant'] );
		// Verify that the font exists
		//It also makes sure that they are google font
		if ( array_key_exists( $font_family, $allowed_fonts ) ) {
			// Build the family name and variant string (e.g., "Open+Sans:regular,italic,700")
			if ( $font_family && $variant ) {
				$families[] = urlencode( $font_family ) . ':' . $variant ;
			} else {
				$families[] = urlencode( $font_family );
			}
		}
	}

	// Start the request
	$request = '';
	$uri_base = '//fonts.googleapis.com/css?family=';

	// Convert from array to string
	if ( ! empty( $families ) ) {
		$request = $uri_base . implode( '|', $families );
	}

	// Load the font subset

	if ( $subsets && ! in_array( 'latin', $subsets ) ) {
		$subsets[] = 'latin';
	}
	// Append the subset string
	if ( '' !== $request && ! empty( $subsets ) ) {
		$request = $uri_base . '&subset='. join( ',', $subsets );
	}

	return $request;
}

/**
 * Build the HTTP request URL for Google Fonts.
 *
 * The wp_enqueue_style function escapes the stylesheet URL, so no escaping is done here. If
 * this function is used in a different context, make sure the output is escaped!
 *
 * @since  1.0.0.
 *
 * @return string    The URL for including Google Fonts.
 */
function cb_get_selected_google_fonts_uri() {

	$font_uri = get_option( 'cb_google_font' );

	if ( $font_uri && ! is_customize_preview() ) {
		return $font_uri;
	}

	$font_keys = cb_get_font_mods_keys();
	$request = cb_get_google_fonts_uri( $font_keys );
	//store the request uri for future use
	update_option( 'cb_google_font', $request );

	/**
	 * Filter the Google Fonts URL.
	 *
	 * @param string    $url    The URL to retrieve the Google Fonts.
	 */

	return apply_filters( 'cb_selected_google_fonts_uri', $request );
}

/**
 * Get an array of keys representing fonts usage on the Login page
 *
 * @return array
 */
function cb_get_login_page_font_keys() {
	$font_keys = array(
		'login-font-settings',
		'login-logo-font-settings',
		'login-logo-font-settings',
	);

	return $font_keys;
}

/**
 * Get the URI to load google fonts selected for login page
 *
 * @return mixed|void
 */
function cb_get_login_page_selected_google_fonts_uri() {

	$font_uri = get_option( 'cb_login_google_font' );

	if ( $font_uri && ! is_customize_preview() ) {
		return $font_uri;
	}

	$font_keys = cb_get_login_page_font_keys();
	$request = cb_get_google_fonts_uri( $font_keys );
	//store the request uri for future use
	update_option( 'cb_login_google_font', $request );

	/**
	 * Filter the Google Fonts URL.
	 *
	 * @param string    $url    The URL to retrieve the Google Fonts.
	 */

	return apply_filters( 'cb_login_page_selected_google_fonts_uri', $request );
}
