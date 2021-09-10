<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class CB_Customize_Control_Box_Layout extends CB_Customize_Control_Layout {
	
	public function __construct( $manager, $id, $args = array() ) {


		$url = combuilder()->get_url() .'/lib/framework/customizer/assets/images/layouts/';

		$layouts = array(
			'boxed' => array(
				'url'	=> $url . 'boxed.png',
				'label'	=> __( 'Standard-Box-Layout', 'social-portal' )
			),
			'fluid' => array(
				'url'	=> $url . 'fluid.png',
				'label'	=> __( 'Fließendes Layout', 'social-portal' )
			),

		);
	
	
		$args['layouts'] = $layouts;
		// Let the parent class handle the rest.
		parent::__construct( $manager, $id, $args );
	}
}
