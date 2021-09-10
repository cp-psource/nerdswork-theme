wp.customize.controlConstructor['border'] = wp.customize.Control.extend({

	ready: function() {

		'use strict';

		var control               = this,
		    value = {},
		    picker;

		// Make sure everything we're going to need exists.
		_.each( control.params['default'], function( defaultParamValue, param ) {

          	if ( false !== defaultParamValue ) {
				value[ param ] = defaultParamValue;
				if ( undefined !== control.setting._value[ param ] ) {
					value[ param ] = control.setting._value[ param ];
				}
			}
		});
		
		_.each( control.setting._value, function( subValue, param ) {

			if ( undefined === value[ param ] || 'undefined' === typeof value[ param ] ) {
				value[ param ] = subValue;
			}
		});


		// border edge
		
		this.container.on( 'change', '.border-edge select', function() {

			// Add the value to the array and set the setting's value.
			value['border-edge'] = jQuery( this ).val();
			value['changed'] = 1;	
			control.saveValue( value );
		});
		
		//border style
		this.container.on( 'change', '.border-style select', function() {

			// Add the value to the array and set the setting's value.
			value['border-style'] = jQuery( this ).val();
			control.saveValue( value );
		});


		this.container.on( 'change keyup paste', '.border-width input', function() {

			// Add the value to the array and set the setting's value
			value['border-width'] = jQuery( this ).val();

			control.saveValue( value );

		});
		

		picker = this.container.find( '.cb-color-control' );

		// Change color
		picker.wpColorPicker({
			change: function() {
					
				setTimeout( function() {

					// Add the value to the array and set the setting's value
					value['border-color'] = picker.val();
					control.saveValue( value );

				}, 100 );

			}

		});


	},

	/**
	 * Saves the value.
	 */
	saveValue: function( value ) {

		'use strict';

		var control  = this,
		    newValue = {};

		_.each( value, function( newSubValue, i ) {
			newValue[ i ] = newSubValue;
		});

		control.setting.set( newValue );
	}

});
