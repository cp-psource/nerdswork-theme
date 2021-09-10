<?php
/**
 * @package social-portal
 * Customizer Styling Panel
 *
 */

//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class CB_Style_Panel_Helper {

	private $panel = 'cb_styling';//panel id

	public function __construct() {
		add_filter( 'cb_customizer_sections', array( $this, 'add_sections' ) );
	}

	public function add_sections( $sections ) {

		$new_sections = $this->get_sections();

		return array_merge( $sections, $new_sections );
	}

	public function get_sections() {

		$panel               = $this->panel;
		$background_sections = array();

		/**
		 * Main Column
		 */
		$background_sections['styling-global'] = array(
			'priority' => 0,
			'panel'    => $panel,
			'title'    => __( 'Global', 'social-portal' ),
			'options'  => array(
				'color-group-theme-style' => array(
					'control' => array(
						'control_type' => 'CB_Customize_Misc_Control',
						'label'        => __( 'Farbschema', 'social-portal' ),
						'type'         => 'group-title',
					),
				),

				'theme-style' => array(
					'setting' => array(
						'sanitize_callback' => 'maybe_hash_hex_color',
						'transport'         => 'postMessage',
						'default'           => 'default',
					),
					'control' => array(
						'control_type' => 'CB_Customize_Control_Palette',
						'label'        => __( 'Stil', 'social-portal' ),
						'choices'      => cb_get_theme_color_palettes(),
						'description'  => __( 'Themenstile zur Ansichtsanpassung.', 'social-portal' ),
					),
				),

				/*'primary-color'           => array(
					'setting' => array(
						'sanitize_callback' => 'maybe_hash_hex_color',
						'transport'         => 'postMessage',
						'default'           => cb_get_default( 'primary-color' ),
					),
					'control' => array(
						'control_type' => 'WP_Customize_Color_Control',
						'label'        => __( 'Primary Color', 'social-portal' ),
						'description'  => sprintf(
							__( 'Used for: %s', 'social-portal' ), __( 'background & UI elements', 'social-portal' )
						),
					),
				),
				'secondary-color'         => array(
					'setting' => array(
						'sanitize_callback' => 'maybe_hash_hex_color',
						'transport'         => 'postMessage',
						'default'           => cb_get_default( 'secondary-color' ),
					),
					'control' => array(
						'control_type' => 'WP_Customize_Color_Control',
						'label'        => __( 'Secondary Color', 'social-portal' ),
						'description'  => sprintf(
							__( 'Used for: %s', 'social-portal' ), __( 'form inputs, table borders, ruled lines, slider buttons', 'social-portal' )
						),
					),
				),*/
				'text-color'              => array(
					'setting' => array(
						'sanitize_callback' => 'maybe_hash_hex_color',
						'transport'         => 'postMessage',
						'default'           => cb_get_default( 'text-color' ),
					),
					'control' => array(
						'control_type' => 'WP_Customize_Color_Control',
						'label'        => __( 'Textfarbe', 'social-portal' ),
						'description'  => sprintf( __( 'Benutzt für: %s', 'social-portal' ), __( 'der meiste Text', 'social-portal' ) ),
					),
				),
				'color-group-global-link' => array(
					'control' => array(
						'control_type' => 'CB_Customize_Misc_Control',
						'label'        => __( 'Links', 'social-portal' ),
						'type'         => 'group-title',
					),
				),
				'link-color'              => array(
					'setting' => array(
						'sanitize_callback' => 'maybe_hash_hex_color',
						'transport'         => 'postMessage',
						'default'           => cb_get_default( 'link-color' ),
					),
					'control' => array(
						'control_type' => 'WP_Customize_Color_Control',
						'label'        => __( 'Linkfarbe', 'social-portal' ),
						'description'  => __( 'Die Standard-Linkfarbe.', 'social-portal' ),
					),
				),
				'link-hover-color'        => array(
					'setting' => array(
						'sanitize_callback' => 'maybe_hash_hex_color',
						'transport'         => 'postMessage',
						'default'           => cb_get_default( 'link-hover-color' ),
					),
					'control' => array(
						'control_type' => 'WP_Customize_Color_Control',
						'label'        => __( 'Link Hover/Fokus Farbe', 'social-portal' ),
						'description'  => __( 'Link Hover/Fokus Farbe.', 'social-portal' ),
					),
				),
			),
		);

		$more_options = cb_get_button_style_definition( 'button', __( 'Schaltflächen', 'social-portal' ) );

		$background_sections['styling-global']['options'] = array_merge( $background_sections['styling-global']['options'], $more_options );

		$background_sections['styling-site-logo'] = array(
			'panel'    => $panel,
			'priority' => 6,
			'title'    => __( 'Logo', 'social-portal' ),
			'options'  => cb_get_background_image_group_definitions( 'site-title', array(
				'background-image' => false,
				'background-color' => false,
				'color'            => false,
				'link'             => true,
				'link-hover'       => true,
				'border-color'     => false,
			) ),
		);

		/**
		 * Site Header
		 */

		$header_options = array(
			'header-background-title' => array(
				'control' => array(
					'control_type' => 'CB_Customize_Title_Control',
					'label'        => __( 'Header', 'social-portal' ),
					//'type'				=> 'title',
				)
			)
		);

		$header_options = array_merge( $header_options, cb_get_background_image_group_definitions( 'header', array(
			'background-image' => true,
			'background-color' => true,
			'color'            => true,
			'link'             => true,
			'link-hover'       => true,
			'border'           => true,
		) ) );

		$header_options['header-styling-panel-toggle-title'] = array(
			'control' => array(
				'control_type' => 'CB_Customize_Misc_Control',
				'label'        => __( 'Panel aktiv', 'social-portal' ),
				'type'         => 'group-title',
			),
		);
		$header_options['panel-left-toggle-color'] = cb_get_color_definition( array(
			'default' => cb_get_default('panel-left-toggle-color'),
			'label'  => __( 'Farbe wenn linkes Panel aktiv', 'social-portal' ),
		) );

		$header_options['panel-right-toggle-color'] = cb_get_color_definition( array(
			'default' => cb_get_default('panel-right-toggle-color'),
			'label'  => __( 'Farbe wenn rechtes Panel aktiv', 'social-portal' ),
		) );

		$header_options = array_merge( $header_options, cb_get_button_style_definition( 'header-buttons', __( 'Login/Registrieren Schaltflächen', 'social-portal' ) ) );

		//for Background color , see customizer-init.php
		$background_sections['header-styling'] = array(
			'panel'    => $panel,
			'priority' => 7,
			'title'    => __( 'Seitenheader', 'social-portal' ),
			'options'  => $header_options,
		);

		$background_sections['header-top-styling'] = array(
			'panel'           => $panel,
			'priority'        => 8,
			'title'           => __( 'Seitenheader - Oben', 'social-portal' ),
			'active_callback' => 'cb_is_header_top_row_enabled',
			'options'         => cb_get_background_image_group_definitions( 'header-top', array(
				'background-image' => false,
				'background-color' => true,
				'color'            => true,
				'link'             => true,
				'link-hover'       => true,
				'border'           => true,
			) ),
		);

		$background_sections['header-main-styling'] = array(
			'panel'    => $panel,
			'priority' => 9,
			'title'    => __( 'Seitenheader - Hauptbereich', 'social-portal' ),
			'options'  => cb_get_background_image_group_definitions( 'header-main', array(
				'background-image' => false,
				'background-color' => true,
				'color'            => true,
				'link'             => true,
				'link-hover'       => true,
				'border'           => true,
			) ),
		);

		$background_sections['header-bottom-styling'] = array(
			'panel'           => $panel,
			'priority'        => 9,
			'title'           => __( 'Seitenheader - Unten', 'social-portal' ),
			'active_callback' => 'cb_is_header_bottom_row_enabled',
			'options'         => cb_get_background_image_group_definitions( 'header-bottom', array(
				'background-image' => false,
				'background-color' => true,
				'color'            => true,
				'link'             => true,
				'link-hover'       => true,
				'border'           => true,
			) ),
		);


		//Main menu
		$menu_options = cb_get_background_image_group_definitions( 'main-nav', array(
			'background-image' => false,
			'background-color' => true,
			'color'            => false,
			'link'             => false,
			'link-hover'       => false,
			'border'           => false,
		) );

		$menu_options['main-nav-alignment'] = array(
			'setting' => array(
				'sanitize_callback' => 'cb_sanitize_setting_choice',
				'transport'         => 'postMessage',
				'default'           => cb_get_default( 'main-nav-alignment' ),
			),
			'control' => array(
				'control_type' => 'CB_Customize_Radio_Control',
				'label'        => __( 'Ausrichtung', 'social-portal' ),
				'type'         => 'radio',
				'mode'         => 'buttonset',
				'choices'      => cb_get_setting_choices( 'main-nav-alignment' ),
			),
		);

		$menu_options['main-nav-main-link-option-heading'] = array(
			'control' => array(
				'control_type' => 'CB_Customize_Misc_Control',
				'type'         => 'group-title',
				'label'        => __( 'Menüelemente', 'social-portal' ),
			),
		);
		$menu_options['main-nav-link-color'] = cb_get_color_definition( array(
			'default' => cb_get_default( 'main-nav-link-color' ),
			'label'   => __( 'Linkfarbe', 'social-portal' ),
		) );

		$menu_options['main-nav-link-background-color'] = cb_get_background_color_definition( array(
			'default' => cb_get_default( 'main-nav-link-background-color' ),
			'label'   => __( 'Hintergrundfarbe', 'social-portal' ),
		) );

		$menu_options['main-nav-link-border'] = cb_get_border_definition( array(
			'label'   => __( 'Rahmen', 'social-portal' ),
			'desc'    => '',
			'default' =>  cb_get_default( 'main-nav-link-border' )
		) );

		$menu_options['main-nav-link-hover-color'] = cb_get_color_definition( array(
			'default' => cb_get_default( 'main-nav-link-hover-color' ),
			'label'   => __( 'Hoverfarbe', 'social-portal' ),
		) );

		$menu_options['main-nav-link-hover-background-color'] = cb_get_background_color_definition( array(
			'default' => cb_get_default( 'main-nav-link-hover-background-color' ),
			'label'   => __( 'Hover Hintergrundfarbe', 'social-portal' ),
		) );

		$menu_options['main-nav-link-hover-border'] = cb_get_border_definition( array(
			'label'   => __( 'Hoverrahmen', 'social-portal' ),
			'desc'    => '',
			'default' =>  cb_get_default( 'main-nav-link-hover-border' )
		) );


		$menu_options['main-nav-selected-option-heading'] = array(
			'control' => array(
				'control_type' => 'CB_Customize_Misc_Control',
				'type'         => 'group-title',
				'label'        => __( 'Ausgewählte Elemente', 'social-portal' ),
			),
		);

		$menu_options['main-nav-selected-item-color'] = array(
			'setting' => array(
				'sanitize_callback' => 'maybe_hash_hex_color',
				'transport'         => 'postMessage',
				'default'           => cb_get_default( 'main-nav-selected-item-color' ),
			),
			'control' => array(
				'control_type' => 'WP_Customize_Color_Control',
				'label'        => __( 'Farbe', 'social-portal' ),
				'description'  => ''
			),
		);


		$menu_options['main-nav-selected-item-font-weight'] = array(
			'setting' => array(
				'sanitize_callback' => 'cb_sanitize_setting_choice',
				'transport'         => 'postMessage',
			),
			'control' => array(
				'control_type' => 'CB_Customize_Radio_Control',
				'label'        => __( 'Schriftgröße', 'social-portal' ),
				'type'         => 'radio',
				'mode'         => 'buttonset',
				'choices'      => cb_get_setting_choices( 'main-nav-selected-item-font-weight' ),
			),
		);

		$menu_options['sub-nav-option-heading'] = array(
			'control' => array(
				'control_type' => 'CB_Customize_Misc_Control',
				'type'         => 'group-title',
				'label'        => __( 'Untermenü Link', 'social-portal' ),
			),
		);

/*		$menu_options = array_merge( $menu_options,
			cb_get_background_image_group_definitions( 'sub-nav', array(

				'background-image' => false,
				'background-color' => false,
				'color'            => false,
				'link'             => true,
				'link-hover'       => true,
				'border'           => false,
			) ) );

*/
		$menu_options['sub-nav-link-color'] = cb_get_color_definition( array(
			'default' => cb_get_default( 'sub-nav-link-color' ),
			'label'   => __( 'Linkfarbe', 'social-portal' ),
		) );

		$menu_options['sub-nav-link-background-color'] = cb_get_background_color_definition( array(
			'default' => cb_get_default( 'sub-nav-link-background-color' ),
			'label'   => __( 'Hintergrundfarbe', 'social-portal' ),
		) );

		$menu_options['sub-nav-link-border'] = cb_get_border_definition( array(
			'label'   => __( 'Rahmen', 'social-portal' ),
			'desc'    => '',
			'default' =>  cb_get_default( 'sub-nav-link-border' )
		) );

		$menu_options['sub-nav-link-hover-color'] = cb_get_color_definition( array(
			'default' => cb_get_default( 'sub-nav-link-hover-color' ),
			'label'   => __( 'Hoverfarbe', 'social-portal' ),
		) );

		$menu_options['sub-nav-link-hover-background-color'] = cb_get_background_color_definition( array(
			'default' => cb_get_default( 'sub-nav-link-hover-background-color' ),
			'label'   => __( 'Hover Hintergrundfarbe', 'social-portal' ),
		) );

		$menu_options['sub-nav-link-hover-border'] = cb_get_border_definition( array(
			'label'   => __( 'Hoverrahmen', 'social-portal' ),
			'desc'    => '',
			'default' =>  cb_get_default( 'sub-nav-link-hover-border' )
		) );

		$background_sections['styling-main-menu'] = array(
			'panel'    => $panel,
			'priority' => 9,
			'title'    => __( 'Hauptmenü', 'social-portal' ),
			'options'  => $menu_options,
		);

		//for Background color , see customizer-init.php
		$background_sections['styling-main-section'] = array(
			'panel'   => $panel,
			'title'   => __( 'Hauptspalte', 'social-portal' ),
			'options' => cb_get_background_image_group_definitions( 'main', array(
				'background-image' => true,
				'background-color' => true,
				'color'            => false,
				'link'             => false,
				'link-hover'       => false,
				'border'           => false,
			) ),
		);

		$background_sections['styling-sidebar'] = array(
			'panel'   => $panel,
			'title'   => __( 'Seitenleiste', 'social-portal' ),
			'options' => cb_get_background_image_group_definitions( 'sidebar', array(
				'background-image' => false,
				'background-color' => true,
				'color'            => true,
				'link'             => true,
				'link-hover'       => true,
				'border'           => false,
			) ),

		);

		$background_sections['styling-widgets'] = array(
			'panel'   => $panel,
			'title'   => __( 'Widgets', 'social-portal' ),
			'options' => array_merge(
				array(
					'widget-title-text-title' => array(
						'control' => array(
							'control_type' => 'CB_Customize_Misc_Control',
							'type'         => 'group-title',
							'label'        => __( 'Titel', 'social-portal' ),
						),
					),
				),
				cb_get_background_image_group_definitions( 'widget-title', array(
					'background-image' => false,
					'background-color' => false,
					'color'            => true,
					'link'             => true,
					'link-hover'       => true,
					'border'           => false,
				) ),
				array(
					'widget-title-text-content' => array(
						'control' => array(
							'control_type' => 'CB_Customize_Misc_Control',
							'type'         => 'group-title',
							'label'        => __( 'Inhalt', 'social-portal' ),
						),
					),
				),
				array(
					'control' => array(
						'control_type' => 'CB_Customize_Misc_Control',
						'type'         => 'group-title',
						'label'        => __( 'Inhalt', 'social-portal' ),
					),
				),
				cb_get_background_image_group_definitions( 'widget', array(
					'background-image' => false,
					'background-color' => true,
					'color'            => true,
					'link'             => true,
					'link-hover'       => true,
					'border'           => false,
				) )
			)
		);

		/**
		 * Footer
		 */
		$background_sections['styling-footer'] = array(
			'panel'   => $panel,
			'title'   => __( 'Fusszeile', 'social-portal' ),
			'options' => cb_get_background_image_group_definitions( 'footer', array(
				'background-image' => true,
				'background-color' => true,
				'color'            => true,
				'link'             => true,
				'link-hover'       => true,
				'border'           => false,
			) ),
		);

		$background_sections['styling-footer-top'] = array(
			'panel'   => $panel,
			'title'   => __( 'Fußzeilen-Widget-Bereich', 'social-portal' ),
			'options' => cb_get_background_image_group_definitions( 'footer-top', array(
				'background-image' => true,
				'background-color' => true,
				'color'            => true,
				'link'             => true,
				'link-hover'       => true,
				'border'           => false,
			) ),
		);

		$background_sections['styling-site-copyright'] = array(
			'panel'   => $panel,
			'title'   => __( 'Copyright-Bereich der Website', 'social-portal' ),
			'options' => cb_get_background_image_group_definitions( 'site-copyright', array(
				'background-image' => false,
				'background-color' => true,
				'color'            => true,
				'link'             => true,
				'link-hover'       => true,
				'border'           => false,
			) ),
		);

		$login_settings = array();
		$login_settings['login-page-text-title'] = array(
			'control' => array(
				'control_type' => 'CB_Customize_Misc_Control',
				'type'         => 'group-title',
				'label'        => __( 'Login Seite', 'social-portal' ),
			),
		);

		//Login Page
		$login_settings1 = cb_get_typography_group_definitions( 'login', __( 'Schrift', 'social-portal' ) );

		$login_settings['login-page-mask-color'] = cb_get_background_color_definition( array(
			'default'       => cb_get_default( 'login-page-mask-color' ),
			'label'         => __( 'Maskenfarbe', 'social-portal' ),
			'description'   => __( 'Farbe zum Maskieren des Hintergrunds der Anmeldeseite', 'social-portal' ),
		) );

		$login_settings_bg = cb_get_background_image_group_definitions( 'login', array(
			'background-image' => true,
			'background-color' => true,
			'color'            => true,
			'link'             => true,
			'link-hover'       => true,
			'border'           => false,
		) );

		$login_settings = array_merge( $login_settings, $login_settings1, $login_settings_bg );

		$login_settings['login-box-text-title'] = array(
			'control' => array(
				'control_type' => 'CB_Customize_Misc_Control',
				'type'         => 'group-title',
				'label'        => __( 'Login Box', 'social-portal' ),
			),
		);

		$login_box_bg = cb_get_background_image_group_definitions( 'login-box', array(
			'background-image' => false,
			'background-color' => true,
			'color'            => false,
			'link'             => false,
			'link-hover'       => false,
			'border'           => true,
		) );

		$login_settings = array_merge( $login_settings, $login_box_bg );

		//Logo link/hover
		$login_settings['login-input-text-logo-title'] = array(
			'control' => array(
				'control_type' => 'CB_Customize_Misc_Control',
				'type'         => 'group-title',
				'label'        => __( 'Seitenname', 'social-portal' ),
				'description'  => __( 'Webseitenname auf der Anmeldeseite', 'social-portal' ),
			),
		);

		$login_settings = array_merge( $login_settings, cb_get_typography_group_definitions( 'login-logo', __( 'Titel', 'social-portal' ) ) );
		$login_settings = array_merge( $login_settings, cb_get_image_definitions( 'login-logo', __( 'Login Logo', 'social-portal' ) ) );

		$login_settings = array_merge( $login_settings, cb_get_background_image_group_definitions( 'login-logo', array(
			'background-image' => false,
			'background-color' => false,
			'color'            => false,
			'link'             => true,
			'link-hover'       => true,
			'border'           => false,
		) ) );

		//Logo link/hover
		$login_settings['login-input-text-title'] = array(
			'control' => array(
				'control_type' => 'CB_Customize_Misc_Control',
				'type'         => 'group-title',
				'label'        => __( 'Textfeld eingeben', 'social-portal' ),
			),
		);
		$login_settings    = array_merge( $login_settings, cb_get_background_image_group_definitions( 'login-input', array(
			'background-image' => false,
			'background-color' => true,
			'color'            => true,
			'link'             => false,
			'link-hover'       => false,
			'border'           => true,
		) ) );
		//Logo link/hover
		$login_settings['login-input-text-focus-title'] = array(
			'control' => array(
				'control_type' => 'CB_Customize_Misc_Control',
				'type'         => 'group-title',
				'label'        => __( 'Fokus des Textfelds', 'social-portal' ),
			),
		);

		//focus
		$login_settings = array_merge( $login_settings, cb_get_background_image_group_definitions( 'login-input-focus', array(
			'background-image' => false,
			'background-color' => true,
			'color'            => true,
			'link'             => false,
			'link-hover'       => false,
			'border'           => true,
		) ) );
		//placeholder
		$login_settings['login-input-placeholder-color'] = cb_get_color_definition( array(
			'default' => cb_get_default( 'login-input-placeholder-color' ),
			'label'   => __( 'Platzhalterfarbe eingeben', 'social-portal' )
		) );

		//button
		$login_settings = array_merge( $login_settings, cb_get_button_style_definition( 'login-submit-button', __( 'Senden-Schaltfläche', 'social-portal' ) ) );

		$background_sections['styling-site-wp-login'] = array(
			'panel'   => $panel,
			'title'   => __( 'Login Seite', 'social-portal' ),
			'options' => $login_settings
		);

		$background_sections = apply_filters( 'cb_customizer_styling_sections', $background_sections );

		return $background_sections;
	}

}//end of class
//init
new CB_Style_Panel_Helper();

