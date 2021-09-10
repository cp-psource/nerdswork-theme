//For Live Preview
;( function( $ ) {
	var api = wp.customize;
    var bridge = parent.wp.customize;
	
	/**
	 * Asynchronous updating
	 */
	
	// Site Title
	api( 'blogname', function( value ) {

		value.bind( function( to ) {

            $( '#logo span.logo-text a' ).html( to );
            //$( '#logo' ).data( 'site-name', to );
            // bridge.control( 'blogdescription' ).setting( to );
		} );

	} );
	
	//Old Logo Image change, Can be removed now. Only for wp<4.5.0
	api( 'logo', function( value ) {
		
		value.bind( function( to ) {
		
			var $logo = $( '#logo' );
			var site_url = $logo.find( 'a' ).attr( 'href' );
			
			if ( ! to ) {
				//Logo deleted
				$logo.find( 'a' ).remove();
				$logo.append( "<span class='logo-text'><a href='"+site_url+"'>"+$logo.data( 'site-name' ) + "</a></span>" );
				
			} else {
				var $img = "<a href='" + site_url + "'><img src='" + to + "' /></a>";
				
				if ( $logo.find( '.logo-text' ) ) {
					//changing from text logo
					$logo.find( '.logo-text' ).remove();//
					$( '#logo' ).append( $img );
					
				} else {
					//changing one logo by another
					$logo.find( 'img' ).attr( 'src', to );
				}

			}
			
			
		} );
	} );


    //Content Width %
	api( 'content-width', function( value ) {
        var $body = $('body'),
            $container = $('#container');

		value.bind( function( to ) {
             //If it is single column page, do not change width
            if ( $container.hasClass( 'page-single-col' ) || $body.hasClass( 'layout-single-col' ) && $container.hasClass( 'page-layout-default' ) ) {
               return ;
            }

			var sidebar = 100 - to;
			$( '#content' ).css( { width: to + '%' } );
			$( '#sidebar' ).css( { width: sidebar + '%', display: 'block' } );
			
			if ( sidebar < 5 ) {
				$( '#sidebar' ).hide();//display:none
			}
		} );
	} );

	//show/hide left panel icon
	api( 'panel-left-visibility', function( value ) {
    
		value.bind( function( to ) {

			if ( to == 'always') {
				$( '#panel-left-toggle' ).show();
			} else {
				$( '#panel-left-toggle' ).hide();
			}
		} );
	} );
	//show/hide right panel icon
	api( 'panel-right-visibility', function( value ) {
    
		value.bind( function( to ) {
			if ( to == 'always' ) {
				$( '#panel-right-toggle' ).show();
			} else {
				$( '#panel-right-toggle' ).hide();
			}
		} );
	} );


    //for color scheme
    api( 'theme-style', function (value ) {

        value.bind( function( to ) {

        });

    });
    api( 'page-header-mask-color', function( value ) {

        value.bind( function( to ) {
            $('.page-header-mask-enabled .page-header-mask, .has-cover-image .page-header-mask, .bp-user .page-header-mask').css( 'background', to );
        });

    } );

    api( 'main-nav-alignment', function( value ) {

        value.bind( function( to ) {
            var $nav = $('#nav');
            $nav.removeClass('main-nav-left main-nav-right main-nav-center' );
            $nav.addClass('main-nav-' + to );
        });

    } );

    //Main menu alignment


    //All link/hover
    apply_color_change( 'text-color', 'body' );

    apply_text_hover_style( 'link-color', 'link-hover-color', 'a', 'a:hover' );

    //buttons bg
    var btn_selector = '.button, input[type="submit"], .btn, .bp-login-widget-register-link a, button, .btn-secondary .activity-item a.button, .ac-reply-content input[type="submit"], a.comment-reply-link, .sow-more-text a';
    var btn_hover_selector = '.button:hover, input[type="submit"]:hover, .btn:hover, .bp-login-widget-register-link a:hover, button:hover, .btn-secondary:hover, .activity-item a.button:hover, a.comment-reply-link:hover, .sow-more-text a:hover, .button:focus, input[type="submit"]:focus, .btn:focus, .bp-login-widget-register-link a:focus, button:focus, .btn-secondary:focus, .activity-item a.button:focus, a.comment-reply-link:focus, .sow-more-text a:focus';
    apply_background_hover_style( 'button', btn_selector, btn_hover_selector );

    apply_text_hover_style( 'button-text-color', 'button-hover-text-color', btn_selector, btn_hover_selector );

    //text color hover

    //Site title font size
	apply_font_change( 'base', 'body' );
    apply_font_change( 'site-title', '#header .logo-text' );

	//site logo color/hover
	apply_link_hover_style( 'site-title', '#header .logo-text a' );//more specific selector to avoid override by header colors

	//Header social icons
    apply_font_size( 'header-social-icon-font-size', '#header ul.social-links .fa' );


    // Site Background
   //Site BG Color, the background image is handled by wp
	api( 'background-color', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css( {'background-color': to  } );
		} );
	} );

	apply_style_change( 'header', '#header' );
	apply_link_hover_style( 'header', '#header a' );
	apply_border_style( 'header-border', '#header' );

    apply_color_change( 'panel-left-toggle-color', '#panel-left-toggle' );
    apply_color_change( 'panel-right-toggle-color', '#panel-right-toggle' );
    //header buttons, these buttons will not be visible to logged in user, so no need for live updating
    //apply_text_hover_style('header-buttons-text-color', 'header-buttons-hover-text-color', 'header-links a.btn', 'header-links a.btn:hover' );
    //apply_background_hover_style('header-buttons', 'header-links a.btn', 'header-links a.btn:hover' );

		
	apply_background_color( 'header-top-background-color', '#header-top-row' );
	apply_color_change( 'header-top-text-color', '#header-top-row' );
	apply_link_hover_style( 'header-top', '#header-top-row a' );
    apply_border_style( 'header-top-border', '#header-top-row' );
	
	apply_background_color( 'header-main-background-color', '#header-main-row' );
	apply_color_change( 'header-main-text-color', '#header-main-row' );
	apply_link_hover_style( 'header-main', '#header-main-row a' );
    apply_border_style( 'header-main-border', '#header-main-row' );

	apply_background_color( 'header-bottom-background-color', '#header-bottom-row' );
	apply_color_change( 'header-bottom-text-color', '#header-bottom-row' );
    apply_link_hover_style( 'header-bottom', '#header-bottom-row a' );
    apply_border_style( 'header-bottom-border', '#header-bottom-row' );

    //text headers
    var headers = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'];

    for ( var i = 0; i< headers.length; i++ ) {
        apply_font_change( headers[i], "article " + headers[i] );
    }

    //Main Menu
    //apply_background_style( 'main-nav', '#nav' );
    apply_background_color( 'main-nav-background-color', '#nav' );
    apply_font_change( 'main-nav', '#nav' );
    apply_link_hover_style( 'main-nav', '#nav > ul > li > a' );
    apply_background_hover_style( 'main-nav-link', '#nav > ul > li > a' );
    apply_border_style( 'main-nav-link-border', '#nav > ul > li > a' );
    apply_border_style( 'main-nav-link-hover-border', '#nav > ul > li > a:hover' );
    //

	//apply_link_hover_style( 'main-nav', '#nav > ul > li > a' );
	
    //sub nav in main menu
    apply_font_change( 'sub-nav', '#nav li li' );
    apply_link_hover_style( 'sub-nav', '#nav > ul > li.menu-item-has-children li a' );
    apply_background_hover_style( 'sub-nav-link', '#nav > ul > li.menu-item-has-children li a' );
    apply_border_style( 'sub-nav-link-border', '#nav > ul > li.menu-item-has-children li a' );
    apply_border_style( 'sub-nav-link-hover-border', '#nav > ul > li.menu-item-has-children li a:hover' );

    //current menu item font weight
    apply_font_weight( 'main-nav-selected-item-font-weight', '#nav .current-menu-item > a, #nav .current-menu-parent > a' );
    apply_color_change( 'main-nav-selected-item-color', '#nav .current-menu-item > a, #nav .current-menu-parent > a' );

    //end of Main Menu
	
	//Page Header
    //background
    apply_background_color( 'page-header-background-color', '.page-header' );
    //page Header text colors
    apply_color_change( 'page-header-title-text-color', '.page-header .page-header-title' );
    apply_color_change( 'page-header-content-text-color', '.page-header-meta' );

	 apply_font_change( 'page-header-title', '.page-header .page-header-title' );
	 apply_font_change( 'page-header-content', '.page-header-meta' );

	apply_background_color( 'sidebar-background-color', '#sidebar' );
	apply_color_change( 'sidebar-text-color', '#sidebar' );
	apply_link_hover_style( 'sidebar', '#sidebar a' );
	
    //for Widgets
    apply_font_change( 'widget-title', '#sidebar .widgettitle' );
    //apply_background_color( 'widget-title-background-color', '#sidebar .widgettitle' );
    apply_color_change( 'widget-title-text-color', '#sidebar .widgettitle' );
    apply_link_hover_style( 'widget-title', '#sidebar .widgettitle a' );

    //widget content//
    apply_font_change( 'widget', '#sidebar .widget' );
    apply_background_color( 'widget-background-color', '#sidebar .widget' );
    apply_color_change( 'widget-text-color', '#sidebar .widget' );
    apply_link_hover_style( 'widget', '#sidebar .widget a' );
	//border color too
	
 



    //footer copyright/text
    apply_font_change( 'footer', '#footer' );
    apply_style_change( 'footer', '#footer' );
    apply_link_hover_style( 'footer', '#footer a' );

    //Footer Widgets
    apply_font_change( 'footer-widget-title', '#footer .widgettitle' );
    //footer widget content
    apply_font_change( 'footer-widget', '#footer .widget' );

	apply_font_change( 'footer-top', '#footer-widget-area' );
    apply_style_change( 'footer-top', '#footer-widget-area' );
    apply_link_hover_style( 'footer-top', '#footer-widget-area a' );

	//copyright area
	apply_background_color( 'site-copyright-background-color', '#site-copyright' );
	apply_color_change( 'site-copyright-text-color', '#site-copyright' );
    apply_link_hover_style( 'site-copyright', '#site-copyright a' );


    //main element
    apply_background_style( 'main', '#container' );
    //apply_color_change( 'main-text-color', '#container' );
    
	apply_color_change( 'main-link-color', '#container a' );
    apply_color_change( 'main-link-hover-color', '#container a:hover' );
	
	
	//Footer Social links
	 apply_font_size( 'footer-social-icon-font-size', '#footer ul.social-links .fa' );

	//Footer content site copyright
	api( 'footer-text', function( value ) {
    
		value.bind( function( to ) {
			if ( to ) {
			    to = to.replace('\[current-year\]', (new Date() ).getFullYear() );
				$('#site-copyright p').html( to );
			}
			
		} );
	} );
	
	api( 'custom_plugin_css', function( value ) {
        var head = $('head'),
            style_id = 'custom-cb-extra-css';

        var style = $( '#' + style_id );

		value.bind( function( to ) {
            // Refresh the stylesheet by removing and recreating it.
            style.remove();

            style = $('<style type="text/css" id="' + style_id + '">' + to + '</style>').appendTo( head );

            //$( '#custom-plugin-css' ).html( to );
		} );
	} );
	
	//BuddyPress
    apply_font_change( 'bp-single-item-title', 'div#item-header h2' );
    apply_link_hover_style( 'bp-single-item-title', 'div#item-header h2 a' );

    //buttons bg
    apply_background_hover_style( 'bp-dropdown-toggle', '.dropdown-toggle', '.dropdown-toggle:hover' );

    apply_text_hover_style( 'bp-dropdown-toggle-text-color', 'bp-dropdown-toggle-hover-text-color','.dropdown-toggle', '.dropdown-toggle:hover' );


    /**
	 * Apply style changes to the selector
	 * 
	 * @param {type} element
	 * @param {type} selector
	 * @returns {undefined}
	 */
	function apply_style_change( element, selector ) {
		
		apply_background_style( element, selector );
		var el = element + '-text-color'; 
		apply_color_change( el, selector );
	}
	
	
	function apply_color_change( setting, selector ) {
		api( setting, function( value ) {

            value.bind( function( to ) {
                generate_internal_css(setting + '-color', selector, { color: to } );
				//$( selector ).css( { color: to } );
			} );
		});
	
	}
	
	/**
	 * Apply font size/line height change
	 * 
	 * @param string element
	 * @param selector string
     *
	 * @returns {null}
	 */
	    
	function apply_font_change( element, selector ) {

        api( element + '-font-settings', function( value ) {

            value.bind( function( to ) {
				var map = {};
				//check if we have the font-size?
				if ( to['font-size'] ) {
					map['font-size'] = to['font-size'] +'px';
				}
				
				if ( to['line-height'] ) {
					map['line-height'] = to['line-height']+'em';
				}
				
				if ( to['variant'] ) {
					map['font-weight'] = to['variant'];
				}
				generate_internal_css( element + '-font-settings', selector, map );
               // $( selector ).css( map );

            } );
        } );

    }
    /**
     * Apply changes in font size live to the given css selectors
     *
     * @param setting setting id
     * @param selector  css selector
     */
    function apply_font_size( setting, selector ) {

        api( setting , function( value ) {

            value.bind( function( to ) {
                if ( to ) {
                    generate_internal_css( setting + '-font-size', selector,{ 'font-size' : to + 'px'} );
                    //$( selector ).css( { 'font-size' : to + 'px'} );
                }

            } );
        } );

    }

    /**
     * Apply change in font weight live to the selectors
     *
     * @param string element
     * @param selector css selector
     */
    function apply_font_weight( element, selector ) {

        api( element, function( value ) {

            value.bind( function( to ) {
                if ( to ) {
                    generate_internal_css( setting + '-font-weight', selector, { 'font-weight' : to } );
                    //$( selector ).css( { 'font-weight' : to } );
                }

            } );
        } );
    }

    /**
     * Apply the line height change live for the given element to the given selector
     *
     * @param setting unique setting id
     * @param selector ( css selector )
     */
    function apply_line_height( setting, selector ) {

        api( setting, function( value ) {

            value.bind( function( to ) {
                if ( to ) {
                    generate_internal_css( setting + '-line-height', selector, { 'line-height' : to + 'em' } );
                   // $( selector ).css( { 'line-height' : to + 'em' } );
                }

            } );
        } );
    }

	function apply_border_style( setting, selector ) {

        api( setting, function( value ) {

            value.bind( function( to ) {

				var map = {};
				
				if ( to['changed'] ) {
                    generate_internal_css(setting, selector, { 'border': '0 none' } );
					//map['border'] = '0 none';//to['font-size'] +'px';
					// $( selector ).css( { 'border': '0 none' } );
					 
				}
				//check if we have the font-size?
				if ( to['border-edge'] && to['border-edge'] == 'none' ) {
					
					map['border'] = '0 none';//to['font-size'] +'px';
					//map['border-style'] = 'none';//to['font-size'] +'px';
				} else {
					map[to['border-edge']] = to['border-width'] +'px ' + to['border-style'] + ' ' + to['border-color'];
				}
                generate_internal_css( setting, selector, map );
                //$( selector ).css( map );
                

            } );
        } );

    }
    //element: main
    //selector: '#container'
    //Apply Background styles
    function apply_background_color( setting, selector ) {
			
		api( setting, function( value ) {
			value.bind( function( to ) {
                generate_internal_css( setting + '-background-color', selector, {'background-color': to  } );
				//$( selector ).css( {'background-color': to  } );
			} );
		} );
    }
	

    /**
     * Apply hover styles to color properties
     *
     * @param element
     * @param selector
     */
    function apply_text_hover_style( setting, setting_hover, selector, selector_hover ) {

        if ( ! selector_hover ) {
            selector_hover = selector+':hover';
        }

        apply_hover_style( setting + '-text-hover', 'color', setting, setting_hover, selector, selector_hover );

    }

    /**
     * Apply hover styles to links
     *
     * @param element
     * @param selector
     */
    function apply_link_hover_style( element, selector ) {
		//return ;main-nav-link-color
        apply_hover_style( element, 'color', element+ '-link-color', element + '-link-hover-color', selector,selector+':hover' );
    }

    /**
     * Apply background hover style
     * @param element
     * @param selector
     * @param hover_selector
     */
    function apply_background_hover_style( element, selector, hover_selector ) {


        if ( hover_selector == undefined ) {
           hover_selector = selector +':hover';
        }

        apply_hover_style( element + '-bg', 'background-color', element + '-background-color', element + '-hover-background-color', selector, hover_selector );
    }


    function apply_background_style( element, selector ) {
        var   bg = $.map([ 'background-image', 'background-color', 'background-position', 'background-repeat', 'background-attachment', 'background-size'], function( prop ) {
            return element + '-' + prop;
        });


        api.when.apply( api, bg ).done( function(  image, bg_color, position, repeat, attachment, size) {

            var $el = $(selector),
                head = $('head'),
                style_id = 'custom-style-css-' + element;

            var style = $( '#' + style_id );

            var update = function() {

                var css = '';

                $el.toggleClass( 'custom-style', !! (  image() || bg_color()  ) );



                if ( bg_color() ) {
                    css += 'background-color: ' + bg_color() + ';';
                }

                if ( image() ) {
                    css += 'background-image: url("' + image() + '");';
                    css += 'background-position: ' + position().replace('-', ' ' ) + ';';
                    css += 'background-repeat: ' + repeat() + ';';
                    css += 'background-attachment: ' + attachment() + ';';
                    css += 'background-size: ' + size() + ';';
                }

                // Refresh the stylesheet by removing and recreating it.
                style.remove();

                style = $('<style type="text/css" id="' + style_id + '">' + selector + '.custom-style { ' + css + ' }</style>').appendTo( head );
            };

            $.each( arguments, function() {

                this.bind( update );
            });

        });

    }

    /**
     * Apply hover style based on the two settings
     *
     * @param string id used for uniquely identifyinf the css block in the current page
     * @param string property valid css property used for hover
     * @param string setting_general name of the setting controlling normal state
     * @param string setting_hover name of setting controlling hover state
     * @param string selector normal state selector
     * @param string selector_hover hover state selector
     */
    function apply_hover_style( id, property, setting_general, setting_hover, selector, selector_hover ) {
        //return ;

        var   props = [ setting_general, setting_hover ];

        api.when.apply( api, props ).done( function(  color, hover_color ) {

            var head = $('head'),
                style_id = 'custom-hover-css-' + id;

            var style = $( '#' + style_id );

            var update = function() {
                var css = hover_css = '';
                //color change?
                if ( color() ) {
                    css =  property + ':' + color() + ';';
                }

                if ( hover_color() ) {
                    hover_css = property + ':' + hover_color() + ';';
                }

                // Refresh the stylesheet by removing and recreating it.
                style.remove();

                style = $('<style type="text/css" id="' + style_id + '">\r\n' +
                    selector + '{ ' + css + ' }\r\n' +
                    selector_hover + '{' + hover_css + '}' +
                    '</style>'
                ).appendTo( head );


            };

            $.each( arguments, function() {

                this.bind( update );
            });

        });

    }

    var head = $( 'head' );

    /**
     *
     * @param setting unique setting id, must be unique for each supplied css object, else will override
     * @param selector the css seletor to which the styles should be spplied
     * @param css_object
     */
    function generate_internal_css( setting, selector, css_object ) {
        //var head = $('head'),
        var   style_id = 'custom-css-style-setting-' + setting;
        var style = $( '#' + style_id );

        style.remove();

        if ( $.isEmptyObject( css_object ) ) {
            return ;
        }

        var css = '';

        for( var key in css_object ) {
            css +=  key + ':' + css_object[key] + ';';
        }

        style = $('<style type="text/css" id="' + style_id + '">\r\n' +
            selector + '{' +css +'}'+
            '</style>'
        ).appendTo( head );

    }

} )( jQuery );


