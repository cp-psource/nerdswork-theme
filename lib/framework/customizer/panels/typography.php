<?php
/**
 * @package social-portal
 * Customizer Typography Panel
 * 
 */

//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class CB_Typography_Panel_Helper {

	private $panel =  'cb_typography';
	
	public function __construct() {
		//hook to cb customizer
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

		$typography_sections = array();

		/**
		 * Global
		 */
		$typography_sections['base-font'] = array(
			'panel'   => $panel,
			'title'   => __( 'Globale Einstellungen', 'social-portal' ),
			'options' => array_merge(
                cb_get_typography_group_definitions( 'base', __( 'Basis', 'social-portal' ) )
            ) ,

		);

	/**
	 * Text Headers
	 */
	$typography_sections['font-headers'] = array(
		'panel'   => $panel,
		'title'   => __( 'Überschriften', 'social-portal' ),
		'options' => array_merge(
			cb_get_typography_group_definitions( 'h1', __( 'H1', 'social-portal' ) ),
			cb_get_typography_group_definitions( 'h2', __( 'H2', 'social-portal' ) ),
			cb_get_typography_group_definitions( 'h3', __( 'H3', 'social-portal' ) ),
			cb_get_typography_group_definitions( 'h4', __( 'H4', 'social-portal' ) ),
			cb_get_typography_group_definitions( 'h5', __( 'H5', 'social-portal' ) ),
			cb_get_typography_group_definitions( 'h6', __( 'H6', 'social-portal' ) )
		),
	);

	/**
	 * Site Title & Tagline
	 */
	$typography_sections['font-site-title-tagline'] = array(
		'panel'   => $panel,
		'title'   => __( 'Seitentitel &amp; Beschreibung', 'social-portal' ),
		'options' => array_merge(
			cb_get_typography_group_definitions( 'site-title', __( 'Seitentitel', 'social-portal' ) )
			//cb_get_typography_group_definitions( 'site-tagline', __( 'Tagline', 'social-portal' ) )
		),
	);

	/**
	 * Main Navigation
	 */
	$typography_sections['font-main-menu'] = array(
		'panel'   => $panel,
		'title'   => __( 'Hauptmenü', 'social-portal' ),
		'options' => array_merge(
			cb_get_typography_group_definitions( 'main-nav', __( 'Menüelemente', 'social-portal' ) ),
			cb_get_typography_group_definitions( 'sub-nav', __( 'Untermenüelemente', 'social-portal' ) )
		),
	);

	/**
	 * Text Headers
	 */
	$typography_sections['font-page-headers'] = array(
		'panel'   => $panel,
		'title'   => __( 'Seitenkopfzeilen', 'social-portal' ),
		'options' => array_merge(
			cb_get_typography_group_definitions( 'page-header-title', __( 'Titel', 'social-portal' ) ),
			cb_get_typography_group_definitions( 'page-header-content', __( 'Beschreibung', 'social-portal' ) )
		),
	);

	/**
	 * Sidebars
	 */
	$typography_sections['font-sidebar'] = array(
		'panel'   => $panel,
		'title'   => __( 'Sidebars', 'social-portal' ),
		'options' => array_merge(
			cb_get_typography_group_definitions( 'widget-title', __( 'Widget Titel', 'social-portal' ) ),
			cb_get_typography_group_definitions( 'widget', __( 'Widgetinhalt', 'social-portal' ) )
		),
	);

	/**
	 * Footer
	 */
	$typography_sections['font-footer'] = array(
		'panel'   => $panel,
		'title'   => __( 'Footer', 'social-portal' ),
		'options' => array_merge(
			cb_get_typography_group_definitions( 'footer-widget-title', __( 'Widget Titel', 'social-portal' ) ),
			cb_get_typography_group_definitions( 'footer-widget', __( 'Widgetinhalt', 'social-portal' ) ),
			cb_get_typography_group_definitions( 'footer', __( 'Fusszeile', 'social-portal' ) )
		),
	);

	/**
	 * Filter the definitions for the controls in the Typography panel of the Customizer.
	 *
	 * @since 1.0.0.
	 *
	 * @param array    $typography_sections    The array of definitions.
	 */
	$typography_sections = apply_filters( 'cb_customizer_typography_sections', $typography_sections );

	return $typography_sections;
	
	}

}//end of class

new CB_Typography_Panel_Helper();