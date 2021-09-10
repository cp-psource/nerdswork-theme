<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

/**
 * Group extension to display an info page for the group
 *
 */
class CB_Group_Info_Extension extends BP_Group_Extension {

	public function __construct() {

		$args = array(
			'slug'              => 'info',
			'name'              => __( 'Über', 'social-portal' ),
			'nav_item_position' => 11,
			'screens'           => array(
				'create' => array(
					'enabled' => false
				),
				'edit'   => array(
					'enabled' => false
				),
				'admin'  => array(
					'enabled' => false,
				),
			)
		);

		parent::init( $args );
	}

	/**
	 *
	 * @param null $group_id
	 */
	public function display( $group_id = null ) {
		bp_get_template_part( 'groups/single/about' );
	}
}

bp_register_group_extension( 'CB_Group_Info_Extension' );
