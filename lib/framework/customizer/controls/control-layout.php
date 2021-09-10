<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit(0);
}
/**
 * Original Work of Justin Tadlock for Hybrid theme
 * Modified for SocialPortal( Mostly renamed classes )
 * 
 */
/**
 * Customize control class to handle theme layouts.  This class extends the framework's
 * `Hybrid_Customize_Control_Radio_Image` class.  Only layouts that have an image will
 * be shown.
 *
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2008 - 2015, Justin Tadlock
 * @link       http://themehybrid.com/hybrid-core
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Theme Layout customize control class.
 *
 * @since  1.0.0
 * @access public
 */
class CB_Customize_Control_Layout extends CB_Customize_Control_Radio_Image {

	/**
	 * The default customizer section this control is attached to.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	//public $section = 'layout';

	/**
	 * Set up our control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @param  string  $id
	 * @param  array   $args
	 * @return void
	 */
	public function __construct( $manager, $id, $args = array() ) {

		if( ! empty( $args['layouts'] ) ) {
			
			$layouts = $args['layouts'];
			unset( $args['layouts'] );
			
		} else {
			
			$layouts = cb_get_layouts();
		}
		// Array of allowed layouts. Pass via `$args['layouts']`.
		//$allowed = ! empty( $args['layouts'] ) ? $args['layouts'] : array_keys( cb_get_layouts() );

		// Loop through each of the layouts and add it to the choices array with proper key/value pairs.
		foreach ( $layouts as $layout_id => $layout ) {

			$args['choices'][ $layout_id ] = array(
				'label' => $layout['label'],
				'url'   => $layout['url']	
			);
			
		}
		

		// Let the parent class handle the rest.
		parent::__construct( $manager, $id, $args );
	}
}
