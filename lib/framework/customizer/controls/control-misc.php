<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit(0);
}

/**
 * @original code by  'Make' theme from ThemeFoundry.com
 */

if ( class_exists( 'WP_Customize_Control' ) ) :
/**
 * Class CB_Customize_Misc_Control
 *
 * Control for adding arbitrary HTML to a Customizer section.
 *
 * @since 1.0.0.
 */
class CB_Customize_Misc_Control extends WP_Customize_Control {
	
	public $type = 'group-title';
	public $settings = 'blogname';
	/**
	 * The current setting name.
	 *
	 * @since 1.0.0.
	 *
	 * @var   string    The current setting name.
	 */
	//public $settings = 'blogname';

	/**
	 * The current setting description.
	 *
	 * @since 1.0.0.
	 *
	 * @var   string    The current setting description.
	 */
	//public $description = '';

	/**
	 * Render the description and title for the section.
	 *
	 * Prints arbitrary HTML to a customizer section. This provides useful hints for how to properly set some custom
	 * options for optimal performance for the option.
	 *
	 * @since  1.0.0.
	 *
	 * @return void
	 */
	public function render_content() {
		
		echo '<h4 class="cb-control-group-title">' . esc_html( $this->label ) . '</h4>';
		if ( '' !== $this->description ) {
			echo '<span class="description customize-control-description">' . $this->description . '</span>';
		}
		
	}
}
endif;