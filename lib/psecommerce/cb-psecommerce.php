<?php
//Do not allow direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}

//disable css
add_filter( 'psecommerce_enqueue_styles', '__return_empty_array' );

/***
 * For PSeCommerce compatibility
 */
//Theme compatibility
if ( has_action( 'psecommerce_before_main_content', 'psecommerce_output_content_wrapper' ) ) {
	remove_action( 'psecommerce_before_main_content', 'psecommerce_output_content_wrapper', 10 );

	add_action( 'psecommerce_before_main_content', 'cb_psecommerce_theme_wrapper_start', 10 );
}

if ( has_action( 'psecommerce_after_main_content', 'psecommerce_output_content_wrapper_end' ) ) {
	remove_action( 'psecommerce_after_main_content', 'psecommerce_output_content_wrapper_end', 10 );

	add_action( 'psecommerce_after_main_content', 'cb_psecommerce_theme_wrapper_end', 10 );
}

/**
 * Before psecommerce content
 */
function cb_psecommerce_theme_wrapper_start() { ?>
	<div id="container" class="<?php echo cb_get_page_layout_class(); ?>"><!-- main container -->
		<div class="clearfix inner">
			<section id="content">
	<?php
}

/**
 * Close psecommerce content
 */
function cb_psecommerce_theme_wrapper_end() { ?>

			</section><!-- #content -->
			<?php get_sidebar(); ?>
		</div><!-- .inner -->
	</div> <!-- #container -->
	<?php
}


//We should not define functions here,
// Let us move to functions file in next update
