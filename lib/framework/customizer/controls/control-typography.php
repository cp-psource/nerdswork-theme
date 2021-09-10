<?php
/**
 * Typography Control based on Kirki's Typography control
 *
 * Customizer Control: typography.
 *
 * Original copyright  Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

	/**
	 * Typography control.
	 */
	class CB_Customize_Control_Typography extends WP_Customize_Control {


		public $type = 'typography';
        public $tooltip = '';
		private $js_vars = array();
		private $output = '';
		//private $choices = array();
		
		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {
            //wp_die("Called");
			wp_enqueue_script( 'cb-typography-control' );
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
				'font-family'    => false,
				'font-size'      => false,
				'variant'        => false,
				'line-height'    => false,
				'letter-spacing' => false,
				'color'          => false,
				'hover-color'	 => false,
				'text-align'     => false,
			);
			$this->json['default'] = wp_parse_args( $this->json['default'], $defaults );
			$this->json['show_variants'] = true;//
			$this->json['show_subsets']  = true;
		}

		/**
		 * An Underscore (JS) template for this control's content (but not its container).
		 *
		 * Class variables for this control class are available in the `data` JS object;
		 * export custom variables by overriding {@see Kirki_Customize_Control::to_json()}.
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

			<div class="wrapper">

                <# if ( '' == data.value['font-family'] ) { data.value['font-family'] = data.default['font-family']; } #>
				<# if ( data.choices['fonts'] ) { data.fonts = data.choices['fonts']; } #>

                <# if ( data.default['font-family'] ) { #>
					<div class="font-family">
						<h5>{{ data.l10n['font-family'] }}</h5>
						<select id="cb-typography-font-family-{{{ data.id }}}" placeholder="{{ data.l10n['select-font-family'] }}"></select>
					</div>
					<# if ( true === data.show_variants || false !== data.default.variant ) { #>
						<div class="variant  cb-variant-wrapper">
							<h5>{{ data.l10n['variant'] }}</h5>
							<select class="variant" id="cb-typography-variant-{{{ data.id }}}"></select>
						</div>
					<# } #>
					<# if ( true === data.show_subsets ) { #>
						<div class="subsets hide-on-standard-fonts cb-subsets-wrapper">
							<h5>{{ data.l10n['subsets'] }}</h5>
							<select class="subset" id="cb-typography-subsets-{{{ data.id }}}"></select>
						</div>
					<# } #>
                <# } #>

				<# if ( data.default['font-size'] ) { #>
					<div class="font-size cb-clearfix">
						<h5>{{ data.l10n['font-size'] }}</h5>
                        <div class="cb-range-slider"></div>
                        <input class="cb-control-range" type="text" value="{{ data.value['font-size'] }}" min="8" max="100" step="1"/>

                    </div>
				<# } #>

				<# if ( data.default['line-height'] ) { #>
					<div class="line-height cb-clearfix">
						<h5>{{ data.l10n['line-height'] }}</h5>

						<div class="cb-range-slider"></div>
                        <input class="cb-control-range" type="text" value="{{ data.value['line-height'] }}" min=".5" max="5" step=".1"/>
                    </div>
				<# } #>

				<# if ( data.default['letter-spacing'] ) { #>
					<div class="letter-spacing">
						<h5>{{ data.l10n['letter-spacing'] }}</h5>
						<input type="text" value="{{ data.value['letter-spacing'] }}"/>
					</div>
				<# } #>

				<# if ( data.default['text-align'] ) { #>
					<div class="text-align">
						<h5>{{ data.l10n['text-align'] }}</h5>
						<input type="radio" value="inherit" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-inherit" <# if ( data.value['text-align'] === 'inherit' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-inherit">
								<span class="dashicons dashicons-editor-removeformatting"></span>
								<span class="screen-reader-text">{{ data.l10n['inherit'] }}</span>
							</label>
						</input>
						<input type="radio" value="left" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-left" <# if ( data.value['text-align'] === 'left' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-left">
								<span class="dashicons dashicons-editor-alignleft"></span>
								<span class="screen-reader-text">{{ data.l10n['left'] }}</span>
							</label>
						</input>
						<input type="radio" value="center" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-center" <# if ( data.value['text-align'] === 'center' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-center">
								<span class="dashicons dashicons-editor-aligncenter"></span>
								<span class="screen-reader-text">{{ data.l10n['center'] }}</span>
							</label>
						</input>
						<input type="radio" value="right" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-right" <# if ( data.value['text-align'] === 'right' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-right">
								<span class="dashicons dashicons-editor-alignright"></span>
								<span class="screen-reader-text">{{ data.l10n['right'] }}</span>
							</label>
						</input>
						<input type="radio" value="justify" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-justify" <# if ( data.value['text-align'] === 'justify' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-justify">
								<span class="dashicons dashicons-editor-justify"></span>
								<span class="screen-reader-text">{{ data.l10n['justify'] }}</span>
							</label>
						</input>
					</div>
				<# } #>

				<# if ( data.default['text-transform'] ) { #>
					<div class="text-transform">
						<h5>{{ data.l10n['text-transform'] }}</h5>
						<select id="cb-typography-text-transform-{{{ data.id }}}">
							<option value="none"<# if ( 'none' === data.value['text-transform'] ) { #>selected<# } #>>{{ data.l10n['none'] }}</option>
							<option value="capitalize"<# if ( 'capitalize' === data.value['text-transform'] ) { #>selected<# } #>>{{ data.l10n['capitalize'] }}</option>
							<option value="uppercase"<# if ( 'uppercase' === data.value['text-transform'] ) { #>selected<# } #>>{{ data.l10n['uppercase'] }}</option>
							<option value="lowercase"<# if ( 'lowercase' === data.value['text-transform'] ) { #>selected<# } #>>{{ data.l10n['lowercase'] }}</option>
							<option value="initial"<# if ( 'initial' === data.value['text-transform'] ) { #>selected<# } #>>{{ data.l10n['initial'] }}</option>
							<option value="inherit"<# if ( 'inherit' === data.value['text-transform'] ) { #>selected<# } #>>{{ data.l10n['inherit'] }}</option>
						</select>
					</div>
				<# } #>

				<# if ( data.default['color'] ) { #>
					<div class="color">
						<h5>{{ data.l10n['color'] }}</h5>
						<input type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default['color'] }}" value="{{ data.value['color'] }}" class="cb-color-control color-picker" {{{ data.link }}} />
					</div>
				<# } #>
				
				<# if ( data.default['hover-color'] ) { #>
					<div class="color">
						<h5>{{ data.l10n['hover-color'] }}</h5>
						<input type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default['hover-color'] }}" value="{{ data.value['hover-color'] }}" class="cb-hover-color-control color-picker" {{{ data.link }}} />
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

				'inherit'               => esc_attr__( 'Inherit', 'social-portal' ),

				'all'                   => esc_attr__( 'Alle', 'social-portal' ),
				'cyrillic'              => esc_attr__( 'Cyrillic', 'social-portal' ),
				'cyrillic-ext'          => esc_attr__( 'Cyrillic Extended', 'social-portal' ),
				'devanagari'            => esc_attr__( 'Devanagari', 'social-portal' ),
				'greek'                 => esc_attr__( 'Greek', 'social-portal' ),
				'greek-ext'             => esc_attr__( 'Greek Extended', 'social-portal' ),
				'khmer'                 => esc_attr__( 'Khmer', 'social-portal' ),
				'latin'                 => esc_attr__( 'Latin', 'social-portal' ),
				'latin-ext'             => esc_attr__( 'Latin Extended', 'social-portal' ),
				'vietnamese'            => esc_attr__( 'Vietnamese', 'social-portal' ),
				'hebrew'                => esc_attr__( 'Hebrew', 'social-portal' ),
				'arabic'                => esc_attr__( 'Arabic', 'social-portal' ),
				'bengali'               => esc_attr__( 'Bengali', 'social-portal' ),
				'gujarati'              => esc_attr__( 'Gujarati', 'social-portal' ),
				'tamil'                 => esc_attr__( 'Tamil', 'social-portal' ),
				'telugu'                => esc_attr__( 'Telugu', 'social-portal' ),
				'thai'                  => esc_attr__( 'Thai', 'social-portal' ),
				'serif'                 => _x( 'Serif', 'font style', 'social-portal' ),
				'sans-serif'            => _x( 'Sans Serif', 'font style', 'social-portal' ),
				'monospace'             => _x( 'Monospace', 'font style', 'social-portal' ),
				'font-family'           => esc_attr__( 'Schriftfamilie', 'social-portal' ),
				'font-size'             => esc_attr__( 'Schriftgröße (px)', 'social-portal' ),
				'font-weight'           => esc_attr__( 'Schriftgewicht', 'social-portal' ),
				'line-height'           => esc_attr__( 'Zeilenhöhe (em)', 'social-portal' ),
				'font-style'            => esc_attr__( 'Schriftstil', 'social-portal' ),
				'letter-spacing'        => esc_attr__( 'Buchstaben-Abstand', 'social-portal' ),
				'top'                   => esc_attr__( 'Oben', 'social-portal' ),
				'bottom'                => esc_attr__( 'Unten', 'social-portal' ),
				'left'                  => esc_attr__( 'Links', 'social-portal' ),
				'right'                 => esc_attr__( 'Rechts', 'social-portal' ),
				'center'                => esc_attr__( 'Zentriert', 'social-portal' ),
				'justify'               => esc_attr__( 'Justieren', 'social-portal' ),
				'color'                 => esc_attr__( 'Farbe', 'social-portal' ),
				'hover-color'           => esc_attr__( 'Hover Farbe', 'social-portal' ),

				'remove'                => esc_attr__( 'Entfernen', 'social-portal' ),
				'select-font-family'    => esc_attr__( 'Wähle eine Schriftfamilie', 'social-portal' ),
				'variant'               => esc_attr__( 'Variante', 'social-portal' ),
				'subsets'               => esc_attr__( 'Teilmenge', 'social-portal' ),
				'size'                  => esc_attr__( 'Größe', 'social-portal' ),
				'height'                => esc_attr__( 'Höhe', 'social-portal' ),
				'spacing'               => esc_attr__( 'Abstand', 'social-portal' ),
				'ultra-light'           => esc_attr__( 'Ultra-Light 100', 'social-portal' ),
				'ultra-light-italic'    => esc_attr__( 'Ultra-Light 100 Italic', 'social-portal' ),
				'light'                 => esc_attr__( 'Light 200', 'social-portal' ),
				'light-italic'          => esc_attr__( 'Light 200 Italic', 'social-portal' ),
				'book'                  => esc_attr__( 'Book 300', 'social-portal' ),
				'book-italic'           => esc_attr__( 'Book 300 Italic', 'social-portal' ),
				'regular'               => esc_attr__( 'Normal 400', 'social-portal' ),
				'italic'                => esc_attr__( 'Normal 400 Italic', 'social-portal' ),
				'medium'                => esc_attr__( 'Medium 500', 'social-portal' ),
				'medium-italic'         => esc_attr__( 'Medium 500 Italic', 'social-portal' ),
				'semi-bold'             => esc_attr__( 'Semi-Bold 600', 'social-portal' ),
				'semi-bold-italic'      => esc_attr__( 'Semi-Bold 600 Italic', 'social-portal' ),
				'bold'                  => esc_attr__( 'Bold 700', 'social-portal' ),
				'bold-italic'           => esc_attr__( 'Bold 700 Italic', 'social-portal' ),
				'extra-bold'            => esc_attr__( 'Extra-Bold 800', 'social-portal' ),
				'extra-bold-italic'     => esc_attr__( 'Extra-Bold 800 Italic', 'social-portal' ),
				'ultra-bold'            => esc_attr__( 'Ultra-Bold 900', 'social-portal' ),
				'ultra-bold-italic'     => esc_attr__( 'Ultra-Bold 900 Italic', 'social-portal' ),
				'invalid-value'         => esc_attr__( 'Ungültiger Wert', 'social-portal' ),
				'back'                  => esc_attr__( 'Zurück', 'social-portal' ),
				'text-align'            => esc_attr__( 'Textausrichtung', 'social-portal' ),
				'text-transform'        => esc_attr__( 'Texttransformation', 'social-portal' ),
				'none'                  => esc_attr__( 'Nichts', 'social-portal' ),
				'capitalize'            => esc_attr__( 'Capitalize', 'social-portal' ),
				'uppercase'             => esc_attr__( 'Großbuchstaben', 'social-portal' ),
				'lowercase'             => esc_attr__( 'Kleinbuchstaben', 'social-portal' ),
				'initial'               => esc_attr__( 'Initial', 'social-portal' ),
				'hex-value'             => esc_attr__( 'Hex Wert', 'social-portal' ),
			);

        return $translation_strings;
    }

}
