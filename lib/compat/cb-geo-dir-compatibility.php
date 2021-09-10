<?php
//Geo Directory plugin compatibility
class CB_Geodir_Compat {

	public function setup() {

		//container
		//open
		remove_action( 'geodir_wrapper_open', 'geodir_action_wrapper_open', 10 );
		add_action( 'geodir_wrapper_open', array( $this, 'container_wrapper_open' ), 9 );
		//container close
		remove_action( 'geodir_wrapper_close', 'geodir_action_wrapper_close', 10 );
		add_action( 'geodir_wrapper_close', array( $this, 'container_wrapper_close' ), 11 );

		//Contents(excluding sidebar)
		remove_action( 'geodir_wrapper_content_open', 'geodir_action_wrapper_content_open', 10 );
		add_action( 'geodir_wrapper_content_open', array( $this, 'content_wrapper_open' ), 9, 3 );

		// close contents
		remove_action( 'geodir_wrapper_content_close', 'geodir_action_wrapper_content_close', 10 );
		add_action( 'geodir_wrapper_content_close', array( $this, 'content_wrapper_close' ), 11 );

		//Sidebar open
		remove_action( 'geodir_sidebar_right_open', 'geodir_action_sidebar_right_open', 10 );
		add_action( 'geodir_sidebar_right_open', array( $this, 'sidebar_wrapper_open' ), 10, 4 );
		//sidebar close
		remove_action( 'geodir_sidebar_right_close', 'geodir_action_sidebar_right_close', 10 );
		add_action( 'geodir_sidebar_right_close', array( $this, 'sidebar_wrapper_close' ), 10, 1 );

	}

	/**
	 * Before Container
	 */
	public function container_wrapper_open() { ?>
		<div id="container" class="<?php echo cb_get_page_layout_class(); ?>"><!-- main container -->
		<div class="clearfix inner">
		<?php
	}

	/**
	 * Close geodir contents
	 */
	public function container_wrapper_close() { ?>

		<?php //get_sidebar(); ?>
		</div><!-- .inner -->
		</div> <!-- #container -->
		<?php
	}

	public function content_wrapper_open() { ?>
		<div class="clearfix geodir-content-wrapper">
		<section id="content">

		<?php
	}

	/**
	 * Content column wrapper end
	 */
	public function content_wrapper_close() { ?>
		</section>
		<?php
	}

	public function sidebar_wrapper_open() {
		if ( ! cb_has_sidebar_enabled() ) {
			//return ;
		}

	?>
		<aside id="sidebar">
		<div class="padder">
		<?php
	}

	public function sidebar_wrapper_close() {
		//if (  cb_has_sidebar_enabled() ) :?>
			</div>
			</aside>
		<?php //endif;?>
		</div><!-- close the geodir-contents wraper -->
		<?php
	}
}
//Init
$cb_geodir_compat = new CB_Geodir_Compat();
$cb_geodir_compat->setup();
