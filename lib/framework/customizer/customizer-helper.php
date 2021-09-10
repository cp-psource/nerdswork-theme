<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}
/**
 * Initializes Customizer control/settings etc
 * 
 */
class CB_Customizer_Helper {
	/**
	 * @var string url to theme directory with trailing slash
	 */
	private $url = '';
	private $path = '';
	
	private $theme_prefix = 'cb_';
	private $customize = '';
	
	private $panel_priority;
    private $current_theme_slug = '';
    private $color_scheme = '';
	/**
	 * Option saved in the database
	 * 
	 * @var string
	 */
	private $setting_key = 'social-portal';//this is the option that will be stored in db with all settings use get_option( 'social-portal') to access it
	
	public function __construct() {
		
		$this->url = combuilder()->get_url() . '/';
		$this->path = combuilder()->get_path() . '/';
		
		$this->setup();
	}
	
	
	public function setup() {
		
		//load our custom controls
		add_action( 'customize_register', array( $this, 'load_custom_controls' ), 0 );
		//register panels, sections, settings, controls
		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'customize_register', array( $this, 'reorder_core_controls' ), 100 );
		
		//load custom js/css, In future, we will just register on these actions let the individual controls load them
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register_scripts' ), 0 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'register_styles' ),  0 );

		//load our own customizer preview js
		add_action( 'customize_preview_init', array( $this, 'load_preview_js' ) );
		
		add_action( 'wp_ajax_customizer_reset', array( $this, 'reset_settings' ) );
		add_action( 'wp_ajax_cb_set_preview_theme_style', array( $this, 'set_preview_theme_style' ) );

		add_action( 'customize_save_after', array( $this, 'font_cleanup' ) );

	}


	
	public function load_custom_controls( $wp_customize ) {
		/**
		 * These custom Controls are mostly based on the Work done by Justin Tadlock from ThemeHybrid
		 * and the ThemeFoundry.com's Make theme
		 */
		
		$path = $this->path . 'lib/framework/customizer/';

		require_once( $path . 'customize-functions.php' );
		require_once( $path . 'customize-sanitization-functions.php' );
		//dependency
		require_once( $path . 'customize-priority.php' );
		//load default choices

		//google font helper
		require_once( $path . 'google-fonts.php' );
		require_once( $path . 'customize-hooks.php' );

		// Load customize setting classes.
		//keeping for future, we don't need these custom setting type yet
		//require_once( $path . 'settings/setting-array-map.php'  );
		//require_once( $path . 'settings/setting-image-data.php' );

		// Load customize control classes.
        require_once( $path . 'controls/control-alpha-color.php' );
		require_once( $path . 'controls/control-checkbox-multiple.php' );
		//we are not using dropdown terms, let us keep it to allow child theme use it in future?
		require_once( $path . 'controls/control-dropdown-terms.php' );
		require_once( $path . 'controls/control-palette.php' );
		//we use radio image for layout
		require_once( $path . 'controls/control-radio-image.php'  );
		require_once( $path . 'controls/control-select-group.php' );
		require_once( $path . 'controls/control-select-multiple.php' );
		require_once( $path . 'controls/control-layout.php' );
		require_once( $path . 'controls/control-header-layout.php' );
		require_once( $path . 'controls/control-page-layout.php' );
		require_once( $path . 'controls/control-box-layout.php' );
		
		
		require_once( $path . 'controls/control-image.php' );
		require_once( $path . 'controls/control-background-position.php' );
		require_once( $path . 'controls/control-radio.php' );
		require_once( $path . 'controls/control-range.php' );
		
		require_once( $path . 'controls/control-misc.php' );
		require_once( $path . 'controls/control-title.php' );
		require_once( $path . 'controls/control-plain-text.php' );
		require_once( $path . 'controls/control-typography.php' );
		require_once( $path . 'controls/control-border.php' );

		// Register control types.
		$wp_customize->register_control_type( 'CB_Customize_Control_Checkbox_Multiple' );
		$wp_customize->register_control_type( 'CB_Customize_Control_Palette' );
		$wp_customize->register_control_type( 'CB_Customize_Control_Radio_Image' );
		$wp_customize->register_control_type( 'CB_Customize_Control_Layout' );
		$wp_customize->register_control_type( 'CB_Customize_Control_Header_Layout' );
		$wp_customize->register_control_type( 'CB_Customize_Control_Page_Layout' );
		$wp_customize->register_control_type( 'CB_Customize_Control_Box_Layout' );
		$wp_customize->register_control_type( 'CB_Customize_Control_Select_Group' );
		$wp_customize->register_control_type( 'CB_Customize_Control_Select_Multiple' );
		$wp_customize->register_control_type( 'CB_Customize_Control_Typography' );
		$wp_customize->register_control_type( 'CB_Customize_Control_Border' );


	}
	
	/***
	 * This is where all starts
	 * 
	 */
	public function customize_register( $wp_customize ) {
		
		$this->customize = $wp_customize;
		$path = $this->path . 'lib/framework/customizer/';
		//general customizer panel 
		require_once( $path . 'panels/general.php' );
		//layout customizer panel
		require_once( $path . 'panels/layout.php' );
		//typography panel
		require_once( $path . 'panels/typography.php' );
		//background panel
		require_once( $path . 'panels/styling.php' );

		//color scheme panel
		//require_once( $path . 'panels/theme-style.php' );
		//blog panel
		require_once( $path . 'panels/blog.php' );

		if ( cb_is_wc_active() ) {
			require_once( $path . 'panels/woocommerce.php' );
		}
		//BuddyPress panel
		require_once( $path . 'panels/buddypress.php' );
		//Advance Settings panel
		require_once( $path . 'panels/settings-advance.php' );
		
				
		$this->add_panels( $wp_customize );
		
		//move core WordPress Sections under various panels
		
		//add logo option under site identity section if < wp 4.5.0
		if ( ! function_exists( 'get_custom_logo' ) ) {
			$this->add_logo_option( $wp_customize );
		}

		$this->add_site_background_color( $wp_customize );
		$this->add_headers( $wp_customize );

		//finally add our section
		$this->add_sections( $wp_customize );

		// Abort if selective refresh is not available.
		if ( ! isset( $wp_customize->selective_refresh ) ) {
			return;
		}

		$wp_customize->selective_refresh->add_partial( 'custom_logo', array(
			'settings'            => array( 'custom_logo' ),
			'selector'            => '#logo',
			'render_callback'     => array( $this, '_render_custom_logo_partial' ),
			'container_inclusive' => false,
		) );

		
	}

	public function _render_custom_logo_partial() {
		ob_start();
		cb_site_branding_content();
		return ob_get_clean();
	}

	/**
	 * Add customizer panels
	 * 
	 * @param type $wp_customize
	 */
	public function add_panels( $wp_customize ) {
		
		$theme_prefix = $this->theme_prefix;
		$priority = new CB_Cutomizer_Prioritizer( 1000, 100 );
		
		//get panels
		$panels = $this->get_panels();

		// Add panels
		foreach ( $panels as $panel => $data ) {
			//if priority is not se, add
			if ( ! isset( $data['priority'] ) ) {
				$data['priority'] = $priority->add();
			}
			// Add panel
            // cb_general , cb_layout,cb_buddypress, cb_wc and so on
			$wp_customize->add_panel( $theme_prefix . $panel, $data );
		}
		
		$this->panel_priority = $priority;

	}
	
	/**
	 * Add sections to various panels
	 * 
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function add_sections( $wp_customize ) {
	
		$theme_prefix = $this->theme_prefix;
	
		$panels       = $this->get_panels();
		$sections = $this->get_sections();
		// array of Priority object for each panel
		$priority = array();
		
		foreach ( $sections as $section => $data ) {
			$options = array();
			// Get the non-prefixed ID of the current section's panel
			$panel = ( isset( $data['panel'] ) ) ? str_replace( $theme_prefix, '', $data['panel'] ) : 'none';

			// save option for later use
			if ( isset( $data['options'] ) ) {
				$options = $data['options'];
				unset( $data['options'] );
			}

			// Determine the priority
			if ( ! isset( $data['priority'] ) ) {
				
				$panel_priority = ( 'none' !== $panel && isset( $panels[ $panel ]['priority'] ) ) ? $panels[ $panel ]['priority'] : 1000;

				// Create a separate priority counter for each panel, and one for sections without a panel
				if ( ! isset( $priority[ $panel ] ) ) {
					$priority[ $panel ] = new CB_Cutomizer_Prioritizer( $panel_priority, 10 );
				}

				$data['priority'] = $priority[ $panel ]->add();
			}

			// Register section
			$wp_customize->add_section( $theme_prefix . $section, $data );

			// Add options to the section if available
			if ( ! empty( $options ) ) {

				$this->add_section_options( $theme_prefix . $section, $options );
				unset( $options );
			}
			
		}
	}
	
	/**
	 * Move various WordPress registered sections to our panel
	 * 
	 * @param WP_Customize_Manager $wp_customize
	 */
	public function reorder_core_controls( $wp_customize ) {
		
		$theme_prefix = $this->theme_prefix;
		
		//move to general panel
		$wp_customize->get_section( 'title_tagline' )->panel = $theme_prefix . 'general';
		$wp_customize->get_section( 'static_front_page' )->panel = $theme_prefix . 'general';
		$wp_customize->get_section( 'static_front_page' )->priority = 90;

		if ( function_exists( 'wp_update_custom_css_post' ) ) {
			$wp_customize->get_section( 'custom_css' )->panel = $theme_prefix . 'styling';
			$wp_customize->get_section( 'custom_css' )->priority = 9879;//too low,
			// there is no logic in it if you are thinking why we selected this priority
		}

		$wp_customize->get_section( 'header_image' )->title = __( 'Seiten Header', 'social-portal' );
		$wp_customize->get_section( 'header_image' )->priority = 10;//__( 'Page Header', 'social-portal' );
		$wp_customize->get_section( 'background_image' )->title = __( 'Seiten-Hintergrund', 'social-portal' );
		$wp_customize->get_section( 'background_image' )->priority = 5;// __( 'Site Background', 'social-portal' );
		
		// Move colors & headers to background panel
		$wp_customize->remove_section( 'colors' );//->panel = $theme_prefix .'styling';
		$wp_customize->remove_setting( 'display_header_text' );//->panel = $theme_prefix .'styling';
		
		$wp_customize->get_section( 'header_image' )->panel = $theme_prefix . 'styling';
		$wp_customize->get_section( 'background_image' )->panel = $theme_prefix .'styling';
		
		// Change transport
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		// Logo
		// $wp_customize->get_setting( 'custom_logo' )->transport        = 'postMessage';

		$wp_customize->get_setting( 'header_image' )->transport    = 'postMessage';
		
		if ( ! isset( $wp_customize->get_panel( 'nav_menus' )->priority ) ) {
			$wp_customize->add_panel( 'nav_menus' );
		}
		
		$priority = $this->panel_priority;
		
		$wp_customize->get_panel( 'nav_menus' )->priority = $priority->add();
		
		if ( ! isset( $wp_customize->get_panel( 'widgets' )->priority ) ) {
			$wp_customize->add_panel( 'widgets' );
		}
		
		$wp_customize->get_panel( 'widgets' )->priority = $priority->add();
		$wp_customize->get_panel( 'widgets' )->title = __( 'Seitenleisten & Widgets', 'social-portal' );
		
		// Enable post message
		foreach ( array( 'color', 'image', 'position_x', 'repeat', 'attachment' ) as $prop ) {
				$wp_customize->get_setting( 'background_' . $prop )->transport = 'postMessage';
		}

	}
	/**
	 * Get an array of panels to add
	 * 
	 * @return array
	 * 
	 */
	public function get_panels() {
		
		$panels = array(
			'general'           => array( 'title' => __( 'Allgemeines', 'social-portal' ), 'priority' => 100 ),
			'layout'			=> array( 'title' => __( 'Layout', 'social-portal' ), 'priority' => 200 ),
			'typography'        => array( 'title' => __( 'Typografie', 'social-portal' ), 'priority' => 300 ),
			//'theme-style'      => array( 'title' => __( 'Color', 'social-portal' ), 'priority' => 400 ),
			'styling'			=> array( 'title' => __( 'Styling', 'social-portal' ), 'priority' => 500 ),
			'blog' 				=> array( 'title' => __( 'Blog', 'social-portal' ), 'priority' => 550 ),
			'wc' 				=> array( 'title' => __( 'Shop', 'social-portal' ), 'priority' => 560 ),
			'bp' 				=> array(
                'title'				=> __( 'BuddyPress', 'social-portal' ),
                'priority'			=> 600,
                'active_callback'	=> 'cb_is_bp_active',
                ),
			'setting-advance' 	=> array( 
				'title'		=> __( 'Erweiterte Einstellungen', 'social-portal' ), 
				'priority'	=> 650 
			),

			
		);

		return apply_filters( 'cb_customizer_panels', $panels );
		
	}
	
	/**
	 * Get all sections
	 * 
	 * We allow other modules to hook and build the list
	 * see files in library/customizer/panels to see how we are using it
	 * 
	 * @return array
	 */
	public function get_sections() {
		
		$sections = apply_filters( 'cb_customizer_sections', array() );//give child theme opportunity to register their own
		
		return $sections;
	}

    /**
     * Register settings for each section
     *
     * @param $section
     * @param $args
     * @param int $initial_priority
     * @return int
     */
	private function add_section_options( $section, $args, $initial_priority = 100 ) {

		global $wp_customize;

		$priority = new CB_Cutomizer_Prioritizer( $initial_priority, 5 );

		
		foreach ( $args as $setting_id => $option ) {
			
			$setting_key = $setting_id;//this will be setting

			// Add setting
			if ( isset( $option['setting'] ) ) {

				$defaults = array(
					'type'                 => 'theme_mod',//option
					'capability'           => 'edit_theme_options',
					'theme_supports'       => '',
					'default'              => '',
					'transport'            => 'refresh',//'postMessage'
					'sanitize_callback'    => '',
					'sanitize_js_callback' => '',
				);

				$setting = wp_parse_args( $option['setting'], $defaults );
				
				if ( $setting['type'] == 'option' ) {
					//not using theme mod?
					$setting_key = $this->setting_key . '[' . $setting_key . ']';//builds settings name like social-portal[xyz] 
				}

				// Add the setting arguments inline so Theme Check can verify the presence of sanitize_callback
				$wp_customize->add_setting( $setting_key, array(
					'type'                 => $setting['type'],
					'capability'           => $setting['capability'],
					'theme_supports'       => $setting['theme_supports'],
					'default'              => $setting['default'],
					'transport'            => $setting['transport'],
					'sanitize_callback'    => $setting['sanitize_callback'],
					'sanitize_js_callback' => $setting['sanitize_js_callback'],
				) );
			}


			// Add control
			if ( isset( $option['control'] ) ) {
				
				$control_id =  $setting_key;

				$defaults = array(
					'settings' => $setting_key,
					'section'  => $section,
					'priority' => $priority->add(),
				);

				if ( ! isset( $option['setting'] ) ) {
					unset( $defaults['settings'] );
				}

				$control = wp_parse_args( $option['control'], $defaults );
				
				// Check for a specialized control class
				if ( isset( $control['control_type'] ) ) {
					$control_type = $control['control_type'];
					//check if the control_type is a subclass of WP_Customize_Control

					if ( is_subclass_of( $control_type, 'WP_Customize_Control' ) ) {
						unset( $control['control_type'] );
						// Dynamically generate a new class instance
						$class_instance = new $control_type( $wp_customize, $control_id, $control  );
						$wp_customize->add_control( $class_instance );
					}

				} else {
					$wp_customize->add_control( $control_id, $control );
				}
			}
		}

		return $priority->get();
	}
	
	/**
	 * Adds community builder logo section to site identity section
	 * 
	 * @param type $wp_customize
	 */
	public function add_logo_option( $wp_customize ) {
		
				//add logo to the title_tagline section
		$wp_customize->add_setting( 'logo', array(
			'type'              => 'theme_mod',
			'capability'        => 'manage_options',
			'transport'         => 'postMessage', // Previewed with JS in the Customizer controls window.
			'sanitize_callback' => 'esc_url_raw'
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
			'label'			=> __( 'Seiten Logo', 'social-portal' ),
			'description'	=> __( 'Das Logo wird im Seiten-Header verwendet. Maximale Breite: 325px, maximale Höhe: 60px', 'social-portal' ),
			'section'		=> 'title_tagline',
			'mime_type'		=> 'image',
			'priority'		=> 70,
			//'height'		=> 512,
			//'width'			=> 512,
		) ) );

	}

    public function add_site_background_color( $wp_customize ) {
        $wp_customize->add_setting( 'background-color', array(
            'type'       => 'theme_mod',
            'capability' => 'manage_options',
            'transport'  => 'postMessage', // Previewed with JS in the Customizer controls window.
            'default'   => cb_get_default( 'background-color' ),
	        'sanitize_callback' => 'cb_sanitize_rgba'
        ) );

        $wp_customize->add_control( new CB_Customize_Control_Alpha_Color( $wp_customize, 'background-color', array(
            'label'			=> __( 'Hintergrundfarbe', 'social-portal' ),
            'description'	=> '',
            'section'		=> 'background_image',
            'priority'		=> 70,

        ) ) );
    }
    public function add_headers( $wp_customize ) {

        $dim = cb_get_page_header_dimensions();

        $headers = array(

            'archive_header_image'    => array(
                'label'			=> __( 'Archiv Seitenheader', 'social-portal' ),
                'description'	=> sprintf( __( 'Bitte lade ein <strong>%sx%s px</strong> Bild hoch, das für die Archivseite verwendet werden soll.', 'social-portal' ), $dim['width'], $dim['height'] ),
            ),
            'search_header_image'    => array(
                'label'			=> __( 'Suche Seitenheader', 'social-portal' ),
                'description'	=> sprintf( __( 'Bitte lade ein <strong>%sx%s px</strong> Bild hoch, das für den Suchseitenheader verwendet werden soll', 'social-portal' ), $dim['width'], $dim['height'] ),
            ),
            '404_header_image'    => array(
                'label'			=> __( '404 Header', 'social-portal' ),
                'description'	=> sprintf( __( 'Bitte lade ein <strong>%sx%s px</strong> Bild hoch, das für den 404-Seitenheader verwendet werden soll', 'social-portal' ), $dim['width'], $dim['height'] ),
            ),

        );


        $i = 0;
        $this->add_background_color( $wp_customize, array(
            'option_name'   => 'page-header-mask-color',
            'label'         => __( 'Maskenfarbe', 'social-portal' ),
            'description'   => __( 'Wird verwendet, um das Seitenheaderbild zu maskieren', 'social-portal' ),
            'priority'      => 1,
            'default'       => cb_get_default( 'page-header-mask-color' ),

        ) );

	    $this->add_background_color( $wp_customize, array(
            'option_name'   => 'page-header-background-color',
            'label'         => __( 'Hintergrundfarbe', 'social-portal' ),
            'description'   => '',
            'priority'      => 2,
            'default'       => cb_get_default( 'page-header-background-color' ),

        ) );

        $this->add_color( $wp_customize, array(
            'option_name'   => 'page-header-title-text-color',
            'label'         => __( 'Titelfarbe', 'social-portal' ),
            'description'   => '',
            'priority'      => 2,
            'default'       => cb_get_default( 'page-header-title-text-color' ),

        ) );

        $this->add_color( $wp_customize, array(
            'option_name'   => 'page-header-content-text-color',
            'label'         => __( 'Beschreibung Farbe', 'social-portal' ),
            'description'   => '',
            'priority'      => 3,
            'default'       => cb_get_default( 'page-header-content-text-color' ),

        ) );

        $i = 0;
        foreach ( $headers as $option_name => $details ) {
            $i = $i+10;
            $wp_customize->add_setting( $option_name, array(
                'type'              => 'theme_mod',
                'capability'        => 'manage_options',
                'transport'         => 'postMessage', // Previewed with JS in the Customizer controls window.
	            'sanitize_callback' => 'esc_js',
            ) );

            $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $option_name, array(
                'label'			=> $details['label'],
                'description'	=> $details['description'],
                'section'		=> 'header_image',
                'mime_type'		=> 'image',
                'priority'		=> 70 + $i,
                //'height'		=> 512,
                //'width'			=> 512,
            ) ) );
        }
    }



    private function add_background_color( $wp_customize, $args = array() ) {

        $wp_customize->add_setting( $args['option_name'], array(
            'type'              => 'theme_mod',
            'capability'        => 'manage_options',
            'default'           => $args['default'],
            'transport'         => isset( $args['transport'] )  ? $args['transport']: 'postMessage', // Previewed with JS in the Customizer controls window.
	        'sanitize_callback' => 'cb_sanitize_rgba',
        ) );

        $wp_customize->add_control( new CB_Customize_Control_Alpha_Color( $wp_customize, $args['option_name'], array(
            'label'			=> $args['label'],
            'description'	=> $args['description'],
            'section'		=> 'header_image',
            'priority'		=> $args['priority'],

        ) ) );

    }


    private function add_color( $wp_customize, $args = array() ) {

        $wp_customize->add_setting( $args['option_name'], array(
            'type'       => 'theme_mod',
            'capability' => 'manage_options',
            'default'    => $args['default'],
            'transport'  => isset( $args['transport'] )  ? $args['transport']: 'postMessage', // Previewed with JS in the Customizer controls window.
	        'sanitize_callback' => 'maybe_hash_hex_color',
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $args['option_name'], array(
            'label'			=> $args['label'],
            'description'	=> $args['description'],
            'section'		=> 'header_image',
            'priority'		=> $args['priority'],

        ) ) );

    }


	public function register_scripts() {
        $url_base = $this->url . 'lib/framework/customizer/';
		// Custom styling depends on version of WP
		// Nav menu panel was introduced in 4.3
		$suffix = cb_get_min_suffix();
		// Scripts
		
		wp_enqueue_script( 'cb-customize-controls', $url_base . 'assets/js/customize-controls' . $suffix . '.js', array( 'customize-controls' ), null, true );
		wp_enqueue_script( 'cb-alpha-color-picker', $url_base . 'assets/js/alpha-color-picker' . $suffix . '.js', array( 'jquery', 'wp-color-picker' ), null, true );
		wp_enqueue_script( 'cb-selectize',			$url_base . 'assets/js/selectize.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'cb-typography-control', $url_base . 'assets/js/typography.js', array( 'cb-customize-controls' ), null, true );
		wp_enqueue_script( 'cb-border-control',		$url_base . 'assets/js/border-controls.js', array( 'cb-customize-controls' ), null, true );

	
		// Collect localization data
		$data = array(
		      'allFonts'          => cb_get_all_fonts(),
		);

		// Add localization strings
		$localize = array(
		
			'docURL'			        => 'https://n3rds.work/wiki/social-portal-dokumentation/',
			'docLabel'		        	=> esc_html__( 'Theme Dokumentation ', 'social-portal' ),
			'reset'                     => __( 'Zurücksetzen', 'social-portal' ),
			'confirm'                   => __( 'Beachtung! Dadurch werden alle Anpassungen entfernt, die jemals über den Customizer an diesem Thema vorgenommen wurden!\n\nDiese Aktion ist irreversibel!', 'social-portal' ),
			'nonce'                     => array(
				            'reset' => wp_create_nonce( 'customizer-reset' ),
			),
			'customizeURL'          => wp_customize_url(),

		);
		
		$data = $data + $localize;

		// Localize the script
		wp_localize_script(
			'cb-customize-controls',
			'_CBCustomizerL10n',
			$data
		);
	}

	/**
	 * Register customizer controls styles.
	 *
	 */
	public function register_styles() {

        $suffix = '';
        $url_base = $this->url . 'lib/framework/customizer/';

        wp_enqueue_style( 'cb-customizer-jquery-ui', $url_base . 'assets/css/jquery-ui/jquery-ui-1.10.4.custom.css', array(), '1.10.4' );

        wp_enqueue_style( 'cb-customizer-sections', $url_base . "assets/css/customizer-sections{$suffix}.css", array( 'cb-customizer-jquery-ui' ), cb_get_version() );

        wp_register_style( 'cb-customize-controls', $url_base . 'assets/css/customize-controls' . $suffix . '.css' );
        wp_register_style( 'cb-alpha-color-picker', $url_base . 'assets/css/alpha-color-picker' . $suffix . '.css', array( 'wp-color-picker' ) );
        wp_enqueue_style( 'cb-selectize', $url_base . 'assets/css/selectize.css' );
    }
	/**
	 * Load customizer preview js
	 * 
	 */
	public function load_preview_js() {
	    wp_enqueue_script( 'cb-preview-js', $this->url . 'lib/framework/customizer/theme-preview.js', array( 'customize-preview', 'jquery' ) );
	}
	
	public function sanitize_width( $width ) {

		if ( ! is_numeric( $width ) ) {
			return 65;
		}
		
		return $width;
	}

    /**
     * reset to default via ajax
     *
     */
	public function reset_settings() {
			
		if ( ! $this->customize->is_preview() ) {
				wp_send_json_error( 'not_preview' );
		}

		if ( ! check_ajax_referer( 'customizer-reset', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		if ( ! current_user_can( 'edit_themes' ) ) {
			wp_send_json_error( __( 'Unzureichende Berechtigungen.', 'social-portal' ) );
		}
		//reset

		remove_theme_mods();

		wp_send_json_success();
	}


	public function set_preview_theme_style() {

		if ( ! $this->customize->is_preview() ) {
				wp_send_json_error( 'not_preview' );
		}

		if ( ! check_ajax_referer( 'customizer-reset', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		if ( ! current_user_can( 'edit_themes' ) ) {
			wp_send_json_error( __( 'Unzureichende Berechtigungen.', 'social-portal' ) );
		}

		if ( empty( $_POST['theme-style'] ) ) {
		    wp_send_json_error( 'value_not_given' );
        }

        //@todo validate name of the color scheme
        update_option( 'cb-preview-theme-style', trim( $_POST['theme-style'] ) );

		wp_send_json_success();
	}
	
	/**
	 * When the customizer settings are saved, delete the google font uri
	 */
	public function font_cleanup() {
		delete_option( 'cb_google_font' );
		delete_option( 'cb_login_google_font' );
	}
}

new CB_Customizer_Helper();

