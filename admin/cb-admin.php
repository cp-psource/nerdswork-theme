<?php

class CB_Admin_Helper {
	
	private $url;
	
	public function __construct() {
		
		$this->url = combuilder()->get_url();
		
		//load asap
		$this->load();
		$this->setup();
	}
	
	//load required files
	public function load() {
		
		$dir = combuilder()->get_path() . '/admin/';
		
		$files = array(
			'cb-admin-functions.php',
			'lib/cb-admin-layout-metabox.php',
			'lib/cb-admin-header-image-metabox.php',
		);
		
		foreach ( $files as $file ) {
			require_once $dir . $file;
		}
	}
	
	public function setup() {
		//hier aktiviere ich
		add_action( 'admin_enqueue_scripts', array( $this, 'load_js' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_css' ) );
		//hier deaktiviere ich
		add_action( 'admin_notices', array( $this, 'activation_notice' ) );	
		
	}
	
	public function load_js( $hook ) {
		
		$url = $this->url;
		//ich schau mir das mal an, vlt. hat es mit dem Footer-Problem zu tun
		wp_register_script( 'cb-widgets-admin', $url . '/admin/assets/js/admin-widgets.js', false, cb_get_version(), true );///load in footer
		//ansonst obere Zeile ausdokumentieren
		if ( $this->load_admin_assets( $hook ) ) {
			wp_enqueue_script( 'cb-widgets-admin' );
		}
	}

	/**
	 * @param $hook
	 * @todo revisit for font awesome loading
	 */
	public function load_css( $hook ) {
		
		$url = $this->url;
		
		wp_register_style( 'font-awesome', $url .'/assets/vendors/font-awesome/css/font-awesome.css' );
		
		if ( $this->load_admin_assets( $hook ) ) {
			
			wp_enqueue_style('font-awesome');
			wp_enqueue_style( 'cb-widgets-admin', $url . '/admin/assets/css/admin-widgets.css' );
		
		}
		
	}

	/**
	 * @param $hook
	 *
	 * @return bool
	 */
	public function load_admin_assets( $hook ) {
		
		$widgetload = ( ( 'post.php' == $hook || 'post-new.php' == $hook ) && ( defined( 'SITEORIGIN_PANELS_VERSION' ) && version_compare( SITEORIGIN_PANELS_VERSION, '2.0' ) >= 0 ) ) ? true : false;

		if ( 'widgets.php' == $hook || $widgetload ) {
			return true;
		}
		
		return false;
		
	}

	public function activation_notice() {
		
		global $pagenow;

		// Bail if community builder theme was not just activated
		if ( empty( $_GET['activated'] ) || ( 'themes.php' != $pagenow ) || ! is_admin() ) {
			return;
		}

		?>

		<div id="message" class="updated fade">
			<p><?php printf( __( 'Theme aktiviert! Mit PS SocialPortal kannst Du <a href="%s">jeden Aspekt</a> mithilfe des Design-Customizers anpassen.', 'social-portal' ), admin_url( 'customize.php' ) ); ?></p>
		</div>

		<style type="text/css">#message2, #message0 { display: none; }</style>

		<?php
	}

}

new CB_Admin_Helper();