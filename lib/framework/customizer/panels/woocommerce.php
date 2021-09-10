<?php
/**
 * @package social-portal
 * Customizer Blog Panel
 *
 */

//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

class CB_WC_Panel_Helper {

	private $panel =  'cb_wc';

	public function __construct() {
		add_filter( 'cb_customizer_sections', array( $this, 'add_sections' ) );
	}

	public function add_sections( $sections ) {

		$new_sections = $this->get_sections();
		return array_merge( $sections, $new_sections );
	}


	public function get_sections() {

		$sections = array();
		$panel = $this->panel;

		$sections['wc-all-page'] = array(
			'panel'       => $panel,
			'title'       => __( 'Global', 'social-portal' ),
			'description' => __( 'Instructions for customizing individual shop page.', 'social-portal' ),
			'options'     => array(

				'wc-page-customize-info' => array(
					'control' => array(
						'control_type' => 'CB_Customize_Misc_Control',
						'label'        => __( 'Layout Customization', 'social-portal' ),
						'description'   => __( 'For customizing Shop, Cart, Checkout etc pages individually, Please visit Dashboard->Pages. Edit the page and change their layout.', 'social-portal' ),
						'type'         => 'group-title',
					),
				),

				// Fallback layout for all woocommerce page
				'wc-page-layout'				=> array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage'
						'default'			=> cb_get_default( 'wc-page-layout' )
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Control_Page_Layout',
						'label'			=> __( 'Default Shop Layout', 'social-portal' ),
						'description'	=> __( 'It will be used as default layout for all the shop pages.', 'social-portal' ),
					),
				),

				'wc-show-header'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'wc-show-header' ),
					),
					'control' => array(
						'type'	=> 'checkbox',
						'input_attrs' => array(
						),
						'label'			=> __( 'Show Page Header?', 'social-portal' ),
						'description'	=> __( 'Do you want to hide the large page header on shop pages?.', 'social-portal' ),
					),
				),

				'wc-show-title'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'wc-show-title' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Show title in the content area too?' , 'social-portal'),
						'description'	=> '',
					),
				),

			),//end of options
		);//end of page section
		$sections['wc-product-page'] = array(
			'panel'       => $panel,
			'title'       => __( 'Product Page', 'social-portal' ),
			'description' => __( 'Single product page display settings.', 'social-portal' ),
			'options'     => array(

				'product-page-layout'				=> array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage'
						'default'			=> cb_get_default( 'product-page-layout' )
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Control_Page_Layout',
						'label'			=> __( 'Page Layout', 'social-portal' ),
						'description'	=> __( 'Choose layout for single product page.', 'social-portal' ),
					),
				),

				'product-show-header'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'product-show-header' ),
					),
					'control' => array(
						'type'	=> 'checkbox',
						'input_attrs' => array(
						),
						'label'			=> __( 'Show Page Header?', 'social-portal' ),
						'description'	=> __( 'Do you want to hide the large page header?.', 'social-portal' ),
					),
				),

				'product-show-title'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'product-show-title' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Show title alongside the product too?' , 'social-portal'),
						'description'	=> __( 'Show the title with the product.', 'social-portal' ),
					),
				),


			),//end of options
		);//end of page section

		$sections['wc-product-category-page'] = array(
			'panel'       => $panel,
			'title'       => __( 'Product Category Page', 'social-portal' ),
			'description' => __( 'Product category display settings.', 'social-portal' ),
			'options'     => array(

				'product-category-page-layout'				=> array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_setting_choice',
						//'transport'         => 'postMessage'
						'default'			=> cb_get_default( 'product-category-page-layout' )
					),
					'control' => array(
						'control_type'	=> 'CB_Customize_Control_Page_Layout',
						'label'			=> __( 'Layout', 'social-portal' ),
						'description'	=> __( 'Choose layout for product category page.', 'social-portal' ),
					),
				),

				'product-category-show-header'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'product-category-show-header' ),
					),
					'control' => array(
						'type'	=> 'checkbox',
						'input_attrs' => array(
						),
						'label'			=> __( 'Show Page Header?', 'social-portal' ),
						'description'	=> __( 'Do you want to hide the large page header on categories?.', 'social-portal' ),
					),
				),

				'product-category-show-title'  => array(
					'setting' => array(
						'sanitize_callback' => 'cb_sanitize_int',
						'transport'			=> 'refresh',
						'default'			=> cb_get_default( 'product-category-show-title' ),
					),
					'control' => array(
						'type'	        => 'checkbox',
						'input_attrs'   => array(
						),
						'label'			=> __( 'Show title in the content area too?' , 'social-portal'),
						'description'	=> '',
					),
				),
			),//end of options
		);//end of page section

		return apply_filters( 'cb_customizer_wc_sections', $sections );
	}

}//end of class

new CB_WC_Panel_Helper();
