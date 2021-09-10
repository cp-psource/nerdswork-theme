( function( $, api ) {

	/* === Checkbox Multiple Control === */

	api.controlConstructor['checkbox-multiple'] = api.Control.extend( {
		ready: function() {
			var control = this;

			$( 'input:checkbox', control.container ).change(
				function() {

					// Get all of the checkbox values.
					var checkbox_values = $( 'input[type="checkbox"]:checked', control.container ).map(
						function() {
							return this.value;
						}
					).get();

					// Set the value.
					if ( null === checkbox_values ) {
						control.setting.set( '' );
					} else {
						control.setting.set( checkbox_values );
					}
				}
			);
		}
	} );

	/* === Palette Control === */

	api.controlConstructor['palette'] = api.Control.extend( {
		ready: function() {
			var control = this;

			// Adds a `.selected` class to the label of checked inputs.
			$( 'input:radio:checked', control.container ).parent( 'label' ).addClass( 'selected' );

			$( 'input:radio', control.container ).change(
				function() {

                    //cb_set_preview_color_scheme
                    var scheme = $( this ).val();
                    var data = {
                        wp_customize: 'on',
                        action: 'cb_set_preview_theme_style',
                        'theme-style' : scheme,
                        nonce: _CBCustomizerL10n.nonce.reset
                    };

                    $.post(ajaxurl, data, function () {
                        //wp.customize.state('saved').set(true);
                        location.reload();
                    });


					// Removes the `.selected` class from other labels and adds it to the new one.
					$( 'label.selected', control.container ).removeClass( 'selected' );
					$( this ).parent( 'label' ).addClass( 'selected' );

					control.setting.set( $( this ).val() );
				}
			);
		}
	} );

	/* === Radio Image Control === */

	api.controlConstructor['radio-image'] = api.Control.extend( {
		ready: function() {
			var control = this;

			$( 'input:radio', control.container ).change(
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
	} );

	/* === Select Group Control === */

	api.controlConstructor['select-group'] = api.Control.extend( {
		ready: function() {
			var control = this;

			$( 'select', control.container ).change(
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
	} );

	/* === Select Multiple Control === */

	api.controlConstructor['select-multiple'] = api.Control.extend( {
		ready: function() {
			var control = this;

			$( 'select', control.container ).change(
				function() {
					var value = $( this ).val();

					if ( null === value ) {
						control.setting.set( '' );
					} else {
						control.setting.set( value );
					}
				}
			);
		}
	} );
	
    var customControls;
	customControls = {
		cache: {},

		//
		init: function() {
			// Populate cache
			this.cache.$buttonset  = $('.cb-control-buttonset, .cb-control-image');
			this.cache.$bgposition = $('.cb-control-background-position');
			this.cache.$range      = $('.cb-control-range');

			// Initialize Button sets
			if (this.cache.$buttonset.length > 0) {
				this.buttonset();
			}

			// Initialize Background Position
			if (this.cache.$bgposition.length > 0) {
				this.bgposition();
			}

			// Initialize ranges
			if (this.cache.$range.length > 0) {
				this.range();
			}
		},

		//
		buttonset: function() {
			this.cache.$buttonset.buttonset();
		},

		//
		bgposition: function() {
			// Initialize button sets
			this.cache.$bgposition.buttonset({
				create : function(event) {
					var $control = $(event.target),
						$positionButton = $control.find('label'),
						$caption = $control.parent().find('.background-position-caption');

					$positionButton.on('click', function() {
						var label = $(this).data('label');
						$caption.text(label);
					});
				}
			});
		},

		//
		range: function() {
			this.cache.$range.each(function() {
				var $input = $(this),
					$slider = $input.parent().find('.cb-range-slider'),
					value = parseFloat( $input.val() ),
					min = parseFloat( $input.attr('min') ),
					max = parseFloat( $input.attr('max') ),
					step = parseFloat( $input.attr('step') );


				$slider.slider({
					value : value,
					min   : min,
					max   : max,
					step  : step,
					slide : function(e, ui) {
						$input.val(ui.value).keyup().trigger('change');
					}
				});
				$input.val( $slider.slider('value') );
			});
		}
	};

	//Initialize fonts
	$(document).ready( function () {
		//fontChoices.init();
		customControls.init();
	});

		// Add Community+ Documentation Linsk
	if ('undefined' !== typeof _CBCustomizerL10n) {
		var link = $('<a class="cb-customize-doc"></a>')
			.attr('href', _CBCustomizerL10n.docURL)
			.attr('target', '_blank')
			.text(_CBCustomizerL10n.docLabel)
		;
		$('.preview-notice').append(link);
		// Remove accordion click event
		$('.cb-customize-doc').on('click', function(e) {
			e.stopPropagation();
		});
	}
	
	//Settings Reset
	var $container = $('#customize-header-actions');
    var $button = $('<input type="submit" name="zoom-reset" id="zoom-reset" class="button-secondary button">')
        .attr('value', _CBCustomizerL10n.reset)
        .css({
            'float': 'right',
            'margin-right': '10px',
            'margin-top': '9px'
        });

    $button.on('click', function (event) {
        event.preventDefault();

        var data = {
            wp_customize: 'on',
            action: 'customizer_reset',
            nonce: _CBCustomizerL10n.nonce.reset
        };

        var r = confirm(_CBCustomizerL10n.confirm);

        if (!r) return;

        $button.attr('disabled', 'disabled');

        $.post(ajaxurl, data, function () {
            wp.customize.state('saved').set(true);
            window.location.href = _CBCustomizerL10n.customizeURL ;
        });
    });

    $container.append($button);

} )( jQuery, wp.customize );
