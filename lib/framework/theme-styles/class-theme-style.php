<?php

/**
 * Class CB_Theme_Style
 *
 * Represents individual unique Theme Style
 */
class CB_Theme_Style {
	/**
	 * @var string unique id of the theme style
	 */
	private $id;

	/**
	 * @var string label of the style
	 */
	private $label;

	/**
	 * @var string optional relative path to the styelsheet for this style
	 */
	private $stylesheets = array();//store stylesheets
	/**
	 * @var array of colors used for representing the color scheme in the customizer
	 *
	 */
	private $palette = array();
	/**
	 * @var array of settings controlled by this style
	 */
	private $settings = array();


	public function __construct( $args = array() ) {

		$defaults = array(
			'id'            => '',
			'label'         => '',
			'stylesheets'   => array(),
			'palette'       => array(),
			'settings'      => array(),
		);

		$args = wp_parse_args( $args, $defaults );

		if ( empty( $args['id'] ) ) {
			throw new Exception( __( 'Der Themenstil muss eine eindeutige ID haben.', 'social-portal' ) );
		}
		//should we do that for label as well?

		$this->id           = $args['id'];
		$this->label        = $args['label'];
		$this->stylesheets   = $args['stylesheets'];
		$this->palette      = $args['palette'];
		$this->settings     = $args['settings'];
	}

	/**
	 * Add an individual setting
	 *
	 * @param string $key setting name
	 * @param mixed $value setting value
	 * @return CB_Theme_Style
	 */
	public function add_setting( $key, $value ) {
		$this->settings[ $key ] = $value;
		return $this;
	}

	/**
	 * Override all settings
	 *
	 * @param $settings
	 * @return CB_Theme_Style
	 */
	public function set( $settings ) {
		$this->settings = $settings;
		return $this;
	}

	/**
	 * Set the stylesheets set for this scheme
	 *
	 * @param array $stylesheets array of named stylesheets
	 *
	 * @return CB_Theme_Style
	 */
	public function set_stylesheets( $stylesheets ) {
		$this->stylesheets = $stylesheets;
		return $this;
	}

	/**
	 * Set a named stylesheet for this theme
	 *
	 * @param $type
	 * @param $styesheet_uri
	 */
	public function set_stylesheet( $type, $styesheet_uri ) {
		$this->stylesheets[ $type ] = $styesheet_uri;
	}

	/**
	 * get stylesheet if any associated with this color scheme
	 *
	 * @param string $type
	 *
	 * @return null|string absolute path to the stylesheet
	 */
	public function get_stylesheet( $type = 'theme' ) {
		if ( isset( $this->stylesheets[ $type ] ) ) {
			return $this->stylesheets[ $type ];
		}

		return null;
	}

	/**
	 * Check if there is an associated stylesheet
	 * @param string $type
	 * @return null|string
	 */
	public function has_stylesheet( $type = 'theme' ) {
		return isset( $this->stylesheets [ $type ] );
	}
	/**
	 * Remove all settings
	 *
	 * @return CB_Theme_Style
	 */
	public function reset() {
		$this->settings = array();
		$this->stylesheet = null;
		return $this;
	}

	/**
	 * get the id of current color scheme
	 * @return string id of the color scheme
	 */
	public function get_id() {
		return $this->id;
	}

	public function get_label() {
		return $this->label;
	}

	public function get_palette() {
		return $this->palette;
	}
	/**
	 * Get all settings as an array
	 *
	 * @return array
	 */
	public function get_settings() {
		return $this->settings;
	}

}
