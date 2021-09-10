<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

//disable css
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/***
 * For Woocommerce compatibility
 */
//Theme compatibility
if ( has_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' ) ) {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );

	add_action( 'woocommerce_before_main_content', 'cb_wc_theme_wrapper_start', 10 );
}

if ( has_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' ) ) {
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

	add_action( 'woocommerce_after_main_content', 'cb_wc_theme_wrapper_end', 10 );
}

/**
 * Before wc content
 */
function cb_wc_theme_wrapper_start() { ?>
	<div id="container" class="<?php echo cb_get_page_layout_class(); ?>"><!-- main container -->
		<div class="clearfix inner">
			<section id="content">
	<?php
}

/**
 * Close wc content
 */
function cb_wc_theme_wrapper_end() { ?>

			</section><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- .inner -->
	</div> <!-- #container -->
	<?php
}

/**
 * Remove automatic display of breadcrumb
 */
if ( has_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb' ) ) {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

//We should not define functions here,
// Let us move to functions file in next update

