<?php
/**
 * Single Page template file
 *
 * @package social-portal
 * @author WMS N@W
 */
?>
<?php get_header( 'page' ); ?>

<div id="container" class="<?php echo cb_get_page_layout_class(); ?>"><!-- section container -->

	<?php
	/**
	 * The hook 'cb_before_container_contents' is used to add anything below the site header
	 *  @see cb-page-builder.php for the details
	 */
	?>

	<?php do_action( 'cb_before_container_contents' ); ?>

	<div class="inner clearfix">
		
		<section id="content" class="content-single">

			<?php do_action( 'cb_before_page_contents' ); ?>

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/entry-page' ); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; ?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/entry-404' ); ?>

			<?php endif; ?>

			<?php do_action( 'cb_after_page_contents' ); ?>

		</section><!-- #content -->

		<?php get_sidebar( 'page' ); ?>
		
	</div><!-- .inner -->

	<?php do_action( 'cb_after_container_contents' ); ?>

</div> <!-- #container -->

<?php get_footer( 'page' ); ?>