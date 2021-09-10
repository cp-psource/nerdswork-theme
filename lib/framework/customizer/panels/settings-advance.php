<?php
/**
 * @package social-portal
 * Customizer Advance Settings Panel
 * 
 */

//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class CB_Advance_Settings_Panel_Helper {

	private $panel =  'cb_setting-advance';
	
	public function __construct() {
		add_filter( 'cb_customizer_sections', array( $this, 'add_sections' ) );
	}
	
	public function add_sections( $sections ) {

		$new_sections = $this->get_sections();
		
		return array_merge( $sections, $new_sections );
	}

	public function get_sections() {
		
		$panel = $this->panel;
		$settings_sections = array();

		$settings_sections['setting-misc'] = array(
			'panel'   => $panel,
			'title'   => __( 'Verschiedenes', 'social-portal' ),
			'options' => array(
				'enable-text-widget-shortcode'                => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'transport'         => 'refresh',
						'default'			=> cb_get_default( 'enable-text-widget-shortcode' ),
					),
					'control' => array(
						'type'	=> 'checkbox',
						'input_attrs' => array(
						),
						'label'			=> __( 'Shortcodes in Text-Widgets aktivieren?', 'social-portal' ),
						'description'	=> __( 'Du kannst Shortcodes im Text-Widget verwenden, wenn Du es aktivierst.', 'social-portal' ),
					),
				),

				'enable-editor-style'                => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'transport'         => 'refresh',
						'default'			=> cb_get_default( 'enable-editor-style' ),
					),
					'control' => array(
						'type'	=> 'checkbox',
						'input_attrs' => array(
						),
						'label'			=> __( 'Editorstil aktivieren?', 'social-portal' ),
						'description'	=> __( 'Mit dieser Option kannst Du den Post-Editor-Stil aktivieren/deaktivieren.', 'social-portal' ),
					),
				),

				'enable-textarea-autogrow'                => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'transport'         => 'refresh',
						'default'			=> cb_get_default( 'enable-textarea-autogrow' ),
					),
					'control' => array(
						'type'	=> 'checkbox',
						'input_attrs' => array(
						),
						'label'			=> __( 'Textfeld automatisch wachsen aktivieren?', 'social-portal' ),
						'description'	=> __( 'Wenn Du es aktivierst, wird die Höhe des Textbereichs an den Inhalt angepasst, anstatt Bildlaufleisten anzuzeigen.', 'social-portal' ),
					),
				),
				'disable-main-menu-dropdown-icon' => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'transport'         => 'refresh',
						'default'           => cb_get_default( 'disable-main-menu-dropdown-icon' ),
					),
					'control' => array(
						'type'        => 'checkbox',
						'input_attrs' => array(),
						'label'       => __( 'Dropdown-Anzeigesymbol im Hauptmenü deaktivieren?', 'social-portal' ),
						'description' => __( 'Wenn Du es aktivierst, wird die Dropdown-Anzeige im Hauptmenü nicht angezeigt.', 'social-portal' ),
					),
				),
				'enable-selectbox-styling'                => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'transport'         => 'refresh',
						'default'			=> cb_get_default( 'enable-selectbox-styling' ),
					),
					'control' => array(
						'type'	=> 'checkbox',
						'input_attrs' => array(
						),
						'label'			=> __( 'Selectbox-Styling aktivieren?', 'social-portal' ),
						'description'	=> __( 'Es hilft, die ausgewählten Dropdown-Felder schöner zu gestalten.', 'social-portal' ),
					),
				),
				'selectbox-excluded-selector'                => array(
					'setting' => array(
						'sanitize_callback' => 'esc_js',
						'transport'         => 'refresh',
						'default'			=> cb_get_option( 'selectbox-excluded-selector' ),
					),
					'control' => array(
						'type'	        => 'textarea',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Selectbox-Styling ausschließen?', 'social-portal' ),
						'description'	=> __( 'Füge hier die CSS-Selektoren für die ausgeschlossenen Auswahlfelder ein. Diese werden vom Styling ausgeschlossen.', 'social-portal' ),
					),
				),

			),//end of options
		);


		$settings_sections['asset-loading'] = array(
			'panel'   => $panel,
			'title'   => __( 'Laden von Assets', 'social-portal' ),
			'options' => array(
				'load-fa'                => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'transport'         => 'refresh',
						'default'			=> cb_get_default( 'load-fa' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> __( 'FontAwesome laden?', 'social-portal' ),
						'description'	=> __( 'Lade FontAwesome Css. Du kannst es hier deaktivieren, wenn es bereits von einem anderen Plugin geladen wurde', 'social-portal' ),
					),
				),

				'load-fa-cdn'                => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'transport'         => 'refresh',
						'default'			=> cb_get_default( 'load-fa-cdn' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> __( 'FontAwesome von CDN laden?', 'social-portal' ),
						'description'	=> __( 'Wenn Du dies aktivierst, wird FontAwesome von der Bootstrap-CDN geladen. Wenn Du es deaktivierst, wird es für die lokale Kopie geladen.', 'social-portal' ),
					),
				),
                'load-google-font'           => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'transport'         => 'refresh',
						'default'			=> cb_get_default( 'load-google-font' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
                        'default'       => 1
						),
						'label'			=> __( 'Google Fonts laden?', 'social-portal' ),
						'description'	=> __( 'Wenn Du dies deaktivierst, werden Google Fonts nicht geladen.', 'social-portal' ),
					),
				),
			
			),
		);

		/*$settings_sections['setting-optimizations'] = array(
			'panel'   => $panel,
			'title'   => __( 'Optimizations', 'social-portal' ),
			'options' => array(
				'load_min_css'                => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'transport'         => 'postMessage',
						'default'			=> 0,	
					),
					'control' => array(
						'type'	=> 'checkbox',
						'input_attrs' => array(
						),
						
						'label'			=> __( 'Load Minified CSS?', 'social-portal' ),
						'description'	=> __( 'Load minified css included with the theme. It will improve the load time. Not needed if you are using a plugin that minifies resources.', 'social-portal' ),
					),
				),

				'load_min_js'                => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'transport'         => 'postMessage',
						'default'			=> 0,	
					),
					'control' => array(
						'type'	=> 'checkbox',
						'input_attrs' => array(
							
						),
						
						'label'			=> __( 'Load Minified Javascript?', 'social-portal' ),
						'description'	=> __( 'Load minified javascript included with the theme. It will improve the load time. Not needed if you are using a plugin that minifies resources.', 'social-portal' ),
					),
				),
				
			
			),
		);*/

				
		$settings_sections['setting-misc-scripts'] = array(
			'panel'   => $panel,
			'title'   => __( 'Benutzerdefinierte Skripte & Stile', 'social-portal' ),
			'options' => array(
				'custom-head-js'                => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_custom_js',
						'transport'         => 'refresh',
						'default'			=> '',	
					),
					'control' => array(
						'type'	        => 'textarea',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Benutzerdefinierte Header-Skripte?', 'social-portal' ),
						'description'	=> __( 'Füge ein beliebiges Skript hinzu, das Du Deinemem <head>-Element hinzufügen möchtest.', 'social-portal' ),
					),
				),
				'custom-footer-js'                => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_custom_js',
						'transport'         => 'refresh',
						'default'			=> '',	
					),
					'control' => array(
						'type'	        => 'textarea',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Benutzerdefinierte Fußzeilenskripte?', 'social-portal' ),
						'description'	=> __( 'Füge ein beliebiges Skript hinzu, das Du zur Fußzeile Deiner Seite hinzufügen möchtest. Am besten geeignet für Analysen usw.', 'social-portal' ),
					),
				),
								


			),//end of options
		);

		//only display control if lower than wp 4.7
		if ( ! function_exists( 'wp_update_custom_css_post' ) ) {
			$settings_sections['setting-misc']['options']['custom_css'] =  array(
				'setting' => array(
					'sanitize_callback' => 'cb_sanitize_setting_custom_css',
					'transport'         => 'refresh',
					'default'			=> '',
				),
				'control' => array(
					'type'	        => 'textarea',
					'input_attrs'   => array(
					),
					'label'			=> __( 'Benutzerdefinierte CSS?', 'social-portal' ),
					'description'	=> __( 'Füge hier benutzerdefinierte CSS-Regeln hinzu. Es wird dem Seiten-Header hinzugefügt.', 'social-portal' ),
				),
			);
		}


		return apply_filters( 'cb_customizer_advance_sections', $settings_sections );
	}
	
}//end of class

new CB_Advance_Settings_Panel_Helper();
