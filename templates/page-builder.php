<?php

/**
 * Template Name: Layout Builder Page
 * 
 * Use this template for building layouts with various layout builder
 */
?>
<?php get_header( 'builder' ); ?>

<div id="container" class="<?php echo cb_get_page_layout_class( 'empty-canvas no-padding-blank' ); ?>"><!-- main container -->
	<?php
	/**
	 * The hook 'cb_before_container_contents' is used to add anything below the site header
	 *  @see cb-page-builder.php for the details
	 */
	?>

	<?php do_action( 'cb_before_container_contents' ); ?>

	<div class="clearfix layout-builder-page-contents">
		
		<section id="content">
		
			<?php do_action( 'cb_before_page_contents' ); ?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/entry', 'layout-builder' ); ?>

                    <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                            echo "<div class='clearfix pagebuilder-comments'>";
                                comments_template();
                            echo "</div>";
                        endif;
                    ?>
				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/entry-404' ); ?>

			<?php endif; ?>

            <?php do_action( 'cb_after_page_contents' ); ?>

		</section><!-- #content -->

		<?php get_sidebar( 'builder' ); ?>
		
	</div><!-- .inner -->

	<?php do_action( 'cb_after_container_contents' ); ?>

</div> <!-- #container -->

<?php get_footer( 'builder' ); ?>