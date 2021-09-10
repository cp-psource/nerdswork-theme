<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit(0);
}

class CB_Customize_Control_Header_Layout extends CB_Customize_Control_Layout {
	
	public function __construct( $manager, $id, $args = array() ) {

		
		$url = combuilder()->get_url() . '/lib/framework/customizer/assets/images/headers/';

		$layouts = array(
			'header-layout-default' => array(
				'url' => $url . 'h1.png',
				'label' => _x( 'Layout default', 'Header Layout name', 'social-portal' ),
			),
					
			'header-layout-2' => array(
				'url' => $url . 'h2.png',
				'label' => _x( 'Layout 2', 'Header Layout name', 'social-portal' ),
			),
			'header-layout-3' => array(
				'url' => $url . 'h3.png',
				'label' => _x( 'Layout 3', 'Header Layout name', 'social-portal' ),
			),

			
			'header-layout-4' => array(
				'url' => $url . 'h4.png',
				'label' => _x( 'Layout 4', 'Header Layout name', 'social-portal' ),
			),
			
			'header-layout-5' => array(
				'url' => $url . 'h5.png',
				'label' => _x( 'Layout 5', 'Header Layout name', 'social-portal' ),
			),
			'header-layout-6' => array(
				'url' => $url . 'h6.png',
				'label' => _x( 'Layout 6', 'Header Layout name', 'social-portal' ),
			),
			'header-layout-7' => array(
				'url' => $url . 'h7.png',
				'label' => _x( 'Layout 7', 'Header Layout name', 'social-portal' ),
			),
			
			'header-layout-8' => array(
				'url' => $url . 'h8.png',
				'label' => _x( 'Layout 8', 'Header Layout name', 'social-portal' ),
			),
			'header-layout-9' => array(
				'url' => $url . 'h9.png',
				'label' => _x( 'Layout 9', 'Header Layout name', 'social-portal' ),
			),
			'header-layout-10' => array(
				'url' => $url . 'h10.png',
				'label' => _x( 'Layout 10', 'Header Layout name', 'social-portal' ),
			),

		
		);

		$args['layouts'] = $layouts;
		// Let the parent class handle the rest.
		parent::__construct( $manager, $id, $args );
	}
}
