<?php

/**
 * Generate css rules for font-size, line-height, font-family
 * @param CB_CSS_Builder $builder
 * @param string $element
 * @param string $selector
 * @param boolean $use_mod
 */
function cb_css_add_font_style( $builder, $element, $selector, $use_mod = true ) {

	if ( ! is_array( $selector ) ) {
		$selector = (array) $selector;
	}
	if ( $use_mod ) {
		$list = cb_get_modified_value( $element . '-font-settings' );
	} else {
		$list = cb_get_option( $element .'-font-settings' );
	}


	if ( ! empty( $list ) ) {
		//print_r($list);
		unset( $list['subsets'] );

		if ( isset( $list['variant'] ) ) {
			$list['font-weight'] = $list['variant'];
			unset( $list['variant'] );

		}

		if ( isset( $list['font-size'] ) ) {
			$list['font-size'] = $list['font-size'] .'px';//append unit
		}

		$builder->add( array(
			'selectors'		=> $selector,
			'declarations'	=> $list
		) );

	}
}

/**
 * Generate hover css
 *
 * @param CB_CSS_Builder $builder
 * @param string $element theme option
 * @param string $selector selector for the anchor elements
 * @param string $hover_selector
 * @param  boolean $use_mod
 */
function cb_css_add_link_style( $builder, $element, $selector , $hover_selector = '', $use_mod = true  ) {

	if ( ! $hover_selector ) {
		$hover_selector = array( $selector .':hover' );
	} else {
		$hover_selector = (array) $hover_selector;
	}

	if ( ! is_array( $selector ) ) {
		$selector = (array) $selector;
	}

	if ( $use_mod ) {
		$callback = 'cb_get_modified_value';
	} else {
		$callback = 'cb_get_option';
	}
	$link_color     = $callback( $element . '-link-color'   );
	$hover_color    = $callback( $element . '-link-hover-color'   );

	if ( $link_color  ) {

		$builder->add( array(
			'selectors'		=> $selector,
			'declarations'	=> array(
				'color' => $link_color
			)
		) );
	}

	if ( $hover_color ) {
		$builder->add( array(
			'selectors'		=> $hover_selector,
			'declarations'	=> array(
				'color' => $hover_color
			)
		) );
	}
}

/**
 * Add Button hover rules
 *
 * @param $builder
 * @param $element
 * @param $selector
 * @param $hover_selector
 * @param boolean $use_mod
 */
function cb_css_add_button_style( $builder, $element, $selector, $hover_selector, $use_mod = true ) {

	$rules_normal  = array();
	$rules_hover  = array();

	if ( ! is_array( $selector ) ) {
		$selector = (array) $selector;
	}

	if ( ! is_array( $hover_selector ) ) {
		$hover_selector = (array) $hover_selector;
	}

	if ( $use_mod ) {
		$callback = 'cb_get_modified_value';
	} else {
		$callback = 'cb_get_option';
	}

	$bg_color		    = $callback(  $element . '-background-color' );
	$bg_hover_color		= $callback(  $element . '-hover-background-color' );

	$text_color	        = $callback( $element . '-text-color' );
	$text_hover_color	= $callback( $element . '-hover-text-color' );

	if ( $bg_color  ) {
		$rules_normal['background-color'] = $bg_color;
	}

	if ( $text_color  ) {
		$rules_normal['color'] = $text_color;
	}

	if ( $bg_hover_color  ) {
		$rules_hover['background-color'] = $bg_hover_color;
	}

	if ( $text_hover_color  ) {
		$rules_hover['color'] = $text_hover_color;
	}

	if ( ! empty( $rules_normal ) ) {
		$builder->add( array(
			'selectors'		=> $selector,
			'declarations'	=> $rules_normal
		) );

	}

	if ( ! empty( $rules_hover ) ) {
		$builder->add( array(
			'selectors'		=> $hover_selector,
			'declarations'	=> $rules_hover
		) );
	}
}

function cb_css_add_background_hover_style( $builder, $element, $selector, $hover_selector, $use_mod = true ) {
	$rules_normal  = array();
	$rules_hover  = array();

	if ( ! is_array( $selector ) ) {
		$selector = (array) $selector;
	}

	if ( ! is_array( $hover_selector ) ) {
		$hover_selector = (array) $hover_selector;
	}

	if ( $use_mod ) {
		$callback = 'cb_get_modified_value';
	} else {
		$callback = 'cb_get_option';
	}

	$bg_color		    = $callback(  $element . '-background-color' );
	$bg_hover_color		= $callback(  $element . '-hover-background-color' );

	$text_color	        = $callback( $element . '-color' );
	$text_hover_color	= $callback( $element . '-hover-color' );

	if ( $bg_color  ) {
		$rules_normal['background-color'] = $bg_color;
	}

	if ( $text_color  ) {
		$rules_normal['color'] = $text_color;
	}

	if ( $bg_hover_color  ) {
		$rules_hover['background-color'] = $bg_hover_color;
	}

	if ( $text_hover_color  ) {
		$rules_hover['color'] = $text_hover_color;
	}

	if ( ! empty( $rules_normal ) ) {
		$builder->add( array(
			'selectors'		=> $selector,
			'declarations'	=> $rules_normal
		) );

	}

	if ( ! empty( $rules_hover ) ) {
		$builder->add( array(
			'selectors'		=> $hover_selector,
			'declarations'	=> $rules_hover
		) );
	}
}

/**
 * Add rules for generating the border styles
 *
 * @param $builder
 * @param $element
 * @param $selector
 * @param boolean $use_mod
 */
function cb_css_add_border_style( $builder, $element, $selector, $use_mod = true ) {

	if ( ! is_array( $selector ) ) {
		$selector = (array) $selector;
	}

	if ( $use_mod ) {
		$list = cb_get_modified_value( $element .'-border'  );
	} else {
		$list = cb_get_option( $element . '-border'  );
	}

	if ( ! empty( $list ) ) {
		$property = $list['border-edge'];
		$value = $list['border-width'] .'px ' . $list['border-style'] . ' ' . $list['border-color'];

		$builder->add( array(
			'selectors'		=> $selector,
			'declarations'	=> array( $property => $value )
		) );
	}
}

/**
 * Generate CSS rules for background and a few more common things
 *
 * @param $builder
 * @param $element
 * @param $selector
 * @param  $use_mod
 */
function cb_css_add_common_style( $builder, $element, $selector, $use_mod = true ) {

	$list  = array();

	if ( ! is_array( $selector ) ) {
		$selector = (array) $selector;
	}

	if ( $use_mod ) {
		$callback = 'cb_get_modified_value';
	} else {
		$callback = 'cb_get_option';
	}

	$image_url		= $callback(  $element . '-background-image' );
	$bg_repeat		= $callback(  $element . '-background-repeat' );

	$bg_position	= $callback( $element . '-background-position' );
	$bg_attachment	= $callback( $element . '-background-attachment' );

	$bg_size		= $callback( $element . '-background-size' );
	$bg_color		= $callback( $element . '-background-color' );

	$text_color		= $callback( $element . '-text-color'   );

	if ( $image_url  ) {
		$list['background-image'] = "url({$image_url})";
	}

	if ( $bg_repeat ) {
		$list['background-repeat'] = $bg_repeat ;
	}

	if ( $bg_position) {
		$list['background-position'] = $bg_position ;
	}

	if ( $bg_attachment) {
		$list['background-attachment'] = $bg_attachment ;
	}

	if ( $bg_size) {
		$list['background-size'] = $bg_size ;
	}

	if ( $bg_color ) {
		$list['background-color'] = $bg_color ;
	}

	if ( $text_color  ) {
		$list['color'] = $text_color;
	}

	if ( ! empty( $list ) ) {
		$builder->add( array(
			'selectors'		=> $selector,
			'declarations'	=> $list
		) );
	}
}

/**
 * Generates custom css for the theme
 *
 */
function cb_css_display_customizations() {

	do_action( 'cb_css' );
	// Echo the rules
	$css = cb_get_css_builder()->build();
	//Pre WordPress 4.7 custom css
	if ( ! function_exists( 'wp_update_custom_css_post' ) ) {

		$custom_css = cb_get_option( 'custom_css' );

		if ( ! empty( $custom_css ) ) {
			$css = $css . $custom_css;
		}
	}

	if ( ! empty( $css ) ) {
		echo "\n<!-- Beginne mit WMS N@W Theme Custom CSS -->\n<style type=\"text/css\" id=\"cb-theme-custom-css\">\n";
		echo $css;
		echo "\n</style>\n<!-- WMS N@W Theme Benutzerdefinierte CSS beenden -->\n";
	}
}
