
	<?php do_action( 'bp_after_container' ); ?>
	<?php do_action( 'bp_before_footer' ); ?>

	<section id="footer" class="clearfix">

		<?php
			//Is footer enabled and Are any of the sidebar widgetized area active?
			if ( cb_has_footer_enabled() && cb_has_footer_widget_area_enabled() ) :

			?>
				<h1 class="accessibly-hidden"><?php _e( 'Footer Navigation', 'social-portal' ); ?></h1>

				<div class="footer-inner-top" id="footer-widget-area">

					<div class="clearfix inner widget-area <?php echo cb_get_footer_widget_wrapper_class(); ?>">

						<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
							<div class="footer-widgets">
								<?php dynamic_sidebar( 'footer-1' ); ?>
							</div><!-- /.footer-widgets -->
						<?php endif; ?>

						<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
							<div class="footer-widgets">
								<?php dynamic_sidebar( 'footer-2' ); ?>
							</div><!-- /.footer-widgets -->
						<?php endif; ?>

						<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
							<div class="footer-widgets">
								<?php dynamic_sidebar( 'footer-3' ); ?>
							</div><!-- /.footer-widgets -->
						<?php endif; ?>

						<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
							<div class="footer-widgets">
								<?php dynamic_sidebar( 'footer-4' ); ?>
							</div><!-- /.footer-widgets -->
						<?php endif; ?>

					</div><!-- /.inner -->

				</div><!-- /.footer-inner-top -->

		<?php endif; ?>

		<?php if ( cb_has_footer_copyright_enabled() ) : ?>
			<!-- copyright -->
			<footer id="site-copyright" class="site-copyright">

				<div class="clearfix inner">

					<?php do_action( 'cb_before_theme_credits' ); ?>

					<?php $footer_text = cb_get_footer_copyright(); ?>

					<?php if ( $footer_text ): ?>
						<p><?php echo $footer_text; ?></p>
					<?php else: ?>
						<p><?php printf( __( 'Stolz angetrieben von <a href="%1$s">PSOURCE</a> & <a href="%2s" title ="PS SocialPortal, das am besten ansprechende WordPress, BuddyPress Theme "> Community +</a>.', 'social-portal' ), 'https://n3rds.work', 'https://n3rds.work/piestingtal-source-project/ps-socialportal/' ); ?></p>
					<?php endif; ?>

					<?php do_action( 'cb_after_theme_credits' ); ?>

				</div><!-- end of /.inner -->

			</footer> <!-- /.site-copyright -->
		<?php endif; //end of copyright section ?>

	</section><!-- #footer -->

	<?php do_action( 'cb_after_footer' ); ?>

	</div><!-- #page -->

	<!-- offcanvas menu panels -->

	<?php if ( cb_has_panel_left_enabled() ) : ?>
		<?php get_template_part( 'template-parts/panel-left' ); ?>
	<?php endif; ?>

	<?php if ( cb_has_panel_right_enabled() ): ?>
		<?php get_template_part( 'template-parts/panel-right' ); ?>
	<?php endif; ?>

	<!-- end of offcanvas menu panels -->

	<?php wp_footer(); ?>
	
	<?php 
	
		$custom_js = cb_get_option( 'custom-footer-js' );
		if ( ! empty( $custom_js ) ) {
			echo $custom_js;
		}
	?>
</body>

</html>