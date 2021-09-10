<?php
/**
 * Functions used for registering customize controls
 *
 */

/**
 * @param $element
 * @param $label
 * @param string $description
 *
 * @return array
 */
function cb_get_typography_group_definitions( $element, $label, $description = '' ) {

	$definitions = array(
		$element . '-font-settings' => array(
			'setting' => array(
				//'sanitize_callback'     => 'cb_sanitize_setting_choice',
				'default'		        => cb_get_default( $element . '-font-settings' ),
				'transport'				=> 'postMessage',
			),
			'control' => array(
				'control_type'  => 'CB_Customize_Control_Typography',
				'label'         => $label,
				'description'   => $description,
				'type'          => 'typography',
			),
		),
	);

	return $definitions;
}

function cb_get_image_definitions( $name , $title) {

	$def = array(
		$name => array(
			'setting' => array(
				'sanitize_callback' => 'esc_url_raw',
				'transport'			=> 'postMessage',
			),
			'control' => array(
				'control_type' => 'CB_Customize_Image_Control',
				'label'        => $title,
				'context'      => 'cb_' . $name,
			),
		),
	);

	return $def;
}

function cb_get_color_definition( $args = array() ) {

	return array(

		'setting'	=> array(
			'sanitize_callback' => 'maybe_hash_hex_color',
			'transport'			=> 'postMessage',
			'default'			=> $args['default'],
		),
		'control'	=> array(
			'control_type'	=> 'WP_Customize_Color_Control',
			'label'			=> $args['label'], //__( 'Text Color', 'social-portal' ),
		),
	);

}

function cb_get_border_definition( $args = array() ) {

	return array(
		'setting' => array(
			//'sanitize_callback'     => 'cb_sanitize_setting_choice',
			'default'   => $args['default'],
			'transport' => isset( $args['transport'] ) ? $args['transport'] : 'postMessage',
		),
		'control' => array(
			'control_type' => 'CB_Customize_Control_Border',
			'label'        => $args['label'],
			'description'  => $args['desc'],
			//'type'          => 'border',
		),
	);

}



function cb_get_button_style_definition( $region, $label ) {

	return array(

		$region . '-color-group-buttons' => array(
			'control' => array(
				'control_type' => 'CB_Customize_Misc_Control',
				'label'        => $label,
				'type'         => 'group-title',
			),
		),
		$region . '-background-color'    => array(
			'setting' => array(
				'sanitize_callback' => 'cb_sanitize_rgba',
				'transport'         => 'postMessage',
				'default'           => cb_get_default( $region . '-background-color' ),
			),
			'control' => array(
				'control_type' => 'CB_Customize_Control_Alpha_Color',
				'label'        => __( 'Hintergrundfarbe', 'social-portal' ),
			),
		),
		$region . '-text-color'          => array(

			'setting' => array(
				'sanitize_callback' => 'maybe_hash_hex_color',
				'transport'         => 'postMessage',
				'default'           => cb_get_default( $region . '-text-color' ),
			),
			'control' => array(
				'control_type' => 'WP_Customize_Color_Control',
				'label'        => __( 'Textfarbe', 'social-portal' ),
			),

		),

		$region . '-hover-background-color' => array(
			'setting' => array(
				'sanitize_callback' => 'cb_sanitize_rgba',
				'transport'         => 'postMessage',
				'default'           => cb_get_default( $region . '-hover-background-color' ),
			),
			'control' => array(
				'control_type' => 'CB_Customize_Control_Alpha_Color',
				'label'        => __( 'Hover Hintergrundfarbe', 'social-portal' ),
			),
		),


		$region . '-hover-text-color' => array(

			'setting' => array(
				'sanitize_callback' => 'maybe_hash_hex_color',
				'transport'         => 'postMessage',
				'default'           => cb_get_default( $region . '-hover-text-color' ),
			),
			'control' => array(
				'control_type' => 'WP_Customize_Color_Control',
				'label'        => __( 'Hover Textfarbe', 'social-portal' ),
			),

		),


	);

}

/**
 * Get the definition for background color
 *
 * @param array $args
 *
 * @return array
 */
function cb_get_background_color_definition( $args = array() ) {

	return array(

		'setting' => array(
			'sanitize_callback' => 'cb_sanitize_rgba',
			'transport'         => 'postMessage',
			'default'           => $args['default'],
		),
		'control' => array(
			'control_type' => 'CB_Customize_Control_Alpha_Color',
			'label'        => $args['label'],
		),
	);

}


function cb_get_background_image_group_definitions( $region, $settings = array() ) {

	$definitions = array();

	if ( ! empty( $settings['background-image'] ) ) {
		$definitions = array(
			$region . '-background-image'      => array(
				'setting' => array(
					'sanitize_callback' => 'esc_url_raw',
					'transport'         => 'postMessage',
				),
				'control' => array(
					'control_type' => 'CB_Customize_Image_Control',
					'label'        => __( 'Hintergrundbild', 'social-portal' ),
					'context'      => 'cb_' . $region . '-background-image',
				),
			),
			$region . '-background-repeat'     => array(
				'setting' => array(
					'sanitize_callback' => 'cb_sanitize_setting_choice',
					'transport'         => 'postMessage',
					'default'           => 'no-repeat'
				),
				'control' => array(
					'label'   => __( 'Wiederholen', 'social-portal' ),
					'type'    => 'radio',
					'choices' => cb_get_setting_choices( $region . '-background-repeat' ),
				),
			),
			$region . '-background-position'   => array(
				'setting' => array(
					'sanitize_callback' => 'cb_sanitize_setting_choice',
					'transport'         => 'postMessage',
					'default'           => 'center'
				),
				'control' => array(
					'control_type' => 'CB_Customize_Background_Position_Control',
					'label'        => __( 'Position', 'social-portal' ),
					'type'         => 'background-position',
					'choices'      => cb_get_setting_choices( $region . '-background-position' ),
				),
			),
			$region . '-background-attachment' => array(
				'setting' => array(
					'sanitize_callback' => 'cb_sanitize_setting_choice',
					'transport'         => 'postMessage',
				),
				'control' => array(
					'control_type' => 'CB_Customize_Radio_Control',
					'label'        => __( 'Anhang', 'social-portal' ),
					'type'         => 'radio',
					'mode'         => 'buttonset',
					'choices'      => cb_get_setting_choices( $region . '-background-attachment' ),
				),
			),
			$region . '-background-size'       => array(
				'setting' => array(
					'sanitize_callback' => 'cb_sanitize_setting_choice',
					'transport'         => 'postMessage',
					'default'           => 'cover'
				),
				'control' => array(
					'control_type' => 'CB_Customize_Radio_Control',
					'label'        => __( 'Größe', 'social-portal' ),
					'type'         => 'radio',
					'mode'         => 'buttonset',
					'choices'      => cb_get_setting_choices( $region . '-background-size' ),
				),
			),

		);
	}

	if ( ! empty( $settings['background-color'] ) ) {

		$definitions[ $region . '-background-color' ] = cb_get_background_color_definition( array(
			'default' => cb_get_default( $region . '-background-color' ),
			'label'   => __( 'Hintergrundfarbe', 'social-portal' )
		) );

	}

	if ( ! empty( $settings['color'] ) ) {

		$definitions[ $region . '-text-color' ] = cb_get_color_definition( array(
			'default' => cb_get_default( $region . '-text-color' ),
			'label'   => __( 'Textfarbe', 'social-portal' )
		) );

	}

	if ( ! empty( $settings['link'] ) ) {

		$definitions[ $region . '-link-color' ] = cb_get_color_definition( array(
			'default' => cb_get_default( $region . '-link-color' ),
			'label'   => __( 'Linkfarbe', 'social-portal' )
		) );

	}

	if ( ! empty( $settings['link-hover'] ) ) {

		$definitions[ $region . '-link-hover-color' ] = cb_get_color_definition( array(
			'default' => cb_get_default( $region . '-link-hover-color' ),
			'label'   => __( 'Link Hover Farbe', 'social-portal' ),
		) );

	}

	if ( ! empty( $settings['border'] ) ) {
		$definitions[ $region . '-border' ] = cb_get_border_definition( array(
			'label'   => __( 'Rahmen', 'social-portal' ),
			'desc'    => '',
			'default' => cb_get_default( $region . '-border' )
		) );

	}

	return apply_filters( 'cb_customizer_style_control_group_definitions', $definitions, $region );
}
