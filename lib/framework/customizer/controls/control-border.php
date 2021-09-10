<?php
/**
 * Element Border Control
 * Author: DerN3rd
 * 
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Border Control
 */
class CB_Customize_Control_Border extends WP_Customize_Control {


	public $type = 'border';
	public $tooltip = '';
	private $js_vars = array();
	private $output = '';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		//wp_die("Called");
		wp_enqueue_script( 'cb-border-control' );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();

		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		} else {
			$this->json['default'] = $this->setting->default;
		}
		$this->json['js_vars']     = isset( $this->js_vars ) ? $this->js_vars : array() ;
		$this->json['output']      = $this->output;
		$this->json['value']       = $this->value();
		$this->json['choices']     = $this->choices;
		$this->json['link']        = $this->get_link();
		$this->json['tooltip']     = $this->tooltip;
		$this->json['id']          = $this->id;
		$this->json['l10n']        = self::get_strings();
		$defaults = array(
			'border-edge'		=> 'all',
			'border-style'		=> 'solid',
			'border-width'		=> 0,
			'border-color'		=> '',
			'changed'			=> 0,
		);
		$this->json['default'] = wp_parse_args( $this->json['default'], $defaults );

	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {

		?>

		<label class="customizer-text">
			<# if ( data.label ) { #>
				<span class="customize-control-title"> {{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>

		<div class="wrapper cb-border-style-control-wrapper">

			<# if ( data.default['border-edge'] ) { #>
				<div class="border-edge">
					<h5>{{ data.l10n['border-edge'] }}</h5>
					<select id="cb-border-border-edge-{{{ data.id }}}">
						<option value="none"<# if ( 'none' === data.value['border-edge'] ) { #>selected<# } #>>{{ data.l10n['none'] }}</option>
						<option value="border"<# if ( 'solid' === data.value['border-edge'] ) { #>selected<# } #>>{{ data.l10n['border'] }}</option>
						<option value="border-top"<# if ( 'dotted' === data.value['border-edge'] ) { #>selected<# } #>>{{ data.l10n['border-top'] }}</option>
						<option value="border-right"<# if ( 'dotted' === data.value['border-edge'] ) { #>selected<# } #>>{{ data.l10n['border-right'] }}</option>
						<option value="border-bottom"<# if ( 'dotted' === data.value['border-edge'] ) { #>selected<# } #>>{{ data.l10n['border-bottom'] }}</option>
						<option value="border-left"<# if ( 'dotted' === data.value['border-edge'] ) { #>selected<# } #>>{{ data.l10n['border-left'] }}</option>
					</select>
				</div>
			<# } #>

			<# if ( data.default['border-style'] ) { #>
				<div class="border-style">
					<h5>{{ data.l10n['border-style'] }}</h5>
					<select id="cb-border-border-style-{{{ data.id }}}">
						<option value="none"<# if ( 'none' === data.value['border-style'] ) { #>selected<# } #>>{{ data.l10n['none'] }}</option>
						<option value="solid"<# if ( 'solid' === data.value['border-style'] ) { #>selected<# } #>>{{ data.l10n['solid'] }}</option>
						<option value="dotted"<# if ( 'dotted' === data.value['border-style'] ) { #>selected<# } #>>{{ data.l10n['dotted'] }}</option>
						<option value="dashed"<# if ( 'dashed' === data.value['border-style'] ) { #>selected<# } #>>{{ data.l10n['dashed'] }}</option>
					</select>
				</div>
			<# } #>

			<# if ( data.default['border-width'] >= 0 ) { #>
				<div class="border-width cb-clearfix">
					<h5>{{ data.l10n['border-width'] }}</h5>
					<div class="cb-range-slider"></div>
					<input class="cb-control-range" type="text" value="{{ data.value['border-width'] }}" min="0" max="20" step="1"/>

				</div>
			<# } #>

			<# if ( data.default['border-color'] ) { #>
				<div class="border-color">
					<h5>{{ data.l10n['border-color'] }}</h5>
					<input type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default['border-color'] }}" value="{{ data.value['border-color'] }}" class="cb-color-control color-picker" {{{ data.link }}} />
				</div>
			<# } #>

		</div>
		<?php
	}

	/**
	 * Renders the control wrapper and calls $this->render_content() for the internals.
	 */
	protected function render() {
		$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
		$class = 'customize-control customize-control-cb customize-control-' . $this->type;
		?><li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
			<?php $this->render_content(); ?>
		</li><?php
	}


	private static function get_strings() {
		$translation_strings = array(

				'none'                  => esc_attr__( 'Nichts', 'social-portal' ),

				'border-edge'			=> esc_attr__( 'Rahmenkante', 'social-portal' ),
				'border-style'			=> esc_attr__( 'Rahmenstil', 'social-portal' ),
				'border-width'			=> esc_attr__( 'Rahmenbreite', 'social-portal' ),
				'border-color'			=> esc_attr__( 'Rahmenfarbe', 'social-portal' ),
				'border'				=> esc_attr__( 'Alle', 'social-portal' ),
				'border-top'			=> esc_attr__( 'Oben', 'social-portal' ),
				'border-right'			=> esc_attr__( 'Rechts', 'social-portal' ),
				'border-bottom'			=> esc_attr__( 'Unten', 'social-portal' ),
				'border-left'			=> esc_attr__( 'Links', 'social-portal' ),

				//border -styles
				'solid'			=> esc_attr__( 'Solid', 'social-portal' ),
				'dotted'			=> esc_attr__( 'Dotted', 'social-portal' ),
				'dashed'			=> esc_attr__( 'Dashed', 'social-portal' ),


				'hex-value'             => esc_attr__( 'Hex Wert', 'social-portal' ),
		);

	return $translation_strings;
}

}
