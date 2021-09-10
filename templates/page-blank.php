<?php

/**
 * Template Name: Blank Page
 * 
 * Use this template for building layouts with various layout builder
 */
?>
<?php get_header( 'page-blank' ); ?>

<div id="container" class="<?php echo cb_get_page_layout_class( 'empty-canvas page-blank no-padding-blank' ); ?>"><!-- main container -->

	<?php
	/**
	 * The hook 'cb_before_container_contents' is used to add anything below the site header
	 *  @see cb-page-builder.php for the details
	 */
	?>

	<?php do_action( 'cb_before_container_contents' ); ?>

	<div class="inner clearfix">
		
		<section id="content">
		
			<?php do_action( 'cb_before_page_contents' ); ?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/entry', get_post_type() ); ?>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/entry-404' ); ?>

			<?php endif; ?>
			
		</section><!-- #content -->

        <?php do_action( 'cb_after_page_contents' ); ?>

		<?php get_sidebar( 'empty-page' ); ?>
		
	</div><!-- .inner -->

	<?php do_action( 'cb_after_container_contents' ); ?>

</div> <!-- #container -->

<?php get_footer( 'page-blank' ); ?>