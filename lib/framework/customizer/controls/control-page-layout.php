<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit(0);
}

class CB_Customize_Control_Page_Layout extends CB_Customize_Control_Layout{
	
	public function __construct( $manager, $id, $args = array() ) {

		$layouts = cb_get_page_layouts();
		$args['layouts'] = $layouts;
		// Let the parent class handle the rest.
		parent::__construct( $manager, $id, $args );
	}
}
