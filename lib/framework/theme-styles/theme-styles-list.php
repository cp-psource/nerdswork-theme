<?php
/**
 * Pre registered Theme Styles
 *  You can register a new Theme style by calling combuilder()->add_theme_style( new Theme_Style() );
 *
 */
$stylesheet_uri = combuilder()->get_url();
$theme_styles = array(
	'default'   => new CB_Theme_Style(
		array(
				'id'        => 'default',//id
				'label'     => __( 'Standard', 'social-portal' ),
				'stylesheets' =>  array(
					'theme'         => $stylesheet_uri . '/assets/css/styles/minimal/theme-minimal.css',
					'buddypress'    => $stylesheet_uri . '/assets/css/styles/minimal/buddypress-minimal.css',
					'psforum'       => $stylesheet_uri . '/assets/css/styles/minimal/psforum-minimal.css', //k, v

					),
				'palette'   => array( '#ffffff', '#000000', '#e5e5e5', '#f61ca6', '#cffc5b' ),
				'settings'  => array(
					//setting options to override
				)
			)
		),

		'facy-blue'   => new CB_Theme_Style(
			array(
				'id'        => 'facy-blue',
				'label'     => __( 'Lust auf Blau', 'social-portal' ),
				'palette'   => array( '#3b5998', '#8b9dc3', '#dfe3ee', '#f7f7f7', '#ffffff' ),
				'stylesheets' =>  array(
					'theme'         => $stylesheet_uri . '/assets/css/styles/facy-blue/theme-facy-blue.css',
					'buddypress'    => $stylesheet_uri . '/assets/css/styles/facy-blue/buddypress-facy-blue.css',
					'psforum'       => $stylesheet_uri . '/assets/css/styles/facy-blue/psforum-facy-blue.css', //k, v

				),
				'settings'  => array(
					'main-nav-selected-item-color'				=> '#fff',
					//'primary-color'                             => '#3070d1',
					//'secondary-color'                           => '#eaecee',
					'text-color'                                => '#171717',
					//'color-detail'                              => '#b9bcbf',
					// Links
					'link-color'								=> '',
					'link-hover-color'							=> '',
					// Background
					'background-color'                          => '#ffffff' , // '#' intentionally left off here
					'main-background-color'                     => 'rgba(0,0,0,0)',
					'login-submit-button-background-color'      => '#547FD9',
					'login-submit-button-hover-background-color'      => '#547FD9',

				)
			)
		),

);
unset( $stylesheet_uri );
combuilder()->set_theme_styles( $theme_styles );