<?php
/**
 * Woothemes sensei plugin compatibility/enhancements
 */

global $woothemes_sensei;
remove_action( 'sensei_before_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper' ), 10 );
remove_action( 'sensei_after_main_content', array( $woothemes_sensei->frontend, 'sensei_output_content_wrapper_end' ), 10 );

add_action( 'sensei_before_main_content', 'cb_sensei_wrapper_start', 10);
add_action( 'sensei_after_main_content', 'cb_sensei_wrapper_end', 10);

function cb_sensei_wrapper_start() { ?>
<div id="container" class="<?php echo cb_get_page_layout_class(); ?>"><!-- main container -->
		<div class="clearfix inner">
			<section id="content">
	<?php
}

function cb_sensei_wrapper_end() {?>

	</section><!-- #content -->
	<?php get_sidebar(); ?>
	</div><!-- .inner -->
	</div> <!-- #container -->
	<?php
}
