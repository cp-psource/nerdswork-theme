<?php
/**
 * @package social-portal
 * Customizer Layout panel
 * 
 */

//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class CB_Layout_Panel_Helper{

	private $panel =  'cb_layout';
	
	public function __construct() {
		add_filter( 'cb_customizer_sections', array( $this, 'add_sections' ) );
	}
	
	public function add_sections( $sections ) {
		
		//get all sections here
		//merge and return
		
		$new_sections = $this->get_sections();
		
		return array_merge( $sections, $new_sections );
	}

	public function get_sections() {
		
		$panel = $this->panel;
		
		$layout_sections = array();

		/**
		 * Global
		 */
		$layout_sections['layout-global'] = array(
			'panel'   => $panel,
			'title'   => __( 'Global', 'social-portal' ),
			'options' => array(
				'theme-layout'                => array(
					'setting' => array(
						'sanitize_callback'     => 'cb_sanitize_setting_choice',
						//'transport'           => 'postMessage'
						'default'			    => cb_get_default( 'theme-layout' ) //,
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Control_Layout',
						'label'			=> __( 'Seitenlayout', 'social-portal' ),
						'description'	=> __( 'Allgemeines Seiten-Layout. Du kannst einzelne Seiten im Seitenbearbeitungsbildschirm überschreiben.', 'social-portal' ),
					),
				),
				'layout-style'                => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage'
						'default'			  => cb_get_default( 'layout-style' ),
					),
					'control' => array(
						'control_type' 			=> 'CB_Customize_Control_Box_Layout',
						'label'   				=> __( 'Layoutstil', 'social-portal' ),
						'description'			=> __( 'Allgemeiner Seiten-Layout-Stil. Standard ist Boxed.', 'social-portal' ),
					),
				),
				'content-width'                => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_float',
						'transport'         => 'postMessage',
						'default'			=> cb_get_default( 'content-width' ),
					),
					'control' => array(
						'control_type' => 'CB_Customize_Range_Control',
						'input_attrs' => array(
							'min'	=> 30,
							'max'	=> 100,
							'step'	=> 1,
						),
						
						'label'			=> __( 'Inhaltsbreite (in %)', 'social-portal' ),
						'description'	=> __( 'Breite des Inhaltsbereichs in Prozent der gesamten Seitenbreite.', 'social-portal' ),
					),
				),
				'hide-admin-bar'                => array(
					'setting' => array(
						'default'			=> cb_get_default( 'hide-admin-bar' ),
					),
					'control' => array(
						'type'			=> 'checkbox',
						'input_attrs'	=> array(
						),
						'label'			=> __( 'WordPress Admin-Leiste ausblenden?', 'social-portal' ),
						'description'	=> __( 'Standardmäßig ist die Admin-Leiste ausgeblendet.', 'social-portal' ),
					),
				),

				'panel-left-user-scope'     => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'default'			=> cb_get_default( 'panel-left-user-scope' ),
						'transport'			=> 'postMessage',
					),
					'control' => array(
						'type'			=> 'select',
						'choices'		=> cb_get_setting_choices( 'panel-left-user-scope' ),
						'label'			=> __( 'Sichtbarkeit linkes Panel', 'social-portal' ),
						'description'   => __( 'Panel anzeigen für?', 'social-portal' ),

					),
				),
				'panel-left-visibility'     => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'default'			=> cb_get_default( 'panel-left-visibility' ),
						'transport'			=> 'postMessage',
					),
					'control' => array(
						'type'			=> 'select',
						'choices'		=> cb_get_setting_choices( 'panel-left-visibility' ),
						'label'			=>'',// __( 'Panel Visibility', 'social-portal' ),
						'description'   => __( 'Sichtbarkeit.', 'social-portal' ),

					),
				),
				'panel-right-user-scope'                => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'default'			=> cb_get_default( 'panel-right-user-scope' ),
						'transport'			=> 'postMessage',
					),
					'control' => array(
						'type'			=> 'select',
						'choices'		=> cb_get_setting_choices( 'panel-right-user-scope' ),
						'label'			=> __( 'Sichtbarkeit rechtes Panel', 'social-portal' ),
						'description'   => __( 'Panel anzeigen für?', 'social-portal' ),

					),
				),

				'panel-right-visibility'                => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'default'			=> cb_get_default( 'panel-right-visibility' ),
						'transport'			=> 'postMessage',
					),
					'control' => array(
						'type'			=> 'select',
						'choices'		=> cb_get_setting_choices( 'panel-right-visibility' ),
						'label'			=> '',// __( 'Show Right Panel?', 'social-portal' ),
						'description'   => __( 'Sichtbarkeit.', 'social-portal' ),

					),
				),
				
				'home-layout'				=> array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage'
						'default'			=> cb_get_default( 'home-layout' )
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Control_Page_Layout',
						'label'			=> __( 'Layout Startseite', 'social-portal' ),
						'description'	=> __( 'Wähle das Layout für die Startseite.', 'social-portal' ),
					),
				),
								
				'archive-layout' => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage',
						'default'           => cb_get_default( 'archive-layout' )
					),
					'control' => array(
						'control_type'  => 'CB_Customize_Control_Page_Layout',
						'label'         => __( 'Seitenlayout Archiv', 'social-portal' ),
						'description'   => __( 'Wähle das Layout für die Archivseite.', 'social-portal' ),
					),
				),
				'search-layout'				=> array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage'
						'default'			=> cb_get_default( 'search-layout' )
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Control_Page_Layout',
						'label'			=> __( 'Suchergebnis Seitenlayout', 'social-portal' ),
						'description'	=> __( 'Wähle das Layout für die Suchergebnisseite.', 'social-portal' ),
					),
				),
				'404-layout'				=> array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage'
						'default'			=> cb_get_default( '404-layout' )
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Control_Page_Layout',
						'label'			=> __( '404 Seitenlayout', 'social-portal' ),
						'description'	=> __( 'Wähle das Layout für die 404-Seite.', 'social-portal' ),
					),
				),
			),
		);

		/**
		 * Header
		 */
		$layout_sections['header'] = array(
			'panel'   => $panel,
			'title'   => __( 'Header', 'social-portal' ),
			'options' => array(

				'header-layout'             => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'default'			=> cb_get_default( 'header-layout' ),
					),
					'control' => array(
						'label'             => __( 'Header Layout', 'social-portal' ),
						'control_type'      => 'CB_Customize_Control_Header_Layout',
						//'type'            => 'radio',
					),
				),

				'header-layout-group-title' => array(
					'control' => array(
						'control_type'  => 'CB_Customize_Misc_Control',
						'label'         => __( 'Extra Einstellungen', 'social-portal' ),
						'type'          => 'group-title',
					),
				),
				'header-show-login-links'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'default'	        => cb_get_default( 'header-show-login-links' ),
					),
					'control' => array(
						'label'			    => __( 'Login/Register Link anzeigen', 'social-portal' ),
						'description'	    => __( 'Wenn Du dies aktivierst, wird im Header eine Anmelde-/Registrierungsschaltfläche für nicht angemeldete Benutzer hinzugefügt.', 'social-portal' ),
						'type'			    => 'checkbox',
						'std'			    => 1,
                        'active_callback'   => 'cb_is_bp_active',
					),
				),
                'header-show-notification-menu' => array(
                    'setting' => array(
                        'sanitize_callback' => 'cb_sanitize_setting_choice',
                        'default'			=> cb_get_default( 'header-show-notification-menu' ),
                    ),
                    'control' => array(
                        'label'			    => __( 'Benachrichtigungsmenü anzeigen', 'social-portal' ),
                        'description'	    => __( 'Wenn Du dies aktivierst, wird ein Dropdown-Menü für Benachrichtigungen für angemeldete Benutzer hinzugefügt.', 'social-portal' ),

                        'type'			    => 'checkbox',
                        'std'			    => 1,
                        'active_callback'   => 'cb_is_bp_active',
                    ),
                ),

                'header-show-account-menu' => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						'default'			=> cb_get_default( 'header-show-account-menu' ),
					),
					'control' => array(
						'label'			    => __( 'Konto-Menü anzeigen', 'social-portal' ),
						'description'	    => __( 'Wenn Du dies aktivierst, wird das Dropdown-Menü Konto für angemeldete Benutzer hinzugefügt.', 'social-portal' ),
						
						'type'			    => 'checkbox',
						'std'			    => 1,
                        'active_callback'   => 'cb_is_bp_active',
					),
				),

				'header-show-search' => array(
					'setting' => array(
						'sanitize_callback'	=> 'absint',
						'default'			=> cb_get_default( 'header-show-search' ),
					),
					'control' => array(
						'label'				=> __( 'Suchfeld anzeigen?', 'social-portal' ),
						'description'       => __( 'Mit dieser Option kannst Du die Sichtbarkeit des Suchformulars in der Kopfzeile umschalten.', 'social-portal' ),
						'type'				=> 'checkbox',
						'std'				=> 1,
						'active_callback'   => 'cb_is_header_search_available',
					),
				),

				'dashboard-link-capability' => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_capability',
						'default'			=> cb_get_default( 'dashboard-link-capability' ),
					),
					'control' => array(
						'label'			    => __( 'Berechtigung für Dashboard-Verknüpfung.', 'social-portal' ),
						'description'	    => __( 'Benutzern mit dieser Funktion oder höher wird der Dashboard-Link im Konto-Dropdown-Menü angezeigt.', 'social-portal' ),

						'type'			    => 'text',
                        'active_callback'   => 'cb_is_header_account_menu_visible',
					),
				),

				'sites-link-capability' => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_capability',
						'default'			=> cb_get_default( 'sites-link-capability' ),
					),
					'control' => array(
						'label'			    => __( 'Berechtigung für Seiten-Menü.', 'social-portal' ),
						'description'	    => __( 'Benutzern mit dieser Funktion oder höher werden die Seiten-Links im Konto-Dropdown-Menü angezeigt.', 'social-portal' ),

						'type'			    => 'text',
                        'active_callback'   => 'cb_is_sites_menu_available',
					),
				),

				'header-show-social' => array(
					'setting' => array(
						'sanitize_callback'	=> 'absint',
						'default'			=> cb_get_default( 'header-show-social' ),
					),
					'control' => array(
						'label'				=> __( 'Soziale Symbole anzeigen', 'social-portal' ),
						'type'				=> 'checkbox',
						'std'				=> 1,
					),
				),				
				'header-social-icon-font-size'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'transport'			=> 'postMessage',
						'default'			=> cb_get_default( 'header-social-icon-font-size' ),
					),
					'control' => array(
						'control_type'  => 'CB_Customize_Range_Control',
						'label'         => __( 'Symbolgröße (px)', 'social-portal' ),
						'type'          => 'range',
						'input_attrs'   => array(
							'min'  => 12,
							'max'  => 100,
							'step' => 1,
						),
					),
				),
			),
		);

		/**
		 * Footer
		 */
		$layout_sections['footer'] = array(
			'panel'     => $panel,
			'title'     => __( 'Footer', 'social-portal' ),
			'options'   => array(
				
				'footer-widget-areas' => array(
					'setting' => array(
						'sanitize_callback'	=> 'cb_sanitize_setting_choice',
						'default'			=> cb_get_default(  'footer-widget-areas' ),
					),
					'control' => array(
						'control_type'      => 'CB_Customize_Radio_Control',
						'label'				=> __( 'Anzahl der Widget-Bereiche', 'social-portal' ),
						'type'				=> 'radio',
						'mode'              => 'buttonset',
						'choices'			=> cb_get_setting_choices( 'footer-widget-areas' ),
					),
				),
				
				'footer-text' => array(
					'setting' => array(
						'sanitize_callback'	=> 'cb_sanitize_text',
						'transport'			=> 'postMessage',
                        'default'           => cb_get_default( 'footer-text' ),
					),
					'control' => array(
						'label'				=> __( 'Footer Copyright Text', 'social-portal' ),
						'description'		=> __( 'z.B. Copyright 2010-2028, YourAwesomeCompany.com. Du kannst anstelle des aktuellen Jahres auch [current-year] im Text verwenden.', 'social-portal' ),
						'type'				=> 'textarea',
					),
				),
				
				'footer-show-social' => array(
					'setting' => array(
						'sanitize_callback'	=> 'absint',
						'default'			=> cb_get_default( 'footer-show-social' ),
					),
					'control' => array(
						'label'				=> __( 'Soziale Symbole anzeigen', 'social-portal' ),
						'type'				=> 'checkbox',
						'std'				=> 1,
					),
				),
				'footer-social-icon-font-size'     => array(
					'setting' => array(
						'sanitize_callback' => 'absint',
						'transport'			=> 'postMessage',
						'default'			=> cb_get_default( 'footer-social-icon-font-size' ),
					),
					'control' => array(
						'control_type'  => 'CB_Customize_Range_Control',
						'label'		    => __( 'Symbolgröße (px)', 'social-portal' ),
						'type'		    => 'range',
						'input_attrs'   => array(
							'min'  => 12,
							'max'  => 100,
							'step' => 1,
						),
					),
				),
			),
		);

		return apply_filters( 'cb_customizer_layout_sections', $layout_sections );
	}
	
}//end of class

new CB_Layout_Panel_Helper();
